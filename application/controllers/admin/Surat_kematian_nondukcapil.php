<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_kematian_nondukcapil $M_kematian_nondukcapil
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_PDF $pdf
 * @property CI_DB_query_builder $db
 */

class Surat_kematian_nondukcapil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // auth check here if you have one
        $this->load->model('M_kematian_nondukcapil');
    }

    public function index()
    {
        $data['title'] = 'Data Surat Kematian (Non Dukcapil)';
        $data['list']  = $this->M_kematian_nondukcapil->all();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian_nondukcapil/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Surat Kematian (Non Dukcapil)';
        $data['surat'] = $this->M_kematian_nondukcapil->find($id);
        if (!$data['surat']) show_404();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian_nondukcapil/v_detail', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Surat Kematian (Non Dukcapil)';
        $data['surat'] = $this->M_kematian_nondukcapil->find($id);
        if (!$data['surat']) show_404();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/kematian_nondukcapil/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
        $rules = [
            ['field' => 'nama_ahli_waris', 'label' => 'Nama Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'nik_ahli_waris', 'label' => 'NIK Ahli Waris', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required|in_list[Laki-laki,Perempuan]'],
            ['field' => 'alamat_ahli_waris', 'label' => 'Alamat Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'hubungan_ahli_waris', 'label' => 'Hubungan Ahli Waris', 'rules' => 'required|trim'],

            ['field' => 'nama_almarhum', 'label' => 'Nama Almarhum', 'rules' => 'required|trim'],
            ['field' => 'nik_almarhum', 'label' => 'NIK Almarhum', 'rules' => 'required|trim|min_length[16]|max_length[16]|numeric'],
            ['field' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'rules' => 'required|trim'],
            ['field' => 'alamat_almarhum', 'label' => 'Alamat Almarhum', 'rules' => 'required|trim'],
            ['field' => 'keterangan_almarhum', 'label' => 'Keterangan Almarhum', 'rules' => 'required|trim'],

            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT', 'rules' => 'required|trim'],
            ['field' => 'nomor_surat', 'label' => 'Nomor Surat', 'rules' => 'trim'],
            ['field' => 'status', 'label' => 'Status Pengajuan', 'rules' => 'required|in_list[Pending,Disetujui,Ditolak]'],
            ['field' => 'telepon_ahli_waris', 'label' => 'No. Telepon Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
        }

        $data = [
            'status'  => $this->input->post('status', true),
            'id' => $this->session->userdata('id_user') ?: null,
            'telepon_pemohon' => $this->input->post('telepon_ahli_waris', true),
            'keperluan'          => $this->input->post('keperluan', true),
            'nama_ahli_waris'     => $this->input->post('nama_ahli_waris', true),
            'nik_ahli_waris'      => $this->input->post('nik_ahli_waris', true),
            'jenis_kelamin'       => $this->input->post('jenis_kelamin', true),
            'alamat_ahli_waris'   => $this->input->post('alamat_ahli_waris', true),
            'hubungan_ahli_waris' => $this->input->post('hubungan_ahli_waris', true),

            'nama_almarhum'       => $this->input->post('nama_almarhum', true),
            'nik_almarhum'        => $this->input->post('nik_almarhum', true),
            'tempat_meninggal'    => $this->input->post('tempat_meninggal', true),
            'tanggal_meninggal'   => $this->input->post('tanggal_meninggal', true),
            'alamat_almarhum'     => $this->input->post('alamat_almarhum', true),
            'keterangan_almarhum' => $this->input->post('keterangan_almarhum', true) ?: null,

            'nomor_surat_rt'      => $this->input->post('nomor_surat_rt', true),
            'tanggal_surat_rt'    => $this->input->post('tanggal_surat_rt', true),
            'nomor_surat'         => $this->input->post('nomor_surat', true) ?: null,
            'status'           => $this->input->post('status', true),
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
                return redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_kematian_nondukcapil', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_kematian_nondukcapil');
    }


    public function delete($id)
    {
        $row = $this->M_kematian_nondukcapil->find($id);
        if ($row && !empty($row->scan_surat_rt)) {
            $path = FCPATH . 'uploads/surat/' . $row->scan_surat_rt; // sama dgn upload_path
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $this->M_kematian_nondukcapil->delete($id);
        $this->session->set_flashdata('success', 'Data dihapus.');
        redirect('admin/surat_kematian_nondukcapil');
    }

    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_kematian_nondukcapil->find($id);

        // Jika data tidak ditemukan, alihkan ke halaman daftar surat
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_kematian_nondukcapil');
        }

        // =================================================================
        // LOGIKA BARU: Pengecekan Nomor Surat DAN Status
        // =================================================================
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Nomor surat belum diisi.');
            redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status != 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_kematian_nondukcapil/edit/' . $id);
            return; // Hentikan eksekusi
        }
        // =================================================================
        // AKHIR LOGIKA BARU
        // =================================================================

        // 2. Siapkan judul dan nama file
        $data['title'] = 'Cetak Surat Kematian - ' . $data['surat']->nama_almarhum;
        $clean_name = preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_almarhum);
        $filename = 'Surat-Kematian-' . $clean_name . '-' . $id;

        // 3. Muat tampilan (view) cetak
        $html = $this->load->view('admin/kematian_nondukcapil/v_cetak', $data, true);

        // 4. Muat library PDF
        $this->load->library('pdf');

        // 5. Generate PDF
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }
}
