<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Kematian (Non Dukcapil)</h1>
                <p class="text-muted mb-0">Lengkapi data berikut dengan benar.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="<?= base_url('pelayanan/submit_kematian_nondukcapil'); ?>" enctype="multipart/form-data">

                    <h5 class="mb-3">Surat Pengantar RT/RW</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat RT/RW</label>
                            <input type="text" name="nomor_surat_rt"
                                value="<?= set_value('nomor_surat_rt'); ?>"
                                placeholder="Nomor surat pengantar RT/RW"
                                class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Surat RT/RW</label>
                            <input type="date" name="tanggal_surat_rt"
                                value="<?= set_value('tanggal_surat_rt'); ?>"
                                class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Scan/Foto Surat RT/RW</label>
                            <input type="file" name="scan_surat_rt"
                                class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>" required>
                            <?php if ($this->session->flashdata('upload_error')): ?>
                                <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                            <?php endif; ?>
                            <div class="form-text mt-1">Format: PDF/JPG/PNG (maks. 2 MB)</div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Data Ahli Waris (Pemohon)</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Ahli Waris</label>
                            <input type="text" name="nama_ahli_waris"
                                value="<?= set_value('nama_ahli_waris'); ?>"
                                placeholder="Nama ahli waris"
                                class="form-control <?= form_error('nama_ahli_waris') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_ahli_waris'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK Ahli Waris</label>
                            <input type="text" name="nik_ahli_waris"
                                value="<?= set_value('nik_ahli_waris'); ?>"
                                placeholder="16 digit NIK"
                                class="form-control <?= form_error('nik_ahli_waris') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nik_ahli_waris'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. Telepon (WhatsApp)</label>
                            <input type="text" name="telepon_pemohon"
                                value="<?= set_value('telepon_pemohon'); ?>"
                                placeholder="Contoh: 08123456789"
                                class="form-control <?= form_error('telepon_pemohon') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('telepon_pemohon'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk1" value="Laki-laki" <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE); ?> required>
                                <label class="form-check-label" for="lk1">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr1" value="Perempuan" <?= set_radio('jenis_kelamin', 'Perempuan'); ?>>
                                <label class="form-check-label" for="pr1">Perempuan</label>
                            </div>
                            <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hubungan dengan Almarhum/ah</label>
                            <input type="text" name="hubungan_ahli_waris"
                                value="<?= set_value('hubungan_ahli_waris'); ?>"
                                placeholder="Contoh: Istri / Suami / Anak Kandung"
                                class="form-control <?= form_error('hubungan_ahli_waris') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('hubungan_ahli_waris'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Ahli Waris</label>
                            <textarea name="alamat_ahli_waris" rows="3"
                                placeholder="Contoh: Jl. Melati No. 10, RT 005/RW 002, Kademangan"
                                class="form-control <?= form_error('alamat_ahli_waris') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_ahli_waris'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat_ahli_waris'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Data Almarhum/Almarhumah</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Almarhum/ah</label>
                            <input type="text" name="nama_almarhum"
                                value="<?= set_value('nama_almarhum'); ?>"
                                placeholder="Nama almarhum/ah"
                                class="form-control <?= form_error('nama_almarhum') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_almarhum'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK Almarhum/ah</label>
                            <input type="text" name="nik_almarhum"
                                value="<?= set_value('nik_almarhum'); ?>"
                                placeholder="16 digit NIK (jika ada)"
                                class="form-control <?= form_error('nik_almarhum') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nik_almarhum'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan (Hubungan Almarhum/ah dengan Ahli Waris)</label>
                            <input type="text" name="keterangan_almarhum"
                                value="<?= set_value('keterangan_almarhum'); ?>"
                                placeholder="Contoh: Ibu Kandung / Ayah Kandung / Suami"
                                class="form-control <?= form_error('keterangan_almarhum') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('keterangan_almarhum'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Meninggal</label>
                            <input type="text" name="tempat_meninggal"
                                value="<?= set_value('tempat_meninggal'); ?>"
                                placeholder="Contoh: Rumah / RSUD dr. Suyoto"
                                class="form-control <?= form_error('tempat_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_meninggal'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Meninggal</label>
                            <input type="date" name="tanggal_meninggal"
                                value="<?= set_value('tanggal_meninggal'); ?>"
                                class="form-control <?= form_error('tanggal_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_meninggal'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Almarhum/ah</label>
                            <textarea name="alamat_almarhum" rows="3"
                                placeholder="Contoh: Jl. Kenanga No. 21, RT 003/RW 004, Kademangan"
                                class="form-control <?= form_error('alamat_almarhum') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_almarhum'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat_almarhum'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Keperluan Surat</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Surat ini digunakan untuk keperluan</label>
                            <input type="text" name="keperluan"
                                value="<?= set_value('keperluan'); ?>"
                                placeholder="Contoh: Administrasi Perbankan / Klaim Asuransi"
                                class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                        </div>
                    </div>

                    <div class="form-check mt-4">
                        <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_nondukcapil" required>
                        <label class="form-check-label" for="agree_nondukcapil">Saya menyatakan data yang diisi adalah benar.</label>
                        <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="reset" class="btn btn-light">Reset</button>
                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>