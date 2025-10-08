<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_suami_istri $M_suami_istri
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_PDF $pdf
 */
class Surat_suami_istri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Auth
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_suami_istri');
    }

    public function index()
    {
        $data['title'] = "Data Surat Keterangan Suami Istri";
        $data['list']  = $this->M_suami_istri->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/suami_istri/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_suami_istri->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_suami_istri');
        }
        $data['title'] = "Detail Pengajuan Suami Istri";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/suami_istri/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_suami_istri->get_by_id($id);
        if (!$data['surat']) {
            redirect('admin/surat_suami_istri');
        }
        $data['title'] = "Edit Surat Keterangan Suami Istri";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/suami_istri/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        // --- Validasi ---
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

        // Pihak 1
        $this->form_validation->set_rules('nama_pihak_satu', 'Nama Pihak Pertama', 'required|trim');
        $this->form_validation->set_rules('nik_pihak_satu', 'NIK Pihak Pertama', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim');
        $this->form_validation->set_rules('alamat_pihak_satu', 'Alamat Pihak Pertama', 'required|trim');

        // Opsional pihak 1 (sesuai view)
        $this->form_validation->set_rules('tempat_lahir_pihak_satu', 'Tempat Lahir Pihak Pertama', 'trim');
        $this->form_validation->set_rules('tanggal_lahir_pihak_satu', 'Tanggal Lahir Pihak Pertama', 'trim');
        $this->form_validation->set_rules('jenis_kelamin_pihak_satu', 'Jenis Kelamin Pihak Pertama', 'trim|in_list[,Laki-laki,Perempuan]');
        $this->form_validation->set_rules('agama_pihak_satu', 'Agama Pihak Pertama', 'trim');
        $this->form_validation->set_rules('pekerjaan_pihak_satu', 'Pekerjaan Pihak Pertama', 'trim');
        $this->form_validation->set_rules('warganegara_pihak_satu', 'Warganegara Pihak Pertama', 'trim');

        // Pihak 2
        $this->form_validation->set_rules('nama_pihak_dua', 'Nama Pihak Kedua', 'required|trim');
        $this->form_validation->set_rules('nik_pihak_dua', 'NIK Pihak Kedua', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('alamat_pihak_dua', 'Alamat Pihak Kedua', 'required|trim');

        // Lain-lain
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        // RT/RW (opsional, sesuai view)
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }

        // --- Ambil data sebelumnya (untuk replace file lama) ---
        $row = $this->M_suami_istri->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            return redirect('admin/surat_suami_istri');
        }

        $uploaded_filename = $row->scan_surat_rt ?: null;

        // --- Upload file (opsional) ---
        if (!empty($_FILES['scan_surat_rt']['name'])) {
            $config = [
                'upload_path'   => './uploads/surat_rt/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048, // 2MB (sesuai view)
                'encrypt_name'  => TRUE
            ];
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('scan_surat_rt')) {
                $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
                return redirect('admin/surat_suami_istri/edit/' . $id);
            }

            $up = $this->upload->data();
            $uploaded_filename = $up['file_name'];

            // Hapus file lama jika ada
            if (!empty($row->scan_surat_rt)) {
                $old = FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt;
                if (file_exists($old)) {
                    @unlink($old);
                }
            }
        }

        // --- Susun data dari POST (XSS filter TRUE) ---
        $post = $this->input->post(NULL, TRUE);

        $data = [
            'status'                    => $post['status'],
            'nomor_surat'               => !empty($post['nomor_surat']) ? $post['nomor_surat'] : NULL,

            // Pihak pertama
            'nama_pihak_satu'           => $post['nama_pihak_satu'],
            'nik_pihak_satu'            => $post['nik_pihak_satu'],
            'telepon_pemohon'           => isset($post['telepon_pemohon']) ? $post['telepon_pemohon'] : null,
            'tempat_lahir_pihak_satu'   => isset($post['tempat_lahir_pihak_satu']) ? $post['tempat_lahir_pihak_satu'] : null,
            'tanggal_lahir_pihak_satu'  => isset($post['tanggal_lahir_pihak_satu']) ? $post['tanggal_lahir_pihak_satu'] : null,
            'jenis_kelamin_pihak_satu'  => isset($post['jenis_kelamin_pihak_satu']) ? $post['jenis_kelamin_pihak_satu'] : null,
            'agama_pihak_satu'          => isset($post['agama_pihak_satu']) ? $post['agama_pihak_satu'] : null,
            'pekerjaan_pihak_satu'      => isset($post['pekerjaan_pihak_satu']) ? $post['pekerjaan_pihak_satu'] : null,
            'warganegara_pihak_satu'    => isset($post['warganegara_pihak_satu']) ? $post['warganegara_pihak_satu'] : null,
            'alamat_pihak_satu'         => $post['alamat_pihak_satu'],

            // Pihak kedua
            'nama_pihak_dua'            => $post['nama_pihak_dua'],
            'nik_pihak_dua'             => $post['nik_pihak_dua'],
            'alamat_pihak_dua'          => $post['alamat_pihak_dua'],

            // Keperluan
            'keperluan'                 => $post['keperluan'],

            // RT/RW
            'nomor_surat_rt'            => isset($post['nomor_surat_rt']) ? $post['nomor_surat_rt'] : null,
            'tanggal_surat_rt'          => isset($post['tanggal_surat_rt']) ? $post['tanggal_surat_rt'] : null,
            'scan_surat_rt'             => $uploaded_filename,

            // Audit user (opsional)
            'id'                   => $this->session->userdata('id_user') ?: null,
        ];

        // --- Update ---
        $this->M_suami_istri->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_suami_istri');
    }

    public function cetak($id)
    {
        // 1. Ambil data surat
        $data['surat'] = $this->M_suami_istri->get_by_id($id);

        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            return redirect('admin/surat_suami_istri');
        }

        // 2. Cek Nomor & Status
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }

        // 3. Render view ke HTML + generate PDF
        $data['title'] = "Cetak Surat Suami Istri - " . $data['surat']->nama_pihak_satu;
        $html = $this->load->view('admin/suami_istri/v_cetak', $data, true);

        $this->load->library('pdf');
        $filename = 'SuamiIstri-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pihak_satu);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        // Pastikan hanya SUPERADMIN yang bisa hapus
        if ($this->session->userdata('role') !== 'superadmin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            redirect('admin/surat_sktm');
            return; // hentikan eksekusi
        }

        // Hapus file upload jika ada
        $row = $this->M_suami_istri->get_by_id($id);
        if ($row && !empty($row->scan_surat_rt)) {
            $path = FCPATH . 'uploads/surat_rt/' . $row->scan_surat_rt;
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        // Hapus data
        $this->M_suami_istri->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_suami_istri');
    }
}
