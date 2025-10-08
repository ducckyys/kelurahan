<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/galeri'); ?>">Galeri</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Tambah</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Foto</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/galeri/store'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Judul Foto</label>
                            <input type="text" name="judul_foto" class="form-control" placeholder="Masukkan judul foto..." required>
                        </div>
                        <div class="form-group">
                            <label>Upload Foto (jpg/jpeg/png/gif, max 5MB)</label>
                            <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.gif" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('admin/galeri'); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>