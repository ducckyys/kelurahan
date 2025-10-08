<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title; ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Berita</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Berita</h4>
                        <a class="btn btn-primary btn-round ml-auto" href="<?= base_url('admin/berita/create'); ?>">
                            <i class="fa fa-plus"></i> Tambah Berita
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul Berita</th>
                                    <th>Tanggal Publish</th>
                                    <th>Penulis</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($berita_list as $berita): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?php if (!empty($berita->gambar)): ?>
                                                <img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" width="100" alt="gambar">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= html_escape($berita->judul_berita); ?></td>
                                        <td><?= date('d M Y H:i', strtotime($berita->tgl_publish)); ?></td>
                                        <td><?= html_escape($berita->nama_lengkap); ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('admin/berita/edit/' . $berita->id_berita); ?>" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/berita/delete/' . $berita->id_berita); ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')"
                                                    title="Hapus" class="btn btn-link btn-danger">
                                                    <i class="fa fa-times"></i>
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