<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_informasi extends CI_Model
{
    private $table = 'informasi';

    public function get_all($filters = [])
    {
        // UBAH BARIS DI BAWAH INI
        $this->db->select('informasi.*, user.nama_lengkap');
        $this->db->from($this->table);
        $this->db->join('user', 'user.id_user = informasi.id_user', 'left');

        // Filter pencarian
        if (!empty($filters['q'])) {
            $this->db->group_start();
            $this->db->like('judul_informasi', $filters['q']);
            $this->db->or_like('isi_informasi', $filters['q']);
            $this->db->group_end();
        }

        // Filter kategori
        if (!empty($filters['cat'])) {
            $this->db->where('kategori', $filters['cat']);
        }

        $this->db->order_by('tgl_publish', 'DESC');
        return $this->db->get()->result();
    }

    public function get_latest_info($limit = 3)
    {
        $this->db->select('informasi.*, user.nama_lengkap');
        $this->db->from('informasi');
        $this->db->join('user', 'user.id_user = informasi.id_user', 'left');
        $this->db->order_by('tgl_publish', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Fungsi ini untuk halaman detail
    public function get_by_id_with_user($id)
    {
        // UBAH JUGA BARIS DI BAWAH INI
        $this->db->select('informasi.*, user.nama_lengkap');
        $this->db->from($this->table);
        $this->db->join('user', 'user.id_user = informasi.id_user', 'left');
        $this->db->where('id_informasi', $id);
        return $this->db->get()->row();
    }

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_informasi' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_informasi' => $id]);
    }
}
