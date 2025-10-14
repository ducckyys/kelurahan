<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_memiliki_rumah $M_belum_memiliki_rumah
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property CI_Loader $load
 * @property CI_PDF $pdf
 */
class Surat_belum_memiliki_rumah extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_belum_memiliki_rumah');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
    }

    private function is_superadmin()
    {
        return $this->session->userdata('id_level') === '1';
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

        $data['title']         = "Edit Surat Belum Memiliki Rumah";
        $data['can_full_edit'] = $this->is_superadmin();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/belum_memiliki_rumah/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    /** Upload multi dokumen dari form admin (opsional). Return array|false */
    private function upload_multiple_from_admin()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return []; // tidak wajib saat edit
        }

        $allowed  = 'pdf|jpg|jpeg|png';
        $max_kb   = 2048;
        $uploaded = [];
        $files    = $_FILES['dokumen_pendukung'];
        $count    = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $this->session->set_flashdata('error', 'Gagal unggah salah satu dokumen (error ' . $files['error'][$i] . ').');
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
        // ===== Admin biasa: hanya boleh ubah nomor_surat & status =====
        if (!$this->is_superadmin()) {
            $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
            $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            }

            $data = [
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
                'status'      => $this->input->post('status', true),
            ];

            $this->db->where('id', $id)->update('surat_belum_memiliki_rumah', $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_belum_memiliki_rumah/detail/' . $id);
        }

        // ===== Superadmin: validasi lengkap + upload lampiran =====
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'required|trim');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
        }

        // Ambil lampiran lama
        $row = $this->M_belum_memiliki_rumah->get_by_id($id);
        $existing = [];
        if ($row && !empty($row->dokumen_pendukung)) {
            $dec = json_decode($row->dokumen_pendukung, true);
            $existing = is_array($dec) ? $dec : [$row->dokumen_pendukung];
        }

        // Upload file baru (opsional)
        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'status'            => $this->input->post('status', true),
            'telepon_pemohon'   => $this->input->post('telepon_pemohon', true),
            'nama_pemohon'      => $this->input->post('nama_pemohon', true),
            'nik'               => $this->input->post('nik', true),
            'tempat_lahir'      => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'     => $this->input->post('tanggal_lahir', true),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin', true),
            'kewarganegaraan'   => $this->input->post('kewarganegaraan', true),
            'agama'             => $this->input->post('agama', true),
            'pekerjaan'         => $this->input->post('pekerjaan', true),
            'alamat'            => $this->input->post('alamat', true),
            'keperluan'         => $this->input->post('keperluan', true),
            'nomor_surat_rt'    => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'  => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'       => $this->input->post('nomor_surat', true) ?: null,
            // HAPUS field 'id' yang dulu salah set. Jangan ubah PK!
            'dokumen_pendukung' => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->db->where('id', $id)->update('surat_belum_memiliki_rumah', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_belum_memiliki_rumah/detail/' . $id);
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_belum_memiliki_rumah->get_by_id($id);

        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_belum_memiliki_rumah');
        }

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Pastikan nomor surat sudah diisi terlebih dahulu.');
            redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            return;
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            return;
        }

        $data['title'] = "Cetak - " . $data['surat']->nama_pemohon;
        $filename = 'SURAT-BELUM-MEMILIKI-RUMAH-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);

        $html = $this->load->view('admin/belum_memiliki_rumah/v_cetak', $data, TRUE);
        $this->load->library('pdf');
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            redirect('admin/surat_belum_memiliki_rumah');
            return;
        }

        $row = $this->M_belum_memiliki_rumah->get_by_id($id);
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) {
                $files = [$row->dokumen_pendukung];
            }
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $p = FCPATH . 'uploads/pendukung/' . $fn;
                    if (file_exists($p)) @unlink($p);
                }
            }
        }

        $this->M_belum_memiliki_rumah->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_memiliki_rumah');
    }
}
