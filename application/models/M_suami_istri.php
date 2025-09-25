<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_suami_istri extends CI_Model
{

    private $_table = "surat_keterangan_suami_istri";

    // Diubah dari getAll
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->_table)->result();
    }

    // Diubah dari getById
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
        if (!$data) return FALSE;

        $filename = $data->scan_surat_rt;
        // Gunakan path yang konsisten untuk file upload
        if (file_exists('./uploads/suami_istri/' . $filename) && $filename) {
            unlink('./uploads/suami_istri/' . $filename);
        }

        return $this->db->delete($this->_table, ["id" => $id]);
    }
}
