<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Surat Domisili Yayasan</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Pengajuan: <?= html_escape($surat->nama_organisasi); ?></h4>
                        <a href="<?= base_url('admin/surat_domisili_yayasan'); ?>" class="btn btn-secondary btn-round ml-auto"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Penanggung Jawab</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nama_penanggung_jawab); ?></dd>
                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->nik); ?></dd>
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->tempat_lahir . ', ' . date('d M Y', strtotime($surat->tanggal_lahir))); ?></dd>
                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->jenis_kelamin); ?></dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: <?= html_escape($surat->alamat_pemohon); ?></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Yayasan</h5>
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
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/surat_domisili_yayasan/edit/' . $surat->id); ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit Data</a>
                    <a href="<?= base_url('admin/surat_domisili_yayasan/cetak/' . $surat->id); ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Cetak Surat</a>
                </div>
            </div>
        </div>
    </div>
</div>