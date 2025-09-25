<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Kematian Non Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_kematian_nondukcapil') ?>">Data Kematian Non Dukcapil</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit Data</a></li>
        </ul>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Formulir Edit Data</h4>
                <a href="<?= base_url('admin/surat_kematian_nondukcapil/detail/' . $surat->id); ?>" class="btn btn-secondary btn-round ml-auto">Batal</a>
            </div>
        </div>
        <form action="<?= base_url('admin/surat_kematian_nondukcapil/update/' . $surat->id); ?>" method="POST" enctype="multipart/form-data">
            <div class="card-body">

                <h5>Administrasi Surat</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control" value="<?= html_escape($surat->nomor_surat); ?>" placeholder="Contoh: 400.12.3.1/123 - Pemerintahan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Pengajuan</label>
                            <select name="status" class="form-control">
                                <option value="Pending" <?= ($surat->status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Disetujui" <?= ($surat->status == 'Disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="Ditolak" <?= ($surat->status == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Data Ahli Waris</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>Nama</label><input name="nama_ahli_waris" class="form-control" value="<?= html_escape($surat->nama_ahli_waris); ?>" required></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>NIK</label><input name="nik_ahli_waris" class="form-control" value="<?= html_escape($surat->nik_ahli_waris); ?>" required></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin" class="form-control" required>
                                <option value="Laki-laki" <?= $surat->jenis_kelamin == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $surat->jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. Telepon Ahli Waris</label>
                            <input type="text" name="telepon_ahli_waris" class="form-control"
                                value="<?= html_escape($surat->telepon_ahli_waris ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Hubungan</label><input name="hubungan_ahli_waris" class="form-control" value="<?= html_escape($surat->hubungan_ahli_waris); ?>" required></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group"><label>Alamat</label><textarea name="alamat_ahli_waris" class="form-control" required><?= html_escape($surat->alamat_ahli_waris); ?></textarea></div>
                    </div>
                </div>

                <hr>
                <h5>Data Almarhum/ah</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>Nama</label><input name="nama_almarhum" class="form-control" value="<?= html_escape($surat->nama_almarhum); ?>" required></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>NIK</label><input name="nik_almarhum" class="form-control" value="<?= html_escape($surat->nik_almarhum); ?>" required></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group"><label>Keterangan (Hubungan dengan Ahli Waris)</label><input name="keterangan_almarhum" class="form-control" value="<?= html_escape($surat->keterangan_almarhum); ?>" placeholder="Contoh: Ibu Kandung" required></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Tempat Meninggal</label><input name="tempat_meninggal" class="form-control" value="<?= html_escape($surat->tempat_meninggal); ?>" required></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Tanggal Meninggal</label><input type="date" name="tanggal_meninggal" class="form-control" value="<?= $surat->tanggal_meninggal; ?>" required></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group"><label>Alamat Almarhum/ah</label><textarea name="alamat_almarhum" class="form-control" required><?= html_escape($surat->alamat_almarhum); ?></textarea></div>
                    </div>
                </div>

                <hr>
                <h5>Keperluan Surat</h5>
                <div class="form-group">
                    <label>Keperluan</label>
                    <input type="text" name="keperluan" class="form-control"
                        value="<?= html_escape($surat->keperluan ?? ''); ?>" required>
                </div>

                <hr>
                <h5>Surat Pengantar RT/RW</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Surat RT/RW</label>
                            <input type="text" class="form-control" name="nomor_surat_rt"
                                value="<?= html_escape($surat->nomor_surat_rt); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Surat RT/RW</label>
                            <input type="date" class="form-control" name="tanggal_surat_rt"
                                value="<?= html_escape($surat->tanggal_surat_rt); ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Scan Surat Pengantar (PDF/JPG/PNG, maks 2MB)</label>
                            <input type="file" class="form-control" name="scan_surat_rt" accept=".pdf,.jpg,.jpeg,.png">
                            <?php if (!empty($surat->scan_surat_rt)): ?>
                                <small class="form-text text-muted">
                                    File saat ini: <a target="_blank" href="<?= base_url('uploads/surat_rt/' . $surat->scan_surat_rt); ?>">
                                        <?= html_escape($surat->scan_surat_rt); ?>
                                    </a>
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>