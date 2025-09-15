<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property M_izin_usaha $M_izin_usaha
 * @property M_pengantar_nikah $M_pengantar_nikah
 * @property M_sktm $M_sktm
 */
class Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Hapus M_pelayanan, kita akan load model spesifik di setiap method
        $this->load->library('form_validation');
    }

    // Menampilkan halaman utama pilihan layanan
    public function index()
    {
        $data['title'] = "Pelayanan Kelurahan";
        $data['cards'] = [
            ['icon' => 'bi-briefcase-fill', 'title' => 'Surat Izin Usaha', 'desc'  => 'Ajukan surat keterangan izin usaha...', 'slug'  => 'izin-usaha'],
            ['icon' => 'bi-heart-fill', 'title' => 'Surat Pengantar Nikah', 'desc'  => 'Dapatkan surat pengantar sebagai salah satu...', 'slug'  => 'pengantar-nikah'],
            ['icon' => 'bi-shield-check', 'title' => 'Surat Keterangan Tidak Mampu', 'desc'  => 'Surat keterangan untuk keperluan keringanan...', 'slug'  => 'tidak-mampu']
        ];
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_pelayanan_list', $data);
        $this->load->view('layouts_frontend/footer');
    }

    // --- FORM IZIN USAHA ---
    public function izin_usaha()
    {
        $data['title'] = "Formulir Surat Izin Usaha";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_izin_usaha', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_usaha()
    {
        // ... (aturan validasi tetap sama) ...
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|min_length[16]|max_length[16]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('alamat', 'Alamat Domisili', 'required|trim');
        $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required|trim');
        $this->form_validation->set_rules('alamat_usaha', 'Alamat Usaha', 'required|trim');
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->izin_usaha();
        } else {
            $post = $this->input->post();
            // PERBAIKAN: Susun data sesuai kolom tabel 'surat_izin_usaha'
            $data_to_save = [
                'nama_pemohon'    => $post['nama'],
                'nik_pemohon'     => $post['nik'],
                'email_pemohon'   => $post['email'],
                'alamat_domisili' => $post['alamat'],
                'nama_usaha'      => $post['nama_usaha'],
                'alamat_usaha'    => $post['alamat_usaha']
            ];

            // PERBAIKAN: Load & simpan ke model yang benar
            $this->load->model('M_izin_usaha');
            $this->M_izin_usaha->save($data_to_save);

            $this->session->set_flashdata('success', 'Pengajuan berhasil dikirim.');
            redirect('pelayanan/sukses');
        }
    }

    // --- FORM PENGANTAR NIKAH ---
    public function pengantar_nikah()
    {
        $data['title'] = "Formulir Surat Pengantar Nikah";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_nikah', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_nikah()
    {
        // ... (aturan validasi tetap sama) ...
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|min_length[16]|max_length[16]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('alamat', 'Alamat Domisili', 'required|trim');
        $this->form_validation->set_rules('nama_pasangan', 'Nama Pasangan', 'required|trim');
        $this->form_validation->set_rules('tanggal_nikah', 'Tanggal Pernikahan', 'required|trim');
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->pengantar_nikah();
        } else {
            $post = $this->input->post();
            // PERBAIKAN: Susun data sesuai kolom tabel 'surat_pengantar_nikah'
            $data_to_save = [
                'nama_pemohon'    => $post['nama'],
                'nik_pemohon'     => $post['nik'],
                'email_pemohon'   => $post['email'],
                'alamat_domisili' => $post['alamat'],
                'nama_pasangan'   => $post['nama_pasangan'],
                'tanggal_nikah'   => $post['tanggal_nikah']
            ];

            // PERBAIKAN: Load & simpan ke model yang benar
            $this->load->model('M_pengantar_nikah');
            $this->M_pengantar_nikah->save($data_to_save);

            $this->session->set_flashdata('success', 'Pengajuan Surat Pengantar Nikah Anda telah berhasil dikirim.');
            redirect('pelayanan/sukses');
        }
    }

    // --- FORM SKTM ---
    public function tidak_mampu()
    {
        $data['title'] = "Formulir SKTM";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_sktm', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_sktm()
    {
        // Aturan validasi baru
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin_pemohon', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat_lahir_pemohon', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir_pemohon', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nik_pemohon', 'NIK', 'required|trim|numeric|min_length[16]|max_length[16]');
        $this->form_validation->set_rules('agama_pemohon', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan_pemohon', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('alamat_pemohon', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('penghasilan_bulanan', 'Penghasilan Bulanan', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'trim'); // SUDAH DIPERBAIKI
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tidak_mampu();
        } else {
            $post = $this->input->post();
            // Susun data sesuai kolom tabel baru
            $data_to_save = [
                'nama_pemohon'          => $post['nama_pemohon'],
                'jenis_kelamin_pemohon' => $post['jenis_kelamin_pemohon'],
                'tempat_lahir_pemohon'  => $post['tempat_lahir_pemohon'],
                'tgl_lahir_pemohon'     => $post['tgl_lahir_pemohon'],
                'nik_pemohon'           => $post['nik_pemohon'],
                'agama_pemohon'         => $post['agama_pemohon'],
                'pekerjaan_pemohon'     => $post['pekerjaan_pemohon'],
                'alamat_pemohon'        => $post['alamat_pemohon'],
                'penghasilan_bulanan'   => $post['penghasilan_bulanan'],
                'keperluan'             => $post['keperluan'],
                'atas_nama'             => $post['atas_nama'] // SUDAH DIPERBAIKI
            ];

            $this->load->model('M_sktm');
            $this->M_sktm->save($data_to_save);

            $this->session->set_flashdata('success', 'Pengajuan SKTM Anda telah berhasil dikirim.');
            redirect('pelayanan/sukses');
        }
    }

    // --- HALAMAN SUKSES ---
    public function sukses()
    {
        if (empty($this->session->flashdata('success'))) {
            redirect('pelayanan');
        }
        $data['title'] = "Pengajuan Berhasil";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_pengajuan_sukses', $data);
        $this->load->view('layouts_frontend/footer');
    }
}
