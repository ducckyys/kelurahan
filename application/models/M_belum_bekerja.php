<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_belum_bekerja extends CI_Model
{

    private $_table = "surat_belum_bekerja";

    public function get_all()
    {
        // DIUBAH: Menggunakan 'created_at' yang sesuai dengan database baru
        return $this->db->order_by('created_at', 'DESC')->get($this->_table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function save($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->_table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        $data = $this->get_by_id($id);
        if ($data && !empty($data->scan_surat_rt)) {
            $file_path = './uploads/surat_rt/' . $data->scan_surat_rt;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        return $this->db->delete($this->_table, ["id" => $id]);
    }
}
