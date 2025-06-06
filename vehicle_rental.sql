-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jun 2025 pada 16.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehicle_rental`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `kendaraan_id` int(11) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `harga_per_hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`kendaraan_id`, `tipe`, `model`, `harga_per_hari`) VALUES
(9, 'Motor', 'Honda Beat', 1000000),
(10, 'Mobil', 'Toyota Avanza', 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `NIK` int(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `sim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`pelanggan_id`, `NIK`, `nama`, `sim`) VALUES
(16, 1234567, 'tes', 'uploads/sim/1749125158_LOGOUT.png'),
(17, 1234567, 'abing', 'uploads/sim/1749125263_LOGOUT.png'),
(19, 1234567, 'tes 1', 'uploads/sim/1749126059_LOGOUT.png'),
(21, 0, '', NULL),
(22, 0, '', NULL),
(23, 111111, 'tes', 'uploads/sim/1749130948_Cuplikan layar 2024-09-24 104504.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rental`
--

CREATE TABLE `rental` (
  `rental_id` int(11) NOT NULL,
  `kendaraan_id` int(11) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `tgl_rental` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rental`
--

INSERT INTO `rental` (`rental_id`, `kendaraan_id`, `pelanggan_id`, `tgl_rental`, `tgl_kembali`, `total`, `IMAGE`) VALUES
(12, 10, 21, '2025-06-05', '2025-06-06', 100000, NULL),
(13, 10, 22, '2025-06-06', '2025-06-07', 100000, NULL),
(14, 10, 17, '2025-06-05', '2025-06-07', 200000, NULL),
(15, 9, 23, '2025-06-05', '2025-06-06', 1000000, NULL),
(16, 10, 23, '2025-06-05', '2025-06-06', 100000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `password`, `role`) VALUES
(1, 'Jason', '12345', '$2y$10$YhI2zwscPOAu7.pRoZsfAe95m7T6khic35/uTiJTxlGU/rijfS4L6', 'user'),
(2, 'Jason', '12345', '$2y$10$eGB7mv8LylpykgfoxH.lf.8WJbq3MTiiE2qmyno7abH2xbqtYdnUO', 'user'),
(3, 'aaa', '123', '$2y$10$E/pMRkOLW6vNPrTuG.65KeW.iW1nCvbD77c7H9hESgB3kB6.KMLhO', 'user'),
(4, 'budi', '12345', '$2y$10$GwjEHiuMtGwTXoB9gemgyO0Kt.7aXN/cZ7iD5cfsO3vC9GYrsWa9S', 'user'),
(5, 'nabil', 'nabil', '$2y$10$jlcScE7igheUaU146dsqh.OPkNnS.ZANWufhQM7Kf5/qY6Xqb/zcK', 'user'),
(6, 'nabil', 'nabil', '$2y$10$WbmILHM4dhx0ryykVoQcUuHIHXXyTVTJFljzslnfQp6bWu8u3d/3q', 'user'),
(7, 'a', 'a', '$2y$10$VbDMtgmDs0ObUSTeDtDBNetEeU1KZ86b27C7/8JmK/8CU0HdpBPum', 'user'),
(8, 'nabil', 'a', '$2y$10$oA1Ppl7TR30WZv0BX58lBusXD0gh8zGQ5ategO2PhLYJwFGbZIYS6', 'user'),
(9, 'u', 'a', '$2y$10$jWAL1KoKcS3mDy.Gsw3QVuM9gI6.zbni/AMDZvOg/k5ZQAa5TZP.W', 'user'),
(10, 'p', 'a', '$2y$10$dHMY2fq7WgPzja9UmDyJp.LILln7slXGtvwrCMewrM8vV94F0Ra3G', 'user'),
(11, 'budi', 'um', '$2y$10$KAaTQ2ISHxh7oJvVKkjIYO95JQYDSQK12ShWiIeFJPSD8JS7SjJli', 'user'),
(12, 'budi', 'um', '$2y$10$tHqnUy5rBAZj/g5lbtxivuo6w6QU6FDDWnCE5N.sQg0ewM78GEDhy', 'user'),
(13, 'nn', 'euuui', '$2y$10$Gyd76cvoxtFu6AgQ.FNL4e9hnEkx7XyF6sGIe04FEO9EWmAg9lYfi', 'user'),
(14, 'umami', 'gob', '$2y$10$h0F/THYRyTB8GVSvedDIIO.wIzpsE/6JV3JA88eYV6UdQirOBfyz6', 'user'),
(15, 'sami', 'mi', '$2y$10$BNZzQfIFbpWKoRP61XZzGOR0VvFSA4wIuHmEF.bkAyk7eZ9PluTBq', 'user'),
(16, 'hary', 'hary', '$2y$12$Ar5OhkWBFiYgOZpM493uKekFaCaBqb6ol9AtqlF7TZ4klE.hDI0kG', 'user'),
(17, 'ayam', 'goreng', '$2y$10$HiLI5ah6BNlwMeK7S.C/z.GHJzXxarMxpYVin2u.nTmaYr5F6d5Cq', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`kendaraan_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`);

--
-- Indeks untuk tabel `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `kendaraan_id` (`kendaraan_id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `kendaraan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `rental`
--
ALTER TABLE `rental`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `rental_ibfk_1` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraan` (`kendaraan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_ibfk_2` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`pelanggan_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
