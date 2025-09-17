<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property M_user $M_user
 */
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        if ($this->session->userdata('id_level') != 1) {
            $this->session->set_flashdata('error', 'Anda tidak punya akses ke halaman ini!');
            redirect('admin/dashboard');
        }
        $this->load->model('M_user');
    }

    public function index()
    {
        $data['title'] = "Manajemen Admin/Staff";
        $data['user_list'] = $this->M_user->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_users', $data);
        $this->load->view('layouts/footer');
    }

    public function store()
    {
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            // PERBAIKAN: Gunakan password_hash()
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'id_level'     => 2
        ];

        $this->M_user->save($data);
        $this->session->set_flashdata('success', 'Admin/Staff baru berhasil ditambahkan.');
        redirect('admin/users');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'nama_lengkap' => $post['nama_lengkap'],
            'username'     => $post['username'],
        ];

        // Cek jika password baru diisi, maka update passwordnya
        if (!empty($post['password'])) {
            // PERBAIKAN: Gunakan password_hash()
            $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        }

        $this->M_user->update($id, $data);
        $this->session->set_flashdata('success', 'Data Admin/Staff berhasil diperbarui.');
        redirect('admin/users');
    }

    public function delete($id)
    {
        $this->M_user->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('admin/users');
    }
}
