<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_kematian_nondukcapil $M_kematian_nondukcapil
 * @property M_pejabat $M_pejabat
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_PDF $pdf
 */
class Surat_kematian_nondukcapil extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model(['M_kematian_nondukcapil', 'M_pejabat']);
        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
        $this->load->library(['upload', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    private function is_superadmin()
    {
        return $this->session->userdata('id_level') === '1';
    }

    public function index()
    {
        $data['title'] = 'Data Surat Kematian (Non Dukcapil)';
        $data['list']  = $this->M_kematian_nondukcapil->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian_nondukcapil/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_kematian_nondukcapil->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian_nondukcapil');

        $data['title'] = "Detail Surat Kematian (Non Dukcapil)";

        // status siap cetak
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
        $this->load->view('admin/kematian_nondukcapil/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_kematian_nondukcapil->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian_nondukcapil');

        $data['title']         = "Edit Surat Kematian (Non Dukcapil)";
        $data['can_full_edit'] = $this->is_superadmin();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian_nondukcapil/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    /** upload multi dokumen pendukung -> return array filename; false jika error */
    private function upload_multiple_from_admin()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return [];
        }
        $allowed = 'pdf|jpg|jpeg|png';
        $max_kb  = 2048;

        $uploaded = [];
        $files = $_FILES['dokumen_pendukung'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $this->session->set_flashdata('error', 'Gagal unggah salah satu dokumen (error code ' . $files['error'][$i] . ').');
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
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return false;
            }
            $data = $this->upload->data();
            $uploaded[] = $data['file_name'];
        }
        return $uploaded;
    }

    public function update($id)
    {
        // admin biasa: hanya status & nomor
        if (!$this->is_superadmin()) {
            $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
            $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
            }

            $data = [
                'nomor_surat' => $this->input->post('nomor_surat', true) ?: null,
                'status'      => $this->input->post('status', true),
            ];
            $this->M_kematian_nondukcapil->update($id, $data);
            $this->session->set_flashdata('success', 'Status / Nomor surat berhasil diperbarui.');
            return redirect('admin/surat_kematian_nondukcapil/detail/' . $id);
        }

        // superadmin: validasi lengkap
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT', 'trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT', 'trim');
        $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim');
        $this->form_validation->set_rules('status', 'Status Pengajuan', 'required|in_list[Pending,Disetujui,Ditolak]');

        $this->form_validation->set_rules('nama_ahli_waris', 'Nama Ahli Waris', 'required|trim');
        $this->form_validation->set_rules('nik_ahli_waris', 'NIK Ahli Waris', 'required|trim|min_length[16]|max_length[20]|numeric');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('alamat_ahli_waris', 'Alamat Ahli Waris', 'required|trim');
        $this->form_validation->set_rules('hubungan_ahli_waris', 'Hubungan Ahli Waris', 'required|trim');
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim');

        $this->form_validation->set_rules('nama_almarhum', 'Nama Almarhum/ah', 'required|trim');
        $this->form_validation->set_rules('nik_almarhum', 'NIK Almarhum/ah', 'required|trim|min_length[16]|max_length[20]|numeric');
        $this->form_validation->set_rules('tempat_meninggal', 'Tempat Meninggal', 'required|trim');
        $this->form_validation->set_rules('tanggal_meninggal', 'Tanggal Meninggal', 'required|trim');
        $this->form_validation->set_rules('alamat_almarhum', 'Alamat Almarhum/ah', 'required|trim');
        $this->form_validation->set_rules('keterangan_almarhum', 'Keterangan Almarhum/ah', 'required|trim');

        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
        }

        $surat    = $this->M_kematian_nondukcapil->get_by_id($id);

        // gabung lampiran lama + baru
        $existing = [];
        if ($surat && !empty($surat->dokumen_pendukung)) {
            $decoded = json_decode($surat->dokumen_pendukung, true);
            $existing = is_array($decoded) ? $decoded : [$surat->dokumen_pendukung];
        }
        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'nomor_surat_rt'      => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'    => $this->input->post('tanggal_surat_rt', true) ?: null,
            'nomor_surat'         => $this->input->post('nomor_surat', true) ?: null,
            'status'              => $this->input->post('status', true),

            'nama_ahli_waris'     => $this->input->post('nama_ahli_waris', true),
            'nik_ahli_waris'      => $this->input->post('nik_ahli_waris', true),
            'jenis_kelamin'       => $this->input->post('jenis_kelamin', true),
            'alamat_ahli_waris'   => $this->input->post('alamat_ahli_waris', true),
            'hubungan_ahli_waris' => $this->input->post('hubungan_ahli_waris', true),
            'telepon_pemohon'     => $this->input->post('telepon_pemohon', true),

            'nama_almarhum'       => $this->input->post('nama_almarhum', true),
            'nik_almarhum'        => $this->input->post('nik_almarhum', true),
            'tempat_meninggal'    => $this->input->post('tempat_meninggal', true),
            'tanggal_meninggal'   => $this->input->post('tanggal_meninggal', true),
            'alamat_almarhum'     => $this->input->post('alamat_almarhum', true),
            'keterangan_almarhum' => $this->input->post('keterangan_almarhum', true),

            'keperluan'           => $this->input->post('keperluan', true),

            'dokumen_pendukung'   => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->M_kematian_nondukcapil->update($id, $data);
        $this->session->set_flashdata('success', 'Data Kematian Non Dukcapil berhasil diperbarui.');
        return redirect('admin/surat_kematian_nondukcapil/detail/' . $id);
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_kematian_nondukcapil->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian_nondukcapil');

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
        }
        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
        }

        // Ambil penandatangan dari query ?ttd=ID (fallback default)
        $ttd_id = (int)$this->input->get('ttd');
        $ttd = null;
        if ($ttd_id > 0) $ttd = $this->M_pejabat->get_by_id_join($ttd_id);
        if (!$ttd) $ttd = $this->M_pejabat->get_default_signer();

        $data['ttd'] = $ttd;
        $data['tanggal_ttd'] = date('d F Y');

        $data['title'] = "Cetak Surat Kematian (Non Dukcapil) - " . $data['surat']->nama_almarhum;
        $html = $this->load->view('admin/kematian_nondukcapil/v_cetak', $data, true);
        $this->load->library('pdf');
        $filename = 'SK-Kematian-NonDukcapil-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_almarhum);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        if (!$this->is_superadmin()) {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            return redirect('admin/surat_kematian_nondukcapil');
        }

        $row = $this->M_kematian_nondukcapil->get_by_id($id);
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) $files = [$row->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $file) {
                    $path = FCPATH . 'uploads/pendukung/' . $file;
                    if (file_exists($path)) @unlink($path);
                }
            }
        }

        $this->M_kematian_nondukcapil->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_kematian_nondukcapil');
    }
}
