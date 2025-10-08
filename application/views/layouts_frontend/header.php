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
    <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/informasi_custom.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/berita_custom.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pelayanan_custom.css'); ?>">
    <!-- Force absolute URL untuk hero background -->
    <style>
        @media (min-width: 992px) {
            .navbar .nav-item.dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= site_url('home'); ?>">Explore Kademangan</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('home'); ?>">Home</a></li>
                    <li class="nav-item dropdown">

                        <a href="<?= site_url('pelayanan'); ?>" class="nav-link d-none d-lg-flex align-items-center gap-2">
                            <i class="fa-solid fa-handshake"></i> Pelayanan
                        </a>

                        <a href="#" class="nav-link dropdown-toggle d-lg-none d-flex align-items-center gap-2" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa-solid fa-handshake"></i> Pelayanan
                        </a>

                        <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                            <li>
                                <h6 class="dropdown-header fw-bold text-primary">
                                    Pilih Jenis Surat
                                </h6>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/tidak-mampu'); ?>">
                                    <i class="bi bi-shield-check me-2"></i> SKTM (Tidak Mampu)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/belum-bekerja'); ?>">
                                    <i class="bi bi-file-earmark-person me-2"></i> Belum Bekerja
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/domisili-yayasan'); ?>">
                                    <i class="bi bi-building me-2"></i> Domisili Yayasan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/belum-memiliki-rumah'); ?>">
                                    <i class="bi bi-house me-2"></i> Belum Memiliki Rumah
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/kematian'); ?>">
                                    <i class="bi bi-person-x me-2"></i> Kematian (Dukcapil)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/kematian-nondukcapil'); ?>">
                                    <i class="bi bi-person-x-fill me-2"></i> Kematian (Non Dukcapil)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('pelayanan/suami-istri'); ?>">
                                    <i class="bi bi-people-fill me-2"></i> Suami Istri
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-center fw-semibold text-primary" href="<?= site_url('pelayanan'); ?>">
                                    <i class="bi bi-three-dots me-1"></i> Layanan Lainnya
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">

                        <a href="<?= site_url('#'); ?>" class="nav-link d-none d-lg-flex align-items-center gap-2">
                            <i class="fa-solid fa-handshake"></i> LKK
                        </a>

                        <a href="#" class="nav-link dropdown-toggle d-lg-none d-flex align-items-center gap-2" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa-solid fa-handshake"></i> LKK
                        </a>

                        <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                            <li>
                                <h6 class="dropdown-header fw-bold text-primary">
                                    Lemaga Kademangan
                                </h6>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>">
                                    RT dan RW
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Pemberdayaan Kesejahteraan Keluarga">
                                    PKK
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="https://www.instagram.com/karangtarunakademangan?igsh=MWZzd2VlcGgxaGM5NQ=="
                                    target="_blank" rel="noopener noreferrer">
                                    Karang Taruna
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>">
                                    Posyandu
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Lembaga Pemberdayaan Masyarakat">
                                    LPM
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>">
                                    MUI Kelurahan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Dewan Masjid Indonesia">
                                    DMI Kelurahan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Dewan Masjid Indonesia">
                                    LPTQ Kelurahan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Dewan Masjid Indonesia">
                                    Pengajian Al Hidayah
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Dewan Masjid Indonesia">
                                    TPS3R dan Bank Sampah
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="<?= site_url('#'); ?>" title="Dewan Masjid Indonesia">
                                    KWT dan Poktan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="https://www.instagram.com/kkmp_kademangan?igsh=MWxsOXNhNXEzaGlsYg=="
                                    target="_blank" rel="noopener noreferrer">
                                    Koprasi Merah Putih
                                </a>
                            </li>
                        </ul>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('berita'); ?>">Berita</a></li>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary px-3">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>