<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Manajemen Admin/Staff</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Administrator</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Manajemen Admin/Staff</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Admin/Staff</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addUserModal">
                            <i class="fa fa-plus"></i>
                            Tambah Staff
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($user_list as $user): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $user->nama_lengkap; ?></td>
                                        <td><?= $user->username; ?></td>
                                        <td><span class="badge badge-info"><?= $user->nama_level; ?></span></td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="modal" data-target="#editUserModal<?= $user->id_user; ?>" title="Edit" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></button>
                                                <a href="<?= base_url('admin/users/delete/' . $user->id_user); ?>" onclick="return confirm('Yakin ingin hapus user ini?')" title="Hapus" class="btn btn-link btn-danger"><i class="fa fa-times"></i></a>
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

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title"><span class="fw-mediumbold">Tambah</span> Admin/Staff Baru</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('admin/users/store'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
                    <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" required></div>
                    <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                </div>
                <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Simpan</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($user_list as $user): ?>
    <div class="modal fade" id="editUserModal<?= $user->id_user; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title"><span class="fw-mediumbold">Edit</span> Data Staff</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('admin/users/update/' . $user->id_user); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" value="<?= $user->nama_lengkap; ?>" required></div>
                        <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" value="<?= $user->username; ?>" required></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control"><small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small></div>
                    </div>
                    <div class="modal-footer no-bd"><button type="submit" class="btn btn-primary">Update</button><button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button></div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>