<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* ==== Kertas F4 & margin cetak ==== */
        @page {
            size: 210mm 330mm;
            margin: 10mm;
        }

        :root {
            --header-height: 45mm;
            --gap-after-header: 6mm;
        }

        /* ==== Reset & font ==== */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        /* ==== Header (kop) fixed ==== */
        #header {
            position: fixed;
            top: 10mm;
            left: 10mm;
            right: 10mm;
        }

        .kop-surat-wrapper {
            border-bottom: 3px solid #000;
            padding-bottom: 2px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #000;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 28mm;
        }

        .kop-logo img {
            width: 36mm;
            height: auto;
            margin-left: 4mm;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text p {
            margin: 1.5px 0;
        }

        .kop-text .line1 {
            font-size: 16pt;
            font-weight: bold;
        }

        .kop-text .line2 {
            font-size: 20pt;
            font-weight: bold;
        }

        .kop-text .line3 {
            font-size: 24pt;
            font-weight: bold;
        }

        .kop-text .line4 {
            font-size: 9pt;
        }

        .contact-info {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            margin-top: 5px;
        }

        .contact-info span {
            margin: 0 6px;
        }

        /* ==== Konten ==== */
        #content {
            padding-top: calc(var(--header-height) + var(--gap-after-header));
            padding-left: 0.8in;
            padding-right: 0.8in;
            padding-bottom: 6mm;
        }

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
            margin-bottom: 15px;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.4;
            margin: 10px 0;
        }

        .isi-surat.pembuka {
            text-indent: 12mm;
            margin: 0.2in 0 10px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 12mm;
            font-size: 12pt;
        }

        .data-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }

        .data-table td:first-child {
            width: 35%;
        }

        .data-table td:nth-child(2) {
            width: 5%;
            text-align: center;
        }

        /* ==== Bagian Keperluan ==== */
        .keperluan-section {
            margin: 12px 0;
        }

        .keperluan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .keperluan-table td {
            padding: 3px 5px;
            width: 50%;
        }

        .checkbox-box {
            display: inline-block;
            width: 5mm;
            height: 5mm;
            border: 1.5px solid black;
            margin-right: 10px;
            vertical-align: middle;
        }

        .catatan-bawah {
            font-size: 11pt;
        }

        /* ==== Penutup/TTD ==== */
        .closing-section {
            page-break-inside: avoid;
            margin-top: 8mm;
            clear: both;
        }

        /* TTD KIRI (BARU) */
        .ttd-kiri {
            width: 80mm;
            /* Lebar area ttd kiri */
            float: left;
            text-align: center;
            line-height: 1.2;
        }

        /* TTD KANAN (LAMA) */
        .ttd-kanan {
            width: 80mm;
            /* Lebar area ttd kanan */
            float: right;
            text-align: center;
            line-height: 1.2;
        }

        .jabatan {
            margin: 2px 0;
        }

        .nama-pejabat {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div id="header">
        <div class="kop-surat-wrapper">
            <table class="kop-table">
                <tr>
                    <td class="kop-logo"><img src="<?= base_url('assets/img/logo_tangsel.png'); ?>" alt="Logo">
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
        <p class="nomor-surat">Nomor : <?= html_escape($surat->nomor_surat); ?></p>
        </p>
        <p class="isi-surat pembuka">Yang bertanda tangan dibawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan menerangkan bahwa :</p>
        <table class="data-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_ahli_waris)); ?></b></td>
            </tr>
            <tr>
                <td>Nomor KTP</td>
                <td>:</td>
                <td><?= html_escape($surat->nik_ahli_waris); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kelamin); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat_ahli_waris); ?></td>
            </tr>
        </table>
        <p class="isi-surat">Nama tersebut diatas adalah ahli waris (<b><?= html_escape($surat->hubungan_ahli_waris); ?></b>) dari alm <?= html_escape(strtoupper($surat->nama_almarhum)); ?> telah datang menghadap, dan memohon surat keterangan berdasarkan pernyataan pemohon dan Surat Pengantar RT/RW nomor <?= html_escape($surat->nomor_surat_rt); ?> tanggal <?= date('d-m-Y', strtotime($surat->tanggal_surat_rt)); ?>, <b><?= html_escape($surat->keterangan_almarhum); ?></b> nama tersebut diatas telah meninggal dunia bertempat tinggal di <?= html_escape($surat->alamat_ahli_waris); ?> dengan data tersebut :</p>
        <table class="data-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_almarhum)); ?></b></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= html_escape($surat->nik_almarhum); ?></td>
            </tr>
            <tr>
                <td>Meninggal</td>
                <td>:</td>
                <td>Di <?= html_escape($surat->tempat_meninggal); ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?= date('d F Y', strtotime($surat->tanggal_meninggal)); ?></td>
            </tr>
            <tr>
                <td>Alamat (Alm)</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat_almarhum); ?></td>
            </tr>
        </table>
        <div class="keperluan-section">
            <p class="isi-surat" style="margin-bottom: 8px;">Surat keterangan ini diperlukan untuk :</p>
            <table class="keperluan-table">
                <tr>
                    <td><span class="checkbox-box"></span> Administrasi Pemakaman</td>
                    <td><span class="checkbox-box"></span> Administrasi Perbankan</td>
                </tr>
                <tr>
                    <td><span class="checkbox-box"></span> TASPEN</td>
                    <td><span class="checkbox-box"></span> BPJS</td>
                </tr>
                <tr>
                    <td><span class="checkbox-box"></span> ASURANSI</td>
                    <td><span class="checkbox-box"></span> ....................................</td>
                </tr>
            </table>
        </div>
        <p class="isi-surat">Apabila pernyataan pemohon ini tidak benar, maka segala resiko hukum sepenuhnya menjadi tanggung jawab pemohon, tanpa melibatkan pihak Lurah.</p>
        <p class="isi-surat">Demikian surat keterangan ini dibuat atas dasar sebenarnya dan untuk digunakan sebagai mana mestinya.</p>
        <p class="catatan-bawah">Surat ini berlaku 14 hari sejak dikeluarkan.</p>

        <div class="closing-section">
            <div class="ttd-kiri">
                <p class="jabatan">
                    Ahli Waris / Pemohon,
                </p>
                <br><br><br><br>
                <p class="nama-pejabat"><?= html_escape(strtoupper($surat->nama_ahli_waris)); ?></p>
            </div>

            <div class="ttd-kanan">
                <p class="jabatan">
                    Kademangan, <?= date('d F Y'); ?><br>
                    Lurah Kademangan
                </p>
                <br><br><br>
                <p class="nama-pejabat">NAMA LURAH</p>
                <p class="jabatan">NIP. NIP LURAH</p>
            </div>
        </div>
    </div>
</body>

</html>