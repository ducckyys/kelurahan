<footer class="mt-5 bg-light py-4">
    <div class="container text-center small text-muted">
        <div>© <?= date('Y'); ?> Kelurahan Kademangan. Semua hak dilindungi.</div>
        <div>Jl. Masjid Jami Al-Latif No.1 Kec. Setu, Kota Tangerang Selatan - Banten 15313, Indonesia • Telp: (021) 123456</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('layananSlider');
        if (!track) return;

        const btns = {
            prev: document.getElementById('layananPrev'),
            next: document.getElementById('layananNext'),
            prevSm: document.getElementById('layananPrevSm'),
            nextSm: document.getElementById('layananNextSm'),
        };

        // Hitung langkah geser = lebar item + gap
        const GAP_PX = 16; // kira-kira gap-4 (1rem) ~ 16px
        const getStep = () => {
            const first = track.querySelector('.slider-item');
            return first ? Math.ceil(first.getBoundingClientRect().width + GAP_PX) : Math.ceil(track.clientWidth * 0.9);
        };

        const scrollByStep = (dir) => {
            track.scrollBy({
                left: dir * getStep(),
                behavior: 'smooth'
            });
        };

        // Binding tombol (desktop & mobile)
        if (btns.prev) btns.prev.addEventListener('click', () => scrollByStep(-1));
        if (btns.next) btns.next.addEventListener('click', () => scrollByStep(1));
        if (btns.prevSm) btns.prevSm.addEventListener('click', () => scrollByStep(-1));
        if (btns.nextSm) btns.nextSm.addEventListener('click', () => scrollByStep(1));

        // Opsional: sembunyikan panah saat mentok
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

    // Tutup dropdown saat mouse keluar
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

    // Tutup semua dropdown saat scroll (biar nggak ngelayang)
    window.addEventListener('scroll', () => {
        document.querySelectorAll('.nav-item.dropdown .dropdown-toggle').forEach((t) => {
            const dd = bootstrap.Dropdown.getInstance(t);
            if (dd) dd.hide();
        });
    });

    // Cegah klik anchor placeholder
    document.querySelectorAll('.dropdown-menu a[href="#"], .nav-link[href="#"]').forEach((a) => {
        a.addEventListener('click', (e) => e.preventDefault());
    });

    (function() {
        const input = document.querySelector('input[name="scan_surat_rt"]');
        const wrap = document.getElementById('srtPreview');
        const img = document.getElementById('srtPreviewImg');
        const fileT = document.getElementById('srtPreviewFile');
        const clear = document.getElementById('srtClear');

        if (!input || !wrap) return;

        input.addEventListener('change', function(e) {
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
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(f);
            } else {
                fileT.textContent = 'File dipilih: ' + f.name + ' (' + Math.round(f.size / 1024) + ' KB)';
                fileT.style.display = 'block';
            }
        });

        clear.addEventListener('click', function() {
            input.value = '';
            wrap.style.display = 'none';
            img.style.display = 'none';
            fileT.style.display = 'none';
        });
    })();

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