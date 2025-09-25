<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_DB_query_builder db
 * @property M_domisili_yayasan M_domisili_yayasan
 * @property CI_Input input
 * @property CI_Loader load
 * @property CI_Session session
 * @property CI_URI uri
 * @property CI_Output output
 * @property CI_PDF pdf
 * @property CI_Form_validation form_validation
 * @property CI_Upload upload
 */

class Surat_domisili_yayasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_domisili_yayasan');
    }
    public function index()
    {
        $data['title'] = "Data Surat Domisili Yayasan";
        $data['list'] = $this->M_domisili_yayasan->get_all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_list', $data);
        $this->load->view('layouts/footer');
    }
    public function detail($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        $data['title'] = "Detail Surat Domisili Yayasan";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_detail', $data);
        $this->load->view('layouts/footer');
    }
    public function edit($id)
    {
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);
        $data['title'] = "Edit Surat Domisili Yayasan";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/surat_domisili_yayasan/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $rules = [
            ['field' => 'nama_penanggung_jawab', 'label' => 'Nama Penanggung Jawab', 'rules' => 'required|trim'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required|trim'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|min_length[16]|max_length[20]|numeric'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required|in_list[Laki-laki,Perempuan]'],
            ['field' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'alamat_pemohon', 'label' => 'Alamat Pemohon', 'rules' => 'required|trim'],
            ['field' => 'nama_organisasi', 'label' => 'Nama Organisasi', 'rules' => 'required|trim'],
            ['field' => 'jenis_kegiatan', 'label' => 'Jenis Kegiatan', 'rules' => 'required|trim'],
            ['field' => 'alamat_kantor', 'label' => 'Alamat Kantor', 'rules' => 'required|trim'],
            ['field' => 'jumlah_pengurus', 'label' => 'Jumlah Pengurus', 'rules' => 'required|integer'],
            ['field' => 'nama_notaris_pendirian', 'label' => 'Nama Notaris Pendirian', 'rules' => 'required|trim'],
            ['field' => 'nomor_akta_pendirian', 'label' => 'Nomor Akta Pendirian', 'rules' => 'required|trim'],
            ['field' => 'tanggal_akta_pendirian', 'label' => 'Tanggal Akta Pendirian', 'rules' => 'required|trim'],
            ['field' => 'npwp', 'label' => 'NPWP', 'rules' => 'required|trim'],
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT', 'rules' => 'required|trim'],
            ['field' => 'nomor_surat', 'label' => 'Nomor Surat', 'rules' => 'trim'],
            ['field' => 'status', 'label' => 'Status Pengajuan', 'rules' => 'required|in_list[Pending,Disetujui,Ditolak]'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'trim'], // bisa tambah numeric/regex

        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_domisili_yayasan/edit/' . $id);
        }

        $data = [
            'status'           => $this->input->post('status', true),
            'telepon_pemohon'  => $this->input->post('telepon_pemohon', true),
            'nama_penanggung_jawab' => $this->input->post('nama_penanggung_jawab', true),
            'tempat_lahir'          => $this->input->post('tempat_lahir', true),
            'tanggal_lahir'         => $this->input->post('tanggal_lahir', true),
            'nik'                   => $this->input->post('nik', true),
            'jenis_kelamin'         => $this->input->post('jenis_kelamin', true),
            'kewarganegaraan'       => $this->input->post('kewarganegaraan', true),
            'agama'                 => $this->input->post('agama', true),
            'alamat_pemohon'        => $this->input->post('alamat_pemohon', true),
            'nama_organisasi'       => $this->input->post('nama_organisasi', true),
            'jenis_kegiatan'        => $this->input->post('jenis_kegiatan', true),
            'alamat_kantor'         => $this->input->post('alamat_kantor', true),
            'jumlah_pengurus'       => (int)$this->input->post('jumlah_pengurus', true),
            'nama_notaris_pendirian' => $this->input->post('nama_notaris_pendirian', true),
            'nomor_akta_pendirian'  => $this->input->post('nomor_akta_pendirian', true),
            'tanggal_akta_pendirian' => $this->input->post('tanggal_akta_pendirian', true),
            'nama_notaris_perubahan' => $this->input->post('nama_notaris_perubahan', true) ?: null,
            'nomor_akta_perubahan'  => $this->input->post('nomor_akta_perubahan', true) ?: null,
            'tanggal_akta_perubahan' => $this->input->post('tanggal_akta_perubahan', true) ?: null,
            'npwp'                  => $this->input->post('npwp', true),
            'nomor_surat_rt'        => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'      => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'           => $this->input->post('nomor_surat', true) ?: null,
            'id_user'               => $this->session->userdata('id_user') ?: null
        ];

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
                return redirect('admin/surat_domisili_yayasan/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_domisili_yayasan', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_domisili_yayasan');
    }

    public function delete($id)
    {
        $surat = $this->M_domisili_yayasan->get_by_id($id);
        if ($surat && !empty($surat->scan_surat_rt)) {
            $path = './uploads/surat/' . $surat->scan_surat_rt;
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $this->M_domisili_yayasan->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_domisili_yayasan');
    }


    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_domisili_yayasan->get_by_id($id);

        // Redirect jika data tidak ditemukan
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_domisili_yayasan');
        }

        // =================================================================
        // LOGIKA BARU: Pengecekan Nomor Surat DAN Status
        // =================================================================
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_domisili_yayasan/edit/' . $id);
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_domisili_yayasan/edit/' . $id);
            return; // Hentikan eksekusi
        }
        // =================================================================
        // AKHIR LOGIKA BARU
        // =================================================================

        // 2. Siapkan judul dan nama file
        $data['title'] = "Cetak Surat Domisili - " . $data['surat']->nama_organisasi;
        $clean_name = preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_organisasi);
        $filename = 'Domisili-Yayasan-' . $clean_name;

        // 3. Muat view dan library PDF
        $html = $this->load->view('admin/surat_domisili_yayasan/v_cetak', $data, true);
        $this->load->library('pdf');

        // 4. Generate PDF dengan ukuran kertas F4 (sesuai permintaan)
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }
}
