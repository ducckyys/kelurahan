<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/fonts.min.css'); ?>">

    <style>
        /* ==== Kertas F4 & margin cetak ==== */
        @page {
            size: 210mm 330mm;
            /* F4/Folio */
            margin: 8mm;
            /* dipersempit agar muat 1 halaman */
        }

        :root {
            /* header dikompakkan sedikit */
            --header-height: 42mm;
            --gap-after-header: 4mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            /* sedikit lebih kecil */
            line-height: 1.28;
            /* default lebih rapat */
        }

        #header {
            position: fixed;
            top: 8mm;
            /* selaras @page margin baru */
            left: 8mm;
            right: 8mm;
        }

        .kop-surat-wrapper {
            border-bottom: 2.5px solid #000;
            padding-bottom: 1.5px;
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
            width: 26mm;
        }

        .kop-logo img {
            width: 32mm;
            /* sedikit diperkecil */
            height: auto;
            margin-left: 3mm;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text p {
            margin: 1px 0;
        }

        .kop-text .line1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line2 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line3 {
            font-size: 22pt;
            font-weight: bold;
            margin: 0;
        }

        .kop-text .line4 {
            font-size: 8.5pt;
        }

        .contact-info {
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
        }

        .contact-info span {
            margin: 0 5px;
        }

        #content {
            padding-top: calc(var(--header-height) + var(--gap-after-header));
            padding-left: 0.8in;
            /* kiri/kanan sedikit dipersempit */
            padding-right: 0.8in;
            padding-bottom: 5mm;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13pt;
            /* sedikit diperkecil */
            margin: 6px 0 3px 0;
        }

        .nomor-surat {
            text-align: center;
            margin: 0 0 6px 0;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.25;
            /* konten utama lebih padat */
            margin: 0;
        }

        .isi-surat.pembuka {
            text-indent: 11mm;
            line-height: 1.22;
            margin: 0.18in 0 8px 0;
        }

        .data-pemohon {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 8px 0;
            font-size: 11.5pt;
        }

        .data-pemohon td {
            padding: 1.5px 0;
            /* padding baris lebih tipis */
            vertical-align: top;
        }

        .data-pemohon td:first-child {
            width: 50mm;
        }

        .data-pemohon td:nth-child(2) {
            width: 5mm;
            text-align: center;
        }

        .closing-section {
            page-break-inside: avoid;
            clear: both;
        }

        .ttd {
            width: 68mm;
            /* agak sempit supaya hemat ruang */
            float: right;
            text-align: center;
        }

        .ttd p {
            margin: 1.5px 0;
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
        <p class="judul-surat">SURAT KETERANGAN KEMATIAN</p>
        <p class="nomor-surat">Nomor: <?= html_escape($surat->nomor_surat) ?: '.................................'; ?></p>

        <?php
        // BLOK PENANDATANGAN (STATIS)
        $ttd_nama = 'Nama Sekretaris Kelurahan';
        $ttd_nip  = 'NIP Sekretaris Kelurahan';
        $ttd_jab  = 'Sekretaris Kelurahan';
        ?>
        <p class="isi-surat pembuka">Yang bertanda tangan di bawah ini :</p>
        <table class="data-pemohon">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= $ttd_nama; ?></b></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $ttd_nip; ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $ttd_jab; ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Berdasarkan Surat Pengantar RT/RW Nomor: <b><?= html_escape($surat->nomor_surat_rt ?? '-'); ?></b>
            tanggal <b><?= !empty($surat->tanggal_surat_rt) ? date('d F Y', strtotime($surat->tanggal_surat_rt)) : '-'; ?></b>, menyatakan dengan sebenar-benarnya bahwa :
        </p>

        <!-- Data Almarhum/Almarhumah -->
        <table class="data-pemohon">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama)); ?></b></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= html_escape($surat->nik); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kelamin); ?></td>
            </tr>
            <tr>
                <td>Tempat Tanggal Lahir</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_lahir); ?>, <?= date('d-m-Y', strtotime($surat->tanggal_lahir)); ?></td>
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
                <td>Alamat</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">Telah meninggal dunia pada:</p>
        <table class="data-pemohon">
            <tr>
                <td>Hari/Tanggal</td>
                <td>:</td>
                <td><?= html_escape($surat->hari_meninggal); ?>, <?= date('d F Y', strtotime($surat->tanggal_meninggal)); ?></td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>:</td>
                <td><?= html_escape($surat->jam_meninggal); ?> WIB</td>
            </tr>
            <tr>
                <td>Tempat Meninggal</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_meninggal); ?></td>
            </tr>
            <tr>
                <td>Disebabkan Karena</td>
                <td>:</td>
                <td><?= html_escape($surat->sebab_meninggal); ?></td>
            </tr>
            <tr>
                <td>Tempat Pemakaman</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_pemakaman); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">Surat keterangan ini dibuat berdasarkan keterangan Pelapor:</p>

        <!-- Data Pelapor -->
        <table class="data-pemohon">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_nama); ?></td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_tempat_lahir); ?>, <?= date('d-m-Y', strtotime($surat->pelapor_tanggal_lahir)); ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_agama); ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_pekerjaan); ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_nik); ?></td>
            </tr>
            <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_no_telepon); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_alamat); ?></td>
            </tr>
            <tr>
                <td>Hubungan dengan Almarhum/ah</td>
                <td>:</td>
                <td><?= html_escape($surat->pelapor_hubungan); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Demikian surat keterangan ini dibuat agar yang berkepentingan mengetahui dan dapat digunakan sebagaimana mestinya.
        </p>

        <div class="closing-section">
            <div class="ttd">
                <p>
                    Tangerang Selatan, <?= date('d F Y'); ?><br>
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