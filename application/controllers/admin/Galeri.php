<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property M_galeri $M_galeri
 * @property CI_Upload $upload
 */
class Galeri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Proteksi login
        if ($this->session->userdata('status') !== "login") {
            redirect(base_url("login"));
        }

        // Proteksi role (hanya admin level 1)
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
        }

        $this->load->model('M_galeri');
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
    }

    private function ensure_upload_dir()
    {
        $dir = FCPATH . 'uploads/galeri/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return $dir;
    }

    private function init_upload_config()
    {
        $dir = $this->ensure_upload_dir();

        $config['upload_path']   = $dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);
    }

    // LIST
    public function index()
    {
        $data['title'] = "Galeri";
        $data['galeri_list'] = $this->M_galeri->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/galeri/index', $data);
        $this->load->view('layouts/footer');
    }

    // PAGE: TAMBAH
    public function create()
    {
        $data['title'] = "Tambah Foto Galeri";

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/galeri/tambah', $data);
        $this->load->view('layouts/footer');
    }

    // ACTION: STORE
    public function store()
    {
        $this->init_upload_config();

        if (!$this->upload->do_upload('foto')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/galeri/create');
            return;
        }

        $upload_data = $this->upload->data();
        $data = [
            'judul_foto' => $this->input->post('judul_foto', true),
            'foto'       => $upload_data['file_name'],
            'id_user'    => $this->session->userdata('id_user')
            // 'tgl_upload' => date('Y-m-d H:i:s') // aktifkan jika kolom tidak auto
        ];

        $this->M_galeri->save($data);
        $this->session->set_flashdata('success', 'Foto berhasil ditambahkan ke galeri.');
        redirect('admin/galeri');
    }

    // PAGE: EDIT
    public function edit($id)
    {
        $item = $this->M_galeri->get_by_id($id);
        if (!$item) {
            show_404();
        }

        $data['title'] = "Edit Foto Galeri";
        $data['item']  = $item;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/galeri/edit', $data);
        $this->load->view('layouts/footer');
    }

    // ACTION: UPDATE
    public function update($id)
    {
        $post = $this->input->post();
        $data = ['judul_foto' => $post['judul_foto']];

        if (!empty($_FILES['foto']['name'])) {
            $this->init_upload_config();

            if ($this->upload->do_upload('foto')) {
                $lama = $this->M_galeri->get_by_id($id);
                $dir  = FCPATH . 'uploads/galeri/';
                if ($lama && !empty($lama->foto) && file_exists($dir . $lama->foto)) {
                    @unlink($dir . $lama->foto);
                }
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/galeri/edit/' . $id);
                return;
            }
        }

        $this->M_galeri->update($id, $data);
        $this->session->set_flashdata('success', 'Foto galeri berhasil diperbarui.');
        redirect('admin/galeri');
    }

    // ACTION: DELETE
    public function delete($id)
    {
        $item = $this->M_galeri->get_by_id($id);
        if ($item) {
            $file = FCPATH . 'uploads/galeri/' . $item->foto;
            if (!empty($item->foto) && file_exists($file)) {
                @unlink($file);
            }
            $this->M_galeri->delete($id);
            $this->session->set_flashdata('success', 'Foto berhasil dihapus dari galeri.');
        }
        redirect('admin/galeri');
    }
}
