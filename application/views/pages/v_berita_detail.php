<section class="berita-section detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1"></h1>
                        <p class="text-muted mb-0"></p>
                    </div>
                    <a href="<?= base_url('berita'); ?>" class="back-icon" aria-label="Kembali">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 16 16" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                        </svg>
                        <span class="ms-2 fw-semibold">Kembali</span>
                    </a>
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