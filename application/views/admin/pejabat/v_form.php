<?php
$action = ($mode === 'edit')
    ? base_url('admin/pejabat/edit/' . ($row->id ?? 0))
    : base_url('admin/pejabat/tambah');
?>
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= html_escape($title); ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="<?= base_url('admin/pejabat') ?>">Pejabat</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a><?= ($mode === 'edit') ? 'Edit' : 'Tambah'; ?></a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><?= ($mode === 'edit') ? 'Edit Pejabat' : 'Tambah Pejabat'; ?></h4>
                </div>
                <div class="card-body">
                    <?= form_open($action, ['autocomplete' => 'off']); ?>

                    <div class="form-group">
                        <label for="jabatan_id">Jabatan <span class="text-danger">*</span></label>
                        <select id="jabatan_id" name="jabatan_id"
                            class="form-control <?= form_error('jabatan_id') ? 'is-invalid' : ''; ?>" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j): ?>
                                <option value="<?= (int)$j->id; ?>"
                                    <?= set_select('jabatan_id', $j->id, (isset($row->jabatan_id) && (int)$row->jabatan_id === (int)$j->id)); ?>>
                                    <?= html_escape($j->nama); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback"><?= strip_tags(form_error('jabatan_id')); ?></div>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>"
                            id="nama" name="nama" value="<?= set_value('nama', $row->nama ?? ''); ?>" required>
                        <div class="invalid-feedback"><?= strip_tags(form_error('nama')); ?></div>
                    </div>

                    <div class="form-group">
                        <label for="nip">NIP (18 digit) <span class="text-danger">*</span></label>
                        <input type="text" pattern="\d{18}" maxlength="18"
                            class="form-control <?= form_error('nip') ? 'is-invalid' : ''; ?>"
                            id="nip" name="nip"
                            value="<?= set_value('nip', $row->nip ?? ''); ?>" required
                            oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                        <div class="invalid-feedback"><?= strip_tags(form_error('nip')); ?></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        <a href="<?= base_url('admin/pejabat'); ?>" class="btn btn-secondary">Batal</a>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>