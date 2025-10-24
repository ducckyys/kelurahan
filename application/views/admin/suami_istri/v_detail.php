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
    $fmtDate = function ($date, $format = 'd M Y') {
        if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') return '<span class="text-muted">-</span>';
        $ts = strtotime($date);
        return $ts ? date($format, $ts) : '<span class="text-muted">-</span>';
    };
    $fmt = fn($t) => (isset($t) && $t !== '') ? html_escape($t) : '<span class="text-muted">-</span>';

    $bisaCetak = $bisaCetak ?? (!empty($surat->nomor_surat) && $surat->status === 'Disetujui');
    $badge = $surat->status === 'Pending' ? 'badge-warning' : ($surat->status === 'Disetujui' ? 'badge-success' : 'badge-danger');

    $files = [];
    if (!empty($surat->dokumen_pendukung)) {
        $decoded = json_decode($surat->dokumen_pendukung, true);
        if (is_array($decoded)) $files = $decoded;
        elseif (is_string($surat->dokumen_pendukung)) $files = [$surat->dokumen_pendukung];
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title">Detail Pengajuan: <?= html_escape($surat->nama_pihak_satu); ?></h4>
                    <a href="<?= base_url('admin/surat_suami_istri'); ?>" class="btn btn-secondary btn-round ml-auto"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>

                <div class="card-body">
                    <?php if (!$bisaCetak): ?>
                        <div class="alert alert-warning">
                            <h5 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Surat Belum Siap Cetak</h5>
                            <p class="mb-0">Pastikan <b>Nomor Surat</b> sudah diisi dan <b>Status</b> diubah ke <b>Disetujui</b> di halaman edit.</p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Pihak Pertama (Pemohon)</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nama_pihak_satu); ?></dd>
                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nik_pihak_satu); ?></dd>
                                <dt class="col-sm-5">No. Telepon</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->telepon_pemohon); ?></dd>
                                <dt class="col-sm-5">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->tempat_lahir_pihak_satu); ?>, <?= $fmtDate($surat->tanggal_lahir_pihak_satu); ?></dd>
                                <dt class="col-sm-5">JK</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->jenis_kelamin_pihak_satu); ?></dd>
                                <dt class="col-sm-5">Agama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->agama_pihak_satu); ?></dd>
                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pekerjaan_pihak_satu); ?></dd>
                                <dt class="col-sm-5">Warganegara</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->warganegara_pihak_satu); ?></dd>
                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->alamat_pihak_satu); ?></dd>
                            </dl>

                            <hr>
                            <h5>Pihak Kedua (Pasangan)</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nama_pihak_dua); ?></dd>
                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nik_pihak_dua); ?></dd>
                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->alamat_pihak_dua); ?></dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h5>Administrasi</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Status</dt>
                                <dd class="col-sm-7">: <span class="badge <?= $badge; ?>"><?= html_escape($surat->status); ?></span></dd>
                                <dt class="col-sm-5">Nomor Surat</dt>
                                <dd class="col-sm-7">: <?= !empty($surat->nomor_surat) ? '<strong>' . html_escape($surat->nomor_surat) . '</strong>' : '<span class="text-muted">Belum diinput</span>'; ?></dd>
                                <dt class="col-sm-5">Keperluan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->keperluan); ?></dd>
                                <dt class="col-sm-5">Tgl. Pengajuan</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->created_at, 'd M Y, H:i'); ?> WIB</dd>
                            </dl>

                            <hr>
                            <h5>Dokumen Pengantar & Lampiran</h5>
                            <dl class="row">
                                <dt class="col-sm-5">No. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nomor_surat_rt); ?></dd>
                                <dt class="col-sm-5">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->tanggal_surat_rt); ?></dd>

                                <dt class="col-sm-12 mt-2">Lampiran</dt>
                                <dd class="col-sm-12">
                                    <?php if (!empty($files)): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($files as $fn): ?>
                                                <li class="mb-1">
                                                    <i class="fa fa-paperclip"></i>
                                                    <a href="<?= base_url('uploads/pendukung/' . $fn) ?>" target="_blank" rel="noopener"><?= html_escape($fn) ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada dokumen terunggah.</span>
                                    <?php endif; ?>
                                </dd>

                                <?php if (!empty($surat->scan_surat_rt)): ?>
                                    <dt class="col-sm-12 mt-2">
                                        <a href="<?= base_url('uploads/surat_rt/' . $surat->scan_surat_rt); ?>" class="btn btn-primary btn-block" target="_blank">
                                            <i class="fas fa-file-alt"></i> Lihat Surat Pengantar RT/RW
                                        </a>
                                    </dt>
                                <?php endif; ?>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex align-items-center flex-wrap">
                    <a href="<?= base_url('admin/surat_suami_istri/edit/' . $surat->id); ?>" class="btn btn-warning mr-2">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>

                    <?php if (!empty($bisaCetak) && $bisaCetak): ?>
                        <?php if (!empty($signers)): ?>
                            <form class="form-inline d-inline-flex align-items-center"
                                action="<?= base_url('admin/surat_suami_istri/cetak/' . $surat->id); ?>"
                                method="get" target="_blank">
                                <!-- tombol cetak -->
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fa fa-print"></i> Cetak Surat (PDF)
                                </button>

                                <!-- dropdown penandatangan -->
                                <label for="ttd" class="mb-0 mr-2">Penandatangan:</label>
                                <select name="ttd" id="ttd" class="form-control" style="min-width:320px" required>
                                    <?php foreach ($signers as $s): ?>
                                        <option value="<?= (int)$s->id; ?>"
                                            <?= (isset($default_signer_id) && (int)$default_signer_id === (int)$s->id) ? 'selected' : '' ?>>
                                            <?= html_escape($s->jabatan_nama . ' - ' . $s->nama); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-success" disabled title="Data penandatangan belum diisi di Pengaturan → Pejabat">
                                <i class="fa fa-print"></i> Cetak Surat (PDF)
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn btn-success" disabled><i class="fa fa-print"></i> Cetak Surat</button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>