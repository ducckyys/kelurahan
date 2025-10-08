<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Running Text</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= site_url('admin/dashboard'); ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Running Text</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Running Text</h4>
                        <button form="form-runningtext" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </div>

                <?= form_open(site_url('admin/runningtext'), ['id' => 'form-runningtext']); ?>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:120px">Posisi</th>
                                    <th style="width:140px">Arah</th>
                                    <th style="width:130px">Speed</th>
                                    <th>Teks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-info px-3 py-2" style="text-transform:lowercase">top</span></td>
                                    <td>
                                        <select class="form-control" name="top_direction" required>
                                            <option value="left" <?= ($top->direction ?? '') === 'left' ? 'selected' : '' ?>>left</option>
                                            <option value="right" <?= ($top->direction ?? '') === 'right' ? 'selected' : '' ?>>right</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" max="10" class="form-control" name="top_speed" value="<?= (int)($top->speed ?? 6) ?>" required>
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="top_content" rows="2" maxlength="255" required><?= html_escape($top->content ?? '') ?></textarea>
                                        <small class="text-muted d-block mt-1">
                                            Preview:
                                            <marquee behavior="scroll" direction="<?= html_escape($top->direction ?? 'left'); ?>" scrollamount="<?= (int)($top->speed ?? 6); ?>">
                                                <?= html_escape($top->content ?? '') ?>
                                            </marquee>
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <td><span class="badge badge-info px-3 py-2" style="text-transform:lowercase">bottom</span></td>
                                    <td>
                                        <select class="form-control" name="bottom_direction" required>
                                            <option value="left" <?= ($bottom->direction ?? '') === 'left' ? 'selected' : '' ?>>left</option>
                                            <option value="right" <?= ($bottom->direction ?? '') === 'right' ? 'selected' : '' ?>>right</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" max="10" class="form-control" name="bottom_speed" value="<?= (int)($bottom->speed ?? 5) ?>" required>
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="bottom_content" rows="2" maxlength="255" required><?= html_escape($bottom->content ?? '') ?></textarea>
                                        <small class="text-muted d-block mt-1">
                                            Preview:
                                            <marquee behavior="scroll" direction="<?= html_escape($bottom->direction ?? 'right'); ?>" scrollamount="<?= (int)($bottom->speed ?? 5); ?>">
                                                <?= html_escape($bottom->content ?? '') ?>
                                            </marquee>
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Inisialisasi tooltip jika ada
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>