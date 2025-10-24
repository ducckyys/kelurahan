<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengantar_nikah extends CI_Model
{
    protected $table = 'surat_pengantar_nikah';
    protected $pk    = 'id';

    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->from($this->table)
            ->order_by('created_at', 'DESC')
            ->limit((int)$limit, (int)$offset)
            ->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->pk => (int)$id])->row();
    }

    public function insert(array $data)
    {
        $this->db->insert($this->table, $data);
        return (int)$this->db->insert_id();
    }

    public function update($id, array $data)
    {
        $this->db->where($this->pk, (int)$id)->update($this->table, $data);
        return $this->db->affected_rows() >= 0;
    }

    public function delete($id)
    {
        $this->db->where($this->pk, (int)$id)->delete($this->table);
        return $this->db->affected_rows() > 0;
    }

    /* ===== Dokumen pendukung (JSON di kolom TEXT) ===== */
    public function get_pendukung($id): array
    {
        $row = $this->get_by_id($id);
        if (!$row || empty($row->dokumen_pendukung)) return [];
        $dec = json_decode($row->dokumen_pendukung, true);
        if (is_array($dec)) return $dec;
        if (is_string($row->dokumen_pendukung)) return [$row->dokumen_pendukung];
        return [];
    }

    public function set_pendukung($id, array $files)
    {
        $clean = array_values(array_filter($files));
        return $this->update($id, [
            'dokumen_pendukung' => !empty($clean) ? json_encode($clean) : null
        ]);
    }

    public function append_pendukung($id, array $newFiles): array
    {
        $existing = $this->get_pendukung($id);
        $all      = array_values(array_filter(array_merge($existing, $newFiles)));
        $this->set_pendukung($id, $all);
        return $all;
    }
}
