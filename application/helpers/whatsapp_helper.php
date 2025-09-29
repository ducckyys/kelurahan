<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// if (!function_exists('kirim_whatsapp')) {

//     /**
//      * Mengirim pesan WhatsApp menggunakan API Mekari Qontak
//      *
//      * @param string $nomor_tujuan Nomor tujuan dengan format 62xxxx
//      * @param string $nama_tujuan Nama penerima pesan
//      * @param string $pesan Teks pesan yang akan dikirim
//      * @return bool|string Response dari server API atau FALSE jika gagal
//      */
//     function kirim_whatsapp($nomor_tujuan, $nama_tujuan, $pesan)
//     {
//         // Ganti dengan Access Token Anda dari Mekari Qontak
//         $accessToken = '---';

//         // Ganti dengan Channel Integration ID Anda
//         $channelId = '---';

//         // Pastikan nomor diawali dengan 62
//         if (substr($nomor_tujuan, 0, 1) == '0') {
//             $nomor_tujuan = '62' . substr($nomor_tujuan, 1);
//         }

//         // Siapkan data sesuai format yang diminta Mekari Qontak
//         $payload = json_encode([
//             "to_number" => $nomor_tujuan,
//             "to_name" => $nama_tujuan,
//             "message_type" => "text",
//             "channel_integration_id" => $channelId,
//             "text" => [
//                 "body" => $pesan
//             ]
//         ]);

//         $curl = curl_init();

//         curl_setopt_array($curl, array(
//             CURLOPT_URL => 'https://chat-api.qontak.com/api/v1/broadcasts/whatsapp/direct',
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_POSTFIELDS => $payload,
//             CURLOPT_HTTPHEADER => array(
//                 'Authorization: Bearer ' . $accessToken,
//                 'Content-Type: application/json'
//             ),
//         ));

//         $response = curl_exec($curl);
//         curl_close($curl);
//         return $response;
//     }
// }
