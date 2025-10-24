<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ref_jabatan extends CI_Model
{
    private $table = 'ref_jabatan';

    public function get_all_active()
    {
        return $this->db->where('is_active', 1)
            ->order_by('urut', 'ASC')->order_by('nama', 'ASC')
            ->get($this->table)->result();
    }

    // List jabatan yang BELUM ditempati (untuk create),
    // atau termasuk jabatan milik $pejabat_id saat edit.
    public function get_available_for($pejabat_id = null)
    {
        $this->db->select('rj.*')->from('ref_jabatan rj');
        $this->db->join('pejabat p', 'p.jabatan_id = rj.id', 'left');
        $this->db->where('rj.is_active', 1);

        if ($pejabat_id === null) {
            // create: hanya yang belum ditempati
            $this->db->where('p.id IS NULL', null, false);
        } else {
            // edit: boleh pilih jabatan kosong atau jabatan yang saat ini dipakai oleh record ini
            $this->db->group_start()
                ->where('p.id IS NULL', null, false)
                ->or_where('p.id', (int)$pejabat_id)
                ->group_end();
        }

        return $this->db->order_by('rj.urut', 'ASC')->order_by('rj.nama', 'ASC')->get()->result();
    }

    public function exists($id)
    {
        return (bool)$this->db->where('id', (int)$id)->count_all_results($this->table);
    }
}
