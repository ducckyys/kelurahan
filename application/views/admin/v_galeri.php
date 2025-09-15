<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Galeri</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Galeri</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Foto Galeri</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addGaleriModal"><i class="fa fa-plus"></i> Tambah Foto</button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div><?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error'); ?></div><?php endif; ?>
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Judul Foto</th>
                                    <th>Pengupload</th>
                                    <th>Tanggal</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($galeri_list as $item): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><a href="<?= base_url('uploads/galeri/' . $item->foto); ?>" target="_blank"><img src="<?= base_url('uploads/galeri/' . $item->foto); ?>" alt="<?= $item->judul_foto; ?>" width="100"></a></td>
                                        <td><?= $item->judul_foto; ?></td>
                                        <td><?= $item->nama_lengkap; ?></td>
                                        <td><?= date('d M Y H:i', strtotime($item->tgl_upload)); ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="modal" data-target="#editGaleriModal<?= $item->id_galeri; ?>" title="Edit" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button>
                                                <a href="<?= base_url('admin/galeri/delete/' . $item->id_galeri); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" title="Hapus" class="btn btn-link btn-danger"><i class="fa fa-times"></i></a>
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

<div class="modal fade" id="addGaleriModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title"><span class="fw-mediumbold">Tambah</span> Foto Galeri</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('admin/galeri/store'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Foto</label>
                        <input type="text" name="judul_foto" class="form-control" placeholder="Masukkan judul foto..." required>
                    </div>
                    <div class="form-group"><label>Upload Foto</label><input type="file" name="foto" class="form-control" required></div>
                </div>
                <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Simpan</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($galeri_list as $item): ?>
    <div class="modal fade" id="editGaleriModal<?= $item->id_galeri; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title"><span class="fw-mediumbold">Edit</span> Foto Galeri</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('admin/galeri/update/' . $item->id_galeri); ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Foto</label>
                            <input type="text" name="judul_foto" class="form-control" value="<?= $item->judul_foto; ?>" required>
                        </div>
                        <div class="form-group"><label>Foto Saat Ini</label><br><img src="<?= base_url('uploads/galeri/' . $item->foto); ?>" width="150"></div>
                        <div class="form-group"><label>Ganti Foto</label><input type="file" name="foto" class="form-control"><small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small></div>
                    </div>
                    <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Update</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>