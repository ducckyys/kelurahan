<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_pejabat $M_pejabat
 * @property M_ref_jabatan $M_ref_jabatan
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */
class Pejabat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== 'login') redirect(base_url('login'));

        $this->load->model(['M_pejabat', 'M_ref_jabatan']);
        $this->load->library(['form_validation']);
        $this->load->helper(['url', 'form']);

        $this->ensure_superadmin();
    }

    private function ensure_superadmin()
    {
        $id_level = (int)($this->session->userdata('id_level') ?? 0);
        if ($id_level !== 1) show_error('Anda tidak memiliki akses ke modul ini.', 403, 'Forbidden');
    }

    public function index()
    {
        $data['title'] = 'Data Pejabat';
        $data['list']  = $this->M_pejabat->get_all();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pejabat/v_list', $data);
        $this->load->view('layouts/footer');
    }

    public function create()
    {
        $data['title']   = 'Tambah Pejabat';
        $data['mode']    = 'create';
        $data['row']     = (object)['jabatan_id' => '', 'nama' => '', 'nip' => ''];
        $data['jabatan'] = $this->M_ref_jabatan->get_available_for(null); // hanya jabatan kosong

        if ($this->input->method() === 'post') {
            $this->_rules_common(null);
            if ($this->form_validation->run()) {
                $payload = [
                    'jabatan_id' => (int)$this->input->post('jabatan_id', true),
                    'nama'       => trim($this->input->post('nama', true)),
                    'nip'        => preg_replace('/\s+/', '', $this->input->post('nip', true)),
                ];
                $this->M_pejabat->insert($payload);
                $this->session->set_flashdata('success', 'Pejabat berhasil ditambahkan.');
                return redirect(base_url('admin/pejabat'));
            }
            $data['row'] = (object)[
                'jabatan_id' => set_value('jabatan_id'),
                'nama'       => set_value('nama'),
                'nip'        => set_value('nip'),
            ];
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pejabat/v_form', $data);
        $this->load->view('layouts/footer');
    }

    public function edit($id = null)
    {
        $id  = (int)$id;
        $row = $this->M_pejabat->get_by_id($id);
        if (!$row) show_404();

        $data['title']   = 'Edit Pejabat';
        $data['mode']    = 'edit';
        $data['row']     = $row;
        $data['jabatan'] = $this->M_ref_jabatan->get_available_for($id); // kosong + milik sendiri

        if ($this->input->method() === 'post') {
            $this->_rules_common($id);
            if ($this->form_validation->run()) {
                $payload = [
                    'jabatan_id' => (int)$this->input->post('jabatan_id', true),
                    'nama'       => trim($this->input->post('nama', true)),
                    'nip'        => preg_replace('/\s+/', '', $this->input->post('nip', true)),
                ];
                $this->M_pejabat->update($id, $payload);
                $this->session->set_flashdata('success', 'Pejabat berhasil diperbarui.');
                return redirect(base_url('admin/pejabat'));
            }
            $data['row'] = (object)[
                'jabatan_id' => set_value('jabatan_id', $row->jabatan_id),
                'nama'       => set_value('nama', $row->nama),
                'nip'        => set_value('nip',  $row->nip),
            ];
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/pejabat/v_form', $data);
        $this->load->view('layouts/footer');
    }

    public function delete($id = null)
    {
        $id = (int)$id;
        $row = $this->M_pejabat->get_by_id($id);
        if (!$row) show_404();
        if ($this->input->method() !== 'post') show_error('Metode tidak diizinkan.', 405);

        $this->M_pejabat->delete($id);
        $this->session->set_flashdata('success', 'Pejabat berhasil dihapus.');
        redirect(base_url('admin/pejabat'));
    }

    // ===== Validations (1 jabatan = 1 orang) =====
    private function _rules_common($id = null)
    {
        // Valid & available
        $this->form_validation->set_rules(
            'jabatan_id',
            'Jabatan',
            [
                'required',
                'integer',
                'callback__jabatan_exists',
                ['unique_jabatan', function ($jid) use ($id) {
                    return !$this->M_pejabat->exists_jabatan((int)$jid, $id);
                }],
            ],
            ['unique_jabatan' => 'Jabatan tersebut sudah memiliki pejabat.']
        );

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim|min_length[3]|max_length[100]');

        $this->form_validation->set_rules(
            'nip',
            'NIP',
            [
                'required',
                'trim',
                ['regex_nip', function ($nip) {
                    return (bool)preg_match('/^\d{18}$/', $nip);
                }],
                ['unique_nip', function ($nip) use ($id) {
                    return !$this->M_pejabat->exists_nip($nip, $id);
                }],
            ],
            [
                'regex_nip'  => 'Format NIP harus 18 digit angka.',
                'unique_nip' => 'NIP sudah terdaftar.',
            ]
        );
    }

    public function _jabatan_exists($jabatan_id)
    {
        if ($this->M_ref_jabatan->exists((int)$jabatan_id)) return TRUE;
        $this->form_validation->set_message('_jabatan_exists', 'Jabatan tidak valid.');
        return FALSE;
    }
}
