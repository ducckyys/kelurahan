<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_coverage extends CI_Model
{
    private $table = 'coverage_stats';

    public function ensure_defaults()
    {
        $q = $this->db->get($this->table);
        if ($q->num_rows() === 0) {
            $this->db->insert($this->table, [
                'jumlah_kk' => 0,
                'jumlah_penduduk' => 0,
                'jumlah_rw' => 0,
                'jumlah_rt' => 0
            ]);
        }
    }

    public function get_single()
    {
        return $this->db->get($this->table)->row();
    }

    public function update_values($data)
    {
        $row = $this->get_single();
        if (!$row) $this->ensure_defaults();
        $this->db->limit(1)->update($this->table, $data);
        if ($this->db->affected_rows() === 0) {
            // Jika belum ada LIMIT target, fallback update row pertama
            $this->db->where('id', 1)->update($this->table, $data);
        }
    }
}
