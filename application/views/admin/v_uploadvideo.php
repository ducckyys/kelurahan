<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Pengaturan Video Beranda</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= site_url('admin/dashboard'); ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Pengaturan Tampilan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Video Beranda</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir Video Beranda</div>
                </div>
                <form action="<?= base_url('admin/uploadvideo/update'); ?>" method="POST">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="youtube_link">Link Video YouTube di Halaman Utama</label>
                            <input type="url" class="form-control" id="youtube_link" name="youtube_link" value="<?= html_escape($youtube_link); ?>" placeholder="https://www.youtube.com/watch?v=xxxx" onkeyup="updateVideoPreview()">
                            <small class="form-text text-muted">Salin dan tempel URL lengkap dari video YouTube yang ingin ditampilkan.</small>
                        </div>

                        <div class="form-group mt-3">
                            <label>Preview Video</label>
                            <div id="video_preview_container" class="embed-responsive embed-responsive-16by9 border rounded d-none">
                                <iframe id="video_preview" class="embed-responsive-item" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <small id="video_preview_message" class="text-muted d-block mt-2">Masukkan link YouTube untuk melihat preview.</small>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Panggil fungsi preview saat halaman pertama kali dimuat
        updateVideoPreview();
    });

    function getYoutubeVideoId(url) {
        let videoId = null;
        const regExp = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
        const match = url.match(regExp);
        if (match && match[1]) {
            videoId = match[1];
        }
        return videoId;
    }

    function updateVideoPreview() {
        const youtubeLinkInput = document.getElementById('youtube_link');
        const videoPreviewContainer = document.getElementById('video_preview_container');
        const videoPreviewIframe = document.getElementById('video_preview');
        const videoPreviewMessage = document.getElementById('video_preview_message');

        const url = youtubeLinkInput.value;
        const videoId = getYoutubeVideoId(url);

        if (videoId) {
            videoPreviewIframe.src = `https://www.youtube.com/embed/${videoId}`;
            videoPreviewContainer.classList.remove('d-none');
            videoPreviewMessage.classList.add('d-none');
        } else {
            videoPreviewIframe.src = ""; // Clear the iframe
            videoPreviewContainer.classList.add('d-none');
            videoPreviewMessage.classList.remove('d-none');
            if (url) {
                videoPreviewMessage.textContent = 'Link YouTube tidak valid atau kosong.';
                videoPreviewMessage.classList.remove('text-muted');
                videoPreviewMessage.classList.add('text-danger');
            } else {
                videoPreviewMessage.textContent = 'Masukkan link YouTube untuk melihat preview.';
                videoPreviewMessage.classList.remove('text-danger');
                videoPreviewMessage.classList.add('text-muted');
            }
        }
    }
</script>