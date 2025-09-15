<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_informasi');
        $this->load->helper('text');
    }

    public function index()
    {
        // Ambil filter dari URL
        $filters = [
            'q'   => $this->input->get('q', TRUE),
            'cat' => $this->input->get('cat', TRUE)
        ];

        $informasi_from_db = $this->M_informasi->get_all($filters);
        $data['items'] = [];

        foreach ($informasi_from_db as $info) {
            $data['items'][] = [
                'category' => $info->kategori,
                'date'     => $info->tgl_publish,
                'title'    => html_escape($info->judul_informasi),
                'summary'  => word_limiter(html_escape($info->isi_informasi), 20),
                'link'     => base_url('informasi/detail/' . $info->id_informasi)
            ];
        }

        $data['title'] = "Informasi Kelurahan";
        $data['categories'] = ['Pengumuman', 'Peraturan', 'Unduhan'];

        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_informasi_list', $data);
        $this->load->view('layouts_frontend/footer');
    }

    public function detail($id = NULL)
    {
        $data['info'] = $this->M_informasi->get_by_id_with_user($id);
        if (empty($id) || empty($data['info'])) {
            show_404();
        }
        $data['title'] = $data['info']->judul_informasi;
        $this->load->view('layouts_frontend/header', $data);
        $this->load->view('pages/v_informasi_detail', $data);
        $this->load->view('layouts_frontend/footer');
    }
}
