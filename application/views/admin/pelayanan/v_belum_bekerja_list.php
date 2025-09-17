<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Keterangan Belum Bekerja</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Layanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Ket. Belum Bekerja</a></li>
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
                                        <td><?= date('d M Y', strtotime($item->tgl_dibuat)); ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/surat_belum_bekerja/detail/' . $item->id); ?>" title="Lihat Detail" class="btn btn-link btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/surat_belum_bekerja/cetak/' . $item->id); ?>" target="_blank" title="Cetak Surat" class="btn btn-link btn-success">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="<?= base_url('admin/surat_belum_bekerja/edit/' . $item->id); ?>" title="Edit" class="btn btn-link btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/surat_belum_bekerja/delete/' . $item->id); ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-link btn-danger"><i class="fa fa-times"></i></a>
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

<script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});
    });
</script>