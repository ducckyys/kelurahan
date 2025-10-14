<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_input $input
 * @property M_coverage $M_coverage
 */

class Coverage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Proteksi login sesuai pola project
        if ($this->session->userdata('status') !== "login") {
            redirect(base_url("login"));
        }
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
        }
        $this->load->model('M_coverage');
        $this->load->library(['form_validation', 'upload']);
        $this->load->helper(['url', 'form']);
        $this->M_coverage->ensure_defaults();
    }

    private function render($view, $data = [])
    {
        if (!isset($data['title'])) $data['title'] = 'Jangkauan Layanan';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer');
    }

    public function index()
    {
        $data['coverage'] = $this->M_coverage->get_single();
        $this->render('admin/coverage/index', $data);
    }

    public function save()
    {
        // Validasi angka
        $this->form_validation->set_rules('jumlah_kk', 'Jumlah KK', 'required|integer');
        $this->form_validation->set_rules('jumlah_penduduk', 'Jumlah Penduduk', 'required|integer');
        $this->form_validation->set_rules('jumlah_rw', 'Jumlah RW', 'required|integer');
        $this->form_validation->set_rules('jumlah_rt', 'Jumlah RT', 'required|integer');

        $row = $this->M_coverage->get_single();
        $icons = [
            'icon_kk'        => $row ? $row->icon_kk : null,
            'icon_penduduk'  => $row ? $row->icon_penduduk : null,
            'icon_rw'        => $row ? $row->icon_rw : null,
            'icon_rt'        => $row ? $row->icon_rt : null,
        ];

        if ($this->form_validation->run() === FALSE) {
            $data['coverage'] = $row;
            return $this->render('admin/coverage/index', $data);
        }

        // Upload config
        $upload_path = FCPATH . 'uploads/icons/';
        if (!is_dir($upload_path)) @mkdir($upload_path, 0755, true);

        $this->upload->initialize([
            'upload_path'   => $upload_path,
            'allowed_types' => 'png|jpg|jpeg|webp|svg',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
            'overwrite'     => FALSE
        ]);

        // Helper untuk proses tiap field file
        $fields = ['icon_kk', 'icon_penduduk', 'icon_rw', 'icon_rt'];
        foreach ($fields as $field) {
            if (!empty($_FILES[$field]['name'])) {
                if ($this->upload->do_upload($field)) {
                    $up = $this->upload->data();
                    $icons[$field] = $up['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                    redirect('admin/coverage');
                    return;
                }
            }
        }

        $payload = [
            'jumlah_kk'        => (int)$this->input->post('jumlah_kk'),
            'jumlah_penduduk'  => (int)$this->input->post('jumlah_penduduk'),
            'jumlah_rw'        => (int)$this->input->post('jumlah_rw'),
            'jumlah_rt'        => (int)$this->input->post('jumlah_rt'),
            'icon_kk'          => $icons['icon_kk'],
            'icon_penduduk'    => $icons['icon_penduduk'],
            'icon_rw'          => $icons['icon_rw'],
            'icon_rt'          => $icons['icon_rt'],
        ];

        $this->M_coverage->update_values($payload);
        $this->session->set_flashdata('success', 'Jangkauan layanan berhasil diperbarui.');
        redirect('admin/coverage');
    }
}
