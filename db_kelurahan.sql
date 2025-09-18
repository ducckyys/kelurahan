-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 02:18 PM
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
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `nama_konfigurasi` varchar(100) NOT NULL,
  `nilai_konfigurasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `nama_konfigurasi`, `nilai_konfigurasi`) VALUES
(1, 'youtube_link', 'https://www.youtube.com/watch?v=Svzvf9_yQiY');

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
  `scan_surat_rt` varchar(100) NOT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `nik` varchar(20) NOT NULL,
  `warganegara` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_bekerja`
--

INSERT INTO `surat_belum_bekerja` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `warganegara`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `tgl_dibuat`, `id_user`) VALUES
(1, '014/RT.02/05/25', '2025-09-16', 'd90d01afb36e1056e36247627042e0f4.pdf', 'ASHIFA AYUNINGTIAS', 'Jakarta', '2025-09-16', 'Perempuan', '3674076710970001', 'Indonesia', 'Islam', 'Karyawan Swasta', 'Perum Amarapura Blok F-3/6 RT 002/005 Kel. Kademangan  Kecamatan Setu Kota Tangerang Selatan\r\n', 'Persyaratan Pengajuan KPR', '2025-09-16 13:37:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_memiliki_rumah`
--

CREATE TABLE `surat_belum_memiliki_rumah` (
  `id` int(11) NOT NULL,
  `nama_pemohon` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_belum_memiliki_rumah`
--

INSERT INTO `surat_belum_memiliki_rumah` (`id`, `nama_pemohon`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `created_at`) VALUES
(1, 'Andrian fakih', '3171070901010006', 'Jakarta', '2025-09-18', 'Laki-laki', 'Indonesia', 'Islam', 'Pelajar/mahasiswa', 'CIledug', 'Pengajuan Beasiswa Kuliah', '089/SP/RT.003/IX/2025', '2025-09-18', '7cc844d7e8fcd817b5e5d92b602c8f00.pdf', '2025-09-18 07:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `surat_domisili_yayasan`
--

CREATE TABLE `surat_domisili_yayasan` (
  `id` int(11) NOT NULL,
  `nama_penanggung_jawab` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(20) NOT NULL,
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
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_domisili_yayasan`
--

INSERT INTO `surat_domisili_yayasan` (`id`, `nama_penanggung_jawab`, `tempat_lahir`, `tanggal_lahir`, `nik`, `jenis_kelamin`, `kewarganegaraan`, `agama`, `alamat_pemohon`, `nama_organisasi`, `jenis_kegiatan`, `alamat_kantor`, `jumlah_pengurus`, `nama_notaris_pendirian`, `nomor_akta_pendirian`, `tanggal_akta_pendirian`, `nama_notaris_perubahan`, `nomor_akta_perubahan`, `tanggal_akta_perubahan`, `npwp`, `tgl_dibuat`, `id_user`) VALUES
(1, 'HERLINA MUSTIKASARI ROTI', 'Jakarta', '2025-09-16', '3674015505690006', 'Perempuan', 'Indonesia', 'Islam', 'BSD Anggrek Loka Blok E No. 3 RT 004/010 Kelurahan Rawa Buntu Kecamatan Serpong Kota Tangerang Selatan', 'YAYASAN MENATA RUMAH KITA BERSAMA', 'Bidang Sosial dan Pendidikan', 'Jl Masji Jami AL Latif No.1 RT 006/002 Kel Kademangan Kec Setu Kota Tangerang Selatan.', 14, 'Dr Udin Nasrudin', '106', '2025-09-16', 'Dr Udin Nasrudin', '09', '2025-09-16', '31.190.787.7-411.000', '2025-09-16 15:24:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` int(11) NOT NULL,
  `nomor_surat_rt` varchar(100) NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `scan_surat_rt` varchar(100) NOT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `warganegara` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `nama_orang_tua` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `id_dtks` varchar(50) DEFAULT NULL,
  `penghasilan_bulanan` varchar(100) NOT NULL,
  `keperluan` text NOT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `scan_surat_rt`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `tgl_dibuat`, `id_user`) VALUES
(1, '089/SP/RT.003/IX/2025', '2025-09-11', '92c1f7dee71ca4a3a2ebb5de2c04accb.pdf', 'AUDYA MAUDY PUTRI', 'Tangerang Selatan', '2015-08-08', '3674074808151001', 'Perempuan', 'Indonesia', 'Islam', 'Pelajar/mahasiswa', 'MAYANG WIDARAPURI', 'Perum Villa Tekno Blok M 16 RT 003 RW 009 Kelurahan kademangan Kecamatan Setu Kota Tangerang Selatan.\r\n', 'Belum Terdaftar', '< Rp 1.000.000', ' Persyaratan PIP', '2025-09-16 09:27:02', NULL);

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
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

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
-- Indexes for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
