<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller: Surat_suami_istri
 *
 * @property M_suami_istri $M_suami_istri
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_PDF $pdf
 * @property CI_Input $input
 */

class Surat_suami_istri extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_suami_istri');

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
        $this->load->library('upload');
        $this->load->helper(['url', 'form']);
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
        if (!$data['surat']) redirect('admin/surat_suami_istri');

        $data['title'] = "Detail Pengajuan Suami Istri";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/suami_istri/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_suami_istri->get_by_id($id);
        if (!$data['surat']) redirect('admin/surat_suami_istri');

        $data['title'] = "Edit Surat Keterangan Suami Istri";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/suami_istri/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    /** === Upload multi dokumen pendukung (seperti SKTM) === */
    private function upload_multiple_from_admin()
    {
        if (
            empty($_FILES['dokumen_pendukung']['name']) ||
            empty($_FILES['dokumen_pendukung']['name'][0])
        ) {
            return []; // tidak wajib saat edit
        }

        $allowed  = 'pdf|jpg|jpeg|png';
        $max_kb   = 2048;
        $files    = $_FILES['dokumen_pendukung'];
        $count    = count($files['name']);
        $uploaded = [];

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $this->session->set_flashdata(
                    'error',
                    'Gagal unggah salah satu dokumen (error code ' . $files['error'][$i] . ').'
                );
                return false;
            }

            $_FILES['single'] = [
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ];

            $config = [
                'upload_path'   => $this->pendukung_dir,
                'allowed_types' => $allowed,
                'max_size'      => $max_kb,
                'encrypt_name'  => TRUE,
            ];
            $this->upload->initialize($config, true);

            if (!$this->upload->do_upload('single')) {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                return false;
            }
            $data       = $this->upload->data();
            $uploaded[] = $data['file_name'];
        }
        return $uploaded;
    }

    public function update($id)
    {
        // validasi singkat (sesuaikan dengan view)
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

        $this->form_validation->set_rules('nama_pihak_satu', 'Nama Pihak Pertama', 'required|trim');
        $this->form_validation->set_rules('nik_pihak_satu', 'NIK Pihak Pertama', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('alamat_pihak_satu', 'Alamat Pihak Pertama', 'required|trim');

        $this->form_validation->set_rules('nama_pihak_dua', 'Nama Pihak Kedua', 'required|trim');
        $this->form_validation->set_rules('nik_pihak_dua', 'NIK Pihak Kedua', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('alamat_pihak_dua', 'Alamat Pihak Kedua', 'required|trim');

        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        // nomor/tanggal surat RT bisa tetap dipakai (hanya metadata, bukan file)
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }

        $row = $this->M_suami_istri->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            return redirect('admin/surat_suami_istri');
        }

        // gabung lampiran lama + baru
        $existing = [];
        if (!empty($row->dokumen_pendukung)) {
            $dec = json_decode($row->dokumen_pendukung, true);
            if (is_array($dec)) $existing = $dec;
            elseif (is_string($row->dokumen_pendukung)) $existing = [$row->dokumen_pendukung];
        }

        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $post = $this->input->post(NULL, TRUE);
        $data = [
            'status'                    => $post['status'],
            'nomor_surat'               => $post['nomor_surat'] ?: NULL,

            'nama_pihak_satu'           => $post['nama_pihak_satu'],
            'nik_pihak_satu'            => $post['nik_pihak_satu'],
            'telepon_pemohon'           => $post['telepon_pemohon'] ?? null,
            'tempat_lahir_pihak_satu'   => $post['tempat_lahir_pihak_satu'] ?? null,
            'tanggal_lahir_pihak_satu'  => $post['tanggal_lahir_pihak_satu'] ?? null,
            'jenis_kelamin_pihak_satu'  => $post['jenis_kelamin_pihak_satu'] ?? null,
            'agama_pihak_satu'          => $post['agama_pihak_satu'] ?? null,
            'pekerjaan_pihak_satu'      => $post['pekerjaan_pihak_satu'] ?? null,
            'warganegara_pihak_satu'    => $post['warganegara_pihak_satu'] ?? null,
            'alamat_pihak_satu'         => $post['alamat_pihak_satu'],

            'nama_pihak_dua'            => $post['nama_pihak_dua'],
            'nik_pihak_dua'             => $post['nik_pihak_dua'],
            'alamat_pihak_dua'          => $post['alamat_pihak_dua'],

            'keperluan'                 => $post['keperluan'],

            // metadata RT (bukan file)
            'nomor_surat_rt'            => $post['nomor_surat_rt'] ?? null,
            'tanggal_surat_rt'          => $post['tanggal_surat_rt'] ?? null,

            // lampiran multi
            'dokumen_pendukung'         => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->M_suami_istri->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_suami_istri/detail/' . $id);
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_suami_istri->get_by_id($id);
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            return redirect('admin/surat_suami_istri');
        }
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            return redirect('admin/surat_suami_istri/edit/' . $id);
        }

        $data['title'] = "Cetak Surat Suami Istri - " . $data['surat']->nama_pihak_satu;
        $html = $this->load->view('admin/suami_istri/v_cetak', $data, true);

        $this->load->library('pdf');
        $filename = 'SuamiIstri-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pihak_satu);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') !== 'superadmin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            return redirect('admin/surat_suami_istri');
        }

        $row = $this->M_suami_istri->get_by_id($id);

        // hapus dokumen pendukung (JSON) di uploads/pendukung
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) $files = [$row->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $p = FCPATH . 'uploads/pendukung/' . $fn;
                    if (file_exists($p)) @unlink($p);
                }
            }
        }

        $this->M_suami_istri->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_suami_istri');
    }
}
