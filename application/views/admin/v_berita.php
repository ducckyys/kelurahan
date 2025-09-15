<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#"><i class="flaticon-home"></i></a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Berita</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Berita</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addBeritaModal">
                            <i class="fa fa-plus"></i>
                            Tambah Berita
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul Berita</th>
                                    <th>Tanggal Publish</th>
                                    <th>Penulis</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($berita_list as $berita): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" width="100"></td>
                                        <td><?= $berita->judul_berita; ?></td>
                                        <td><?= date('d M Y H:i', strtotime($berita->tgl_publish)); ?></td>
                                        <td><?= $berita->nama_lengkap; ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="modal" data-target="#editBeritaModal<?= $berita->id_berita; ?>" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a href="<?= base_url('admin/berita/delete/' . $berita->id_berita); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" title="Hapus" class="btn btn-link btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addBeritaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title"><span class="fw-mediumbold">Tambah</span> Berita Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('admin/berita/store'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Berita</label>
                        <input type="text" name="judul_berita" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Layanan">Layanan</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Isi Berita</label>
                        <textarea name="isi_berita" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php foreach ($berita_list as $berita): ?>
    <div class="modal fade" id="editBeritaModal<?= $berita->id_berita; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title"><span class="fw-mediumbold">Edit</span> Berita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('admin/berita/update/' . $berita->id_berita); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Berita</label>
                            <input type="text" name="judul_berita" class="form-control" value="<?= $berita->judul_berita; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <option value="Kegiatan" <?= ($berita->kategori == 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                                <option value="Pengumuman" <?= ($berita->kategori == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                <option value="Layanan" <?= ($berita->kategori == 'Layanan') ? 'selected' : ''; ?>>Layanan</option>
                                <option value="Umum" <?= ($berita->kategori == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Isi Berita</label>
                            <textarea name="isi_berita" class="form-control" rows="5" required><?= $berita->isi_berita; ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>