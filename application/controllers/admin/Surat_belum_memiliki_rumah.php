<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_memiliki_rumah $M_belum_memiliki_rumah
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_pdf $pdf
 */
class Surat_belum_memiliki_rumah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_belum_memiliki_rumah');
    }

    public function index()
    {
        $data['title'] = "Data Surat Belum Memiliki Rumah";
        $data['list']  = $this->M_belum_memiliki_rumah->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/belum_memiliki_rumah/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_belum_memiliki_rumah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_belum_memiliki_rumah');

        $data['title'] = "Detail Surat Belum Memiliki Rumah";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/belum_memiliki_rumah/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_belum_memiliki_rumah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_belum_memiliki_rumah');

        $data['title'] = "Edit Surat Belum Memiliki Rumah";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/belum_memiliki_rumah/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $row = $this->M_belum_memiliki_rumah->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            return redirect('admin/surat_belum_memiliki_rumah');
        }

        // default file lama
        $nama_file_upload = $row->scan_surat_rt;

        // jika ada file baru
        if (!empty($_FILES['scan_surat_rt']['name'])) {
            $config = [
                'upload_path'   => './uploads/surat_rt/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            if (!is_dir($config['upload_path'])) @mkdir($config['upload_path'], 0755, TRUE);
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('scan_surat_rt')) {
                $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
                return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            }

            $up = $this->upload->data();
            $nama_file_upload = $up['file_name'];

            // hapus lama
            if (!empty($row->scan_surat_rt) && file_exists(FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt)) {
                @unlink(FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt);
            }
        }

        $post = $this->input->post(NULL, TRUE);

        $data = [
            'nama_pemohon'     => $post['nama_pemohon'],
            'nik'              => $post['nik'],
            'tempat_lahir'     => $post['tempat_lahir'],
            'tanggal_lahir'    => $post['tanggal_lahir'],
            'jenis_kelamin'    => $post['jenis_kelamin'],
            'kewarganegaraan'  => $post['kewarganegaraan'] ?: 'Indonesia',
            'agama'            => $post['agama'],
            'pekerjaan'        => $post['pekerjaan'],
            'alamat'           => $post['alamat'],
            'keperluan'        => $post['keperluan'],
            'nomor_surat_rt'   => $post['nomor_surat_rt'],
            'tanggal_surat_rt' => $post['tanggal_surat_rt'],
            'scan_surat_rt'    => $nama_file_upload,
        ];

        $this->M_belum_memiliki_rumah->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        redirect('admin/surat_belum_memiliki_rumah');
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_belum_memiliki_rumah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_belum_memiliki_rumah');

        $data['title'] = "Cetak - " . $data['surat']->nama_pemohon;
        $html = $this->load->view('admin/belum_memiliki_rumah/v_cetak', $data, TRUE);

        $this->load->library('pdf');
        $filename = 'SURAT-BELUM-MEMILIKI-RUMAH-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        $row = $this->M_belum_memiliki_rumah->get_by_id($id);
        if ($row && !empty($row->scan_surat_rt) && file_exists(FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt)) {
            @unlink(FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt);
        }
        $this->M_belum_memiliki_rumah->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_memiliki_rumah');
    }
}
