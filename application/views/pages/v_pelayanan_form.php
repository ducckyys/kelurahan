<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1"><?= $title; ?></h1>
                        <p class="text-muted mb-0">Silakan isi data di bawah ini dengan benar.</p>
                    </div>
                    <a href="<?= base_url('pelayanan'); ?>" class="btn btn-outline-secondary">← Kembali</a>
                </div>

                <div class="card shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="<?= base_url('pelayanan/kirim_pengajuan'); ?>" method="POST">
                            <input type="hidden" name="jenis_surat" value="<?= $jenis_surat; ?>">

                            <h5 class="mb-3">Data Pemohon</h5>
                            <div class="mb-3">
                                <label for="nama_pemohon" class="form-label">Nama Lengkap Sesuai KTP</label>
                                <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" required>
                            </div>
                            <div class="mb-4">
                                <label for="nik_pemohon" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" class="form-control" id="nik_pemohon" name="nik_pemohon" required>
                            </div>

                            <hr>

                            <h5 class="mb-3">Data Pendukung</h5>
                            <?php foreach ($form_fields as $field) : ?>
                                <div class="mb-3">
                                    <label for="<?= $field['name']; ?>" class="form-label"><?= $field['label']; ?></label>
                                    <?php if ($field['type'] == 'textarea') : ?>
                                        <textarea class="form-control" id="<?= $field['name']; ?>" name="<?= $field['name']; ?>" rows="3" <?= $field['required'] ? 'required' : ''; ?>></textarea>
                                    <?php else : ?>
                                        <input type="<?= $field['type']; ?>" class="form-control" id="<?= $field['name']; ?>" name="<?= $field['name']; ?>" <?= $field['required'] ? 'required' : ''; ?>>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Kirim Pengajuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>