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

<?php if (!empty($rt_top) || !empty($rt_bottom)) : ?>
    <section id="marquee-info" class="py-2">
        <div class="container-fluid px-lg-5">

            <?php if (!empty($rt_top)) : ?>
                <marquee
                    behavior="scroll"
                    direction="<?= html_escape($rt_top->direction); ?>"
                    scrollamount="<?= (int)$rt_top->speed; ?>"
                    style="display:block;background:var(--primary);color:#fff;padding:.45rem .75rem;border-radius:8px;">
                    <?= html_escape($rt_top->content); ?>
                </marquee>
                <div style="height:.5rem"></div>
            <?php endif; ?>

            <?php if (!empty($rt_bottom)) : ?>
                <marquee
                    behavior="scroll"
                    direction="<?= html_escape($rt_bottom->direction); ?>"
                    scrollamount="<?= (int)$rt_bottom->speed; ?>"
                    style="display:block;background:var(--accent);color:#fff;padding:.45rem .75rem;border-radius:8px;">
                    <?= html_escape($rt_bottom->content); ?>
                </marquee>
            <?php endif; ?>

        </div>
    </section>
<?php endif; ?>


<section id="Layanan" class="py-5 section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title mb-1">Layanan Kami</h2>
                <p class="text-muted">Solusi layanan publik yang mudah, cepat, dan transparan.</p>
            </div>
        </div>

        <?php if (!empty($layanan_list)): ?>
            <div class="position-relative">

                <!-- Tombol navigasi -->
                <button id="layananPrev" class="nav-arrow btn btn-outline-primary btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-lg-inline-flex" type="button" aria-label="Sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button id="layananNext" class="nav-arrow btn btn-outline-primary btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-lg-inline-flex" type="button" aria-label="Berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>

                <!-- Track slider -->
                <div id="layananSlider"
                    class="d-flex flex-nowrap gap-4 overflow-auto pb-2"
                    style="scroll-snap-type:x mandatory; scroll-behavior:smooth;">
                    <?php foreach ($layanan_list as $l): ?>
                        <!-- Gunakan kelas grid untuk lebar responsif per item -->
                        <div class="slider-item col-10 col-sm-6 col-lg-3 p-0 flex-shrink-0" style="scroll-snap-align:start;">
                            <div class="card service-card h-100 overflow-hidden">
                                <?php if (!empty($l->gambar)): ?>
                                    <img src="<?= base_url('uploads/layanan/' . $l->gambar); ?>"
                                        alt="<?= html_escape($l->judul); ?>"
                                        class="card-img-top">
                                <?php else: ?>
                                    <div class="card-img-top bg-light"></div>
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title mb-1"><?= html_escape($l->judul); ?></h5>
                                    <span class="title-underline"></span>
                                    <p class="card-text small text-muted mb-0">
                                        <?= nl2br(html_escape($l->deskripsi)); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Tombol navigasi untuk mobile (opsional) -->
                <div class="d-grid gap-2 d-lg-none mt-3">
                    <div class="d-flex justify-content-center gap-2">
                        <button id="layananPrevSm" class="btn btn-outline-primary btn-sm" type="button" aria-label="Sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button id="layananNextSm" class="btn btn-outline-primary btn-sm" type="button" aria-label="Berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        <?php else: ?>
            <div class="text-center text-muted">Belum ada layanan yang ditambahkan.</div>
        <?php endif; ?>
    </div>
</section>

