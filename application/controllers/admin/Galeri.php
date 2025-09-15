<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_galeri M_galeri
 * @property CI_Upload upload
 */

class Galeri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_galeri');
        // Load library upload sekali saja di constructor
        $this->load->library('upload');
    }

    public function index()
    {
        $data['title'] = "Galeri";
        $data['galeri_list'] = $this->M_galeri->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_galeri', $data);
        $this->load->view('layouts/footer');
    }

    // Buat fungsi private untuk menampung konfigurasi agar tidak duplikat
    private function _initialize_upload_config()
    {
        $config['upload_path']   = './uploads/galeri/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        // Gunakan initialize untuk memuat konfigurasi
        $this->upload->initialize($config);
    }

    public function store()
    {
        // Panggil konfigurasi
        $this->_initialize_upload_config();

        if (!$this->upload->do_upload('foto')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $upload_data = $this->upload->data();
            $data = [
                'judul_foto' => $this->input->post('judul_foto'),
                'foto'       => $upload_data['file_name'],
                'id_user'    => $this->session->userdata('id_user')
            ];
            $this->M_galeri->save($data);
            $this->session->set_flashdata('success', 'Foto berhasil ditambahkan ke galeri.');
        }
        redirect('admin/galeri');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = ['judul_foto' => $post['judul_foto']];

        if (!empty($_FILES["foto"]["name"])) {
            // Panggil konfigurasi
            $this->_initialize_upload_config();

            if ($this->upload->do_upload('foto')) {
                $galeri_lama = $this->M_galeri->get_by_id($id);
                if ($galeri_lama && file_exists('./uploads/galeri/' . $galeri_lama->foto)) {
                    unlink('./uploads/galeri/' . $galeri_lama->foto);
                }
                $data['foto'] = $this->upload->data("file_name");
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/galeri');
                return;
            }
        }

        $this->M_galeri->update($id, $data);
        $this->session->set_flashdata('success', 'Foto galeri berhasil diperbarui.');
        redirect('admin/galeri');
    }

    public function delete($id)
    {
        $galeri = $this->M_galeri->get_by_id($id);
        if ($galeri) {
            if (file_exists('./uploads/galeri/' . $galeri->foto)) {
                unlink('./uploads/galeri/' . $galeri->foto);
            }
            $this->M_galeri->delete($id);
            $this->session->set_flashdata('success', 'Foto berhasil dihapus dari galeri.');
        }
        redirect('admin/galeri');
    }
}
