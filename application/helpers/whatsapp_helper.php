<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('kirim_whatsapp')) {

    function kirim_whatsapp($nomor_tujuan, $pesan)
    {
        // Ganti dengan API Key Anda dari Fonnte
        $apiKey = 'MnCgngGQHywjar8raEKKD4Eywpt';

        // Pastikan nomor diawali dengan 62
        if (substr($nomor_tujuan, 0, 1) == '0') {
            $nomor_tujuan = '62' . substr($nomor_tujuan, 1);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $nomor_tujuan,
                'message' => $pesan,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $apiKey
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response; // Mengembalikan response dari Fonnte
    }
}
