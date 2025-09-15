<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_konfigurasi M_konfigurasi
 */

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_konfigurasi');
    }

    public function index()
    {
        $data['title'] = "Pengaturan Website";
        $data['youtube_link'] = $this->M_konfigurasi->get_setting('youtube_link');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_pengaturan', $data);
        $this->load->view('layouts/footer');
    }

    public function update()
    {
        $youtube_link = $this->input->post('youtube_link');
        $this->M_konfigurasi->update_setting('youtube_link', $youtube_link);
        $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui.');
        redirect('admin/pengaturan');
    }
}
