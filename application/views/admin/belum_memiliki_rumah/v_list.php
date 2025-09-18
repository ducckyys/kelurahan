<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Belum Memiliki Rumah</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Surat Belum Memiliki Rumah</a></li>
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
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pemohon</th>
                                    <th>NIK</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Pengajuan</th>
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
                                        <td><?= html_escape($item->keperluan); ?></td>
                                        <td><?= date('d M Y', strtotime($item->created_at)); ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/surat_belum_memiliki_rumah/detail/' . $item->id); ?>" title="Lihat Detail" class="btn btn-link btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/surat_belum_memiliki_rumah/cetak/' . $item->id); ?>" target="_blank" title="Cetak Surat" class="btn btn-link btn-success">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="<?= base_url('admin/surat_belum_memiliki_rumah/edit/' . $item->id); ?>" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/surat_belum_memiliki_rumah/delete/' . $item->id); ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-link btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                if (empty($list)): ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>