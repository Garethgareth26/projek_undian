-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Agu 2024 pada 03.44
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `project_undian_fix`
CREATE DATABASE IF NOT EXISTS `project_undian_fix`;
USE `project_undian_fix`;

-- Tabel `hadiah_new`
CREATE TABLE `hadiah_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel `kategori_hadiah`
CREATE TABLE `kategori_hadiah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel `voucher`
CREATE TABLE `voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_voucher` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_voucher_UNIQUE` (`kode_voucher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel `undian`
CREATE TABLE `undian` (
  `undian_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_voucher` varchar(100) NOT NULL,
  `hadiah_id` int(11) NOT NULL,
  `status_klaim` int(1) NOT NULL,
  PRIMARY KEY (`undian_id`),
  FOREIGN KEY (`kode_voucher`) REFERENCES `voucher` (`kode_voucher`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`hadiah_id`) REFERENCES `hadiah_new` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel `pemenang`
CREATE TABLE `pemenang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_voucher` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bagian` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `hadiah_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`kode_voucher`) REFERENCES `voucher` (`kode_voucher`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`hadiah_id`) REFERENCES `hadiah_new` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel `user`
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nama` varchar(100) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_foto` varchar(100) DEFAULT NULL,
  `level` int(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
