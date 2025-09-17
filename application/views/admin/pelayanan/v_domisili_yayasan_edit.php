<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Surat Domisili Yayasan</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Edit Data</div>
                </div>
                <form action="<?= base_url('admin/surat_domisili_yayasan/update/' . $surat->id); ?>" method="POST">
                    <div class="card-body">
                        <h5 class="mb-3">Data Penanggung Jawab</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_penanggung_jawab" class="form-control" value="<?= html_escape($surat->nama_penanggung_jawab); ?>" required></div>
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
                                <div class="form-group"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan" class="form-control" value="<?= html_escape($surat->kewarganegaraan); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Agama</label><input type="text" name="agama" class="form-control" value="<?= html_escape($surat->agama); ?>" required></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat Sesuai KTP</label><textarea name="alamat_pemohon" class="form-control" required><?= html_escape($surat->alamat_pemohon); ?></textarea></div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">Data Yayasan / Organisasi</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Organisasi</label><input type="text" name="nama_organisasi" class="form-control" value="<?= html_escape($surat->nama_organisasi); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kegiatan</label><input type="text" name="jenis_kegiatan" class="form-control" value="<?= html_escape($surat->jenis_kegiatan); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jumlah Pengurus</label><input type="number" name="jumlah_pengurus" class="form-control" value="<?= html_escape($surat->jumlah_pengurus); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NPWP</label><input type="text" name="npwp" class="form-control" value="<?= html_escape($surat->npwp); ?>" required></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat Kantor</label><textarea name="alamat_kantor" class="form-control" required><?= html_escape($surat->alamat_kantor); ?></textarea></div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">Data Legalitas</h5>
                        <h6>Akta Pendirian</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label>Nama Notaris</label><input type="text" name="nama_notaris_pendirian" class="form-control" value="<?= html_escape($surat->nama_notaris_pendirian); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Nomor Akta</label><input type="text" name="nomor_akta_pendirian" class="form-control" value="<?= html_escape($surat->nomor_akta_pendirian); ?>" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Akta</label><input type="date" name="tanggal_akta_pendirian" class="form-control" value="<?= $surat->tanggal_akta_pendirian; ?>" required></div>
                            </div>
                        </div>
                        <h6 class="mt-3">Akta Perubahan (Opsional)</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group"><label>Nama Notaris</label><input type="text" name="nama_notaris_perubahan" class="form-control" value="<?= html_escape($surat->nama_notaris_perubahan); ?>"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Nomor Akta</label><input type="text" name="nomor_akta_perubahan" class="form-control" value="<?= html_escape($surat->nomor_akta_perubahan); ?>"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Akta</label><input type="date" name="tanggal_akta_perubahan" class="form-control" value="<?= $surat->tanggal_akta_perubahan; ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= base_url('admin/surat_domisili_yayasan'); ?>" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>