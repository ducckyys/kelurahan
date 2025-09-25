<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Kematian Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data Kematian Dukcapil</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Almarhum/ah</th>
                                    <th>NIK</th>
                                    <th>Tanggal Meninggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= html_escape($item->nama); ?></td>
                                        <td><?= html_escape($item->nik); ?></td>
                                        <td><?= !empty($item->tanggal_meninggal) ? date('d M Y', strtotime($item->tanggal_meninggal)) : '-'; ?></td>
                                        <td>
                                            <?php
                                            if ($item->status == 'Pending') $badge = 'badge-warning';
                                            elseif ($item->status == 'Disetujui') $badge = 'badge-success';
                                            else $badge = 'badge-danger';
                                            ?>
                                            <span class="badge <?= $badge; ?>"><?= $item->status; ?></span>
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/surat_kematian/detail/' . $item->id); ?>" class="btn btn-link btn-info" title="Detail"><i class="fa fa-eye"></i></a>
                                                <a href="<?= base_url('admin/surat_kematian/edit/' . $item->id); ?>" class="btn btn-link btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/surat_kematian/delete/' . $item->id); ?>" class="btn btn-link btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="fa fa-times"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>