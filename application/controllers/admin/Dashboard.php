<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session session
 * @property CI_Input input
 * @property CI_DB_query_builder db
 */

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Pastikan ada pengecekan login di sini
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['title'] = "Dasbor Admin";

        // 1. Menghitung jumlah total untuk setiap jenis surat
        $data['total_sktm'] = $this->db->count_all_results('surat_sktm');
        $data['total_belum_bekerja'] = $this->db->count_all_results('surat_belum_bekerja');
        $data['total_domisili_yayasan'] = $this->db->count_all_results('surat_domisili_yayasan');
        $data['total_belum_rumah'] = $this->db->count_all_results('surat_belum_memiliki_rumah');
        $data['total_kematian'] = $this->db->count_all_results('surat_kematian');
        $data['total_kematian_non'] = $this->db->count_all_results('surat_kematian_nondukcapil');
        $data['total_suami_istri'] = $this->db->count_all_results('surat_keterangan_suami_istri');

        // 2. Query UNION untuk mengambil 10 data terbaru dari semua tabel surat
        // 2. Query UNION untuk mengambil 10 data terbaru dari semua tabel surat
        //    Semua 'tgl_dibuat' diganti menjadi 'created_at'
        $query_union = "
            (SELECT id, nama_pemohon AS nama, 'SKTM' AS jenis_surat, 'admin/surat_sktm' AS url, created_at AS tanggal_masuk FROM surat_sktm)
            UNION ALL
            (SELECT id, nama_pemohon AS nama, 'Belum Bekerja' AS jenis_surat, 'admin/surat_belum_bekerja' AS url, created_at AS tanggal_masuk FROM surat_belum_bekerja)
            UNION ALL
            (SELECT id, nama_organisasi AS nama, 'Domisili Yayasan' AS jenis_surat, 'admin/surat_domisili_yayasan' AS url, created_at AS tanggal_masuk FROM surat_domisili_yayasan)
            UNION ALL
            (SELECT id, nama_pemohon AS nama, 'Belum Memiliki Rumah' AS jenis_surat, 'admin/surat_belum_memiliki_rumah' AS url, created_at AS tanggal_masuk FROM surat_belum_memiliki_rumah)
            UNION ALL
            (SELECT id, nama AS nama, 'Kematian Dukcapil' AS jenis_surat, 'admin/surat_kematian' AS url, created_at AS tanggal_masuk FROM surat_kematian)
            UNION ALL
            (SELECT id, nama_ahli_waris AS nama, 'Kematian Non Dukcapil' AS jenis_surat, 'admin/surat_kematian_nondukcapil' AS url, created_at AS tanggal_masuk FROM surat_kematian_nondukcapil)
            UNION ALL
            (SELECT id, nama_pihak_satu AS nama, 'Suami Istri' AS jenis_surat, 'admin/surat_suami_istri' AS url, created_at AS tanggal_masuk FROM surat_keterangan_suami_istri)
            ORDER BY tanggal_masuk DESC
            LIMIT 10
        ";

        $data['pengajuan_terbaru'] = $this->db->query($query_union)->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_dashboard', $data);
        $this->load->view('layouts/footer');
    }
}
