<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_sktm $M_sktm
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_pdf $pdf
 * @property CI_upload $upload
 * @property CI_DB_query_builder $db
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
        $this->load->view('admin/sktm/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_sktm');
        }

        $data['title'] = "Detail Pengajuan SKTM";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/sktm/v_detail', $data);
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
        $this->load->view('admin/sktm/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        // ambil record lama
        $row = $this->M_sktm->get_by_id($id);

        // default: pakai file lama
        $nama_file_upload = $row ? $row->scan_surat_rt : null;

        // jika user upload file baru, proses upload dan timpa
        if (!empty($_FILES['scan_surat_rt']['name'])) {
            $config['upload_path']   = './uploads/sktm/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('scan_surat_rt')) {
                $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
                redirect('admin/surat_sktm/edit/' . $id);
                return;
            }

            // sukses upload
            $up = $this->upload->data();
            $nama_file_upload = $up['file_name'];

            // (opsional) hapus file lama
            if (!empty($row->scan_surat_rt) && file_exists(FCPATH . 'uploads/sktm/' . $row->scan_surat_rt)) {
                @unlink(FCPATH . 'uploads/sktm/' . $row->scan_surat_rt);
            }
        }

        // sekarang aman dipakai di array
        $data = [
            'nomor_surat_rt'       => $this->input->post('nomor_surat_rt', TRUE),
            'tanggal_surat_rt'     => $this->input->post('tanggal_surat_rt', TRUE),
            'scan_surat_rt'        => $nama_file_upload,
            'nama_pemohon'         => $this->input->post('nama_pemohon', TRUE),
            'tempat_lahir'         => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir'        => $this->input->post('tanggal_lahir', TRUE),
            'nik'                  => $this->input->post('nik', TRUE),
            'jenis_kelamin'        => $this->input->post('jenis_kelamin', TRUE),
            'warganegara'          => $this->input->post('warganegara', TRUE) ?: 'Indonesia',
            'agama'                => $this->input->post('agama', TRUE),
            'pekerjaan'            => $this->input->post('pekerjaan', TRUE),
            'nama_orang_tua'       => $this->input->post('nama_orang_tua', TRUE),
            'alamat'               => $this->input->post('alamat', TRUE),
            'id_dtks'              => $this->input->post('id_dtks', TRUE) ?: null,
            'penghasilan_bulanan'  => $this->input->post('penghasilan_bulanan', TRUE),
            'keperluan'            => $this->input->post('keperluan', TRUE),
            'id_user'              => (int) $this->session->userdata('user_id') ?: null,
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
        $html = $this->load->view('admin/sktm/v_cetak', $data, true);

        // 3. Load library Pdf
        $this->load->library('pdf');

        // 4. Generate PDF
        $filename = 'SKTM-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        $this->M_sktm->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_sktm');
    }
}
