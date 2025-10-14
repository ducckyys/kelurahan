<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property M_berita $M_berita
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Output $output
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

        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
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

    // === ENDPOINT: UPLOAD GAMBAR DARI CKEDITOR 5 ===
    public function upload_gambar()
    {
        // Hanya izinkan POST
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
            show_error('Method Not Allowed', 405);
        }

        // Siapkan folder
        $upload_dir = FCPATH . 'uploads/berita/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0755, true);
        }

        // Konfigurasi upload
        $config = [
            'upload_path'   => $upload_dir,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 5120, // 5MB
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload', $config);

        // CKEditor SimpleUpload memakai field name "upload"
        if (!$this->upload->do_upload('upload')) {
            $error = strip_tags($this->upload->display_errors('', ''));
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['error' => ['message' => $error]]));
        }

        $data = $this->upload->data();
        $url  = base_url('uploads/berita/' . $data['file_name']);

        // Respons yang diharapkan CKEditor 5
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['url' => $url]));
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

        // === Ambil input ===
        $judul    = $this->input->post('judul_berita', true);
        $kategori = $this->input->post('kategori', true);
        $isi      = $this->input->post('isi_berita', false); // HTML utuh dari CKEditor
        $slug     = url_title($judul, 'dash', true);

        if (!$judul || !$kategori || !$isi) {
            $this->session->set_flashdata('error', 'Judul, Kategori, dan Isi wajib diisi.');
            redirect('admin/berita/create');
            return;
        }

        // === Siapkan data dasar ===
        $data = [
            'judul_berita' => $judul,
            'isi_berita'   => $isi,
            'kategori'     => $kategori,
            'slug_berita'  => $slug,
            'id_user'      => $this->session->userdata('id_user'),
            'tgl_publish'  => date('Y-m-d H:i:s'), // <-- PENTING kalau kolom NOT NULL
        ];

        // === Upload sampul (OPsional) ===
        // Di view boleh tetap 'required' kalau memang wajib, tapi biar aman kita handle opsional di backend
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
            $config['max_size']      = 5120; // 5 MB
            $config['encrypt_name']  = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $err = strip_tags($this->upload->display_errors('', ''));
                $this->session->set_flashdata('error', 'Upload gambar gagal: ' . $err);
                redirect('admin/berita/create');
                return;
            }

            $upload_data     = $this->upload->data();
            $data['gambar']  = $upload_data['file_name'];
        } else {
            // Jika memang wajib punya gambar, kamu bisa aktifkan validasi ini:
            // $this->session->set_flashdata('error', 'Gambar wajib diunggah.');
            // redirect('admin/berita/create'); return;
        }

        // === Simpan ===
        // (opsional) cek slug unik kalau ada UNIQUE constraint di DB
        // if ($this->M_berita->exists_slug($slug)) { ... }

        $ok = $this->M_berita->save($data);
        if (!$ok) {
            $this->session->set_flashdata('error', 'Gagal menyimpan data. Coba lagi.');
            redirect('admin/berita/create');
            return;
        }

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
        // Ambil dengan kontrol XSS: judul & kategori boleh TRUE, RTE harus FALSE
        $judul    = $this->input->post('judul_berita', TRUE);
        $kategori = $this->input->post('kategori', TRUE);
        $isi      = $this->input->post('isi_berita', FALSE); // RAW HTML

        $data = [
            'judul_berita' => $judul,
            'isi_berita'   => $isi,
            'kategori'     => $kategori,
            'slug_berita'  => url_title($judul, 'dash', true),
        ];

        // upload gambar (opsional)
        if (!empty($_FILES["gambar"]["name"])) {
            $berita = $this->M_berita->get_by_id($id);

            $upload_dir = FCPATH . 'uploads/berita/';
            if (!is_dir($upload_dir)) @mkdir($upload_dir, 0755, true);

            $config = [
                'upload_path'   => $upload_dir,
                'allowed_types' => 'gif|jpg|png|jpeg|webp',
                'max_size'      => 5120,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                if (!empty($berita->gambar) && file_exists($upload_dir . $berita->gambar)) {
                    @unlink($upload_dir . $berita->gambar);
                }
                $data['gambar'] = $this->upload->data("file_name");
            } else {
                $this->session->set_flashdata('error', strip_tags($this->upload->display_errors('', '')));
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
