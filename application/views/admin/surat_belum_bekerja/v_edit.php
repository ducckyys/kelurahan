<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Surat Keterangan Belum Bekerja</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header">
                    <div class="card-title">Formulir Edit Data</div>
                </div>

                <!-- Form -->
                <form action="<?= base_url('admin/surat_belum_bekerja/update/' . $surat->id); ?>" method="POST">
                    <div class="card-body">

                        <!-- Data Pengantar RT/RW -->
                        <h5 class="mb-3">Data Pengantar RT/RW</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat RT/RW</label>
                                    <input type="text" name="nomor_surat_rt" class="form-control"
                                        value="<?= html_escape($surat->nomor_surat_rt); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Surat RT/RW</label>
                                    <input type="date" name="tanggal_surat_rt" class="form-control"
                                        value="<?= $surat->tanggal_surat_rt; ?>" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Data Diri Pemohon -->
                        <h5 class="mb-3">Data Diri Pemohon</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_pemohon" class="form-control"
                                        value="<?= html_escape($surat->nama_pemohon); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control"
                                        value="<?= html_escape($surat->nik); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="<?= html_escape($surat->tempat_lahir); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="<?= $surat->tanggal_lahir; ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="Laki-laki" <?= ($surat->jenis_kelamin == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($surat->jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Warganegara</label>
                                    <input type="text" name="warganegara" class="form-control"
                                        value="<?= html_escape($surat->warganegara); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" name="agama" class="form-control"
                                        value="<?= html_escape($surat->agama); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control"
                                        value="<?= html_escape($surat->pekerjaan); ?>" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control" rows="3" required><?= html_escape($surat->alamat); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- Data Keterangan -->
                        <h5 class="mb-3">Data Keterangan</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Keperluan</label>
                                    <input type="text" name="keperluan" class="form-control"
                                        value="<?= html_escape($surat->keperluan); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/surat_belum_bekerja'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>