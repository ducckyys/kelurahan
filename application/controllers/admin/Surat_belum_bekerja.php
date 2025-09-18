<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_bekerja $M_belum_bekerja
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_pdf $pdf
 * @property CI_DB_query_builder $db
 */

class Surat_belum_bekerja extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_belum_bekerja');
    }

    public function index()
    {
        $data['title'] = "Data Surat Ket. Belum Bekerja";
        $data['list'] = $this->M_belum_bekerja->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_belum_bekerja');
        }

        $data['title'] = "Detail Surat Ket. Belum Bekerja";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_belum_bekerja');
        }
        $data['title'] = "Edit Surat Ket. Belum Bekerja";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $post = $this->input->post();
        $data = [
            'nomor_surat_rt'   => $post['nomor_surat_rt'],
            'tanggal_surat_rt' => $post['tanggal_surat_rt'],
            'nama_pemohon'     => $post['nama_pemohon'],
            'tempat_lahir'     => $post['tempat_lahir'],
            'tanggal_lahir'    => $post['tanggal_lahir'],
            'jenis_kelamin'    => $post['jenis_kelamin'],
            'nik'              => $post['nik'],
            'warganegara'      => $post['warganegara'],
            'agama'            => $post['agama'],
            'pekerjaan'        => $post['pekerjaan'],
            'alamat'           => $post['alamat'],
            'keperluan'        => $post['keperluan'],
            'id_user'          => $this->session->userdata('id_user')
        ];

        $this->M_belum_bekerja->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        redirect('admin/surat_belum_bekerja');
    }

    public function delete($id)
    {
        // Optional: Hapus file scan jika ada
        $surat = $this->M_belum_bekerja->get_by_id($id);
        if ($surat && file_exists('./uploads/surat_rt/' . $surat->scan_surat_rt)) {
            unlink('./uploads/surat_rt/' . $surat->scan_surat_rt);
        }

        $this->M_belum_bekerja->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_bekerja');
    } // FUNGSI CETAK BARU
    public function cetak($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_belum_bekerja');
        }

        $data['title'] = "Cetak Surat Ket. Belum Bekerja - " . $data['surat']->nama_pemohon;

        $this->load->library('pdf');
        // Kita panggil view baru yang akan kita buat
        $html = $this->load->view('admin/surat_belum_bekerja/v_cetak', $data, true);
        $filename = 'surat-belum-bekerja-' . $data['surat']->nik;

        // Pilih ukuran kertas A4 atau F4
        $this->pdf->generate($html, $filename, 'A4', 'portrait');
    }
}
