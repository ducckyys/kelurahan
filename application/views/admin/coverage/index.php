<div class="page-inner">
    <!-- ====== HEADER & BREADCRUMBS (SAMA PERSIS FORMAT RUNNING TEXT) ====== -->
    <div class="page-header">
        <h4 class="page-title">Jangkauan Layanan</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= site_url('admin/dashboard'); ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Jangkauan Layanan</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            <!-- ====== FLASH MESSAGES ====== -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <!-- ====== CARD WRAPPER (SAMA DENGAN RUNNING TEXT) ====== -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Jangkauan Layanan</h4>
                        <!-- tombol submit di header, menargetkan form via atribut form -->
                        <button form="form-coverage" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </div>

                <!-- ====== FORM OPEN (multipart untuk upload ikon) ====== -->
                <?= form_open_multipart('admin/coverage/save', ['id' => 'form-coverage']); ?>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:220px">Item</th>
                                    <th style="width:180px">Jumlah</th>
                                    <th style="width:200px">Ikon Saat Ini</th>
                                    <th>Upload Ikon Baru</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ========================== KK ========================== -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info px-3 py-2">KK yang Dilayani</span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="jumlah_kk"
                                            value="<?= (int)$coverage->jumlah_kk; ?>" required>
                                    </td>
                                    <td>
                                        <?php if (!empty($coverage->icon_kk)): ?>
                                            <img src="<?= base_url('uploads/icons/' . $coverage->icon_kk) ?>"
                                                class="img-thumbnail" style="max-height:70px" alt="Ikon KK">
                                        <?php else: ?>
                                            <small class="text-muted">Belum ada ikon.</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="file" name="icon_kk" class="form-control"
                                            accept=".png,.jpg,.jpeg,.webp,.svg">
                                        <small class="text-muted">Rekomendasi 256×256, background transparan.</small>
                                    </td>
                                </tr>

                                <!-- ====================== PENDUDUK ======================= -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info px-3 py-2">Jumlah Penduduk</span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="jumlah_penduduk"
                                            value="<?= (int)$coverage->jumlah_penduduk; ?>" required>
                                    </td>
                                    <td>
                                        <?php if (!empty($coverage->icon_penduduk)): ?>
                                            <img src="<?= base_url('uploads/icons/' . $coverage->icon_penduduk) ?>"
                                                class="img-thumbnail" style="max-height:70px" alt="Ikon Penduduk">
                                        <?php else: ?>
                                            <small class="text-muted">Belum ada ikon.</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="file" name="icon_penduduk" class="form-control"
                                            accept=".png,.jpg,.jpeg,.webp,.svg">
                                        <small class="text-muted">Rekomendasi 256×256, background transparan.</small>
                                    </td>
                                </tr>

                                <!-- =========================== RW ======================== -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info px-3 py-2">Jumlah RW</span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="jumlah_rw"
                                            value="<?= (int)$coverage->jumlah_rw; ?>" required>
                                    </td>
                                    <td>
                                        <?php if (!empty($coverage->icon_rw)): ?>
                                            <img src="<?= base_url('uploads/icons/' . $coverage->icon_rw) ?>"
                                                class="img-thumbnail" style="max-height:70px" alt="Ikon RW">
                                        <?php else: ?>
                                            <small class="text-muted">Belum ada ikon.</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="file" name="icon_rw" class="form-control"
                                            accept=".png,.jpg,.jpeg,.webp,.svg">
                                        <small class="text-muted">Rekomendasi 256×256, background transparan.</small>
                                    </td>
                                </tr>

                                <!-- =========================== RT ======================== -->
                                <tr>
                                    <td>
                                        <span class="badge badge-info px-3 py-2">Jumlah RT</span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="jumlah_rt"
                                            value="<?= (int)$coverage->jumlah_rt; ?>" required>
                                    </td>
                                    <td>
                                        <?php if (!empty($coverage->icon_rt)): ?>
                                            <img src="<?= base_url('uploads/icons/' . $coverage->icon_rt) ?>"
                                                class="img-thumbnail" style="max-height:70px" alt="Ikon RT">
                                        <?php else: ?>
                                            <small class="text-muted">Belum ada ikon.</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="file" name="icon_rt" class="form-control"
                                            accept=".png,.jpg,.jpeg,.webp,.svg">
                                        <small class="text-muted">Rekomendasi 256×256, background transparan.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?= form_close(); ?>
                <!-- ====== /FORM ====== -->
            </div>
            <!-- /card -->
        </div>
    </div>
</div>

<script>
    // Optional: samakan behavior kecil dengan halaman Running Text
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>