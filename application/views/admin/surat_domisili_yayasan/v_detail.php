<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Domisili Yayasan</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_domisili_yayasan') ?>">Data Domisili Yayasan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Pengajuan: <?= html_escape($surat->nama_organisasi); ?></h4>
                        <a href="<?= base_url('admin/surat_domisili_yayasan'); ?>" class="btn btn-secondary btn-round ml-auto">
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
                            <h5>Data Penanggung Jawab</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_penanggung_jawab); ?></dd>
                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nik); ?></dd>
                                <dt class="col-sm-4">No. Telepon</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->telepon_pemohon); ?></dd>
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_lahir . ', ' . date('d M Y', strtotime($surat->tanggal_lahir))); ?></dd>
                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kelamin); ?></dd>
                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->agama); ?></dd>
                                <dt class="col-sm-4">Kewarganegaraan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->kewarganegaraan); ?></dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->alamat_pemohon); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Yayasan / Organisasi</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Yayasan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_organisasi); ?></dd>
                                <dt class="col-sm-4">Jenis Kegiatan</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kegiatan); ?></dd>
                                <dt class="col-sm-4">Jumlah Pengurus</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jumlah_pengurus); ?> Orang</dd>
                                <dt class="col-sm-4">NPWP</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->npwp); ?></dd>
                                <dt class="col-sm-4">Alamat Kantor</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->alamat_kantor); ?></dd>
                            </dl>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Akta Pendirian</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Notaris</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_notaris_pendirian); ?></dd>
                                <dt class="col-sm-4">Nomor Akta</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nomor_akta_pendirian); ?></dd>
                                <dt class="col-sm-4">Tanggal Akta</dt>
                                <dd class="col-sm-8">: <?= date('d M Y', strtotime($surat->tanggal_akta_pendirian)); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h5>Akta Perubahan (Jika Ada)</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Notaris</dt>
                                <dd class="col-sm-8">: <?= !empty($surat->nama_notaris_perubahan) ? html_escape($surat->nama_notaris_perubahan) : '-'; ?></dd>
                                <dt class="col-sm-4">Nomor Akta</dt>
                                <dd class="col-sm-8">: <?= !empty($surat->nomor_akta_perubahan) ? html_escape($surat->nomor_akta_perubahan) : '-'; ?></dd>
                                <dt class="col-sm-4">Tanggal Akta</dt>
                                <dd class="col-sm-8">: <?= !empty($surat->tanggal_akta_perubahan) ? date('d M Y', strtotime($surat->tanggal_akta_perubahan)) : '-'; ?></dd>
                            </dl>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Data Administrasi & Dokumen Pendukung</h5>
                            <dl class="row">
                                <dt class="col-sm-3">Status Pengajuan</dt>
                                <dd class="col-sm-9">:
                                    <?php
                                    if ($surat->status == 'Pending') $badge = 'badge-warning';
                                    elseif ($surat->status == 'Disetujui') $badge = 'badge-success';
                                    else $badge = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge; ?>"><?= $surat->status; ?></span>
                                </dd>
                                <dt class="col-sm-3">Nomor Surat Kelurahan</dt>
                                <dd class="col-sm-9">: <strong><?= $surat->nomor_surat ? html_escape($surat->nomor_surat) : '<span class="text-muted">Belum diinput</span>'; ?></strong></dd>
                                <dt class="col-sm-3">No. Surat RT/RW</dt>
                                <dd class="col-sm-9">: <?= html_escape($surat->nomor_surat_rt); ?></dd>
                                <dt class="col-sm-3">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-9">: <?= date('d M Y', strtotime($surat->tanggal_surat_rt)); ?></dd>

                                <dt class="col-sm-12 mt-2">Lampiran</dt>
                                <dd class="col-sm-12">
                                    <?php
                                    $files = [];
                                    if (!empty($surat->dokumen_pendukung)) {
                                        $decoded = json_decode($surat->dokumen_pendukung, true);
                                        if (is_array($decoded)) $files = $decoded;
                                        elseif (is_string($surat->dokumen_pendukung)) $files = [$surat->dokumen_pendukung];
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
                    <a href="<?= base_url('admin/surat_domisili_yayasan/edit/' . $surat->id); ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>

                    <?php if ($bisaCetak): ?>
                        <?php if (!empty($signers)): ?>
                            <form class="form-inline d-inline-flex align-items-center ml-2"
                                action="<?= base_url('admin/surat_domisili_yayasan/cetak/' . $surat->id); ?>"
                                method="get" target="_blank">

                                <!-- Tombol Cetak di kiri -->
                                <button type="submit" class="btn btn-success mr-2">
                                    <i class="fa fa-print"></i> Cetak Surat
                                </button>

                                <!-- Dropdown penandatangan di kanan tombol -->
                                <label for="ttd" class="mb-0 mr-2">Penandatangan:</label>
                                <select name="ttd" id="ttd" class="form-control" style="min-width:320px" required>
                                    <?php foreach ($signers as $s): ?>
                                        <option value="<?= (int)$s->id; ?>"
                                            <?= ($default_signer_id && (int)$default_signer_id === (int)$s->id) ? 'selected' : '' ?>>
                                            <?= html_escape($s->jabatan_nama . ' - ' . $s->nama); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-success ml-2" disabled title="Data penandatangan belum diisi di menu Pengaturan → Pejabat">
                                <i class="fa fa-print"></i> Cetak Surat
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn btn-success" disabled title="Lengkapi data di halaman edit terlebih dahulu">
                            <i class="fa fa-print"></i> Cetak Surat
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>