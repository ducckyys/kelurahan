-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 04:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

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
  `id_berita` int(11) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `slug_berita` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `kategori` enum('Kegiatan','Pengumuman','Layanan','Umum') NOT NULL DEFAULT 'Umum',
  `gambar` varchar(100) NOT NULL,
  `tgl_publish` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `slug_berita`, `isi_berita`, `kategori`, `gambar`, `tgl_publish`, `id_user`) VALUES
(1, 'Acara layang-layang', 'acara-layang-layang', 'bermain layangan', 'Kegiatan', '925b93067fb00b3386421441bab5049b.png', '2025-09-12 11:11:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `judul_foto` varchar(255) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `tgl_upload` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `foto`, `tgl_upload`, `id_user`) VALUES
(1, 'BATAN INDAH', 'b048a6f2e0e691777c3fa123b2f7ccdd.jpg', '2025-09-12 11:12:18', 1),
(2, 'AMARAPURA', 'fc837a5294ceda5a4b8319e71be4e02e.jpg', '2025-09-15 21:42:47', 1),
(3, 'PALEM SERPONG INDAH', '38d89f44014349adec8cbbc56009c1cf.jpg', '2025-09-15 21:43:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_informasi` int(11) NOT NULL,
  `judul_informasi` varchar(255) NOT NULL,
  `isi_informasi` text NOT NULL,
  `kategori` enum('Pengumuman','Peraturan','Unduhan') NOT NULL,
  `tgl_publish` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_informasi`, `judul_informasi`, `isi_informasi`, `kategori`, `tgl_publish`, `id_user`) VALUES
(1, 'Test pengumuman', 'testing', 'Pengumuman', '2025-09-12 11:11:25', 1),
(2, 'Surat Izin Usaha', 'harus bawa gerobaknya', 'Peraturan', '2025-09-15 15:09:05', 1),
(3, 'Surat Izin Usaha', 'download dulu', 'Unduhan', '2025-09-15 15:09:23', 1),
(4, 'libur', 'mantap', 'Pengumuman', '2025-09-15 15:10:17', 1),
(5, 'Surat Izin Usaha', 'WAJIB OMSET DIATAS 600JUTA/BULAN', 'Peraturan', '2025-09-16 16:29:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Superadmin'),
(2, 'Admin/Staff');

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_bekerja`
--

CREATE TABLE `surat_belum_bekerja` (
  `id` int(11) NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `nik` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `warganegara` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `keperluan` text NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_bekerja`
--

INSERT INTO `surat_belum_bekerja` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `telepon_pemohon`, `warganegara`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, '089/SP/RT.003/IX/2025', '2025-09-24', '38ac22442f2fee9a0c5670d20e1682c6.pdf', NULL, 'Andrian fakih', 'Jakarta', '2025-09-24', 'Laki-laki', '3171070901010006', '089514353271', 'Indonesia', 'Islamm', 'Karyawan Swasta', 'Ciledug', 'Pengajuan Beasiswa Kuliah', 'Pending', '2025-09-24 12:42:15', '2025-09-24 16:46:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_memiliki_rumah`
--

CREATE TABLE `surat_belum_memiliki_rumah` (
  `id` int(11) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `kewarganegaraan` varchar(100) NOT NULL DEFAULT 'Indonesia',
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `keperluan` text NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_memiliki_rumah`
--

INSERT INTO `surat_belum_memiliki_rumah` (`id`, `nama_pemohon`, `nik`, `telepon_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andrian fakih', '3171070901010006', '089514353271', 'Jakarta', '2025-09-24', 'Laki-laki', 'Indonesia', 'Islamm', 'Karyawan Swasta', 'ciledug', 'Pengajuan Beasiswa Kuliah', '089/SP/RT.003/IX/2025', '2025-09-24', '775766a94b9f3f9d56b111701b2626f2.pdf', NULL, 'Pending', '2025-09-24 13:15:05', '2025-09-24 16:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `surat_domisili_yayasan`
--

CREATE TABLE `surat_domisili_yayasan` (
  `id` int(11) NOT NULL,
  `nama_penanggung_jawab` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `kewarganegaraan` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `alamat_pemohon` text NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `jenis_kegiatan` varchar(100) NOT NULL,
  `alamat_kantor` text NOT NULL,
  `jumlah_pengurus` int(11) NOT NULL,
  `nama_notaris_pendirian` varchar(100) NOT NULL,
  `nomor_akta_pendirian` varchar(50) NOT NULL,
  `tanggal_akta_pendirian` date NOT NULL,
  `nama_notaris_perubahan` varchar(100) DEFAULT NULL,
  `nomor_akta_perubahan` varchar(50) DEFAULT NULL,
  `tanggal_akta_perubahan` date DEFAULT NULL,
  `npwp` varchar(50) NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_domisili_yayasan`
--

INSERT INTO `surat_domisili_yayasan` (`id`, `nama_penanggung_jawab`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `alamat_pemohon`, `nama_organisasi`, `jenis_kegiatan`, `alamat_kantor`, `jumlah_pengurus`, `nama_notaris_pendirian`, `nomor_akta_pendirian`, `tanggal_akta_pendirian`, `nama_notaris_perubahan`, `nomor_akta_perubahan`, `tanggal_akta_perubahan`, `npwp`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, 'HERLINA MUSTIKASARI ROTI', 'Tangerang Selatan', '2025-09-24', '3674076710970001', '089514353271', 'Laki-laki', 'Indonesia', 'Islamm', 'Ciledug', 'YAYASAN MENATA RUMAH KITA BERSAMA', 'Bidang Sosial dan Pendidikan', 'Ciledug', 14, 'Not. Dr Udin Nasrudin', '106', '2025-09-24', 'Not. Dr Udin Nasrudin', '09', '2025-09-24', '31.190.787.7-411.000', '089/SP/RT.003/IX/2025', '2025-09-24', '7c8f4190754b4851554d27d2bb692436.pdf', NULL, 'Pending', '2025-09-24 12:45:48', '2025-09-24 16:46:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian`
--

CREATE TABLE `surat_kematian` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `hari_meninggal` varchar(20) NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `jam_meninggal` time NOT NULL,
  `tempat_meninggal` varchar(150) NOT NULL,
  `sebab_meninggal` varchar(200) NOT NULL,
  `tempat_pemakaman` varchar(200) NOT NULL,
  `pelapor_nama` varchar(255) NOT NULL,
  `pelapor_tempat_lahir` varchar(100) NOT NULL,
  `pelapor_tanggal_lahir` date NOT NULL,
  `pelapor_agama` varchar(50) NOT NULL,
  `pelapor_pekerjaan` varchar(150) NOT NULL,
  `pelapor_nik` varchar(16) NOT NULL,
  `pelapor_no_telepon` varchar(30) NOT NULL,
  `pelapor_alamat` text NOT NULL,
  `pelapor_hubungan` varchar(50) NOT NULL,
  `nomor_surat_rt` varchar(100) DEFAULT NULL,
  `tanggal_surat_rt` date DEFAULT NULL,
  `scan_surat_rt` varchar(255) DEFAULT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_kematian`
--

INSERT INTO `surat_kematian` (`id`, `nama`, `nik`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `agama`, `pekerjaan`, `alamat`, `hari_meninggal`, `tanggal_meninggal`, `jam_meninggal`, `tempat_meninggal`, `sebab_meninggal`, `tempat_pemakaman`, `pelapor_nama`, `pelapor_tempat_lahir`, `pelapor_tanggal_lahir`, `pelapor_agama`, `pelapor_pekerjaan`, `pelapor_nik`, `pelapor_no_telepon`, `pelapor_alamat`, `pelapor_hubungan`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(0, 'Andrian fakih', '3171070901010006', 'Laki-laki', 'Tangerang Selatan', '2025-09-24', 'Islamm', 'Karyawan Swasta', 'Ciledug', 'Jumat', '2025-09-24', '21:48:00', 'Rumah', 'Sakit', 'TPU Kademangan', 'Andrian fakih', 'Tangerang', '2025-09-24', 'Islam', 'Wirasuasta', '3674074808151001', '089514353271', 'Ciledug', 'Kerabat', '089/SP/RT.003/IX/2025', '2025-09-24', '5bfe61419b1f239023672289bd5ed7c5.pdf', NULL, 'Pending', '2025-09-24 13:49:21', '2025-09-24 16:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian_nondukcapil`
--

CREATE TABLE `surat_kematian_nondukcapil` (
  `id` int(11) NOT NULL,
  `nama_ahli_waris` varchar(255) NOT NULL,
  `nik_ahli_waris` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat_ahli_waris` text NOT NULL,
  `hubungan_ahli_waris` varchar(100) NOT NULL,
  `nama_almarhum` varchar(255) NOT NULL,
  `nik_almarhum` varchar(16) NOT NULL,
  `tempat_meninggal` varchar(255) NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `alamat_almarhum` text NOT NULL,
  `keterangan_almarhum` varchar(255) DEFAULT NULL COMMENT 'Contoh: Ibu Kandung, Ayah Kandung, dll.',
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `keperluan` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_kematian_nondukcapil`
--

INSERT INTO `surat_kematian_nondukcapil` (`id`, `nama_ahli_waris`, `nik_ahli_waris`, `telepon_pemohon`, `jenis_kelamin`, `alamat_ahli_waris`, `hubungan_ahli_waris`, `nama_almarhum`, `nik_almarhum`, `tempat_meninggal`, `tanggal_meninggal`, `alamat_almarhum`, `keterangan_almarhum`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `keperluan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Andrian fakih', '3171090101010006', '081328000052', 'Laki-laki', 'Ciledug', 'Anak Kandung', 'Andrian fakih', '3171090101010006', 'Rumah', '2025-09-24', 'Ciledug', 'Ayah Kandung', '089/SP/RT.003/IX/2025', '2025-09-24', '133a5cc84ad4ed379dd492f3fa42b629.pdf', NULL, 'Pengajuan Beasiswa Kuliah', 'Pending', '2025-09-24 13:59:16', '2025-09-24 16:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_suami_istri`
--

CREATE TABLE `surat_keterangan_suami_istri` (
  `id` int(11) NOT NULL,
  `nama_pihak_satu` varchar(255) NOT NULL,
  `nik_pihak_satu` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `tempat_lahir_pihak_satu` varchar(100) NOT NULL,
  `tanggal_lahir_pihak_satu` date NOT NULL,
  `jenis_kelamin_pihak_satu` enum('Laki-laki','Perempuan') NOT NULL,
  `agama_pihak_satu` varchar(50) NOT NULL,
  `pekerjaan_pihak_satu` varchar(100) NOT NULL,
  `warganegara_pihak_satu` varchar(100) NOT NULL,
  `alamat_pihak_satu` text NOT NULL,
  `nama_pihak_dua` varchar(255) NOT NULL,
  `nik_pihak_dua` varchar(16) NOT NULL,
  `alamat_pihak_dua` text NOT NULL,
  `keperluan` text NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL COMMENT 'Nama file hasil upload',
  `nomor_surat` varchar(100) DEFAULT NULL COMMENT 'Diisi oleh admin saat surat diterbitkan',
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_keterangan_suami_istri`
--

INSERT INTO `surat_keterangan_suami_istri` (`id`, `nama_pihak_satu`, `nik_pihak_satu`, `telepon_pemohon`, `tempat_lahir_pihak_satu`, `tanggal_lahir_pihak_satu`, `jenis_kelamin_pihak_satu`, `agama_pihak_satu`, `pekerjaan_pihak_satu`, `warganegara_pihak_satu`, `alamat_pihak_satu`, `nama_pihak_dua`, `nik_pihak_dua`, `alamat_pihak_dua`, `keperluan`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `status`, `created_at`, `updated_at`) VALUES
(1, 'andrian fakih', '3171070901010006', '089514353271', 'Tangerang Selatan', '2025-09-24', 'Laki-laki', 'Islamm', 'Mahasiswa', 'Indonesia', 'Tangerang selatan', 'Nayla Rabiatul Hanifa', '3171070901010006', 'Depok', 'Persyaratan Pengajuan KPR', '089/SP/RT.003/IX/2025', '2025-09-24', '4c638b245c19df43f046cfeee92ffc0c.pdf', NULL, 'Pending', '2025-09-24 14:07:22', '2025-09-24 17:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` int(11) NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(255) NOT NULL,
  `nomor_surat` varchar(100) DEFAULT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) NOT NULL,
  `telepon_pemohon` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `warganegara` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `nama_orang_tua` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_dtks` varchar(50) DEFAULT NULL,
  `penghasilan_bulanan` varchar(100) NOT NULL,
  `keperluan` text NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(8, '089/SP/RT.003/IX/2025', '2025-09-24', 'd517149a19ab8ff9c360a1c797d4b91f.pdf', NULL, 'Andrian fakih', 'Bogor', '2025-09-24', '3171070901010006', '6285174103802', 'Laki-laki', 'Indonesia', 'Islamm', 'Karyawan Swasta', 'MAYANG WIDARAPURI', 'Ciledug', 'Belum Terdaftar', 'Kurang dari Rp 1.000.000', 'Pengajuan Beasiswa Kuliah', 'Disetujui', '2025-09-24 14:32:18', '2025-09-25 02:11:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploadvideo`
--

CREATE TABLE `uploadvideo` (
  `id_konfigurasi` int(11) NOT NULL,
  `nama_konfigurasi` varchar(100) NOT NULL,
  `nilai_konfigurasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploadvideo`
--

INSERT INTO `uploadvideo` (`id_konfigurasi`, `nama_konfigurasi`, `nilai_konfigurasi`) VALUES
(1, 'youtube_link', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `id_level` int(11) NOT NULL
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
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_informasi`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

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
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
