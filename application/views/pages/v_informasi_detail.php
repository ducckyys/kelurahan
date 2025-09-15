<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="mb-4"><a href="<?= base_url('informasi'); ?>" class="btn btn-outline-secondary btn-sm">← Kembali ke Daftar Informasi</a></div>
                <div class="d-flex align-items-center mb-3">
                    <span class="badge me-2 bg-primary-subtle text-primary"><?= $info->kategori; ?></span>
                    <span class="text-muted small">Dipublikasikan pada: <?= date('d F Y', strtotime($info->tgl_publish)); ?></span>
                </div>
                <h1 class="display-6 fw-bold mb-4"><?= html_escape($info->judul_informasi); ?></h1>
                <div class="article-content"><?= nl2br($info->isi_informasi); ?></div>
            </div>
        </div>
    </div>
</section>