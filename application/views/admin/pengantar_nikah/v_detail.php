<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Pengantar Nikah</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_pengantar_nikah') ?>">Data Pengantar Nikah</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>

    <?php
    $fmtDate = function ($date, $format = 'd M Y') {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') return '-';
        $ts = strtotime($date);
        return $ts ? date($format, $ts) : '-';
    };
    $fmt = fn($t) => (isset($t) && $t !== '') ? html_escape($t) : '<span class="text-muted">-</span>';

    $badge = ($surat->status === 'Pending') ? 'badge-warning' : (($surat->status === 'Disetujui') ? 'badge-success' : 'badge-danger');

    $files = [];
    if (!empty($surat->dokumen_pendukung)) {
        $dec = json_decode($surat->dokumen_pendukung, true);
        if (is_array($dec)) $files = $dec;
        elseif (is_string($surat->dokumen_pendukung)) $files = [$surat->dokumen_pendukung];
    }

    $bisaCetak = isset($bisaCetak) ? $bisaCetak : (!empty($surat->nomor_surat) && ($surat->status === 'Disetujui'));
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Data Pengajuan</h4>
                        <a href="<?= base_url('admin/surat_pengantar_nikah'); ?>" class="btn btn-secondary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (!$bisaCetak): ?>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Surat Belum Siap Cetak!</h4>
                            <p class="mb-0">Pastikan <b>Nomor Surat</b> sudah diisi dan <b>Status</b> telah diubah menjadi "<b>Disetujui</b>" di halaman edit.</p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Kolom kiri: Pihak Pria + Ortu -->
                        <div class="col-md-6">
                            <h5>Pihak Pria (Pemohon)</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_nama); ?></dd>

                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_nik); ?></dd>

                                <dt class="col-sm-5">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_tempat_lahir); ?>, <?= $fmtDate($surat->pria_tanggal_lahir); ?></dd>

                                <dt class="col-sm-5">Kewarganegaraan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_kewarganegaraan); ?></dd>

                                <dt class="col-sm-5">Agama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_agama); ?></dd>

                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_pekerjaan); ?></dd>

                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->pria_alamat); ?></dd>

                                <dt class="col-sm-5">Status Pria</dt>
                                <dd class="col-sm-7">:
                                    <?php
                                    $statusPria = html_escape($surat->pria_status);
                                    if ($surat->pria_status === 'Beristri' && !empty($surat->pria_istri_ke)) {
                                        $statusPria .= ' (Istri ke-' . html_escape($surat->pria_istri_ke) . ')';
                                    }
                                    echo $statusPria;
                                    ?>
                                </dd>
                            </dl>

                            <hr>
                            <h5>Data Orang Tua</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama Ortu</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_nama); ?></dd>

                                <dt class="col-sm-5">NIK Ortu</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_nik); ?></dd>

                                <dt class="col-sm-5">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_tempat_lahir); ?>, <?= $fmtDate($surat->ortu_tanggal_lahir); ?></dd>

                                <dt class="col-sm-5">Kewarganegaraan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_kewarganegaraan); ?></dd>

                                <dt class="col-sm-5">Agama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_agama); ?></dd>

                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_pekerjaan); ?></dd>

                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->ortu_alamat); ?></dd>
                            </dl>
                        </div>

                        <!-- Kolom kanan: Pihak Wanita + Administrasi + Lampiran -->
                        <div class="col-md-6">
                            <h5>Pihak Wanita</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_nama); ?></dd>

                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_nik); ?></dd>

                                <dt class="col-sm-5">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_tempat_lahir); ?>, <?= $fmtDate($surat->wanita_tanggal_lahir); ?></dd>

                                <dt class="col-sm-5">Kewarganegaraan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_kewarganegaraan); ?></dd>

                                <dt class="col-sm-5">Agama</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_agama); ?></dd>

                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_pekerjaan); ?></dd>

                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_alamat); ?></dd>

                                <dt class="col-sm-5">Status Wanita</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->wanita_status); ?></dd>
                            </dl>

                            <hr>

                            <h5>Administrasi</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Status</dt>
                                <dd class="col-sm-7">:
                                    <span class="badge <?= $badge; ?>"><?= html_escape($surat->status); ?></span>
                                </dd>

                                <dt class="col-sm-5">Nomor Surat Kelurahan</dt>
                                <dd class="col-sm-7">:
                                    <?= !empty($surat->nomor_surat) ? '<strong>' . html_escape($surat->nomor_surat) . '</strong>' : '<span class="text-muted">Belum diinput</span>'; ?>
                                </dd>

                                <dt class="col-sm-5">No. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmt($surat->nomor_surat_rt); ?></dd>

                                <dt class="col-sm-5">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-7">: <?= $fmtDate($surat->tanggal_surat_rt); ?></dd>

                                <dt class="col-sm-5">Tgl. Pengajuan</dt>
                                <dd class="col-sm-7">:
                                    <?= !empty($surat->created_at) ? date('d M Y, H:i', strtotime($surat->created_at)) . ' WIB' : '-' ?>
                                </dd>
                            </dl>

                            <hr>

                            <h5>Dokumen Lampiran</h5>
                            <?php if (!empty($files)): ?>
                                <ul class="list-unstyled">
                                    <?php foreach ($files as $fn): ?>
                                        <li class="mb-1">
                                            <i class="fa fa-paperclip"></i>
                                            <a href="<?= base_url('uploads/nikah/' . $fn) ?>" target="_blank" rel="noopener">
                                                <?= html_escape($fn) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada dokumen terunggah.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex flex-wrap align-items-center gap-2">
                    <a href="<?= base_url('admin/surat_pengantar_nikah/edit/' . $surat->id); ?>" class="btn btn-warning mr-2">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>

                    <?php if (!empty($bisaCetak) && $bisaCetak): ?>
                        <?php if (!empty($signers)): ?>
                            <form class="form-inline d-inline-flex align-items-center"
                                action="<?= base_url('admin/surat_pengantar_nikah/cetak/' . $surat->id); ?>"
                                method="get" target="_blank">
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fa fa-print"></i> Cetak Surat (PDF)
                                </button>

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
                        <button class="btn btn-success" disabled title="Lengkapi Nomor Surat & setujui pengajuan untuk mengaktifkan cetak">
                            <i class="fa fa-print"></i> Cetak Surat (PDF)
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>