<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/berita'); ?>">Berita</a></li>
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
                    <h4 class="card-title">Form Edit Berita</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/berita/update/' . $berita->id_berita); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Judul Berita</label>
                            <input type="text" name="judul_berita" class="form-control" value="<?= html_escape($berita->judul_berita); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <?php
                                $opsi = ['Kegiatan', 'Pengumuman', 'Layanan', 'Umum'];
                                foreach ($opsi as $o):
                                ?>
                                    <option value="<?= $o; ?>" <?= ($berita->kategori === $o ? 'selected' : ''); ?>><?= $o; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Isi Berita</label>
                            <textarea id="isi_berita" name="isi_berita" class="form-control" rows="8" required><?= $berita->isi_berita; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label><br>
                            <?php if (!empty($berita->gambar)): ?>
                                <img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" alt="gambar" style="max-width:220px;border:1px solid #eee;border-radius:6px;">
                            <?php else: ?>
                                <em>Belum ada gambar</em>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Ganti Gambar (opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('admin/berita'); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>