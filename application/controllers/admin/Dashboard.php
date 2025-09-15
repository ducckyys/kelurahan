<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_DB_query_builder db
 * @property M_dashboard M_dashboard
 */

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Proteksi halaman, wajib login
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }

        // Load model dashboard
        $this->load->model('M_dashboard');
    }

    public function index()
    {
        $data['title'] = "Dashboard";

        // Mengambil jumlah data konten
        $data['jumlah_berita'] = $this->M_dashboard->count_all('berita');
        $data['jumlah_galeri'] = $this->M_dashboard->count_all('galeri');
        $data['jumlah_informasi'] = $this->M_dashboard->count_all('informasi');

        // Mengambil jumlah data untuk setiap jenis surat
        $data['jumlah_usaha'] = $this->M_dashboard->count_all('surat_izin_usaha');
        $data['jumlah_nikah'] = $this->M_dashboard->count_all('surat_pengantar_nikah');
        $data['jumlah_sktm'] = $this->M_dashboard->count_all('surat_sktm');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_dashboard', $data);
        $this->load->view('layouts/footer');
    }
}
