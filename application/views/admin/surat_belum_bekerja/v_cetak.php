<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/fonts.min.css'); ?>">
    <style>
        /* ===== Kertas F4 & margin cetak ===== */
        @page {
            size: 210mm 330mm;
            /* F4/Folio Indonesia */
            margin: 10mm;
            /* margin tipis agar muat 1 halaman */
        }

        :root {
            /* Perkiraan tinggi kop (logo + teks + garis) */
            --header-height: 45mm;
            /* silakan koreksi 2–4mm jika perlu */
            --gap-after-header: 6mm;
            /* jarak ekstra antara kop & konten */
        }

        /* ===== Reset & font ===== */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        /* ===== Watermark ===== */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            z-index: -1;
            /* cukup -1 agar aman di print engine */
            font-size: 140pt;
            /* dipadatkan agar konten muat */
            font-weight: bold;
            color: rgba(0, 0, 0, 0.08);
            pointer-events: none;
            user-select: none;
        }

        /* ===== Header (kop) fixed ===== */
        #header {
            position: fixed;
            top: 10mm;
            /* sinkron dengan @page margin */
            left: 10mm;
            right: 10mm;
        }

        .kop-surat-wrapper {
            border-bottom: 3px solid #000;
            /* garis tebal bawah */
            padding-bottom: 2px;
            /* jarak antar garis */
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000;
            /* garis tipis atas */
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 28mm;
        }

        .kop-logo img {
            width: 36mm;
            /* kira-kira setara 140–150px */
            height: auto;
            margin-left: 4mm;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text p {
            margin: 1.5px 0;
        }

        /* Padatkan heading kop agar hemat ruang */
        .kop-text .line1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line2 {
            font-size: 20pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line3 {
            font-size: 24pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line4 {
            font-size: 9pt;
        }

        .contact-info {
            font-family: Arial, sans-serif;
            font-size: 9pt;
        }

        .contact-info span {
            margin: 0 6px;
        }

        /* ===== Konten mulai setelah header fixed ===== */
        #content {
            padding-top: calc(var(--header-height) + var(--gap-after-header));
            padding-left: 0.8in;
            padding-right: 0.8in;
            padding-bottom: 6mm;
        }

        /* ===== Judul & Nomor (beri jarak cukup) ===== */
        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            margin: 8px 0 4px 0;
        }

        .nomor-surat {
            text-align: center;
            margin: 0;
            margin-bottom: 8px;
            /* <-- supaya tidak dempet dengan pembuka */
        }

        /* ===== Isi ===== */
        .isi-surat {
            text-align: justify;
            line-height: 1.35;
            /* dipadatkan agar muat 1 halaman */
            margin: 0;
        }

        .isi-surat.pembuka {
            text-indent: 12mm;
            line-height: 1.25;
            margin: 10px 0 10px 0;
        }

        /* ===== Tabel data pemohon ===== */
        .data-pemohon {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
            font-size: 12pt;
            /* jika mepet, bisa 11.5pt */
        }

        .data-pemohon td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-pemohon td:first-child {
            width: 52mm;
        }

        /* label */
        .data-pemohon td:nth-child(2) {
            width: 6mm;
            text-align: center;
        }

        /* ":" */
        .data-pemohon td:nth-child(3) {
            width: auto;
        }

        /* nilai */

        /* ===== Penutup/TTD ===== */
        .closing-section {
            page-break-inside: avoid;
            margin-top: 6mm;
            clear: both;
        }

        .ttd {
            width: 60mm;
            /* agak sempit agar hemat ruang */
            float: right;
            text-align: center;
            line-height: 1.15;
            margin-top: 4mm;
        }

        .ttd p {
            margin: 2px 0;
        }

        /* ===== Cetak bersih ===== */
        @media print {

            html,
            body {
                height: 330mm;
            }
        }
    </style>
</head>

<body>
    <div class="watermark">SKBB</div>

    <div id="header">
        <div class="kop-surat-wrapper">
            <table class="kop-table">
                <tr>
                    <td class="kop-logo">
                        <img src="<?= base_url('assets/img/logo_tangsel.png'); ?>" alt="Logo">
                    </td>
                    <td class="kop-text">
                        <p class="line1">PEMERINTAH KOTA TANGERANG SELATAN</p>
                        <p class="line2">KECAMATAN SETU</p>
                        <p class="line3">KELURAHAN KADEMANGAN</p>
                        <p class="line4">Jl. Masjid Jami Al-Latif No.1 Kec. Setu - Tangerang Selatan - Banten 15313</p>
                        <div class="contact-info">
                            <span><i class="fab fa-whatsapp"></i> 083125243200</span>
                            <span><i class="far fa-envelope"></i> kel.kademangan@gmail.com</span>
                            <span><i class="fab fa-instagram"></i> kelurahan.kademangan</span><br>
                            <i class="fas fa-globe"></i> Website: http://kademangan.tangerangselatankota.go.id
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content">
        <p class="judul-surat">SURAT KETERANGAN</p>
        <p class="nomor-surat">Nomor: 145 / <?= str_repeat("&nbsp;", 10); ?>/ Kel.KDM/<?= date('Y'); ?></p>

        <p class="isi-surat pembuka">
            Yang bertanda tangan di bawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan dengan ini menerangkan bahwa:
        </p>

        <table class="data-pemohon">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_pemohon)); ?></b></td>
            </tr>
            <tr>
                <td>Tempat, tanggal lahir</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_lahir . ', ' . date('d-m-Y', strtotime($surat->tanggal_lahir))); ?></td>
            </tr>
            <tr>
                <td>Jenis kelamin</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kelamin); ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= html_escape($surat->nik); ?></td>
            </tr>
            <tr>
                <td>Warganegara</td>
                <td>:</td>
                <td><?= html_escape($surat->warganegara); ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= html_escape($surat->agama); ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= html_escape($surat->pekerjaan); ?></td>
            </tr>
            <tr>
                <td>Alamat Domisili</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Nama tersebut diatas adalah benar bertempat tinggal di Kelurahan kami dan berdasarkan surat pengantar RT/RW Nomor <b><?= html_escape($surat->nomor_surat_rt); ?></b> tanggal <b><?= date('d F Y', strtotime($surat->tanggal_surat_rt)); ?></b>, serta surat pernyataan yang bersangkutan bahwa nama tersebut diatas <b>BELUM BEKERJA</b>.
        </p>
        <p class="isi-surat pembuka">
            Surat keterangan ini dibuat diperuntukan : <b><?= html_escape($surat->keperluan); ?></b>
        </p>
        <p class="isi-surat pembuka">
            Demikian surat keterangan ini dibuat agar yang berkepentingan mengetahui dan dapat digunakan sebagaimana mestinya.
        </p>

        <div class="closing-section">
            <div class="ttd">
                <p>
                    Kademangan, <?= date('d F Y'); ?><br>
                    a.n. Lurah Kademangan<br>
                    Sekretaris Kelurahan
                </p>
                <br><br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">NAMA SEKRETARIS LURAH</p>
                <p>NIP. NIP SEKRETARIS LURAH</p>
            </div>
        </div>
    </div>
</body>

</html>