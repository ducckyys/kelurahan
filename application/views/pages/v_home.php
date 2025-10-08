<?php if (!empty($rt_top) || !empty($rt_bottom)) : ?>
    <section id="marquee-info" class="bg-primary text-white py-2">
        <div class="container-fluid px-lg-5">
            <?php if (!empty($rt_top)) : ?>
                <marquee behavior="scroll"
                    direction="<?= html_escape($rt_top->direction); ?>"
                    scrollamount="<?= (int)$rt_top->speed; ?>">
                    <?= html_escape($rt_top->content); ?>
                </marquee>
                <div class="my-1"></div>
            <?php endif; ?>

            <?php if (!empty($rt_bottom)) : ?>
                <marquee behavior="scroll"
                    direction="<?= html_escape($rt_bottom->direction); ?>"
                    scrollamount="<?= (int)$rt_bottom->speed; ?>">
                    <?= html_escape($rt_bottom->content); ?>
                </marquee>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<section id="home" class="py-5 d-flex align-items-center mb-5 mt-5">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Layanan Publik Kelurahan yang Mudah & Transparan</h1>
                <p class="lead text-muted">Akses informasi, ajukan layanan, dan baca berita terbaru seputar kelurahan Anda dalam satu halaman.</p>
                <a href="<?= base_url('pelayanan'); ?>" class="btn btn-primary btn-lg me-2">Ajukan Layanan</a>
                <a href="<?= site_url('#Layanan'); ?>" class="btn btn-outline-primary btn-lg">Layanan kami</a>
            </div>
        </div>
    </div>
</section>

<section>
    <p>Layanan kami</p>
</section>

<section>
    <p>Jangkauan Pelayanan</p>
</section>

<section id="galeri" class="py-5">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Galeri Kademangan</h2>
                <p class="text-muted">Area Kademangan.</p>
            </div>
        </div>
        <?php if (!empty($galeri_list)) : ?>
            <div id="carouselGaleri" class="carousel slide shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($galeri_list as $key => $item) : ?>
                        <div class="carousel-item <?= ($key == 0) ? 'active' : ''; ?>">
                            <img src="<?= base_url('uploads/galeri/' . $item->foto); ?>" class="d-block w-100" alt="<?= html_escape($item->judul_foto); ?>" style="min-height: 400px; object-fit: cover;">
                            <div class="carousel-caption d-none d-md-block text-start">
                                <h5><?= html_escape($item->judul_foto); ?></h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleri" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleri" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php else : ?>
            <div class="col-12 text-center">
                <p>Belum ada foto di galeri.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="berita" class="py-5 bg-light">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="text-muted">Kegiatan kelurahan dan informasi aktual untuk warga.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php if (!empty($berita_list)) : ?>
                <?php foreach ($berita_list as $berita) : ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                            <img src="<?= base_url('uploads/berita/' . $berita->gambar); ?>" class="card-img-top" alt="<?= html_escape($berita->judul_berita); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <span class="badge bg-primary-subtle text-primary mb-2"><?= html_escape($berita->kategori); ?></span>
                                <h5 class="card-title"><?= html_escape($berita->judul_berita); ?></h5>
                                <p class="card-text small text-muted"><?= word_limiter(html_escape($berita->isi_berita), 15); ?></p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="<?= base_url('berita/detail/' . $berita->slug_berita); ?>" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center">
                    <p>Belum ada berita yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Cek jika link youtube ada isinya
if (!empty($youtube_link)) {
    // Proses untuk mengambil ID video dari URL lengkap
    parse_str(parse_url($youtube_link, PHP_URL_QUERY), $youtube_vars);
    $video_id = isset($youtube_vars['v']) ? $youtube_vars['v'] : null;

    if ($video_id) {
?>
        <section id="video" class="py-5">
            <div class="container-fluid px-lg-5">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <h2 class="section-title">Video</h2>
                        <p class="text-muted">Kenali lebih dekat Kelurahan Kademangan.</p>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="video-card shadow-sm rounded-4 overflow-hidden">
                            <div class="video-thumbnail position-relative">
                                <iframe
                                    src="https://www.youtube.com/embed/<?= $video_id; ?>?rel=0"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    class="video-frame w-100 h-100"></iframe>

                                <!-- Overlay bawah -->
                                <div class="video-info d-flex justify-content-between align-items-center px-4 py-3">
                                    <div>
                                        <h5 class="video-title mb-1"><?= html_escape($video_meta['title']); ?></h5>
                                        <p class="video-channel mb-0"><?= html_escape($video_meta['author_name']); ?></p>
                                    </div>
                                    <a
                                        href="https://www.youtube.com/watch?v=<?= $video_id; ?>"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-youtube me-1"></i> Tonton di YouTube
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}
?>

<section>
    <p>Tentang Web - tautan terkait - sosial media</p>
</section>