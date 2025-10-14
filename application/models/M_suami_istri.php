<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model: M_suami_istri
 * Tabel: surat_keterangan_suami_istri
 */
class M_suami_istri extends CI_Model
{
    protected $table = 'surat_keterangan_suami_istri';
    protected $pk    = 'id';

    /** List data terbaru dulu */
    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->from($this->table)
            ->order_by('created_at', 'DESC')
            ->limit((int)$limit, (int)$offset)
            ->get()->result();
    }

    /** Ambil satu baris */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->pk => (int)$id])->row();
    }

    /** Insert data, return insert_id */
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return (int)$this->db->insert_id();
    }

    /** Alias untuk kompatibilitas dengan Pelayanan::submit_* */
    public function save($data)
    {
        return $this->insert($data);
    }

    /** Update by id */
    public function update($id, $data)
    {
        $this->db->where($this->pk, (int)$id)->update($this->table, $data);
        return $this->db->affected_rows() >= 0;
    }

    /** Hapus by id */
    public function delete($id)
    {
        $this->db->where($this->pk, (int)$id)->delete($this->table);
        return $this->db->affected_rows() > 0;
    }

    // =========================
    //  Dokumen Pendukung (JSON)
    // =========================

    /** Ambil array file dari kolom dokumen_pendukung */
    public function get_pendukung($id)
    {
        $row = $this->get_by_id($id);
        if (!$row || empty($row->dokumen_pendukung)) return [];

        $decoded = json_decode($row->dokumen_pendukung, true);
        if (is_array($decoded)) return $decoded;
        if (is_string($row->dokumen_pendukung)) return [$row->dokumen_pendukung];
        return [];
    }

    /** Set penuh dokumen_pendukung */
    public function set_pendukung($id, array $files)
    {
        $clean = array_values(array_filter($files));
        return $this->update($id, [
            'dokumen_pendukung' => !empty($clean) ? json_encode($clean) : null
        ]);
    }

    /** Append file baru */
    public function append_pendukung($id, array $newFiles)
    {
        $existing = $this->get_pendukung($id);
        $all = array_values(array_filter(array_merge($existing, $newFiles)));
        $this->set_pendukung($id, $all);
        return $all;
    }

    /** Hapus satu filename dari list (tidak menghapus file fisik) */
    public function remove_pendukung_file($id, $filename)
    {
        $files = $this->get_pendukung($id);
        $filtered = array_values(array_filter($files, function ($f) use ($filename) {
            return $f !== $filename;
        }));
        return $this->set_pendukung($id, $filtered);
    }
}
