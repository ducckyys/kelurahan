<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Keterangan Belum Bekerja</h1>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="post" action="<?= base_url('pelayanan/submit-belum-bekerja'); ?>" enctype="multipart/form-data">
                    <h5 class="mb-4">Data Pengantar RT/RW</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat RT/RW</label>
                            <input type="text" name="nomor_surat_rt" value="<?= set_value('nomor_surat_rt'); ?>" placeholder="Nomor Surat RT/RW" class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Surat RT/RW</label>
                            <input type="date" name="tanggal_surat_rt" value="<?= set_value('tanggal_surat_rt'); ?>" class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Scan/Foto Surat RT/RW</label>
                            <input type="file" name="scan_surat_rt" class="form-control <?= form_error('scan_surat_rt') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('scan_surat_rt'); ?></div>
                            <?php if ($this->session->flashdata('upload_error')): ?><div class="text-danger small mt-1"><?= $this->session->flashdata('upload_error'); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h5 class="mb-4">Data Diri Pemohon</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemohon</label>
                            <input type="text" name="nama_pemohon" value="<?= set_value('nama_pemohon'); ?>" placeholder="Nama Pemohon" class="form-control <?= form_error('nama_pemohon') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_pemohon'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK Pemohon</label>
                            <input type="text" name="nik" value="<?= set_value('nik'); ?>" placeholder="NIK Pemohon" class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= set_value('tempat_lahir'); ?>" placeholder="Tempat Lahir" class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= set_value('tanggal_lahir'); ?>" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select <?= form_error('jenis_kelamin') ? 'is-invalid' : ''; ?>" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki'); ?>>Laki-laki</option>
                                <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan'); ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback"><?= form_error('jenis_kelamin'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="warganegara" value="<?= set_value('warganegara'); ?>" placeholder="Warganegara" class="form-control <?= form_error('warganegara') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('warganegara'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" value="<?= set_value('agama'); ?>" placeholder="Agama" class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="<?= set_value('pekerjaan'); ?>" placeholder="Pekerjaan" class="form-control <?= form_error('pekerjaan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pekerjaan'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Diperlukan Untuk</label>
                            <input type="text" name="keperluan" value="<?= set_value('keperluan'); ?>" class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" placeholder="Contoh: Melamar Pekerjaan" required>
                            <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-check"><input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_sktm"><label class="form-check-label" for="agree_sktm">Saya menyatakan data yang saya isi adalah benar.</label>
                            <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>