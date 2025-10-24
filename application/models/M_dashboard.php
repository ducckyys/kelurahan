<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    /**
     * Datatables server-side untuk aktivitas pengajuan lintas tabel.
     * Kolom yang dikembalikan: id, tanggal_masuk, jenis_surat, nama, url
     */
    public function datatable_aktivitas($start, $length, $search, $order_col, $order_dir)
    {
        // mapping kolom untuk ORDER BY yang aman
        $orderable = [
            0 => 'tanggal_masuk',
            1 => 'jenis_surat',
            2 => 'nama',
        ];
        $order_by = isset($orderable[$order_col]) ? $orderable[$order_col] : 'tanggal_masuk';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        // -- UNION ALL lintas tabel
        // NOTE: Ganti nama table kalau di project-mu berbeda (khusus SKTM)
        $union = "
            SELECT id, created_at AS tanggal_masuk, 'SKTM' AS jenis_surat,
                   nama_pemohon AS nama, 'admin/surat_sktm' AS url
            FROM sktm

            UNION ALL
            SELECT id, created_at, 'Ket. Belum Bekerja', nama_pemohon, 'admin/surat_belum_bekerja'
            FROM surat_belum_bekerja

            UNION ALL
            SELECT id, created_at, 'Domisili Yayasan', nama_organisasi, 'admin/surat_domisili_yayasan'
            FROM surat_domisili_yayasan

            UNION ALL
            SELECT id, created_at, 'Belum Punya Rumah', nama_pemohon, 'admin/surat_belum_memiliki_rumah'
            FROM surat_belum_memiliki_rumah

            UNION ALL
            SELECT id, created_at, 'Kematian Dukcapil', nama, 'admin/surat_kematian'
            FROM surat_kematian

            UNION ALL
            SELECT id, created_at, 'Kematian Non Dukcapil', nama_ahli_waris, 'admin/surat_kematian_nondukcapil'
            FROM surat_kematian_nondukcapil

            UNION ALL
            SELECT id, created_at, 'Suami Istri', nama_pihak_satu, 'admin/surat_suami_istri'
            FROM surat_keterangan_suami_istri

            UNION ALL
            SELECT id, created_at, 'Pengantar Nikah', CONCAT(pria_nama, ' & ', wanita_nama), 'admin/surat_pengantar_nikah'
            FROM surat_pengantar_nikah
        ";

        // jadikan subquery untuk filter/order/limit
        $sql_base = "FROM ($union) AS t";

        // total tanpa filter
        $total = (int) $this->db->query("SELECT COUNT(*) AS c $sql_base")->row()->c;

        // filter pencarian
        $binds = [];
        $where = "";
        if ($search !== '') {
            $like = '%' . $this->db->escape_like_str($search) . '%';
            $where = " WHERE (t.nama LIKE ? OR t.jenis_surat LIKE ?)";
            $binds = [$like, $like];
        }

        // filtered count
        $filtered_sql = "SELECT COUNT(*) AS c $sql_base $where";
        $filtered = (int) $this->db->query($filtered_sql, $binds)->row()->c;

        // data
        $data_sql = "SELECT t.id, t.tanggal_masuk, t.jenis_surat, t.nama, t.url
                     $sql_base
                     $where
                     ORDER BY $order_by $order_dir
                     LIMIT ? OFFSET ?";
        $binds_data = array_merge($binds, [(int)$length, (int)$start]);
        $rows = $this->db->query($data_sql, $binds_data)->result();

        return [
            'total'    => $total,
            'filtered' => $filtered,
            'rows'     => $rows,
        ];
    }
}
