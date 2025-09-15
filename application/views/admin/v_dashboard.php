<div class="page-inner">
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Izin Usaha</p>
                                <h4 class="card-title"><?= $jumlah_usaha; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pengantar Nikah</p>
                                <h4 class="card-title"><?= $jumlah_nikah; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">SKTM</p>
                                <h4 class="card-title"><?= $jumlah_sktm; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Selamat Datang di Dasbor Admin!</h4>
                </div>
                <div class="card-body">
                    <p>Halo, <strong><?= $this->session->userdata('nama'); ?></strong>! 👋</p>
                    <p>Ini adalah pusat kendali untuk Website Kelurahan. Gunakan menu di samping kiri untuk mengelola konten dan data pengajuan surat dari warga.</p>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/profil') ?>" class="btn btn-sm btn-light mr-2"><i class="fas fa-user-circle mr-1"></i> Profil Saya</a>
                        <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ringkasan Konten</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('admin/berita') ?>">Total Berita</a>
                            <span class="badge badge-primary badge-pill"><?= $jumlah_berita; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('admin/galeri') ?>">Total Galeri</a>
                            <span class="badge badge-info badge-pill"><?= $jumlah_galeri; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('admin/informasi') ?>">Total Informasi</a>
                            <span class="badge badge-success badge-pill"><?= $jumlah_informasi; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>