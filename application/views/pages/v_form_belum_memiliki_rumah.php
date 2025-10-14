<?php

/**
 * View: Pelayanan — Surat Belum Memiliki Rumah
 * Helper: url, form
 * Flashdata opsional: 'upload_error'
 */
?>
<section class="py-5">
    <div class="container">
        <?php
        $title    = 'Surat Belum Memiliki Rumah';
        $subtitle = 'Lengkapi data berikut dengan benar.';
        $backHref = base_url('#pelayanan');
        ?>

        <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
            <a href="<?= $backHref ?>"
                class="back-icon ms-auto"
                aria-label="Kembali"
                onclick="if (history.length > 1) { history.back(); return false; }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
                <span class="ms-2 fw-semibold d-none d-sm-inline">Kembali</span>
            </a>
        </div>

        <div class="mb-4">
            <h1 class="h4 mb-1 section-title"><?= $title; ?></h1>
            <p class="text-muted mb-0"><?= $subtitle; ?></p>
        </div>

        <div class="card shadow-sm brand-card">
            <div class="card-body p-4 p-md-5">
                <?= form_open_multipart('pelayanan/submit_belum_memiliki_rumah'); ?>

                <!-- Dokumen Pendukung -->
                <h5 class="mb-4 text-primary">Dokumen Pendukung</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            placeholder="Contoh: 014/RT.02/05/25"
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
                        <label class="form-label">Unggah Dokumen Pendukung</label>
                        <input type="file" name="dokumen_pendukung[]" multiple
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>" required>
                        <?php if ($this->session->flashdata('upload_error')): ?>
                            <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                        <?php else: ?>
                            <div class="form-text">
                                Unggah minimal 1 dokumen: KTP, KK, dan/atau Surat Pengantar RT/RW (maks. 2 MB per file, JPG/PNG/PDF).
                            </div>
                        <?php endif; ?>
                        <ul id="dokList" class="small mt-2 text-muted"></ul>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Data Diri Pemohon -->
                <h5 class="mb-4 text-primary">Data Diri Pemohon</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pemohon</label>
                        <input type="text" name="nama_pemohon"
                            value="<?= set_value('nama_pemohon'); ?>"
                            placeholder="Nama pemohon sesuai KTP"
                            class="form-control <?= form_error('nama_pemohon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_pemohon'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIK Pemohon</label>
                        <input type="text" name="nik"
                            value="<?= set_value('nik'); ?>"
                            placeholder="16 digit NIK"
                            class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="telepon_pemohon"
                            value="<?= set_value('telepon_pemohon'); ?>"
                            placeholder="Contoh: 081234567890"
                            class="form-control <?= form_error('telepon_pemohon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('telepon_pemohon'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            value="<?= set_value('tempat_lahir'); ?>"
                            placeholder="Contoh: Tangerang"
                            class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tempat_lahir'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="<?= set_value('tanggal_lahir'); ?>"
                            class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_lahir'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk1"
                                value="Laki-laki" <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE); ?> required>
                            <label class="form-check-label" for="lk1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr1"
                                value="Perempuan" <?= set_radio('jenis_kelamin', 'Perempuan'); ?>>
                            <label class="form-check-label" for="pr1">Perempuan</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan"
                            value="<?= set_value('kewarganegaraan', 'Indonesia'); ?>"
                            placeholder="Contoh: Indonesia"
                            class="form-control <?= form_error('kewarganegaraan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('kewarganegaraan'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama"
                            value="<?= set_value('agama'); ?>"
                            placeholder="Contoh: Islam"
                            class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan"
                            value="<?= set_value('pekerjaan'); ?>"
                            placeholder="Contoh: Karyawan Swasta"
                            class="form-control <?= form_error('pekerjaan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pekerjaan'); ?></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                            placeholder="Contoh: Jl. Melati No. 45 RT 02 RW 05, Kademangan, Setu"
                            class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keperluan</label>
                        <input type="text" name="keperluan"
                            value="<?= set_value('keperluan'); ?>"
                            placeholder="Contoh: Pengajuan bantuan perumahan"
                            class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_bmr" required>
                    <label class="form-check-label" for="agree_bmr">
                        Saya menyatakan data yang diisi adalah benar.
                    </label>
                    <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('input[name="dokumen_pendukung[]"]');
        const list = document.getElementById('dokList');
        if (!input || !list) return;
        input.addEventListener('change', function() {
            list.innerHTML = '';
            if (!this.files) return;
            Array.from(this.files).forEach(function(f) {
                const li = document.createElement('li');
                li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                list.appendChild(li);
            });
        });
    });
</script>