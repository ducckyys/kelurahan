<?php defined('BASEPATH') or exit('No direct script access allowed');

class HttpClient
{
    public function get($url, $query = [], $headers = [], $timeout = 15)
    {
        if (!empty($query)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($query);
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 6,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => $headers,
            // default UA sopan
            CURLOPT_USERAGENT      => 'KelurahanDashboard/1.0 (+contact: admin@yourdomain.tld)',
        ]);
        $body = curl_exec($ch);
        $err  = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false) {
            return ['ok' => false, 'error' => $err ?: 'curl error', 'code' => 0];
        }
        $json = json_decode($body, true);
        return [
            'ok'   => ($code >= 200 && $code < 300),
            'code' => $code,
            'json' => $json,
            'raw'  => $body,
            'error' => ($code >= 200 && $code < 300) ? null : ('HTTP ' . $code)
        ];
    }
}
