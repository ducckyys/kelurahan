<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Profil Saya</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profil</div>
                </div>
                <form action="<?= base_url('admin/profil/update'); ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label>Foto Profil</label><br>
                                    <img src="<?= base_url('uploads/profil/' . $user->foto); ?>" alt="Foto Profil" class="avatar-img rounded-circle mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                    <input type="file" name="foto" class="form-control mt-2">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_lengkap">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $user->nama_lengkap; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?= $user->username; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_baru">Password Baru</label>
                                            <input type="password" class="form-control" name="password_baru">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" name="konfirmasi_password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>