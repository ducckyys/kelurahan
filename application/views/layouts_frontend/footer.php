<?php

/**
 * Footer Dinamis — About / Related Links / Social
 * - Aman kalau $footer_settings TIDAK dikirim: view akan fetch sendiri dari M_settings
 * - Tiap blok otomatis sembunyi kalau kosong
 * - Font Awesome 6 (brands) untuk ikon sosial
 */

// --- Fallback: ambil data kalau belum ada ---
if (!isset($footer_settings) || !is_array($footer_settings)) {
    $footer_settings = get_footer_settings();
}

// --- Normalisasi & guard array ---
$about  = trim((string)($footer_settings['about_html'] ?? ''));
$links  = $footer_settings['related_links'] ?? [];
$social = $footer_settings['social_links'] ?? [];
$links  = is_array($links)  ? $links  : [];
$social = is_array($social) ? $social : [];

// --- Helper kecil ---
$hasLinks  = count(array_filter($links,  function ($x) {
    return !empty($x['title']) || !empty($x['url']);
})) > 0;
$hasSocial = count(array_filter($social, function ($x) {
    return !empty($x['label']) || !empty($x['url']);
})) > 0;
$hasAny    = ($about !== '' || $hasLinks || $hasSocial);

// Deteksi set ikon (brands/solid) sederhana
$detectIconSet = function ($icon) {
    $icon = trim((string)$icon);
    if ($icon === '') return ['fa-brands', 'fa-link'];
    $isBrand = (bool)preg_match('/^(fa-)?(facebook|facebook-f|instagram|x-twitter|twitter|youtube|tiktok|whatsapp|linkedin|linkedin-in|telegram)/i', $icon);
    return [$isBrand ? 'fa-brands' : 'fa-solid', $icon];
};
?>

<?php if ($hasAny): ?>
    <section class="footer-info py-5">
        <div class="container">
            <div class="row g-4">

                <?php if ($about !== ''): ?>
                    <div class="col-lg-6">
                        <div class="fi-card">
                            <div class="fi-card-head">
                                <h5 class="fi-title">Tentang Web</h5>
                            </div>
                            <div class="fi-card-body text-muted">
                                <?= $about; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($hasLinks): ?>
                    <div class="col-lg-3">
                        <div class="fi-card">
                            <div class="fi-card-head">
                                <h5 class="fi-title">Tautan Terkait</h5>
                            </div>
                            <ul class="fi-list mb-0">
                                <?php foreach ($links as $it):
                                    $title = trim((string)($it['title'] ?? ''));
                                    $url   = trim((string)($it['url'] ?? ''));
                                    if ($title === '' && $url === '') continue;
                                    $host  = $url ? (parse_url($url, PHP_URL_HOST) ?: $url) : '';
                                    $label = $title !== '' ? $title : $host;
                                ?>
                                    <li>
                                        <?php if ($url !== ''): ?>
                                            <a href="<?= html_escape($url); ?>" target="_blank" rel="noopener">
                                                <?= html_escape($label); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted"><?= html_escape($label); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($hasSocial): ?>
                    <div class="col-lg-3">
                        <div class="fi-card">
                            <div class="fi-card-head">
                                <h5 class="fi-title">Sosial Media</h5>
                            </div>
                            <ul class="fi-social mb-0">
                                <?php foreach ($social as $it):
                                    $iconRaw = $it['icon'] ?? 'fa-link';
                                    $label   = trim((string)($it['label'] ?? ''));
                                    $url     = trim((string)($it['url'] ?? ''));
                                    $isBrand = (bool)preg_match('/^(fa-)?(facebook|facebook-f|instagram|x-twitter|twitter|youtube|tiktok|whatsapp|linkedin|linkedin-in|telegram)/i', $iconRaw);
                                    $set     = $isBrand ? 'fa-brands' : 'fa-solid';
                                    $icon    = $iconRaw ?: 'fa-link';
                                    if ($url === '' && $label === '' && $icon === '') continue;
                                ?>
                                    <li>
                                        <?php if ($url !== ''): ?>
                                            <a href="<?= html_escape($url); ?>" target="_blank" rel="noopener">
                                                <span class="fi-ico"><i class="<?= $set; ?> <?= html_escape($icon); ?>"></i></span>
                                                <span class="fi-text"><?= html_escape($label !== '' ? $label : $url); ?></span>
                                            </a>
                                        <?php else: ?>
                                            <span class="fi-ico"><i class="<?= $set; ?> <?= html_escape($icon); ?>"></i></span>
                                            <span class="fi-text text-muted"><?= html_escape($label); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>
