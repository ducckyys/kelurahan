<?php
defined('BASEPATH') or exit('No direct script access allowed');

$e = function ($v) {
    return htmlspecialchars((string)$v ?? '', ENT_QUOTES, 'UTF-8');
};
function tgl_indo($date)
{
    if (!$date || $date === '0000-00-00') return '-';
    $ts = is_numeric($date) ? (int)$date : strtotime($date);
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

/* Status pria untuk sub-poin a. */
$teksStatusPria = $surat->pria_status === 'Beristri'
    ? 'Beristri' . ($surat->pria_istri_ke ? ' (istri ke-' . $e($surat->pria_istri_ke) . ')' : '')
    : $e($surat->pria_status);

/* Data penandatangan dari controller */
$namaTtd = $ttd->nama ?? '.....................';
$nipTtd  = $ttd->nip  ?? '...............................';
$jabTtd  = $ttd->jabatan_nama ?? 'Sekretaris Kelurahan';
$isLurah = isset($ttd->jabatan_nama) && stripos($ttd->jabatan_nama, 'Lurah') === 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $e($title ?? 'Cetak Pengantar Nikah') ?></title>
    <style>
        /* ===== Kertas F4 portrait ===== */
        @page {
            size: 215mm 330mm;
            margin: 14mm 14mm 14mm 20mm;
        }

        html,
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11.3pt;
            color: #000;
            line-height: 1.32;
        }

        h1,
        h2,
        h3,
        h4,
        p {
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
        }

        /* Header */
        .header {
            position: relative;
            margin-bottom: 4mm;
        }

        .header .title {
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .2px;
        }

        .header .model {
            position: absolute;
            right: 0;
            top: -4mm;
            font-size: 9pt;
        }

        .kop {
            margin-top: 2mm;
            margin-bottom: 3mm;
            width: 92mm;
        }

        .kop table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop td {
            padding: .45mm 0;
            vertical-align: top;
        }

        .kop .lbl {
            width: 44mm;
        }

        .kop .sep {
            width: 3mm;
            text-align: center;
        }

        .section-title {
            text-align: center;
            font-weight: 700;
            margin: 1.5mm 0 2mm 0;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 3mm;
        }

        .nomor-table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        .nomor-table td {
            padding: 0 1.2mm;
            vertical-align: baseline;
        }

        .nomor-table .lbl {
            font-weight: 700;
            white-space: nowrap;
        }

        .nomor-table .sep {
            width: 3mm;
            text-align: center;
        }

        .nomor-table .val {
            white-space: nowrap;
        }

        /* Isi bernomor */
        .par {
            text-align: justify;
            margin-bottom: 1.6mm;
        }

        .listing {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: .8mm;
        }

        .listing td {
            padding: .32mm 0;
            vertical-align: top;
        }

        .listing .no {
            width: 7mm;
        }

        .listing .lbl {
            width: 66mm;
            white-space: nowrap;
        }

        .listing .sep {
            width: 3mm;
            text-align: center;
        }

        .subnote-table {
            margin-left: 9mm;
            margin-bottom: 1mm;
            border-collapse: collapse;
            width: auto;
        }

        .subnote-table td {
            padding: 0 .5mm 0 0;
            vertical-align: top;
        }

        .subnote-table .letter {
            width: 7mm;
        }

        /* FOOTER: 2 kotak, kanan untuk TTD */
        .footer {
            margin-top: 4mm;
            page-break-inside: avoid;
        }

        .ttd-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 1mm 0;
            table-layout: fixed;
            page-break-inside: avoid;
        }

        .ttd-table td {
            vertical-align: top;
            padding: 0;
        }

        .ttd-left {
            width: 60%;
        }

        .ttd-right {
            width: 40%;
        }

        .box {
            border: none;
            /* sebelumnya: 1px dashed #000 */
            border-radius: 0;
            /* hilangkan sudut kotak */
            width: 100%;
            height: 42mm;
            page-break-inside: avoid;
            padding: 2mm 3mm;
        }

        .box {
            border: none;
            border-radius: 0;
            width: 100%;
            height: 42mm;
            page-break-inside: avoid;
            padding: 2mm 3mm;
        }

        .box-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .box-table .head td {
            text-align: center;
            padding-top: 3mm;
            line-height: 1.2;
        }

        .box-table .spacer td {
            height: 18mm;
        }

        .box-table .sign td {
            text-align: center;
            padding-bottom: 3mm;
        }

        .box-table .sign .nama {
            font-weight: 700;
            white-space: nowrap;
            word-break: keep-all;
        }

        .note {
            font-size: 9pt;
            margin-top: 4mm;
        }
    </style>
</head>

