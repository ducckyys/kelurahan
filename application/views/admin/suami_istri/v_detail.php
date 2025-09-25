<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Ket. Suami Istri</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_suami_istri'); ?>">Data Ket. Suami Istri</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>

    <?php
    // helper mini untuk tampilan tanggal aman
    $fmtDate = function ($date, $format = 'd M Y') {
        if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') return '<span class="text-muted">-</span>';
        $ts = strtotime($date);
        return $ts ? date($format, $ts) : '<span class="text-muted">-</span>';
    };
    $fmtText = function ($text) {
        return (isset($text) && $text !== '') ? html_escape($text) : '<span class="text-muted">-</span>';
    };

    // syarat cetak
    $bisaCetak = true;
    $pesanError = [];
    if (empty($surat->nomor_surat)) {
        $bisaCetak = false;
        $pesanError[] = 'Nomor surat belum diisi.';
    }
    if ($surat->status !== 'Disetujui') {
        $bisaCetak = false;
        $pesanError[] = 'Status surat masih "' . html_escape($surat->status) . '", belum "Disetujui".';
    }

    // path file upload (sesuai controller: ./uploads/suami_istri/)
    $fileUrl = !empty($surat->scan_surat_rt) ? base_url('uploads/suami_istri/' . $surat->scan_surat_rt) : null;
    $fileExists = !empty($surat->scan_surat_rt) && file_exists(FCPATH . 'uploads/suami_istri/' . $surat->scan_surat_rt);

    // badge status
    $badge = 'badge-secondary';
    if ($surat->status === 'Pending')   $badge = 'badge-warning';
    if ($surat->status === 'Disetujui') $badge = 'badge-success';
    if ($surat->status === 'Ditolak')   $badge = 'badge-danger';
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center w-100">
                        <h4 class="card-title">Detail Pengajuan: <?= html_escape($surat->nama_pihak_satu); ?></h4>
                        <div class="ml-auto">
                            <a href="<?= base_url('admin/surat_suami_istri'); ?>" class="btn btn-secondary btn-round">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <?php if (!$bisaCetak): ?>
                        <div class="alert alert-warning" role="alert">
                            <h5 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Surat Belum Siap Cetak</h5>
                            <ul class="mb-0 pl-4">
                                <?php foreach ($pesanError as $err): ?>
                                    <li><?= $err; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <small class="d-block mt-2">Silakan lengkapi di halaman <a href="<?= base_url('admin/surat_suami_istri/edit/' . $surat->id); ?>"><u>Edit</u></a>.</small>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- KOLOM KIRI -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Pihak Pertama (Pemohon)</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama Lengkap</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->nama_pihak_satu); ?></dd>

                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->nik_pihak_satu); ?></dd>

                                <dt class="col-sm-5">No. Telepon</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->telepon_pemohon); ?></dd>

                                <dt class="col-sm-5">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-7">
                                    : <?= $fmtText($surat->tempat_lahir_pihak_satu); ?>,
                                    <?= $fmtDate($surat->tanggal_lahir_pihak_satu); ?>
                                </dd>

                                <dt class="col-sm-5">Jenis Kelamin</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->jenis_kelamin_pihak_satu); ?></dd>

                                <dt class="col-sm-5">Agama</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->agama_pihak_satu); ?></dd>

                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->pekerjaan_pihak_satu); ?></dd>

                                <dt class="col-sm-5">Kewarganegaraan</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->warganegara_pihak_satu); ?></dd>

                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->alamat_pihak_satu); ?></dd>
                            </dl>

                            <hr>

                            <h5 class="mb-3">Pihak Kedua (Pasangan)</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama Lengkap</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->nama_pihak_dua); ?></dd>

                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->nik_pihak_dua); ?></dd>

                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->alamat_pihak_dua); ?></dd>
                            </dl>
                        </div>

                        <!-- KOLOM KANAN -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Data Administrasi</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Status Pengajuan</dt>
                                <dd class="col-sm-7">:
                                    <span class="badge <?= $badge; ?>"><?= html_escape($surat->status); ?></span>
                                </dd>

                                <dt class="col-sm-5">Nomor Surat</dt>
                                <dd class="col-sm-7">:
                                    <?= !empty($surat->nomor_surat) ? '<strong>' . html_escape($surat->nomor_surat) . '</strong>'
                                        : '<span class="text-muted">Belum diinput</span>'; ?>
                                </dd>

                                <dt class="col-sm-5">Keperluan</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->keperluan); ?></dd>

                                <dt class="col-sm-5">Tgl. Pengajuan</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->created_at, 'd M Y, H:i'); ?> WIB</dd>

                                <dt class="col-sm-5">Tgl. Diperbarui</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->updated_at, 'd M Y, H:i'); ?> WIB</dd>
                            </dl>

                            <hr>

                            <h5 class="mb-3">Dokumen Pengantar RT/RW</h5>
                            <dl class="row">
                                <dt class="col-sm-5">No. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmtText($surat->nomor_surat_rt); ?></dd>

                                <dt class="col-sm-5">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->tanggal_surat_rt); ?></dd>

                                <?php
                                $fname = trim((string)$surat->scan_surat_rt);
                                $fileUrl    = !empty($fname) ? base_url('uploads/surat_rt/' . $fname) : null;
                                $fileExists = !empty($fname) && file_exists(FCPATH . 'uploads/surat_rt/' . $fname);
                                ?>
                                <dt class="col-sm-12 mt-2">
                                    <?php if ($fileExists): ?>
                                        <a href="<?= $fileUrl; ?>" target="_blank" class="btn btn-primary btn-block">
                                            <i class="fas fa-file-alt"></i> Lihat Surat Pengantar
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-light btn-block" type="button" disabled>
                                            <i class="fas fa-file-alt"></i> Surat Pengantar belum diunggah
                                        </button>
                                    <?php endif; ?>
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <a href="<?= base_url('admin/surat_suami_istri/edit/' . $surat->id); ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>

                    <?php if ($bisaCetak): ?>
                        <a href="<?= base_url('admin/surat_suami_istri/cetak/' . $surat->id); ?>" target="_blank" class="btn btn-success">
                            <i class="fa fa-print"></i> Cetak Surat
                        </a>
                    <?php else: ?>
                        <button class="btn btn-success" disabled title="Lengkapi nomor surat & setujui status terlebih dahulu">
                            <i class="fa fa-print"></i> Cetak Surat
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>