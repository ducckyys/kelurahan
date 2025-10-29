<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Keterangan Penghasilan</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data Surat Keterangan Penghasilan</a></li>
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
                                    <th>Nama Pemohon</th>
                                    <th>NIK</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= html_escape($item->nama_pemohon); ?></td>
                                        <td><?= html_escape($item->nik); ?></td>
                                        <td><?= date('d M Y', strtotime($item->created_at)); ?></td>
                                        <td>
                                            <?php $badge = $item->status == 'Pending' ? 'badge-warning' : ($item->status == 'Disetujui' ? 'badge-success' : 'badge-danger'); ?>
                                            <span class="badge <?= $badge; ?>"><?= $item->status; ?></span>
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/surat_penghasilan/detail/' . $item->id); ?>" class="btn btn-link btn-info" title="Lihat"><i class="fa fa-eye"></i></a>
                                                <a href="<?= base_url('admin/surat_penghasilan/edit/' . $item->id); ?>" class="btn btn-link btn-warning" title="Ubah"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/surat_penghasilan/delete/' . $item->id); ?>" class="btn btn-link btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa fa-times"></i></a>
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