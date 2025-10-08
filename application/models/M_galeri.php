<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_galeri extends CI_Model
{
    private $table = 'galeri';

    public function get_all($limit = null, $start = 0)
    {
        $this->db->select('galeri.*, user.nama_lengkap');
        $this->db->from($this->table);
        $this->db->join('user', 'user.id_user = galeri.id_user', 'left');
        $this->db->order_by('tgl_upload', 'DESC');

        if (!is_null($limit)) {
            $this->db->limit((int)$limit, (int)$start);
        }

        return $this->db->get()->result();
    }

    public function get_latest_galeri($limit = 6)
    {
        $this->db->order_by('tgl_upload', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_galeri' => $id])->row();
    }

    public function save($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_galeri' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_galeri' => $id]);
    }
}
