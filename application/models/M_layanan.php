<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_layanan extends CI_Model
{
    private $table = 'layanan';

    public function get_all_active()
    {
        return $this->db->where('aktif', 1)
            ->order_by('urut', 'ASC')
            ->order_by('id', 'DESC')
            ->get($this->table)->result();
    }

    // Admin
    public function get_all($q = null)
    {
        if ($q) {
            $this->db->group_start()
                ->like('judul', $q)
                ->or_like('deskripsi', $q)
                ->group_end();
        }
        return $this->db->order_by('urut', 'ASC')
            ->order_by('id', 'DESC')
            ->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function update($id, $data)
    {
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }
    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }
}
