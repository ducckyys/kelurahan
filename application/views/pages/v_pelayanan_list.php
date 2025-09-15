<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Pelayanan Kelurahan</h1>
                <p class="text-muted mb-0">Pilih jenis pelayanan untuk mulai pengajuan.</p>
            </div>
            <a href="<?= base_url(); ?>#pelayanan" class="btn btn-outline-secondary">← Kembali</a>
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