<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Pengaturan Website</h4>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Pengaturan</div>
                </div>
                <form action="<?= base_url('admin/uploadvideo/update'); ?>" method="POST">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="youtube_link">Link Video YouTube di Halaman Utama</label>
                            <input type="url" class="form-control" name="youtube_link" value="<?= html_escape($youtube_link); ?>" placeholder="https://www.youtube.com/watch?v=xxxx">
                            <small class="form-text text-muted">Salin dan tempel URL lengkap dari video YouTube yang ingin ditampilkan.</small>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>