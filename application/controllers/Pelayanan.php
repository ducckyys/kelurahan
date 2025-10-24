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
 * @property M_kematian $M_kematian
 * @property M_kematian_nondukcapil $M_kematian_nondukcapil
 * @property M_suami_istri $M_suami_istri
 * @property M_pengantar_nikah $M_pengantar_nikah
 */
class Pelayanan extends CI_Controller
{
    private $pendukung_dir;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form']);

        $this->load->model([
            'M_sktm',
            'M_belum_bekerja',
            'M_domisili_yayasan',
            'M_belum_memiliki_rumah',
            'M_kematian',
            'M_kematian_nondukcapil',
            'M_suami_istri',
            'M_pengantar_nikah',
        ]);

        $this->pendukung_dir = FCPATH . 'uploads/pendukung/';
        if (!is_dir($this->pendukung_dir)) {
            @mkdir($this->pendukung_dir, 0755, true);
        }
    }

    /** Helper: upload multi dokumen pendukung (return array file_name) */
    private function _upload_multiple_pendukung(bool $required = true)
    {
        if (empty($_FILES['dokumen_pendukung']['name']) || empty($_FILES['dokumen_pendukung']['name'][0])) {
            if ($required) {
                $this->session->set_flashdata('upload_error', 'Minimal 1 dokumen pendukung harus diunggah.');
                return false;
            }
            return []; // tidak wajib
        }

        $allowed = 'pdf|jpg|jpeg|png';
        $max_kb  = 2048;

        $uploaded = [];
        $files = $_FILES['dokumen_pendukung'];

        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $this->session->set_flashdata('upload_error', 'Gagal mengunggah salah satu dokumen (error code ' . $files['error'][$i] . ').');
                return false;
            }

            // Remap ke $_FILES['single']
            $_FILES['single']['name']     = $files['name'][$i];
            $_FILES['single']['type']     = $files['type'][$i];
            $_FILES['single']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['single']['error']    = $files['error'][$i];
            $_FILES['single']['size']     = $files['size'][$i];

            $config = [
                'upload_path'   => $this->pendukung_dir,
                'allowed_types' => $allowed,
                'max_size'      => $max_kb,
                'encrypt_name'  => TRUE,
            ];
            // re-init ulang setiap loop
            $this->load->library('upload');
            $this->upload->initialize($config, true);

            if (!$this->upload->do_upload('single')) {
                $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
                return false;
            }
            $data = $this->upload->data();
            $uploaded[] = $data['file_name'];
        }

        return $uploaded;
    }

    public function index()
    {
        $data['title'] = "Pelayanan Kelurahan";
        $data['cards'] = [
            ['icon' => 'bi-shield-check', 'title' => 'Surat Keterangan Tidak Mampu', 'desc' => 'Surat keterangan untuk keperluan keringanan biaya.', 'slug' => 'tidak-mampu'],
            ['icon' => 'bi-file-earmark-person', 'title' => 'Surat Ket. Belum Bekerja', 'desc' => 'Ajukan surat keterangan status belum atau tidak bekerja.', 'slug' => 'belum-bekerja'],
            ['icon' => 'bi-building', 'title' => 'Surat Domisili Yayasan', 'desc' => 'Ajukan surat keterangan domisili untuk organisasi.', 'slug' => 'domisili-yayasan'],
            ['icon' => 'bi-house', 'title' => 'Surat Belum Memiliki Rumah', 'desc' => 'Ajukan surat keterangan bahwa pemohon belum memiliki rumah.', 'slug' => 'belum-memiliki-rumah'],
            ['icon' => 'bi-person-x', 'title' => 'Surat Keterangan Kematian Dukcapil', 'desc' => 'Ajukan surat keterangan resmi tentang kematian seseorang.', 'slug' => 'kematian'],
            ['icon' => 'bi-person-x-fill', 'title' => 'Surat Kematian (Non Dukcapil)', 'desc' => 'Untuk kebutuhan non-dukcapil (bank, asuransi, dll).', 'slug' => 'kematian-nondukcapil'],
            ['icon' => 'bi-people-fill', 'title' => 'Surat Keterangan Suami Istri', 'desc' => 'Ajukan surat untuk menyatakan status hubungan pernikahan.', 'slug' => 'suami-istri'],
            ['icon' => 'bi-suit-heart',        'title' => 'Surat Pengantar Nikah',          'desc' => 'Ajukan pengantar nikah (N1): data pria, orang tua, calon istri.', 'slug' => 'pengantar-nikah'],
        ];
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_pelayanan_list', $data);
        $this->load->view('layouts_frontend/footer');
    }

    // =============================================
    // SKTM
    // =============================================
    public function tidak_mampu()
    {
        $data['title'] = "Formulir SKTM";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_sktm', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_sktm()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'rules' => 'required|trim'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'warganegara', 'label' => 'Warganegara', 'rules' => 'required|trim'],
            ['field' => 'penghasilan_bulanan', 'label' => 'Penghasilan', 'rules' => 'required'],
            ['field' => 'nama_orang_tua', 'label' => 'Nama Orang Tua', 'rules' => 'required|trim'],
            ['field' => 'id_dtks', 'label' => 'ID DTKS', 'rules' => 'trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->tidak_mampu();
        }

        // dokumen pendukung WAJIB (dulu scan_surat_rt wajib)
        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->tidak_mampu();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'      => $post['nomor_surat_rt'],
            'tanggal_surat_rt'    => $post['tanggal_surat_rt'],
            'dokumen_pendukung'   => json_encode($files),
            'nama_pemohon'        => $post['nama_pemohon'],
            'telepon_pemohon'     => $post['telepon_pemohon'],
            'tempat_lahir'        => $post['tempat_lahir'],
            'tanggal_lahir'       => $post['tanggal_lahir'],
            'nik'                 => $post['nik'],
            'jenis_kelamin'       => $post['jenis_kelamin'],
            'warganegara'         => $post['warganegara'],
            'agama'               => $post['agama'],
            'pekerjaan'           => $post['pekerjaan'],
            'nama_orang_tua'      => $post['nama_orang_tua'],
            'alamat'              => $post['alamat'],
            'id_dtks'             => $post['id_dtks'] ?: NULL,
            'penghasilan_bulanan' => $post['penghasilan_bulanan'],
            'keperluan'           => $post['keperluan'],
        ];

        $this->M_sktm->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan SKTM Anda telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // BELUM BEKERJA
    // =============================================
    public function belum_bekerja()
    {
        $data['title'] = "Formulir Surat Ket. Belum Bekerja";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_belum_bekerja', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_belum_bekerja()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'rules' => 'required|trim'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'warganegara', 'label' => 'Warganegara', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];

        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->belum_bekerja();
        }

        // dulu wajib => tetap wajib
        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->belum_bekerja();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'   => $post['nomor_surat_rt'],
            'tanggal_surat_rt' => $post['tanggal_surat_rt'],
            'dokumen_pendukung' => json_encode($files),
            'nama_pemohon'     => $post['nama_pemohon'],
            'telepon_pemohon'  => $post['telepon_pemohon'],
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

        $this->M_belum_bekerja->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Anda telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // BELUM MEMILIKI RUMAH
    // =============================================
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
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'rules' => 'required|trim'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->belum_memiliki_rumah();
        }

        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->belum_memiliki_rumah();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'   => $post['nomor_surat_rt'],
            'tanggal_surat_rt' => $post['tanggal_surat_rt'],
            'dokumen_pendukung' => json_encode($files),
            'nama_pemohon'     => $post['nama_pemohon'],
            'telepon_pemohon'  => $post['telepon_pemohon'],
            'nik'              => $post['nik'],
            'tempat_lahir'     => $post['tempat_lahir'],
            'tanggal_lahir'    => $post['tanggal_lahir'],
            'jenis_kelamin'    => $post['jenis_kelamin'],
            'kewarganegaraan'  => $post['kewarganegaraan'],
            'agama'            => $post['agama'],
            'pekerjaan'        => $post['pekerjaan'],
            'alamat'           => $post['alamat'],
            'keperluan'        => $post['keperluan'],
        ];

        $this->M_belum_memiliki_rumah->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Anda telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // DOMISILI YAYASAN
    // =============================================
    public function domisili_yayasan()
    {
        $data['title'] = "Formulir Surat Domisili Yayasan";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_domisili_yayasan', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_domisili_yayasan()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_penanggung_jawab', 'label' => 'Nama Penanggung Jawab', 'rules' => 'required|trim'],
            ['field' => 'nik', 'label' => 'NIK', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'kewarganegaraan', 'label' => 'Kewarganegaraan', 'rules' => 'required|trim'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'alamat_pemohon', 'label' => 'Alamat Pemohon', 'rules' => 'required|trim'],
            ['field' => 'nama_organisasi', 'label' => 'Nama Organisasi', 'rules' => 'required|trim'],
            ['field' => 'jenis_kegiatan', 'label' => 'Jenis Kegiatan', 'rules' => 'required|trim'],
            ['field' => 'alamat_kantor', 'label' => 'Alamat Kantor', 'rules' => 'required|trim'],
            ['field' => 'jumlah_pengurus', 'label' => 'Jumlah Pengurus', 'rules' => 'required|numeric'],
            ['field' => 'npwp', 'label' => 'NPWP', 'rules' => 'required|trim'],
            ['field' => 'nama_notaris_pendirian', 'label' => 'Nama Notaris Pendirian', 'rules' => 'required|trim'],
            ['field' => 'nomor_akta_pendirian', 'label' => 'Nomor Akta Pendirian', 'rules' => 'required|trim'],
            ['field' => 'tanggal_akta_pendirian', 'label' => 'Tanggal Akta Pendirian', 'rules' => 'required'],
            ['field' => 'nama_notaris_perubahan', 'label' => 'Nama Notaris Perubahan', 'rules' => 'trim'],
            ['field' => 'nomor_akta_perubahan', 'label' => 'Nomor Akta Perubahan', 'rules' => 'trim'],
            ['field' => 'tanggal_akta_perubahan', 'label' => 'Tanggal Akta Perubahan', 'rules' => 'trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->domisili_yayasan();
        }

        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->domisili_yayasan();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'            => $post['nomor_surat_rt'],
            'tanggal_surat_rt'          => $post['tanggal_surat_rt'],
            'dokumen_pendukung'         => json_encode($files),
            'nama_penanggung_jawab'     => $post['nama_penanggung_jawab'],
            'tempat_lahir'              => $post['tempat_lahir'],
            'tanggal_lahir'             => $post['tanggal_lahir'],
            'nik'                       => $post['nik'],
            'telepon_pemohon'           => $post['telepon_pemohon'],
            'jenis_kelamin'             => $post['jenis_kelamin'],
            'kewarganegaraan'           => $post['kewarganegaraan'],
            'agama'                     => $post['agama'],
            'alamat_pemohon'            => $post['alamat_pemohon'],
            'nama_organisasi'           => $post['nama_organisasi'],
            'jenis_kegiatan'            => $post['jenis_kegiatan'],
            'alamat_kantor'             => $post['alamat_kantor'],
            'jumlah_pengurus'           => $post['jumlah_pengurus'],
            'nama_notaris_pendirian'    => $post['nama_notaris_pendirian'],
            'nomor_akta_pendirian'      => $post['nomor_akta_pendirian'],
            'tanggal_akta_pendirian'    => $post['tanggal_akta_pendirian'],
            'nama_notaris_perubahan'    => !empty($post['nama_notaris_perubahan']) ? $post['nama_notaris_perubahan'] : NULL,
            'nomor_akta_perubahan'      => !empty($post['nomor_akta_perubahan']) ? $post['nomor_akta_perubahan'] : NULL,
            'tanggal_akta_perubahan'    => !empty($post['tanggal_akta_perubahan']) ? $post['tanggal_akta_perubahan'] : NULL,
            'npwp'                      => $post['npwp']
        ];

        $this->M_domisili_yayasan->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Surat Domisili Yayasan telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // KEMATIAN (Dukcapil) — dulu opsional → tetap opsional
    // =============================================
    public function kematian()
    {
        $data['title'] = "Formulir Surat Kematian Dukcapil";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_kematian', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_kematian()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nama', 'label' => 'Nama Almarhum/ah', 'rules' => 'required|trim'],
            ['field' => 'nik', 'label' => 'NIK Almarhum/ah', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'rules' => 'required'],
            ['field' => 'agama', 'label' => 'Agama', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan', 'label' => 'Pekerjaan', 'rules' => 'required|trim'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required|trim'],
            ['field' => 'hari_meninggal', 'label' => 'Hari Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'rules' => 'required'],
            ['field' => 'jam_meninggal', 'label' => 'Jam Meninggal', 'rules' => 'required'],
            ['field' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'rules' => 'required|trim'],
            ['field' => 'sebab_meninggal', 'label' => 'Sebab Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tempat_pemakaman', 'label' => 'Tempat Pemakaman', 'rules' => 'required|trim'],
            ['field' => 'pelapor_nama', 'label' => 'Nama Pelapor', 'rules' => 'required|trim'],
            ['field' => 'pelapor_nik', 'label' => 'NIK Pelapor', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'pelapor_no_telepon', 'label' => 'No. Telepon Pelapor', 'rules' => 'required|trim|numeric'],
            ['field' => 'pelapor_tempat_lahir', 'label' => 'Tempat Lahir Pelapor', 'rules' => 'required|trim'],
            ['field' => 'pelapor_tanggal_lahir', 'label' => 'Tanggal Lahir Pelapor', 'rules' => 'required'],
            ['field' => 'pelapor_agama', 'label' => 'Agama Pelapor', 'rules' => 'required|trim'],
            ['field' => 'pelapor_pekerjaan', 'label' => 'Pekerjaan Pelapor', 'rules' => 'required|trim'],
            ['field' => 'pelapor_alamat', 'label' => 'Alamat Pelapor', 'rules' => 'required|trim'],
            ['field' => 'pelapor_hubungan', 'label' => 'Hubungan Pelapor', 'rules' => 'required|trim'],
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->kematian();
        }

        // OPSIONAL
        $files = $this->_upload_multiple_pendukung(false);
        if ($files === false) return $this->kematian();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nama' => $post['nama'],
            'nik' => $post['nik'],
            'jenis_kelamin' => $post['jenis_kelamin'],
            'tempat_lahir' => $post['tempat_lahir'],
            'tanggal_lahir' => $post['tanggal_lahir'],
            'agama' => $post['agama'],
            'pekerjaan' => $post['pekerjaan'],
            'alamat' => $post['alamat'],
            'hari_meninggal' => $post['hari_meninggal'],
            'tanggal_meninggal' => $post['tanggal_meninggal'],
            'jam_meninggal' => $post['jam_meninggal'],
            'tempat_meninggal' => $post['tempat_meninggal'],
            'sebab_meninggal' => $post['sebab_meninggal'],
            'tempat_pemakaman' => $post['tempat_pemakaman'],
            'pelapor_nama' => $post['pelapor_nama'],
            'pelapor_tempat_lahir' => $post['pelapor_tempat_lahir'],
            'pelapor_tanggal_lahir' => $post['pelapor_tanggal_lahir'],
            'pelapor_agama' => $post['pelapor_agama'],
            'pelapor_pekerjaan' => $post['pelapor_pekerjaan'],
            'pelapor_nik' => $post['pelapor_nik'],
            'pelapor_no_telepon' => $post['pelapor_no_telepon'],
            'pelapor_alamat' => $post['pelapor_alamat'],
            'pelapor_hubungan' => $post['pelapor_hubungan'],
            'nomor_surat_rt' => !empty($post['nomor_surat_rt']) ? $post['nomor_surat_rt'] : NULL,
            'tanggal_surat_rt' => !empty($post['tanggal_surat_rt']) ? $post['tanggal_surat_rt'] : NULL,
            'dokumen_pendukung' => !empty($files) ? json_encode($files) : NULL,
        ];

        $this->M_kematian->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Surat Kematian (Dukcapil) telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // KEMATIAN NON DUKCAPIL (wajib seperti semula)
    // =============================================
    public function kematian_nondukcapil()
    {
        $data['title'] = "Formulir Surat Kematian (Non Dukcapil)";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_kematian_nondukcapil', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_kematian_nondukcapil()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_ahli_waris', 'label' => 'Nama Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'nik_ahli_waris', 'label' => 'NIK Ahli Waris', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'rules' => 'required'],
            ['field' => 'alamat_ahli_waris', 'label' => 'Alamat Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'hubungan_ahli_waris', 'label' => 'Hubungan Ahli Waris', 'rules' => 'required|trim'],
            ['field' => 'nama_almarhum', 'label' => 'Nama Almarhum/ah', 'rules' => 'required|trim'],
            ['field' => 'nik_almarhum', 'label' => 'NIK Almarhum/ah', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'keterangan_almarhum', 'label' => 'Keterangan Almarhum', 'rules' => 'required|trim'],
            ['field' => 'tempat_meninggal', 'label' => 'Tempat Meninggal', 'rules' => 'required|trim'],
            ['field' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal', 'rules' => 'required'],
            ['field' => 'alamat_almarhum', 'label' => 'Alamat Almarhum/ah', 'rules' => 'required|trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->kematian_nondukcapil();
        }

        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->kematian_nondukcapil();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'      => $post['nomor_surat_rt'],
            'tanggal_surat_rt'    => $post['tanggal_surat_rt'],
            'dokumen_pendukung'   => json_encode($files),
            'nama_ahli_waris'     => $post['nama_ahli_waris'],
            'nik_ahli_waris'      => $post['nik_ahli_waris'],
            'telepon_pemohon'     => $post['telepon_pemohon'],
            'jenis_kelamin'       => $post['jenis_kelamin'],
            'alamat_ahli_waris'   => $post['alamat_ahli_waris'],
            'hubungan_ahli_waris' => $post['hubungan_ahli_waris'],
            'nama_almarhum'       => $post['nama_almarhum'],
            'nik_almarhum'        => $post['nik_almarhum'],
            'keterangan_almarhum' => $post['keterangan_almarhum'],
            'tempat_meninggal'    => $post['tempat_meninggal'],
            'tanggal_meninggal'   => $post['tanggal_meninggal'],
            'alamat_almarhum'     => $post['alamat_almarhum'],
            'keperluan'           => $post['keperluan'],
        ];

        $this->M_kematian_nondukcapil->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Surat Kematian (Non Dukcapil) telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // =============================================
    // SUAMI ISTRI
    // =============================================
    public function suami_istri()
    {
        $data['title'] = "Formulir Surat Keterangan Suami Istri";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_suami_istri', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_suami_istri()
    {
        $this->form_validation->set_error_delimiters('', '');
        $rules = [
            ['field' => 'nomor_surat_rt', 'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],
            ['field' => 'nama_pihak_satu', 'label' => 'Nama Pemohon', 'rules' => 'required|trim'],
            ['field' => 'nik_pihak_satu', 'label' => 'NIK Pemohon', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'telepon_pemohon', 'label' => 'No. Telepon', 'rules' => 'required|trim|numeric'],
            ['field' => 'tempat_lahir_pihak_satu', 'label' => 'Tempat Lahir Pemohon', 'rules' => 'required|trim'],
            ['field' => 'tanggal_lahir_pihak_satu', 'label' => 'Tanggal Lahir Pemohon', 'rules' => 'required'],
            ['field' => 'jenis_kelamin_pihak_satu', 'label' => 'Jenis Kelamin Pemohon', 'rules' => 'required'],
            ['field' => 'agama_pihak_satu', 'label' => 'Agama Pemohon', 'rules' => 'required|trim'],
            ['field' => 'pekerjaan_pihak_satu', 'label' => 'Pekerjaan Pemohon', 'rules' => 'required|trim'],
            ['field' => 'warganegara_pihak_satu', 'label' => 'Warganegara Pemohon', 'rules' => 'required|trim'],
            ['field' => 'alamat_pihak_satu', 'label' => 'Alamat Pemohon', 'rules' => 'required|trim'],
            ['field' => 'nama_pihak_dua', 'label' => 'Nama Pasangan', 'rules' => 'required|trim'],
            ['field' => 'nik_pihak_dua', 'label' => 'NIK Pasangan', 'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'alamat_pihak_dua', 'label' => 'Alamat Pasangan', 'rules' => 'required|trim'],
            ['field' => 'keperluan', 'label' => 'Keperluan', 'rules' => 'required|trim'],
            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            return $this->suami_istri();
        }

        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->suami_istri();

        $post = $this->input->post(NULL, TRUE);
        $data_to_save = [
            'nomor_surat_rt'           => $post['nomor_surat_rt'],
            'tanggal_surat_rt'         => $post['tanggal_surat_rt'],
            'dokumen_pendukung'        => json_encode($files),
            'nama_pihak_satu'          => $post['nama_pihak_satu'],
            'nik_pihak_satu'           => $post['nik_pihak_satu'],
            'telepon_pemohon'          => $post['telepon_pemohon'],
            'tempat_lahir_pihak_satu'  => $post['tempat_lahir_pihak_satu'],
            'tanggal_lahir_pihak_satu' => $post['tanggal_lahir_pihak_satu'],
            'jenis_kelamin_pihak_satu' => $post['jenis_kelamin_pihak_satu'],
            'agama_pihak_satu'         => $post['agama_pihak_satu'],
            'pekerjaan_pihak_satu'     => $post['pekerjaan_pihak_satu'],
            'warganegara_pihak_satu'   => $post['warganegara_pihak_satu'],
            'alamat_pihak_satu'        => $post['alamat_pihak_satu'],
            'nama_pihak_dua'           => $post['nama_pihak_dua'],
            'nik_pihak_dua'            => $post['nik_pihak_dua'],
            'alamat_pihak_dua'         => $post['alamat_pihak_dua'],
            'keperluan'                => $post['keperluan'],
        ];

        $this->M_suami_istri->save($data_to_save);
        $this->session->set_flashdata('success', 'Pengajuan Surat Keterangan Suami Istri telah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    public function pengantar_nikah()
    {
        $data['title'] = "Formulir Surat Pengantar Nikah";
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_form_pengantar_nikah', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function submit_pengantar_nikah()
    {
        $this->form_validation->set_error_delimiters('', '');

        $rules = [
            // Surat pengantar RT/RW
            ['field' => 'nomor_surat_rt',   'label' => 'Nomor Surat RT/RW', 'rules' => 'required|trim'],
            ['field' => 'tanggal_surat_rt', 'label' => 'Tanggal Surat RT/RW', 'rules' => 'required'],

            // PRIA (pemohon)
            ['field' => 'pria_nama',            'label' => 'Nama Pria',            'rules' => 'required|trim'],
            ['field' => 'pria_nik',             'label' => 'NIK Pria',             'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'pria_tempat_lahir',    'label' => 'Tempat Lahir Pria',    'rules' => 'required|trim'],
            ['field' => 'pria_tanggal_lahir',   'label' => 'Tanggal Lahir Pria',   'rules' => 'required'],
            ['field' => 'pria_kewarganegaraan', 'label' => 'Kewarganegaraan Pria', 'rules' => 'required|trim'],
            ['field' => 'pria_agama',           'label' => 'Agama Pria',           'rules' => 'required|trim'],
            ['field' => 'pria_pekerjaan',       'label' => 'Pekerjaan Pria',       'rules' => 'required|trim'],
            ['field' => 'pria_alamat',          'label' => 'Alamat Pria',          'rules' => 'required|trim'],
            ['field' => 'pria_status',          'label' => 'Status Pernikahan Pria', 'rules' => 'required|in_list[Jejaka,Duda,Beristri]'],
            ['field' => 'pria_istri_ke',        'label' => 'Istri ke-',            'rules' => 'trim|integer'],

            // ORANG TUA (gabung)
            ['field' => 'ortu_nama',          'label' => 'Nama Orang Tua',  'rules' => 'required|trim'],
            ['field' => 'ortu_nik',           'label' => 'NIK Orang Tua',   'rules' => 'trim|min_length[0]|max_length[16]'],
            ['field' => 'ortu_tempat_lahir',  'label' => 'Tempat Lahir Ortu', 'rules' => 'trim'],
            ['field' => 'ortu_tanggal_lahir', 'label' => 'Tanggal Lahir Ortu', 'rules' => 'trim'],
            ['field' => 'ortu_kewarganegaraan', 'label' => 'Kewarganegaraan Ortu', 'rules' => 'trim'],
            ['field' => 'ortu_agama',         'label' => 'Agama Ortu',      'rules' => 'trim'],
            ['field' => 'ortu_pekerjaan',     'label' => 'Pekerjaan Ortu',  'rules' => 'trim'],
            ['field' => 'ortu_alamat',        'label' => 'Alamat Ortu',     'rules' => 'trim'],

            // WANITA (calon istri)
            ['field' => 'wanita_nama',            'label' => 'Nama Wanita',            'rules' => 'required|trim'],
            ['field' => 'wanita_nik',             'label' => 'NIK Wanita',             'rules' => 'required|trim|numeric|exact_length[16]'],
            ['field' => 'wanita_tempat_lahir',    'label' => 'Tempat Lahir Wanita',    'rules' => 'required|trim'],
            ['field' => 'wanita_tanggal_lahir',   'label' => 'Tanggal Lahir Wanita',   'rules' => 'required'],
            ['field' => 'wanita_kewarganegaraan', 'label' => 'Kewarganegaraan Wanita', 'rules' => 'required|trim'],
            ['field' => 'wanita_agama',           'label' => 'Agama Wanita',           'rules' => 'required|trim'],
            ['field' => 'wanita_pekerjaan',       'label' => 'Pekerjaan Wanita',       'rules' => 'required|trim'],
            ['field' => 'wanita_alamat',          'label' => 'Alamat Wanita',          'rules' => 'required|trim'],
            ['field' => 'wanita_status',          'label' => 'Status Wanita',          'rules' => 'required|in_list[Perawan,Janda]'],

            ['field' => 'agree', 'label' => 'Persetujuan', 'rules' => 'required']
        ];
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === FALSE) {
            return $this->pengantar_nikah(); // kembali ke form
        }

        // Jika status = Beristri maka "istri ke-" wajib >=1
        $status_pria = $this->input->post('pria_status', true);
        $istri_ke    = (int)$this->input->post('pria_istri_ke', true);
        if ($status_pria === 'Beristri' && $istri_ke < 1) {
            $this->session->set_flashdata('upload_error', 'Field "Istri ke-" wajib diisi jika status pria = Beristri.');
            $this->session->set_flashdata('error', 'Field "Istri ke-" wajib diisi jika status pria = Beristri.');
            return $this->pengantar_nikah();
        }

        // Multi-upload (WAJIB)
        $files = $this->_upload_multiple_pendukung(true);
        if ($files === false) return $this->pengantar_nikah();

        $p = $this->input->post(NULL, TRUE);

        $data_to_save = [
            // RT/RW
            'nomor_surat_rt'       => $p['nomor_surat_rt'],
            'tanggal_surat_rt'     => $p['tanggal_surat_rt'],

            // file JSON (TEXT)
            'dokumen_pendukung'    => json_encode($files),

            // PRIA
            'pria_nama'            => $p['pria_nama'],
            'pria_nik'             => $p['pria_nik'],
            'pria_jenis_kelamin'   => 'Laki-laki',
            'pria_tempat_lahir'    => $p['pria_tempat_lahir'],
            'pria_tanggal_lahir'   => $p['pria_tanggal_lahir'],
            'pria_kewarganegaraan' => $p['pria_kewarganegaraan'],
            'pria_agama'           => $p['pria_agama'],
            'pria_pekerjaan'       => $p['pria_pekerjaan'],
            'pria_alamat'          => $p['pria_alamat'],
            'pria_status'          => $p['pria_status'],
            'pria_istri_ke'        => ($p['pria_status'] === 'Beristri') ? $p['pria_istri_ke'] : NULL,

            // ORANG TUA (gabung)
            'ortu_nama'            => $p['ortu_nama'],
            'ortu_nik'             => $p['ortu_nik'] ?: NULL,
            'ortu_tempat_lahir'    => $p['ortu_tempat_lahir'] ?: NULL,
            'ortu_tanggal_lahir'   => $p['ortu_tanggal_lahir'] ?: NULL,
            'ortu_kewarganegaraan' => $p['ortu_kewarganegaraan'] ?: 'Indonesia',
            'ortu_agama'           => $p['ortu_agama'] ?: NULL,
            'ortu_pekerjaan'       => $p['ortu_pekerjaan'] ?: NULL,
            'ortu_alamat'          => $p['ortu_alamat'] ?: NULL,

            // WANITA
            'wanita_nama'            => $p['wanita_nama'],
            'wanita_nik'             => $p['wanita_nik'],
            'wanita_tempat_lahir'    => $p['wanita_tempat_lahir'],
            'wanita_tanggal_lahir'   => $p['wanita_tanggal_lahir'],
            'wanita_kewarganegaraan' => $p['wanita_kewarganegaraan'],
            'wanita_agama'           => $p['wanita_agama'],
            'wanita_pekerjaan'       => $p['wanita_pekerjaan'],
            'wanita_alamat'          => $p['wanita_alamat'],
            'wanita_status'          => $p['wanita_status'],

            // meta
            'id_user' => $this->session->userdata('id_user') ?: NULL,
        ];

        $this->M_pengantar_nikah->insert($data_to_save);

        $this->session->set_flashdata('success', 'Pengajuan Surat Pengantar Nikah berhasil dikirim.');
        redirect('pelayanan/sukses');
    }

    // --- SUKSES ---
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
