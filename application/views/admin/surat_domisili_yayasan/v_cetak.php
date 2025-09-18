<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/fonts.min.css'); ?>">

    <style>
        /* ===== Ukuran kertas & margin cetak (F4/Folio) ===== */
        @page {
            size: 210mm 330mm;
            /* F4 Indonesia */
            margin: 10mm;
            /* margin tipis agar muat 1 halaman */
        }

        :root {
            /* Perkirakan tinggi kop (logo + teks + garis) */
            --header-height: 45mm;
            /* sesuaikan jika kopmu lebih pendek/panjang */
            --gap-after-header: 6mm;
            /* jarak ekstra antara header & konten */
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

        /* ===== Watermark aman untuk cetak ===== */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            z-index: -1;
            /* cukup -1 agar kompatibel engine print */
            font-size: 140pt;
            /* sedikit dikecilkan agar muat 1 halaman */
            font-weight: bold;
            color: rgba(0, 0, 0, 0.08);
            pointer-events: none;
        }

        /* ===== Header (kop surat) fixed ===== */
        #header {
            position: fixed;
            top: 10mm;
            /* sinkron dengan @page margin */
            left: 10mm;
            right: 10mm;
        }

        .kop-surat-wrapper {
            border-bottom: 3px solid #000;
            /* Garis tebal di bawah */
            padding-bottom: 2px;
            /* jarak antar garis */
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000;
            /* Garis tipis di atas */
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 28mm;
        }

        .kop-logo img {
            width: 34mm;
            height: auto;
            margin-left: 4mm;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text p {
            margin: 1.5px 0;
        }

        /* Ukuran heading kop sedikit dipadatkan */
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

        /* ===== Judul & Nomor: beri jarak agar tak dempet ===== */
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
            /* jarak ke paragraf pembuka */
        }

        /* ===== Isi Surat ===== */
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

        /* ===== Tabel data pemohon/organisasi ===== */
        .data-blok {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
            font-size: 12pt;
            /* kalau mepet, bisa jadi 11.5pt */
        }

        .data-blok td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-blok td:first-child {
            width: 52mm;
        }

        /* label */
        .data-blok td:nth-child(2) {
            width: 6mm;
            text-align: center;
        }

        /* ":" */
        .data-blok td:nth-child(3) {
            width: auto;
        }

        /* nilai */

        /* ===== Penutup/TTD: hindari pecah halaman ===== */
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
            line-height: 1.1;
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
    <div class="watermark">SDY</div>

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
        <p class="nomor-surat">Nomor : 145 / <?= str_repeat("&nbsp;", 10); ?> / Kel.KDM/ <?= date('Y'); ?></p>

        <p class="isi-surat pembuka">
            Yang bertanda tangan di bawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan dengan ini menerangkan bahwa :
        </p>

        <table class="data-blok">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_penanggung_jawab)); ?></b></td>
            </tr>
            <tr>
                <td>Tempat, tanggal lahir</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_lahir . ', ' . date('d-m-Y', strtotime($surat->tanggal_lahir))); ?></td>
            </tr>
            <tr>
                <td>Nomor KTP</td>
                <td>:</td>
                <td><?= html_escape($surat->nik); ?></td>
            </tr>
            <tr>
                <td>Jenis kelamin</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kelamin); ?></td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td><?= html_escape($surat->kewarganegaraan); ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= html_escape($surat->agama); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat_pemohon); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Telah datang menghadap, melapor dan memohon surat keterangan, berdasarkan pernyataan dan dokumen pemohon, yang bersangkutan memiliki Yayasan dengan data Sebagai berikut:
        </p>

        <table class="data-blok">
            <tr>
                <td>Nama Organisasi</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_organisasi)); ?></b></td>
            </tr>
            <tr>
                <td>Penanggung Jawab</td>
                <td>:</td>
                <td><?= html_escape($surat->nama_penanggung_jawab); ?></td>
            </tr>
            <tr>
                <td>Jenis Kegiatan</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kegiatan); ?></td>
            </tr>
            <tr>
                <td>Alamat Kantor</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat_kantor); ?></td>
            </tr>
            <tr>
                <td>Jumlah Pengurus</td>
                <td>:</td>
                <td><?= html_escape($surat->jumlah_pengurus); ?> (Orang)</td>
            </tr>
            <tr>
                <td>Akta Pendirian</td>
                <td>:</td>
                <td>Notaris: <?= html_escape($surat->nama_notaris_pendirian); ?></td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><?= html_escape($surat->nomor_akta_pendirian); ?>,- Tanggal: <?= date('d F Y', strtotime($surat->tanggal_akta_pendirian)); ?></td>
            </tr>

            <?php if (!empty($surat->nomor_akta_perubahan)): ?>
                <tr>
                    <td>Akta Perubahan</td>
                    <td>:</td>
                    <td>Notaris: <?= html_escape($surat->nama_notaris_perubahan); ?></td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td><?= html_escape($surat->nomor_akta_perubahan); ?>,- Tanggal: <?= date('d F Y', strtotime($surat->tanggal_akta_perubahan)); ?></td>
                </tr>
            <?php endif; ?>

            <tr>
                <td>NPWP</td>
                <td>:</td>
                <td><?= html_escape($surat->npwp); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Demikian surat keterangan ini dibuat, sesuai dengan data pemohon, apabila di kemudian hari keterangan atau pengakuan pemohon tidak benar, atau melanggar ketentuan yang berlaku sepenuhnya menjadi tanggung jawab pemohon tidak melibatkan pihak RT/RW dan Pejabat yang menandatangani surat keterangan ini.
        </p>

        <div class="closing-section">
            <div class="ttd">
                <p>
                    Tangerang Selatan, <?= date('d F Y'); ?><br>
                    Sesuai Permohonan Pemohon<br>
                    Lurah
                </p>
                <br><br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">NAMA LURAH</p>
                <p>NIP. NIP LURAH</p>
            </div>
        </div>
    </div>
</body>

</html>