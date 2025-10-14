<section id="berita-detail" class="py-5">
    <div class="container">
        <a href="<?= site_url('berita'); ?>" class="back-icon mb-3 d-inline-flex" aria-label="Kembali">
            <!-- (ikon kembali sama seperti di atas) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
            </svg>
            <span class="ms-2 fw-semibold">Kembali ke Daftar Berita</span>
        </a>

        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card shadow-sm rounded-4 overflow-hidden">
                    <?php if (!empty($berita->gambar)): ?>
                        <img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" class="w-100" alt="<?= html_escape($berita->judul_berita); ?>" style="max-height:420px; object-fit:cover;">
                    <?php endif; ?>

                    <div class="card-body">
                        <?php
                        // Ambil tanggal & penulis dengan fallback yang aman
                        $tgl = $berita->tgl_publish ?? ($berita->created_at ?? ($berita->tanggal ?? date('Y-m-d')));
                        $penulis = trim($berita->penulis ?? '') !== '' ? $berita->penulis : 'Admin Kelurahan';
                        ?>
                        <span class="badge bg-primary-subtle text-primary mb-2"><?= html_escape($berita->kategori); ?></span>
                        <h1 class="h3"><?= html_escape($berita->judul_berita); ?></h1>

                        <div class="text-muted small mb-4">
                            Dipublikasikan oleh
                            <span class="fw-semibold text-primary"><?= html_escape($penulis); ?></span>
                            pada
                            <time datetime="<?= date('Y-m-d', strtotime($tgl)); ?>">
                                <?= date('d M Y', strtotime($tgl)); ?>
                            </time>
                        </div>


                        <div class="article-content">
                            <?= safe_rte($berita->isi_berita ?? '', 'detail'); ?>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="sticky-top" style="top: 90px;">

                    <?php if (!empty($related)): ?>
                        <div class="card shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="card-body">
                                <h5 class="section-title mb-3">Berita Terkait</h5>
                                <ul class="list-unstyled m-0">
                                    <?php foreach ($related as $r): ?>
                                        <li class="d-flex gap-3 align-items-start mb-3">
                                            <a href="<?= base_url('berita/detail/' . $r->slug_berita); ?>" class="d-inline-block flex-shrink-0">
                                                <img
                                                    src="<?= !empty($r->gambar) ? base_url('uploads/berita/' . $r->gambar) : base_url('assets/img/noimage.jpg'); ?>"
                                                    alt="<?= html_escape($r->judul_berita); ?>"
                                                    class="rounded"
                                                    style="width:96px;height:72px;object-fit:cover;border:2px solid var(--accent);">
                                            </a>
                                            <div class="flex-grow-1">
                                                <a href="<?= base_url('berita/detail/' . $r->slug_berita); ?>"
                                                    class="fw-semibold text-decoration-none d-block">
                                                    <?= character_limiter(html_escape($r->judul_berita), 70); ?>
                                                </a>

                                                <!-- META: penulis + tanggal -->
                                                <small class="text-muted d-block mt-1">
                                                    Dipublikasikan oleh
                                                    <span class="fw-semibold text-primary">
                                                        <?= html_escape($r->penulis ?? $r->nama_lengkap ?? 'Admin Kelurahan'); ?>
                                                    </span>
                                                    <?php if (!empty($r->tgl_publish)): ?>
                                                        • <time datetime="<?= date('Y-m-d', strtotime($r->tgl_publish)); ?>">
                                                            <?= date('d M Y', strtotime($r->tgl_publish)); ?>
                                                        </time>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Berita Lainnya</h5>
                            <ul class="list-unstyled m-0">
                                <?php if (!empty($latest)): ?>
                                    <?php foreach ($latest as $l): ?>
                                        <li class="d-flex gap-3 align-items-start mb-3">
                                            <a href="<?= base_url('berita/detail/' . $l->slug_berita); ?>" class="d-inline-block flex-shrink-0">
                                                <img
                                                    src="<?= !empty($l->gambar) ? base_url('uploads/berita/' . $l->gambar) : base_url('assets/img/noimage.jpg'); ?>"
                                                    alt="<?= html_escape($l->judul_berita); ?>"
                                                    class="rounded"
                                                    style="width:96px;height:72px;object-fit:cover;border:2px solid var(--accent);">
                                            </a>
                                            <div class="flex-grow-1">
                                                <a href="<?= base_url('berita/detail/' . $l->slug_berita); ?>"
                                                    class="fw-semibold text-decoration-none d-block">
                                                    <?= character_limiter(html_escape($l->judul_berita), 70); ?>
                                                </a>

                                                <!-- META: penulis + tanggal -->
                                                <small class="text-muted d-block mt-1">
                                                    Dipublikasikan oleh
                                                    <span class="fw-semibold text-primary">
                                                        <?= html_escape($l->penulis ?? $l->nama_lengkap ?? 'Admin Kelurahan'); ?>
                                                    </span>
                                                    <?php if (!empty($l->tgl_publish)): ?>
                                                        • <time datetime="<?= date('Y-m-d', strtotime($l->tgl_publish)); ?>">
                                                            <?= date('d M Y', strtotime($l->tgl_publish)); ?>
                                                        </time>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-muted">Belum ada berita lain.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>