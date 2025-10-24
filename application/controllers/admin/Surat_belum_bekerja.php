<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_bekerja $M_belum_bekerja
 * @property M_pejabat $M_pejabat
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property CI_Loader $load
 * @property CI_Email $email
 * @property CI_PDF $pdf
 */
class Surat_belum_bekerja extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model(['M_belum_bekerja', 'M_pejabat']); // <== TAMBAH M_pejabat
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
        $data['title'] = "Data Surat Ket. Belum Bekerja";
        $data['list']  = $this->M_belum_bekerja->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_belum_bekerja');

        // ==== cek siap cetak ====
        $data['bisaCetak'] = true;
        if (empty($data['surat']->nomor_surat)) $data['bisaCetak'] = false;
        if ($data['surat']->status != 'Disetujui') $data['bisaCetak'] = false;

        // ==== dropdown penandatangan ====
        $signers = $this->M_pejabat->get_all_signers();
        $default = null;
        foreach ($signers as $s) {
            if ($s->jabatan_nama === 'Sekretaris Kelurahan') {
                $default = $s->id;
                break;
            }
        }
        if (!$default) {
            foreach ($signers as $s) {
                if (stripos($s->jabatan_nama, 'Lurah') === 0) {
                    $default = $s->id;
                    break;
                }
            }
        }
        $data['signers'] = $signers;
        $data['default_signer_id'] = $default;

        $data['title'] = "Detail Surat Ket. Belum Bekerja";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_belum_bekerja');

        $data['title']         = "Edit Surat Ket. Belum Bekerja";
        $data['can_full_edit'] = $this->is_superadmin();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_belum_bekerja/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    private function upload_multiple_from_admin()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return [];
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
        // Admin biasa: hanya nomor_surat & status
        if (!$this->is_superadmin()) {
            $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
            $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                return redirect('admin/surat_belum_bekerja/edit/' . $id);
            }

            $data = [
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
                'status'      => $this->input->post('status', true),
            ];
            $this->db->where('id', $id)->update('surat_belum_bekerja', $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_belum_bekerja/detail/' . $id);
        }

        // Superadmin: lengkap
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'required|trim');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim');
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

        $row = $this->M_belum_bekerja->get_by_id($id);
        $existing = [];
        if ($row && !empty($row->dokumen_pendukung)) {
            $dec = json_decode($row->dokumen_pendukung, true);
            $existing = is_array($dec) ? $dec : [$row->dokumen_pendukung];
        }

        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_belum_bekerja/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'nomor_surat_rt'   => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt' => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'      => $this->input->post('nomor_surat', true) ?: null,
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
            'dokumen_pendukung' => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->db->where('id', $id)->update('surat_belum_bekerja', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_belum_bekerja/detail/' . $id);
    }

    public function delete($id)
    {
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            redirect('admin/surat_belum_bekerja');
            return;
        }

        $surat = $this->M_belum_bekerja->get_by_id($id);
        if ($surat && !empty($surat->dokumen_pendukung)) {
            $files = json_decode($surat->dokumen_pendukung, true);
            if (is_string($surat->dokumen_pendukung) && !is_array($files)) $files = [$surat->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $path = FCPATH . 'uploads/pendukung/' . $fn;
                    if (file_exists($path)) @unlink($path);
                }
            }
        }

        $this->M_belum_bekerja->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_bekerja');
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_belum_bekerja->get_by_id($id);

        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_belum_bekerja');
        }

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_belum_bekerja/edit/' . $id);
            return;
        }
        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_belum_bekerja/edit/' . $id);
            return;
        }

        // ===== Penandatangan dari ?ttd=ID =====
        $ttd_id = (int)$this->input->get('ttd');
        $ttd = null;
        if ($ttd_id > 0) {
            $ttd = $this->M_pejabat->get_by_id_join($ttd_id);
        }
        if (!$ttd) {
            $ttd = $this->M_pejabat->get_default_signer();
        }
        $data['ttd'] = $ttd;
        $data['tanggal_ttd'] = date('d F Y');

        $data['title'] = "Cetak Surat Ket. Belum Bekerja - " . $data['surat']->nama_pemohon;
        $filename = 'surat-belum-bekerja-' . $data['surat']->nik;

        $html = $this->load->view('admin/surat_belum_bekerja/v_cetak', $data, true);
        $this->load->library('pdf');
        $this->pdf->generate($html, $filename, 'A4', 'portrait');
    }
}
