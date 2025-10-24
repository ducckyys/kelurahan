</div>
<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Website Kelurahan
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            <?= date('Y'); ?>, made with <i class="fa fa-heart heart text-danger"></i> by <a href="#">Tim Anda</a>
        </div>
    </div>
</footer>
</div>
</div>
<script src="<?= base_url('assets/admin/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/core/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/core/bootstrap.min.js'); ?>"></script>

<!-- CDN CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

<script src="<?= base_url('assets/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/chart.js/chart.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/chart-circle/circles.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/plugin/datatables/datatables.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/plugin/sweetalert/sweetalert.min.js'); ?>"></script>

<script src="<?= base_url('assets/admin/js/atlantis.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/custom.js'); ?>"></script>
<script>
    let ck;
    ClassicEditor.create(document.querySelector('#isi_berita'), {
        language: 'id',
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'alignment', 'undo', 'redo', '|',
                'imageUpload'
            ]
        },
        simpleUpload: {
            uploadUrl: '<?= base_url('admin/berita/upload_gambar'); ?>',
            withCredentials: false,
            headers: {
                'X-CSRF-TOKEN': '<?= $this->security->get_csrf_hash(); ?>'
            }
        }
    }).then(editor => {
        ck = editor;
    }).catch(console.error);

    // Util: cek apakah HTML kosong (hanya tag/tanpa teks)
    function isEmptyHtml(html) {
        if (!html) return true;
        // buang &nbsp;, <br>, whitespace dan tag kosong
        const text = html
            .replace(/&nbsp;/g, ' ')
            .replace(/<br\s*\/?>/gi, ' ')
            .replace(/<[^>]*>/g, ' ') // buang semua tag
            .trim();
        return text.length === 0;
    }

    // Hook submit form: validasi isi CKEditor dan set ke textarea
    document.querySelector('form[action*="admin/berita/store"], form[action*="admin/berita/update"]')
        ?.addEventListener('submit', function(e) {
            try {
                const data = ck.getData();
                if (isEmptyHtml(data)) {
                    e.preventDefault();
                    alert('Isi berita wajib diisi.');
                    ck.editing.view.focus();
                    return false;
                }
                // masukkan kembali ke textarea agar terkirim ke server
                document.getElementById('isi_berita').value = data;
            } catch (err) {
                // fallback: jangan blokir submit kalau ck belum siap
                console.warn(err);
            }
        });
</script>
</body>

</html>