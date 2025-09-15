<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_pengantar_nikah $M_pengantar_nikah
 * @property CI_Input $input
 * @property CI_Session $session
 */

class Surat_nikah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_pengantar_nikah');
    }

    public function index()
    {
        $data['title'] = "Data Surat Pengantar Nikah";
        $data['list'] = $this->M_pengantar_nikah->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_nikah_list', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_pengantar_nikah->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_nikah');
        }
        $data['title'] = "Edit Surat Pengantar Nikah";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_nikah_edit', $data);
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
            'nama_pasangan'   => $post['nama_pasangan'],
            'tanggal_nikah'   => $post['tanggal_nikah'],
            'id_user'         => $this->session->userdata('id_user')
        ];
        $this->M_pengantar_nikah->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        redirect('admin/surat_nikah');
    }

    public function delete($id)
    {
        $this->M_pengantar_nikah->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_nikah');
    }
}
