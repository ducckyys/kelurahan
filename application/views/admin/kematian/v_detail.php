<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Kematian Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_kematian') ?>">Data Kematian Dukcapil</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Pengajuan an. <?= html_escape($surat->nama); ?></h4>
                        <a href="<?= base_url('admin/surat_kematian'); ?>" class="btn btn-secondary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    $bisaCetak = true;
                    if (empty($surat->nomor_surat)) $bisaCetak = false;
                    if ($surat->status != 'Disetujui') $bisaCetak = false;
                    ?>
                    <?php if (!$bisaCetak): ?>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Surat Belum Siap Cetak!</h4>
                            <p class="mb-0">Pastikan <b>Nomor Surat</b> sudah diisi dan <b>Status</b> telah diubah menjadi "Disetujui" di halaman edit.</p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Almarhum/Almarhumah</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama); ?></dd>
                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nik); ?></dd>
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_lahir); ?>, <?= !empty($surat->tanggal_lahir) ? date('d M Y', strtotime($surat->tanggal_lahir)) : '-'; ?></dd>
                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kelamin); ?></dd>
                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->agama); ?></dd>
                                <dt class="col-sm-4">Pekerjaan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pekerjaan); ?></dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->alamat)); ?></dd>
                            </dl>
                            <hr>
                            <h5>Data Kematian</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Hari/Tanggal</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->hari_meninggal); ?>, <?= !empty($surat->tanggal_meninggal) ? date('d M Y', strtotime($surat->tanggal_meninggal)) : '-'; ?></dd>
                                <dt class="col-sm-4">Jam</dt>
                                <dd class="col-sm-8">: <?= !empty($surat->jam_meninggal) ? html_escape(substr($surat->jam_meninggal, 0, 5)) . ' WIB' : '-'; ?></dd>
                                <dt class="col-sm-4">Tempat</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_meninggal); ?></dd>
                                <dt class="col-sm-4">Sebab</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->sebab_meninggal); ?></dd>
                                <dt class="col-sm-4">Pemakaman</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_pemakaman); ?></dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h5>Data Administrasi</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-8">:
                                    <?php
                                    if ($surat->status == 'Pending') $badge = 'badge-warning';
                                    elseif ($surat->status == 'Disetujui') $badge = 'badge-success';
                                    else $badge = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge; ?>"><?= $surat->status; ?></span>
                                </dd>
                                <dt class="col-sm-4">Nomor Surat</dt>
                                <dd class="col-sm-8">: <strong><?= $surat->nomor_surat ? html_escape($surat->nomor_surat) : '<span class="text-muted">Belum diinput</span>'; ?></strong></dd>
                            </dl>
                            <hr>
                            <h5>Data Pelapor</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pelapor_nama); ?></dd>
                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pelapor_nik); ?></dd>
                                <dt class="col-sm-4">No. Telepon</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pelapor_no_telepon); ?></dd>
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pelapor_tempat_lahir); ?>, <?= !empty($surat->pelapor_tanggal_lahir) ? date('d M Y', strtotime($surat->pelapor_tanggal_lahir)) : '-'; ?></dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->pelapor_alamat)); ?></dd>
                                <dt class="col-sm-4">Hubungan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pelapor_hubungan); ?></dd>
                            </dl>

                            <hr>
                            <h5>Dokumen Pendukung</h5>
                            <dl class="row">
                                <dt class="col-sm-4">No. Surat RT/RW</dt>
                                <dd class="col-sm-8">: <?= $surat->nomor_surat_rt ? html_escape($surat->nomor_surat_rt) : '-'; ?></dd>
                                <dt class="col-sm-4">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-8">: <?= $surat->tanggal_surat_rt ? date('d M Y', strtotime($surat->tanggal_surat_rt)) : '-'; ?></dd>
                                <dt class="col-sm-12 mt-2">Lampiran</dt>
                                <dd class="col-sm-12">
                                    <?php
                                    $files = [];
                                    if (!empty($surat->dokumen_pendukung)) {
                                        $dec = json_decode($surat->dokumen_pendukung, true);
                                        if (is_array($dec)) $files = $dec;
                                        else $files = [$surat->dokumen_pendukung];
                                    }
                                    ?>
                                    <?php if (!empty($files)): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($files as $fn): ?>
                                                <li class="mb-1">
                                                    <i class="fa fa-paperclip"></i>
                                                    <a href="<?= base_url('uploads/pendukung/' . $fn) ?>" target="_blank" rel="noopener">
                                                        <?= html_escape($fn) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada dokumen terunggah.</span>
                                    <?php endif; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="<?= base_url('admin/surat_kematian/edit/' . $surat->id); ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit Data Ini</a>
                    <?php if ($bisaCetak): ?>
                        <a href="<?= base_url('admin/surat_kematian/cetak/' . $surat->id); ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Cetak Surat (PDF)</a>
                    <?php else: ?>
                        <button class="btn btn-success" disabled><i class="fa fa-print"></i> Cetak Surat (PDF)</button>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>