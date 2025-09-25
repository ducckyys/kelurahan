<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Kematian Non Dukcapil</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data Kematian Non Dukcapil</a></li>
        </ul>
    </div>
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
                            <th>Nama Ahli Waris</th>
                            <th>Nama Almarhum/ah</th>
                            <th>Tanggal Meninggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($list as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= html_escape($row->nama_ahli_waris); ?></td>
                                <td><?= html_escape($row->nama_almarhum); ?></td>
                                <td><?= date('d M Y', strtotime($row->tanggal_meninggal)); ?></td>
                                <td>
                                    <?php
                                    if ($row->status == 'Pending') $badge = 'badge-warning';
                                    elseif ($row->status == 'Disetujui') $badge = 'badge-success';
                                    else $badge = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge; ?>"><?= $row->status; ?></span>
                                </td>
                                <td>
                                    <div class="form-button-action">
                                        <a class="btn btn-link btn-info" href="<?= base_url('admin/surat_kematian_nondukcapil/detail/' . $row->id); ?>" title="Detail"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-link btn-primary" href="<?= base_url('admin/surat_kematian_nondukcapil/edit/' . $row->id); ?>" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-link btn-danger" onclick="return confirm('Hapus data ini?')" href="<?= base_url('admin/surat_kematian_nondukcapil/delete/' . $row->id); ?>" title="Hapus"><i class="fa fa-times"></i></a>
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