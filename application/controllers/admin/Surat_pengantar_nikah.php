<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_pengantar_nikah $M_pengantar_nikah
 * @property M_pejabat $M_pejabat
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_PDF $pdf
 */
class Surat_pengantar_nikah extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model(['M_pengantar_nikah', 'M_pejabat']);
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        // Direktori upload lampiran khusus pengantar nikah
        $this->pendukung_dir = FCPATH . 'uploads/nikah/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
    }

    private function is_superadmin()
    {
        return $this->session->userdata('id_level') === '1';
    }

    /* ===================== LIST / DETAIL / EDIT ===================== */

    public function index()
    {
        $data['title'] = "Data Surat Pengantar Nikah";
        $data['list']  = $this->M_pengantar_nikah->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pengantar_nikah/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_pengantar_nikah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_pengantar_nikah');

        $data['title'] = "Detail Surat Pengantar Nikah";

        // siap cetak jika nomor ada & status disetujui
        $data['bisaCetak'] = !empty($data['surat']->nomor_surat) && $data['surat']->status === 'Disetujui';

        // dropdown penandatangan
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

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pengantar_nikah/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_pengantar_nikah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_pengantar_nikah');

        $data['title']         = "Edit Surat Pengantar Nikah";
        $data['can_full_edit'] = $this->is_superadmin(); // view bisa disable input utk admin biasa

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pengantar_nikah/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    /* ===================== UPDATE (ADMIN/SUPERADMIN) ===================== */

    public function update($id)
    {
        $row = $this->M_pengantar_nikah->get_by_id($id);
        if (!$row) return redirect('admin/surat_pengantar_nikah');

        // ===== Admin biasa: boleh ubah STATUS & NOMOR SURAT saja =====
        if (!$this->is_superadmin()) {
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[Pending,Disetujui,Ditolak]');
            $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                return redirect('admin/surat_pengantar_nikah/edit/' . $id);
            }

            $data = [
                'status'      => $this->input->post('status', true),
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
            ];
            $this->M_pengantar_nikah->update($id, $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_pengantar_nikah/detail/' . $id);
        }

        // ===== Superadmin: validasi & update penuh =====
        $this->_rules();
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_pengantar_nikah/edit/' . $id);
        }

        // Jika status Beristri, istri_ke wajib diisi (>=1)
        $status_pria = $this->input->post('pria_status', true);
        $istri_ke    = (int)$this->input->post('pria_istri_ke', true);
        if ($status_pria === 'Beristri' && $istri_ke < 1) {
            $this->session->set_flashdata('error', 'Field "Istri ke-" wajib diisi jika status pria = Beristri.');
            return redirect('admin/surat_pengantar_nikah/edit/' . $id);
        }

        // Gabungkan lampiran lama + baru
        $existing = $this->M_pengantar_nikah->get_pendukung($id) ?: [];
        $newFiles = $this->upload_multiple();
        if ($newFiles === false) {
            return redirect('admin/surat_pengantar_nikah/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        // Build payload & simpan
        $payload = $this->_payload($this->input->post(NULL, TRUE), $allFiles);
        if (!$payload['dokumen_pendukung']) unset($payload['dokumen_pendukung']);
        $payload['id_user'] = $this->session->userdata('id_user') ?: $row->id_user;

        $this->M_pengantar_nikah->update($id, $payload);
        $this->session->set_flashdata('success', 'Data berhasil disimpan.');
        return redirect('admin/surat_pengantar_nikah/detail/' . $id);
    }

    /* ===================== CETAK (PDF F4 Portrait) ===================== */

    public function cetak($id)
    {
        $data['surat'] = $this->M_pengantar_nikah->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_pengantar_nikah');

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            return redirect('admin/surat_pengantar_nikah/edit/' . $id);
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            return redirect('admin/surat_pengantar_nikah/edit/' . $id);
        }

        // Identitas wilayah (sementara; bisa ambil dari settings)
        $data['kelurahan'] = 'KADEMANGAN';
        $data['kecamatan'] = 'SETU';
        $data['kota']      = 'TANGERANG SELATAN';

        // Tanggal cetak
        $data['tgl_cetak']   = $data['surat']->created_at ?: date('Y-m-d');
        $data['tanggal_ttd'] = date('d F Y');

        // Ambil penandatangan dari query ?ttd=ID (fallback ke default)
        $ttd_id = (int)$this->input->get('ttd');
        $ttd = null;
        if ($ttd_id > 0) $ttd = $this->M_pejabat->get_by_id_join($ttd_id);
        if (!$ttd)       $ttd = $this->M_pejabat->get_default_signer();
        $data['ttd'] = $ttd;

        $data['title'] = "Cetak Pengantar Nikah - " . $data['surat']->pria_nama;

        // Render HTML -> PDF
        $html = $this->load->view('admin/pengantar_nikah/v_cetak', $data, true);

        $this->load->library('pdf');
        $filename = 'Pengantar-Nikah-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->pria_nama);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    /* ===================== HAPUS ===================== */

    public function delete($id)
    {
        if (!$this->is_superadmin()) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            return redirect('admin/surat_pengantar_nikah');
        }

        $row = $this->M_pengantar_nikah->get_by_id($id);
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) $files = [$row->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $p = $this->pendukung_dir . $fn;
                    if (is_file($p)) @unlink($p);
                }
            }
        }

        $this->M_pengantar_nikah->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_pengantar_nikah');
    }

    /* ===================== UTIL: VALIDASI / PAYLOAD / UPLOAD ===================== */

    private function _rules()
    {
        // Admin fields
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[Pending,Disetujui,Ditolak]');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');

        // Pengantar RT/RW
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'required|trim');

        // Pria (pemohon)
        $this->form_validation->set_rules('pria_nama', 'Nama Pria', 'required|trim');
        $this->form_validation->set_rules('pria_nik', 'NIK Pria', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('pria_tempat_lahir', 'Tempat Lahir Pria', 'required|trim');
        $this->form_validation->set_rules('pria_tanggal_lahir', 'Tanggal Lahir Pria', 'required|trim');
        $this->form_validation->set_rules('pria_kewarganegaraan', 'Kewarganegaraan Pria', 'required|trim');
        $this->form_validation->set_rules('pria_agama', 'Agama Pria', 'required|trim');
        $this->form_validation->set_rules('pria_pekerjaan', 'Pekerjaan Pria', 'required|trim');
        $this->form_validation->set_rules('pria_alamat', 'Alamat Pria', 'required|trim');
        $this->form_validation->set_rules('pria_status', 'Status Pernikahan Pria', 'required|in_list[Jejaka,Duda,Beristri]');
        $this->form_validation->set_rules('pria_istri_ke', 'Istri ke-', 'trim|integer');

        // Orang Tua
        $this->form_validation->set_rules('ortu_nama', 'Nama Orang Tua', 'required|trim');
        $this->form_validation->set_rules('ortu_nik', 'NIK Orang Tua', 'trim|min_length[0]|max_length[16]');

        // Wanita
        $this->form_validation->set_rules('wanita_nama', 'Nama Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_nik', 'NIK Wanita', 'required|trim|min_length[16]|max_length[16]|numeric');
        $this->form_validation->set_rules('wanita_tempat_lahir', 'Tempat Lahir Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_tanggal_lahir', 'Tanggal Lahir Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_kewarganegaraan', 'Kewarganegaraan Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_agama', 'Agama Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_pekerjaan', 'Pekerjaan Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_alamat', 'Alamat Wanita', 'required|trim');
        $this->form_validation->set_rules('wanita_status', 'Status Wanita', 'required|in_list[Perawan,Janda]');
    }

    private function _payload(array $p, array $files = []): array
    {
        return [
            'status'                 => $p['status'] ?? 'Pending',
            'nomor_surat'            => $p['nomor_surat'] ?: NULL,

            'nomor_surat_rt'         => $p['nomor_surat_rt'],
            'tanggal_surat_rt'       => $p['tanggal_surat_rt'],

            'pria_nama'              => $p['pria_nama'],
            'pria_nik'               => $p['pria_nik'],
            'pria_jenis_kelamin'     => 'Laki-laki',
            'pria_tempat_lahir'      => $p['pria_tempat_lahir'],
            'pria_tanggal_lahir'     => $p['pria_tanggal_lahir'],
            'pria_kewarganegaraan'   => $p['pria_kewarganegaraan'],
            'pria_agama'             => $p['pria_agama'],
            'pria_pekerjaan'         => $p['pria_pekerjaan'],
            'pria_alamat'            => $p['pria_alamat'],
            'pria_status'            => $p['pria_status'],
            'pria_istri_ke'          => ($p['pria_status'] === 'Beristri') ? ($p['pria_istri_ke'] ?? NULL) : NULL,

            'ortu_nama'              => $p['ortu_nama'],
            'ortu_nik'               => $p['ortu_nik'] ?? NULL,
            'ortu_tempat_lahir'      => $p['ortu_tempat_lahir'] ?? NULL,
            'ortu_tanggal_lahir'     => $p['ortu_tanggal_lahir'] ?? NULL,
            'ortu_kewarganegaraan'   => $p['ortu_kewarganegaraan'] ?? 'Indonesia',
            'ortu_agama'             => $p['ortu_agama'] ?? NULL,
            'ortu_pekerjaan'         => $p['ortu_pekerjaan'] ?? NULL,
            'ortu_alamat'            => $p['ortu_alamat'] ?? NULL,

            'wanita_nama'            => $p['wanita_nama'],
            'wanita_nik'             => $p['wanita_nik'],
            'wanita_tempat_lahir'    => $p['wanita_tempat_lahir'],
            'wanita_tanggal_lahir'   => $p['wanita_tanggal_lahir'],
            'wanita_kewarganegaraan' => $p['wanita_kewarganegaraan'],
            'wanita_agama'           => $p['wanita_agama'],
            'wanita_pekerjaan'       => $p['wanita_pekerjaan'],
            'wanita_alamat'          => $p['wanita_alamat'],
            'wanita_status'          => $p['wanita_status'],

            'dokumen_pendukung'      => !empty($files) ? json_encode($files) : NULL,
        ];
    }

    /** Upload multi dokumen dari form edit admin. Return: array nama file | [] | false ketika error */
    private function upload_multiple()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return [];
        }
        $allowed  = 'pdf|jpg|jpeg|png';
        $max_kb   = 2048;
        $files    = $_FILES['dokumen_pendukung'];
        $count    = count($files['name']);
        $uploaded = [];

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
                'encrypt_name'  => true,
            ];
            $this->upload->initialize($config, true);

            if (!$this->upload->do_upload('single')) {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                return false;
            }
            $uploaded[] = $this->upload->data('file_name');
        }
        return $uploaded;
    }
}
