<?php

/**
 * View: Pelayanan — Surat Keterangan Suami Istri
 */
?>
<section class="py-5">
    <div class="container">
        <?php
        $title    = 'Surat Keterangan Suami Istri';
        $subtitle = 'Lengkapi semua data di bawah ini dengan benar.';
        $backHref = base_url('#pelayanan');
        ?>
        <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
            <a href="<?= $backHref ?>" class="back-icon ms-auto" aria-label="Kembali"
                onclick="if (history.length > 1) { history.back(); return false; }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
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

                <?= form_open_multipart('pelayanan/submit_suami_istri'); ?>

                <!-- Dokumen Pendukung (pola SKTM) -->
                <h5 class="mb-4 text-primary">Dokumen Pendukung</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat Pengantar RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            placeholder="Contoh: 01/RT01/RW02/KDM/2025"
                            class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat Pengantar RT/RW</label>
                        <input type="date" name="tanggal_surat_rt"
                            value="<?= set_value('tanggal_surat_rt'); ?>"
                            class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Lampirkan Dokumen Pendukung</label>
                        <input type="file" name="dokumen_pendukung[]"
                            class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>"
                            accept=".jpg,.jpeg,.png,.pdf" multiple required>
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

                <!-- Data Pihak Pertama -->
                <h5 class="mb-4 text-primary">Data Pihak Pertama (Pemohon)</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_pihak_satu"
                            value="<?= set_value('nama_pihak_satu'); ?>"
                            placeholder="Masukkan nama sesuai KTP"
                            class="form-control <?= form_error('nama_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik_pihak_satu"
                            value="<?= set_value('nik_pihak_satu'); ?>"
                            placeholder="16 digit NIK"
                            class="form-control <?= form_error('nik_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nik_pihak_satu'); ?></div>
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
                        <input type="text" name="tempat_lahir_pihak_satu"
                            value="<?= set_value('tempat_lahir_pihak_satu'); ?>"
                            placeholder="Kota tempat lahir"
                            class="form-control <?= form_error('tempat_lahir_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tempat_lahir_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_pihak_satu"
                            value="<?= set_value('tanggal_lahir_pihak_satu'); ?>"
                            class="form-control <?= form_error('tanggal_lahir_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_lahir_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin_pihak_satu" id="lk1"
                                value="Laki-laki" <?= set_radio('jenis_kelamin_pihak_satu', 'Laki-laki', TRUE); ?> required>
                            <label class="form-check-label" for="lk1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin_pihak_satu" id="pr1"
                                value="Perempuan" <?= set_radio('jenis_kelamin_pihak_satu', 'Perempuan'); ?>>
                            <label class="form-check-label" for="pr1">Perempuan</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama_pihak_satu"
                            value="<?= set_value('agama_pihak_satu'); ?>"
                            placeholder="Contoh: Islam"
                            class="form-control <?= form_error('agama_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('agama_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="warganegara_pihak_satu"
                            value="<?= set_value('warganegara_pihak_satu', 'Indonesia'); ?>"
                            placeholder="Contoh: Indonesia"
                            class="form-control <?= form_error('warganegara_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('warganegara_pihak_satu'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan_pihak_satu"
                            value="<?= set_value('pekerjaan_pihak_satu'); ?>"
                            placeholder="Contoh: Karyawan Swasta"
                            class="form-control <?= form_error('pekerjaan_pihak_satu') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pekerjaan_pihak_satu'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_pihak_satu" rows="3"
                            placeholder="Alamat lengkap sesuai KTP"
                            class="form-control <?= form_error('alamat_pihak_satu') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_pihak_satu'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat_pihak_satu'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Data Pihak Kedua -->
                <h5 class="mb-4 text-primary">Data Pihak Kedua (Pasangan)</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap Pasangan</label>
                        <input type="text" name="nama_pihak_dua"
                            value="<?= set_value('nama_pihak_dua'); ?>"
                            placeholder="Masukkan nama pasangan sesuai KTP"
                            class="form-control <?= form_error('nama_pihak_dua') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_pihak_dua'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK Pasangan</label>
                        <input type="text" name="nik_pihak_dua"
                            value="<?= set_value('nik_pihak_dua'); ?>"
                            placeholder="16 digit NIK"
                            class="form-control <?= form_error('nik_pihak_dua') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nik_pihak_dua'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap Pasangan</label>
                        <textarea name="alamat_pihak_dua" rows="3"
                            placeholder="Alamat lengkap pasangan sesuai KTP"
                            class="form-control <?= form_error('alamat_pihak_dua') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_pihak_dua'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat_pihak_dua'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Keperluan -->
                <h5 class="mb-4 text-primary">Keperluan Surat</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Surat ini digunakan untuk</label>
                        <input type="text" name="keperluan"
                            value="<?= set_value('keperluan'); ?>"
                            placeholder="Contoh: Persyaratan Pengurusan Surat Waris"
                            class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_suamiistri" required>
                    <label class="form-check-label" for="agree_suamiistri">
                        Saya menyatakan data yang diisi adalah benar.
                    </label>
                    <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-5">
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
        var input = document.querySelector('input[name="dokumen_pendukung[]"]');
        var list = document.getElementById('dokList');
        if (!input || !list) return;
        input.addEventListener('change', function() {
            list.innerHTML = '';
            if (!this.files) return;
            Array.from(this.files).forEach(function(f) {
                var li = document.createElement('li');
                li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                list.appendChild(li);
            });
        });
    });
</script>