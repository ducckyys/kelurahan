<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_kematian $M_kematian
 * @property CI_pdf $pdf
 * @property CI_DB_query_builder $db
 */

class Surat_kematian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_kematian');
    }

    public function index()
    {
        $data['title'] = "Data Surat Kematian";
        $data['list']  = $this->M_kematian->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_kematian->get_by_id($id);
        if (!$data['surat']) redirect('admin/surat_kematian');
        $data['title'] = "Detail Surat Kematian";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_kematian->get_by_id($id);

        // Redirect jika data tidak ditemukan
        if (!$data['surat']) {
            redirect('admin/surat_kematian');
        }

        // =================================================================
        // LOGIKA BARU: Pengecekan Nomor Surat DAN Status
        // =================================================================
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_kematian/edit/' . $id);
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_kematian/edit/' . $id);
            return; // Hentikan eksekusi
        }
        // =================================================================
        // AKHIR LOGIKA BARU
        // =================================================================

        $data['title'] = 'Cetak Surat Keterangan Kematian - ' . $data['surat']->nama;

        // 2. Render HTML view ke dalam sebuah variabel
        $html = $this->load->view('admin/kematian/v_cetak', $data, TRUE);

        // 3. Load library PDF dan generate file
        $this->load->library('pdf');
        $filename = 'SKK-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_kematian->get_by_id($id);
        if (!$data['surat']) redirect('admin/surat_kematian');
        $data['title'] = "Edit Surat Kematian";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $rules = [
            ['field' => 'nama', 'label' => 'Nama', 'rules' => 'required|trim'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required|in_list[Laki-laki,Perempuan]'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'hari_meninggal', 'label' => 'Hari Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'rules' => 'required|trim'],
            ['field' => 'jam_meninggal', 'label' => 'Jam Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'rules' => 'required|trim'],
            ['field' => 'sebab_meninggal', 'label' => 'Sebab Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tempat_pemakaman', 'label' => 'Tempat Pemakaman', 'rules' => 'required|trim'],

            ['field' => 'pelapor_nama', 'label' => 'Pelapor Nama', 'rules' => 'required|trim'],
            ['field' => 'pelapor_tempat_lahir', 'label' => 'Pelapor Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'pelapor_tanggal_lahir', 'label' => 'Pelapor Tanggal Lahir', 'rules' => 'required|trim'],
            ['field' => 'pelapor_agama', 'label' => 'Pelapor Agama', 'rules' => 'required|trim'],
            ['field' => 'pelapor_pekerjaan', 'label' => 'Pelapor Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'pelapor_nik', 'label' => 'Pelapor NIK', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'pelapor_no_telepon', 'label' => 'Pelapor No Telepon', 'rules' => 'required|trim'],
            ['field' => 'pelapor_alamat', 'label' => 'Pelapor Alamat', 'rules' => 'required|trim'],
            ['field' => 'pelapor_hubungan', 'label' => 'Pelapor Hubungan', 'rules' => 'required|trim'],

            // Samakan dengan view: jadikan required bila memang wajib
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT', 'rules' => 'required|trim'],

            ['field' => 'nomor_surat', 'label' => 'Nomor Surat', 'rules' => 'trim'],

            // TAMBAH INI:
            ['field' => 'status', 'label' => 'Status Pengajuan', 'rules' => 'required|in_list[Pending,Disetujui,Ditolak]'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_kematian/edit/' . $id);
        }

        $data = [
            'nama'                 => $this->input->post('nama', true),
            'nik'                  => $this->input->post('nik', true),
            'jenis_kelamin'        => $this->input->post('jenis_kelamin', true),
            'tempat_lahir'         => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'        => $this->input->post('tanggal_lahir', true),
            'agama'                => $this->input->post('agama', true),
            'pekerjaan'            => $this->input->post('pekerjaan', true),
            'alamat'               => $this->input->post('alamat', true),
            'hari_meninggal'       => $this->input->post('hari_meninggal', true),
            'tanggal_meninggal'    => $this->input->post('tanggal_meninggal', true),
            'jam_meninggal'        => $this->input->post('jam_meninggal', true),
            'tempat_meninggal'     => $this->input->post('tempat_meninggal', true),
            'sebab_meninggal'      => $this->input->post('sebab_meninggal', true),
            'tempat_pemakaman'     => $this->input->post('tempat_pemakaman', true),

            'pelapor_nama'         => $this->input->post('pelapor_nama', true),
            'pelapor_tempat_lahir' => $this->input->post('pelapor_tempat_lahir', true),
            'pelapor_tanggal_lahir' => $this->input->post('pelapor_tanggal_lahir', true),
            'pelapor_agama'        => $this->input->post('pelapor_agama', true),
            'pelapor_pekerjaan'    => $this->input->post('pelapor_pekerjaan', true),
            'pelapor_nik'          => $this->input->post('pelapor_nik', true),
            'pelapor_no_telepon'   => $this->input->post('pelapor_no_telepon', true),
            'pelapor_alamat'       => $this->input->post('pelapor_alamat', true),
            'pelapor_hubungan'     => $this->input->post('pelapor_hubungan', true),

            'nomor_surat_rt'       => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'     => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'          => $this->input->post('nomor_surat', true) ?: null,

            // TAMBAH INI:
            'status'               => $this->input->post('status', true),

            // Opsional jejak user:
            'id'              => $this->session->userdata('id') ?: null,
        ];

        if (!empty($_FILES['scan_surat_rt']['name'])) {
            $config = [
                'upload_path'   => './uploads/surat/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE
            ];
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('scan_surat_rt')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return redirect('admin/surat_kematian/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_kematian', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_kematian');
    }

    public function delete($id)
    {
        $row = $this->M_kematian->get_by_id($id);
        if ($row && !empty($row->scan_surat_rt)) {
            $path = FCPATH . 'uploads/surat/' . $row->scan_surat_rt; // sama dengan upload_path
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $this->M_kematian->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_kematian');
    }
}
