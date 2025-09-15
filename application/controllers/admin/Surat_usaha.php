<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_izin_usaha $M_izin_usaha
 * @property CI_Input $input
 * @property CI_Session $session
 */

class Surat_usaha extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_izin_usaha');
    }

    public function index()
    {
        $data['title'] = "Data Surat Izin Usaha";
        $data['list'] = $this->M_izin_usaha->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_usaha_list', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_izin_usaha->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_usaha');
        }
        $data['title'] = "Edit Surat Izin Usaha";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_usaha_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'nama_pemohon'    => $post['nama_pemohon'],
            'nik_pemohon'     => $post['nik_pemohon'],
            'email_pemohon'   => $post['email_pemohon'],
            'alamat_domisili' => $post['alamat_domisili'],
            'nama_usaha'      => $post['nama_usaha'],
            'alamat_usaha'    => $post['alamat_usaha'],
            'id_user'         => $this->session->userdata('id_user')
        ];
        $this->M_izin_usaha->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        redirect('admin/surat_usaha');
    }

    public function delete($id)
    {
        $this->M_izin_usaha->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_usaha');
    }
}
