<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $can_full = isset($can_full_edit) && $can_full_edit === true; ?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit Surat Pengantar Nikah</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/surat_pengantar_nikah'); ?>">Data Pengantar Nikah</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit</a></li>
        </ul>
    </div>

    <?php if (!$can_full): ?>
        <div class="alert alert-info">
            Anda login sebagai <b>admin</b>. Hanya bisa mengubah <b>Status</b> dan <b>Nomor Surat Kelurahan</b>.
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4 class="card-title">Edit: <?= html_escape($surat->pria_nama); ?> &amp; <?= html_escape($surat->wanita_nama); ?></h4>
            <a href="<?= base_url('admin/surat_pengantar_nikah/detail/' . $surat->id); ?>" class="btn btn-secondary btn-round ml-auto">Batal</a>
        </div>

        <form action="<?= base_url('admin/surat_pengantar_nikah/update/' . $surat->id); ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">

                <h5>Administrasi Surat</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Surat Kelurahan</label>
                            <input type="text" class="form-control" name="nomor_surat"
                                value="<?= html_escape($surat->nomor_surat); ?>"
                                placeholder="Contoh: 145/206-Pemt/IX/2025">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Pengajuan</label>
                            <select name="status" class="form-control" required <?= $can_full ? '' : '' ?>>
                                <option value="Pending" <?= $surat->status == 'Pending'   ? 'selected' : ''; ?>>Pending</option>
                                <option value="Disetujui" <?= $surat->status == 'Disetujui' ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="Ditolak" <?= $surat->status == 'Ditolak'   ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>

                <h5>Pengantar RT/RW</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Surat RT/RW</label>
                            <input type="text" name="nomor_surat_rt" class="form-control"
                                value="<?= html_escape($surat->nomor_surat_rt); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Surat RT/RW</label>
                            <input type="date" name="tanggal_surat_rt" class="form-control"
                                value="<?= html_escape($surat->tanggal_surat_rt); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <!-- PRIA -->
                    <div class="col-md-6">
                        <h5>Data Pria (Pemohon)</h5>
                        <div class="form-group"><label>Nama</label>
                            <input type="text" name="pria_nama" class="form-control"
                                value="<?= html_escape($surat->pria_nama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                        </div>
                        <div class="form-group"><label>NIK</label>
                            <input type="text" name="pria_nik" class="form-control"
                                value="<?= html_escape($surat->pria_nik); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                        </div>
                        <div class="form-group"><label>Tempat Lahir</label>
                            <input type="text" name="pria_tempat_lahir" class="form-control"
                                value="<?= html_escape($surat->pria_tempat_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Tanggal Lahir</label>
                            <input type="date" name="pria_tanggal_lahir" class="form-control"
                                value="<?= html_escape($surat->pria_tanggal_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Kewarganegaraan</label>
                            <input type="text" name="pria_kewarganegaraan" class="form-control"
                                value="<?= html_escape($surat->pria_kewarganegaraan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Agama</label>
                            <input type="text" name="pria_agama" class="form-control"
                                value="<?= html_escape($surat->pria_agama); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Pekerjaan</label>
                            <input type="text" name="pria_pekerjaan" class="form-control"
                                value="<?= html_escape($surat->pria_pekerjaan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Alamat</label>
                            <textarea name="pria_alamat" class="form-control" rows="3" <?= $can_full ? '' : 'readonly' ?>><?= html_escape($surat->pria_alamat); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status Pernikahan Pria</label><br>
                            <?php $disabled = $can_full ? '' : 'disabled'; ?>
                            <label class="mr-3"><input type="radio" name="pria_status" value="Jejaka" <?= $surat->pria_status == 'Jejaka' ? 'checked' : ''; ?> <?= $disabled; ?>> Jejaka</label>
                            <label class="mr-3"><input type="radio" name="pria_status" value="Duda" <?= $surat->pria_status == 'Duda' ? 'checked' : ''; ?> <?= $disabled; ?>> Duda</label>
                            <label class="mr-3"><input type="radio" name="pria_status" value="Beristri" <?= $surat->pria_status == 'Beristri' ? 'checked' : ''; ?> <?= $disabled; ?>> Beristri</label>
                        </div>

                        <div class="form-group" id="fieldIstriKe" style="display:<?= $surat->pria_status == 'Beristri' ? 'block' : 'none'; ?>;">
                            <label>Istri ke-</label>
                            <input type="number" name="pria_istri_ke" class="form-control" min="1"
                                value="<?= html_escape($surat->pria_istri_ke); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                    </div>

                    <!-- ORANG TUA (GABUNG) -->
                    <div class="col-md-6">
                        <h5>Data Orang Tua</h5>
                        <div class="form-group"><label>Nama Orang Tua</label>
                            <input type="text" name="ortu_nama" class="form-control"
                                value="<?= html_escape($surat->ortu_nama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                        </div>
                        <div class="form-group"><label>NIK Orang Tua</label>
                            <input type="text" name="ortu_nik" class="form-control"
                                value="<?= html_escape($surat->ortu_nik); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Tempat Lahir</label>
                            <input type="text" name="ortu_tempat_lahir" class="form-control"
                                value="<?= html_escape($surat->ortu_tempat_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Tanggal Lahir</label>
                            <input type="date" name="ortu_tanggal_lahir" class="form-control"
                                value="<?= html_escape($surat->ortu_tanggal_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Kewarganegaraan</label>
                            <input type="text" name="ortu_kewarganegaraan" class="form-control"
                                value="<?= html_escape($surat->ortu_kewarganegaraan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Agama</label>
                            <input type="text" name="ortu_agama" class="form-control"
                                value="<?= html_escape($surat->ortu_agama); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Pekerjaan</label>
                            <input type="text" name="ortu_pekerjaan" class="form-control"
                                value="<?= html_escape($surat->ortu_pekerjaan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Alamat</label>
                            <textarea name="ortu_alamat" class="form-control" rows="3" <?= $can_full ? '' : 'readonly' ?>><?= html_escape($surat->ortu_alamat); ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- WANITA -->
                <h5>Data Calon Istri (Wanita)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>Nama</label>
                            <input type="text" name="wanita_nama" class="form-control"
                                value="<?= html_escape($surat->wanita_nama); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                        </div>
                        <div class="form-group"><label>NIK</label>
                            <input type="text" name="wanita_nik" class="form-control"
                                value="<?= html_escape($surat->wanita_nik); ?>" <?= $can_full ? '' : 'readonly' ?> required>
                        </div>
                        <div class="form-group"><label>Tempat Lahir</label>
                            <input type="text" name="wanita_tempat_lahir" class="form-control"
                                value="<?= html_escape($surat->wanita_tempat_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Tanggal Lahir</label>
                            <input type="date" name="wanita_tanggal_lahir" class="form-control"
                                value="<?= html_escape($surat->wanita_tanggal_lahir); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Kewarganegaraan</label>
                            <input type="text" name="wanita_kewarganegaraan" class="form-control"
                                value="<?= html_escape($surat->wanita_kewarganegaraan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Agama</label>
                            <input type="text" name="wanita_agama" class="form-control"
                                value="<?= html_escape($surat->wanita_agama); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                        <div class="form-group"><label>Pekerjaan</label>
                            <input type="text" name="wanita_pekerjaan" class="form-control"
                                value="<?= html_escape($surat->wanita_pekerjaan); ?>" <?= $can_full ? '' : 'readonly' ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Alamat</label>
                            <textarea name="wanita_alamat" class="form-control" rows="3" <?= $can_full ? '' : 'readonly' ?>><?= html_escape($surat->wanita_alamat); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status (Wanita)</label><br>
                            <?php $disabledW = $can_full ? '' : 'disabled'; ?>
                            <label class="mr-3"><input type="radio" name="wanita_status" value="Perawan" <?= $surat->wanita_status == 'Perawan' ? 'checked' : ''; ?> <?= $disabledW; ?>> Perawan</label>
                            <label class="mr-3"><input type="radio" name="wanita_status" value="Janda" <?= $surat->wanita_status == 'Janda' ? 'checked' : ''; ?> <?= $disabledW; ?>> Janda</label>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Lampiran</h5>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Unggah Dokumen Pendukung (PDF/JPG/PNG, maks 2MB per file)</label>
                            <input type="file" name="dokumen_pendukung[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" multiple <?= $can_full ? '' : 'disabled' ?>>
                            <small class="form-text text-muted">Dokumen baru akan <b>ditambahkan</b> ke lampiran yang sudah ada.</small>

                            <?php
                            $files = [];
                            if (!empty($surat->dokumen_pendukung)) {
                                $dec = json_decode($surat->dokumen_pendukung, true);
                                if (is_array($dec)) $files = $dec;
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
                                                <a href="<?= base_url('uploads/nikah/' . $fn) ?>" target="_blank" rel="noopener"><?= html_escape($fn) ?></a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // preview file list
        var input = document.querySelector('input[name="dokumen_pendukung[]"]');
        var list = document.getElementById('dokListAdmin');
        if (input && list) {
            input.addEventListener('change', function() {
                list.innerHTML = '';
                Array.from(this.files || []).forEach(function(f) {
                    var li = document.createElement('li');
                    li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                    list.appendChild(li);
                });
            });
        }
        // toggle istri_ke
        function toggleIstriKe() {
            var checked = document.querySelector('input[name="pria_status"]:checked');
            var wrap = document.getElementById('fieldIstriKe');
            var show = checked && checked.value === 'Beristri';
            if (wrap) wrap.style.display = show ? 'block' : 'none';
        }
        document.querySelectorAll('input[name="pria_status"]').forEach(function(r) {
            r.addEventListener('change', toggleIstriKe);
        });
        toggleIstriKe();
    });
</script>