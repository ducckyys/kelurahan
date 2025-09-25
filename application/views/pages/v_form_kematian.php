<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Keterangan Kematian (Dukcapil)</h1>
                <p class="text-muted mb-0">Lengkapi data berikut dengan benar.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">

                <form method="post" action="<?= base_url('pelayanan/submit_kematian'); ?>" enctype="multipart/form-data">

                    <h5 class="mb-3">Data Almarhum/Almarhumah</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="<?= set_value('nama'); ?>"
                                placeholder="Nama lengkap sesuai KTP"
                                class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" value="<?= set_value('nik'); ?>"
                                placeholder="16 digit NIK"
                                class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-laki"
                                    <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE); ?> required>
                                <label class="form-check-label" for="jk_l">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan"
                                    <?= set_radio('jenis_kelamin', 'Perempuan'); ?>>
                                <label class="form-check-label" for="jk_p">Perempuan</label>
                            </div>
                            <div class="invalid-feedback d-block"><?= form_error('jenis_kelamin'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= set_value('tempat_lahir'); ?>"
                                placeholder="Contoh: Tangerang Selatan"
                                class="form-control <?= form_error('tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= set_value('tanggal_lahir'); ?>"
                                class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" value="<?= set_value('agama'); ?>"
                                placeholder="Contoh: Islam / Kristen"
                                class="form-control <?= form_error('agama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('agama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="<?= set_value('pekerjaan'); ?>"
                                placeholder="Contoh: Karyawan Swasta"
                                class="form-control <?= form_error('pekerjaan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pekerjaan'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="3"
                                placeholder="Contoh: Jl. Mawar No. 5, RT 002/RW 001, Kademangan"
                                class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('alamat'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Data Kematian</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Hari</label>
                            <input type="text" name="hari_meninggal" value="<?= set_value('hari_meninggal'); ?>"
                                placeholder="Contoh: Senin"
                                class="form-control <?= form_error('hari_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('hari_meninggal'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal_meninggal" value="<?= set_value('tanggal_meninggal'); ?>"
                                class="form-control <?= form_error('tanggal_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tanggal_meninggal'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jam</label>
                            <input type="time" name="jam_meninggal" value="<?= set_value('jam_meninggal'); ?>"
                                class="form-control <?= form_error('jam_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('jam_meninggal'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Meninggal</label>
                            <input type="text" name="tempat_meninggal" value="<?= set_value('tempat_meninggal'); ?>"
                                placeholder="Contoh: Rumah / RSUD Tangerang Selatan"
                                class="form-control <?= form_error('tempat_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_meninggal'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sebab Meninggal</label>
                            <input type="text" name="sebab_meninggal" value="<?= set_value('sebab_meninggal'); ?>"
                                placeholder="Contoh: Sakit / Kecelakaan"
                                class="form-control <?= form_error('sebab_meninggal') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('sebab_meninggal'); ?></div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Tempat Pemakaman</label>
                            <input type="text" name="tempat_pemakaman" value="<?= set_value('tempat_pemakaman'); ?>"
                                placeholder="Contoh: TPU Kademangan"
                                class="form-control <?= form_error('tempat_pemakaman') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('tempat_pemakaman'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Data Pelapor</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelapor</label>
                            <input type="text" name="pelapor_nama" value="<?= set_value('pelapor_nama'); ?>"
                                placeholder="Nama pelapor"
                                class="form-control <?= form_error('pelapor_nama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_nama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK Pelapor</label>
                            <input type="text" name="pelapor_nik" value="<?= set_value('pelapor_nik'); ?>"
                                placeholder="16 digit NIK"
                                class="form-control <?= form_error('pelapor_nik') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_nik'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon Pelapor</label>
                            <input type="text" name="pelapor_no_telepon" value="<?= set_value('pelapor_no_telepon'); ?>"
                                placeholder="Contoh: 0812xxxxxxx"
                                class="form-control <?= form_error('pelapor_no_telepon') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_no_telepon'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hubungan dengan Almarhum/ah</label>
                            <input type="text" name="pelapor_hubungan" value="<?= set_value('pelapor_hubungan'); ?>"
                                placeholder="Contoh: Istri / Suami / Anak / Saudara"
                                class="form-control <?= form_error('pelapor_hubungan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_hubungan'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir Pelapor</label>
                            <input type="text" name="pelapor_tempat_lahir" value="<?= set_value('pelapor_tempat_lahir'); ?>"
                                placeholder="Contoh: Tangerang Selatan"
                                class="form-control <?= form_error('pelapor_tempat_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_tempat_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir Pelapor</label>
                            <input type="date" name="pelapor_tanggal_lahir" value="<?= set_value('pelapor_tanggal_lahir'); ?>"
                                class="form-control <?= form_error('pelapor_tanggal_lahir') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_tanggal_lahir'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama Pelapor</label>
                            <input type="text" name="pelapor_agama" value="<?= set_value('pelapor_agama'); ?>"
                                placeholder="Contoh: Islam / Kristen"
                                class="form-control <?= form_error('pelapor_agama') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_agama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan Pelapor</label>
                            <input type="text" name="pelapor_pekerjaan" value="<?= set_value('pelapor_pekerjaan'); ?>"
                                placeholder="Contoh: Wiraswasta"
                                class="form-control <?= form_error('pelapor_pekerjaan') ? 'is-invalid' : ''; ?>" required>
                            <div class="invalid-feedback"><?= form_error('pelapor_pekerjaan'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Pelapor</label>
                            <textarea name="pelapor_alamat" rows="3"
                                placeholder="Contoh: Jl. Anggrek No. 8, RT 004/RW 003, Kademangan"
                                class="form-control <?= form_error('pelapor_alamat') ? 'is-invalid' : ''; ?>" required><?= set_value('pelapor_alamat'); ?></textarea>
                            <div class="invalid-feedback"><?= form_error('pelapor_alamat'); ?></div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-4">Data Pengantar RT/RW (Opsional)</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat RT/RW</label>
                            <input type="text" name="nomor_surat_rt" value="<?= set_value('nomor_surat_rt'); ?>"
                                placeholder="Nomor surat pengantar RT/RW"
                                class="form-control <?= form_error('nomor_surat_rt') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nomor_surat_rt'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Surat RT/RW</label>
                            <input type="date" name="tanggal_surat_rt" value="<?= set_value('tanggal_surat_rt'); ?>"
                                class="form-control <?= form_error('tanggal_surat_rt') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('tanggal_surat_rt'); ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Upload Scan/Foto Surat RT/RW</label>
                            <input type="file" name="scan_surat_rt"
                                class="form-control <?= form_error('scan_surat_rt') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('scan_surat_rt'); ?></div>
                            <?php if ($this->session->flashdata('upload_error')): ?>
                                <div class="text-danger small mt-1"><?= $this->session->flashdata('upload_error'); ?></div>
                            <?php endif; ?>
                            <div class="form-text mt-1">Format: PDF/JPG/PNG (maks. 2 MB)</div>
                        </div>
                    </div>

                    <div class="form-check mt-4">
                        <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_sk" required>
                        <label class="form-check-label" for="agree_sk">Saya menyatakan data yang saya isi adalah benar.</label>
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