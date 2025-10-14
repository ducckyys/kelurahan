<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model: M_kematian_nondukcapil
 * Tabel: surat_kematian_nondukcapil
 *
 * Catatan:
 * - Method save() disediakan agar kompatibel dengan controller Pelayanan::submit_kematian_nondukcapil
 * - Method all()/find() disediakan agar kompatibel dengan controller admin.
 */
class M_kematian_nondukcapil extends CI_Model
{
    protected $table = 'surat_kematian_nondukcapil';
    protected $pk    = 'id';

    /** List data (terbaru dulu) */
    public function get_all($limit = 50, $offset = 0)
    {
        return $this->db->from($this->table)
            ->order_by('created_at', 'DESC')
            ->limit((int)$limit, (int)$offset)
            ->get()->result();
    }

    /** Alias agar cocok dengan controller admin */
    public function all($limit = 50, $offset = 0)
    {
        return $this->get_all($limit, $offset);
    }

    /** Ambil satu baris by id */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->pk => (int)$id])->row();
    }

    /** Alias agar cocok dengan controller admin */
    public function find($id)
    {
        return $this->get_by_id($id);
    }

    /** Insert data baru, kembalikan insert_id */
    public function insert(array $data)
    {
        $ok = $this->db->insert($this->table, $data);
        return $ok ? (int)$this->db->insert_id() : false;
    }

    /** Alias utk kompatibilitas controller Pelayanan */
    public function save(array $data)
    {
        return $this->insert($data);
    }

    /** Update by id */
    public function update($id, array $data)
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
}
