<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_belum_bekerja extends CI_Model
{
    private $table = 'surat_belum_bekerja';

    /**
     * Mengambil semua data untuk ditampilkan di tabel admin.
     */
    public function get_all()
    {
        return $this->db->order_by('tgl_dibuat', 'DESC')->get($this->table)->result();
    }

    /**
     * Mengambil satu baris data berdasarkan ID.
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Menyimpan data baru.
     */
    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Memperbarui data berdasarkan ID.
     */
    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    /**
     * Menghapus data berdasarkan ID.
     */
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
