<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('safe_rte')) {
    /**
     * Tampilkan HTML dari RTE secara aman:
     * - Decode entitas (&lt;p&gt; -> <p>)
     * - Hapus event handler & javascript: url
     * - Whitelist tag yang diizinkan
     */
    function safe_rte($html, $mode = 'summary')
    {
        if ($html === null) return '';
        $decoded = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

        if ($mode === 'summary') {
            $allowed = '<p><br><br/><strong><b><em><i><u>'
                . '<ul><ol><li><blockquote>'
                . '<h1><h2><h3><h4><h5><h6>'
                . '<a><span><div>';
        } else { // detail
            $allowed = '<p><br><br/><strong><b><em><i><u>'
                . '<ul><ol><li><blockquote>'
                . '<h1><h2><h3><h4><h5><h6>'
                . '<a><span><div><img>'
                . '<table><thead><tbody><tfoot><tr><th><td>';
        }

        $clean = strip_tags($decoded, $allowed);
        // bersihin attribute berbahaya sederhana
        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);             // onerror=, onclick=, dll
        $clean = preg_replace('/\shref="javascript:[^"]*"/i', ' href="#"', $clean);
        $clean = preg_replace('/\ssrc="javascript:[^"]*"/i',  ' src=""',    $clean);
        return $clean;
    }
}

if (!function_exists('rte_first_paragraph')) {
    /**
     * Ambil paragraf (<p>...</p>) pertama dari HTML RTE,
     * sanitize, dan pertahankan inline tags (b,strong,i,em,u,a,span).
     * Tidak memotong karakter (biar bold tidak rusak) — potongnya pakai CSS clamp.
     */
    function rte_first_paragraph($html)
    {
        if ($html === null) return '';
        $decoded = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

        // Cari <p> pertama; jika tidak ada, pakai seluruh konten
        if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $decoded, $m)) {
            $first = $m[1];
        } else {
            $first = $decoded;
        }

        // Izinkan inline tags; buang block tags lain agar rapi
        $allowed_inline = '<b><strong><i><em><u><a><span><br><br/>';
        $clean = strip_tags($first, $allowed_inline);

        // Bersihkan event handler & javascript: URL
        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);
        $clean = preg_replace('/\shref="javascript:[^"]*"/i', ' href="#"', $clean);

        // Bungkus lagi sebagai satu paragraf
        return '<p>' . $clean . '</p>';
    }
}
