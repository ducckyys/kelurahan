<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

    /**
     * Mengambil data user tunggal berdasarkan username.
     * @param string $username
     * @return object|null
     */
    public function get_user_by_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }
}
