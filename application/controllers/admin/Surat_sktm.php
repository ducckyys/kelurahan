<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_sktm $M_sktm
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_pdf $pdf
 * @property CI_upload $upload
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
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
        // Validasi
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'trim'); // jika wajib: tambahkan 'required'
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');

        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|min_length[16]|max_length[20]|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('warganegara', 'Warganegara', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('nama_orang_tua', 'Nama Orang Tua', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('id_dtks', 'ID DTKS', 'trim');

        // opsional: batasi angka saja untuk telepon, atau cukup trim
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim'); // bisa tambah regex/ numeric

        $this->form_validation->set_rules('penghasilan_bulanan', 'Penghasilan Bulanan', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_sktm/edit/' . $id);
        }

        $data = [
            'nomor_surat_rt'       => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'     => $this->input->post('tanggal_surat_rt', true) ?: null,
            'nomor_surat'          => $this->input->post('nomor_surat', true) ?: null,
            'status'               => $this->input->post('status', true), // <— tambahkan

            'nama_pemohon'         => $this->input->post('nama_pemohon', true),
            'tempat_lahir'         => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'        => $this->input->post('tanggal_lahir', true),
            'nik'                  => $this->input->post('nik', true),
            'jenis_kelamin'        => $this->input->post('jenis_kelamin', true),
            'warganegara'          => $this->input->post('warganegara', true),
            'agama'                => $this->input->post('agama', true),
            'pekerjaan'            => $this->input->post('pekerjaan', true),
            'nama_orang_tua'       => $this->input->post('nama_orang_tua', true),
            'alamat'               => $this->input->post('alamat', true),
            'id_dtks'              => $this->input->post('id_dtks', true) ?: null,
            'penghasilan_bulanan'  => $this->input->post('penghasilan_bulanan', true),
            'keperluan'            => $this->input->post('keperluan', true),

            'telepon_pemohon'      => $this->input->post('telepon_pemohon', true), // <— tambahkan

            'id_user'              => $this->session->userdata('id_user') ?: null
        ];

        // Upload scan_surat_rt (opsional)
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
                return redirect('admin/surat_sktm/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_sktm', $data);
        $this->session->set_flashdata('success', 'Data SKTM berhasil diperbarui.');
        return redirect('admin/surat_sktm'); // <— konsistenkan rute
    }

    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_sktm->get_by_id($id);

        // Redirect jika data tidak ditemukan
        if (!$data['surat']) {
            redirect('admin/surat_sktm');
        }

        // =================================================================
        // LOGIKA BARU: Pengecekan Nomor Surat DAN Status
        // =================================================================
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_sktm/edit/' . $id);
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_sktm/edit/' . $id);
            return; // Hentikan eksekusi
        }
        // =================================================================
        // AKHIR LOGIKA BARU
        // =================================================================

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
