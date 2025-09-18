<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property M_sktm $M_sktm
 * @property M_belum_bekerja $M_belum_bekerja
 * @property M_domisili_yayasan $M_domisili_yayasan
 * @property M_belum_memiliki_rumah $M_belum_memiliki_rumah
 */
class Pelayanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model(['M_sktm', 'M_belum_bekerja', 'M_domisili_yayasan', 'M_belum_memiliki_rumah']);
    }

    // Menampilkan halaman utama pilihan layanan
    public function index()
    {
        $data['title'] = "Pelayanan Kelurahan";
        // Hanya tampilkan 2 layanan yang aktif
        $data['cards'] = [
            [
                'icon'  => 'bi-shield-check',
                'title' => 'Surat Keterangan Tidak Mampu',
                'desc'  => 'Surat keterangan untuk keperluan keringanan biaya.',
                'slug'  => 'tidak-mampu'
            ],
            [
                'icon'  => 'bi-file-earmark-person',
                'title' => 'Surat Ket. Belum Bekerja',
                'desc'  => 'Ajukan surat keterangan status belum atau tidak bekerja.',
                'slug'  => 'belum-bekerja'
            ],
            [
                'icon'  => 'bi-building',
                'title' => 'Surat Domisili Yayasan',
                'desc'  => 'Ajukan surat keterangan domisili untuk organisasi, yayasan, atau lembaga.',
                'slug'  => 'domisili-yayasan'
            ],
            [
                'icon'  => 'bi-house',
                'title' => 'Surat Belum Memiliki Rumah',
                'desc'  => 'Ajukan surat keterangan bahwa pemohon belum memiliki rumah.',
                'slug'  => 'belum-memiliki-rumah'
            ]
        ];
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_pelayanan_list', $data);
        $this->load->view('layouts_frontend/footer');
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
        $this->load->library('form_validation');

        // error tanpa <p> wrapper (biar cocok dengan invalid-feedback)
        $this->form_validation->set_error_delimiters('', '');

        // ===== VALIDASI: gunakan nama field BARU (match DB) =====
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'required|trim');

        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|exact_length[16]', [
            'numeric'       => '%s harus angka.',
            'exact_length'  => '%s harus 16 digit.'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');

        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('warganegara', 'Warganegara', 'required|trim');

        $this->form_validation->set_rules('penghasilan_bulanan', 'Penghasilan', 'required');
        $this->form_validation->set_rules('nama_orang_tua', 'Nama Orang Tua', 'required|trim');
        $this->form_validation->set_rules('id_dtks', 'ID DTKS', 'trim'); // opsional
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');

        $this->form_validation->set_rules('agree', 'Persetujuan', 'required', [
            'required' => 'Anda harus menyetujui pernyataan.'
        ]);

        // ===== Jika validasi gagal: kembali ke form =====
        if ($this->form_validation->run() === FALSE) {
            return $this->tidak_mampu();
        }

        // ===== Proses upload (wajib ada file) =====
        $config['upload_path']   = './uploads/surat_rt/';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->load->library('upload', $config);

        if (empty($_FILES['scan_surat_rt']['name'])) {
            $this->session->set_flashdata('upload_error', 'File surat RT/RW wajib diunggah.');
            return $this->tidak_mampu();
        }

        if (!$this->upload->do_upload('scan_surat_rt')) {
            $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
            return $this->tidak_mampu();
        }

        $upload_data = $this->upload->data();

        // ===== Siapkan data untuk disimpan (match kolom tabel) =====
        $post = $this->input->post(NULL, TRUE); // sanitasi XSS
        $data_to_save = [
            'nomor_surat_rt'      => $post['nomor_surat_rt'],
            'tanggal_surat_rt'    => $post['tanggal_surat_rt'],
            'scan_surat_rt'       => $upload_data['file_name'],

            'nama_pemohon'        => $post['nama_pemohon'],
            'tempat_lahir'        => $post['tempat_lahir'],
            'tanggal_lahir'       => $post['tanggal_lahir'],
            'nik'                 => $post['nik'],
            'jenis_kelamin'       => $post['jenis_kelamin'],
            'warganegara'         => !empty($post['warganegara']) ? $post['warganegara'] : 'Indonesia',
            'agama'               => $post['agama'],
            'pekerjaan'           => $post['pekerjaan'],
            'nama_orang_tua'      => $post['nama_orang_tua'],
            'alamat'              => $post['alamat'],

            'id_dtks'             => $post['id_dtks'] ?: NULL,
            'penghasilan_bulanan' => $post['penghasilan_bulanan'],
            'keperluan'           => $post['keperluan'],
            // 'id_user'           => (int) $this->session->userdata('user_id') ?: NULL, // kalau mau ikut simpan
        ];

        $this->load->model('M_sktm');
        $this->M_sktm->save($data_to_save);

        $this->session->set_flashdata('success', 'Pengajuan SKTM Anda telah berhasil dikirim.');
        return redirect('pelayanan/sukses');
    }

    // --- FORM BELUM BEKERJA ---
    public function belum_bekerja()
    {
        $data['title'] = "Formulir Surat Keterangan Belum Bekerja";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_belum_bekerja', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_belum_bekerja()
    {
        // Aturan validasi lengkap untuk Belum Bekerja
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'required');
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|min_length[16]|max_length[16]', ['numeric' => '%s harus angka.', 'min_length' => '%s harus 16 digit.', 'max_length' => '%s harus 16 digit.']);
        $this->form_validation->set_rules('warganegara', 'Warganegara', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required', [
            'required' => 'Anda harus menyetujui pernyataan.'
        ]);

        $config['upload_path']   = './uploads/surat_rt/';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;
        $this->load->library('upload', $config);

        if ($this->form_validation->run() == FALSE || !$this->upload->do_upload('scan_surat_rt')) {
            $data = ['title' => "Formulir Surat Keterangan Belum Bekerja"];
            if (!$this->upload->do_upload('scan_surat_rt') && !empty($_FILES['scan_surat_rt']['name'])) {
                $this->session->set_flashdata('upload_error', $this->upload->display_errors());
            }
            $this->load->view('layouts_frontend/header', $data);
            $this->load->view('pages/v_form_belum_bekerja', $data);
            $this->load->view('layouts_frontend/footer');
        } else {
            $post = $this->input->post();
            $upload_data = $this->upload->data();
            $data_to_save = [
                'nomor_surat_rt'   => $post['nomor_surat_rt'],
                'tanggal_surat_rt' => $post['tanggal_surat_rt'],
                'scan_surat_rt'    => $upload_data['file_name'],
                'nama_pemohon'     => $post['nama_pemohon'],
                'tempat_lahir'     => $post['tempat_lahir'],
                'tanggal_lahir'    => $post['tanggal_lahir'],
                'jenis_kelamin'    => $post['jenis_kelamin'],
                'nik'              => $post['nik'],
                'warganegara'      => $post['warganegara'],
                'agama'            => $post['agama'],
                'pekerjaan'        => $post['pekerjaan'],
                'alamat'           => $post['alamat'],
                'keperluan'        => $post['keperluan'],
            ];

            $this->load->model('M_belum_bekerja');
            $this->M_belum_bekerja->save($data_to_save);
            $this->session->set_flashdata('success', 'Pengajuan Anda telah berhasil dikirim.');
            redirect('pelayanan/sukses');
        }
    }

    // Method untuk menampilkan form
    public function domisili_yayasan()
    {
        $data['title'] = "Formulir Surat Domisili Yayasan";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_domisili_yayasan', $data); // Buat view ini
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_domisili_yayasan()
    {
        // Aturan validasi lengkap
        $this->form_validation->set_rules('nama_penanggung_jawab', 'Nama Penanggung Jawab', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|min_length[16]|max_length[16]', [
            'numeric' => '%s harus berupa angka.',
            'min_length' => '%s harus 16 digit.',
            'max_length' => '%s harus 16 digit.'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('alamat_pemohon', 'Alamat Pemohon', 'required|trim');
        $this->form_validation->set_rules('nama_organisasi', 'Nama Organisasi', 'required|trim');
        $this->form_validation->set_rules('jenis_kegiatan', 'Jenis Kegiatan', 'required|trim');
        $this->form_validation->set_rules('alamat_kantor', 'Alamat Kantor', 'required|trim');
        $this->form_validation->set_rules('jumlah_pengurus', 'Jumlah Pengurus', 'required|numeric', ['numeric' => '%s harus berupa angka.']);
        $this->form_validation->set_rules('nama_notaris_pendirian', 'Nama Notaris Pendirian', 'required|trim');
        $this->form_validation->set_rules('nomor_akta_pendirian', 'Nomor Akta Pendirian', 'required|trim');
        $this->form_validation->set_rules('tanggal_akta_pendirian', 'Tanggal Akta Pendirian', 'required');
        $this->form_validation->set_rules('npwp', 'NPWP', 'required|trim');
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required', [
            'required' => 'Anda harus menyetujui pernyataan.'
        ]);

        // Field akta perubahan tidak wajib, jadi hanya divalidasi 'trim' jika diisi
        $this->form_validation->set_rules('nama_notaris_perubahan', 'Nama Notaris Perubahan', 'trim');
        $this->form_validation->set_rules('nomor_akta_perubahan', 'Nomor Akta Perubahan', 'trim');
        $this->form_validation->set_rules('tanggal_akta_perubahan', 'Tanggal Akta Perubahan', 'trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form
            $this->domisili_yayasan();
        } else {
            // Jika validasi berhasil, simpan data
            $post = $this->input->post();
            $data_to_save = [
                'nama_penanggung_jawab'  => $post['nama_penanggung_jawab'],
                'tempat_lahir'           => $post['tempat_lahir'],
                'tanggal_lahir'          => $post['tanggal_lahir'],
                'nik'                    => $post['nik'],
                'jenis_kelamin'          => $post['jenis_kelamin'],
                'kewarganegaraan'        => $post['kewarganegaraan'],
                'agama'                  => $post['agama'],
                'alamat_pemohon'         => $post['alamat_pemohon'],
                'nama_organisasi'        => $post['nama_organisasi'],
                'jenis_kegiatan'         => $post['jenis_kegiatan'],
                'alamat_kantor'          => $post['alamat_kantor'],
                'jumlah_pengurus'        => $post['jumlah_pengurus'],
                'nama_notaris_pendirian' => $post['nama_notaris_pendirian'],
                'nomor_akta_pendirian'   => $post['nomor_akta_pendirian'],
                'tanggal_akta_pendirian' => $post['tanggal_akta_pendirian'],
                'nama_notaris_perubahan' => !empty($post['nama_notaris_perubahan']) ? $post['nama_notaris_perubahan'] : NULL,
                'nomor_akta_perubahan'   => !empty($post['nomor_akta_perubahan']) ? $post['nomor_akta_perubahan'] : NULL,
                'tanggal_akta_perubahan' => !empty($post['tanggal_akta_perubahan']) ? $post['tanggal_akta_perubahan'] : NULL,
                'npwp'                   => $post['npwp']
            ];

            $this->load->model('M_domisili_yayasan');
            $this->M_domisili_yayasan->save($data_to_save);
            $this->session->set_flashdata('success', 'Pengajuan Anda telah berhasil dikirim.');
            redirect('pelayanan/sukses');
        }
    }

    public function belum_memiliki_rumah()
    {
        $data['title'] = "Formulir Surat Belum Memiliki Rumah";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_belum_memiliki_rumah', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_belum_memiliki_rumah()
    {
        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|numeric|exact_length[16]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
        $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
        $this->form_validation->set_rules('nomor_surat_rt', 'Nomor Surat RT/RW', 'required|trim');
        $this->form_validation->set_rules('tanggal_surat_rt', 'Tanggal Surat RT/RW', 'required|trim');
        $this->form_validation->set_rules('agree', 'Persetujuan', 'required', [
            'required' => 'Anda harus menyetujui pernyataan.'
        ]);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');


        if ($this->form_validation->run() === FALSE) {
            return $this->belum_memiliki_rumah();
        }

        // Upload wajib
        $config = [
            'upload_path'   => './uploads/surat_rt/',
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
        ];
        if (!is_dir($config['upload_path'])) @mkdir($config['upload_path'], 0755, TRUE);
        $this->load->library('upload', $config);

        if (empty($_FILES['scan_surat_rt']['name'])) {
            $this->session->set_flashdata('upload_error', 'File surat RT/RW wajib diunggah.');
            return $this->belum_memiliki_rumah();
        }
        if (!$this->upload->do_upload('scan_surat_rt')) {
            $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
            return $this->belum_memiliki_rumah();
        }
        $up = $this->upload->data();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nama_pemohon'     => $post['nama_pemohon'],
            'nik'              => $post['nik'],
            'jenis_kelamin'    => $post['jenis_kelamin'],
            'kewarganegaraan'  => $post['kewarganegaraan'] ?: 'Indonesia',
            'agama'            => $post['agama'],
            'pekerjaan'        => $post['pekerjaan'],
            'alamat'           => $post['alamat'],
            'keperluan'        => $post['keperluan'],
            'nomor_surat_rt'   => $post['nomor_surat_rt'],
            'tanggal_surat_rt' => $post['tanggal_surat_rt'],
            'scan_surat_rt'    => $up['file_name'],
            'tempat_lahir'     => $post['tempat_lahir'],
            'tanggal_lahir'    => $post['tanggal_lahir']
        ];

        $this->load->model('M_belum_memiliki_rumah');
        $this->M_belum_memiliki_rumah->save($data_to_save);

        $this->session->set_flashdata('success', 'Pengajuan Anda telah berhasil dikirim.');
        return redirect('pelayanan/sukses');
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
