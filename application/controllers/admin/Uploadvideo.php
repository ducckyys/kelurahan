<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property CI_Form_validation form_validation
 * @property M_uploadvideo M_uploadvideo
 */

class Uploadvideo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('M_uploadvideo');

        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
        }
    }

    public function index()
    {
        // Ambil link YouTube dari database
        $youtube_link = $this->M_uploadvideo->get_setting('youtube_link');

        // Siapkan default metadata
        $video_meta = [
            'title' => 'Video Kelurahan Kademangan',
            'author_name' => 'Kelurahan Kademangan'
        ];

        // Jika ada link, coba ambil metadata via oEmbed YouTube
        if (!empty($youtube_link)) {
            $oembed_url = 'https://www.youtube.com/oembed?url=' . urlencode($youtube_link) . '&format=json';
            $oembed_data = @file_get_contents($oembed_url);

            if ($oembed_data !== false) {
                $oembed = json_decode($oembed_data, true);
                $video_meta['title'] = $oembed['title'] ?? $video_meta['title'];
                $video_meta['author_name'] = $oembed['author_name'] ?? $video_meta['author_name'];
            }
        }

        // Kirim ke view
        $data = [
            'title' => 'Explore Kademangan',
            'youtube_link' => $youtube_link,
            'video_meta' => $video_meta
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_uploadvideo', $data);
        $this->load->view('layouts/footer');
    }

    public function update()
    {
        // 1. Load library form validation
        $this->load->library('form_validation');

        // 2. Atur aturan validasi. 'trim' akan membersihkan spasi
        //    dan memperbolehkan nilai kosong.
        $this->form_validation->set_rules('youtube_link', 'Link YouTube', 'trim');

        // 3. Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal (meskipun seharusnya tidak dengan aturan 'trim'),
            // kembali ke halaman form.
            $this->index();
        } else {
            // 4. Ambil data dari post setelah divalidasi
            $youtube_link = $this->input->post('youtube_link');

            // 5. Kirim data ke model untuk diupdate
            $this->M_uploadvideo->update_setting('youtube_link', $youtube_link);

            // 6. Set notifikasi dan redirect
            $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui.');
            redirect('admin/uploadvideo');
        }
    }
}
