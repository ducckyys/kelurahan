<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_coverage $M_coverage
 * @property CI_DB_query_builder $db
 * @property M_dashboard $M_dashboard
 * @property CI_Output $output
 */

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
        $this->load->model('M_coverage');
    }

    public function index()
    {
        $data['title'] = "Dashboard Admin";

        // Kartu ringkas
        $data['total_sktm']             = $this->db->count_all_results('surat_sktm');
        $data['total_belum_bekerja']    = $this->db->count_all_results('surat_belum_bekerja');
        $data['total_domisili_yayasan'] = $this->db->count_all_results('surat_domisili_yayasan');
        $data['total_belum_rumah']      = $this->db->count_all_results('surat_belum_memiliki_rumah');
        $data['total_kematian']         = $this->db->count_all_results('surat_kematian');
        $data['total_kematian_non']     = $this->db->count_all_results('surat_kematian_nondukcapil');
        $data['total_suami_istri']      = $this->db->count_all_results('surat_keterangan_suami_istri');
        $data['total_pengantar_nikah']  = $this->db->table_exists('surat_pengantar_nikah')
            ? $this->db->count_all_results('surat_pengantar_nikah') : 0;

        // 10 aktivitas terbaru (fallback non DataTables)
        $union = $this->union_base_query();
        $sql   = $union
            ? "SELECT * FROM ($union) t ORDER BY t.tanggal_masuk DESC LIMIT 10"
            : "SELECT 1 id, NOW() tanggal_masuk, '' jenis_surat, '' nama, '' url LIMIT 0"; // kosong aman
        $data['pengajuan_terbaru'] = $this->db->query($sql)->result();

        // Grafik Jangkauan (Skala Kami)
        $cov = $this->M_coverage->get_single();
        $data['coverage_chart'] = [
            'labels' => ['Jumlah KK', 'Penduduk', 'RW', 'RT'],
            'data'   => [
                (int)($cov->jumlah_kk ?? 0),
                (int)($cov->jumlah_penduduk ?? 0),
                (int)($cov->jumlah_rw ?? 0),
                (int)($cov->jumlah_rt ?? 0),
            ],
        ];

        // Grafik Pengajuan (12 bulan)
        $labelsYM    = $this->_month_range(12);
        $labelsHuman = array_map(fn($ym) => date('M Y', strtotime($ym . '-01')), $labelsYM);

        $tables = [
            'sktm'             => ['table' => 'surat_sktm',                   'label' => 'SKTM'],
            'belum_bekerja'    => ['table' => 'surat_belum_bekerja',          'label' => 'Belum Bekerja'],
            'domisili_yayasan' => ['table' => 'surat_domisili_yayasan',       'label' => 'Domisili Yayasan'],
            'belum_rumah'      => ['table' => 'surat_belum_memiliki_rumah',   'label' => 'Belum Memiliki Rumah'],
            'kematian'         => ['table' => 'surat_kematian',               'label' => 'Kematian Dukcapil'],
            'kematian_non'     => ['table' => 'surat_kematian_nondukcapil',   'label' => 'Kematian Non Dukcapil'],
            'suami_istri'      => ['table' => 'surat_keterangan_suami_istri', 'label' => 'Suami Istri'],
        ];
        if ($this->db->table_exists('surat_pengantar_nikah')) {
            $tables['pengantar_nikah'] = ['table' => 'surat_pengantar_nikah', 'label' => 'Pengantar Nikah'];
        }

        $series_by_type   = [];
        $total_per_month  = array_fill(0, count($labelsYM), 0);

        foreach ($tables as $key => $info) {
            $map = $this->_monthly_counts($info['table']); // ['Y-m'=>count]
            $arr = [];
            foreach ($labelsYM as $i => $ym) {
                $val = (int)($map[$ym] ?? 0);
                $arr[] = $val;
                $total_per_month[$i] += $val;
            }
            $series_by_type[$key] = ['label' => $info['label'], 'data' => $arr];
        }

        $data['chart_labels'] = $labelsHuman;
        $data['chart_totals'] = $total_per_month;
        $data['chart_series'] = $series_by_type;

        // render
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('admin/v_dashboard', $data);
        $this->load->view('layouts/footer');
    }

    /** DataTables JSON */
    public function aktivitas_json()
    {
        if ($this->session->userdata('status') != 'login') {
            return $this->output->set_status_header(401)
                ->set_output(json_encode(['error' => 'Unauthorized']));
        }

        $draw      = (int)($this->input->get('draw', TRUE) ?? 1);
        $start     = (int)($this->input->get('start', TRUE) ?? 0);
        $length    = (int)($this->input->get('length', TRUE) ?? 10);
        $search    = $this->input->get('search', TRUE);
        $searchVal = is_array($search) ? trim($search['value'] ?? '') : trim((string)$search);
        $order     = $this->input->get('order', TRUE);
        $order_col = 0;
        $order_dir = 'desc';
        if (is_array($order) && !empty($order)) {
            $order_col = (int)($order[0]['column'] ?? 0);
            $order_dir = strtolower($order[0]['dir'] ?? 'desc');
        }
        $orderable = [0 => 'tanggal_masuk', 1 => 'jenis_surat', 2 => 'nama'];
        $order_by  = $orderable[$order_col] ?? 'tanggal_masuk';
        $order_dir = ($order_dir === 'asc') ? 'ASC' : 'DESC';

        $union = $this->union_base_query();
        if (!$union) {
            // tidak ada tabel yang tersedia
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode([
                    'draw' => $draw,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]));
        }

        $base = "FROM ($union) t";
        $total = (int)$this->db->query("SELECT COUNT(*) c $base")->row()->c;

        $where = "";
        $binds = [];
        if ($searchVal !== '') {
            $like  = '%' . $this->db->escape_like_str($searchVal) . '%';
            $where = " WHERE (t.nama LIKE ? OR t.jenis_surat LIKE ?)";
            $binds = [$like, $like];
        }

        $filtered = (int)$this->db->query("SELECT COUNT(*) c $base $where", $binds)->row()->c;

        $sql  = "SELECT t.id, t.tanggal_masuk, t.jenis_surat, t.nama, t.url
                 $base $where ORDER BY $order_by $order_dir LIMIT ? OFFSET ?";
        $rows = $this->db->query($sql, array_merge($binds, [$length, $start]))->result();

        $data = [];
        foreach ($rows as $r) {
            $detail_url = base_url($r->url . '/detail/' . $r->id);
            $data[] = [
                date('d M Y, H:i', strtotime($r->tanggal_masuk)),
                '<span class="badge badge-primary">' . $r->jenis_surat . '</span>',
                html_escape($r->nama),
                '<a href="' . $detail_url . '" class="btn btn-info btn-sm">Lihat Detail</a>',
            ];
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data,
        ]));
    }

    /** UNION dinamis hanya untuk tabel yang ada */
    private function union_base_query(): ?string
    {
        $parts = [];

        if ($this->db->table_exists('surat_sktm')) {
            $parts[] = "SELECT id, created_at AS tanggal_masuk, 'SKTM' AS jenis_surat, nama_pemohon AS nama, 'admin/surat_sktm' AS url FROM surat_sktm";
        }
        if ($this->db->table_exists('surat_belum_bekerja')) {
            $parts[] = "SELECT id, created_at, 'Belum Bekerja', nama_pemohon, 'admin/surat_belum_bekerja' FROM surat_belum_bekerja";
        }
        if ($this->db->table_exists('surat_domisili_yayasan')) {
            $parts[] = "SELECT id, created_at, 'Domisili Yayasan', nama_organisasi, 'admin/surat_domisili_yayasan' FROM surat_domisili_yayasan";
        }
        if ($this->db->table_exists('surat_belum_memiliki_rumah')) {
            $parts[] = "SELECT id, created_at, 'Belum Memiliki Rumah', nama_pemohon, 'admin/surat_belum_memiliki_rumah' FROM surat_belum_memiliki_rumah";
        }
        if ($this->db->table_exists('surat_kematian')) {
            $parts[] = "SELECT id, created_at, 'Kematian Dukcapil', nama, 'admin/surat_kematian' FROM surat_kematian";
        }
        if ($this->db->table_exists('surat_kematian_nondukcapil')) {
            $parts[] = "SELECT id, created_at, 'Kematian Non Dukcapil', nama_ahli_waris, 'admin/surat_kematian_nondukcapil' FROM surat_kematian_nondukcapil";
        }
        if ($this->db->table_exists('surat_keterangan_suami_istri')) {
            $parts[] = "SELECT id, created_at, 'Suami Istri', nama_pihak_satu, 'admin/surat_suami_istri' FROM surat_keterangan_suami_istri";
        }
        if ($this->db->table_exists('surat_pengantar_nikah')) {
            $parts[] = "SELECT id, created_at, 'Pengantar Nikah', CONCAT(pria_nama, ' & ', wanita_nama), 'admin/surat_pengantar_nikah' FROM surat_pengantar_nikah";
        }

        if (empty($parts)) return null;
        return implode("\nUNION ALL\n", $parts);
    }

    private function _month_range(int $months = 12): array
    {
        $out = [];
        for ($i = $months - 1; $i >= 0; $i--) $out[] = date('Y-m', strtotime("-$i months"));
        return $out;
    }

    private function _monthly_counts(string $table): array
    {
        $start = date('Y-m-01', strtotime('-11 months'));
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') ym, COUNT(*) c
                FROM {$table}
                WHERE created_at >= ?
                GROUP BY ym";
        $rows = $this->db->query($sql, [$start])->result();
        $map = [];
        foreach ($rows as $r) $map[$r->ym] = (int)$r->c;
        return $map;
    }
}
