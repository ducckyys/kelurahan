<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Pengajuan Belum Memiliki Rumah</h4>
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
                    <div class="row">
                        <!-- Kiri -->
                        <div class="col-md-6">
                            <h5>Data Diri</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_pemohon); ?></dd>

                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nik); ?></dd>

                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">:
                                    <?= html_escape($surat->tempat_lahir); ?>,
                                    <?= !empty($surat->tanggal_lahir) ? date('d M Y', strtotime($surat->tanggal_lahir)) : '-'; ?>
                                </dd>


                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kelamin); ?></dd>

                                <dt class="col-sm-4">Kewarganegaraan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->kewarganegaraan); ?></dd>

                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->agama); ?></dd>

                                <dt class="col-sm-4">Pekerjaan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->pekerjaan); ?></dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->alamat)); ?></dd>
                            </dl>
                        </div>

                        <!-- Kanan -->
                        <div class="col-md-6">
                            <h5>Data Pengajuan</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Keperluan</dt>
                                <dd class="col-sm-8">: <?= nl2br(html_escape($surat->keperluan)); ?></dd>

                                <dt class="col-sm-4">Tgl. Pengajuan</dt>
                                <dd class="col-sm-8">:
                                    <?= !empty($surat->created_at) ? date('d M Y, H:i', strtotime($surat->created_at)) . ' WIB' : '-'; ?>
                                </dd>
                            </dl>
                            <hr>
                            <h5>Dokumen Pendukung</h5>
                            <dl class="row">
                                <dt class="col-sm-4">No. Surat RT/RW</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nomor_surat_rt); ?></dd>

                                <dt class="col-sm-4">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-8">:
                                    <?= !empty($surat->tanggal_surat_rt) ? date('d M Y', strtotime($surat->tanggal_surat_rt)) : '-'; ?>
                                </dd>

                                <dt class="col-sm-12 mt-2">
                                    <?php if (!empty($surat->scan_surat_rt)): ?>
                                        <a href="<?= base_url('uploads/surat_rt/' . $surat->scan_surat_rt); ?>" target="_blank" class="btn btn-primary btn-block">
                                            <i class="fas fa-file-alt"></i> Lihat Surat Pengantar RT/RW
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Lampiran tidak tersedia.</span>
                                    <?php endif; ?>
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="<?= base_url('admin/surat_belum_memiliki_rumah/edit/' . $surat->id); ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>
                    <a href="<?= base_url('admin/surat_belum_memiliki_rumah/cetak/' . $surat->id); ?>" target="_blank" class="btn btn-success">
                        <i class="fa fa-print"></i> Cetak Surat (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>