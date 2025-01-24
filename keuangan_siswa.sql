-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2023 at 08:00 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminx`
--

CREATE TABLE `adminx` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `usernamex` varchar(100) DEFAULT NULL,
  `passwordx` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminx`
--

INSERT INTO `adminx` (`kd`, `usernamex`, `passwordx`) VALUES
('e4ea2f7dfb2e5c51e38998599e90afc2', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `m_cara_bayar`
--

CREATE TABLE `m_cara_bayar` (
  `kd` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_cara_bayar`
--

INSERT INTO `m_cara_bayar` (`kd`, `nama`, `postdate`) VALUES
('c4ca4238a0b923820dcc509a6f75849b', 'ANTAR JEMPUT', '2022-07-21 11:32:26'),
('c81e728d9d4c2f636f067f89cc14862c', 'BUKU PAKET', '2022-07-21 11:32:38'),
('eccbc87e4b5ce2fe28308fd9f2a7baf3', 'SPI xkkurixPEMBANGUNANxkkurnanx', '2022-07-21 11:32:52'),
('fce3cfac7b7febc5cbe3551f6d35932c', 'SYAHRIYAH', '2022-07-21 11:33:00'),
('c1b1f59dbfe51b882c8b0dd09c86c1ca', 'TABUNGAN', '2022-07-21 00:00:00'),
('b9e50b39803faf8811645bb9261d11e3', 'KEGIATAN', '2022-08-31 11:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `m_set_nominal`
--

CREATE TABLE `m_set_nominal` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `tapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `bulan` varchar(2) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `nominal` varchar(15) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_siswa`
--

CREATE TABLE `m_siswa` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `tapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `usernamex` varchar(100) DEFAULT NULL,
  `passwordx` varchar(100) DEFAULT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kelamin` varchar(1) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL,
  `filex1` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_siswa`
--

INSERT INTO `m_siswa` (`kd`, `tapel`, `kelas`, `usernamex`, `passwordx`, `nis`, `nama`, `kelamin`, `postdate`, `filex1`) VALUES
('fa6b2eb62c52144ad150a1f1355aa8d1', '2022xgmringx2023', '1 TAHFIDZ', NULL, NULL, '2733', 'AFNAN ATMA PURNAMA', 'l', '2023-10-11 11:51:03', 'fa6b2eb62c52144ad150a1f1355aa8d1-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `m_tapel`
--

CREATE TABLE `m_tapel` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `tahun1` varchar(4) DEFAULT NULL,
  `tahun2` varchar(4) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_tapel`
--

INSERT INTO `m_tapel` (`kd`, `tahun1`, `tahun2`, `postdate`) VALUES
('b455c00b6c6c435ebe47c7f87c470107', '2022', '2023', '2022-04-15 22:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `m_uang_jenis`
--

CREATE TABLE `m_uang_jenis` (
  `kd` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_uang_jenis`
--

INSERT INTO `m_uang_jenis` (`kd`, `nama`, `postdate`) VALUES
('0c29e121b2c56caedaeceeb6f77b8d39', 'Cash', '2022-04-15 22:20:11'),
('932080bdece9028d93b83b389e5c842e', 'Bantuan Lainnya', '2022-04-15 22:20:32'),
('84a0f3455dcca894ace136be62efa292', 'TRANSFER', '2022-09-11 22:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_bayar`
--

CREATE TABLE `siswa_bayar` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `siswa_kd` varchar(50) DEFAULT NULL,
  `siswa_nis` varchar(100) DEFAULT NULL,
  `siswa_nama` varchar(100) DEFAULT NULL,
  `tapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `cara_bayar` varchar(100) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `nilai` varchar(15) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL,
  `ket` longtext DEFAULT NULL,
  `sisa` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminx`
--
ALTER TABLE `adminx`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_cara_bayar`
--
ALTER TABLE `m_cara_bayar`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_set_nominal`
--
ALTER TABLE `m_set_nominal`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_tapel`
--
ALTER TABLE `m_tapel`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_uang_jenis`
--
ALTER TABLE `m_uang_jenis`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `siswa_bayar`
--
ALTER TABLE `siswa_bayar`
  ADD PRIMARY KEY (`kd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
