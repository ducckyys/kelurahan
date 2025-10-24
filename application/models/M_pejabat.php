<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pejabat extends CI_Model
{
    private $table = 'pejabat';

    public function get_all()
    {
        return $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from($this->table . ' p')
            ->join('ref_jabatan rj', 'rj.id = p.jabatan_id', 'left')
            ->order_by('rj.urut', 'ASC')->order_by('rj.nama', 'ASC')->order_by('p.nama', 'ASC')
            ->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from($this->table . ' p')
            ->join('ref_jabatan rj', 'rj.id = p.jabatan_id', 'left')
            ->where('p.id', (int)$id)->get()->row();
    }

    public function get_all_signers()
    {
        return $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from('pejabat p')
            ->join('ref_jabatan rj', 'rj.id = p.jabatan_id', 'inner')
            ->where('rj.is_active', 1)
            ->order_by('rj.urut', 'ASC')->order_by('rj.nama', 'ASC')
            ->get()->result();
    }

    public function get_by_id_join($id)
    {
        return $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from('pejabat p')
            ->join('ref_jabatan rj', 'rj.id = p.jabatan_id', 'inner')
            ->where('p.id', (int)$id)
            ->limit(1)->get()->row();
    }

    // Default preferensi: Sekretaris Kelurahan → Lurah (kalau ada)
    public function get_default_signer()
    {
        $sek = $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from('pejabat p')->join('ref_jabatan rj', 'rj.id=p.jabatan_id', 'inner')
            ->where('rj.nama', 'Sekretaris Kelurahan')->limit(1)->get()->row();
        if ($sek) return $sek;

        $lur = $this->db->select('p.*, rj.nama AS jabatan_nama')
            ->from('pejabat p')->join('ref_jabatan rj', 'rj.id=p.jabatan_id', 'inner')
            ->like('rj.nama', 'Lurah', 'after') // nama jabatan diawali "Lurah"
            ->limit(1)->get()->row();
        return $lur ?: null;
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, ['id' => (int)$id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => (int)$id]);
    }

    public function exists_nip($nip, $ignore_id = null)
    {
        $this->db->from($this->table)->where('nip', $nip);
        if (!empty($ignore_id)) $this->db->where('id !=', (int)$ignore_id);
        return (bool)$this->db->count_all_results();
    }

    public function exists_jabatan($jabatan_id, $ignore_id = null)
    {
        $this->db->from($this->table)->where('jabatan_id', (int)$jabatan_id);
        if (!empty($ignore_id)) $this->db->where('id !=', (int)$ignore_id);
        return (bool)$this->db->count_all_results();
    }
}
