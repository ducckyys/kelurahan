<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="mb-4">
                    <a href="<?= base_url('berita'); ?>" class="btn btn-outline-secondary btn-sm">← Kembali ke Daftar Berita</a>
                </div>

                <h1 class="display-6 fw-bold mb-3"><?= html_escape($berita->judul_berita); ?></h1>

                <div class="text-muted small mb-4">
                    <span>Dipublikasikan pada: <?= date('d F Y', strtotime($berita->tgl_publish)); ?></span>
                    <span class="mx-2">|</span>
                    <span>Oleh: <?= html_escape($berita->penulis); ?></span>
                </div>

                <img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" class="img-fluid rounded-4 shadow-sm mb-4" alt="<?= html_escape($berita->judul_berita); ?>">

                <div class="article-content">
                    <?= nl2br($berita->isi_berita); // nl2br untuk menjaga format paragraf 
                    ?>
                </div>

            </div>
        </div>
    </div>
</section>