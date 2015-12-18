-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 16 Des 2015 pada 08.36
-- Versi Server: 5.5.27
-- Versi PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `berkah`
--
CREATE DATABASE `berkah` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `berkah`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `kd_bank` varchar(3) NOT NULL,
  `nm_bank` varchar(15) NOT NULL,
  PRIMARY KEY (`kd_bank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`kd_bank`, `nm_bank`) VALUES
('002', 'BRI'),
('008', 'MANDIRI'),
('009', 'BNI'),
('011', 'DANAMON'),
('014', 'BCA'),
('016', 'BII'),
('019', 'PANIN'),
('020', 'ARTA NIAGA KENC'),
('052', 'ABN AMRO'),
('061', 'PANIN BANK'),
('076', 'BUMI ARTA'),
('088', 'ALFINDO'),
('110', 'BANK JABAR'),
('111', 'DKI'),
('147', 'MUAMALAT'),
('200', 'BTN'),
('422', 'BRI SYARIAH'),
('426', 'MEGA'),
('441', 'BUKOPIN'),
('451', 'SYARIAH MANDIRI'),
('494', 'AGRO NIAGA'),
('503', 'ALFINDO'),
('525', 'AKITA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` varchar(3) NOT NULL,
  `nm_jabatan` varchar(25) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nm_jabatan`) VALUES
('ADM', 'ADMINISTRASI'),
('FIN', 'FINANCE'),
('HRD', 'HUMAN RESOURCE DEVELOPMEN'),
('IT', 'INFORMATION TECHNOLOGY'),
('MAN', 'MANAJER'),
('MRT', 'MARKETING'),
('PNL', 'PURCHASE AND LOGISTIC'),
('TS', 'TECHNICAL SERVICE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE IF NOT EXISTS `karyawan` (
  `nik` varchar(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tmp_lhr` varchar(25) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `tgl_masuk` date NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `foto` varchar(20) NOT NULL,
  `st_marital` enum('Menikah','Belum Menikah','','') NOT NULL,
  `status_aktf` enum('Aktif','Tidak Aktif','Cuti','Baru') NOT NULL,
  `id_unit` varchar(3) NOT NULL,
  `id_jabatan` varchar(3) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `no_rek` varchar(20) NOT NULL,
  `pend_akhir` varchar(3) NOT NULL,
  `gol_darah` varchar(2) NOT NULL,
  PRIMARY KEY (`nik`),
  KEY `fk_vendor` (`id_unit`),
  KEY `fk_jb` (`id_jabatan`),
  KEY `no_rek` (`no_rek`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama`, `tmp_lhr`, `tgl_lhr`, `jk`, `tgl_masuk`, `alamat`, `email`, `foto`, `st_marital`, `status_aktf`, `id_unit`, `id_jabatan`, `tlp`, `no_rek`, `pend_akhir`, `gol_darah`) VALUES
('123', 'sasasdaaaa', 'kn', '1994-12-08', 'Perempuan', '2015-11-01', 'kkkkk', 'berkahkng@gmail.com', '', 'Belum Menikah', 'Cuti', 'BUS', 'HRD', '123332222', '0529-01-010858-50-6', 'S2', 'B'),
('1234', 'aaa55555', 'kn', '0000-00-00', 'Perempuan', '0000-00-00', 'kkkkk', 'berkahkng@gmail.com', 'word.jpg', 'Belum Menikah', 'Aktif', 'BMM', 'IT', '123332222', '10999', 'D1', 'O');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id_user` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `activity` enum('on','off') NOT NULL,
  `nik` varchar(20) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `nik` (`nik`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_user`, `username`, `password`, `activity`, `nik`) VALUES
(1, 'a', '0cc175b9c0f1b6a831c399e269772661', 'on', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi`
--

CREATE TABLE IF NOT EXISTS `mutasi` (
  `id_mutasi` int(5) NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) NOT NULL,
  `id_unit` varchar(3) NOT NULL,
  `id_jabatan` varchar(3) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  PRIMARY KEY (`id_mutasi`),
  KEY `fk_nik` (`nik`),
  KEY `fk_id_unit` (`id_unit`),
  KEY `fk_id_jabatan` (`id_jabatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `mutasi`
--

INSERT INTO `mutasi` (`id_mutasi`, `nik`, `id_unit`, `id_jabatan`, `tgl_mutasi`) VALUES
(1, '123', 'BAS', 'MAN', '2015-12-08'),
(2, '1234', 'BS2', 'PNL', '0000-00-00'),
(3, '123', 'BMM', 'HRD', '2015-12-16'),
(4, '1234', 'BAS', 'IT', '2015-12-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE IF NOT EXISTS `rekening` (
  `no_rek` varchar(20) NOT NULL,
  `atas_nama` varchar(30) NOT NULL,
  `kd_bank` varchar(3) NOT NULL,
  PRIMARY KEY (`no_rek`),
  KEY `kd_bank` (`kd_bank`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`no_rek`, `atas_nama`, `kd_bank`) VALUES
('012201003606536', 'RUDI HARTONO', '002'),
('0529-01-010858-50-6', 'ERNA SARI ', '002'),
('0792.0100.8262.530', 'Yudis Rachmanto', '002'),
('101 00822 08', 'Yayasan Rumah Zakat Indonesia', '147'),
('10999', 'aaa', '200'),
('1100006036146', 'M.QHONI ', '008'),
('2008-01-001236-50-9 ', 'Teguh Suryadi Hilmahindra ', '002'),
('3279-01-021391-53-1', 'ARIF PUTRA PRATAMA', '002'),
('8888888', 'asasa', '076');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id_unit` varchar(3) NOT NULL,
  `nm_unit` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kontak` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `unit`
--

INSERT INTO `unit` (`id_unit`, `nm_unit`, `alamat`, `kontak`, `email`) VALUES
('BAS', 'Berkah Arum Santika', '', '', ''),
('BMM', 'Berkah Mitra Mandiri', '', '', ''),
('BS1', 'Berkah Sinar Mandiri 1', '', '', ''),
('BS2', 'Berkah Sinar Mandiri 2', '', '', ''),
('BSB', 'Berkah Satya Bakti', '', '', ''),
('BUS', 'Berkah Unggas Sejahtera', '', '', '');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`),
  ADD CONSTRAINT `karyawan_ibfk_3` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  ADD CONSTRAINT `karyawan_ibfk_4` FOREIGN KEY (`no_rek`) REFERENCES `rekening` (`no_rek`);

--
-- Ketidakleluasaan untuk tabel `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `mutasi`
--
ALTER TABLE `mutasi`
  ADD CONSTRAINT `fk_id_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  ADD CONSTRAINT `fk_id_unit` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`),
  ADD CONSTRAINT `fk_nik` FOREIGN KEY (`nik`) REFERENCES `karyawan` (`nik`);

--
-- Ketidakleluasaan untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD CONSTRAINT `rekening_ibfk_1` FOREIGN KEY (`kd_bank`) REFERENCES `bank` (`kd_bank`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
