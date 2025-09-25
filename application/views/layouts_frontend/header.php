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
    <!-- Force absolute URL untuk hero background -->
    <style>
        .hero {
            background-image: lineargradient(rgba(0, 0, 0, .25), rgba(0, 0, 0, .25)), url('<?= base_url('assets/img/bgkelurahan.jpg'); ?>');
            background-size: cover;
            background-position: center
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
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('informasi'); ?>">Informasi</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pelayanan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/tidak-mampu'); ?>">Surat Keterangan Tidak Mampu</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/belum-bekerja'); ?>">Surat Ket. Belum Bekerja</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/domisili-yayasan'); ?>">Surat Domisili Yayasan</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/belum-memiliki-rumah'); ?>">Surat Belum Memiliki Rumah</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/kematian'); ?>">Surat Keterangan Kematian Dukcapil</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/kematian-nondukcapil'); ?>">Surat Kematian (Non Dukcapil)</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan/suami-istri'); ?>">Surat Keterangan Suami Istri</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= site_url('pelayanan'); ?>">Layanan Lainnya</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('berita'); ?>">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('lkk'); ?>">LKK</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary px-3">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>