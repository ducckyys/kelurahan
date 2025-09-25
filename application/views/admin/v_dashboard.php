<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Dasbor</h4>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_sktm') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-shield-alt text-warning"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">SKTM</p>
                                    <h4 class="card-title"><?= $total_sktm; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_belum_bekerja') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-user text-info"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Belum Bekerja</p>
                                    <h4 class="card-title"><?= $total_belum_bekerja; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_domisili_yayasan') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-university text-success"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Domisili Yayasan</p>
                                    <h4 class="card-title"><?= $total_domisili_yayasan; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_belum_memiliki_rumah') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-home text-primary"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Belum Punya Rumah</p>
                                    <h4 class="card-title"><?= $total_belum_rumah; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_kematian') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-crosshairs text-secondary"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Kematian Dukcapil</p>
                                    <h4 class="card-title"><?= $total_kematian; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_kematian_nondukcapil') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-user-times text-danger"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Kematian Non Dukcapil</p>
                                    <h4 class="card-title"><?= $total_kematian_non; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="<?= base_url('admin/surat_suami_istri') ?>" style="text-decoration: none;">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-section"><i class="fa fa-users text-muted"></i></div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Suami Istri</p>
                                    <h4 class="card-title"><?= $total_suami_istri; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Aktivitas Pengajuan Surat Terbaru</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <th>Jenis Surat</th>
                                    <th>Nama Pemohon/Yayasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pengajuan_terbaru)): ?>
                                    <?php foreach ($pengajuan_terbaru as $item): ?>
                                        <tr>
                                            <td><?= date('d M Y, H:i', strtotime($item->tanggal_masuk)); ?></td>
                                            <td><span class="badge badge-primary"><?= $item->jenis_surat; ?></span></td>
                                            <td><?= html_escape($item->nama); ?></td>
                                            <td>
                                                <a href="<?= base_url($item->url . '/detail/' . $item->id); ?>" class="btn btn-info btn-sm">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pengajuan surat yang masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>