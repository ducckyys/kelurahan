<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_login $M_login
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login');
    }

    /**
     * Menampilkan halaman login.
     * Jika user sudah login, akan diarahkan ke dashboard.
     */
    public function index()
    {
        if ($this->session->userdata('status') == "login") {
            redirect('admin/dashboard');
        }
        $this->load->view('v_login');
    }

    /**
     * Memproses aksi login dari form.
     */
    public function aksi_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // 1. Ambil data user dari database berdasarkan username
        $user = $this->M_login->get_user_by_username($username);

        // 2. Cek apakah user ada DAN password-nya cocok
        if ($user && password_verify($password, $user->password)) {
            // Jika berhasil, buat session
            $data_session = array(
                'id_user'   => $user->id_user,
                'nama'      => $user->nama_lengkap,
                'id_level'  => $user->id_level,
                'foto'      => $user->foto, // <-- TAMBAHKAN BARIS INI
                'status'    => "login"
            );
            $this->session->set_userdata($data_session);
            redirect('admin/dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            redirect('auth/login');
        }
    }

    /**
     * Menghancurkan session dan logout.
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
}
