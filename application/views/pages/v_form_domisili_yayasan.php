<?php

/**
 * ============================================================================
 * View: Pelayanan — Surat Keterangan Domisili Yayasan
 * ----------------------------------------------------------------------------
 * Prasyarat
 * - CodeIgniter helpers: url, form (base_url(), form_error(), set_value(), set_radio()).
 * - Controller boleh mengirim $title dan $subtitle (opsional).
 * - Flashdata 'upload_error' (opsional) untuk menampilkan kegagalan upload.
 *
 * Catatan Teknis
 * - Menggunakan form_open_multipart() untuk unggah multi-file pendukung.
 * - Atribut HTML (required, autocomplete, inputmode) membantu UX; validasi akhir tetap di server.
 * ============================================================================
 */
?>
<section class="py-5">
    <div class="container">
        <?php
        $title    = $title    ?? 'Surat Keterangan Domisili Yayasan';
        $subtitle = $subtitle ?? 'Lengkapi semua data di bawah ini dengan benar.';
        $backHref = base_url() . '#pelayanan';
        ?>

        <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
            <a href="<?= $backHref ?>" class="back-icon ms-auto" aria-label="Kembali"
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
            <h1 class="h4 mb-1 section-title"><?= htmlentities($title, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="text-muted mb-0"><?= htmlentities($subtitle, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="card shadow-sm brand-card">
            <div class="card-body p-4 p-md-5">
                <?= form_open_multipart('pelayanan/submit_domisili_yayasan'); ?>

                <h5 class="mb-4 text-primary">Data Pengantar RT/RW</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat RT/RW</label>
                        <input type="text" name="nomor_surat_rt"
                            value="<?= set_value('nomor_surat_rt'); ?>"
                            placeholder="Contoh: 012/RT01/RW02/2025"
                            autocomplete="off"
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
                        <input type="file" name="dokumen_pendukung[]"
                            multiple accept=".pdf,.jpg,.jpeg,.png"
                            class="form-control <?= $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>" required>
                        <?php if ($this->session->flashdata('upload_error')): ?>
                            <div class="invalid-feedback d-block"><?= $this->session->flashdata('upload_error'); ?></div>
                        <?php else: ?>
                            <div class="form-text">
                                Unggah minimal 1 dokumen (KTP, KK, dan/atau Surat Pengantar RT/RW). Maksimal 2&nbsp;MB per file (JPG/PNG/PDF).
                            </div>
                        <?php endif; ?>
                        <ul id="dokList" class="small mt-2 text-muted"></ul>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-4 text-primary">Data Penanggung Jawab</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" name="nama_penanggung_jawab"
                            value="<?= set_value('nama_penanggung_jawab'); ?>"
                            placeholder="Nama lengkap sesuai KTP"
                            autocomplete="name"
                            class="form-control <?= form_error('nama_penanggung_jawab') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_penanggung_jawab'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK Penanggung Jawab</label>
                        <input type="text" name="nik"
                            value="<?= set_value('nik'); ?>"
                            placeholder="16 digit NIK (tanpa spasi)"
                            inputmode="numeric" autocomplete="off"
                            class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="telepon_pemohon"
                            value="<?= set_value('telepon_pemohon'); ?>"
                            placeholder="Nomor WhatsApp aktif (08xxxxxxxxxx)"
                            inputmode="tel" autocomplete="tel"
                            class="form-control <?= form_error('telepon_pemohon') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('telepon_pemohon'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            value="<?= set_value('tempat_lahir'); ?>"
                            placeholder="Kota/Kabupaten lahir"
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
                        <label class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan"
                            value="<?= set_value('kewarganegaraan'); ?>"
                            placeholder="Misal: Indonesia"
                            autocomplete="country-name"
                            class="form-control <?= form_error('kewarganegaraan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('kewarganegaraan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama"
                            value="<?= set_value('agama'); ?>"
                            placeholder="Misal: Islam"
                            autocomplete="off"
                            class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Sesuai KTP</label>
                        <textarea name="alamat_pemohon" rows="3"
                            placeholder="Sesuai KTP: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('alamat_pemohon') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_pemohon'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat_pemohon'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-4 text-primary">Data Yayasan / Organisasi</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi"
                            value="<?= set_value('nama_organisasi'); ?>"
                            placeholder="Nama yayasan/organisasi"
                            autocomplete="organization"
                            class="form-control <?= form_error('nama_organisasi') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_organisasi'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kegiatan</label>
                        <input type="text" name="jenis_kegiatan"
                            value="<?= set_value('jenis_kegiatan'); ?>"
                            placeholder="Misal: Pendidikan, Sosial, Keagamaan"
                            autocomplete="off"
                            class="form-control <?= form_error('jenis_kegiatan') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('jenis_kegiatan'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Pengurus</label>
                        <input type="number" name="jumlah_pengurus"
                            value="<?= set_value('jumlah_pengurus'); ?>"
                            placeholder="Contoh: 7" min="1" inputmode="numeric"
                            class="form-control <?= form_error('jumlah_pengurus') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('jumlah_pengurus'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NPWP</label>
                        <input type="text" name="npwp"
                            value="<?= set_value('npwp'); ?>"
                            placeholder="Format: 99.999.999.9-999.999"
                            autocomplete="off"
                            class="form-control <?= form_error('npwp') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('npwp'); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Kantor</label>
                        <textarea name="alamat_kantor" rows="3"
                            placeholder="Alamat lengkap lokasi kegiatan/kantor: Jalan..., RT/RW..., Kelurahan..., Kecamatan..., Kota/Kab..., Kode Pos..."
                            autocomplete="street-address"
                            class="form-control <?= form_error('alamat_kantor') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat_kantor'); ?></textarea>
                        <div class="invalid-feedback"><?= form_error('alamat_kantor'); ?></div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-2 text-primary">Data Legalitas</h5>
                <p class="text-muted small">Isi data Akta Pendirian. Jika ada Akta Perubahan, lengkapi juga.</p>

                <h6>Akta Pendirian</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Notaris</label>
                        <input type="text" name="nama_notaris_pendirian"
                            value="<?= set_value('nama_notaris_pendirian'); ?>"
                            placeholder="Nama notaris pembuat akta"
                            autocomplete="off"
                            class="form-control <?= form_error('nama_notaris_pendirian') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nama_notaris_pendirian'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Akta</label>
                        <input type="text" name="nomor_akta_pendirian"
                            value="<?= set_value('nomor_akta_pendirian'); ?>"
                            placeholder="Nomor akta pendirian"
                            autocomplete="off"
                            class="form-control <?= form_error('nomor_akta_pendirian') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('nomor_akta_pendirian'); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Akta</label>
                        <input type="date" name="tanggal_akta_pendirian"
                            value="<?= set_value('tanggal_akta_pendirian'); ?>"
                            class="form-control <?= form_error('tanggal_akta_pendirian') ? 'is-invalid' : ''; ?>" required>
                        <div class="invalid-feedback"><?= form_error('tanggal_akta_pendirian'); ?></div>
                    </div>
                </div>

                <h6 class="mt-4">Akta Perubahan (Opsional)</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Notaris</label>
                        <input type="text" name="nama_notaris_perubahan"
                            value="<?= set_value('nama_notaris_perubahan'); ?>"
                            placeholder="Nama notaris akta perubahan (jika ada)"
                            autocomplete="off"
                            class="form-control <?= form_error('nama_notaris_perubahan') ? 'is-invalid' : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Akta</label>
                        <input type="text" name="nomor_akta_perubahan"
                            value="<?= set_value('nomor_akta_perubahan'); ?>"
                            placeholder="Nomor akta perubahan (jika ada)"
                            autocomplete="off"
                            class="form-control <?= form_error('nomor_akta_perubahan') ? 'is-invalid' : ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Akta</label>
                        <input type="date" name="tanggal_akta_perubahan"
                            value="<?= set_value('tanggal_akta_perubahan'); ?>"
                            class="form-control <?= form_error('tanggal_akta_perubahan') ? 'is-invalid' : ''; ?>">
                    </div>
                </div>

                <div class="form-check mt-4">
                    <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                        type="checkbox" name="agree" value="1" id="agree_yys" required>
                    <label class="form-check-label" for="agree_yys">Saya menyatakan data yang saya isi adalah benar.</label>
                    <div class="invalid-feedback d-block"><?= form_error('agree'); ?></div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Kirim Pengajuan</button>
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