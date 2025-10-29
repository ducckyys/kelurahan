<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/fonts.min.css'); ?>">
    <style>
        @page {
            size: 210mm 330mm;
            margin: 10mm;
        }

        :root {
            --header-height: 45mm;
            --gap-after-header: 6mm;
            --ttd-width: 100mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

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
        }

        .contact-info span {
            margin: 0 6px;
        }

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
            margin: 0 0 8px 0;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.35;
            margin: 0;
        }

        .isi-surat.pembuka {
            text-indent: 12mm;
            line-height: 1.25;
            margin: 10px 0;
        }

        .data-pemohon {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
            font-size: 12pt;
        }

        .data-pemohon td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-pemohon td:first-child {
            width: 52mm;
        }

        .data-pemohon td:nth-child(2) {
            width: 6mm;
            text-align: center;
        }

        .closing-section {
            page-break-inside: avoid;
            margin-top: 6mm;
            clear: both;
        }

        .ttd {
            width: var(--ttd-width);
            float: right;
            text-align: center;
            line-height: 1.15;
            margin-top: 4mm;
        }

        .ttd p {
            margin: 2px 0;
        }

        .ttd .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
            white-space: nowrap;
            word-break: keep-all;
        }

        @media print {

            html,
            body {
                height: 330mm;
            }
        }
    </style>
</head>

<body>

    <div id="header">
        <div class="kop-surat-wrapper">
            <table class="kop-table">
                <tr>
                    <td class="kop-logo"><img src="<?= base_url('assets/img/logo_tangsel.png'); ?>" alt="Logo"></td>
                    <td class="kop-text">
                        <p class="line1">PEMERINTAH KOTA TANGERANG SELATAN</p>
                        <p class="line2">KECAMATAN SETU</p>
                        <p class="line3">KELURAHAN KADEMANGAN</p>
                        <p class="line4">Jl. Masjid Jami Al-Latif No.1 Kec. Setu - Tangerang Selatan - Banten 15313</p>
                        <div class="contact-info">
                            <span>083125243200</span>
                            <span>kel.kademangan@gmail.com</span>
                            <span>instagram: kelurahan.kademangan</span><br>
                            Website: http://kademangan.tangerangselatankota.go.id
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content">
        <p class="judul-surat">SURAT KETERANGAN PENGHASILAN</p>
        <p class="nomor-surat">Nomor: <?= html_escape($surat->nomor_surat) ?: '.................................'; ?></p>

        <p class="isi-surat pembuka">
            Yang bertanda tangan di bawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan, dengan ini menerangkan bahwa:
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
            Nama tersebut di atas adalah benar bertempat tinggal di Kelurahan kami dan berdasarkan
            surat pengantar RT/RW Nomor <b><?= html_escape($surat->nomor_surat_rt); ?></b>
            tanggal <b><?= date('d F Y', strtotime($surat->tanggal_surat_rt)); ?></b>,
            serta surat pernyataan yang bersangkutan bahwa nama tersebut di atas
            <b><span class="nowrap">TIDAK MEMILIKI PENGHASILAN.</span></b>
        </p>

        <p class="isi-surat pembuka">
            Surat keterangan ini dibuat untuk keperluan: <b><?= html_escape($surat->keperluan); ?></b>.
        </p>

        <p class="isi-surat pembuka">Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>

        <div class="closing-section">
            <?php
            $jabatanLabel = $ttd->jabatan_nama ?? 'Sekretaris Kelurahan';
            $namaTtd = $ttd->nama ?? '.....................';
            $nipTtd  = $ttd->nip  ?? '.....................';
            $tanggalCetak = $tanggal_ttd ?? date('d F Y');
            ?>
            <div class="ttd">
                <p>Kademangan, <?= html_escape($tanggalCetak); ?><br><?= html_escape($jabatanLabel); ?></p>
                <br><br><br><br>
                <p class="nama-ttd"><?= html_escape(strtoupper($namaTtd)); ?></p>
                <p>NIP. <?= html_escape($nipTtd); ?></p>
            </div>
        </div>
    </div>
</body>

</html>