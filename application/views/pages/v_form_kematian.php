<?php

/**
 * ============================================================================
 * View: Pelayanan — Surat Keterangan Kematian (Dukcapil)
 * ----------------------------------------------------------------------------
 * Prasyarat
 * - CodeIgniter helpers: url, form (base_url(), form_error(), set_value(), set_radio()).
 * - Controller boleh mengirim $title dan $subtitle (opsional).
 * - Flashdata 'upload_error' (opsional) untuk menampilkan kegagalan upload file.
 *
 * Catatan Teknis
 * - Menggunakan form_open_multipart() untuk opsi unggah multi-file pendukung (opsional).
 * - Atribut HTML (required, autocomplete, inputmode) membantu UX; validasi akhir tetap di server.
 * ============================================================================
 */
?>
<section class="py-5">
    <div class="container">
        <?php
        $title    = $title    ?? 'Surat Keterangan Kematian (Dukcapil)';
        $subtitle = $subtitle ?? 'Lengkapi data berikut dengan benar.';
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

        <div class="mb-4">
            <h1 class="h4 mb-1 section-title"><?= htmlentities($title, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="text-muted mb-0"><?= htmlentities($subtitle, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="card shadow-sm brand-card">
            <div class="card-body p-4 p-md-5">
                <?= form_open_multipart('pelayanan/submit_kematian'); ?>

                <h5 class="mb-3 text-primary">Data Almarhum/Almarhumah</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama"
                            value="<?= set_value('nama'); ?>"
                            placeholder="Nama lengkap sesuai KTP"
                            autocomplete="name"
                            class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik"
                            value="<?= set_value('nik'); ?>"
                            placeholder="16 digit NIK (tanpa spasi)"
                            inputmode="numeric" autocomplete="off"
                            class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                name="jenis_kelamin" id="jk_l" value="Laki-laki"
                                <?= set_radio('jenis_kelamin', 'Laki-laki', true); ?> required>
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
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            value="<?= set_value('tempat_lahir'); ?>"
                            placeholder="Contoh: Tangerang Selatan"
                            autocomplete="address-level2"
                            class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tempat_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="<?= set_value('tanggal_lahir'); ?>"
                            autocomplete="bday"
                            class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama"
                            value="<?= set_value('agama'); ?>"
                            placeholder="Contoh: Islam / Kristen"
                            autocomplete="off"
                            class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan"
                            value="<?= set_value('pekerjaan'); ?>"
                            placeholder="Contoh: Karyawan Swasta"
                            autocomplete="organization-title"
                            class="form-control <?= form_error('pekerjaan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pekerjaan'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" rows="3"
                            placeholder="Sesuai KTP: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Data Kematian</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Hari</label>
                        <input type="text" name="hari_meninggal"
                            value="<?= set_value('hari_meninggal'); ?>"
                            placeholder="Contoh: Senin"
                            autocomplete="off"
                            class="form-control <?= form_error('hari_meninggal') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('hari_meninggal'); ?></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_meninggal"
                            value="<?= set_value('tanggal_meninggal'); ?>"
                            class="form-control <?= form_error('tanggal_meninggal') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_meninggal'); ?></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jam</label>
                        <input type="time" name="jam_meninggal"
                            value="<?= set_value('jam_meninggal'); ?>"
                            class="form-control <?= form_error('jam_meninggal') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('jam_meninggal'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Meninggal</label>
                        <input type="text" name="tempat_meninggal"
                            value="<?= set_value('tempat_meninggal'); ?>"
                            placeholder="Contoh: Rumah / RSUD Tangerang Selatan"
                            autocomplete="off"
                            class="form-control <?= form_error('tempat_meninggal') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tempat_meninggal'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sebab Meninggal</label>
                        <input type="text" name="sebab_meninggal"
                            value="<?= set_value('sebab_meninggal'); ?>"
                            placeholder="Contoh: Sakit / Kecelakaan"
                            autocomplete="off"
                            class="form-control <?= form_error('sebab_meninggal') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('sebab_meninggal'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tempat Pemakaman</label>
                        <input type="text" name="tempat_pemakaman"
                            value="<?= set_value('tempat_pemakaman'); ?>"
                            placeholder="Contoh: TPU Kademangan"
                            autocomplete="off"
                            class="form-control <?= form_error('tempat_pemakaman') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tempat_pemakaman'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Data Pelapor</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor</label>
                        <input type="text" name="pelapor_nama"
                            value="<?= set_value('pelapor_nama'); ?>"
                            placeholder="Nama pelapor"
                            autocomplete="name"
                            class="form-control <?= form_error('pelapor_nama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_nama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK Pelapor</label>
                        <input type="text" name="pelapor_nik"
                            value="<?= set_value('pelapor_nik'); ?>"
                            placeholder="16 digit NIK (tanpa spasi)"
                            inputmode="numeric" autocomplete="off"
                            class="form-control <?= form_error('pelapor_nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon Pelapor</label>
                        <input type="text" name="pelapor_no_telepon"
                            value="<?= set_value('pelapor_no_telepon'); ?>"
                            placeholder="Nomor WhatsApp aktif (08xxxxxxxxxx)"
                            inputmode="tel" autocomplete="tel"
                            class="form-control <?= form_error('pelapor_no_telepon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_no_telepon'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hubungan dengan Almarhum/ah</label>
                        <input type="text" name="pelapor_hubungan"
                            value="<?= set_value('pelapor_hubungan'); ?>"
                            placeholder="Contoh: Istri / Suami / Anak / Saudara"
                            autocomplete="off"
                            class="form-control <?= form_error('pelapor_hubungan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_hubungan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir Pelapor</label>
                        <input type="text" name="pelapor_tempat_lahir"
                            value="<?= set_value('pelapor_tempat_lahir'); ?>"
                            placeholder="Contoh: Tangerang Selatan"
                            autocomplete="address-level2"
                            class="form-control <?= form_error('pelapor_tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_tempat_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir Pelapor</label>
                        <input type="date" name="pelapor_tanggal_lahir"
                            value="<?= set_value('pelapor_tanggal_lahir'); ?>"
                            autocomplete="bday"
                            class="form-control <?= form_error('pelapor_tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_tanggal_lahir'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama Pelapor</label>
                        <input type="text" name="pelapor_agama"
                            value="<?= set_value('pelapor_agama'); ?>"
                            placeholder="Contoh: Islam / Kristen"
                            autocomplete="off"
                            class="form-control <?= form_error('pelapor_agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_agama'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan Pelapor</label>
                        <input type="text" name="pelapor_pekerjaan"
                            value="<?= set_value('pelapor_pekerjaan'); ?>"
                            placeholder="Contoh: Wiraswasta"
                            autocomplete="organization-title"
                            class="form-control <?= form_error('pelapor_pekerjaan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('pelapor_pekerjaan'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Pelapor</label>
                        <textarea name="pelapor_alamat" rows="3"
                            placeholder="Sesuai KTP: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('pelapor_alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('pelapor_alamat'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('pelapor_alamat'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Dokumen Pendukung</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            placeholder="Nomor surat pengantar RT/RW (opsional)"
                            autocomplete="off"
                            class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Surat RT/RW</label>
                        <input type="date" name="tanggal_surat_rt"
                            value="<?= set_value('tanggal_surat_rt'); ?>"
                            class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Unggah Dokumen Pendukung</label>
                        <input type="file" name="dokumen_pendukung[]"
                            multiple accept=".pdf,.jpg,.jpeg,.png"
                            class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>">
                        <?php if ($this->session->flashdata('upload_error')): ?>
                            <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                        <?php else: ?>
                            <div class="form-text mt-1">
                                Format: PDF/JPG/PNG (maks. 2&nbsp;MB per file). Unggah surat RT/RW, KTP/KK, surat RS, dsb. (opsional).
                            </div>
                        <?php endif; ?>
                        <ul id="dokList" class="small mt-2 text-muted"></ul>
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_sk" required>
                    <label class="form-check-label" for="agree_sk">Saya menyatakan data yang saya isi adalah benar.</label>
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