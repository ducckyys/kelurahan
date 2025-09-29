<section class="py-4 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1"></h1>
                <p class="text-muted mb-0"></p>
            </div>
            <a href="<?= base_url(); ?>" class="back-icon" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
            </a>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1">Informasi Kelurahan</h1>
                <p class="text-muted mb-0">Cari pengumuman, peraturan, dan dokumen unduhan.</p>
            </div>
        </div>


        <!-- Filter/Search -->
        <form method="get" class="row g-2 align-items-end mb-4">
            <div class="col-md-6">
                <label class="form-label small">Pencarian</label>
                <input type="text" name="q" value="<?= html_escape($this->input->get('q')); ?>" class="form-control" placeholder="Ketik kata kunci...">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Kategori</label>
                <select name="cat" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c; ?>" <?= set_select('cat', $c, $this->input->get('cat') === $c); ?>><?= $c; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button class="btn btn-primary">Terapkan</button>
            </div>
        </form>


        <!-- Daftar kartu informasi -->
        <div class="row g-4">
            <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-warning">Tidak ada data yang cocok.</div>
                </div>
            <?php endif; ?>


            <?php foreach ($items as $it): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm info-card">
                        <div class="card-body">
                            <span class="badge me-2 bg-primary-subtle text-primary"><?= $it['category']; ?></span>
                            <span class="text-muted small"><?= date('d M Y', strtotime($it['date'])); ?></span>
                            <h5 class="mt-2 mb-2"><?= $it['title']; ?></h5>
                            <p class="small text-muted mb-3"><?= $it['summary']; ?></p>
                            <a href="<?= $it['link']; ?>" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>