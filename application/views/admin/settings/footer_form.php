<?php
$footer = $footer ?? ['about_html' => '', 'related_links' => [], 'social_links' => []];
$links  = $footer['related_links'];
$social = $footer['social_links'];
?>

<div class="container-fluid py-3">
    <h3 class="mb-3"><?= html_escape($title ?? 'Pengaturan Footer'); ?></h3>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <form action="<?= site_url('admin/settings/footer_save'); ?>" method="post">
        <!-- Tentang Web -->
        <div class="card mb-3">
            <div class="card-header fw-semibold">Tentang Web (opsional)</div>
            <div class="card-body">
                <p class="text-muted small mb-2">Boleh dikosongkan. Tag HTML dasar diizinkan (p, b, strong, i, em, ul/ol/li, a, br, heading).</p>
                <textarea name="about_html" class="form-control" rows="6" placeholder="Tulis deskripsi singkat tentang website..."><?= set_value('about_html', $footer['about_html']); ?></textarea>
            </div>
        </div>

        <!-- Tautan Terkait -->
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold">Tautan Terkait</span>
                <button type="button" id="btnAddLink" class="btn btn-sm btn-primary">+ Tambah Tautan</button>
            </div>
            <div class="card-body">
                <div id="linksRepeater" class="vstack gap-2">
                    <?php if (!empty($links)): foreach ($links as $it): ?>
                            <div class="row g-2 align-items-end link-item">
                                <div class="col-md-4">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="links_title[]" class="form-control" value="<?= html_escape($it['title'] ?? ''); ?>" placeholder="Contoh: Layanan Online">
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">URL</label>
                                    <input type="url" name="links_url[]" class="form-control" value="<?= html_escape($it['url'] ?? ''); ?>" placeholder="https://...">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-outline-danger w-100 btnRemoveLink">&times;</button>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
                <template id="linkTemplate">
                    <div class="row g-2 align-items-end link-item">
                        <div class="col-md-4">
                            <label class="form-label">Judul</label>
                            <input type="text" name="links_title[]" class="form-control" placeholder="Contoh: Layanan Online">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">URL</label>
                            <input type="url" name="links_url[]" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-outline-danger w-100 btnRemoveLink">&times;</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sosial Media -->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold">Sosial Media</span>
                <button type="button" id="btnAddSocial" class="btn btn-sm btn-primary">+ Tambah Sosial</button>
            </div>
            <div class="card-body">
                <div id="socialRepeater" class="vstack gap-2">
                    <?php if (!empty($social)): foreach ($social as $it): ?>
                            <div class="row g-2 align-items-end social-item">
                                <div class="col-md-4">
                                    <label class="form-label">Icon</label>
                                    <select name="social_icon[]" class="custom-select form-control">
                                        <?php
                                        $icons = [
                                            'fa-facebook-f' => 'Facebook',
                                            'fa-instagram' => 'Instagram',
                                            'fa-x-twitter' => 'X (Twitter)',
                                            'fa-youtube' => 'YouTube',
                                            'fa-tiktok' => 'TikTok',
                                            'fa-whatsapp' => 'WhatsApp',
                                            'fa-linkedin-in' => 'LinkedIn',
                                            'fa-telegram' => 'Telegram',
                                        ];
                                        $sel = $it['icon'] ?? '';
                                        foreach ($icons as $key => $label) {
                                            $s = $sel === $key ? 'selected' : '';
                                            echo "<option value=\"$key\" $s>$label</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Label (opsional)</label>
                                    <input type="text" name="social_label[]" class="form-control" value="<?= html_escape($it['label'] ?? ''); ?>" placeholder="Contoh: @kelurahan.kademangan">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">URL</label>
                                    <input type="url" name="social_url[]" class="form-control" value="<?= html_escape($it['url'] ?? ''); ?>" placeholder="https://...">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-outline-danger w-100 btnRemoveSocial">&times;</button>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
                <template id="socialTemplate">
                    <div class="row g-2 align-items-end social-item">
                        <div class="col-md-4">
                            <label class="form-label">Icon</label>
                            <select name="social_icon[]" class="custom-select form-control">
                                <option value="fa-facebook-f">Facebook</option>
                                <option value="fa-instagram">Instagram</option>
                                <option value="fa-x-twitter">X (Twitter)</option>
                                <option value="fa-youtube">YouTube</option>
                                <option value="fa-tiktok">TikTok</option>
                                <option value="fa-whatsapp">WhatsApp</option>
                                <option value="fa-linkedin-in">LinkedIn</option>
                                <option value="fa-telegram">Telegram</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Label (opsional)</label>
                            <input type="text" name="social_label[]" class="form-control" placeholder="Contoh: @kelurahan.kademangan">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">URL</label>
                            <input type="url" name="social_url[]" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-outline-danger w-100 btnRemoveSocial">&times;</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Repeater: Links
        const linksWrap = document.getElementById('linksRepeater');
        const linkTpl = document.getElementById('linkTemplate');
        const addLink = document.getElementById('btnAddLink');
        if (addLink && linksWrap && linkTpl) {
            addLink.addEventListener('click', () => {
                linksWrap.appendChild(linkTpl.content.cloneNode(true));
            });
            linksWrap.addEventListener('click', (e) => {
                if (e.target.closest('.btnRemoveLink')) {
                    e.target.closest('.link-item').remove();
                }
            });
        }

        // Repeater: Social
        const socialWrap = document.getElementById('socialRepeater');
        const socialTpl = document.getElementById('socialTemplate');
        const addSocial = document.getElementById('btnAddSocial');
        if (addSocial && socialWrap && socialTpl) {
            addSocial.addEventListener('click', () => {
                socialWrap.appendChild(socialTpl.content.cloneNode(true));
            });
            socialWrap.addEventListener('click', (e) => {
                if (e.target.closest('.btnRemoveSocial')) {
                    e.target.closest('.social-item').remove();
                }
            });
        }
    });
</script>