<body>
    <div class="page">

        <div class="header">
            <div class="title">FORMULIR PENGANTAR NIKAH</div>
            <div class="model">Model N1</div>
            <div class="kop">
                <table>
                    <tr>
                        <td class="lbl">KANTOR KELURAHAN</td>
                        <td class="sep">:</td>
                        <td><?= $e($kelurahan) ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">KECAMATAN</td>
                        <td class="sep">:</td>
                        <td><?= $e($kecamatan) ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">KOTA</td>
                        <td class="sep">:</td>
                        <td><?= $e($kota) ?></td>
                    </tr>
                </table>
            </div>

            <div class="section-title">PENGANTAR NIKAH</div>
            <div class="nomor">
                <table class="nomor-table">
                    <tr>
                        <td class="lbl">Nomor</td>
                        <td class="sep">:</td>
                        <td class="val"><?= $e($surat->nomor_surat) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <p class="par">Yang bertanda tangan di bawah ini menjelaskan dengan sesungguhnya bahwa :</p>

        <table class="listing">
            <tr>
                <td class="no">1.</td>
                <td class="lbl">Nama</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_nama) ?></td>
            </tr>
            <tr>
                <td class="no">2.</td>
                <td class="lbl">Nomor Induk Kependudukan (NIK)</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_nik) ?></td>
            </tr>
            <tr>
                <td class="no">3.</td>
                <td class="lbl">Jenis Kelamin</td>
                <td class="sep">:</td>
                <td>Laki-laki</td>
            </tr>
            <tr>
                <td class="no">4.</td>
                <td class="lbl">Tempat dan tanggal lahir</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_tempat_lahir) ?>, <?= tgl_indo($surat->pria_tanggal_lahir) ?></td>
            </tr>
            <tr>
                <td class="no">5.</td>
                <td class="lbl">Kewarganegaraan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_kewarganegaraan) ?></td>
            </tr>
            <tr>
                <td class="no">6.</td>
                <td class="lbl">Agama</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_agama) ?></td>
            </tr>
            <tr>
                <td class="no">7.</td>
                <td class="lbl">Pekerjaan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->pria_pekerjaan) ?></td>
            </tr>
            <tr>
                <td class="no">8.</td>
                <td class="lbl">Alamat</td>
                <td class="sep">:</td>
                <td><?= nl2br($e($surat->pria_alamat)) ?></td>
            </tr>
        </table>

        <table class="listing">
            <tr>
                <td class="no">9.</td>
                <td class="lbl">Status Pernikahan</td>
                <td class="sep">:</td>
                <td>Belum kawin</td>
            </tr>
        </table>

        <!-- Sub-poin a & b -->
        <table class="subnote-table">
            <tr>
                <td class="letter">a.</td>
                <td>Laki-laki : Jejaka, Duda, atau beristri ke : <strong><?= $teksStatusPria ?></strong></td>
            </tr>
            <tr>
                <td class="letter">b.</td>
                <td>Perempuan : Perawan, Janda : <strong><?= $e($surat->wanita_status) ?></strong></td>
            </tr>
        </table>

        <p class="par">Adalah benar anak dari pernikahan seorang pria :</p>

        <table class="listing">
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Nama Lengkap dan alias</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_nama) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Nomor Induk Kependudukan (NIK)</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_nik ?: '-') ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Tempat dan tanggal lahir</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_tempat_lahir ?: '-') ?><?= $surat->ortu_tanggal_lahir ? ', ' . tgl_indo($surat->ortu_tanggal_lahir) : '' ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Kewarganegaraan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_kewarganegaraan ?: 'Indonesia') ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Agama</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_agama ?: '-') ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Pekerjaan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->ortu_pekerjaan ?: '-') ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Alamat</td>
                <td class="sep">:</td>
                <td><?= nl2br($e($surat->ortu_alamat ?: '-')) ?></td>
            </tr>
        </table>

        <p class="par">Dengan seorang wanita :</p>

        <table class="listing">
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Nama Lengkap dan alias</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_nama) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Nomor Induk Kependudukan (NIK)</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_nik) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Tempat dan tanggal lahir</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_tempat_lahir) ?>, <?= tgl_indo($surat->wanita_tanggal_lahir) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Kewarganegaraan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_kewarganegaraan) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Agama</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_agama) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Pekerjaan</td>
                <td class="sep">:</td>
                <td><?= $e($surat->wanita_pekerjaan) ?></td>
            </tr>
            <tr>
                <td class="no">&nbsp;</td>
                <td class="lbl">Alamat</td>
                <td class="sep">:</td>
                <td><?= nl2br($e($surat->wanita_alamat)) ?></td>
            </tr>
        </table>

        <!-- Footer: dua kotak (kiri kosong, kanan berisi) -->
        <div class="footer">
            <table class="ttd-table">
                <colgroup>
                    <col class="ttd-left">
                    <col class="ttd-right">
                </colgroup>
                <tr>
                    <td>
                        <div class="box"></div>
                    </td>
                    <td>
                        <div class="box">
                            <table class="box-table">
                                <tr class="head">
                                    <td>
                                        <?= $e(ucwords(strtolower($kelurahan))) ?>, <?= tgl_indo($tgl_cetak) ?><br>
                                        <?= $isLurah ? 'Lurah' : ($e($jabTtd)) ?>
                                    </td>
                                </tr>
                                <tr class="spacer">
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="sign">
                                    <td>
                                        <div class="nama"><?= $e(strtoupper($namaTtd)) ?></div>
                                        <div class="nip">NIP. <?= $e($nipTtd) ?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="note">*) nama lengkap</div>

    </div>
</body>

</html>