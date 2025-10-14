<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property M_layanan M_layanan
 * @property CI_Form_validation form_validation
 * @property CI_Upload upload
 * @property CI_Session session
 * @property CI_input input
 */
class Layanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== "login") {
            redirect(base_url("login"));
        }
        if ($this->session->userdata('id_level') !== '1') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            redirect('admin/dashboard');
        }
        $this->load->model('M_layanan');
        $this->load->helper(['form', 'url', 'file', 'text']);
        $this->load->library(['form_validation', 'upload', 'session']);
    }

    /** Wrapper layout Atlantis */
    private function render($view, $data = [])
    {
        if (!isset($data['title'])) $data['title'] = 'Layanan';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/footer');
    }

    // LIST
    public function index()
    {
        $data['title'] = 'Layanan';
        $q             = $this->input->get('q', true);
        $data['q']     = $q;
        $data['rows']  = $this->M_layanan->get_all($q);
        $this->render('admin/layanan/index', $data);
    }

    // TAMBAH
    public function tambah()
    {
        $data['title'] = 'Tambah Layanan';

        if ($this->input->method() === 'post') {
            $this->_validate(true);

            if ($this->form_validation->run()) {
                // Coba upload dulu
                $file = $this->_do_upload();

                // Jika user wajib unggah gambar tapi belum pilih file
                if ($file === null) {
                    $this->session->set_flashdata('error', 'Silakan pilih gambar (maks 2MB, jpg/jpeg/png/webp).');
                    return $this->render('admin/layanan/tambah', $data);
                }

                // Jika upload gagal (ukuran > 2MB / tipe tidak valid / dsb)
                if ($file === false) {
                    $msg = strip_tags($this->upload->display_errors('', ''));
                    if ($msg === '') $msg = 'Upload gambar gagal. Pastikan ukuran ≤ 2MB dan format jpg/jpeg/png/webp.';
                    $this->session->set_flashdata('error', $msg);
                    return $this->render('admin/layanan/tambah', $data);
                }

                // Lolos -> simpan
                $payload = [
                    'judul'     => $this->input->post('judul', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'gambar'    => $file,            // PASTI terisi file yang valid
                    'urut'      => (int)$this->input->post('urut'),
                    'aktif'     => (int)($this->input->post('aktif') ?? 1),
                ];

                if ($this->M_layanan->create($payload)) {
                    $this->session->set_flashdata('success', 'Berhasil menambahkan layanan.');
                    return redirect('admin/layanan');
                }
                $this->session->set_flashdata('error', 'Gagal menyimpan.');
            }
        }

        $this->render('admin/layanan/tambah', $data);
    }

    // EDIT
    public function edit($id)
    {
        $row = $this->M_layanan->get($id);
        if (!$row) show_404();

        $data['title'] = 'Edit Layanan';
        $data['row']   = $row;

        if ($this->input->method() === 'post') {
            $this->_validate(false);
            if ($this->form_validation->run()) {
                $payload = [
                    'judul'     => $this->input->post('judul', true),
                    'deskripsi' => $this->input->post('deskripsi', true),
                    'urut'      => (int)$this->input->post('urut'),
                    'aktif'     => (int)$this->input->post('aktif'),
                ];

                if (!empty($_FILES['gambar']['name'])) {
                    $new = $this->_do_upload();
                    if ($new) {
                        $payload['gambar'] = $new;
                        $this->_unlink_old($row->gambar);
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        return redirect('admin/layanan/edit/' . $id);
                    }
                }

                if ($this->M_layanan->update($id, $payload)) {
                    $this->session->set_flashdata('success', 'Perubahan disimpan.');
                    return redirect('admin/layanan');
                }
                $this->session->set_flashdata('error', 'Gagal menyimpan perubahan.');
            }
        }

        $this->render('admin/layanan/edit', $data);
    }

    // HAPUS
    public function delete($id)
    {
        $row = $this->M_layanan->get($id);
        if (!$row) show_404();

        if ($this->M_layanan->delete($id)) {
            $this->_unlink_old($row->gambar);
            $this->session->set_flashdata('success', 'Berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus.');
        }
        redirect('admin/layanan');
    }

    /* ===== Helpers ===== */
    private function _validate($requireImage = true)
    {
        $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|min_length[8]');
        $this->form_validation->set_rules('urut', 'Urutan', 'integer');
        $this->form_validation->set_rules('aktif', 'Aktif', 'in_list[0,1]');
        if ($requireImage && empty($_FILES['gambar']['name'])) {
            $this->form_validation->set_rules('gambar', 'Gambar', 'required');
        }
    }

    private function _do_upload()
    {
        // Tidak memilih file
        if (empty($_FILES['gambar']['name'])) {
            return null; // bedakan dengan 'false' (gagal upload)
        }

        $config = [
            'upload_path'   => FCPATH . 'uploads/layanan',
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size'      => 2048,          // KB -> 2 MB
            'encrypt_name'  => true,
        ];
        if (!is_dir($config['upload_path'])) @mkdir($config['upload_path'], 0775, true);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('gambar')) {
            $up = $this->upload->data();
            return $up['file_name'];         // Sukses
        }

        return false; // GAGAL upload (ukuran/tipe tidak valid, dsb)
    }

    private function _unlink_old($filename)
    {
        if (!$filename) return;
        $path = FCPATH . 'uploads/layanan/' . $filename;
        if (is_file($path)) @unlink($path);
    }
}
