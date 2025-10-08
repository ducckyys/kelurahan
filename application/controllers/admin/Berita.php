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
        $this->load->model('M_berita');
        $this->load->helper(['url', 'form', 'text']);

        // Proteksi login
        if ($this->session->userdata('status') !== "login") {
            redirect(base_url("login"));
        }
    }

    // LIST
    public function index()
    {
        $data['title'] = "Manajemen Berita";
        $data['berita_list'] = $this->M_berita->get_all(); // tanpa limit di halaman admin

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/berita/index', $data);
        $this->load->view('layouts/footer');
    }

    // PAGE: TAMBAH
    public function create()
    {
        $data['title'] = "Tambah Berita";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/berita/tambah', $data);
        $this->load->view('layouts/footer');
    }

    // ACTION: STORE
    public function store()
    {
        // Pastikan folder upload ada
        $upload_dir = FCPATH . 'uploads/berita/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0755, true);
        }

        $config['upload_path']   = $upload_dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 5 MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/berita/create');
            return;
        }

        $upload_data = $this->upload->data();
        $data = [
            'judul_berita' => $this->input->post('judul_berita', true),
            'isi_berita'   => $this->input->post('isi_berita', false),
            'kategori'     => $this->input->post('kategori', true),
            'slug_berita'  => url_title($this->input->post('judul_berita', true), 'dash', true),
            'gambar'       => $upload_data['file_name'],
            'id_user'      => $this->session->userdata('id_user')
            // 'tgl_publish' => date('Y-m-d H:i:s') // jika DB tidak auto
        ];

        $this->M_berita->save($data);
        $this->session->set_flashdata('success', 'Berita berhasil ditambahkan.');
        redirect('admin/berita');
    }

    // PAGE: EDIT
    public function edit($id)
    {
        $berita = $this->M_berita->get_by_id($id);
        if (!$berita) {
            show_404();
        }

        $data['title']  = "Edit Berita";
        $data['berita'] = $berita;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/berita/edit', $data);
        $this->load->view('layouts/footer');
    }

    // ACTION: UPDATE
    public function update($id)
    {
        $post = $this->input->post();

        $data = [
            'judul_berita' => $post['judul_berita'],
            'isi_berita'   => $post['isi_berita'],
            'kategori'     => $post['kategori'],
            'slug_berita'  => url_title($post['judul_berita'], 'dash', true)
        ];

        // Jika ada gambar baru
        if (!empty($_FILES["gambar"]["name"])) {
            $berita = $this->M_berita->get_by_id($id);

            $upload_dir = FCPATH . 'uploads/berita/';
            if (!is_dir($upload_dir)) {
                @mkdir($upload_dir, 0755, true);
            }

            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                // hapus lama
                if (!empty($berita->gambar) && file_exists($upload_dir . $berita->gambar)) {
                    @unlink($upload_dir . $berita->gambar);
                }
                $data['gambar'] = $this->upload->data("file_name");
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/berita/edit/' . $id);
                return;
            }
        }

        $this->M_berita->update($id, $data);
        $this->session->set_flashdata('success', 'Berita berhasil diperbarui.');
        redirect('admin/berita');
    }

    // ACTION: DELETE
    public function delete($id)
    {
        $berita = $this->M_berita->get_by_id($id);
        if ($berita) {
            $file = FCPATH . 'uploads/berita/' . $berita->gambar;
            if (!empty($berita->gambar) && file_exists($file)) {
                @unlink($file);
            }
            $this->M_berita->delete($id);
            $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        }
        redirect('admin/berita');
    }
}
