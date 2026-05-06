-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 05:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spk_topsis_borda`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `kode_alternatif` varchar(10) NOT NULL,
  `nama_alternatif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `kode_alternatif`, `nama_alternatif`) VALUES
(1, 'A1', 'Tik Tok'),
(2, 'A2', 'Instagram'),
(3, 'A3', 'Email Marketing'),
(4, 'A4', 'Influencer');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `bobot` int(11) NOT NULL,
  `jenis` enum('Benefit','Cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `bobot`, `jenis`) VALUES
(1, 'C1', 'Biaya Iklan Digital', 3, 'Cost'),
(2, 'C2', 'Jangkauan Audiens', 4, 'Benefit'),
(3, 'C3', 'Tingkat Interaksi', 5, 'Benefit'),
(4, 'C4', 'Konversi Penjualan', 5, 'Benefit');

-- --------------------------------------------------------

--
-- Table structure for table `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `nama_penilai` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilai`
--

INSERT INTO `penilai` (`id_penilai`, `nama_penilai`, `deskripsi`) VALUES
(1, 'Penilai 1', 'Manager Pemasaran'),
(2, 'Penilai 2', 'Staff Digital'),
(3, 'Penilai 3', 'Konsultan');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_penilai`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(177, 2, 1, 1, 5000000),
(178, 2, 1, 2, 5),
(179, 2, 1, 3, 4),
(180, 2, 1, 4, 4),
(181, 2, 2, 1, 5000000),
(182, 2, 2, 2, 4),
(183, 2, 2, 3, 5),
(184, 2, 2, 4, 4),
(185, 2, 3, 1, 6000000),
(186, 2, 3, 2, 3),
(187, 2, 3, 3, 3),
(188, 2, 3, 4, 4),
(189, 2, 4, 1, 6500000),
(190, 2, 4, 2, 2),
(191, 2, 4, 3, 2),
(192, 2, 4, 4, 4),
(193, 3, 1, 1, 2000000),
(194, 3, 1, 2, 5),
(195, 3, 1, 3, 4),
(196, 3, 1, 4, 4),
(197, 3, 2, 1, 2500000),
(198, 3, 2, 2, 4),
(199, 3, 2, 3, 5),
(200, 3, 2, 4, 3),
(201, 3, 3, 1, 4000000),
(202, 3, 3, 2, 3),
(203, 3, 3, 3, 3),
(204, 3, 3, 4, 4),
(205, 3, 4, 1, 3500000),
(206, 3, 4, 2, 2),
(207, 3, 4, 3, 2),
(208, 3, 4, 4, 4),
(209, 1, 1, 1, 3000000),
(210, 1, 1, 2, 5),
(211, 1, 1, 3, 4),
(212, 1, 1, 4, 4),
(213, 1, 2, 1, 2500000),
(214, 1, 2, 2, 4),
(215, 1, 2, 3, 5),
(216, 1, 2, 4, 4),
(217, 1, 3, 1, 4000000),
(218, 1, 3, 2, 3),
(219, 1, 3, 3, 3),
(220, 1, 3, 4, 3),
(221, 1, 4, 1, 3500000),
(222, 1, 4, 2, 2),
(223, 1, 4, 3, 2),
(224, 1, 4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama_sub` varchar(150) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub`, `id_kriteria`, `nama_sub`, `nilai`) VALUES
(1, 2, '> 100.000 orang', 5),
(2, 2, '50.000 – 100.000 orang', 4),
(3, 2, '10.000 – 50.000 orang', 3),
(4, 2, '< 10.000 orang', 2),
(5, 3, '> 10%', 5),
(6, 3, '6 – 10%', 4),
(7, 3, '3 – 5%', 3),
(8, 3, '1 – 2%', 2),
(9, 4, 'Sangat Tinggi (> 25%)', 5),
(10, 4, 'Tinggi (20-25%)', 4),
(11, 4, 'Sedang (15-20%)', 3),
(12, 4, 'Rendah (< 15%)', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','penilai') NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `foto`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Utama', 'admin', 'profil-1-1767719097.jpeg'),
(2, 'penilai1', 'a32440a7a6af86edafe2593d3b0d3f8f', 'Penilai Satu', 'penilai', 'profil-2-1767721565.jpeg'),
(3, 'penilai2', '0192023a7bbd73250516f069df18b500', 'Penilai Dua', 'penilai', NULL),
(4, 'penilai3', '0192023a7bbd73250516f069df18b500', 'Penilai Tiga', 'penilai', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD UNIQUE KEY `unique_vote` (`id_penilai`,`id_alternatif`,`id_kriteria`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
