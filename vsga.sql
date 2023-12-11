-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 04:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsga`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_beasiswa`
--

CREATE TABLE `tabel_beasiswa` (
  `id` varchar(32) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_beasiswa`
--

INSERT INTO `tabel_beasiswa` (`id`, `nama`) VALUES
('ebe111b9f82c2c0da557780e4d7e6cf4', 'Beasiswa Akademik'),
('f822108545fe70c40cbf97460f5f3b75', 'Beasiswa Non Akademik');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pendaftaran`
--

CREATE TABLE `tabel_pendaftaran` (
  `id` varchar(32) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `semester` int(11) NOT NULL,
  `ipk` decimal(4,2) NOT NULL,
  `pilihan_beasiswa` varchar(255) NOT NULL,
  `berkas_syarat` varchar(255) NOT NULL,
  `status_ajuan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_pendaftaran`
--

INSERT INTO `tabel_pendaftaran` (`id`, `nama`, `email`, `nomor_hp`, `semester`, `ipk`, `pilihan_beasiswa`, `berkas_syarat`, `status_ajuan`, `created_at`) VALUES
('0e822348dc947c26037f0c44513f2b82', 'Petrus Kuswandi', 'petruskuswandi1@gmail.com', '08999965657', 7, 3.56, 'Beasiswa Akademik', 'cover-not-found.jpeg', 'belum di verifikasi', '2023-12-11 03:30:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_beasiswa`
--
ALTER TABLE `tabel_beasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
