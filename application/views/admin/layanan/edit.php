<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/layanan'); ?>">Layanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Edit</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Layanan</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/layanan/edit/' . $row->id); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" value="<?= html_escape($row->judul); ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="6" required><?= html_escape($row->deskripsi); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Urut</label>
                                    <input type="number" name="urut" value="<?= (int)$row->urut; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Aktif?</label>
                                    <select name="aktif" class="form-control">
                                        <option value="1" <?= $row->aktif ? 'selected' : ''; ?>>Ya</option>
                                        <option value="0" <?= !$row->aktif ? 'selected' : ''; ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ganti Gambar (opsional)</label>
                                    <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label><br>
                            <?php if (!empty($row->gambar)): ?>
                                <img src="<?= base_url('uploads/layanan/' . $row->gambar); ?>" alt="gambar" style="max-width:220px;border:1px solid #eee;border-radius:6px;">
                            <?php else: ?>
                                <em>Belum ada gambar</em>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('admin/layanan'); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>