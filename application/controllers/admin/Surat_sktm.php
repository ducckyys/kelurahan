<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session 
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_sktm $M_sktm
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_PDF $pdf
 */

class Surat_sktm extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_sktm');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) @mkdir($this->pendukung_dir, 0755, true);
    }

    private function is_superadmin()
    {
        // konsisten dengan pengecekan di delete()
        return $this->session->userdata('id_level') === '1';
    }

    public function index()
    {
        $data['title'] = "Data Surat Keterangan Tidak Mampu (SKTM)";
        $data['list']  = $this->M_sktm->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/sktm/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_sktm');

        $data['title'] = "Detail Pengajuan SKTM";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/sktm/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_sktm');

        $data['title']          = "Edit SKTM";
        $data['can_full_edit']  = $this->is_superadmin(); // dipakai oleh view untuk disable input

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/sktm/v_edit', $data);
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
            $data        = $this->upload->data();
            $uploaded[]  = $data['file_name'];
        }
        return $uploaded;
    }

    public function update($id)
    {
        // ===== Admin biasa: boleh ubah STATUS & NOMOR SURAT saja =====
        if (!$this->is_superadmin()) {
            $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
            $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                return redirect('admin/surat_sktm/edit/' . $id);
            }

            $data = [
                'status'      => $this->input->post('status', true),
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
            ];

            $this->M_sktm->update($id, $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_sktm/detail/' . $id);
        }

        // ===== Superadmin: validasi & update penuh =====
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'trim');
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
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim');
        $this->form_validation->set_rules('penghasilan_bulanan', 'Penghasilan Bulanan', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_sktm/edit/' . $id);
        }

        $surat    = $this->M_sktm->get_by_id($id);
        $existing = [];
        if ($surat && !empty($surat->dokumen_pendukung)) {
            $decoded = json_decode($surat->dokumen_pendukung, true);
            if (is_array($decoded)) $existing = $decoded;
            elseif (is_string($surat->dokumen_pendukung)) $existing = [$surat->dokumen_pendukung];
        }

        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_sktm/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'nomor_surat_rt'       => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'     => $this->input->post('tanggal_surat_rt', true) ?: null,
            'nomor_surat'          => $this->input->post('nomor_surat', true) ?: null,
            'status'               => $this->input->post('status', true),
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
            'telepon_pemohon'      => $this->input->post('telepon_pemohon', true),
            'id_user'              => $this->session->userdata('id_user') ?: null,
            'dokumen_pendukung'    => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->M_sktm->update($id, $data);
        $this->session->set_flashdata('success', 'Data SKTM berhasil diperbarui.');
        return redirect('admin/surat_sktm/detail/' . $id);
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_sktm->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_sktm');

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            return redirect('admin/surat_sktm/edit/' . $id);
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            return redirect('admin/surat_sktm/edit/' . $id);
        }

        $data['title'] = "Cetak SKTM - " . $data['surat']->nama_pemohon;
        $html = $this->load->view('admin/sktm/v_cetak', $data, true);

        $this->load->library('pdf');
        $filename = 'SKTM-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        if (!$this->is_superadmin()) {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            return redirect('admin/surat_sktm');
        }

        $row = $this->M_sktm->get_by_id($id);
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) $files = [$row->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $path = FCPATH . 'uploads/pendukung/' . $fn;
                    if (file_exists($path)) @unlink($path);
                }
            }
        }

        $this->M_sktm->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_sktm');
    }
}
