<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_runningtext extends CI_Model
{
    private $table = 'running_texts';

    public function get_by_position($position)
    {
        return $this->db->get_where($this->table, ['position' => $position])->row();
    }

    public function update_by_position($position, $data)
    {
        return $this->db->update($this->table, $data, ['position' => $position]);
    }

    /** Ambil yang aktif (fallback ke baris posisi itu jika semua nonaktif) */
    public function get_active_by_position($position)
    {
        $row = $this->db->where('position', $position)
            ->where('is_active', 1)
            ->order_by('updated_at', 'DESC')
            ->limit(1)
            ->get($this->table)->row();
        if (!$row) {
            $row = $this->get_by_position($position);
        }
        return $row;
    }

    /** Pastikan baris 'top' & 'bottom' selalu ada */
    public function ensure_defaults()
    {
        $defaults = [
            'top' => [
                'content'   => '📢 Selamat Datang di Website Resmi Kelurahan Kademangan | Layanan publik mudah, cepat, dan transparan!',
                'direction' => 'left',
                'speed'     => 6,
                'is_active' => 1,
            ],
            'bottom' => [
                'content'   => '💬 Hubungi kami melalui media sosial resmi Kelurahan Kademangan | Ikuti update kegiatan terbaru setiap minggu!',
                'direction' => 'right',
                'speed'     => 5,
                'is_active' => 1,
            ],
        ];
        foreach ($defaults as $pos => $val) {
            if (!$this->get_by_position($pos)) {
                $this->db->insert($this->table, array_merge(['position' => $pos], $val));
            }
        }
    }
}
