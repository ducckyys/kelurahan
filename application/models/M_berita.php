<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_berita extends CI_Model
{

    private $table = 'berita';

    // Fungsi baru untuk menghitung total semua berita
    public function count_all_berita()
    {
        return $this->db->count_all('berita');
    }

    // Fungsi get_all diubah untuk menerima limit dan offset
    public function get_all($limit, $start)
    {
        $this->db->select('berita.*, user.nama_lengkap');
        $this->db->from('berita');
        $this->db->join('user', 'user.id_user = berita.id_user', 'left');
        $this->db->order_by('tgl_publish', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function get_latest_berita($limit = 3)
    {
        $this->db->select('berita.*, user.nama_lengkap');
        $this->db->from('berita');
        $this->db->join('user', 'user.id_user = berita.id_user', 'left');
        $this->db->order_by('tgl_publish', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_by_slug($slug)
    {
        // Tambahkan join untuk mengambil nama penulis juga
        $this->db->select('berita.*, user.nama_lengkap as penulis');
        $this->db->from('berita');
        $this->db->join('user', 'user.id_user = berita.id_user', 'left');
        $this->db->where('slug_berita', $slug);
        return $this->db->get()->row();
    }

    // Mengambil satu data berita berdasarkan ID
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_berita' => $id])->row();
    }

    // Menyimpan data berita baru
    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Memperbarui data berita
    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_berita' => $id]);
    }

    // Menghapus data berita
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_berita' => $id]);
    }
}
