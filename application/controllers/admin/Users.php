<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_user M_user
 */

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Cek status login
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }

        // --- KUNCI KEAMANAN ---
        // Cek level user, hanya Superadmin (level 1) yang boleh mengakses
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
        $data['level_list'] = $this->M_user->get_levels(); // Untuk dropdown di modal

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
            'password'     => md5($this->input->post('password')), // Enkripsi password
            'id_level'     => 2
        ];

        $this->M_user->save($data);
        $this->session->set_flashdata('success', 'Admin/Staff baru berhasil ditambahkan.');
        redirect('admin/users');
    }

    // application/controllers/admin/Users.php

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'nama_lengkap' => $post['nama_lengkap'],
            'username'     => $post['username'],
        ];

        // Cek jika password diisi, maka update passwordnya
        if (!empty($post['password'])) {
            $data['password'] = md5($post['password']);
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
