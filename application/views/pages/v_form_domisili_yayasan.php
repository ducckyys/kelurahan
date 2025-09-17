<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Keterangan Domisili Yayasan</h1>
                <p class="text-muted mb-0">Lengkapi semua data di bawah ini dengan benar.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="<?= base_url('pelayanan/submit-domisili-yayasan'); ?>">
                    <h5 class="mb-4">Data Penanggung Jawab</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Penanggung Jawab</label><input type="text" name="nama_penanggung_jawab" value="<?= set_value('nama_penanggung_jawab'); ?>" placeholder="Nama Penanggung Jawab" class="form-control <?= form_error('nama_penanggung_jawab') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_penanggung_jawab'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">NIK Penanggung Jawab</label><input type="text" name="nik" value="<?= set_value('nik'); ?>" placeholder="NIK Penanggung Jawab" class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir" value="<?= set_value('tempat_lahir'); ?>" placeholder="Tempat Lahir" class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_lahir'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="<?= set_value('tanggal_lahir'); ?>" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="Laki-laki" <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE); ?> required>
                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" <?= set_radio('jenis_kelamin', 'Perempuan'); ?>>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                            <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Kewarganegaraan</label><input type="text" name="kewarganegaraan" value="<?= set_value('kewarganegaraan'); ?>" placeholder="Kewarganegaraan" class="form-control <?= form_error('kewarganegaraan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('kewarganegaraan'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama" value="<?= set_value('agama'); ?>" placeholder="Agama" class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                        </div>
                        <div class="col-12"><label class="form-label">Alamat Sesuai KTP</label><textarea name="alamat_pemohon" rows="3" class="form-control <?= form_error('alamat_pemohon') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_pemohon'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat_pemohon'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-4">Data Yayasan / Organisasi</h5>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nama Organisasi</label><input type="text" name="nama_organisasi" value="<?= set_value('nama_organisasi'); ?>" placeholder="Nama Organisasi" class="form-control <?= form_error('nama_organisasi') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_organisasi'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Jenis Kegiatan</label><input type="text" name="jenis_kegiatan" value="<?= set_value('jenis_kegiatan'); ?>" class="form-control <?= form_error('jenis_kegiatan') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Sosial dan Pendidikan" required>
                            <div class="invalid-feedback"><?= form_error('jenis_kegiatan'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Jumlah Pengurus</label><input type="number" name="jumlah_pengurus" value="<?= set_value('jumlah_pengurus'); ?>" class="form-control <?= form_error('jumlah_pengurus') ? 'is-invalid' : ''; ?>" placeholder="Jumlah Pengurus" required>
                            <div class="invalid-feedback"><?= form_error('jumlah_pengurus'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">NPWP</label><input type="text" name="npwp" value="<?= set_value('npwp'); ?>" class="form-control <?= form_error('npwp') ? 'is-invalid' : ''; ?>" placeholder="NPWP" required>
                            <div class="invalid-feedback"><?= form_error('npwp'); ?></div>
                        </div>
                        <div class="col-12"><label class="form-label">Alamat Kantor</label><textarea name="alamat_kantor" rows="3" class="form-control <?= form_error('alamat_kantor') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_kantor'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat_kantor'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-4">Data Legalitas</h5>
                    <p class="text-muted small">Isi data Akta Pendirian. Jika ada Akta Perubahan, silakan diisi juga.</p>
                    <h6>Akta Pendirian</h6>
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label">Nama Notaris</label><input type="text" name="nama_notaris_pendirian" value="<?= set_value('nama_notaris_pendirian'); ?>" class="form-control <?= form_error('nama_notaris_pendirian') ? 'is-invalid' : ''; ?>" placeholder="Nama Notaris" required>
                            <div class="invalid-feedback"><?= form_error('nama_notaris_pendirian'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Nomor Akta</label><input type="text" name="nomor_akta_pendirian" value="<?= set_value('nomor_akta_pendirian'); ?>" class="form-control <?= form_error('nomor_akta_pendirian') ? 'is-invalid' : ''; ?>" placeholder="Nomor Akta" required>
                            <div class="invalid-feedback"><?= form_error('nomor_akta_pendirian'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal Akta</label><input type="date" name="tanggal_akta_pendirian" value="<?= set_value('tanggal_akta_pendirian'); ?>" class="form-control <?= form_error('tanggal_akta_pendirian') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_akta_pendirian'); ?></div>
                        </div>
                    </div>
                    <h6 class="mt-4">Akta Perubahan (Opsional)</h6>
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label">Nama Notaris</label><input type="text" name="nama_notaris_perubahan" value="<?= set_value('nama_notaris_perubahan'); ?>" class="form-control <?= form_error('nama_notaris_perubahan') ? 'is-invalid' : ''; ?>" placeholder="Nama Notaris">
                            <div class="invalid-feedback"><?= form_error('nama_notaris_perubahan'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Nomor Akta</label><input type="text" name="nomor_akta_perubahan" value="<?= set_value('nomor_akta_perubahan'); ?>" class="form-control <?= form_error('nomor_akta_perubahan') ? 'is-invalid' : ''; ?>" placeholder="Nomor Akta">
                            <div class="invalid-feedback"><?= form_error('nomor_akta_perubahan'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal Akta</label><input type="date" name="tanggal_akta_perubahan" value="<?= set_value('tanggal_akta_perubahan'); ?>" class="form-control <?= form_error('tanggal_akta_perubahan') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('tanggal_akta_perubahan'); ?></div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-check"><input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_sktm"><label class="form-check-label" for="agree_sktm">Saya menyatakan data yang saya isi adalah benar.</label>
                            <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>