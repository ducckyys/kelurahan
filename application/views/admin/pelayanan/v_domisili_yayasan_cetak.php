<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= html_escape($title); ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/fonts.min.css'); ?>">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        #header {
            position: fixed;
            top: 0.4in;
            left: 0.4in;
            right: 0.4in;
        }

        #content {
            padding-top: 2in;
            padding-left: 0.8in;
            padding-right: 0.8in;
            padding-bottom: 0.5in;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            z-index: -1000;
            font-size: 150pt;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.08);
            pointer-events: none;
        }

        .kop-surat-wrapper {
            border-bottom: 3px solid #000;
            /* Garis TEBAL di paling bawah */
            padding-bottom: 2px;
            /* Jarak antara dua garis */
        }

        .kop-table {
            width: 100%;
            border-bottom: 1px solid #000;
            /* Garis TIPIS di atas */
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 100px;
        }

        .kop-logo img {
            width: 140px;
            margin-left: 20px;
            height: auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text p {
            margin: 2px 0;
        }

        .kop-text .line1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0px;
        }

        .kop-text .line2 {
            font-size: 22pt;
            font-weight: bold;
            margin: 0px;
        }

        .kop-text .line3 {
            font-size: 28pt;
            font-weight: bold;
            margin: 0px;
        }

        .kop-text .line4 {
            font-size: 9pt;
        }

        .contact-info {
            font-family: Arial, sans-serif;
            font-size: 9pt
        }

        .contact-info span {
            margin: 0 7px;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        .nomor-surat {
            text-align: center;
            margin-top: 0in;
            margin-bottom: 0in;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.5;
        }

        .isi-surat.pembuka {
            text-indent: 0.5in;
            line-height: 1;
            margin-bottom: 1em;
        }

        .data-pemohon {
            padding-left: 0.5in;
            line-height: 1;
            margin: 15px 0;
        }

        .data-pemohon td {
            padding: 2px 0;
            vertical-align: top;
        }

        .data-pemohon td:first-child {
            width: 170px;
        }

        .data-pemohon td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .ttd {
            width: 40%;
            float: right;
            text-align: center;
            margin-top: 10px;
            line-height: 1;
        }

        .ttd p {
            margin: 1px 0;
            /* Mengurangi margin atas/bawah paragraf menjadi sangat kecil */
        }

        .closing-section {
            page-break-inside: avoid;
            margin-top: 10px;

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
                            <span><i class="fab fa-instagram"></i> kelurahan.kademangan</span>
                            <br>
                            <i class="fas fa-globe"></i> Website: http://kademangan.tangerangselatankota.go.id
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content">
        <p class="judul-surat">SURAT KETERANGAN</p>
        <p class="nomor-surat">Nomor : 145 / <?= str_repeat("&nbsp;", 10); ?> / Kel.Kdm/ <?= date('Y'); ?></p>

        <p class="isi-surat pembuka">Yang bertanda tangan di bawah ini Lurah Kademangan Kecamatan Setu Kota Tangerang Selatan dengan ini menerangkan bahwa :</p>

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

        <p class="isi-surat pembuka">Telah datang menghadap, melapor dan memohon surat keterangan, berdasarkan pernyataan dan dokumen pemohon, yang bersangkutan memiliki Yayasan dengan data Sebagai berikut:</p>

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

        <p class="isi-surat pembuka">Demikian surat keterangan ini dibuat, sesuai dengan data pemohon, apabila di kemudian hari keterangan atau pengakuan pemohon tidak benar, atau melanggar ketentuan yang berlaku sepenuhnya menjadi tanggung jawab pemohon tidak melibatkan pihak RT/RW dan Pejabat yang menandatangani surat keterangan ini.</p>

        <div class="closing-section">
            <div class="ttd">
                <p>Tangerang Selatan, <?= date('d F Y'); ?>
                    <br>Sesuai Permohonan Pemohon<br>Lurah
                </p>
                <br><br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">NAMA LURAH</p>
                <p>NIP. NIP LURAH</p>
            </div>
        </div>
    </div>
</body>

</html>