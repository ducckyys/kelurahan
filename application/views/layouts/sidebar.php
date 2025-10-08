<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <?php
            // Ambil data penting sekali di awal
            $session_data = $this->session->userdata();
            $id_level     = $session_data['id_level'] ?? null;
            $nama_user    = $session_data['nama'] ?? 'Pengguna';
            $foto_user    = $session_data['foto'] ?? 'default.jpg';
            $seg2         = $this->uri->segment(2);
            ?>

            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= base_url('uploads/profil/' . $foto_user); ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= $nama_user; ?>
                            <span class="user-level"><?= ($id_level === '1') ? 'Superadmin' : 'Admin/Staff'; ?></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item <?= ($seg2 == 'dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard'); ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">LAYANAN</h4>
                </li>

                <?php
                // [DIPERBAIKI] Definisikan SEMUA layanan di dalam satu array ini
                $services = [
                    ['slug' => 'surat_sktm',                   'url' => 'admin/surat_sktm',                   'label' => 'SKTM'],
                    ['slug' => 'surat_belum_bekerja',           'url' => 'admin/surat_belum_bekerja',           'label' => 'Ket. Belum Bekerja'],
                    ['slug' => 'surat_domisili_yayasan',       'url' => 'admin/surat_domisili_yayasan',       'label' => 'Domisili Yayasan'],
                    ['slug' => 'surat_belum_memiliki_rumah',   'url' => 'admin/surat_belum_memiliki_rumah',   'label' => 'Belum Punya Rumah'],
                    ['slug' => 'surat_kematian',               'url' => 'admin/surat_kematian',               'label' => 'Kematian Dukcapil'],
                    ['slug' => 'surat_kematian_nondukcapil',   'url' => 'admin/surat_kematian_nondukcapil',   'label' => 'Kematian Non Dukcapil'],
                    ['slug' => 'surat_suami_istri',             'url' => 'admin/surat_suami_istri',             'label' => 'Suami Istri'],
                ];
                $isServiceMenuActive = in_array($seg2, array_column($services, 'slug'));
                ?>

                <li class="nav-item <?= $isServiceMenuActive ? 'active sub-menu' : '' ?>">
                    <a data-toggle="collapse" href="#menuLayanan" class="collapsed" aria-expanded="<?= $isServiceMenuActive ? 'true' : 'false' ?>">
                        <i class="fa fa-briefcase"></i>
                        <p>Pelayanan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?= $isServiceMenuActive ? 'show' : '' ?>" id="menuLayanan">
                        <ul class="nav nav-collapse">
                            <?php // [DIPERBAIKI] Gunakan foreach untuk menampilkan semua layanan secara otomatis 
                            ?>
                            <?php foreach ($services as $service): ?>
                                <li class="<?= ($seg2 === $service['slug']) ? 'active' : '' ?>">
                                    <a href="<?= base_url($service['url']); ?>">
                                        <span class="sub-item"><?= $service['label']; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <?php // Bagian ini hanya akan muncul jika id_level adalah '1' (Superadmin) 
                ?>
                <?php if ($id_level === '1'): ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                        <h4 class="text-section">ADMINISTRATOR</h4>
                    </li>
                    <li class="nav-item <?= ($seg2 == 'berita') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/berita'); ?>"><i class="fas fa-newspaper"></i>
                            <p>Berita</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($seg2 == 'galeri') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/galeri'); ?>"><i class="far fa-images"></i>
                            <p>Galeri</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($seg2 == 'uploadvideo') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/uploadvideo'); ?>"><i class="fas fa-cog"></i>
                            <p>Pengaturan Video</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($seg2 == 'runningtext') ? 'active' : '' ?>">
                        <a href="<?= site_url('admin/runningtext'); ?>"><i class="fas fa-stream"></i>
                            <p>Running Text</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($seg2 == 'users') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/users'); ?>"><i class="fas fa-users-cog"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content">