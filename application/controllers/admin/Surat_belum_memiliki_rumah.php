<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_belum_memiliki_rumah $M_belum_memiliki_rumah
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_pdf $pdf
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 */
class Surat_belum_memiliki_rumah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_belum_memiliki_rumah');
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

        $data['title'] = "Edit Surat Belum Memiliki Rumah";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/belum_memiliki_rumah/v_edit', $data);
        $this->load->view('layouts/footer');
    }

    public function update($id)
    {
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
        $this->form_validation->set_rules('telepon_pemohon', 'No. Telepon', 'trim'); // bisa tambah numeric/regex sesuai kebutuhan

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
        }

        $data = [
            'status'           => $this->input->post('status', true),
            'telepon_pemohon'  => $this->input->post('telepon_pemohon', true),
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
                return redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            }
            $up = $this->upload->data();
            $data['scan_surat_rt'] = $up['file_name'];
        }

        $this->db->where('id', $id)->update('surat_belum_memiliki_rumah', $data);
        $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
        return redirect('admin/surat_belum_memiliki_rumah');
    }

    public function cetak($id)
    {
        // 1. Ambil data surat dari database
        $data['surat'] = $this->M_belum_memiliki_rumah->get_by_id($id);

        // Redirect jika data tidak ditemukan
        if (!$data['surat']) {
            $this->session->set_flashdata('error', 'Data surat tidak ditemukan.');
            redirect('admin/surat_belum_memiliki_rumah'); // Sesuaikan dengan URL Anda
        }

        // LOGIKA BARU: Cek apakah nomor surat sudah diisi sebelum mencetak
        if (empty($data['surat']->nomor_surat)) {
            $this->session->set_flashdata('error', 'Gagal cetak! Pastikan nomor surat sudah diisi terlebih dahulu.');
            redirect('admin/surat_belum_memiliki_rumah/edit/' . $id); // Arahkan ke halaman edit
            return; // Hentikan eksekusi
        }

        if ($data['surat']->status !== 'Disetujui') {
            $this->session->set_flashdata('error', 'Gagal cetak! Status surat harus "Disetujui" terlebih dahulu.');
            redirect('admin/surat_belum_memiliki_rumah/edit/' . $id);
            return;
        }

        // 2. Siapkan judul dan nama file
        $data['title'] = "Cetak - " . $data['surat']->nama_pemohon;
        $filename = 'SURAT-BELUM-MEMILIKI-RUMAH-' . preg_replace('/[^A-Za-z0-9\-]/', '', $data['surat']->nama_pemohon);

        // 3. Muat view dan library PDF
        $html = $this->load->view('admin/belum_memiliki_rumah/v_cetak', $data, TRUE);
        $this->load->library('pdf');

        // 4. Generate PDF
        $this->pdf->generate($html, $filename, 'F4', 'portrait');
    }

    public function delete($id)
    {
        $row = $this->M_belum_memiliki_rumah->get_by_id($id);
        if ($row && !empty($row->scan_surat_rt)) {
            $path = FCPATH . 'uploads/surat/' . $row->scan_surat_rt; // disamakan
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $this->M_belum_memiliki_rumah->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/surat_belum_memiliki_rumah');
    }
}
