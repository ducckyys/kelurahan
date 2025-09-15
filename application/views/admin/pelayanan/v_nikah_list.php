<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Pengantar Nikah</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div><?php endif; ?>
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pemohon</th>
                                    <th>Nama Pasangan</th>
                                    <th>Tanggal Nikah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($list as $item): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= html_escape($item->nama_pemohon); ?></td>
                                        <td><?= html_escape($item->nama_pasangan); ?></td>
                                        <td><?= date('d M Y', strtotime($item->tanggal_nikah)); ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/surat_nikah/edit/' . $item->id); ?>" title="Edit" class="btn btn-link btn-primary btn-lg"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url('admin/surat_nikah/delete/' . $item->id); ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-link btn-danger"><i class="fa fa-times"></i></a>
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