<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_berita $M_berita
 * @property M_galeri $M_galeri
 * @property M_informasi $M_informasi
 * @property M_uploadvideo $M_uploadvideo
 * @property M_runningtext $M_runningtext
 * @property M_layanan $M_layanan
 * @property M_coverage $M_coverage
 */

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load semua model yang dibutuhkan untuk halaman utama
        $this->load->model('M_berita');
        $this->load->model('M_galeri');
        $this->load->model('M_runningtext');
        $this->load->model('M_uploadvideo');
        $this->load->model('M_layanan');
        $this->load->helper('text');
        $this->load->model('M_coverage');
    }

    public function index()
    {
        $data['title'] = "Explore Kademangan";

        $data['berita_list'] = $this->M_berita->get_latest_berita(3); // Ambil 3 berita terbaru
        $data['galeri_list'] = $this->M_galeri->get_latest_galeri(6); // Ambil 6 foto terbaru
        $data['youtube_link'] = $this->M_uploadvideo->get_setting('youtube_link');
        $data['layanan_list'] = $this->M_layanan->get_all_active();
        $data['coverage'] = $this->M_coverage->get_single();

        // === Tambahan: ambil metadata YouTube (judul & channel)
        $video_meta = [
            'title' => 'Video Kelurahan Kademangan',
            'author_name' => 'Kelurahan Kademangan'
        ];

        if (!empty($data['youtube_link'])) {
            $oembed_url = 'https://www.youtube.com/oembed?url=' . urlencode($data['youtube_link']) . '&format=json';
            $oembed_data = @file_get_contents($oembed_url);

            if ($oembed_data !== false) {
                $oembed = json_decode($oembed_data, true);
                $video_meta['title'] = $oembed['title'] ?? $video_meta['title'];
                $video_meta['author_name'] = $oembed['author_name'] ?? $video_meta['author_name'];
            }
        }

        $data['video_meta'] = $video_meta;

        $data['rt_top']    = $this->M_runningtext->get_active_by_position('top');
        $data['rt_bottom'] = $this->M_runningtext->get_active_by_position('bottom');

        // Muat tampilan
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_home', $data);
        $this->load->view('layouts_frontend/footer');
    }
}
