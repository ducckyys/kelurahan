<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_informasi M_informasi
 */

class Informasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_informasi');
    }

    public function index()
    {
        $data['title'] = "Manajemen Informasi";
        $data['informasi_list'] = $this->M_informasi->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_informasi', $data);
        $this->load->view('layouts/footer');
    }

    public function store()
    {
        $data = [
            'judul_informasi' => $this->input->post('judul_informasi'),
            'isi_informasi'   => $this->input->post('isi_informasi'),
            'kategori'        => $this->input->post('kategori'), // TAMBAHKAN INI
            'id_user'         => $this->session->userdata('id_user')
        ];

        $this->M_informasi->save($data);
        $this->session->set_flashdata('success', 'Informasi berhasil ditambahkan.');
        redirect('admin/informasi');
    }

    public function update($id)
    {
        $data = [
            'judul_informasi' => $this->input->post('judul_informasi'),
            'isi_informasi'   => $this->input->post('isi_informasi'),
            'kategori'        => $this->input->post('kategori') // TAMBAHKAN INI
        ];
        $this->M_informasi->update($id, $data);
        $this->session->set_flashdata('success', 'Informasi berhasil diperbarui.');
        redirect('admin/informasi');
    }

    public function delete($id)
    {
        $this->M_informasi->delete($id);
        $this->session->set_flashdata('success', 'Informasi berhasil dihapus.');
        redirect('admin/informasi');
    }
}
