<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_berita extends CI_Model
{
    private $table = 'berita';

    public function count_all_berita()
    {
        return $this->db->count_all($this->table);
    }

    // Bisa dipakai admin (tanpa limit) & frontend (dengan limit/offset)
    public function get_all($limit = null, $start = 0)
    {
        $this->db->select('berita.*, user.nama_lengkap');
        $this->db->from($this->table);
        $this->db->join('user', 'user.id_user = berita.id_user', 'left');
        $this->db->order_by('tgl_publish', 'DESC');

        if (!is_null($limit)) {
            $this->db->limit((int)$limit, (int)$start);
        }

        return $this->db->get()->result();
    }

    public function get_all_for_admin()
    {
        // tetap ada jika kamu pakai di tempat lain
        return $this->get_all();
    }

    public function get_latest_berita($limit = 3)
    {
        return $this->get_all($limit, 0);
    }

    public function get_by_slug($slug)
    {
        $this->db->select('berita.*, user.nama_lengkap as penulis');
        $this->db->from($this->table);
        $this->db->join('user', 'user.id_user = berita.id_user', 'left');
        $this->db->where('slug_berita', $slug);
        return $this->db->get()->row();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_berita' => $id])->row();
    }

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_berita' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_berita' => $id]);
    }
}
