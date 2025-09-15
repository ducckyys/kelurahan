<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_profil extends CI_Model
{

    private $table = 'user';

    public function get_user_data($id)
    {
        return $this->db->get_where($this->table, ['id_user' => $id])->row();
    }

    public function update_profile($id, $data)
    {
        return $this->db->update($this->table, $data, ['id_user' => $id]);
    }
}
