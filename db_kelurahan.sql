-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 03:22 PM
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
(1, 'Test pengumuman', 'testing', 'Pengumuman', '2025-09-12 11:11:25', 1),
(2, 'Surat Izin Usaha', 'harus bawa gerobaknya', 'Peraturan', '2025-09-15 15:09:05', 1),
(3, 'Surat Izin Usaha', 'download dulu', 'Unduhan', '2025-09-15 15:09:23', 1),
(4, 'libur', 'mantap', 'Pengumuman', '2025-09-15 15:10:17', 1);

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
(1, 'youtube_link', 'https://www.youtube.com/watch?v=hzUG58aJ124');

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
  `jenis_kelamin_pemohon` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir_pemohon` varchar(100) NOT NULL,
  `tgl_lahir_pemohon` date NOT NULL,
  `nik_pemohon` varchar(20) NOT NULL,
  `agama_pemohon` varchar(50) NOT NULL,
  `pekerjaan_pemohon` varchar(100) NOT NULL,
  `alamat_pemohon` text NOT NULL,
  `penghasilan_bulanan` varchar(100) NOT NULL,
  `keperluan` text NOT NULL,
  `atas_nama` varchar(100) DEFAULT NULL,
  `tgl_dibuat` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nama_pemohon`, `jenis_kelamin_pemohon`, `tempat_lahir_pemohon`, `tgl_lahir_pemohon`, `nik_pemohon`, `agama_pemohon`, `pekerjaan_pemohon`, `alamat_pemohon`, `penghasilan_bulanan`, `keperluan`, `atas_nama`, `tgl_dibuat`, `id_user`) VALUES
(3, 'Andrian fakih', 'Laki-laki', 'Tangerang Selatan', '2001-01-09', '3171070901010006', 'Islam', 'Mahasiswa', 'Perumahan Pondok Maharta Blok A10 NO.19', '< Rp 1.000.000', 'Pengajuan Beasiswa Kuliah', 'Andrian Fakih', '2025-09-15 09:49:31', NULL);

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
(1, 'Super Administrator', 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', '0b91ff0d41926dafe50999bf7c72a317.png', 1);

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
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
