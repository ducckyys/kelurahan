<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_profil M_profil
 * @property CI_Upload upload
 */

class Profil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_profil');
    }

    public function index()
    {
        // Ambil id_user dari session yang sedang login
        $id_user = $this->session->userdata('id_user');

        $data['title'] = "Profil Saya";
        $data['user'] = $this->M_profil->get_user_data($id_user);

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_profil', $data);
        $this->load->view('layouts/footer');
    }

    public function update()
    {
        $id_user = $this->session->userdata('id_user');
        $post = $this->input->post();

        $data = [
            'nama_lengkap' => $post['nama_lengkap'],
            'username'     => $post['username']
        ];

        // Cek jika user mengisi password baru
        if (!empty($post['password_baru'])) {
            if ($post['password_baru'] != $post['konfirmasi_password']) {
                $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok!');
                redirect('admin/profil');
            }
            $data['password'] = password_hash($post['password_baru'], PASSWORD_DEFAULT);
        }

        // Cek jika ada file foto yang diupload
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './uploads/profil/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 5120; // 2MB
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                // Hapus foto lama (jika bukan default.jpg)
                $user_lama = $this->M_profil->get_user_data($id_user);
                if ($user_lama->foto != 'default.jpg') {
                    unlink('./uploads/profil/' . $user_lama->foto);
                }
                // Ambil nama file baru dan masukkan ke data
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/profil');
            }
        }

        // Update data ke database
        if ($this->M_profil->update_profile($id_user, $data)) {
            // Update session dengan data baru
            $this->session->set_userdata('nama', $data['nama_lengkap']);
            if (isset($data['foto'])) {
                $this->session->set_userdata('foto', $data['foto']);
            }
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
        }

        redirect('admin/profil');
    }
}
