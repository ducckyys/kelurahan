<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

    // Mengambil semua data user dengan join ke tabel level
    public function get_all()
    {
        $this->db->select('user.*, level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'user.id_level = level.id_level');
        $this->db->where('user.id_level !=', 1); // Hanya tampilkan user yang BUKAN Superadmin

        return $this->db->get()->result();
    }

    // Mengambil semua data level
    public function get_levels()
    {
        return $this->db->get('level')->result();
    }

    // Menyimpan user baru
    public function save($data)
    {
        return $this->db->insert('user', $data);
    }

    // Mengupdate data user
    public function update($id, $data)
    {
        return $this->db->update('user', $data, ['id_user' => $id]);
    }

    // Menghapus data user
    public function delete($id)
    {
        return $this->db->delete('user', ['id_user' => $id]);
    }
}
