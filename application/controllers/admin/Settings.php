<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property M_settings M_settings
 * @property CI_Input input
 */

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') !== "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_settings');
        $this->load->helper(['url', 'form']);
    }

    // Form pengaturan footer
    public function footer()
    {
        $data['title'] = "Pengaturan Footer";
        $data['footer'] = $this->M_settings->get_footer();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/settings/footer_form', $data);
        $this->load->view('layouts/footer');
    }

    // Proses simpan
    public function footer_save()
    {
        // --- Ambil & bersihkan input ---
        $allowed_tags = '<p><b><strong><i><em><u><br><ul><ol><li><a><small><span><h1><h2><h3><h4><h5><h6>';
        $about_html_raw = $this->input->post('about_html', true) ?? '';
        $about_html = trim(strip_tags($about_html_raw, $allowed_tags));

        // Tautan terkait
        $links_title = $this->input->post('links_title') ?: [];
        $links_url   = $this->input->post('links_url') ?: [];
        $related_links = [];
        foreach ($links_title as $i => $title) {
            $title = trim((string)$title);
            $url   = isset($links_url[$i]) ? trim((string)$links_url[$i]) : '';
            if ($title === '' && $url === '') continue;
            $related_links[] = [
                'title' => $title,
                'url'   => $this->normalizeUrl($url),
            ];
        }

        // Sosial media
        $social_icon  = $this->input->post('social_icon') ?: [];
        $social_label = $this->input->post('social_label') ?: [];
        $social_url   = $this->input->post('social_url') ?: [];
        $social_links = [];
        foreach ($social_icon as $i => $icon) {
            $icon  = trim((string)$icon); // contoh: fa-facebook-f
            $label = isset($social_label[$i]) ? trim((string)$social_label[$i]) : '';
            $url   = isset($social_url[$i]) ? trim((string)$social_url[$i]) : '';
            if ($icon === '' && $url === '' && $label === '') continue;
            $social_links[] = [
                'icon'  => $icon,
                'label' => $label,
                'url'   => $this->normalizeUrl($url),
            ];
        }

        $ok = $this->M_settings->save_footer([
            'about_html'    => $about_html ?: null, // boleh null/kosong
            'related_links' => $related_links,
            'social_links'  => $social_links,
        ]);

        $this->session->set_flashdata($ok ? 'success' : 'error', $ok ? 'Footer berhasil disimpan.' : 'Gagal menyimpan footer.');
        redirect('admin/settings/footer');
    }

    private function normalizeUrl($url)
    {
        if ($url === '') return '';
        // kalau tidak diawali http/https, tambahkan https://
        if (!preg_match('~^https?://~i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }
        return $url;
    }
}
