<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property M_domisili_yayasan $M_domisili_yayasan
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Email $email
 * @property CI_URI $uri
 * @property CI_PDF $pdf
 */
class Surat_domisili_yayasan extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_domisili_yayasan');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
    }

    private function is_superadmin()
    {
        // konsisten dengan modul lain: superadmin = id_level '1'
        return $this->session->userdata('id_level') === '1';
    }

    public function index()
    {
        $data['title'] = "Data Surat Domisili Yayasan";
        $data['list']  = $this->M_domisili_yayasan->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_domisili_yayasan');

        $data['title'] = "Detail Surat Domisili Yayasan";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_domisili_yayasan');

        $data['title']         = "Edit Surat Domisili Yayasan";
        $data['can_full_edit'] = $this->is_superadmin(); // untuk locking field di view

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    private function upload_multiple_from_admin()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return []; // optional pada edit
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
                return redirect('admin/surat_domisili_yayasan/edit/' . $id);
            }

            $data = [
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
                'status'      => $this->input->post('status', true),
            ];
            $this->db->where('id', $id)->update('surat_domisili_yayasan', $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_domisili_yayasan/detail/' . $id);
        }

        // ===== Superadmin: validasi lengkap + upload lampiran =====
        $rules = [
            ['field' => 'nama_penanggung_jawab',   'label' => 'Nama Penanggung Jawab',   'rules' => 'required|trim'],
            ['field' => 'tempat_lahir',            'label' => 'Tempat Lahir',            'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir',           'label' => 'Tanggal Lahir',           'rules' => 'required|trim'],
            ['field' => 'nik',                     'label' => 'NIK',                     'rules' => 'required|trim|min_length[16]|max_length[20]|numeric'],
            ['field' => 'jenis_kelamin',           'label' => 'Jenis Kelamin',           'rules' => 'required|in_list[Laki-laki,Perempuan]'],
            ['field' => 'kewarganegaraan',         'label' => 'Kewarganegaraan',         'rules' => 'required|trim'],
            ['field' => 'agama',                   'label' => 'Agama',                   'rules' => 'required|trim'],
            ['field' => 'alamat_pemohon',          'label' => 'Alamat Pemohon',          'rules' => 'required|trim'],
            ['field' => 'nama_organisasi',         'label' => 'Nama Organisasi',         'rules' => 'required|trim'],
            ['field' => 'jenis_kegiatan',          'label' => 'Jenis Kegiatan',          'rules' => 'required|trim'],
            ['field' => 'alamat_kantor',           'label' => 'Alamat Kantor',           'rules' => 'required|trim'],
            ['field' => 'jumlah_pengurus',         'label' => 'Jumlah Pengurus',         'rules' => 'required|integer'],
            ['field' => 'nama_notaris_pendirian',  'label' => 'Nama Notaris Pendirian',  'rules' => 'required|trim'],
            ['field' => 'nomor_akta_pendirian',    'label' => 'Nomor Akta Pendirian',    'rules' => 'required|trim'],
            ['field' => 'tanggal_akta_pendirian',  'label' => 'Tanggal Akta Pendirian',  'rules' => 'required|trim'],
            ['field' => 'npwp',                    'label' => 'NPWP',                    'rules' => 'required|trim'],
            ['field' => 'nomor_surat_rt',          'label' => 'Nomor Surat RT',          'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt',        'label' => 'Tanggal Surat RT',        'rules' => 'required|trim'],
            ['field' => 'nomor_surat',             'label' => 'Nomor Surat',             'rules' => 'trim'],
            ['field' => 'status',                  'label' => 'Status Pengajuan',        'rules' => 'required|in_list[Pending,Disetujui,Ditolak]'],
            ['field' => 'telepon_pemohon',         'label' => 'No. Telepon',             'rules' => 'trim'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_domisili_yayasan/edit/' . $id);
        }

        $row = $this->M_domisili_yayasan->get_by_id($id);

        // gabung lampiran lama + baru
        $existing = [];
        if ($row && !empty($row->dokumen_pendukung)) {
            $dec = json_decode($row->dokumen_pendukung, true);
            $existing = is_array($dec) ? $dec : [$row->dokumen_pendukung];
        }

        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_domisili_yayasan/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'status'                   => $this->input->post('status', true),
            'telepon_pemohon'          => $this->input->post('telepon_pemohon', true),
            'nama_penanggung_jawab'    => $this->input->post('nama_penanggung_jawab', true),
            'tempat_lahir'             => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'            => $this->input->post('tanggal_lahir', true),
            'nik'                      => $this->input->post('nik', true),
            'jenis_kelamin'            => $this->input->post('jenis_kelamin', true),
            'kewarganegaraan'          => $this->input->post('kewarganegaraan', true),
            'agama'                    => $this->input->post('agama', true),
            'alamat_pemohon'           => $this->input->post('alamat_pemohon', true),
            'nama_organisasi'          => $this->input->post('nama_organisasi', true),
            'jenis_kegiatan'           => $this->input->post('jenis_kegiatan', true),
            'alamat_kantor'            => $this->input->post('alamat_kantor', true),
            'jumlah_pengurus'          => (int)$this->input->post('jumlah_pengurus', true),
            'nama_notaris_pendirian'   => $this->input->post('nama_notaris_pendirian', true),
            'nomor_akta_pendirian'     => $this->input->post('nomor_akta_pendirian', true),
            'tanggal_akta_pendirian'   => $this->input->post('tanggal_akta_pendirian', true),
            'nama_notaris_perubahan'   => $this->input->post('nama_notaris_perubahan', true) ?: null,
            'nomor_akta_perubahan'     => $this->input->post('nomor_akta_perubahan', true) ?: null,
            'tanggal_akta_perubahan'   => $this->input->post('tanggal_akta_perubahan', true) ?: null,
            'npwp'                     => $this->input->post('npwp', true),
            'nomor_surat_rt'           => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'         => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'              => $this->input->post('nomor_surat', true) ?: null,
            'id_user'                  => $this->session->userdata('id_user') ?: null,
            'dokumen_pendukung'        => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->db->where('id', $id)->update('surat_domisili_yayasan', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_domisili_yayasan/detail/' . $id);
    }

    public function delete($id)
    {
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            redirect('admin/surat_domisili_yayasan');
            return;
        }

        $surat = $this->M_domisili_yayasan->get_by_id($id);
        if ($surat && !empty($surat->dokumen_pendukung)) {
            $files = json_decode($surat->dokumen_pendukung, true);
            if (is_string($surat->dokumen_pendukung) && !is_array($files)) $files = [$surat->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $path = $this->pendukung_dir . $fn;
                    if (file_exists($path)) @unlink($path);
                }
            }
        }
        $this->M_domisili_yayasan->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_domisili_yayasan');
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_domisili_yayasan');
        }

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_domisili_yayasan/edit/' . $id);
            return;
        }
        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_domisili_yayasan/edit/' . $id);
            return;
        }

        $data['title'] = "Cetak Surat Domisili - " . $data['surat']->nama_organisasi;
        $clean_name = preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_organisasi);
        $filename   = 'Domisili-Yayasan-' . $clean_name;

        $html = $this->load->view('admin/surat_domisili_yayasan/v_cetak', $data, true);
        $this->load->library('pdf');
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }
}