<?php endif; ?>

<footer class="mt-5 bg-light py-4">
    <div class="container text-center small text-muted">
        <div>© <?= date('Y'); ?> Kelurahan Kademangan. Semua hak dilindungi.</div>
        <div>Jl. Masjid Jami Al-Latif No.1 Kec. Setu, Kota Tangerang Selatan - Banten 15313, Indonesia • Telp: (021) 123456</div>
    </div>
</footer>

<!-- ====== JS kamu (biarkan apa adanya) ====== -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>

<script>
    // Slider layanan (tetap)
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('layananSlider');
        if (!track) return;

        const btns = {
            prev: document.getElementById('layananPrev'),
            next: document.getElementById('layananNext'),
            prevSm: document.getElementById('layananPrevSm'),
            nextSm: document.getElementById('layananNextSm'),
        };

        const GAP_PX = 16;
        const getStep = () => {
            const first = track.querySelector('.slider-item');
            return first ? Math.ceil(first.getBoundingClientRect().width + GAP_PX) :
                Math.ceil(track.clientWidth * 0.9);
        };
        const scrollByStep = (dir) => track.scrollBy({
            left: dir * getStep(),
            behavior: 'smooth'
        });

        btns.prev?.addEventListener('click', () => scrollByStep(-1));
        btns.next?.addEventListener('click', () => scrollByStep(1));
        btns.prevSm?.addEventListener('click', () => scrollByStep(-1));
        btns.nextSm?.addEventListener('click', () => scrollByStep(1));

        const toggleArrows = () => {
            const maxScroll = track.scrollWidth - track.clientWidth - 1;
            if (btns.prev) btns.prev.style.visibility = track.scrollLeft <= 0 ? 'hidden' : 'visible';
            if (btns.next) btns.next.style.visibility = track.scrollLeft >= maxScroll ? 'hidden' : 'visible';
        };
        track.addEventListener('scroll', toggleArrows, {
            passive: true
        });
        window.addEventListener('resize', toggleArrows);
        toggleArrows();
    });

    // Dropdown behavior (tetap)
    document.querySelectorAll('.nav-item.dropdown').forEach((item) => {
        let timer;
        item.addEventListener('mouseleave', () => {
            timer = setTimeout(() => {
                const toggle = item.querySelector('[data-bs-toggle="dropdown"], .dropdown-toggle');
                if (toggle) bootstrap.Dropdown.getOrCreateInstance(toggle).hide();
            }, 120);
        });
        item.addEventListener('mouseenter', () => {
            if (timer) clearTimeout(timer);
        });
    });
    window.addEventListener('scroll', () => {
        document.querySelectorAll('.nav-item.dropdown .dropdown-toggle').forEach((t) => {
            const dd = bootstrap.Dropdown.getInstance(t);
            if (dd) dd.hide();
        });
    });
    document.querySelectorAll('.dropdown-menu a[href="#"], .nav-link[href="#"]').forEach((a) => {
        a.addEventListener('click', (e) => e.preventDefault());
    });

    // Preview file (tetap)
    (function() {
        const input = document.querySelector('input[name="scan_surat_rt"]');
        const wrap = document.getElementById('srtPreview');
        const img = document.getElementById('srtPreviewImg');
        const fileT = document.getElementById('srtPreviewFile');
        const clear = document.getElementById('srtClear');
        if (!input || !wrap) return;

        input.addEventListener('change', function() {
            const f = this.files && this.files[0] ? this.files[0] : null;
            if (!f) {
                wrap.style.display = 'none';
                return;
            }
            wrap.style.display = 'block';
            fileT.style.display = 'none';
            img.style.display = 'none';
            const ext = (f.name.split('.').pop() || '').toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                const reader = new FileReader();
                reader.onload = (ev) => {
                    img.src = ev.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(f);
            } else {
                fileT.textContent = 'File dipilih: ' + f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                fileT.style.display = 'block';
            }
        });
        clear?.addEventListener('click', function() {
            input.value = '';
            wrap.style.display = 'none';
            img.style.display = 'none';
            fileT.style.display = 'none';
        });
    })();

    // List dokumen pendukung (tetap)
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('input[name="dokumen_pendukung[]"]');
        const list = document.getElementById('dokList');
        if (!input || !list) return;
        input.addEventListener('change', function() {
            list.innerHTML = '';
            if (!this.files) return;
            Array.from(this.files).forEach(function(f) {
                const li = document.createElement('li');
                li.textContent = f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                list.appendChild(li);
            });
        });
    });
</script>
</body>

</html>