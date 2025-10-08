<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_bekerja $M_belum_bekerja
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_pdf $pdf
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property CI_upload $upload
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
        // Validasi
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'required|trim');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

        // TAMBAHAN
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim'); // bisa ditambah regex/ numeric sesuai kebutuhan

        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|min_length[16]|max_length[20]|numeric');
        $this->form_validation->set_rules('warganegara', 'Warganegara', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_belum_bekerja/edit/' . $id);
        }

        $data = [
            'nomor_surat_rt'   => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt' => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'      => $this->input->post('nomor_surat', true) ?: null,

            // TAMBAHKAN INI:
            'status'           => $this->input->post('status', true),
            'telepon_pemohon'  => $this->input->post('telepon_pemohon', true),

            'nama_pemohon'     => $this->input->post('nama_pemohon', true),
            'tempat_lahir'     => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'    => $this->input->post('tanggal_lahir', true),
            'jenis_kelamin'    => $this->input->post('jenis_kelamin', true),
            'nik'              => $this->input->post('nik', true),
            'warganegara'      => $this->input->post('warganegara', true),
            'agama'            => $this->input->post('agama', true),
            'pekerjaan'        => $this->input->post('pekerjaan', true),
            'alamat'           => $this->input->post('alamat', true),
            'keperluan'        => $this->input->post('keperluan', true),
            'id_user'          => $this->session->userdata('id_user') ?: null
        ];

        // Upload opsional
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
                return redirect('admin/surat_belum_bekerja/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_belum_bekerja', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_belum_bekerja');
    }

    public function delete($id)
    {
        // Pastikan hanya SUPERADMIN yang bisa hapus
        if ($this->session->userdata('role') !== 'superadmin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            redirect('admin/surat_sktm');
            return; // hentikan eksekusi
        }

        $surat = $this->M_belum_bekerja->get_by_id($id);
        if ($surat && !empty($surat->scan_surat_rt)) {
            $path = './uploads/surat/' . $surat->scan_surat_rt; // disamakan
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->M_belum_bekerja->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_bekerja');
    }


    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);

        // Redirect jika data tidak ditemukan
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_belum_bekerja');
        }

        // =================================================================
        // LOGIKA BARU: Pengecekan Nomor Surat DAN Status
        // =================================================================
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_belum_bekerja/edit/' . $id);
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_belum_bekerja/edit/' . $id);
            return; // Hentikan eksekusi
        }
        // =================================================================
        // AKHIR LOGIKA BARU
        // =================================================================

        // 2. Siapkan judul dan nama file
        $data['title'] = "Cetak Surat Ket. Belum Bekerja - " . $data['surat']->nama_pemohon;
        $filename = 'surat-belum-bekerja-' . $data['surat']->nik;

        // 3. Muat view dan library PDF
        $html = $this->load->view('admin/surat_belum_bekerja/v_cetak', $data, true);
        $this->load->library('pdf');

        // 4. Generate PDF
        $this->pdf->generate($html, $filename, 'A4', 'portrait');
    }
}
