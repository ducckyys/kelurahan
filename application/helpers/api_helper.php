<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('api_set_headers')) {
    function api_set_headers()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
    }
}
if (!function_exists('api_preflight')) {
    function api_preflight()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
if (!function_exists('api_respond')) {
    function api_respond($arr, $code = 200)
    {
        http_response_code($code);
        echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return;
    }
}
if (!function_exists('api_fail')) {
    function api_fail($message, $code = 400)
    {
        return api_respond(['ok' => false, 'error' => $message], $code);
    }
}
