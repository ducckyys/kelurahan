<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Waktu/Tanggal: TimeAPI.io → fallback WorldTimeAPI
 *
 * @property CI_Cache|CI_Cache_file $cache
 * @property CI_Input $input
 */
class Api_time extends CI_Controller
{
    private $timeapi = 'https://timeapi.io/api';
    private $wtaBase = 'https://worldtimeapi.org/api/timezone';
    private $TTL_TIME = 60;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        api_set_headers();
        api_preflight();

        $this->load->driver('cache', ['adapter' => 'file']);
    }

    // GET /api/time/now?timezone=Asia/Jakarta
    public function now()
    {
        $tz = $this->input->get('timezone') ?: 'Asia/Jakarta';
        $cacheKey = 'time_' . str_replace('/', '_', $tz);
        if ($cached = $this->cache->file->get($cacheKey)) return api_respond($cached);

        $t1 = $this->curlGet($this->timeapi . '/Time/current/zone?timeZone=' . rawurlencode($tz));
        if ($t1['ok'] && !empty($t1['json']['dateTime'])) {
            $j = $t1['json'];
            $out = [
                'ok'          => true,
                'source'      => 'timeapi.io',
                'timezone'    => $j['timeZone'] ?? $tz,
                'datetime'    => $j['dateTime'],
                'date'        => substr($j['dateTime'], 0, 10),
                'time'        => substr($j['dateTime'], 11, 8),
                'utc_offset'  => $j['utcOffset'] ?? null,
                'day_of_week' => $j['dayOfWeek'] ?? null,
                'week_number' => $j['weekOfYear'] ?? null,
                'unixtime'    => isset($j['unixTimeSeconds']) ? (int)$j['unixTimeSeconds'] : null,
            ];
            $this->cache->file->save($cacheKey, $out, $this->TTL_TIME);
            return api_respond($out);
        }

        $t2 = $this->curlGet($this->wtaBase . '/' . rawurlencode($tz));
        if (!$t2['ok']) return api_fail('Gagal ambil waktu.', 502);
        $j = $t2['json'] ?: [];
        $out = [
            'ok'         => true,
            'source'     => 'worldtimeapi',
            'timezone'   => $j['timezone'] ?? $tz,
            'datetime'   => $j['datetime'] ?? null,
            'date'       => isset($j['datetime']) ? substr($j['datetime'], 0, 10) : null,
            'time'       => isset($j['datetime']) ? substr($j['datetime'], 11, 8) : null,
            'utc_offset' => $j['utc_offset'] ?? null,
            'day_of_week' => $j['day_of_week'] ?? null,
            'day_of_year' => $j['day_of_year'] ?? null,
            'week_number' => $j['week_number'] ?? null,
            'unixtime'   => $j['unixtime'] ?? null,
        ];
        $this->cache->file->save($cacheKey, $out, $this->TTL_TIME);
        return api_respond($out);
    }

    private function curlGet($url, $timeout = 12)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 6,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_USERAGENT      => 'KelurahanDashboard/1.0',
        ]);
        $body = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($body === false) return ['ok' => false, 'error' => $err ?: 'curl'];
        return ['ok' => $code >= 200 && $code < 300, 'code' => $code, 'json' => json_decode($body, true), 'raw' => $body];
    }
}
