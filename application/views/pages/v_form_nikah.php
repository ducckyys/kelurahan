<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 mb-1">Surat Pengantar Pernikahan</h1>
                <p class="text-muted mb-0">Lengkapi data pemohon dan pasangan.</p>
            </div>
            <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Daftar Pelayanan</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?= base_url('pelayanan/submit-nikah'); ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= set_value('nama'); ?>" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nama'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" value="<?= set_value('nik'); ?>" class="form-control <?= form_error('nik') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nik'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('email'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat Domisili</label>
                            <input type="text" name="alamat" value="<?= set_value('alamat'); ?>" class="form-control <?= form_error('alamat') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('alamat'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pasangan</label>
                            <input type="text" name="nama_pasangan" value="<?= set_value('nama_pasangan'); ?>" class="form-control <?= form_error('nama_pasangan') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('nama_pasangan'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pernikahan</label>
                            <input type="date" name="tanggal_nikah" value="<?= set_value('tanggal_nikah'); ?>" class="form-control <?= form_error('tanggal_nikah') ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?= form_error('tanggal_nikah'); ?></div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input <?= form_error('agree') ? 'is-invalid' : ''; ?>" type="checkbox" name="agree" value="1" id="agree_nikah">
                                <label class="form-check-label" for="agree_nikah">Saya menyetujui kebijakan privasi.</label>
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