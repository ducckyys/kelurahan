<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Berita Kelurahan</h1>
                <p class="text-muted mb-0">Kabar dan kegiatan terbaru seputar kelurahan Anda.</p>
            </div>
            <a href="<?= base_url(); ?>" class="btn btn-outline-secondary">← Kembali ke Halaman Utama</a>
        </div>

        <div class="row g-4">
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $it) : ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                            <img src="<?= $it['image']; ?>" class="card-img-top" alt="<?= $it['title']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary align-self-start mb-2"><?= $it['kategori']; ?></span>
                                <span class="text-muted small mb-1"><?= date('d M Y', strtotime($it['date'])); ?></span>
                                <h5 class="card-title mb-2"><?= $it['title']; ?></h5>

                                <p class="card-text small text-muted mb-3 flex-grow-1"><?= $it['summary']; ?></p>
                                <a href="<?= $it['link']; ?>" class="btn btn-primary btn-sm mt-auto">Baca Selengkapnya</a>
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
        <div class="row g-4">
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $it) : ?>
                <?php endforeach; ?>
            <?php else : ?>
            <?php endif; ?>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <?= $pagination; ?>
            </div>
        </div>
    </div>
    </div>
</section>