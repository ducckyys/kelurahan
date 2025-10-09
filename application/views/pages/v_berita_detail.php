<section class="berita-section detail py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <!-- breadcrumb mini bisa ditambah jika mau -->
                    </div>
                    <a href="<?= base_url('berita'); ?>" class="back-icon" aria-label="Kembali">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 16 16" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                        </svg>
                        <span class="ms-2 fw-semibold">Kembali</span>
                    </a>
                </div>

                <h1 class="display-6 fw-bold mb-3"><?= html_escape($berita->judul_berita); ?></h1>

                <div class="text-muted small mb-4">
                    <span>Dipublikasikan pada: <?= date('d F Y', strtotime($berita->tgl_publish)); ?></span>
                    <?php if (!empty($berita->penulis)) : ?>
                        <span class="mx-2">|</span>
                        <span>Oleh: <?= html_escape($berita->penulis); ?></span>
                    <?php endif; ?>
                </div>

                <img
                    src="<?= base_url('uploads/berita/' . $berita->gambar); ?>"
                    class="img-fluid rounded-4 shadow-sm mb-4"
                    alt="<?= html_escape($berita->judul_berita); ?>">

                <?php
                // IZINKAN TAG DASAR + <a>
                $allowed_tags = '<p><br><strong><b><em><i><u><blockquote><ul><ol><li><h2><h3><h4><h5><h6><hr><a>';

                $raw = (string) $berita->isi_berita;

                // 1) Buang tag di luar whitelist
                $safe_html = strip_tags($raw, $allowed_tags);

                // 2) Bersihkan atribut berbahaya pada <a>
                //    - hapus event handler (onclick, onload, dst) & style inline
                $safe_html = preg_replace('/\s+on\w+="[^"]*"/i', '', $safe_html);
                $safe_html = preg_replace("/\s+on\w+='[^']*'/i", '', $safe_html);
                $safe_html = preg_replace('/\s+style="[^"]*"/i', '', $safe_html);
                $safe_html = preg_replace("/\s+style='[^']*'/i", '', $safe_html);

                // 3) Normalkan <a> agar hanya punya href yang aman (http/https/mailto) + target/rel
                $safe_html = preg_replace_callback(
                    '/<a\b[^>]*href\s*=\s*(["\'])(.*?)\1[^>]*>/i',
                    function ($m) {
                        $href = trim($m[2]);
                        // izinkan hanya http, https, mailto
                        if (!preg_match('#^(https?://|mailto:)#i', $href)) {
                            $href = '#';
                        }
                        // rebuild tag pembuka <a ...>
                        $href = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
                        return '<a href="' . $href . '" target="_blank" rel="noopener nofollow ugc">';
                    },
                    $safe_html
                );

                // 4) Rapikan spasi
                $safe_html = preg_replace('/\s+/', ' ', $safe_html);
                $safe_html = str_replace(['<p> ', ' </p>'], ['<p>', '</p>'], $safe_html);
                ?>
                <div class="article-content">
                    <?= $safe_html; ?>
                </div>
            </div>
        </div>
    </div>
</section>