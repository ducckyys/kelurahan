<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property M_berita $M_berita
 * @property CI_Input $input
 * @property CI_Upload $upload
 */

class Berita extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model M_berita
        $this->load->model('M_berita');

        // Proteksi halaman, jika belum login akan dilempar ke halaman login
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    // Halaman utama (daftar berita)
    public function index()
    {
        $data['title'] = "Manajemen Berita";
        $data['berita_list'] = $this->M_berita->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_berita', $data);
        $this->load->view('layouts/footer');
    }

    // Method untuk menyimpan data (Create)
    public function store()
    {
        // Konfigurasi untuk upload gambar
        $config['upload_path']   = './uploads/berita/'; // pastikan folder ini ada
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 2MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/berita');
        } else {
            $upload_data = $this->upload->data();
            $data = [
                'judul_berita' => $this->input->post('judul_berita'),
                'isi_berita'   => $this->input->post('isi_berita'),
                'kategori'     => $this->input->post('kategori'), // <-- TAMBAHKAN INI
                'slug_berita'  => url_title($this->input->post('judul_berita'), 'dash', TRUE),
                'gambar'       => $upload_data['file_name'],
                'id_user'      => $this->session->userdata('id_user')
            ];

            $this->M_berita->save($data);
            $this->session->set_flashdata('success', 'Berita berhasil ditambahkan.');
            redirect('admin/berita');
        }
    }

    // Method untuk memperbarui data (Update)
    public function update($id)
    {
        $post = $this->input->post();

        $data = [
            'judul_berita' => $post['judul_berita'],
            'isi_berita'   => $post['isi_berita'],
            'kategori'     => $post['kategori'], // <-- TAMBAHKAN INI
            'slug_berita'  => url_title($post['judul_berita'], 'dash', TRUE)
        ];

        // Cek apakah ada file gambar baru yang diupload
        if (!empty($_FILES["gambar"]["name"])) {
            // Hapus gambar lama
            $berita = $this->M_berita->get_by_id($id);
            if (file_exists('./uploads/berita/' . $berita->gambar) && $berita->gambar) {
                unlink('./uploads/berita/' . $berita->gambar);
            }

            // Upload gambar baru
            $config['upload_path']   = './uploads/berita/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                $data['gambar'] = $this->upload->data("file_name");
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/berita');
            }
        }

        $this->M_berita->update($id, $data);
        $this->session->set_flashdata('success', 'Berita berhasil diperbarui.');
        redirect('admin/berita');
    }

    // Method untuk menghapus data (Delete)
    public function delete($id)
    {
        // Ambil data berita untuk mendapatkan nama file gambarnya
        $berita = $this->M_berita->get_by_id($id);
        if ($berita) {
            // Hapus file gambar dari server
            if (file_exists('./uploads/berita/' . $berita->gambar)) {
                unlink('./uploads/berita/' . $berita->gambar);
            }
            // Hapus data dari database
            $this->M_berita->delete($id);
            $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        }
        redirect('admin/berita');
    }
}
