<?php

/**
 * View: Pelayanan — Surat Kematian (Non Dukcapil)
 * Prasyarat helper: url, form
 * Field upload: name="dokumen_pendukung[]" (multi)
 */
?>
<section class="py-5">
    <div class="container">

        <?php
        $title    = 'Surat Kematian (Non Dukcapil)';
        $subtitle = 'Lengkapi data berikut dengan benar.';
        $backHref = base_url() . '#pelayanan';
        ?>

        <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
            <a href="<?= $backHref ?>" class="back-icon ms-auto" aria-label="Kembali"
                onclick="if (history.length > 1) { history.back(); return false; }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
                <span class="ms-2 fw-semibold d-none d-sm-inline">Kembali</span>
            </a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1 section-title"><?= $title; ?></h1>
                <p class="text-muted mb-0"><?= $subtitle; ?></p>
            </div>
        </div>

        <div class="card shadow-sm brand-card">
            <div class="card-body p-4 p-md-5">

                <?= form_open_multipart('pelayanan/submit_kematian_nondukcapil'); ?>

                <!-- Dokumen Pendukung & Data Pengantar RT/RW -->
                <h5 class="mb-4 text-primary">Dokumen Pendukung</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat Pengantar RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            placeholder="Contoh: 123/RT01/RW02/KDM/2025"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat Pengantar RT/RW</label>
                        <input type="date" name="tanggal_surat_rt"
                            value="<?= set_value('tanggal_surat_rt'); ?>"
                            class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Unggah Dokumen Pendukung</label>
                        <input type="file" name="dokumen_pendukung[]"
                            class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>"
                            accept=".jpg,.jpeg,.png,.pdf" multiple required>

                        <?php if ($this->session->flashdata('upload_error')): ?>
                            <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                        <?php else: ?>
                            <div class="form-text">
                                Unggah minimal 1 dokumen: KTP, KK, Surat Pengantar RT/RW, atau surat RS (maks. 2 MB per file, JPG/PNG/PDF).
                            </div>
                        <?php endif; ?>

                        <ul id="dokList" class="small mt-2 text-muted"></ul>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Data Ahli Waris (Pemohon) -->
                <h5 class="mb-4 text-primary">Data Ahli Waris (Pemohon)</h5>
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
                            placeholder="Contoh: 081234567890"
                            class="form-control <?= form_error('telepon_pemohon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('telepon_pemohon'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="jenis_kelamin" id="jk_l" value="Laki-laki"
                                <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE); ?> required>
                            <label class="form-check-label" for="jk_l">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="jenis_kelamin" id="jk_p" value="Perempuan"
                                <?= set_radio('jenis_kelamin', 'Perempuan'); ?>>
                            <label class="form-check-label" for="jk_p">Perempuan</label>
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

                <!-- Data Almarhum/ah -->
                <h5 class="mb-4 text-primary">Data Almarhum/Almarhumah</h5>
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

                <!-- Keperluan -->
                <h5 class="mb-4 text-primary">Keperluan Surat</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Surat ini digunakan untuk keperluan</label>
                        <input type="text" name="keperluan"
                            value="<?= set_value('keperluan'); ?>"
                            class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>"
                            placeholder="Contoh: Administrasi Perbankan / Klaim Asuransi" required>
                        <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                    </div>
                </div>

                <!-- Persetujuan -->
                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_nondukcapil" required>
                    <label class="form-check-label" for="agree_nondukcapil">
                        Saya menyatakan data yang saya isi adalah benar.
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