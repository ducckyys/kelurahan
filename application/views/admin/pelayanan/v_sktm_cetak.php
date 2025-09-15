<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 0;
        }

        .container {
            padding: 0in 0.3in;
        }

        /* --- PERBAIKAN: UBAH GARIS MENJADI DOUBLE --- */
        .kop-surat-image {
            width: 100%;
            margin-bottom: 20px;
            /* Ganti 'solid' menjadi 'double' dan atur ketebalan */
            border-bottom: 4px double #000;
            padding-bottom: 10px;
        }

        .kop-surat-image img {
            width: 100%;
            height: auto;
        }

        /* --- END PERBAIKAN --- */

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
            margin-top: 0px;
            margin-bottom: 25px;
        }

        .isi-surat {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 0.5em;
            /* Jarak bawah setiap paragraf dikurangi */
        }

        .isi-surat.pembuka {
            text-indent: 0.5in;
        }

        .data-pemohon {
            padding-left: 0.5in;
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
            margin-top: 30px;
        }

        .keperluan-section {
            margin-top: 0.5em;
            /* Jarak atas blok dikurangi */
            margin-bottom: 0.5em;
            /* Jarak bawah blok dikurangi */
        }

        .keperluan-data {
            padding-left: 0.5in;
            margin-top: 5px;
        }

        .keperluan-data .line-item {
            border-bottom: 1px dotted #000;
            font-weight: bold;
            text-align: center;
            padding: 2px 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat-image">
            <img src="<?= base_url('assets/img/kop_surat.png'); ?>" alt="Kop Surat Kelurahan">
        </div>

        <p class="judul-surat">SURAT KETERANGAN TIDAK MAMPU</p>
        <p class="nomor-surat">Nomor: 470 / <?= $surat->id; ?>-KDM / IX / <?= date('Y'); ?></p>

        <p class="isi-surat pembuka">Yang bertanda tangan di bawah ini Lurah Kademangan, Kecamatan Setu, Kota Tangerang Selatan, dengan ini menerangkan bahwa:</p>

        <table class="data-pemohon">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><b><?= html_escape(strtoupper($surat->nama_pemohon)); ?></b></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= html_escape($surat->jenis_kelamin_pemohon); ?></td>
            </tr>
            <tr>
                <td>Tempat/Tgl. Lahir</td>
                <td>:</td>
                <td><?= html_escape($surat->tempat_lahir_pemohon . ', ' . date('d F Y', strtotime($surat->tgl_lahir_pemohon))); ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= html_escape($surat->nik_pemohon); ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?= html_escape($surat->agama_pemohon); ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= html_escape($surat->pekerjaan_pemohon); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= html_escape($surat->alamat_pemohon); ?></td>
            </tr>
        </table>

        <p class="isi-surat pembuka">
            Bahwa nama tersebut di atas, adalah benar warga kami yang berdomisili di alamat tersebut dan berdasarkan data serta pengamatan kami, yang bersangkutan tergolong keluarga Pra-Sejahtera / Tidak Mampu.
        </p>

        <div class="keperluan-section">
            <p class="isi-surat">Surat keterangan ini dibuat untuk keperluan</p>
            <div class="keperluan-data">
                <div class="line-item">“ <?= html_escape($surat->keperluan); ?> ”</div>
            </div>
            <?php if (!empty($surat->atas_nama)): ?>
                <div class="keperluan-data" style="margin-top: 10px;">
                    <table>
                        <tr>
                            <td style="width: 100px;">Atas nama</td>
                            <td style="width: 20px; text-align: center;">:</td>
                            <td class="line-item" style="text-align: left; padding-left: 10px;"><?= html_escape(strtoupper($surat->atas_nama)); ?></td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="closing-section">
            <p class="isi-surat pembuka">
                Demikian Surat Pernyataan ini saya buat dengan sebenarnya dan akan saya pergunakan sebagaimana mestinya.
            </p>
            <div class="ttd">
                <p>Kademangan, <?= date('d F Y'); ?>
                    <br>
                    Lurah Kademangan
                </p>
                <br><br><br>
                <p style="text-decoration: underline; font-weight: bold;">NAMA LURAH ANDA</p>
                <p>NIP. NIP LURAH ANDA</p>
            </div>
        </div>

    </div>
</body>

</html>