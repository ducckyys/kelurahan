<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_settings extends CI_Model
{
    private $table = 'site_settings';

    public function get_footer()
    {
        $row = $this->db->get_where($this->table, ['id' => 1])->row_array();

        if (!$row) {
            return [
                'about_html'   => '',
                'related_links' => [],
                'social_links' => [],
            ];
        }

        return [
            'about_html'    => (string)($row['about_html'] ?? ''),
            'related_links' => $this->jsonDecodeSafe($row['related_links'] ?? '[]'),
            'social_links'  => $this->jsonDecodeSafe($row['social_links'] ?? '[]'),
        ];
    }

    public function save_footer(array $data)
    {
        $payload = [
            'about_html'   => $data['about_html'] ?? null,
            'related_links' => json_encode($data['related_links'] ?? []),
            'social_links' => json_encode($data['social_links'] ?? []),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        // pastikan baris id=1 selalu ada
        $exists = $this->db->get_where($this->table, ['id' => 1])->row_array();
        if ($exists) {
            $this->db->where('id', 1)->update($this->table, $payload);
        } else {
            $payload['id'] = 1;
            $this->db->insert($this->table, $payload);
        }
        return $this->db->affected_rows() >= 0;
    }

    private function jsonDecodeSafe($json)
    {
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : [];
    }
}
