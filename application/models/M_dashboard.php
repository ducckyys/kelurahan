<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{

    /**
     * Menghitung jumlah total baris pada sebuah tabel tunggal.
     */
    public function count_all($table)
    {
        return $this->db->count_all($table);
    }

    /**
     * Menghitung total data dari semua tabel layanan.
     * Fungsi ini akan menjumlahkan total data dari 3 tabel.
     */
    public function count_pelayanan()
    {
        $count_usaha = $this->db->count_all_results('surat_izin_usaha');
        $count_nikah = $this->db->count_all_results('surat_pengantar_nikah');
        $count_sktm  = $this->db->count_all_results('surat_sktm');

        // Kembalikan hasil penjumlahan dari ketiganya
        return $count_usaha + $count_nikah + $count_sktm;
    }
}
