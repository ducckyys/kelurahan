-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 09:34 AM
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
(1, 'Batan Indah', 'b048a6f2e0e691777c3fa123b2f7ccdd.jpg', '2025-09-12 11:12:18', 1);

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
(1, 'Test pengumuman', 'testing', 'Pengumuman', '2025-09-12 11:11:25', 1);

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
-- Table structure for table `surat_izin_usaha`
--

CREATE TABLE `surat_izin_usaha` (
  `id` int(11) NOT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `nik_pemohon` varchar(20) NOT NULL,
  `email_pemohon` varchar(100) NOT NULL,
  `alamat_domisili` text NOT NULL,
  `nama_usaha` varchar(100) NOT NULL,
  `alamat_usaha` text NOT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_izin_usaha`
--

INSERT INTO `surat_izin_usaha` (`id`, `nama_pemohon`, `nik_pemohon`, `email_pemohon`, `alamat_domisili`, `nama_usaha`, `alamat_usaha`, `tgl_dibuat`, `id_user`) VALUES
(1, 'Andrian fakih', '3171070901010006', 'Adrianfaqih47@gmail.com', 'Tangerang Selatan', 'GamingShop', 'Ciledug', '2025-09-12 14:03:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengantar_nikah`
--

CREATE TABLE `surat_pengantar_nikah` (
  `id` int(11) NOT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `nik_pemohon` varchar(20) NOT NULL,
  `email_pemohon` varchar(100) NOT NULL,
  `alamat_domisili` text NOT NULL,
  `nama_pasangan` varchar(100) NOT NULL,
  `tanggal_nikah` date NOT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` int(11) NOT NULL,
  `nama_pemohon` varchar(100) NOT NULL,
  `nik_pemohon` varchar(20) NOT NULL,
  `email_pemohon` varchar(100) NOT NULL,
  `alamat_domisili` text NOT NULL,
  `penghasilan_bulanan` int(11) NOT NULL,
  `alasan_permohonan` text NOT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `id_level`) VALUES
(1, 'Super Administrator', 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', 1);

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
-- Indexes for table `surat_izin_usaha`
--
ALTER TABLE `surat_izin_usaha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
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
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_izin_usaha`
--
ALTER TABLE `surat_izin_usaha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
