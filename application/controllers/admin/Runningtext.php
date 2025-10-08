<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 * @property M_runningtext M_runningtext
 * @property CI_Form_validation form_validation
 */
class Runningtext extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // TODO: pasang guard admin (cek login/role).
        $this->load->model('M_runningtext');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form']);

        // Pastikan dua baris ada
        $this->M_runningtext->ensure_defaults();

        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
        }
    }

    private function render($view, $data = [])
    {
        if (!isset($data['title'])) $data['title'] = 'Running Text';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer');
    }

    /** Tampil + Update */
    public function index()
    {
        if ($this->input->method() === 'post') {
            // Validasi bulk
            $this->form_validation->set_rules('top_content', 'Teks Top', 'required|max_length[255]');
            $this->form_validation->set_rules('top_direction', 'Arah Top', 'required|in_list[left,right]');
            $this->form_validation->set_rules('top_speed',   'Speed Top', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[10]');

            $this->form_validation->set_rules('bottom_content', 'Teks Bottom', 'required|max_length[255]');
            $this->form_validation->set_rules('bottom_direction', 'Arah Bottom', 'required|in_list[left,right]');
            $this->form_validation->set_rules('bottom_speed',   'Speed Bottom', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[10]');

            if ($this->form_validation->run()) {
                $p = $this->input->post(NULL, TRUE);

                $this->M_runningtext->update_by_position('top', [
                    'content'   => $p['top_content'],
                    'direction' => $p['top_direction'],
                    'speed'     => (int)$p['top_speed'],
                    'is_active' => isset($p['top_is_active']) ? 1 : 0,
                ]);

                $this->M_runningtext->update_by_position('bottom', [
                    'content'   => $p['bottom_content'],
                    'direction' => $p['bottom_direction'],
                    'speed'     => (int)$p['bottom_speed'],
                    'is_active' => isset($p['bottom_is_active']) ? 1 : 0,
                ]);

                $this->session->set_flashdata('success', 'Pengaturan running text disimpan.');
                return redirect('admin/runningtext'); // <-- tanpa strip
            }
        }

        $data['title']  = 'Running Text';
        $data['top']    = $this->M_runningtext->get_by_position('top');
        $data['bottom'] = $this->M_runningtext->get_by_position('bottom');
        $this->render('admin/runningtext/settings', $data);
    }
}
