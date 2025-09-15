<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Keterangan Tidak Mampu (SKTM)</h1>
                <p class="text-muted mb-0">Lengkapi data berikut dengan benar.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="<?= base_url('pelayanan/submit-sktm'); ?>">
                    <h5 class="mb-4">Data Pemohon (Yang Menyatakan)</h5>
                    <div class="row g-4">
                        <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" name="nama_pemohon" value="<?= set_value('nama_pemohon'); ?>" class="form-control <?= form_error('nama_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nama_pemohon'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">NIK</label><input type="text" name="nik_pemohon" value="<?= set_value('nik_pemohon'); ?>" class="form-control <?= form_error('nik_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nik_pemohon'); ?></div>
                        </div>

                        <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_pemohon" value="<?= set_value('tempat_lahir_pemohon'); ?>" class="form-control <?= form_error('tempat_lahir_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('tempat_lahir_pemohon'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tgl_lahir_pemohon" value="<?= set_value('tgl_lahir_pemohon'); ?>" class="form-control <?= form_error('tgl_lahir_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('tgl_lahir_pemohon'); ?></div>
                        </div>

                        <div class="col-md-6"><label class="form-label">Jenis Kelamin</label><select name="jenis_kelamin_pemohon" class="form-select <?= form_error('jenis_kelamin_pemohon') ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" <?= set_select('jenis_kelamin_pemohon', 'Laki-laki'); ?>>Laki-laki</option>
                                <option value="Perempuan" <?= set_select('jenis_kelamin_pemohon', 'Perempuan'); ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback"><?= form_error('jenis_kelamin_pemohon'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama_pemohon" value="<?= set_value('agama_pemohon'); ?>" class="form-control <?= form_error('agama_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('agama_pemohon'); ?></div>
                        </div>

                        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_pemohon" value="<?= set_value('pekerjaan_pemohon'); ?>" class="form-control <?= form_error('pekerjaan_pemohon') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('pekerjaan_pemohon'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Penghasilan Bulanan</label><select name="penghasilan_bulanan" class="form-select <?= form_error('penghasilan_bulanan') ? 'is-invalid' : ''; ?>" required>
                                <option value="">-- Pilih Rentang --</option>
                                <option value="< Rp 1.000.000" <?= set_select('penghasilan_bulanan', '< Rp 1.000.000'); ?>>Kurang dari Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 2.500.000" <?= set_select('penghasilan_bulanan', 'Rp 1.000.000 - Rp 2.500.000'); ?>>Rp 1.000.000 - Rp 2.500.000</option>
                                <option value="Rp 2.500.001 - Rp 5.000.000" <?= set_select('penghasilan_bulanan', 'Rp 2.500.001 - Rp 5.000.000'); ?>>Rp 2.500.001 - Rp 5.000.000</option>
                                <option value="> Rp 5.000.000" <?= set_select('penghasilan_bulanan', '> Rp 5.000.000'); ?>>Lebih dari Rp 5.000.000</option>
                            </select>
                            <div class="invalid-feedback"><?= form_error('penghasilan_bulanan'); ?></div>
                        </div>

                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat_pemohon" rows="3" class="form-control <?= form_error('alamat_pemohon') ? 'is-invalid' : ''; ?>"><?= set_value('alamat_pemohon'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat_pemohon'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-4">Data Keterangan</h5>
                    <div class="row g-4">
                        <div class="col-md-6"><label class="form-label">Keperluan Surat</label><input type="text" name="keperluan" value="<?= set_value('keperluan'); ?>" class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Pengajuan Beasiswa Pendidikan">
                            <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Dibuat Atas Nama</label><input type="text" name="atas_nama" value="<?= set_value('atas_nama'); ?>" class="form-control <?= form_error('atas_nama') ? 'is-invalid' : ''; ?>" placeholder="(Kosongkan jika untuk diri sendiri)">
                            <div class="invalid-feedback"><?= form_error('atas_nama'); ?></div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-check"><input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_sktm"><label class="form-check-label" for="agree_sktm">Saya menyatakan data yang saya isi adalah benar.</label>
                                <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4"><button type="reset" class="btn btn-light">Reset</button><button type="submit" class="btn btn-primary">Kirim Pengajuan</button></div>
                </form>
            </div>
        </div>
    </div>
</section>