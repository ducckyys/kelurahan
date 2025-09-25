<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Ket. Suami Istri</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_suami_istri'); ?>">Data Ket. Suami Istri</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit Data</a></li>
        </ul>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('upload_error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('upload_error'); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Edit Pengajuan: <?= html_escape($surat->nama_pihak_satu); ?></h4>
                        <a href="<?= base_url('admin/surat_suami_istri/detail/' . $surat->id); ?>" class="btn btn-secondary btn-round ml-auto">Batal</a>
                    </div>
                </div>

                <form action="<?= base_url('admin/surat_suami_istri/update/' . $surat->id); ?>" method="post" enctype="multipart/form-data">
                    <div class="card-body">

                        <h5>Administrasi Surat</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_surat">Nomor Surat Kelurahan</label>
                                    <input type="text" class="form-control" name="nomor_surat" id="nomor_surat"
                                        value="<?= html_escape($surat->nomor_surat); ?>"
                                        placeholder="Contoh: 145/206-Pemt/IX/2025">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pengajuan</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Pending" <?= ($surat->status == 'Pending')   ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Disetujui" <?= ($surat->status == 'Disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                        <option value="Ditolak" <?= ($surat->status == 'Ditolak')   ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- DATA PIHAK PERTAMA -->
                            <div class="col-md-6">
                                <h5>Data Pihak Pertama</h5>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pihak_satu"
                                        value="<?= html_escape($surat->nama_pihak_satu); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" name="nik_pihak_satu"
                                        value="<?= html_escape($surat->nik_pihak_satu); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" class="form-control" name="telepon_pemohon"
                                        value="<?= html_escape($surat->telepon_pemohon); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="tempat_lahir_pihak_satu"
                                        value="<?= html_escape($surat->tempat_lahir_pihak_satu); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir_pihak_satu"
                                        value="<?= html_escape($surat->tanggal_lahir_pihak_satu); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin_pihak_satu">
                                        <option value="" <?= empty($surat->jenis_kelamin_pihak_satu) ? 'selected' : ''; ?> disabled>Pilih...</option>
                                        <option value="Laki-laki" <?= ($surat->jenis_kelamin_pihak_satu === 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($surat->jenis_kelamin_pihak_satu === 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" class="form-control" name="agama_pihak_satu"
                                        value="<?= html_escape($surat->agama_pihak_satu); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan_pihak_satu"
                                        value="<?= html_escape($surat->pekerjaan_pihak_satu); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Warganegara</label>
                                    <input type="text" class="form-control" name="warganegara_pihak_satu"
                                        value="<?= html_escape($surat->warganegara_pihak_satu); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat_pihak_satu" rows="3" required><?= html_escape($surat->alamat_pihak_satu); ?></textarea>
                                </div>
                            </div>

                            <!-- DATA PIHAK KEDUA -->
                            <div class="col-md-6">
                                <h5>Data Pihak Kedua</h5>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama_pihak_dua"
                                        value="<?= html_escape($surat->nama_pihak_dua); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" name="nik_pihak_dua"
                                        value="<?= html_escape($surat->nik_pihak_dua); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat_pihak_dua" rows="3" required><?= html_escape($surat->alamat_pihak_dua); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Keperluan</label>
                            <input type="text" class="form-control" name="keperluan"
                                value="<?= html_escape($surat->keperluan); ?>" required>
                        </div>

                        <hr>

                        <h5>Surat Pengantar RT/RW</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat RT/RW</label>
                                    <input type="text" class="form-control" name="nomor_surat_rt"
                                        value="<?= html_escape($surat->nomor_surat_rt); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Surat RT/RW</label>
                                    <input type="date" class="form-control" name="tanggal_surat_rt"
                                        value="<?= html_escape($surat->tanggal_surat_rt); ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Scan Surat Pengantar (PDF/JPG/PNG, maks 2MB)</label>
                                    <input type="file" class="form-control" name="scan_surat_rt" accept=".pdf,.jpg,.jpeg,.png">
                                    <?php if (!empty($surat->scan_surat_rt)): ?>
                                        <small class="form-text text-muted">
                                            File saat ini: <a target="_blank" href="<?= base_url('uploads/surat_rt/' . $surat->scan_surat_rt); ?>">
                                                <?= html_escape($surat->scan_surat_rt); ?>
                                            </a>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.card-body -->

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>