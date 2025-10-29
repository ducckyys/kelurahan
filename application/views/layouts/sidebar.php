<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <?php
            $session_data = $this->session->userdata();
            $id_level  = $session_data['id_level'] ?? null;
            $nama_user = $session_data['nama'] ?? 'Pengguna';
            $foto_user = $session_data['foto'] ?? 'default.jpg';

            $seg1 = $this->uri->segment(1); // biasanya 'admin'
            $seg2 = $this->uri->segment(2); // dashboard / surat_* / coverage / dll
            $seg3 = $this->uri->segment(3); // mis. footer pada settings
            ?>

            <!-- USER -->
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= base_url('uploads/profil/' . $foto_user); ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= html_escape($nama_user); ?>
                            <span class="user-level"><?= ($id_level === '1') ? 'Superadmin' : 'Admin/Staff'; ?></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>

            <ul class="nav nav-primary">
                <!-- DASHBOARD -->
                <li class="nav-item <?= ($seg2 === 'dashboard') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard'); ?>">
                        <!-- pakai FA5 -->
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- SECTION: LAYANAN -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fas fa-ellipsis-h"></i></span>
                    <h4 class="text-section">LAYANAN</h4>
                </li>

                <?php
                // daftar semua layanan surat
                $services = [
                    ['slug' => 'surat_sktm',                 'url' => 'admin/surat_sktm',                 'label' => 'Surat Keterangan Tidak Mampu (SKTM)'],
                    ['slug' => 'surat_belum_bekerja',        'url' => 'admin/surat_belum_bekerja',        'label' => 'Surat Keterangan Belum Bekerja'],
                    ['slug' => 'surat_penghasilan',          'url' => 'admin/surat_penghasilan',          'label' => 'Surat Keterangan Penghasilan'], // <= TAMBAHAN
                    ['slug' => 'surat_domisili_yayasan',     'url' => 'admin/surat_domisili_yayasan',     'label' => 'Surat Keterangan Domisili Yayasan'],
                    ['slug' => 'surat_belum_memiliki_rumah', 'url' => 'admin/surat_belum_memiliki_rumah', 'label' => 'Surat Keterangan Belum Punya Rumah'],
                    ['slug' => 'surat_kematian',             'url' => 'admin/surat_kematian',             'label' => 'Surat Keterangan Kematian (Dukcapil)'],
                    ['slug' => 'surat_kematian_nondukcapil', 'url' => 'admin/surat_kematian_nondukcapil', 'label' => 'Surat Keterangan Kematian (Non-Dukcapil)'],
                    ['slug' => 'surat_suami_istri',          'url' => 'admin/surat_suami_istri',          'label' => 'Surat Keterangan Suami Istri'],
                    ['slug' => 'surat_pengantar_nikah',      'url' => 'admin/surat_pengantar_nikah',      'label' => 'Surat Keterangan Pengantar Nikah'],
                ];
                $isServiceMenuActive = in_array($seg2, array_column($services, 'slug'));
                ?>

                <!-- Pelayanan (collapse) -->
                <li class="nav-item <?= $isServiceMenuActive ? 'active sub-menu' : '' ?>">
                    <a data-toggle="collapse" href="#menuLayanan" class="collapsed" aria-expanded="<?= $isServiceMenuActive ? 'true' : 'false' ?>">
                        <i class="fas fa-briefcase"></i>
                        <p>Pelayanan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?= $isServiceMenuActive ? 'show' : '' ?>" id="menuLayanan">
                        <ul class="nav nav-collapse">
                            <?php foreach ($services as $service): ?>
                                <li class="<?= ($seg2 === $service['slug']) ? 'active' : '' ?>">
                                    <a href="<?= base_url($service['url']); ?>">
                                        <span class="sub-item"><?= html_escape($service['label']); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <?php if ($id_level === '1'): ?>
                    <!-- SECTION: ADMINISTRATOR -->
                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fas fa-ellipsis-h"></i></span>
                        <h4 class="text-section">ADMINISTRATOR</h4>
                    </li>

                    <!-- Berita & Galeri tetap sendiri -->
                    <li class="nav-item <?= ($seg2 === 'berita') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/berita'); ?>">
                            <i class="fas fa-newspaper"></i>
                            <p>Berita</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($seg2 === 'galeri') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/galeri'); ?>">
                            <i class="far fa-images"></i>
                            <p>Galeri</p>
                        </a>
                    </li>

                    <?php
                    // item untuk dropdown "Pengaturan" (slug-based)
                    $settingsItems = [
                        ['slug' => 'pejabat',     'url' => 'admin/pejabat',           'label' => 'Pejabat'],
                        ['slug' => 'layanan',     'url' => 'admin/layanan',           'label' => 'Layanan'],
                        ['slug' => 'uploadvideo', 'url' => 'admin/uploadvideo',       'label' => 'Pengaturan Video'],
                        ['slug' => 'coverage',    'url' => 'admin/coverage',          'label' => 'Jangkauan Layanan'],
                        ['slug' => 'runningtext', 'url' => 'admin/runningtext',       'label' => 'Running Text'],
                        ['slug' => 'users',       'url' => 'admin/users',             'label' => 'Manajemen User'],
                        // khusus Footer: seg2=settings & seg3=footer
                        ['slug' => 'settings',    'url' => 'admin/settings/footer',   'label' => 'Footer', 'seg3' => 'footer'],
                    ];

                    // penentu aktif dropdown Pengaturan
                    $isSettingsMenuActive = false;
                    foreach ($settingsItems as $it) {
                        $matchPlain = ($seg2 === $it['slug'] && empty($it['seg3']));
                        $matchSeg3  = (!empty($it['seg3']) && $seg2 === $it['slug'] && $seg3 === $it['seg3']);
                        if ($matchPlain || $matchSeg3) {
                            $isSettingsMenuActive = true;
                            break;
                        }
                    }
                    ?>

                    <!-- Pengaturan (collapse) -->
                    <li class="nav-item <?= $isSettingsMenuActive ? 'active sub-menu' : '' ?>">
                        <a data-toggle="collapse" href="#menuPengaturan" class="collapsed"
                            aria-expanded="<?= $isSettingsMenuActive ? 'true' : 'false' ?>">
                            <i class="fas fa-cog"></i>
                            <p>Pengaturan</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?= $isSettingsMenuActive ? 'show' : '' ?>" id="menuPengaturan">
                            <ul class="nav nav-collapse">
                                <?php foreach ($settingsItems as $it):
                                    $active = ($seg2 === $it['slug'] && empty($it['seg3'])) ||
                                        (!empty($it['seg3']) && $seg2 === $it['slug'] && $seg3 === $it['seg3']);
                                ?>
                                    <li class="<?= $active ? 'active' : '' ?>">
                                        <a href="<?= base_url($it['url']); ?>">
                                            <span class="sub-item"><?= html_escape($it['label']); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content">