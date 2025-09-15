<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_sktm $M_sktm
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_pdf $pdf
 */

class Surat_sktm extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_sktm');
    }

    public function index()
    {
        $data['title'] = "Data Surat Keterangan Tidak Mampu (SKTM)";
        $data['list'] = $this->M_sktm->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_sktm_list', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_sktm');
        }
        $data['title'] = "Edit SKTM";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pelayanan/v_sktm_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $post = $this->input->post();
        // SUDAH DIPERBAIKI
        $data = [
            'nama_pemohon'          => $post['nama_pemohon'],
            'jenis_kelamin_pemohon' => $post['jenis_kelamin_pemohon'],
            'tempat_lahir_pemohon'  => $post['tempat_lahir_pemohon'],
            'tgl_lahir_pemohon'     => $post['tgl_lahir_pemohon'],
            'nik_pemohon'           => $post['nik_pemohon'],
            'agama_pemohon'         => $post['agama_pemohon'],
            'pekerjaan_pemohon'     => $post['pekerjaan_pemohon'],
            'alamat_pemohon'        => $post['alamat_pemohon'],
            'penghasilan_bulanan'   => $post['penghasilan_bulanan'],
            'keperluan'             => $post['keperluan'],
            'atas_nama'             => $post['atas_nama'],
            'id_user'               => $this->session->userdata('id_user')
        ];
        $this->M_sktm->update($id, $data);
        $this->session->set_flashdata('success', 'Data SKTM berhasil diperbarui.');
        redirect('admin/surat_sktm');
    }

    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_sktm');
        }

        $data['title'] = "Cetak SKTM - " . $data['surat']->nama_pemohon;

        // 2. Load view cetak ke dalam sebuah variabel
        $html = $this->load->view('admin/pelayanan/v_sktm_cetak', $data, true);

        // 3. Load library Pdf
        $this->load->library('pdf');

        // 4. Generate PDF
        $filename = 'SKTM-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);
        $this->pdf->generate($html, $filename, 'A4', 'portrait');
    }

    public function delete($id)
    {
        $this->M_sktm->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_sktm');
    }
}
