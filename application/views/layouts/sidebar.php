<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= base_url('uploads/profil/' . $this->session->userdata('foto')); ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= $this->session->userdata('nama'); ?>
                            <span class="user-level"><?= ($this->session->userdata('id_level') == 1) ? 'Superadmin' : 'Admin/Staff'; ?></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/dashboard'); ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">KONTEN</h4>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'berita') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/berita'); ?>">
                        <i class="fas fa-newspaper"></i>
                        <p>Berita</p>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'informasi') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/informasi'); ?>">
                        <i class="fas fa-bullhorn"></i>
                        <p>Informasi</p>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'galeri') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/galeri'); ?>">
                        <i class="far fa-images"></i>
                        <p>Galeri</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">LAYANAN</h4>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'surat_sktm') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/surat_sktm'); ?>">
                        <i class="fas fa-shield-alt"></i>
                        <p>SKTM</p>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'surat_belum_bekerja') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/surat_belum_bekerja'); ?>">
                        <i class="fas fa-user-check"></i>
                        <p>Ket. Belum Bekerja</p>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'surat_domisili_yayasan') ? 'active' : ''; ?>">
                    <a href="<?= base_url('admin/surat_domisili_yayasan'); ?>">
                        <i class="fas fa-building"></i>
                        <p>Domisili Yayasan</p>
                    </a>
                </li>

                <?php if ($this->session->userdata('id_level') == 1): ?>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">ADMINISTRATOR</h4>
                    </li>
                    <li class="nav-item <?= ($this->uri->segment(2) == 'users') ? 'active' : ''; ?>">
                        <a href="<?= base_url('admin/users'); ?>">
                            <i class="fas fa-users-cog"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($this->uri->segment(2) == 'pengaturan') ? 'active' : ''; ?>">
                        <a href="<?= base_url('admin/pengaturan'); ?>">
                            <i class="fas fa-cog"></i>
                            <p>Upload Video</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<div class="main-panel">
    <div class="content">