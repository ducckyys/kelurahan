<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kematian extends CI_Model
{
    private $table = 'surat_kematian';

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    public function update($id, $d)
    {
        return $this->db->update($this->table, $d, ['id' => $id]);
    }
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
