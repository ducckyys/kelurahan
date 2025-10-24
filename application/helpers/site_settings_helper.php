<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Ambil footer settings untuk halaman publik.
 * @return array{about_html:string, related_links:array, social_links:array}
 */
function get_footer_settings(): array
{
    /** @var CI_Controller $CI */
    $CI = &get_instance();
    $CI->load->model('M_settings');

    /** @var M_settings $M_settings */
    $M_settings = $CI->M_settings ?? null;

    if (!$M_settings) {
        return ['about_html' => '', 'related_links' => [], 'social_links' => []];
    }
    return $M_settings->get_footer();
}
