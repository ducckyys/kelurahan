<section id="berita" class="berita-section list py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Berita Kelurahan</h1>
                <p class="text-muted mb-0">Kabar dan kegiatan terbaru seputar kelurahan Anda.</p>
            </div>
            <a href="<?= base_url(); ?>" class="back-icon" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
                <span class="ms-2 fw-semibold">Kembali ke Halaman Utama</span>
            </a>
        </div>

        <div class="row g-4">
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $it) : ?>
                    <div class="col-md-4">
                        <div class="card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                            <img src="<?= $it['image']; ?>" class="card-img-top news-img"
                                alt="<?= html_escape($it['title']); ?>" style="height:200px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                                    <?= html_escape($it['kategori']); ?>
                                </span>
                                <div class="text-muted small mb-1">
                                    Dipublikasikan oleh
                                    <span class="fw-semibold text-primary"><?= html_escape($it['author'] ?? 'Admin Kelurahan'); ?></span>
                                    <?php if (!empty($it['date'])): ?> •
                                        <time datetime="<?= date('Y-m-d', strtotime($it['date'])); ?>">
                                            <?= date('d M Y', strtotime($it['date'])); ?>
                                        </time>
                                    <?php endif; ?>
                                </div>

                                <h5 class="card-title mb-2"><?= html_escape($it['title']); ?></h5>

                                <div class="card-text small text-muted mb-3 flex-grow-1 article-content article-excerpt">
                                    <?= rte_first_paragraph($it['summary']); ?>
                                </div>

                                <a href="<?= $it['link']; ?>" class="btn btn-outline-primary btn-sm mt-auto">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center">
                    <p>Belum ada berita yang dipublikasikan saat ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <?= $pagination; ?>
            </div>
        </div>
    </div>
</section>