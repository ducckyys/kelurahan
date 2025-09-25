<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kematian_nondukcapil extends CI_Model
{
    protected $table = 'surat_kematian_nondukcapil';

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }
    public function find($id)
    {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }
    public function update($id, $data)
    {
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => (int)$id]);
    }
}
