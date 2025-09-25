<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Keterangan Suami Istri</h1>
                <p class="text-muted mb-0">Lengkapi semua data di bawah ini dengan benar.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">

                <?= form_open_multipart('pelayanan/submit_suami_istri'); ?>

                <h5 class="mb-4">Data Pengantar RT/RW</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat RT/RW</label>
                        <input type="text" name="nomor_surat_rt" value="<?= set_value('nomor_surat_rt'); ?>" class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>" placeholder="Contoh: 01/RT.01/IX/2025" required>
                        <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat RT/RW</label>
                        <input type="date" name="tanggal_surat_rt" value="<?= set_value('tanggal_surat_rt'); ?>" class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Upload Scan/Foto Surat RT/RW</label>
                        <input type="file" name="scan_surat_rt" class="form-control <?= form_error('scan_surat_rt') || $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>" required>
                        <?php if ($this->session->flashdata('upload_error')): ?>
                            <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                        <?php endif; ?>
                        <div class="form-text mt-1">Format: PDF/JPG/PNG (maks. 2 MB)</div>
                    </div>
                </div>
                <hr class="my-4">

                <h5 class="mb-4">Data Pihak Pertama (Pemohon)</h5>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" name="nama_pihak_satu" value="<?= set_value('nama_pihak_satu'); ?>" class="form-control <?= form_error('nama_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="Masukkan nama sesuai KTP" required></div>
                    <div class="col-md-6"><label class="form-label">NIK</label><input type="text" name="nik_pihak_satu" value="<?= set_value('nik_pihak_satu'); ?>" class="form-control <?= form_error('nik_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="16 digit NIK" required></div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="telepon_pemohon" value="<?= set_value('telepon_pemohon'); ?>"
                            placeholder="Contoh: 081234567890"
                            class="form-control <?= form_error('telepon_pemohon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('telepon_pemohon'); ?></div>
                    </div>

                    <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_pihak_satu" value="<?= set_value('tempat_lahir_pihak_satu'); ?>" class="form-control <?= form_error('tempat_lahir_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="Kota tempat lahir" required></div>
                    <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir_pihak_satu" value="<?= set_value('tanggal_lahir_pihak_satu'); ?>" class="form-control <?= form_error('tanggal_lahir_pihak_satu') ? 'is-invalid' : ''; ?>" required></div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin_pihak_satu" id="lk1" value="Laki-laki" <?= set_radio('jenis_kelamin_pihak_satu', 'Laki-laki', TRUE); ?> required>
                            <label class="form-check-label" for="lk1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin_pihak_satu" id="pr1" value="Perempuan" <?= set_radio('jenis_kelamin_pihak_satu', 'Perempuan'); ?>>
                            <label class="form-check-label" for="pr1">Perempuan</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama_pihak_satu" value="<?= set_value('agama_pihak_satu'); ?>" class="form-control <?= form_error('agama_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Islam" required></div>
                    <div class="col-md-6"><label class="form-label">Kewarganegaraan</label><input type="text" name="warganegara_pihak_satu" value="<?= set_value('warganegara_pihak_satu', 'Indonesia'); ?>" placeholder="Contoh: Indonesia" class="form-control <?= form_error('warganegara_pihak_satu') ? 'is-invalid' : ''; ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_pihak_satu" value="<?= set_value('pekerjaan_pihak_satu'); ?>" class="form-control <?= form_error('pekerjaan_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Karyawan Swasta" required></div>
                    <div class="col-12"><label class="form-label">Alamat Lengkap</label><textarea name="alamat_pihak_satu" rows="3" class="form-control <?= form_error('alamat_pihak_satu') ? 'is-invalid' : ''; ?>" placeholder="Alamat lengkap sesuai KTP" required><?= set_value('alamat_pihak_satu'); ?></textarea></div>
                </div>
                <hr class="my-4">

                <h5 class="mb-4">Data Pihak Kedua (Pasangan)</h5>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nama Lengkap Pasangan</label><input type="text" name="nama_pihak_dua" value="<?= set_value('nama_pihak_dua'); ?>" class="form-control <?= form_error('nama_pihak_dua') ? 'is-invalid' : ''; ?>" placeholder="Masukkan nama pasangan sesuai KTP" required></div>
                    <div class="col-md-6"><label class="form-label">NIK Pasangan</label><input type="text" name="nik_pihak_dua" value="<?= set_value('nik_pihak_dua'); ?>" class="form-control <?= form_error('nik_pihak_dua') ? 'is-invalid' : ''; ?>" placeholder="16 digit NIK" required></div>
                    <div class="col-12"><label class="form-label">Alamat Lengkap Pasangan</label><textarea name="alamat_pihak_dua" rows="3" class="form-control <?= form_error('alamat_pihak_dua') ? 'is-invalid' : ''; ?>" placeholder="Alamat lengkap pasangan sesuai KTP" required><?= set_value('alamat_pihak_dua'); ?></textarea></div>
                </div>
                <hr class="my-4">

                <h5 class="mb-4">Keperluan Surat</h5>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Surat ini digunakan untuk</label><input type="text" name="keperluan" value="<?= set_value('keperluan'); ?>" class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Persyaratan Pengurusan Surat Waris" required></div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_bmr" required>
                    <label class="form-check-label" for="agree_bmr">Saya menyatakan data yang diisi adalah benar.</label>
                    <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-5">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</section>