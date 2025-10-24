<?php

/**
 * ============================================================================
 * View: Pelayanan — Surat Pengantar Nikah
 * ----------------------------------------------------------------------------
 * Tujuan
 * - Menyediakan form pengajuan dengan placeholder profesional dan rapi.
 *
 * Prasyarat
 * - CodeIgniter helpers: url, form (base_url(), form_error(), set_value(), set_radio()).
 * - Controller boleh mengirim $title dan $subtitle (opsional).
 * - Flashdata 'upload_error' (opsional) untuk menampilkan kegagalan upload file.
 *
 * Catatan Teknis
 * - Menggunakan form_open_multipart() untuk unggah multi-file pendukung.
 * - Atribut HTML (required, autocomplete, inputmode) membantu UX; validasi akhir tetap di server.
 * ============================================================================
 */
defined('BASEPATH') or exit('No direct script access allowed');
?>
<section class="py-5">
    <div class="container">
        <?php
        $title    = $title    ?? 'Surat Pengantar Nikah';
        $subtitle = $subtitle ?? 'Lengkapi data berikut dengan benar sesuai dokumen asli.';
        $backHref = base_url() . '#pelayanan';
        ?>

        <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
            <a href="<?= $backHref ?>" class="back-icon ms-auto" aria-label="Kembali"
                onclick="if (history.length > 1) { history.back(); return false; }">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
                <span class="ms-2 fw-semibold d-none d-sm-inline">Kembali</span>
            </a>
        </div>

        <div class="mb-4">
            <h1 class="h4 mb-1 section-title"><?= htmlentities($title, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="text-muted mb-0"><?= htmlentities($subtitle, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="card shadow-sm brand-card">
            <div class="card-body p-4 p-md-5">
                <?= form_open_multipart('pelayanan/submit_pengantar_nikah'); ?>

                <h5 class="mb-3 text-primary">Surat Pengantar RT/RW & Lampiran</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat Pengantar RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            placeholder="Contoh: 012/RT01/RW02/2025"
                            autocomplete="off"
                            class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat Pengantar RT/RW</label>
                        <input type="date" name="tanggal_surat_rt"
                            value="<?= set_value('tanggal_surat_rt'); ?>"
                            class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>" required>
                        <div class="form-text">Pilih tanggal sesuai surat pengantar RT/RW.</div>
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
                            <div class="form-text">Unggah minimal 1 dokumen (KTP/KK/Surat RT-RW). Maksimal 2&nbsp;MB per file (JPG/PNG/PDF).</div>
                        <?php endif; ?>
                        <ul id="dokList" class="small mt-2 text-muted"></ul>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Data Pria (Pemohon)</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="pria_nama"
                            value="<?= set_value('pria_nama'); ?>"
                            placeholder="Nama lengkap sesuai KTP"
                            autocomplete="name"
                            class="form-control <?= form_error('pria_nama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_nama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="pria_nik"
                            value="<?= set_value('pria_nik'); ?>"
                            inputmode="numeric" maxlength="16"
                            placeholder="16 digit NIK (tanpa spasi/tanda baca)"
                            class="form-control <?= form_error('pria_nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="pria_tempat_lahir"
                            value="<?= set_value('pria_tempat_lahir'); ?>"
                            placeholder="Contoh: Jakarta"
                            autocomplete="address-level2"
                            class="form-control <?= form_error('pria_tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_tempat_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="pria_tanggal_lahir"
                            value="<?= set_value('pria_tanggal_lahir'); ?>"
                            autocomplete="bday"
                            class="form-control <?= form_error('pria_tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="form-text">Pilih tanggal lahir sesuai KTP.</div>
                        <div class="invalid-feedback"><?= form_error('pria_tanggal_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="pria_kewarganegaraan"
                            value="<?= set_value('pria_kewarganegaraan'); ?>"
                            placeholder="Misal: Indonesia"
                            autocomplete="country-name"
                            class="form-control <?= form_error('pria_kewarganegaraan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_kewarganegaraan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="pria_agama"
                            value="<?= set_value('pria_agama'); ?>"
                            placeholder="Misal: Islam"
                            autocomplete="off"
                            class="form-control <?= form_error('pria_agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_agama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pria_pekerjaan"
                            value="<?= set_value('pria_pekerjaan'); ?>"
                            placeholder="Misal: Karyawan Swasta / Wiraswasta / PNS"
                            autocomplete="organization-title"
                            class="form-control <?= form_error('pria_pekerjaan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pria_pekerjaan'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="pria_alamat" rows="3"
                            placeholder="Sesuai KTP: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('pria_alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('pria_alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('pria_alamat'); ?></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-block">Status Pernikahan</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="pria_status" id="st1" value="Jejaka"
                                <?= set_radio('pria_status', 'Jejaka', true); ?> required>
                            <label class="form-check-label" for="st1">Jejaka</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="pria_status" id="st2" value="Duda"
                                <?= set_radio('pria_status', 'Duda'); ?>>
                            <label class="form-check-label" for="st2">Duda</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="pria_status" id="st3" value="Beristri"
                                <?= set_radio('pria_status', 'Beristri'); ?>>
                            <label class="form-check-label" for="st3">Beristri</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= form_error('pria_status'); ?></div>
                        <div class="form-text">Pilih salah satu sesuai kondisi saat ini.</div>
                    </div>

                    <div class="col-md-6" id="fieldIstriKe" style="display:none;">
                        <label class="form-label">Istri ke-</label>
                        <input type="number" min="1" name="pria_istri_ke"
                            value="<?= set_value('pria_istri_ke'); ?>"
                            placeholder="Masukkan angka ≥ 1 (wajib jika Beristri)"
                            class="form-control <?= form_error('pria_istri_ke') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('pria_istri_ke'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Data Orang Tua</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Orang Tua</label>
                        <input type="text" name="ortu_nama"
                            value="<?= set_value('ortu_nama'); ?>"
                            placeholder="Contoh: Budi Santoso"
                            autocomplete="name"
                            class="form-control <?= form_error('ortu_nama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('ortu_nama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK Orang Tua (opsional)</label>
                        <input type="text" name="ortu_nik"
                            value="<?= set_value('ortu_nik'); ?>"
                            inputmode="numeric" maxlength="16"
                            placeholder="16 digit (jika ada)"
                            class="form-control <?= form_error('ortu_nik') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('ortu_nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir (opsional)</label>
                        <input type="text" name="ortu_tempat_lahir"
                            value="<?= set_value('ortu_tempat_lahir'); ?>"
                            placeholder="Contoh: Bandung"
                            autocomplete="address-level2"
                            class="form-control <?= form_error('ortu_tempat_lahir') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('ortu_tempat_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir (opsional)</label>
                        <input type="date" name="ortu_tanggal_lahir"
                            value="<?= set_value('ortu_tanggal_lahir'); ?>"
                            class="form-control <?= form_error('ortu_tanggal_lahir') ? 'is-invalid' : ''; ?>">
                        <div class="form-text">Isi bila diketahui.</div>
                        <div class="invalid-feedback"><?= form_error('ortu_tanggal_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="ortu_kewarganegaraan"
                            value="<?= set_value('ortu_kewarganegaraan'); ?>"
                            placeholder="Misal: Indonesia"
                            autocomplete="country-name"
                            class="form-control <?= form_error('ortu_kewarganegaraan') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('ortu_kewarganegaraan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama (opsional)</label>
                        <input type="text" name="ortu_agama"
                            value="<?= set_value('ortu_agama'); ?>"
                            placeholder="Contoh: Islam/Kristen/Hindu/Buddha/Konghucu"
                            autocomplete="off"
                            class="form-control <?= form_error('ortu_agama') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('ortu_agama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan (opsional)</label>
                        <input type="text" name="ortu_pekerjaan"
                            value="<?= set_value('ortu_pekerjaan'); ?>"
                            placeholder="Contoh: Wiraswasta/Pensiunan/Ibu Rumah Tangga"
                            autocomplete="organization-title"
                            class="form-control <?= form_error('ortu_pekerjaan') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('ortu_pekerjaan'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Orang Tua (opsional)</label>
                        <textarea name="ortu_alamat" rows="3"
                            placeholder="Contoh: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('ortu_alamat') ? 'is-invalid' : ''; ?>"><?= set_value('ortu_alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('ortu_alamat'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Data Calon Istri (Wanita)</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="wanita_nama"
                            value="<?= set_value('wanita_nama'); ?>"
                            placeholder="Nama lengkap sesuai KTP"
                            autocomplete="name"
                            class="form-control <?= form_error('wanita_nama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_nama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="wanita_nik"
                            value="<?= set_value('wanita_nik'); ?>"
                            inputmode="numeric" maxlength="16"
                            placeholder="16 digit NIK (tanpa spasi/tanda baca)"
                            class="form-control <?= form_error('wanita_nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="wanita_tempat_lahir"
                            value="<?= set_value('wanita_tempat_lahir'); ?>"
                            placeholder="Contoh: Surabaya"
                            autocomplete="address-level2"
                            class="form-control <?= form_error('wanita_tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_tempat_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="wanita_tanggal_lahir"
                            value="<?= set_value('wanita_tanggal_lahir'); ?>"
                            autocomplete="bday"
                            class="form-control <?= form_error('wanita_tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="form-text">Pilih tanggal lahir sesuai KTP.</div>
                        <div class="invalid-feedback"><?= form_error('wanita_tanggal_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="wanita_kewarganegaraan"
                            value="<?= set_value('wanita_kewarganegaraan'); ?>"
                            placeholder="Misal: Indonesia"
                            autocomplete="country-name"
                            class="form-control <?= form_error('wanita_kewarganegaraan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_kewarganegaraan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="wanita_agama"
                            value="<?= set_value('wanita_agama'); ?>"
                            placeholder="Misal: Islam"
                            autocomplete="off"
                            class="form-control <?= form_error('wanita_agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_agama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="wanita_pekerjaan"
                            value="<?= set_value('wanita_pekerjaan'); ?>"
                            placeholder="Misal: Karyawan Swasta / Pedagang"
                            autocomplete="organization-title"
                            class="form-control <?= form_error('wanita_pekerjaan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('wanita_pekerjaan'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="wanita_alamat" rows="3"
                            placeholder="Sesuai KTP: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('wanita_alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('wanita_alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('wanita_alamat'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Status (Wanita)</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="wanita_status" id="ws1" value="Perawan"
                                <?= set_radio('wanita_status', 'Perawan', true); ?> required>
                            <label class="form-check-label" for="ws1">Perawan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="wanita_status" id="ws2" value="Janda"
                                <?= set_radio('wanita_status', 'Janda'); ?>>
                            <label class="form-check-label" for="ws2">Janda</label>
                        </div>
                        <div class="invalid-feedback d-block"><?= form_error('wanita_status'); ?></div>
                        <div class="form-text">Pilih salah satu sesuai status saat ini.</div>
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_nikah" required>
                    <label class="form-check-label" for="agree_nikah">Saya menyatakan data yang diisi adalah benar.</label>
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
        const input = document.querySelector('input[name="dokumen_pendukung[]"]');
        const list = document.getElementById('dokList');
        if (input && list) {
            input.addEventListener('change', function() {
                list.innerHTML = '';
                if (!this.files) return;
                Array.from(this.files).forEach(function(f) {
                    const li = document.createElement('li');
                    li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                    list.appendChild(li);
                });
            });
        }

        function toggleIstriKe() {
            const wrapper = document.getElementById('fieldIstriKe');
            const inputIstriKe = document.querySelector('input[name="pria_istri_ke"]');
            const checked = document.querySelector('input[name="pria_status"]:checked');
            const show = checked && checked.value === 'Beristri';
            if (wrapper) wrapper.style.display = show ? '' : 'none';
            if (inputIstriKe) {
                inputIstriKe.required = !!show;
                if (!show) inputIstriKe.value = '';
            }
        }
        document.querySelectorAll('input[name="pria_status"]').forEach(function(r) {
            r.addEventListener('change', toggleIstriKe);
        });
        toggleIstriKe();
    });
</script>