<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cuaca: MET Norway (tanpa key) → fallback Open-Meteo
 * GET /api/weather?lat=-6.2&lon=106.8&units=metric&daily=1
 *
 * Output:
 * {
 *   ok, source, query,
 *   data: {
 *     location:{latitude,longitude,timezone},
 *     current:{temperature_2m,apparent_temperature,relative_humidity_2m,wind_speed_10m,wind_direction_10m,weather_code,is_day,precipitation},
 *     daily:{sunrise[],sunset[],...}
 *   }
 * }
 *
 * @property CI_Cache|CI_Cache_file $cache
 * @property CI_Input $input
 */
class Api_weather extends CI_Controller
{
    private $metnoBase   = 'https://api.met.no/weatherapi/locationforecast/2.0/compact';
    private $openmeteo   = 'https://api.open-meteo.com/v1/forecast';
    private $TTL_CURRENT = 300; // 5 menit

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        api_set_headers();
        api_preflight();

        $this->load->driver('cache', ['adapter' => 'file']);
    }

    private function curlJson($url, $timeout = 12)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 6,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            // MET Norway MENGHARUSKAN User-Agent yang jelas
            CURLOPT_USERAGENT      => 'KelurahanDashboard/1.0 (admin@yourdomain.tld)',
        ]);
        $body = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false) return ['ok' => false, 'error' => $err ?: 'curl'];
        $json = json_decode($body, true);
        return ['ok' => $code >= 200 && $code < 300, 'code' => $code, 'json' => $json, 'raw' => $body];
    }

    private function mapMetSymbolToWmo($symbol)
    {
        if (!$symbol) return null;
        $s = strtolower($symbol);
        if (strpos($s, 'clearsky') !== false)       return 0;
        if (strpos($s, 'fair') !== false)           return 1;
        if (strpos($s, 'partlycloudy') !== false)   return 2;
        if ($s === 'cloudy')                       return 3;
        if (strpos($s, 'fog') !== false)            return 45;

        if ($s === 'lightrain' || $s === 'rainshowers_light') return 61;
        if ($s === 'rain' || $s === 'rainshowers')             return 63;
        if ($s === 'heavyrain' || $s === 'rainshowers_heavy')  return 65;

        if (strpos($s, 'sleet') !== false)                      return 66;

        if ($s === 'lightsnow' || $s === 'snowshowers_light')  return 71;
        if ($s === 'snow' || $s === 'snowshowers')             return 73;
        if ($s === 'heavysnow' || $s === 'snowshowers_heavy')  return 75;

        if ($s === 'heavyrainshowers')                         return 82;

        if (strpos($s, 'thunder') !== false) return (strpos($s, 'hail') !== false) ? 99 : 95;

        return null;
    }

    private function sunTimesToday($lat, $lon, $tz = 'Asia/Jakarta')
    {
        $ts = time();
        $info = date_sun_info($ts, $lat, $lon);
        if (!$info) return [null, null];

        $sr = !empty($info['sunrise']) ? (new DateTime('@' . $info['sunrise'])) : null;
        $ss = !empty($info['sunset'])  ? (new DateTime('@' . $info['sunset']))  : null;
        try {
            if ($sr) $sr->setTimezone(new DateTimeZone($tz));
            if ($ss) $ss->setTimezone(new DateTimeZone($tz));
        } catch (Exception $e) {
        }
        return [$sr ? $sr->format('c') : null, $ss ? $ss->format('c') : null];
    }

    public function index()
    {
        $lat   = (float) $this->input->get('lat');
        $lon   = (float) $this->input->get('lon');
        $units = strtolower($this->input->get('units') ?: 'metric'); // metric|imperial
        $wantDaily = $this->input->get('daily') !== null;

        if (!$lat && !$lon) return api_fail('Parameter lat & lon wajib.', 422);

        $tempUnit = ($units === 'imperial') ? 'fahrenheit' : 'celsius';
        $cacheKey = sprintf('wx_mn_%s_%s_%s_%s', $lat, $lon, $tempUnit, $wantDaily ? 'D' : 'C');
        if ($cached = $this->cache->file->get($cacheKey)) return api_respond($cached);

        // ====== 1) MET Norway ======
        $metUrl = $this->metnoBase . '?lat=' . rawurlencode($lat) . '&lon=' . rawurlencode($lon);
        $met = $this->curlJson($metUrl);
        $sourceTried = ['met.no'];

        $current = null;
        $daily = null;
        $tzName = null;

        if ($met['ok'] && !empty($met['json']['properties']['timeseries'][0]['data'])) {
            $d    = $met['json']['properties']['timeseries'][0]['data'];
            $inst = $d['instant']['details'] ?? [];
            $symb = $d['next_1_hours']['summary']['symbol_code'] ?? ($d['next_6_hours']['summary']['symbol_code'] ?? null);

            $wind_ms = isset($inst['wind_speed']) ? (float)$inst['wind_speed'] : null; // m/s
            $wind_kmh = $wind_ms !== null ? $wind_ms * 3.6 : null;

            $current = [
                'temperature_2m'        => $inst['air_temperature'] ?? null,
                'apparent_temperature'  => $inst['air_temperature'] ?? null, // MET tidak beda feels-like
                'relative_humidity_2m'  => $inst['relative_humidity'] ?? null,
                'wind_speed_10m'        => $wind_kmh,
                'wind_direction_10m'    => $inst['wind_from_direction'] ?? null,
                'weather_code'          => $this->mapMetSymbolToWmo($symb),
                'is_day'                => null,
                'precipitation'         => $inst['precipitation_rate'] ?? null,
            ];

            if ($wantDaily) {
                list($sr, $ss) = $this->sunTimesToday($lat, $lon, 'Asia/Jakarta');
                $daily = [
                    'sunrise'            => $sr ? [$sr] : null,
                    'sunset'             => $ss ? [$ss] : null,
                    'temperature_2m_max' => null,
                    'temperature_2m_min' => null,
                    'precipitation_sum'  => null,
                ];
            }
        } else {
            // ====== 2) Fallback: Open-Meteo ======
            $sourceTried[] = 'open-meteo';
            $om = $this->curlJson(
                $this->openmeteo .
                    '?latitude=' . rawurlencode($lat) .
                    '&longitude=' . rawurlencode($lon) .
                    '&timezone=auto' .
                    '&temperature_unit=' . ($tempUnit === 'fahrenheit' ? 'fahrenheit' : 'celsius') .
                    '&windspeed_unit=kmh' .
                    '&current=temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,weather_code,wind_speed_10m,wind_direction_10m' .
                    ($wantDaily ? '&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,sunrise,sunset' : '')
            );
            if (!$om['ok']) return api_fail('Gagal mengambil cuaca.', 502);
            $j = $om['json'] ?: [];
            $tzName  = $j['timezone'] ?? null;
            $current = $j['current'] ?? null;
            $daily   = $j['daily']   ?? null;
        }

        if (!$current) return api_fail('Data cuaca tidak tersedia.', 502);

        $out = [
            'ok'     => true,
            'source' => implode(' → ', $sourceTried),
            'query'  => ['lat' => $lat, 'lon' => $lon, 'units' => $units, 'daily' => (bool)$wantDaily],
            'data'   => [
                'location' => ['latitude' => $lat, 'longitude' => $lon, 'timezone' => $tzName],
                'current'  => $current,
                'daily'    => $daily,
            ],
        ];

        $this->cache->file->save($cacheKey, $out, $this->TTL_CURRENT);
        return api_respond($out);
    }
}