<section id="coverage" class="py-5 section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title mb-1">Skala Kami</h2>
                <p class="text-muted">Berpengalaman melayani lingkungan pemerintahan & warga secara transparan.</p>
            </div>
        </div>

        <?php
        // formatter angka TANPA pembulatan (7884, 25.724, dst)
        if (!function_exists('format_int')) {
            function format_int($n)
            {
                return number_format((int)$n, 0, ',', '.'); // 25724 -> 25.724
            }
        }

        $iconBase = base_url('uploads/icons/');

        $cards = [
            [
                'title' => 'KK yang Dilayani',
                'desc'  => 'Semua keluarga bisa mengakses layanan kami.',
                'value' => format_int((int)$coverage->jumlah_kk),
                'icon'  => !empty($coverage->icon_kk) ? $iconBase . $coverage->icon_kk : base_url('assets/img/icons/kk.png'),
            ],
            [
                'title' => 'Jumlah Penduduk',
                'desc'  => 'Identitas dan layanan publik yang inklusif.',
                'value' => format_int((int)$coverage->jumlah_penduduk),
                'icon'  => !empty($coverage->icon_penduduk) ? $iconBase . $coverage->icon_penduduk : base_url('assets/img/icons/penduduk.png'),
            ],
            [
                'title' => 'Jumlah RW',
                'desc'  => 'Kolaborasi tingkat wilayah untuk pelayanan.',
                'value' => format_int((int)$coverage->jumlah_rw),
                'icon'  => !empty($coverage->icon_rw) ? $iconBase . $coverage->icon_rw : base_url('assets/img/icons/rw.png'),
            ],
            [
                'title' => 'Jumlah RT',
                'desc'  => 'Layanan dekat warga di tingkat rukun tetangga.',
                'value' => format_int((int)$coverage->jumlah_rt),
                'icon'  => !empty($coverage->icon_rt) ? $iconBase . $coverage->icon_rt : base_url('assets/img/icons/rt.png'),
            ],
        ];
        ?>

        <div class="row g-4">
            <?php foreach ($cards as $c): ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card metric-card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                        <div class="card-body text-center d-flex flex-column">
                            <img src="<?= $c['icon']; ?>" alt="" class="metric-illustration mx-auto mb-2">
                            <h5 class="metric-title mb-1"><?= html_escape($c['title']); ?></h5>
                            <p class="metric-desc text-muted mb-4"><?= html_escape($c['desc']); ?></p>
                            <div class="metric-value mt-auto"><?= $c['value']; ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
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

<section id="berita" class="py-5 bg-light section-abstract">
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
                        <div class="card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                            <img
                                src="<?= base_url('uploads/berita/' . $berita->gambar); ?>"
                                class="card-img-top news-img"
                                alt="<?= html_escape($berita->judul_berita); ?>"
                                style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                                    <?= html_escape($berita->kategori); ?>
                                </span>

                                <!-- META: Penulis + Tanggal -->
                                <div class="text-muted small mb-1">
                                    Dipublikasikan oleh
                                    <span class="fw-semibold text-primary">
                                        <?= html_escape($berita->nama_lengkap ?? 'Admin Kelurahan'); ?>
                                    </span>
                                    <?php if (!empty($berita->tgl_publish)): ?>
                                        • <time datetime="<?= date('Y-m-d', strtotime($berita->tgl_publish)); ?>">
                                            <?= date('d M Y', strtotime($berita->tgl_publish)); ?>
                                        </time>
                                    <?php endif; ?>
                                </div>

                                <h5 class="card-title mb-2"><?= html_escape($berita->judul_berita); ?></h5>

                                <p class="card-text small text-muted mb-3 flex-grow-1 home-news-excerpt">
                                    <?php
                                    $raw   = (string) $berita->isi_berita;
                                    $plain = html_entity_decode($raw, ENT_QUOTES, 'UTF-8');
                                    $plain = strip_tags($plain);
                                    $plain = preg_replace('/\s+/', ' ', $plain);
                                    echo character_limiter(trim($plain), 160);
                                    ?>
                                </p>

                                <a href="<?= base_url('berita/detail/' . $berita->slug_berita); ?>" class="btn btn-outline-primary btn-sm mt-auto">
                                    Baca Selengkapnya
                                </a>
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


<?php if (!empty($youtube_link)): ?>
    <?php
    parse_str(parse_url($youtube_link, PHP_URL_QUERY), $youtube_vars);
    $video_id = isset($youtube_vars['v']) ? $youtube_vars['v'] : null;
    ?>
    <?php if ($video_id): ?>
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
                        <div class="video-card brand-card shadow-sm rounded-4 overflow-hidden">
                            <!-- strip kuning -->
                            <span class="brand-strip"></span>

                            <div class="video-thumbnail position-relative">
                                <iframe
                                    src="https://www.youtube.com/embed/<?= $video_id; ?>?rel=0"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    class="video-frame w-100 h-100"></iframe>

                                <!-- Bar info bawah -->
                                <div class="video-info d-flex justify-content-between align-items-center px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="yt-badge" aria-hidden="true">
                                            <i class="bi bi-play-fill"></i>
                                        </span>
                                        <div>
                                            <h5 class="video-title mb-1"><?= html_escape($video_meta['title']); ?></h5>
                                            <p class="video-channel mb-0 text-muted"><?= html_escape($video_meta['author_name']); ?></p>
                                        </div>
                                    </div>

                                    <a href="https://www.youtube.com/watch?v=<?= $video_id; ?>"
                                        target="_blank"
                                        class="btn btn-brand btn-sm">
                                        <i class="bi bi-youtube me-1"></i> Tonton di YouTube
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>