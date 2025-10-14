<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Kematian Non Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_kematian_nondukcapil') ?>">Data Kematian Non Dukcapil</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit Data</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Formulir Edit Data: <?= html_escape($surat->nama_almarhum); ?></h4>
                        <a href="<?= base_url('admin/surat_kematian_nondukcapil/detail/' . $surat->id); ?>" class="btn btn-secondary btn-round ml-auto">Batal</a>
                    </div>
                </div>

                <form action="<?= base_url('admin/surat_kematian_nondukcapil/update/' . $surat->id); ?>" method="POST" enctype="multipart/form-data">
                    <div class="card-body">

                        <h5>Administrasi Surat</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control"
                                        value="<?= html_escape($surat->nomor_surat); ?>"
                                        placeholder="Contoh: 400.12.3.1/123 - Pemerintahan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pengajuan</label>
                                    <select name="status" class="form-control">
                                        <option value="Pending" <?= ($surat->status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Disetujui" <?= ($surat->status == 'Disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                        <option value="Ditolak" <?= ($surat->status == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <h5 class="mb-3">Data Ahli Waris</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama</label>
                                    <input type="text" name="nama_ahli_waris" class="form-control"
                                        value="<?= html_escape($surat->nama_ahli_waris); ?>" placeholder="Nama ahli waris" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label>
                                    <input type="text" name="nik_ahli_waris" class="form-control"
                                        value="<?= html_escape($surat->nik_ahli_waris); ?>" placeholder="16 digit NIK" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="Laki-laki" <?= ($surat->jenis_kelamin == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($surat->jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>No. Telepon (WhatsApp)</label>
                                    <input type="text" name="telepon_pemohon" class="form-control"
                                        value="<?= html_escape($surat->telepon_pemohon ?? ''); ?>" placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Hubungan</label>
                                    <input type="text" name="hubungan_ahli_waris" class="form-control"
                                        value="<?= html_escape($surat->hubungan_ahli_waris); ?>" placeholder="Contoh: Anak Kandung" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat</label>
                                    <textarea name="alamat_ahli_waris" class="form-control" placeholder="Alamat lengkap ahli waris" required><?= html_escape($surat->alamat_ahli_waris); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Almarhum/ah</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama</label>
                                    <input type="text" name="nama_almarhum" class="form-control"
                                        value="<?= html_escape($surat->nama_almarhum); ?>" placeholder="Nama almarhum/ah" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label>
                                    <input type="text" name="nik_almarhum" class="form-control"
                                        value="<?= html_escape($surat->nik_almarhum); ?>" placeholder="16 digit NIK (jika ada)" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Keterangan (Hubungan)</label>
                                    <input type="text" name="keterangan_almarhum" class="form-control"
                                        value="<?= html_escape($surat->keterangan_almarhum); ?>" placeholder="Contoh: Ibu Kandung" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Meninggal</label>
                                    <input type="text" name="tempat_meninggal" class="form-control"
                                        value="<?= html_escape($surat->tempat_meninggal); ?>" placeholder="Contoh: Rumah / RSUD dr. Suyoto" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Meninggal</label>
                                    <input type="date" name="tanggal_meninggal" class="form-control"
                                        value="<?= html_escape($surat->tanggal_meninggal); ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat Almarhum/ah</label>
                                    <textarea name="alamat_almarhum" class="form-control" placeholder="Alamat lengkap almarhum/ah" required><?= html_escape($surat->alamat_almarhum); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Keperluan Surat</h5>
                        <div class="form-group">
                            <label>Keperluan</label>
                            <input type="text" name="keperluan" class="form-control"
                                value="<?= html_escape($surat->keperluan ?? ''); ?>" placeholder="Contoh: Administrasi Perbankan / Klaim Asuransi" required>
                        </div>

                        <hr>
                        <h5>Dokumen Pendukung & Data Pengantar RT/RW</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat RT/RW</label>
                                    <input type="text" class="form-control" name="nomor_surat_rt"
                                        value="<?= html_escape($surat->nomor_surat_rt); ?>" placeholder="Nomor surat pengantar RT/RW">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Surat RT/RW</label>
                                    <input type="date" class="form-control" name="tanggal_surat_rt"
                                        value="<?= html_escape($surat->tanggal_surat_rt); ?>" placeholder="Pilih tanggal surat RT/RW">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Unggah Dokumen Pendukung (PDF/JPG/PNG, maks 2MB per file)</label>
                                    <input type="file" class="form-control"
                                        name="dokumen_pendukung[]" accept=".pdf,.jpg,.jpeg,.png" multiple>
                                    <small class="form-text text-muted">Dokumen baru akan <b>ditambahkan</b> ke lampiran yang sudah ada.</small>

                                    <?php
                                    $files = [];
                                    if (!empty($surat->dokumen_pendukung)) {
                                        $decoded = json_decode($surat->dokumen_pendukung, true);
                                        if (is_array($decoded)) $files = $decoded;
                                        elseif (is_string($surat->dokumen_pendukung)) $files = [$surat->dokumen_pendukung];
                                    }
                                    ?>
                                    <div class="mt-2">
                                        <label class="mb-1 d-block">Lampiran Saat Ini:</label>
                                        <?php if (!empty($files)): ?>
                                            <ul class="list-unstyled">
                                                <?php foreach ($files as $fn): ?>
                                                    <li class="mb-1">
                                                        <i class="fa fa-paperclip"></i>
                                                        <a href="<?= base_url('uploads/pendukung/' . $fn) ?>" target="_blank" rel="noopener">
                                                            <?= html_escape($fn) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada dokumen terunggah.</span>
                                        <?php endif; ?>
                                    </div>

                                    <ul id="dokListAdmin" class="small mt-2 text-muted"></ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.querySelector('input[name="dokumen_pendukung[]"]');
        var list = document.getElementById('dokListAdmin');
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