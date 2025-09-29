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
                <form method="post" action="<?= base_url('pelayanan/submit_sktm'); ?>" enctype="multipart/form-data">
                    <h5 class="mb-4">Data Pengantar RT/RW</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat RT/RW</label>
                            <input type="text" name="nomor_surat_rt"
                                placeholder="Contoh: 123/RT01/RW02/KDM/2025"
                                value="<?= set_value('nomor_surat_rt'); ?>"
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

                            <!-- INPUT ASLI: tidak diubah -->
                            <input type="file" name="scan_surat_rt"
                                class="form-control <?= form_error('scan_surat_rt') || $this->session->flashdata('upload_error') ? 'is-invalid' : ''; ?>" required>

                            <div class="invalid-feedback"><?= form_error('scan_surat_rt'); ?></div>
                            <?php if ($this->session->flashdata('upload_error')): ?>
                                <div class="text-danger small mt-1"><?= $this->session->flashdata('upload_error'); ?></div>
                            <?php endif; ?>
                            <div class="form-text mt-1">
                                Pilih <b>Kamera</b> untuk memotret langsung, atau <b>File Manager</b> bila sudah punya file PDF/JPG/PNG (maks. 2 MB).
                            </div>

                            <!-- Preview ringan (opsional, tidak wajib) -->
                            <div id="srtPreview" class="mt-2" style="display:none;">
                                <img id="srtPreviewImg" alt="Pratinjau" class="img-fluid rounded" style="max-height:240px; display:none;" />
                                <div id="srtPreviewFile" class="small text-muted" style="display:none;"></div>
                                <button type="button" id="srtClear" class="btn btn-link btn-sm ps-0">Hapus pilihan</button>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-4">Data Diri Pemohon</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemohon</label>
                            <input type="text" name="nama_pemohon"
                                value="<?= set_value('nama_pemohon'); ?>"
                                placeholder="Nama lengkap sesuai KTP"
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

                        <div class="col-md-6">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="warganegara"
                                value="<?= set_value('warganegara', 'Indonesia'); ?>"
                                placeholder="Contoh: Indonesia"
                                class="form-control <?= form_error('warganegara') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('warganegara'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penghasilan Bulanan</label>
                            <select name="penghasilan_bulanan"
                                class="form-select <?= form_error('penghasilan_bulanan') ? 'is-invalid' : ''; ?>" required>
                                <option value="">-- Pilih Rentang Penghasilan --</option>
                                <option value="Kurang dari Rp 1.000.000" <?= set_select('penghasilan_bulanan', 'Kurang dari Rp 1.000.000'); ?>>Kurang dari Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 2.500.000" <?= set_select('penghasilan_bulanan', 'Rp 1.000.000 - Rp 2.500.000'); ?>>Rp 1.000.000 - Rp 2.500.000</option>
                                <option value="Rp 2.500.001 - Rp 4.000.000" <?= set_select('penghasilan_bulanan', 'Rp 2.500.001 - Rp 4.000.000'); ?>>Rp 2.500.001 - Rp 4.000.000</option>
                                <option value="Lebih dari Rp 4.000.000" <?= set_select('penghasilan_bulanan', 'Lebih dari Rp 4.000.000'); ?>>Lebih dari Rp 4.000.000</option>
                            </select>
                            <div class="invalid-feedback"><?= form_error('penghasilan_bulanan'); ?></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="3"
                                placeholder="Alamat lengkap sesuai KTP"
                                class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-4">Data Keterangan</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Orang Tua</label>
                            <input type="text" name="nama_orang_tua"
                                value="<?= set_value('nama_orang_tua'); ?>"
                                placeholder="Nama orang tua/wali"
                                class="form-control <?= form_error('nama_orang_tua') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_orang_tua'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ID DTKS (Opsional)</label>
                            <input type="text" name="id_dtks"
                                value="<?= set_value('id_dtks'); ?>"
                                placeholder="Boleh dikosongkan jika tidak ada"
                                class="form-control <?= form_error('id_dtks') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('id_dtks'); ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Keperluan Surat</label>
                            <input type="text" name="keperluan"
                                value="<?= set_value('keperluan'); ?>"
                                class="form-control <?= form_error('keperluan') ? 'is-invalid' : ''; ?>"
                                placeholder="Contoh: Pengajuan Beasiswa Pendidikan" required>
                            <div class="invalid-feedback"><?= form_error('keperluan'); ?></div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>"
                                    type="checkbox" name="agree" value="1" id="agree_sktm" required>
                                <label class="form-check-label" for="agree_sktm">
                                    Saya menyatakan data yang saya isi adalah benar.
                                </label>
                                <div class="invalid-feedback"><?= form_error('agree'); ?></div>
                            </div>
                        </div>
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