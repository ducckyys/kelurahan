<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $can_full = isset($can_full_edit) && $can_full_edit === true; ?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Kematian Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_kematian') ?>">Data Kematian Dukcapil</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit Data</a></li>
        </ul>
    </div>

    <?php if (!$can_full): ?>
        <div class="alert alert-info">
            Anda login sebagai <b>admin</b>. Anda hanya dapat mengubah <b>Status</b> dan <b>Nomor Surat</b>.
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Formulir Edit Data an. <?= html_escape($surat->nama); ?></h4>
                        <a href="<?= base_url('admin/surat_kematian/detail/' . $surat->id); ?>" class="btn btn-secondary btn-round ml-auto">Batal</a>
                    </div>
                </div>

                <form action="<?= base_url('admin/surat_kematian/update/' . $surat->id); ?>" method="POST" enctype="multipart/form-data">
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

                        <h5>Dokumen Pendukung & Surat RT/RW (Opsional)</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nomor Surat RT/RW</label>
                                    <input type="text" class="form-control" name="nomor_surat_rt"
                                        value="<?= html_escape($surat->nomor_surat_rt); ?>" <?= $can_full ? '' : 'readonly' ?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Surat RT/RW</label>
                                    <input type="date" class="form-control" name="tanggal_surat_rt"
                                        value="<?= html_escape($surat->tanggal_surat_rt); ?>" <?= $can_full ? '' : 'readonly' ?>>
                                </div>
                            </div>

                            <?php
                            $files = [];
                            if (!empty($surat->dokumen_pendukung)) {
                                $dec = json_decode($surat->dokumen_pendukung, true);
                                $files = is_array($dec) ? $dec : [$surat->dokumen_pendukung];
                            }
                            ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tambah Dokumen Pendukung (PDF/JPG/PNG, maks 2MB per file)</label>
                                    <input type="file" class="form-control" name="dokumen_pendukung[]" accept=".pdf,.jpg,.jpeg,.png" multiple <?= $can_full ? '' : 'disabled' ?>>
                                    <small class="form-text text-muted">File baru akan <b>ditambahkan</b> ke lampiran yang sudah ada.</small>
                                </div>

                                <?php if (!empty($files)): ?>
                                    <div class="mt-2">
                                        <label class="d-block">Lampiran Saat Ini:</label>
                                        <ul class="mb-0">
                                            <?php foreach ($files as $fn): ?>
                                                <li><a href="<?= base_url('uploads/pendukung/' . $fn); ?>" target="_blank" rel="noopener"><?= html_escape($fn) ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                    <small class="text-muted">Belum ada lampiran.</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Almarhum/Almarhumah</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?= html_escape($surat->nama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label>
                                    <input type="text" name="nik" class="form-control" value="<?= html_escape($surat->nik); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="<?= html_escape($surat->tempat_lahir); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= html_escape($surat->tanggal_lahir); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" <?= $can_full ? '' : 'disabled' ?> required>
                                        <option value="Laki-laki" <?= $surat->jenis_kelamin == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= $surat->jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Agama</label>
                                    <input type="text" name="agama" class="form-control" value="<?= html_escape($surat->agama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="<?= html_escape($surat->pekerjaan); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" <?= $can_full ? '' : 'readonly' ?> required><?= html_escape($surat->alamat); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Kematian</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Hari</label>
                                    <input type="text" name="hari_meninggal" class="form-control" value="<?= html_escape($surat->hari_meninggal); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Tanggal</label>
                                    <input type="date" name="tanggal_meninggal" class="form-control" value="<?= html_escape($surat->tanggal_meninggal); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Jam</label>
                                    <input type="time" name="jam_meninggal" class="form-control" value="<?= html_escape($surat->jam_meninggal); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Meninggal</label>
                                    <input type="text" name="tempat_meninggal" class="form-control" value="<?= html_escape($surat->tempat_meninggal); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Sebab Meninggal</label>
                                    <input type="text" name="sebab_meninggal" class="form-control" value="<?= html_escape($surat->sebab_meninggal); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Tempat Pemakaman</label>
                                    <input type="text" name="tempat_pemakaman" class="form-control" value="<?= html_escape($surat->tempat_pemakaman); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-3">Data Pelapor</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama</label>
                                    <input type="text" name="pelapor_nama" class="form-control" value="<?= html_escape($surat->pelapor_nama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label>
                                    <input type="text" name="pelapor_nik" class="form-control" value="<?= html_escape($surat->pelapor_nik); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>No. Telepon</label>
                                    <input type="text" name="pelapor_no_telepon" class="form-control" value="<?= html_escape($surat->pelapor_no_telepon); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Hubungan</label>
                                    <input type="text" name="pelapor_hubungan" class="form-control" value="<?= html_escape($surat->pelapor_hubungan); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir Pelapor</label>
                                    <input type="text" name="pelapor_tempat_lahir" class="form-control" value="<?= html_escape($surat->pelapor_tempat_lahir); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir Pelapor</label>
                                    <input type="date" name="pelapor_tanggal_lahir" class="form-control" value="<?= html_escape($surat->pelapor_tanggal_lahir); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Agama Pelapor</label>
                                    <input type="text" name="pelapor_agama" class="form-control" value="<?= html_escape($surat->pelapor_agama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Pekerjaan Pelapor</label>
                                    <input type="text" name="pelapor_pekerjaan" class="form-control" value="<?= html_escape($surat->pelapor_pekerjaan); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group"><label>Alamat Pelapor</label>
                                    <textarea name="pelapor_alamat" class="form-control" rows="3" <?= $can_full ? '' : 'readonly' ?> required><?= html_escape($surat->pelapor_alamat); ?></textarea>
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