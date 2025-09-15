<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_konfigurasi extends CI_Model
{

    public function get_setting($nama)
    {
        $query = $this->db->get_where('konfigurasi', ['nama_konfigurasi' => $nama]);
        if ($query->num_rows() > 0) {
            return $query->row()->nilai_konfigurasi;
        }
        return '';
    }

    public function update_setting($nama, $nilai)
    {
        $this->db->where('nama_konfigurasi', $nama);
        return $this->db->update('konfigurasi', ['nilai_konfigurasi' => $nilai]);
    }
}
