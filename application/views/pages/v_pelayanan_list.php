<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1"></h1>
                <p class="text-muted mb-0"></p>
            </div>
            <a href="<?= base_url(); ?>#pelayanan" class="back-icon" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                </svg>
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Pelayanan Kelurahan</h1>
                <p class="text-muted mb-0">Pilih jenis pelayanan untuk mulai pengajuan.</p>
            </div>
        </div>


        <div class="row g-4">
            <?php foreach ($cards as $c): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm service-card">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3 display-6"><i class="bi <?= $c['icon']; ?>"></i></div>
                            <h5 class="card-title"><?= $c['title']; ?></h5>
                            <p class="card-text text-muted small flex-grow-1"><?= $c['desc']; ?></p>
                            <a href="<?= base_url('pelayanan/' . $c['slug']); ?>" class="btn btn-primary mt-auto">Ajukan Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>