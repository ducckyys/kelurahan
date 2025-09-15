<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_berita $M_berita
 * @property CI_Pagination pagination
 * @property CI_URI uri
 */

class Berita extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_berita');
        $this->load->helper('text'); // Load text helper untuk word_limiter
    }

    // Fungsi untuk menampilkan halaman daftar semua berita
    public function index()
    {
        // Load library pagination
        $this->load->library('pagination');

        // Konfigurasi Paginasi
        $config['base_url'] = base_url('berita/index');
        $config['total_rows'] = $this->M_berita->count_all_berita();
        $config['per_page'] = 6; // Tampilkan 6 berita per halaman
        $config['uri_segment'] = 3;

        // Kustomisasi Tampilan Paginasi (menggunakan gaya Bootstrap)
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        // Inisialisasi paginasi
        $this->pagination->initialize($config);

        // Ambil nomor halaman dari URL
        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // Ambil data berita sesuai halaman
        $berita_from_db = $this->M_berita->get_all($config['per_page'], $start);
        $data['items'] = [];

        foreach ($berita_from_db as $berita) {
            $data['items'][] = [
                'image'    => base_url('uploads/berita/' . $berita->gambar),
                'date'     => $berita->tgl_publish,
                'title'    => html_escape($berita->judul_berita),
                'summary'  => word_limiter(html_escape($berita->isi_berita), 20),
                'link'     => base_url('berita/detail/' . $berita->slug_berita),
                'kategori' => html_escape($berita->kategori)
            ];
        }

        $data['title'] = "Berita Kelurahan";
        // Kirim link paginasi ke view
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_berita_list', $data);
        $this->load->view('layouts_frontend/footer');
    }

    // Tambahkan method ini di dalam class Berita
    public function detail($slug = NULL)
    {
        if ($slug === NULL) {
            redirect('berita');
        }

        $data['berita'] = $this->M_berita->get_by_slug($slug);

        if (empty($data['berita'])) {
            show_404(); // Tampilkan halaman 404 jika berita tidak ditemukan
        }

        $data['title'] = $data['berita']->judul_berita;

        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_berita_detail', $data);
        $this->load->view('layouts_frontend/footer');
    }
}
