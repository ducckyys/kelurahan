-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 29, 2025 at 03:16 AM
-- Server version: 8.4.3
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kelurahan`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int UNSIGNED NOT NULL,
  `judul_berita` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug_berita` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_berita` text COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('Kegiatan','Pengumuman','Layanan','Umum') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Umum',
  `gambar` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coverage_stats`
--

CREATE TABLE `coverage_stats` (
  `id` int NOT NULL,
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `jumlah_penduduk` int NOT NULL DEFAULT '0',
  `jumlah_rw` int NOT NULL DEFAULT '0',
  `jumlah_rt` int NOT NULL DEFAULT '0',
  `icon_kk` varchar(255) DEFAULT NULL,
  `icon_penduduk` varchar(255) DEFAULT NULL,
  `icon_rw` varchar(255) DEFAULT NULL,
  `icon_rt` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `coverage_stats`
--

INSERT INTO `coverage_stats` (`id`, `jumlah_kk`, `jumlah_penduduk`, `jumlah_rw`, `jumlah_rt`, `icon_kk`, `icon_penduduk`, `icon_rw`, `icon_rt`, `updated_at`) VALUES
(1, 7884, 25724, 9, 68, 'f7f56dd8d5606b770e6d45c28ace0b48.png', '840093522e323a13c38e0de648a2c894.png', 'c26d17d054ed729432dc6619a95e537d.png', 'd88d95bb4b96df198f06ed1c295aec93.png', '2025-10-09 20:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL,
  `judul_foto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int UNSIGNED NOT NULL,
  `judul` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `urut` int DEFAULT '0',
  `aktif` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int NOT NULL,
  `nama_level` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Superadmin'),
(2, 'Admin/Staff');

-- --------------------------------------------------------

--
-- Table structure for table `pejabat`
--

CREATE TABLE `pejabat` (
  `id` int UNSIGNED NOT NULL,
  `jabatan_id` int UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pejabat`
--

INSERT INTO `pejabat` (`id`, `jabatan_id`, `nama`, `nip`, `created_at`, `updated_at`) VALUES
(2, 1, 'Madsuki, S.H.', '196911051989121002', '2025-10-21 03:39:02', '2025-10-21 03:39:02'),
(3, 2, 'Muhammad Djupri, S.KOM., M.AK', '198507222011011012', '2025-10-21 03:44:43', '2025-10-21 03:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urut` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id`, `nama`, `urut`, `is_active`) VALUES
(1, 'Lurah', 1, 1),
(2, 'Sekretaris Kelurahan', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `running_texts`
--

CREATE TABLE `running_texts` (
  `id` int UNSIGNED NOT NULL,
  `position` enum('top','bottom') COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `direction` enum('left','right') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'left',
  `speed` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `running_texts`
--

INSERT INTO `running_texts` (`id`, `position`, `content`, `direction`, `speed`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'top', 'Selamat Datang di Website Resmi Kelurahan Kademangan | Layanan publik mudah, cepat, dan transparan!', 'left', 6, 0, '2025-10-06 15:12:40', '2025-10-06 21:13:55'),
(2, 'bottom', 'Hubungi kami melalui media sosial resmi Kelurahan Kademangan | Ikuti update kegiatan terbaru setiap minggu!', 'left', 5, 0, '2025-10-06 15:12:40', '2025-10-06 21:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int NOT NULL,
  `about_html` mediumtext COLLATE utf8mb4_unicode_ci,
  `related_links` mediumtext COLLATE utf8mb4_unicode_ci,
  `social_links` mediumtext COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `about_html`, `related_links`, `social_links`, `updated_at`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nunc nulla, tempor sit amet tortor ut, lobortis hendrerit nisi. Aliquam id finibus erat. Vivamus in finibus eros. Aenean ut pulvinar odio. Pellentesque tempor metus eget risus varius ultricies. Praesent elementum vitae nibh ut blandit. Curabitur convallis purus in nisi viverra, vel tempus dolor consectetur. Nam vitae orci et libero viverra cursus ultricies quis massa. Curabitur semper tellus magna, id venenatis leo tincidunt sit amet. Morbi at semper neque. Sed laoreet faucibus iaculis.', '[{\"title\":\"Pemerintah Kota Tangerang Selatan\",\"url\":\"https:\\/\\/www.tangerangselatankota.go.id\"},{\"title\":\"Kecamatan Setu Kota Tangerang Selatan\",\"url\":\"https:\\/\\/kecsetu.tangerangselatankota.go.id\"}]', '[{\"icon\":\"fa-youtube\",\"label\":\"@dsdabmbktangsel\",\"url\":\"https:\\/\\/www.youtube.com\\/channel\\/UCVNJNLQozN3NTdn1qZR05_A\"},{\"icon\":\"fa-x-twitter\",\"label\":\"@dsdabmbk\",\"url\":\"https:\\/\\/x.com\\/dsdabmbk\"},{\"icon\":\"fa-instagram\",\"label\":\"@kelurahan.kademangan\",\"url\":\"https:\\/\\/instagram.com\\/kelurahan.kademangan\"}]', '2025-10-15 04:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_bekerja`
--

CREATE TABLE `surat_belum_bekerja` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warganegara` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_bekerja`
--

INSERT INTO `surat_belum_bekerja` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `telepon_pemohon`, `warganegara`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, '089/SP/RT.003/IX/2025', '2025-10-21', '[\"623236e3b21073e8953ad2df389e2200.pdf\",\"84360d9d0cfca66efb59f625b2540a0c.pdf\",\"2ead290da9c75591ea789d6ac64f74a2.pdf\"]', '1234.3234423/sdfdsdf', 'Andrian fakih', 'Tangerang Selatan', '2025-10-21', 'Laki-laki', '3171070901010006', '089514353271', 'Indonesia', 'Islam', 'Karyawan Swasta', 'JAKARTA', 'Pengajuan Beasiswa Kuliah', 'Disetujui', '2025-10-21 07:22:37', '2025-10-27 01:51:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_memiliki_rumah`
--

CREATE TABLE `surat_belum_memiliki_rumah` (
  `id` int NOT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `kewarganegaraan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Indonesia',
  `agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_memiliki_rumah`
--

INSERT INTO `surat_belum_memiliki_rumah` (`id`, `nama_pemohon`, `nik`, `telepon_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andrian fakih', '3171070901010006', '089514353271', 'Tangerang Selatan', '2025-10-21', 'Laki-laki', 'Indonesia', 'Islam', 'Karyawan Swasta', 'JAKARTA', 'Persyaratan Pengajuan KPR', '089/SP/RT.003/IX/2025', '2025-10-21', '[\"71e7e25e0e420638bda8e10403a71090.pdf\",\"795199145607fa8b1727a0b8a2804745.pdf\",\"320a3b13579538ef852c6944bfb9641f.jpg\"]', '1234.3234423/sdfdsdf', 'Disetujui', '2025-10-21 07:49:03', '2025-10-21 07:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `surat_domisili_yayasan`
--

CREATE TABLE `surat_domisili_yayasan` (
  `id` int NOT NULL,
  `nama_penanggung_jawab` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `kewarganegaraan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pemohon` text COLLATE utf8mb4_general_ci NOT NULL,
  `nama_organisasi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kegiatan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_kantor` text COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_pengurus` int NOT NULL,
  `nama_notaris_pendirian` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_akta_pendirian` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_akta_pendirian` date NOT NULL,
  `nama_notaris_perubahan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_akta_perubahan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_akta_perubahan` date DEFAULT NULL,
  `npwp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_domisili_yayasan`
--

INSERT INTO `surat_domisili_yayasan` (`id`, `nama_penanggung_jawab`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `alamat_pemohon`, `nama_organisasi`, `jenis_kegiatan`, `alamat_kantor`, `jumlah_pengurus`, `nama_notaris_pendirian`, `nomor_akta_pendirian`, `tanggal_akta_pendirian`, `nama_notaris_perubahan`, `nomor_akta_perubahan`, `tanggal_akta_perubahan`, `npwp`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, 'HERLINA MUSTIKASARI ROTI', 'Tangerang Selatan', '2025-10-21', '3171070901010006', '089514353271', 'Laki-laki', 'Indonesia', 'Islam', 'Jakarta', 'YAYASAN MENATA RUMAH KITA BERSAMA', 'Bidang Sosial dan Pendidikan', 'Jakarta', 12, 'Not. Dr Udin Nasrudin', '106', '2025-10-21', 'Not. Dr Udin Nasrudin', '09', '2025-10-21', '31.190.787.7-411.000', '089/SP/RT.003/IX/2025', '2025-10-21', '[\"0416b296d2311e9f9802b5a3a396feab.pdf\",\"608ddcc9eb1d390b1a8cf30261aebc90.pdf\",\"5b20fb114832de81a360718252602527.pdf\"]', '1234.3234423/sdfdsdf', 'Disetujui', '2025-10-21 07:35:41', '2025-10-27 01:52:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian`
--

CREATE TABLE `surat_kematian` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `hari_meninggal` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `jam_meninggal` time NOT NULL,
  `tempat_meninggal` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `sebab_meninggal` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_pemakaman` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_tanggal_lahir` date NOT NULL,
  `pelapor_agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_pekerjaan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_no_telepon` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_hubungan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_surat_rt` date DEFAULT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_kematian`
--

INSERT INTO `surat_kematian` (`id`, `nama`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pekerjaan`, `alamat`, `hari_meninggal`, `tanggal_meninggal`, `jam_meninggal`, `tempat_meninggal`, `sebab_meninggal`, `tempat_pemakaman`, `pelapor_nama`, `pelapor_tempat_lahir`, `pelapor_tanggal_lahir`, `pelapor_agama`, `pelapor_pekerjaan`, `pelapor_nik`, `pelapor_no_telepon`, `pelapor_alamat`, `pelapor_hubungan`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andrian fakih', '3171070901010006', 'Laki-laki', 'Tangerang Selatan', '2025-10-21', 'Islam', 'Karyawan Swasta', 'JAKARTA', 'Jumat', '2025-10-21', '14:51:00', 'Rumah', 'Sakit', 'TPU Kademangan', 'Andrian fakih', 'Tangerang', '2025-10-21', 'Islam', 'Wirasuasta', '3674074808151001', '081329999444', 'JAKARTA', 'Kerabat', '089/SP/RT.003/IX/2025', '2025-10-21', '[\"605c546bfbcad3e5803ab01f79ac2b24.pdf\",\"8e2cabf7da5cd46246b414062bbd0361.pdf\",\"d4228b8fcd156d749e9e557ff26ebb97.pdf\"]', '1234.3234423/sdfdsdf', 'Disetujui', '2025-10-21 07:52:53', '2025-10-21 08:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian_nondukcapil`
--

CREATE TABLE `surat_kematian_nondukcapil` (
  `id` int NOT NULL,
  `nama_ahli_waris` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik_ahli_waris` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_ahli_waris` text COLLATE utf8mb4_general_ci NOT NULL,
  `hubungan_ahli_waris` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_almarhum` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik_almarhum` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_meninggal` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `alamat_almarhum` text COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan_almarhum` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Contoh: Ibu Kandung, Ayah Kandung, dll.',
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keperluan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_kematian_nondukcapil`
--

INSERT INTO `surat_kematian_nondukcapil` (`id`, `nama_ahli_waris`, `nik_ahli_waris`, `telepon_pemohon`, `jenis_kelamin`, `alamat_ahli_waris`, `hubungan_ahli_waris`, `nama_almarhum`, `nik_almarhum`, `tempat_meninggal`, `tanggal_meninggal`, `alamat_almarhum`, `keterangan_almarhum`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `keperluan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andrian fakih', '3171090101010006', '089514353271', 'Laki-laki', 'JAKARTA', 'Anak Kandung', 'Andrian fakih', '3171090101010006', 'Rumah', '2025-10-21', 'JAKARTA', 'Ayah Kandung', '089/SP/RT.003/IX/2025', '2025-10-21', '[\"0339d4e2f95bd0dae51109b5a9fc7013.pdf\",\"cd9fb375f47bf5b22950ae9fc6e6fa4c.pdf\",\"b5eb1ef023873ec7ef7c7dc6f604a329.pdf\"]', '1234.3234423/sdfdsdf', 'Administrasi', 'Disetujui', '2025-10-21 07:54:08', '2025-10-21 08:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_suami_istri`
--

CREATE TABLE `surat_keterangan_suami_istri` (
  `id` int NOT NULL,
  `nama_pihak_satu` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pihak_satu` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir_pihak_satu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir_pihak_satu` date NOT NULL,
  `jenis_kelamin_pihak_satu` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `agama_pihak_satu` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan_pihak_satu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `warganegara_pihak_satu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pihak_satu` text COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pihak_dua` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pihak_dua` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pihak_dua` text COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Diisi oleh admin saat surat diterbitkan',
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_keterangan_suami_istri`
--

INSERT INTO `surat_keterangan_suami_istri` (`id`, `nama_pihak_satu`, `nik_pihak_satu`, `telepon_pemohon`, `tempat_lahir_pihak_satu`, `tanggal_lahir_pihak_satu`, `jenis_kelamin_pihak_satu`, `agama_pihak_satu`, `pekerjaan_pihak_satu`, `warganegara_pihak_satu`, `alamat_pihak_satu`, `nama_pihak_dua`, `nik_pihak_dua`, `alamat_pihak_dua`, `keperluan`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'andrian fakih', '3171070901010006', '6285174103802', 'Tangerang Selatan', '2025-10-21', 'Laki-laki', 'Islam', 'Mahasiswa', 'Indonesia', 'JAKRTA', 'Nayla Rabiatul Hanifa', '3171070901010006', 'DEPOK', 'Persyaratan PIP', '089/SP/RT.003/IX/2025', '2025-10-21', '[\"b9e3877eb1c231c9f27b913a113e5602.pdf\",\"197d0e28624bb50107da16b5fc425fcc.pdf\",\"6c76ddb9d733f08954ef1113a5b89b36.pdf\"]', '1234.3234423/sdfdsdf', 'Disetujui', '2025-10-21 07:55:21', '2025-10-21 08:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengantar_nikah`
--

CREATE TABLE `surat_pengantar_nikah` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pria_nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Laki-laki',
  `pria_tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_tanggal_lahir` date NOT NULL,
  `pria_kewarganegaraan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pria_alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `pria_status` enum('Jejaka','Duda','Beristri') COLLATE utf8mb4_general_ci NOT NULL,
  `pria_istri_ke` tinyint UNSIGNED DEFAULT NULL,
  `ortu_nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `ortu_nik` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_tanggal_lahir` date DEFAULT NULL,
  `ortu_kewarganegaraan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Indonesia',
  `ortu_agama` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_alamat` text COLLATE utf8mb4_general_ci,
  `wanita_nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_tanggal_lahir` date NOT NULL,
  `wanita_kewarganegaraan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_status` enum('Perawan','Janda') COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_pengantar_nikah`
--

INSERT INTO `surat_pengantar_nikah` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `pria_nama`, `pria_nik`, `pria_jenis_kelamin`, `pria_tempat_lahir`, `pria_tanggal_lahir`, `pria_kewarganegaraan`, `pria_agama`, `pria_pekerjaan`, `pria_alamat`, `pria_status`, `pria_istri_ke`, `ortu_nama`, `ortu_nik`, `ortu_tempat_lahir`, `ortu_tanggal_lahir`, `ortu_kewarganegaraan`, `ortu_agama`, `ortu_pekerjaan`, `ortu_alamat`, `wanita_nama`, `wanita_nik`, `wanita_tempat_lahir`, `wanita_tanggal_lahir`, `wanita_kewarganegaraan`, `wanita_agama`, `wanita_pekerjaan`, `wanita_alamat`, `wanita_status`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, '089/SP/RT.003/IX/2025', '2025-10-21', '[\"6190d01b6498e9e39ce02586ad6d5983.pdf\",\"f5e8f0cfd7d9c6b3abe6c15eb10c5fc4.pdf\",\"6dab6c149fc28ee7a1fc6b27142a8157.pdf\"]', '1234.3234423/sdfdsdf', 'Andrian Fakih', '3171070901010006', 'Laki-laki', 'Jakarta', '2025-10-21', 'Indonesia', 'Islam', 'Karyawan Swasta', 'JAKARTA', 'Jejaka', NULL, 'Budi', '317107090101006', 'Kudus', '2025-10-21', 'Indonesia', 'Islam', 'Wiraswasta', 'JAKARTA', 'Nayla Rabiatul Hanifa', '3171070901010006', 'Depok', '2025-10-21', 'Indonesia', 'Islam', 'Karyawan Swasta', 'DEPOK', 'Perawan', 'Disetujui', '2025-10-21 07:56:48', '2025-10-21 08:35:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_penghasilan`
--

CREATE TABLE `surat_penghasilan` (
  `id` int UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warganegara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_penghasilan`
--

INSERT INTO `surat_penghasilan` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `telepon_pemohon`, `warganegara`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, '012/RT01/RW02/2025', '2025-10-01', '[\"65d1c823a8156b1249ba0135f4743deb.pdf\",\"c93caef4c68de1fd387c5068956abe08.pdf\",\"a5493f4aa418d7d0765dffc789da04b7.pdf\"]', '1234.3234423/sdfdsdf', 'Budi Santoso', 'Tangerang Selatan', '1995-12-05', 'Laki-laki', '3678123412341234', '081234567890', 'Indonesia', 'Islam', 'Karyawan Swasta', 'Jl. Melati No.10, RT 001/RW 002, Kel. Kademangan, Kec. Setu, Kota Tangerang Selatan, 15313', 'Persyaratan administrasi bantuan pendidikan', 'Disetujui', '2025-10-27 04:41:17', '2025-10-27 04:41:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `warganegara` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_orang_tua` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_dtks` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penghasilan_bulanan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, '089/SP/RT.003/IX/2025', '2025-10-21', '[\"de3b90a7d60dd7149dae4b0b4b43a167.pdf\",\"95a0715aed69d844136348f5e209eace.pdf\",\"2db855ea3ed5249d93c392fd9cb19675.pdf\"]', '1234.3234423/sdfdsdf', 'Andrian fakih', 'Tangerang Selatan', '2025-10-21', '3171070901010006', '089514353271', 'Laki-laki', 'Indonesia', 'Islam', 'Karyawan Swasta', 'MAYANG WIDARAPURI', 'CILEDUG', 'Belum Terdaftar', 'Kurang dari Rp 1.000.000', 'Pengajuan Beasiswa Kuliah', 'Disetujui', '2025-10-21 04:15:33', '2025-10-21 07:14:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploadvideo`
--

CREATE TABLE `uploadvideo` (
  `id_konfigurasi` int NOT NULL,
  `nama_konfigurasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_konfigurasi` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default.jpg',
  `id_level` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `foto`, `id_level`) VALUES
(1, 'Super Administrator', 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', '0b91ff0d41926dafe50999bf7c72a317.png', 1),
(4, 'Andrian Fakih', '19220532', '$2y$10$b5vRbZ5M3rj11uFp4fXi9.tUSLf2Dgym6jBzWRqJDughAWE1wwXUC', '0857a8f0032ecf8783494d5ed757cf9f.png', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `coverage_stats`
--
ALTER TABLE `coverage_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `pejabat`
--
ALTER TABLE `pejabat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pejabat_nip` (`nip`),
  ADD UNIQUE KEY `uq_pejabat_jabatan` (`jabatan_id`),
  ADD KEY `fk_pejabat_jabatan` (`jabatan_id`);

--
-- Indexes for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ref_jabatan_nama` (`nama`);

--
-- Indexes for table `running_texts`
--
ALTER TABLE `running_texts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pos_active` (`position`,`is_active`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pria_nik` (`pria_nik`),
  ADD KEY `idx_wanita_nik` (`wanita_nik`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coverage_stats`
--
ALTER TABLE `coverage_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pejabat`
--
ALTER TABLE `pejabat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `running_texts`
--
ALTER TABLE `running_texts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  MODIFY `id_konfigurasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pejabat`
--
ALTER TABLE `pejabat`
  ADD CONSTRAINT `fk_pejabat_jabatan` FOREIGN KEY (`jabatan_id`) REFERENCES `ref_jabatan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
