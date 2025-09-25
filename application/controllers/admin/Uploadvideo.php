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
    }

    public function index()
    {
        $data['title'] = "Pengaturan Website";
        $data['youtube_link'] = $this->M_uploadvideo->get_setting('youtube_link');

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
