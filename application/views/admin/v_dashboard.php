<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* ===== Palet fallback ===== */
    :root {
        --blue-900: #0a2a66;
        --blue-700: #0f3a8a;
        --blue-600: #1147a7;
        --blue-500: #1666cc;
        --blue-100: #eaf2ff;
        --yellow-500: #ffc107;
        --paper: #ffffff;
        --ink: #0b1220;
    }

    /* ===== Heading halaman ===== */
    .page-header {
        position: relative;
        padding-bottom: 8px
    }

    .page-header::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 3px;
        background: var(--yellow-500)
    }

    /* ===== STAT CARDS (modern & elegan) ===== */
    .stat-link {
        display: block;
        text-decoration: none !important;
        color: inherit !important
    }

    .stat-grid .stat-card {
        border: 1px solid rgba(17, 71, 167, .08);
        border-radius: 16px;
        background: linear-gradient(180deg, #fff 0%, #f7f8fc 100%);
        box-shadow: 0 6px 18px rgba(24, 28, 33, .06);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        overflow: hidden;
    }

    .stat-grid .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(24, 28, 33, .10);
        border-color: rgba(17, 71, 167, .18)
    }

    .stat-body {
        padding: 14px 16px;
        min-height: 92px
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border-radius: 12px;
        background: var(--blue-100);
        color: var(--blue-600) !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 0 1px rgba(17, 71, 167, .10)
    }

    .stat-icon i {
        font-size: 18px
    }

    .stat-meta {
        min-width: 0
    }

    .stat-title {
        margin: 0;
        font-size: .88rem;
        line-height: 1.25;
        color: #334155;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: normal;
        overflow-wrap: normal;
        hyphens: auto
    }

    .stat-value {
        margin-left: auto;
        font-weight: 800;
        font-size: 1.35rem;
        color: var(--blue-700);
        font-variant-numeric: tabular-nums
    }

    .stat-link:focus-visible .stat-card {
        outline: 3px solid rgba(17, 71, 167, .25);
        outline-offset: 2px
    }

    /* Netralisir pewarnaan icon lama di dalam stat-card */
    .stat-card .text-gradient-primary,
    .stat-card .text-gradient-info,
    .stat-card .text-gradient-success,
    .stat-card .text-gradient-secondary,
    .stat-card .text-gradient-danger,
    .stat-card .text-gradient-warning,
    .stat-card .text-gradient-muted {
        color: inherit !important
    }

    /* ===== Section cards umum ===== */
    .card-modern {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 6px 18px rgba(24, 28, 33, .06)
    }

    .card-modern .card-header {
        border: 0;
        padding: 16px 20px;
        box-shadow: inset 0 -3px 0 0 var(--yellow-500)
    }

    .card-modern .card-title {
        margin: 0;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--blue-700) !important
    }

    /* ===== DataTables ===== */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e6e8ef;
        border-radius: 10px;
        padding: .45rem .7rem;
        outline: 0
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e6e8ef;
        border-radius: 10px;
        padding: .3rem .5rem;
        outline: 0
    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: var(--blue-600);
        box-shadow: 0 0 0 3px rgba(17, 71, 167, .12)
    }

    .table a {
        color: var(--blue-600);
        text-decoration: none !important
    }

    .table a:hover {
        color: var(--blue-700);
        text-decoration: underline
    }

    /* ===== Weather & Time ===== */
    .wx-card {
        border: 0;
        border-radius: 14px;
        background: linear-gradient(180deg, #fff 0%, #f7f8fc 100%);
        box-shadow: 0 6px 18px rgba(24, 28, 33, .06)
    }

    .wx-card .card-header {
        border: 0;
        padding: 14px 18px;
        box-shadow: inset 0 -3px 0 0 var(--yellow-500)
    }

    .wx-title {
        margin: 0;
        font-weight: 700;
        font-size: 1.02rem;
        color: var(--blue-700)
    }

    .wx-sub {
        color: #6c7a91;
        font-size: .875rem
    }

    .wx-updated {
        color: #6c7a91;
        font-size: .86rem
    }

    .wx-dot {
        width: 8px;
        height: 8px;
        display: inline-block;
        border-radius: 50%;
        background: var(--yellow-500);
        margin: 0 6px;
        vertical-align: middle
    }

    .wx-chips {
        display: grid;
        grid-template-columns: repeat(2, minmax(180px, 1fr));
        gap: .6rem
    }

    @media(min-width:768px) {
        .wx-chips {
            grid-template-columns: repeat(4, minmax(160px, 1fr))
        }
    }

    .wx-chip {
        display: flex;
        align-items: center;
        gap: .6rem;
        border: 1px solid #e6e8ef;
        border-radius: 12px;
        background: #fff;
        padding: .6rem .7rem
    }

    .wx-chip i {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--blue-100);
        color: var(--blue-600)
    }

    .wx-val {
        font-weight: 700;
        color: var(--blue-700)
    }

    .wx-meta {
        color: var(--blue-900);
        font-weight: 600
    }

    .wx-acc-pill {
        font-size: .75rem;
        background: #eef4ff;
        color: #1147a7;
        padding: .1rem .45rem;
        border-radius: 999px
    }
