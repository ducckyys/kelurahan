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
                                <div class="form-group"><label>NIK Pemohon</label><input type="text" name="nik_pemohon" class="form-control" value="<?= html_escape($surat->nik_pemohon); ?>" required></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_pemohon" class="form-control" value="<?= html_escape($surat->tempat_lahir_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir_pemohon" class="form-control" value="<?= $surat->tgl_lahir_pemohon; ?>" required></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label><select name="jenis_kelamin_pemohon" class="form-control" required>
                                        <option value="Laki-laki" <?= ($surat->jenis_kelamin_pemohon == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($surat->jenis_kelamin_pemohon == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Agama</label><input type="text" name="agama_pemohon" class="form-control" value="<?= html_escape($surat->agama_pemohon); ?>" required></div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group"><label>Pekerjaan</label><input type="text" name="pekerjaan_pemohon" class="form-control" value="<?= html_escape($surat->pekerjaan_pemohon); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Penghasilan Bulanan</label><select name="penghasilan_bulanan" class="form-control" required>
                                        <option value="< Rp 1.000.000" <?= ($surat->penghasilan_bulanan == '< Rp 1.000.000') ? 'selected' : ''; ?>>Kurang dari Rp 1.000.000</option>
                                        <option value="Rp 1.000.000 - Rp 2.500.000" <?= ($surat->penghasilan_bulanan == 'Rp 1.000.000 - Rp 2.500.000') ? 'selected' : ''; ?>>Rp 1.000.000 - Rp 2.500.000</option>
                                        <option value="Rp 2.500.001 - Rp 5.000.000" <?= ($surat->penghasilan_bulanan == 'Rp 2.500.001 - Rp 5.000.000') ? 'selected' : ''; ?>>Rp 2.500.001 - Rp 5.000.000</option>
                                        <option value="> Rp 5.000.000" <?= ($surat->penghasilan_bulanan == '> Rp 5.000.000') ? 'selected' : ''; ?>>Lebih dari Rp 5.000.000</option>
                                    </select></div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group"><label>Alamat</label><textarea name="alamat_pemohon" class="form-control" required><?= html_escape($surat->alamat_pemohon); ?></textarea></div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Keterangan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Keperluan</label><input type="text" name="keperluan" class="form-control" value="<?= html_escape($surat->keperluan); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Atas Nama</label><input type="text" name="atas_nama" class="form-control" value="<?= html_escape($surat->atas_nama); ?>"></div>
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