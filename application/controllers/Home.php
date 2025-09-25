<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_berita $M_berita
 * @property M_galeri $M_galeri
 * @property M_informasi $M_informasi
 * @property M_uploadvideo $M_uploadvideo
 */

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load semua model yang dibutuhkan untuk halaman utama
        $this->load->model('M_berita');
        $this->load->model('M_galeri');
        $this->load->model('M_informasi');
        $this->load->model('M_uploadvideo');
    }

    public function index()
    {
        $data['title'] = "Explore Kademangan";

        $this->load->model('M_uploadvideo');

        // Mengambil data dari database
        $data['berita_list'] = $this->M_berita->get_latest_berita(3); // Ambil 3 berita terbaru
        $data['galeri_list'] = $this->M_galeri->get_latest_galeri(6); // Ambil 6 foto terbaru
        $data['informasi_list'] = $this->M_informasi->get_latest_info(3); // Ambil 3 info terbaru
        $data['youtube_link'] = $this->M_uploadvideo->get_setting('youtube_link');


        // Memuat view
        // Ganti 'layouts_frontend' dengan nama folder layout Anda jika berbeda
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_home', $data); // Ini adalah view konten utama
        $this->load->view('layouts_frontend/footer');
    }
}
