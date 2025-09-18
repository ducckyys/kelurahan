<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_DB_query_builder db
 * @property M_domisili_yayasan M_domisili_yayasan
 * @property CI_Input input
 * @property CI_Loader load
 * @property CI_Session session
 * @property CI_URI uri
 * @property CI_Output output
 * @property CI_PDF pdf
 */

class Surat_domisili_yayasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_domisili_yayasan');
    }
    public function index()
    {
        $data['title'] = "Data Surat Domisili Yayasan";
        $data['list'] = $this->M_domisili_yayasan->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_list', $data);
        $this->load->view('layouts/footer');
    }
    public function detail($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        $data['title'] = "Detail Surat Domisili Yayasan";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_detail', $data);
        $this->load->view('layouts/footer');
    }
    public function edit($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        $data['title'] = "Edit Surat Domisili Yayasan";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_edit', $data);
        $this->load->view('layouts/footer');
    }
    public function update($id)
    {
        $post = $this->input->post();
        // Susun data sesuai dengan semua input di form dan kolom di database
        $data = [
            'nama_penanggung_jawab'  => $post['nama_penanggung_jawab'],
            'nik'                    => $post['nik'],
            'tempat_lahir'           => $post['tempat_lahir'],
            'tanggal_lahir'          => $post['tanggal_lahir'],
            'jenis_kelamin'          => $post['jenis_kelamin'],
            'kewarganegaraan'        => $post['kewarganegaraan'],
            'agama'                  => $post['agama'],
            'alamat_pemohon'         => $post['alamat_pemohon'],
            'nama_organisasi'        => $post['nama_organisasi'],
            'jenis_kegiatan'         => $post['jenis_kegiatan'],
            'alamat_kantor'          => $post['alamat_kantor'],
            'jumlah_pengurus'        => $post['jumlah_pengurus'],
            'nama_notaris_pendirian' => $post['nama_notaris_pendirian'],
            'nomor_akta_pendirian'   => $post['nomor_akta_pendirian'],
            'tanggal_akta_pendirian' => $post['tanggal_akta_pendirian'],
            'nama_notaris_perubahan' => !empty($post['nama_notaris_perubahan']) ? $post['nama_notaris_perubahan'] : NULL,
            'nomor_akta_perubahan'   => !empty($post['nomor_akta_perubahan']) ? $post['nomor_akta_perubahan'] : NULL,
            'tanggal_akta_perubahan' => !empty($post['tanggal_akta_perubahan']) ? $post['tanggal_akta_perubahan'] : NULL,
            'npwp'                   => $post['npwp'],
            'id_user'                => $this->session->userdata('id_user')
        ];

        $this->M_domisili_yayasan->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        redirect('admin/surat_domisili_yayasan');
    }
    public function delete($id)
    {
        $this->M_domisili_yayasan->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_domisili_yayasan');
    }
    public function cetak($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        $data['title'] = "Cetak Surat Domisili Yayasan";
        $this->load->library('pdf');
        $html = $this->load->view('admin/surat_domisili_yayasan/v_cetak', $data, true);
        $this->pdf->generate($html, 'surat-domisili-yayasan-' . $id, 'A4', 'portrait');
    }
}
