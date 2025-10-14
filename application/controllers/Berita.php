<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_berita $M_berita
 * @property CI_Pagination $pagination
 * @property CI_URI $uri
 */
class Berita extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_berita');
        $this->load->helper(['url', 'text']); // +url kalau belum autoload
        $this->load->library('pagination');
    }

    // LIST
    public function index()
    {
        // Konfigurasi Paginasi
        $config['base_url']    = base_url('berita/index');
        $config['total_rows']  = $this->M_berita->count_all_berita();
        $config['per_page']    = 6;
        $config['uri_segment'] = 3;

        // Bootstrap pager
        $config['full_tag_open']  = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link']     = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link']      = 'Last';
        $config['last_tag_open']  = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link']      = '&raquo';
        $config['next_tag_open']  = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link']      = '&laquo';
        $config['prev_tag_open']  = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open']   = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']  = '</a></li>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $start = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;

        // Ambil data (model sudah JOIN user.nama_lengkap)
        $berita_from_db = $this->M_berita->get_all($config['per_page'], $start);

        // Map ke struktur yang dipakai view
        $data['items'] = array_map(function ($b) {
            return [
                'image'    => base_url('uploads/berita/' . ($b->gambar ?? '')),
                'date'     => $b->tgl_publish ?? null,
                'title'    => $b->judul_berita ?? '',
                'summary'  => $b->isi_berita ?? '',        // RAW RTE → dipotong di view dengan helper
                'link'     => site_url('berita/detail/' . $b->slug_berita),
                'kategori' => $b->kategori ?? '',
                'author'   => $b->nama_lengkap ?? 'Admin Kelurahan', // ← TAMBAHAN
            ];
        }, $berita_from_db);

        $data['title']      = 'Berita Kelurahan';
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_berita_list', $data);
        $this->load->view('layouts_frontend/footer');
    }

    // DETAIL
    public function detail($slug = null)
    {
        if ($slug === null) {
            redirect('berita');
        }

        $data['berita'] = $this->M_berita->get_by_slug($slug);
        if (empty($data['berita'])) {
            show_404();
        }

        // Sidebar: terkait & terbaru (butuh method baru di model; lihat di bawah)
        $data['related'] = $this->M_berita->get_related_by_category(
            $data['berita']->kategori ?? '',
            $data['berita']->id_berita ?? null,
            5
        );
        $data['latest']  = $this->M_berita->get_latest_except(
            $data['berita']->id_berita ?? null,
            5
        );

        $data['title'] = $data['berita']->judul_berita;

        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_berita_detail', $data);
        $this->load->view('layouts_frontend/footer');
    }
}
