<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= html_escape($title); ?></title>
    <style>
        @page {
            size: 210mm 330mm;
            margin: 10mm;
        }

        :root {
            --header-height: 45mm;
            --gap-after-header: 6mm;
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
            margin: 0 0 20px 0;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.5;
            margin: 8px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }

        .data-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-table td.label {
            width: 30%;
        }

        .data-table td.separator {
            width: 5%;
            text-align: center;
        }

        .data-table td.value {
            width: 65%;
        }

        .indented-list {
            padding-left: 20px;
        }

        .closing-section {
            page-break-inside: avoid;
            margin-top: 30px;
            width: 100%;
            clear: both;
        }

        .ttd-box {
            width: 48%;
            text-align: center;
            line-height: 1.4;
        }

        .ttd-left {
            float: left;
        }

        .ttd-right {
            float: right;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body onload="window.print()">

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
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content">
        <p class="judul-surat">SURAT KETERANGAN SUAMI ISTRI</p>
        <p class="nomor-surat">Nomor: <?= html_escape($surat->nomor_surat); ?></p>

        <p class="isi-surat">Yang bertanda tangan di bawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan Provinsi Banten menerangkan bahwa :</p>

        <table class="data-table">
            <tr>
                <td class="label">N a m a</td>
                <td class="separator">:</td>
                <td class="value"><b><?= html_escape(strtoupper($surat->nama_pihak_satu)); ?></b></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->nik_pihak_satu); ?></td>
            </tr>
            <tr>
                <td class="label">Tempat/Tgl Lahir</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->tempat_lahir_pihak_satu); ?>, <?= date('d-m-Y', strtotime($surat->tanggal_lahir_pihak_satu)); ?></td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->jenis_kelamin_pihak_satu); ?></td>
            </tr>
            <tr>
                <td class="label">A g a m a</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->agama_pihak_satu); ?></td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->pekerjaan_pihak_satu); ?></td>
            </tr>
            <tr>
                <td class="label">Warganegara</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->warganegara_pihak_satu); ?></td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->alamat_pihak_satu); ?></td>
            </tr>
        </table>

        <p class="isi-surat">
            Nama tersebut diatas telah datang menghadap memohon surat keterangan berdasarkan surat pengantar RT/RW Nomor: <b><?= html_escape($surat->nomor_surat_rt); ?></b> tanggal <b><?= date('d F Y', strtotime($surat->tanggal_surat_rt)); ?></b> dan surat pernyataan pemohon bahwa:
        </p>

        <table class="data-table indented-list">
            <tr>
                <td class="label" style="width: 2%;">a.</td>
                <td class="label" style="width: 25%;">N a m a</td>
                <td class="separator">:</td>
                <td class="value"><b><?= html_escape(strtoupper($surat->nama_pihak_satu)); ?></b></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->nik_pihak_satu); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->alamat_pihak_satu); ?></td>
            </tr>
        </table>

        <table class="data-table indented-list" style="margin-top: 10px;">
            <tr>
                <td class="label" style="width: 2%;">b.</td>
                <td class="label" style="width: 25%;">Nama</td>
                <td class="separator">:</td>
                <td class="value"><b><?= html_escape(strtoupper($surat->nama_pihak_dua)); ?></b></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">NIK</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->nik_pihak_dua); ?></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td class="value"><?= html_escape($surat->alamat_pihak_dua); ?></td>
            </tr>
        </table>

        <p class="isi-surat" style="text-indent: 20px;">
            Adalah pasangan Suami Istri berdasarkan surat pengantar dari RT/RW.
        </p>
        <p class="isi-surat">
            Surat keterangan ini diperlukan untuk: <b><?= html_escape($surat->keperluan); ?></b>
        </p>

        <p class="isi-surat" style="text-indent: 20px;">
            Apabila pernyataan dan pengakuan pemohon tidak benar, melanggar peraturan dan ketentuan yang berlaku sepenuhnya menjadi tanggung jawab pemohon, dan membebaskan para saksi RT/RW dan Lurah yang turut menandatangani surat keterangan ini dari segala tuntutan hukum.
        </p>

        <div class="closing-section">
            <div class="ttd-box ttd-left">
                <p>Pemohon,</p>
                <br><br><br><br>
                <p class="ttd-name">( <?= html_escape(strtoupper($surat->nama_pihak_satu)); ?> )</p>
            </div>
            <div class="ttd-box ttd-right">
                <p>
                    Kademangan, <?= date('d F Y'); ?><br>
                    a.n. Lurah Kademangan<br>
                    Sekretaris Kelurahan
                </p>
                <br><br><br>
                <p class="ttd-name">NAMA SEKRETARIS LURAH</p>
                <p>NIP. NIP SEKRETARIS LURAH</p>
            </div>
        </div>

    </div>
</body>

</html>