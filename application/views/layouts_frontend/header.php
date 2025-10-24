    <!doctype html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= isset($title) ? $title : 'Kelurahan'; ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/informasi_custom.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/berita_custom.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/pelayanan_custom.css'); ?>">
    </head>

    <body class="is-home has-abstract-bg">
        <nav class="navbar navbar-light bg-white shadow-sm nav-topbar sticky-top">
            <div class="container align-items-center position-relative">
                <!-- Burger (mobile, kiri) -->
                <button class="navbar-toggler d-lg-none me-2" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Brand di TENGAH -->
                <a class="navbar-brand fw-bold navbar-brand-center brand-kademangan" href="<?= site_url('home'); ?>">
                    <span class="brand-line-1">
                        <span class="brand-k">K</span>ademangan
                    </span>
                    <span class="brand-line-2">Solutif &middot; Kolaboratif &middot; Inklusif</span>
                </a>

                <!-- Login (desktop, kanan) -->
                <div class="d-none d-lg-block ms-auto">
                    <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary px-3">Login</a>
                </div>
            </div>
        </nav>

        <!-- NAV 2: Menubar (floating, rounded, center) -->
        <nav class="navbar navbar-expand-lg nav-menubar">
            <div class="container container-menu">
                <div class="menubar-floating">
                    <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                        <?php $seg1 = $this->uri->segment(1) ?: 'home'; ?>
                        <ul class="navbar-nav nav-justified gap-lg-1">

                            <!-- HOME -->
                            <li class="nav-item">
                                <a class="nav-link px-3 d-flex align-items-center gap-2 <?= $seg1 === 'home' ? 'active' : '' ?>"
                                    href="<?= site_url('home'); ?>">
                                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                                    <span>Home</span>
                                </a>
                            </li>

                            <!-- PELAYANAN -->
                            <li class="nav-item dropdown">
                                <!-- Desktop: langsung link -->
                                <a href="<?= site_url('pelayanan'); ?>"
                                    class="nav-link d-none d-lg-flex align-items-center gap-2 px-3 <?= $seg1 === 'pelayanan' ? 'active' : '' ?>">
                                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                    <span>Pelayanan</span>
                                </a>

                                <!-- Mobile: dropdown -->
                                <a href="#"
                                    class="nav-link dropdown-toggle d-lg-none d-flex align-items-center gap-2 px-3"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                    <span>Pelayanan</span>
                                </a>

                                <!-- isi dropdown (sudah FA dan dibetulkan tiponya) -->
                                <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                                    <li>
                                        <h6 class="dropdown-header fw-bold text-primary">
                                            <i class="fas fa-envelope-open-text me-2"></i>Pilih Jenis Surat
                                        </h6>
                                    </li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/tidak-mampu'); ?>">
                                            <i class="fas fa-shield-alt me-2"></i>Surat Keterangan Tidak Mampu (SKTM)
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/belum-bekerja'); ?>">
                                            <i class="fas fa-user me-2"></i>Surat Keterangan Belum Bekerja
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/domisili-yayasan'); ?>">
                                            <i class="fas fa-university me-2"></i>Surat Keterangan Domisili Yayasan
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/belum-memiliki-rumah'); ?>">
                                            <i class="fas fa-home me-2"></i>Surat Keterangan Belum Memiliki Rumah
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/kematian'); ?>">
                                            <i class="fas fa-user-times me-2"></i>Surat Keterangan Kematian (Dukcapil)
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/kematian-nondukcapil'); ?>">
                                            <i class="fas fa-user-slash me-2"></i>Surat Keterangan Kematian (Non Dukcapil)
                                        </a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/suami-istri'); ?>">
                                            <i class="fas fa-users me-2"></i>Surat Keterangan Suami Istri
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-center fw-semibold text-primary" href="<?= site_url('pelayanan'); ?>">
                                            <i class="fas fa-ellipsis-h me-1"></i>Layanan Lainnya
                                        </a></li>
                                </ul>
                            </li>

                            <!-- LKK -->
                            <li class="nav-item dropdown">
                                <!-- Desktop: langsung link (ke landing/sekilas LKK) -->
                                <a href="<?= site_url('#'); ?>"
                                    class="nav-link d-none d-lg-flex align-items-center gap-2 px-3">
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                                    <span>LKK</span>
                                </a>

                                <!-- Mobile: dropdown -->
                                <a href="#" class="nav-link dropdown-toggle d-lg-none d-flex align-items-center gap-2 px-3"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                                    <span>LKK</span>
                                </a>

                                <!-- isi dropdown LKK (FA icons) -->
                                <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                                    <li>
                                        <h6 class="dropdown-header fw-bold text-primary">
                                            <i class="fas fa-sitemap me-2"></i>Lembaga Kemasyarakatan Kelurahan
                                        </h6>
                                    </li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-users me-2"></i>RT dan RW</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-hand-holding-heart me-2"></i>PKK</a></li>
                                    <li><a class="dropdown-item" href="https://www.instagram.com/karangtarunakademangan?igsh=MWZzd2VlcGgxaGM5NQ==" target="_blank" rel="noopener">
                                            <i class="fas fa-hands-helping me-2"></i>Karang Taruna</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-clinic-medical me-2"></i>Posyandu</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-project-diagram me-2"></i>LPM</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-mosque me-2"></i>MUI Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-mosque me-2"></i>DMI Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-quran me-2"></i>LPTQ Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-book-open me-2"></i>Pengajian Al Hidayah</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-recycle me-2"></i>TPS3R dan Bank Sampah</a></li>
                                    <li><a class="dropdown-item" href="<?= site_url('#'); ?>"><i class="fas fa-seedling me-2"></i>KWT dan Poktan</a></li>
                                    <li><a class="dropdown-item" href="https://www.instagram.com/kkmp_kademangan?igsh=MWxsOXNhNXEzaGlsYg==" target="_blank" rel="noopener">
                                            <i class="fa-solid fa-coins"></i> Koperasi Merah Putih</a></li>
                                </ul>
                            </li>

                            <!-- BERITA -->
                            <li class="nav-item">
                                <a class="nav-link px-3 d-flex align-items-center gap-2 <?= $seg1 === 'berita' ? 'active' : '' ?>"
                                    href="<?= site_url('berita'); ?>">
                                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                                    <span>Berita</span>
                                </a>
                            </li>

                            <!-- Login (mobile) -->
                            <li class="nav-item d-lg-none mt-2">
                                <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary w-100">Login</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>