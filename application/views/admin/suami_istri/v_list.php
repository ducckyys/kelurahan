<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Keterangan Suami Istri</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="<?= base_url('admin/dashboard') ?>"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data Surat Keterangan Suami Istri</a></li>
        </ul>
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
                                    <th>Suami/Istri</th>
                                    <th>Istri/Suami</th>
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
                                        <td><?= html_escape($item->nama_pihak_satu); ?></td>
                                        <td><?= html_escape($item->nama_pihak_dua); ?></td>
                                        <td><?= date('d M Y', strtotime($item->created_at)); ?></td>
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
                                                <!-- Lihat -->
                                                <a href="<?= base_url('admin/surat_suami_istri/detail/' . $item->id); ?>"
                                                    class="btn btn-link btn-info" title="Lihat">
                                                    <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z" />
                                                        <path d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" />
                                                    </svg>
                                                </a>

                                                <!-- Ubah -->
                                                <a href="<?= base_url('admin/surat_suami_istri/edit/' . $item->id); ?>"
                                                    class="btn btn-link btn-warning" title="Ubah">
                                                    <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706l-1 1-2.147-2.147 1-1a.5.5 0 0 1 .707 0l1.44 1.44z" />
                                                        <path d="M13.354 3.354 5.5 11.207V13.5h2.293l7.854-7.853-2.293-2.293z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11A1.5 1.5 0 0 0 15 13.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </a>

                                                <!-- Hapus -->
                                                <a href="<?= base_url('admin/surat_suami_istri/delete/' . $item->id); ?>"
                                                    class="btn btn-link btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <svg class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                                                        <path d="M11 1.5v1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5ZM14 3h-1v10.5A1.5 1.5 0 0 1 11.5 15h-7A1.5 1.5 0 0 1 3 13.5V3H2a1 1 0 1 1 0-2h12a1 1 0 1 1 0 2ZM5.5 5.5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3 0a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7Zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0V6Z" />
                                                    </svg>
                                                </a>
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