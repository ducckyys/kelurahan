<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_belum_memiliki_rumah extends CI_Model
{
    private $table = 'surat_belum_memiliki_rumah';

    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    public function save($data)
    {
        $ok = $this->db->insert($this->table, $data);
        return $ok ? $this->db->insert_id() : false;
    }

    public function update($id, $data)
    {
        $this->db->update($this->table, $data, ['id' => (int)$id]);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->delete($this->table, ['id' => (int)$id]);
        return $this->db->affected_rows();
    }
}
