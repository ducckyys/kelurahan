<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Manajemen Informasi</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Informasi</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Informasi</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addModal">
                            <i class="fa fa-plus"></i> Tambah Informasi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Informasi</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($informasi_list as $info): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= html_escape($info->judul_informasi); ?></td>
                                        <td><span class="badge badge-primary"><?= html_escape($info->kategori); ?></span></td>
                                        <td><?= !empty($info->nama_lengkap) ? html_escape($info->nama_lengkap) : '<span class="text-danger font-italic">User Dihapus</span>'; ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="modal" data-target="#editModal<?= $info->id_informasi; ?>" title="Edit" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button>
                                                <a href="<?= base_url('admin/informasi/delete/' . $info->id_informasi); ?>" onclick="return confirm('Yakin ingin menghapus informasi ini?')" title="Hapus" class="btn btn-link btn-danger"><i class="fa fa-times"></i></a>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">Tambah Informasi Baru</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('admin/informasi/store'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group"><label>Judul Informasi</label><input type="text" name="judul_informasi" class="form-control" required></div>
                    <div class="form-group"><label>Kategori</label><select name="kategori" class="form-control" required>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Peraturan">Peraturan</option>
                            <option value="Unduhan">Unduhan</option>
                        </select></div>
                    <div class="form-group"><label>Isi Informasi</label><textarea name="isi_informasi" class="form-control" rows="5" required></textarea></div>
                </div>
                <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Simpan</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($informasi_list as $info): ?>
    <div class="modal fade" id="editModal<?= $info->id_informasi; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title">Edit Informasi</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('admin/informasi/update/' . $info->id_informasi); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group"><label>Judul Informasi</label><input type="text" name="judul_informasi" class="form-control" value="<?= $info->judul_informasi; ?>" required></div>
                        <div class="form-group"><label>Kategori</label><select name="kategori" class="form-control" required>
                                <option value="Pengumuman" <?= ($info->kategori == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                <option value="Peraturan" <?= ($info->kategori == 'Peraturan') ? 'selected' : ''; ?>>Peraturan</option>
                                <option value="Unduhan" <?= ($info->kategori == 'Unduhan') ? 'selected' : ''; ?>>Unduhan</option>
                            </select></div>
                        <div class="form-group"><label>Isi Informasi</label><textarea name="isi_informasi" class="form-control" rows="5" required><?= $info->isi_informasi; ?></textarea></div>
                    </div>
                    <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Update</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>