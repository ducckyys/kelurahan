<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Belum Memiliki Rumah</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_belum_memiliki_rumah') ?>">Data Belum Memiliki Rumah</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Data Pemohon</h4>
                        <a href="<?= base_url('admin/surat_belum_memiliki_rumah'); ?>" class="btn btn-secondary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $bisaCetak = true;
                    $pesanError = [];
                    if (empty($surat->nomor_surat)) {
                        $bisaCetak = false;
                        $pesanError[] = '<strong>Nomor Surat</strong> belum diisi.';
                    }
                    if ($surat->status != 'Disetujui') {
                        $bisaCetak = false;
                        $pesanError[] = '<strong>Status Surat</strong> masih "' . $surat->status . '", belum "Disetujui".';
                    }

                    if (!$bisaCetak):
                    ?>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Surat Belum Siap Cetak!</h4>
                            <p class="mb-0">Pastikan <b>**Nomor Surat**</b> sudah diisi dan <b>**Status**</b> telah diubah menjadi "Disetujui" di halaman edit.</p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Diri</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_pemohon); ?></dd>
                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nik); ?></dd>
                                <dt class="col-sm-4">No. Telepon</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->telepon_pemohon); ?></dd>
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_lahir); ?>, <?= !empty($surat->tanggal_lahir) ? date('d M Y', strtotime($surat->tanggal_lahir)) : '-'; ?></dd>
                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kelamin); ?></dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->alamat)); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Pengajuan</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Status Pengajuan</dt>
                                <dd class="col-sm-8">
                                    : <?php
                                        if ($surat->status == 'Pending') $badge = 'badge-warning';
                                        elseif ($surat->status == 'Disetujui') $badge = 'badge-success';
                                        else $badge = 'badge-danger';
                                        ?>
                                    <span class="badge <?= $badge; ?>"><?= $surat->status; ?></span>
                                </dd>
                                <dt class="col-sm-4">Nomor Surat Kelurahan</dt>
                                <dd class="col-sm-8">:<strong><?= html_escape($surat->nomor_surat) ?: '<span class="text-muted">Belum diinput</span>'; ?></strong></dd>
                                <dt class="col-sm-4">Keperluan</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->keperluan)); ?></dd>
                                <dt class="col-sm-4">Tgl. Pengajuan</dt>
                                <dd class="col-sm-8">:<?= !empty($surat->created_at) ? date('d M Y, H:i', strtotime($surat->created_at)) . ' WIB' : '-'; ?></dd>
                            </dl>
                            <hr>
                            <h5>Dokumen Pendukung</h5>
                            <dl class="row">
                                <dt class="col-sm-4">No. Surat RT/RW</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nomor_surat_rt); ?></dd>
                                <dt class="col-sm-4">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-8">:<?= !empty($surat->tanggal_surat_rt) ? date('d M Y', strtotime($surat->tanggal_surat_rt)) : '-'; ?></dd>
                                <dt class="col-sm-12 mt-2"><a href="<?= base_url('uploads/surat_rt/' . $surat->scan_surat_rt); ?>" target="_blank" class="btn btn-primary btn-block"><i class="fas fa-file-alt"></i> Lihat Surat Pengantar</a></dt>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/surat_belum_memiliki_rumah/edit/' . $surat->id); ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit Data Ini</a>
                    <?php if ($bisaCetak): ?>
                        <a href="<?= base_url('admin/surat_belum_memiliki_rumah/cetak/' . $surat->id); ?>" target="_blank" class="btn btn-success">
                            <i class="fa fa-print"></i> Cetak Surat (PDF)
                        </a>
                    <?php else: ?>
                        <button class="btn btn-success" disabled title="Lengkapi data di halaman edit terlebih dahulu">
                            <i class="fa fa-print"></i> Cetak Surat (PDF)
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>