</style>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Dashboard</h4>
    </div>

    <!-- ===== STAT CARDS (rapi & modern) ===== -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 stat-grid mb-3">

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_sktm') ?>" title="Lihat SKTM">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_sktm ?? 0); ?>">
                            <?= number_format((int)($total_sktm ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_belum_bekerja') ?>" title="Lihat Belum Bekerja">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-user"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Belum Bekerja">Surat Keterangan Belum Bekerja</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_belum_bekerja ?? 0); ?>">
                            <?= number_format((int)($total_belum_bekerja ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_domisili_yayasan') ?>" title="Lihat Domisili Yayasan">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-university"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Domisili Yayasan">Surat Keterangan Domisili Yayasan</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_domisili_yayasan ?? 0); ?>">
                            <?= number_format((int)($total_domisili_yayasan ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_belum_memiliki_rumah') ?>" title="Lihat Belum Punya Rumah">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-home"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Belum Punya Rumah">Surat Keterangan Belum Punya Rumah</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_belum_rumah ?? 0); ?>">
                            <?= number_format((int)($total_belum_rumah ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_kematian') ?>" title="Lihat Kematian (Dukcapil)">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-crosshairs"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Kematian (Dukcapil)">Surat Keterangan Kematian (Dukcapil)</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_kematian ?? 0); ?>">
                            <?= number_format((int)($total_kematian ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_kematian_nondukcapil') ?>" title="Lihat Kematian (Non-Dukcapil)">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-user-times"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Kematian (Non-Dukcapil)">Surat Keterangan Kematian (Non-Dukcapil)</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_kematian_non ?? 0); ?>">
                            <?= number_format((int)($total_kematian_non ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_suami_istri') ?>" title="Lihat Suami Istri">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Suami Istri">Surat Keterangan Suami Istri</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_suami_istri ?? 0); ?>">
                            <?= number_format((int)($total_suami_istri ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a class="stat-link" href="<?= base_url('admin/surat_pengantar_nikah') ?>" title="Lihat Pengantar Nikah">
                <div class="card stat-card h-100">
                    <div class="card-body stat-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="fas fa-ring"></i></div>
                        <div class="stat-meta flex-grow-1">
                            <p class="stat-title" title="Surat Keterangan Pengantar Nikah">Surat Keterangan Pengantar Nikah</p>
                        </div>
                        <div class="stat-value" data-count="<?= (int)($total_pengantar_nikah ?? 0); ?>">
                            <?= number_format((int)($total_pengantar_nikah ?? 0), 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- ===== CUACA & WAKTU ===== -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card wx-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h4 class="wx-title mb-0"><i class="fas fa-cloud-sun me-2"></i>Cuaca & Waktu</h4>
                    <span class="wx-updated" id="wxUpdated"></span>
                </div>
                <div class="card-body">
                    <div class="wx-sub">
                        <div class="wx-meta" id="wxLoc">–</div>
                        <span id="wxDate">–</span> <span class="wx-dot"></span> <span id="wxTime">–</span>
                        <span class="ms-2 badge bg-warning text-dark" id="wxTZ" style="font-weight:600;">Asia/Jakarta</span>
                        <span class="ms-2 wx-acc-pill" id="wxAcc">±– m</span>
                    </div>

                    <div class="wx-chips mt-3">
                        <div class="wx-chip">
                            <i class="fas fa-thermometer-half"></i>
                            <div>
                                <div class="wx-val" id="wxTemp">–</div>
                                <div class="wx-sub">Suhu (Feels)</div>
                            </div>
                        </div>
                        <div class="wx-chip">
                            <i class="fas fa-cloud"></i>
                            <div>
                                <div class="wx-val" id="wxCond">–</div>
                                <div class="wx-sub">Kondisi</div>
                            </div>
                        </div>
                        <div class="wx-chip">
                            <i class="fas fa-wind"></i>
                            <div>
                                <div class="wx-val" id="wxWind">–</div>
                                <div class="wx-sub">Angin</div>
                            </div>
                        </div>
                        <div class="wx-chip">
                            <i class="fas fa-tint"></i>
                            <div>
                                <div class="wx-val" id="wxHum">–</div>
                                <div class="wx-sub">Kelembapan</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 wx-sub" id="wxSun">Sunrise/Sunset: –</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== GRAFIK: Jangkauan & Pengajuan ===== -->
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Jangkauan Layanan</h4>
                </div>
                <div class="card-body"><canvas id="coverageChart" height="180"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-chart-line me-2"></i>Pengajuan Surat (12 bulan)</h4>
                </div>
                <div class="card-body"><canvas id="suratChart" height="180"></canvas></div>
            </div>
        </div>
    </div>

    <!-- ===== AKTIVITAS ===== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-modern">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h4 class="card-title mb-0">Aktivitas Pengajuan Surat</h4>
                    <div class="filter-group d-flex flex-wrap gap-2">
                        <button class="filter-chip btn btn-light border" data-q=""><i class="fas fa-list-ul me-1"></i>Semua</button>
                        <button class="filter-chip btn btn-light border" data-q="SKTM"><i class="fas fa-shield-alt me-1"></i>SKTM</button>
                        <button class="filter-chip btn btn-light border" data-q="Belum Bekerja"><i class="fas fa-user me-1"></i>Belum Bekerja</button>
                        <button class="filter-chip btn btn-light border" data-q="Domisili Yayasan"><i class="fas fa-university me-1"></i>Domisili Yayasan</button>
                        <button class="filter-chip btn btn-light border" data-q="Belum Memiliki Rumah"><i class="fas fa-home me-1"></i>Belum Punya Rumah</button>
                        <button class="filter-chip btn btn-light border" data-q="Kematian Dukcapil"><i class="fas fa-crosshairs me-1"></i>Kematian (Dukcapil)</button>
                        <button class="filter-chip btn btn-light border" data-q="Kematian Non Dukcapil"><i class="fas fa-user-times me-1"></i>Kematian (Non-Dukcapil)</button>
                        <button class="filter-chip btn btn-light border" data-q="Suami Istri"><i class="fas fa-users me-1"></i>Suami Istri</button>
                        <button class="filter-chip btn btn-light border" data-q="Pengantar Nikah"><i class="fas fa-ring me-1"></i>Pengantar Nikah</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tbl-aktivitas" class="table table-striped table-hover w-100 align-middle">
                            <thead>
                                <tr>
                                    <th style="min-width:170px;">Tanggal Masuk</th>
                                    <th style="min-width:160px;">Jenis Surat</th>
                                    <th>Nama Pemohon/Yayasan</th>
                                    <th style="min-width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <script>
                        // ===== DataTables =====
                        document.addEventListener('DOMContentLoaded', function() {
                            var dt = $('#tbl-aktivitas').DataTable({
                                processing: true,
                                serverSide: true,
                                searchDelay: 400,
                                order: [
                                    [0, 'desc']
                                ],
                                autoWidth: false,
                                lengthMenu: [
                                    [10, 25, 50, 100],
                                    [10, 25, 50, 100]
                                ],
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Cari nama / jenis surat...",
                                    lengthMenu: "Tampilkan _MENU_",
                                    info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                                    infoEmpty: "Tidak ada data",
                                    zeroRecords: "Data tidak ditemukan",
                                    processing: "Memuat...",
                                    paginate: {
                                        previous: "‹",
                                        next: "›"
                                    }
                                },
                                ajax: {
                                    url: '<?= base_url('admin/dashboard/aktivitas_json'); ?>',
                                    type: 'GET'
                                },
                                columnDefs: [{
                                    targets: [3],
                                    orderable: false,
                                    searchable: false
                                }]
                            });

                            // Filter chips
                            var chips = document.querySelectorAll('.filter-chip');

                            function setActive(el) {
                                chips.forEach(c => c.classList.remove('active'));
                                el.classList.add('active');
                            }
                            chips.forEach(chip => {
                                chip.addEventListener('click', function() {
                                    var q = this.getAttribute('data-q') || '';
                                    dt.search(q).draw();
                                    setActive(this);
                                });
                            });
                            var def = document.querySelector('.filter-chip[data-q=""]');
                            if (def) def.classList.add('active');
                        });

                        // ===== Chart.js (opsional) =====
                        window.addEventListener('load', function() {
                            if (typeof window.Chart === 'undefined') {
                                console.warn('Chart.js tidak ditemukan. Grafik dilewati.');
                                return;
                            }
                            try {
                                const covLabels = <?= json_encode($coverage_chart['labels'] ?? []); ?>;
                                const covData = <?= json_encode($coverage_chart['data']   ?? []); ?>;
                                new Chart(document.getElementById('coverageChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: covLabels,
                                        datasets: [{
                                            label: 'Jumlah',
                                            data: covData
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                mode: 'index',
                                                intersect: false
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    precision: 0
                                                }
                                            }
                                        }
                                    }
                                });

                                const labels = <?= json_encode($chart_labels ?? []); ?>;
                                const totals = <?= json_encode($chart_totals ?? []); ?>;
                                const series = <?= json_encode($chart_series ?? []); ?>;
                                const datasets = [
                                    ...Object.keys(series).map(k => ({
                                        type: 'bar',
                                        label: series[k].label,
                                        data: series[k].data,
                                        stack: 'surat'
                                    })),
                                    {
                                        type: 'line',
                                        label: 'Total',
                                        data: totals,
                                        tension: .25,
                                        borderWidth: 2,
                                        pointRadius: 3
                                    }
                                ];
                                new Chart(document.getElementById('suratChart'), {
                                    data: {
                                        labels,
                                        datasets
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            tooltip: {
                                                mode: 'index',
                                                intersect: false
                                            }
                                        },
                                        scales: {
                                            x: {
                                                stacked: true
                                            },
                                            y: {
                                                stacked: true,
                                                beginAtZero: true,
                                                ticks: {
                                                    precision: 0
                                                }
                                            }
                                        }
                                    }
                                });
                            } catch (e) {
                                console.error('Gagal render grafik:', e);
                            }
                        });
                    </script>

                    <script>
                        (function() {
                            /* ===== Paksa lokasi: Kelurahan Kademangan, Setu, Tangsel ===== */
                            const FORCE_CITY = true;
                            const CITY = {
                                lat: -6.335064,
                                lon: 106.669816,
                                label: 'Kademangan, Setu, Tangerang Selatan, Indonesia'
                            };

                            /* ===== Endpoint backend ===== */
                            const API_WX = '<?= base_url('api/weather'); ?>';
                            const API_TIME = '<?= base_url('api/time/now'); ?>';

                            /* ===== DOM ===== */
                            const el = {
                                loc: document.getElementById('wxLoc'),
                                date: document.getElementById('wxDate'),
                                time: document.getElementById('wxTime'),
                                tz: document.getElementById('wxTZ'),
                                temp: document.getElementById('wxTemp'),
                                cond: document.getElementById('wxCond'),
                                wind: document.getElementById('wxWind'),
                                hum: document.getElementById('wxHum'),
                                sun: document.getElementById('wxSun'),
                                updated: document.getElementById('wxUpdated'),
                                acc: document.getElementById('wxAcc')
                            };

                            let ticker = null,
                                baseNow = null,
                                baseStart = null,
                                tzUsed = 'Asia/Jakarta';
                            const fmtDate = (d, tz) => new Intl.DateTimeFormat('id-ID', {
                                dateStyle: 'full',
                                timeZone: tz
                            }).format(d);
                            const fmtTime = (d, tz) => new Intl.DateTimeFormat('id-ID', {
                                timeStyle: 'medium',
                                timeZone: tz
                            }).format(d);
                            const fetchJSON = async (u) => {
                                const r = await fetch(u, {
                                    cache: 'no-store'
                                });
                                if (!r.ok) throw new Error('HTTP ' + r.status);
                                return r.json();
                            };
                            const degToCompass16 = (deg) => {
                                if (deg == null || isNaN(deg)) return null;
                                const d = ((deg % 360) + 360) % 360;
                                const dirs = ['Utara', 'Utara-Timur Laut', 'Timur Laut', 'Timur-Timur Laut', 'Timur', 'Timur-Tenggara', 'Tenggara', 'Selatan-Tenggara', 'Selatan', 'Selatan-Barat Daya', 'Barat Daya', 'Barat-Barat Daya', 'Barat', 'Barat-Barat Laut', 'Barat Laut', 'Utara-Barat Laut'];
                                return dirs[Math.round(d / 22.5) % 16];
                            };

                            function startClock() {
                                if (ticker) clearInterval(ticker);
                                if (!baseNow) baseNow = new Date();
                                baseStart = Date.now();
                                ticker = setInterval(() => {
                                    const d = new Date(baseNow.getTime() + (Date.now() - baseStart));
                                    el.time.textContent = fmtTime(d, tzUsed);
                                }, 1000);
                            }

                            async function reverseLabelFull(lat, lon) {
                                if (FORCE_CITY && CITY.label) return CITY.label;
                                try {
                                    const j = await fetchJSON(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&accept-language=id&zoom=16&lat=${lat}&lon=${lon}`);
                                    if (j && j.address) {
                                        const a = j.address;
                                        const area = a.neighbourhood || a.quarter || a.hamlet || a.suburb || a.village || a.town || a.city_district || a.district;
                                        const city = a.city || a.municipality || a.town || a.county || a.state_district;
                                        const country = a.country;
                                        const parts = [area, city, country].filter(Boolean);
                                        if (parts.length) return parts.join(', ');
                                    }
                                } catch (_) {}
                                return `${lat.toFixed(5)}, ${lon.toFixed(5)}`;
                            }

                            async function paintWeather(lat, lon, acc) {
                                try {
                                    const wx = await fetchJSON(`${API_WX}?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}&units=metric&daily=1`);
                                    if (!wx.ok) throw new Error(wx.error || 'wx');
                                    const cur = wx.data.current || {},
                                        daily = wx.data.daily || {};
                                    tzUsed = (wx.data.location && wx.data.location.timezone) || 'Asia/Jakarta';
                                    el.tz.textContent = 'Asia/Jakarta';

                                    baseNow = null;
                                    try {
                                        const t = await fetchJSON(`${API_TIME}?timezone=${encodeURIComponent(tzUsed)}`);
                                        if (t.ok && t.datetime) baseNow = new Date(t.datetime);
                                    } catch (_) {}
                                    if (!baseNow) baseNow = new Date();

                                    el.loc.textContent = await reverseLabelFull(lat, lon);
                                    el.date.textContent = fmtDate(baseNow, tzUsed);
                                    el.time.textContent = fmtTime(baseNow, tzUsed);
                                    el.acc.textContent = acc != null ? `±${Math.round(acc)} m` : '±– m';
                                    startClock();

                                    const WMO = {
                                        0: 'Cerah',
                                        1: 'Cerah Berawan',
                                        2: 'Berawan',
                                        3: 'Mendung',
                                        45: 'Berkabut',
                                        48: 'Berkabut',
                                        51: 'Gerimis ringan',
                                        53: 'Gerimis',
                                        55: 'Gerimis lebat',
                                        61: 'Hujan ringan',
                                        63: 'Hujan sedang',
                                        65: 'Hujan lebat',
                                        66: 'Hujan beku ringan',
                                        67: 'Hujan beku lebat',
                                        71: 'Salju ringan',
                                        73: 'Salju',
                                        75: 'Salju lebat',
                                        77: 'Butiran salju',
                                        80: 'Hujan deras singkat',
                                        81: 'Hujan deras',
                                        82: 'Hujan sangat deras',
                                        85: 'Hujan salju',
                                        86: 'Hujan salju lebat',
                                        95: 'Badai petir',
                                        96: 'Badai petir (es ringan)',
                                        99: 'Badai petir (es lebat)'
                                    };

                                    const tC = cur.temperature_2m,
                                        tAP = cur.apparent_temperature;
                                    el.temp.textContent = (tC != null ? `${tC.toFixed(1)}°C` : '–') + (tAP != null ? ` (${tAP.toFixed(1)}°C)` : '');
                                    el.cond.textContent = (cur.weather_code != null ? (WMO[cur.weather_code] || `Kode ${cur.weather_code}`) : '–');

                                    const ws = cur.wind_speed_10m,
                                        wd = cur.wind_direction_10m;
                                    const dir = degToCompass16(wd);
                                    el.wind.textContent = (ws != null ? `${Math.round(ws)} km/j` : '–') + (dir ? ` • ${dir}` : '');

                                    const rh = cur.relative_humidity_2m;
                                    el.hum.textContent = (rh != null ? `${rh}%` : '–');

                                    if (daily && daily.sunrise && daily.sunrise[0] && daily.sunset && daily.sunset[0]) {
                                        const sr = new Date(daily.sunrise[0]),
                                            ss = new Date(daily.sunset[0]);
                                        const fmt = (d) => new Intl.DateTimeFormat('id-ID', {
                                            timeStyle: 'short',
                                            timeZone: tzUsed
                                        }).format(d);
                                        el.sun.textContent = `Sunrise/Sunset: ${fmt(sr)} / ${fmt(ss)}`;
                                    } else el.sun.textContent = 'Sunrise/Sunset: –';

                                    el.updated.textContent = 'Terakhir diperbarui: ' + new Intl.DateTimeFormat('id-ID', {
                                        dateStyle: 'medium',
                                        timeStyle: 'short'
                                    }).format(new Date());
                                } catch (e) {
                                    console.warn('paintWeather fail', e);
                                }
                            }

                            // jalankan (paksa Kademangan)
                            try {
                                localStorage.removeItem('wx_last_coords');
                            } catch (_) {}
                            paintWeather(CITY.lat, CITY.lon, null);
                        })();
                    </script>

                    <!-- (Opsional) COUNT-UP angka stat -->
                    <script>
                        (function() {
                            const ENABLE_COUNTUP = false; // ubah ke true kalau mau animasi
                            if (!ENABLE_COUNTUP) return;
                            const els = document.querySelectorAll('.stat-value[data-count]');
                            els.forEach(el => {
                                const target = parseInt(el.getAttribute('data-count') || '0', 10);
                                const start = 0,
                                    dur = 600;
                                const t0 = performance.now();

                                function tick(now) {
                                    const p = Math.min(1, (now - t0) / dur);
                                    const val = Math.round(start + (target - start) * p);
                                    el.textContent = val.toLocaleString('id-ID');
                                    if (p < 1) requestAnimationFrame(tick);
                                }
                                requestAnimationFrame(tick);
                            });
                        })();
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>