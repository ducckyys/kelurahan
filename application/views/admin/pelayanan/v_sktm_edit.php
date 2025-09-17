<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit SKTM</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Edit Data SKTM</div>
                </div>
                <form action="<?= base_url('admin/surat_sktm/update/' . $surat->id); ?>" method="POST">
                    <div class="card-body">
                        <h5 class="mb-3">Data Pemohon</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Pemohon</label><input type="text" name="nama_pemohon" class="form-control" value="<?= html_escape($surat->nama_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="text" name="nik" class="form-control" value="<?= html_escape($surat->nik); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="<?= html_escape($surat->tempat_lahir); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="<?= $surat->tanggal_lahir; ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin" class="form-control" required>
                                        <option value="Laki-laki" <?= ($surat->jenis_kelamin == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($surat->jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Warganegara</label><input type="text" name="warganegara" class="form-control" value="<?= html_escape($surat->warganegara); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Agama</label><input type="text" name="agama" class="form-control" value="<?= html_escape($surat->agama); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan" class="form-control" value="<?= html_escape($surat->pekerjaan); ?>" required></div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" required><?= html_escape($surat->alamat); ?></textarea></div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Keterangan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Orang Tua</label><input type="text" name="nama_orang_tua" class="form-control" value="<?= html_escape($surat->nama_orang_tua); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>ID DTKS (Opsional)</label><input type="text" name="id_dtks" class="form-control" value="<?= html_escape($surat->id_dtks); ?>"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Penghasilan Bulanan</label><select name="penghasilan_bulanan" class="form-control" required>
                                        <option value="< Rp 1.000.000" <?= ($surat->penghasilan_bulanan == '< Rp 1.000.000') ? 'selected' : ''; ?>>Kurang dari Rp 1.000.000</option>
                                        <option value="Rp 1.000.000 - Rp 2.500.000" <?= ($surat->penghasilan_bulanan == 'Rp 1.000.000 - Rp 2.500.000') ? 'selected' : ''; ?>>Rp 1.000.000 - Rp 2.500.000</option>
                                        <option value="Rp 2.500.001 - Rp 4.000.000" <?= ($surat->penghasilan_bulanan == 'Rp 2.500.001 - Rp 4.000.000') ? 'selected' : ''; ?>>Rp 2.500.001 - Rp 4.000.000</option>
                                        <option value="> Rp 4.000.000" <?= ($surat->penghasilan_bulanan == '> Rp 4.000.000') ? 'selected' : ''; ?>>Lebih dari Rp 4.000.000</option>
                                    </select></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Keperluan</label><input type="text" name="keperluan" class="form-control" value="<?= html_escape($surat->keperluan); ?>" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/surat_sktm'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>