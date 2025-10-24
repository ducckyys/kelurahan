<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Pejabat</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Pejabat</a></li>
        </ul>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Pejabat</h4>
                    <a href="<?= base_url('admin/pejabat/tambah'); ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:60px;">No</th>
                                    <th style="width:220px;">Jabatan</th>
                                    <th>Nama</th>
                                    <th style="width:220px;">NIP</th>
                                    <th style="width:160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($list)): $no = 1;
                                    foreach ($list as $item): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><strong><?= html_escape($item->jabatan_nama ?? '-'); ?></strong></td>
                                            <td><?= html_escape($item->nama); ?></td>
                                            <td><code><?= html_escape($item->nip); ?></code></td>
                                            <td>
                                                <a href="<?= base_url('admin/pejabat/edit/' . $item->id); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?= form_open(base_url('admin/pejabat/delete/' . $item->id), ['style' => 'display:inline-block', 'onsubmit' => "return confirm('Hapus data ini?')"]); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i> Hapus
                                                </button>
                                                <?= form_close(); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>