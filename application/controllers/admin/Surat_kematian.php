<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_kematian $M_kematian
 * @property CI_DB_query_builder $db
 * @property CI_pdf $pdf
 */
class Surat_kematian extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_kematian');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form', 'security']);

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
    }

    public function index()
    {
        $data['title'] = "Data Surat Kematian";
        $data['list']  = $this->M_kematian->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['surat'] = $this->M_kematian->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian');

        $data['title'] = "Detail Surat Kematian";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['surat'] = $this->M_kematian->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian');

        $data['title'] = "Edit Surat Kematian";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    private function upload_multiple_from_admin()
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            return []; // opsional saat edit
        }

        $allowed   = 'pdf|jpg|jpeg|png';
        $max_kb    = 2048;
        $uploaded  = [];
        $files     = $_FILES['dokumen_pendukung'];
        $count     = count($files['name']);

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

            $data = $this->upload->data();
            $uploaded[] = $data['file_name'];
        }

        return $uploaded;
    }

    public function update($id)
    {
        $rules = [
            ['field' => 'nama', 'label' => 'Nama', 'rules' => 'required|trim'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required|in_list[Laki-laki,Perempuan]'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'hari_meninggal', 'label' => 'Hari Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'rules' => 'required|trim'],
            ['field' => 'jam_meninggal', 'label' => 'Jam Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'rules' => 'required|trim'],
            ['field' => 'sebab_meninggal', 'label' => 'Sebab Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tempat_pemakaman', 'label' => 'Tempat Pemakaman', 'rules' => 'required|trim'],

            ['field' => 'pelapor_nama', 'label' => 'Pelapor Nama', 'rules' => 'required|trim'],
            ['field' => 'pelapor_tempat_lahir', 'label' => 'Pelapor Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'pelapor_tanggal_lahir', 'label' => 'Pelapor Tanggal Lahir', 'rules' => 'required|trim'],
            ['field' => 'pelapor_agama', 'label' => 'Pelapor Agama', 'rules' => 'required|trim'],
            ['field' => 'pelapor_pekerjaan', 'label' => 'Pelapor Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'pelapor_nik', 'label' => 'Pelapor NIK', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'pelapor_no_telepon', 'label' => 'Pelapor No Telepon', 'rules' => 'required|trim'],
            ['field' => 'pelapor_alamat', 'label' => 'Pelapor Alamat', 'rules' => 'required|trim'],
            ['field' => 'pelapor_hubungan', 'label' => 'Pelapor Hubungan', 'rules' => 'required|trim'],

            // Opsional
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT', 'rules' => 'trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT', 'rules' => 'trim'],

            ['field' => 'nomor_surat', 'label' => 'Nomor Surat', 'rules' => 'trim'],
            ['field' => 'status', 'label' => 'Status Pengajuan', 'rules' => 'required|in_list[Pending,Disetujui,Ditolak]'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_kematian/edit/' . $id);
        }

        $row = $this->M_kematian->get_by_id($id);

        // Ambil lampiran lama (array filenames)
        $existing = [];
        if ($row && !empty($row->dokumen_pendukung)) {
            $dec = json_decode($row->dokumen_pendukung, true);
            if (is_array($dec)) $existing = $dec;
            else $existing = [$row->dokumen_pendukung];
        }

        // Upload baru (opsional)
        $newFiles = $this->upload_multiple_from_admin();
        if ($newFiles === false) {
            return redirect('admin/surat_kematian/edit/' . $id);
        }
        $allFiles = array_values(array_filter(array_merge($existing, $newFiles)));

        $data = [
            'nama'                 => $this->input->post('nama', true),
            'nik'                  => $this->input->post('nik', true),
            'jenis_kelamin'        => $this->input->post('jenis_kelamin', true),
            'tempat_lahir'         => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'        => $this->input->post('tanggal_lahir', true),
            'agama'                => $this->input->post('agama', true),
            'pekerjaan'            => $this->input->post('pekerjaan', true),
            'alamat'               => $this->input->post('alamat', true),

            'hari_meninggal'       => $this->input->post('hari_meninggal', true),
            'tanggal_meninggal'    => $this->input->post('tanggal_meninggal', true),
            'jam_meninggal'        => $this->input->post('jam_meninggal', true),
            'tempat_meninggal'     => $this->input->post('tempat_meninggal', true),
            'sebab_meninggal'      => $this->input->post('sebab_meninggal', true),
            'tempat_pemakaman'     => $this->input->post('tempat_pemakaman', true),

            'pelapor_nama'         => $this->input->post('pelapor_nama', true),
            'pelapor_tempat_lahir' => $this->input->post('pelapor_tempat_lahir', true),
            'pelapor_tanggal_lahir' => $this->input->post('pelapor_tanggal_lahir', true),
            'pelapor_agama'        => $this->input->post('pelapor_agama', true),
            'pelapor_pekerjaan'    => $this->input->post('pelapor_pekerjaan', true),
            'pelapor_nik'          => $this->input->post('pelapor_nik', true),
            'pelapor_no_telepon'   => $this->input->post('pelapor_no_telepon', true),
            'pelapor_alamat'       => $this->input->post('pelapor_alamat', true),
            'pelapor_hubungan'     => $this->input->post('pelapor_hubungan', true),

            'nomor_surat_rt'       => $this->input->post('nomor_surat_rt', true) ?: null,
            'tanggal_surat_rt'     => $this->input->post('tanggal_surat_rt', true) ?: null,
            'nomor_surat'          => $this->input->post('nomor_surat', true) ?: null,

            'status'               => $this->input->post('status', true),
            'id'              => $this->session->userdata('id') ?: null,

            'dokumen_pendukung'    => !empty($allFiles) ? json_encode($allFiles) : null,
        ];

        $this->db->where('id', $id)->update('surat_kematian', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_kematian/detail/' . $id);
    }

    public function cetak($id)
    {
        $data['surat'] = $this->M_kematian->get_by_id($id);
        if (!$data['surat']) return redirect('admin/surat_kematian');

        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_kematian/edit/' . $id);
            return;
        }
        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_kematian/edit/' . $id);
            return;
        }

        $data['title'] = 'Cetak Surat Keterangan Kematian - ' . $data['surat']->nama;
        $html = $this->load->view('admin/kematian/v_cetak', $data, TRUE);

        $this->load->library('pdf');
        $filename = 'SKK-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama);
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        if ($this->session->userdata('role') !== 'superadmin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya superadmin yang dapat menghapus data.');
            return redirect('admin/surat_kematian');
        }

        $row = $this->M_kematian->get_by_id($id);

        // Hapus semua lampiran dokumen_pendukung
        if ($row && !empty($row->dokumen_pendukung)) {
            $files = json_decode($row->dokumen_pendukung, true);
            if (is_string($row->dokumen_pendukung) && !is_array($files)) $files = [$row->dokumen_pendukung];
            if (is_array($files)) {
                foreach ($files as $fn) {
                    $path = $this->pendukung_dir . $fn;
                    if (is_file($path)) @unlink($path);
                }
            }
        }

        $this->M_kematian->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        return redirect('admin/surat_kematian');
    }
}
