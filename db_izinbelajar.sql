-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jan 2026 pada 15.15
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
-- Database: `db_izinbelajar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_expired` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `email`, `password`, `reset_password_token`, `reset_password_expired`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Hitachi', 'beniliufeto08@gmail.com', '$2y$10$bzbmP5GsWWO/q.G5PGit3.S7W0gyIy3mWDhccT.HnHk/zUR09AjN.', NULL, NULL, '2026-01-08 21:12:58', '2026-01-06 22:27:12', '2026-01-08 21:12:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_belajar`
--

CREATE TABLE `izin_belajar` (
  `id_izin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status_pengajuan` enum('draft','diajukan','diverifikasi','ditolak','disetujui','tidak lengkap') DEFAULT 'draft',
  `tanggal_pengajuan` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jenis_pengajuan` enum('baru','perpanjangan') NOT NULL DEFAULT 'baru',
  `id_izin_induk` int(11) DEFAULT NULL,
  `last_step` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_belajar`
--

INSERT INTO `izin_belajar` (`id_izin`, `id_user`, `status_pengajuan`, `tanggal_pengajuan`, `created_at`, `updated_at`, `jenis_pengajuan`, `id_izin_induk`, `last_step`) VALUES
(72, 4, 'disetujui', '2026-01-08', '2026-01-08 14:17:21', '2026-01-08 21:29:55', 'baru', NULL, 4),
(73, 4, 'disetujui', '2026-01-08', '2026-01-08 14:30:16', '2026-01-08 21:34:06', 'perpanjangan', 72, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_dokumen_pendukung`
--

CREATE TABLE `izin_dokumen_pendukung` (
  `id_dokumen` int(11) NOT NULL,
  `id_izin` int(11) NOT NULL,
  `jenis_pendanaan` varchar(100) DEFAULT NULL,
  `penyedia_beasiswa` varchar(150) DEFAULT NULL,
  `jabatan_penjamin` varchar(150) DEFAULT NULL,
  `surat_jaminan` varchar(255) DEFAULT NULL,
  `surat_pernyataan` varchar(255) DEFAULT NULL,
  `surat_kesehatan` varchar(255) DEFAULT NULL,
  `letter_acceptance` varchar(255) DEFAULT NULL,
  `ijazah_terakhir` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nomor_kitas` varchar(50) DEFAULT NULL,
  `jumlah_kitas` int(11) DEFAULT NULL,
  `tgl_kitas_berlaku` date DEFAULT NULL,
  `tgl_kitas_berakhir` date DEFAULT NULL,
  `file_kitas` varchar(255) DEFAULT NULL,
  `nomor_sktt` varchar(50) DEFAULT NULL,
  `tgl_sktt` date DEFAULT NULL,
  `file_sktt` varchar(255) DEFAULT NULL,
  `transkrip_akademik` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_dokumen_pendukung`
--

INSERT INTO `izin_dokumen_pendukung` (`id_dokumen`, `id_izin`, `jenis_pendanaan`, `penyedia_beasiswa`, `jabatan_penjamin`, `surat_jaminan`, `surat_pernyataan`, `surat_kesehatan`, `letter_acceptance`, `ijazah_terakhir`, `created_at`, `updated_at`, `nomor_kitas`, `jumlah_kitas`, `tgl_kitas_berlaku`, `tgl_kitas_berakhir`, `file_kitas`, `nomor_sktt`, `tgl_sktt`, `file_sktt`, `transkrip_akademik`) VALUES
(20, 72, 'Biaya Mandiri', 'Pemerintah', 'Direktur', 'uploads/dokumen/695faf670b622.jpeg', 'uploads/dokumen/695faf670bac8.jpeg', 'uploads/dokumen/695faf670bf89.jpeg', 'uploads/dokumen/695faf670c2d6.jpeg', 'uploads/dokumen/695faf670c5ef.jpeg', '2026-01-08 21:21:43', '2026-01-08 21:21:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 73, 'Biaya Mandiri', 'Pemerintah', 'Direktur', 'uploads/dokumen/695faf670b622.jpeg', 'uploads/dokumen/695faf670bac8.jpeg', 'uploads/dokumen/695faf670bf89.jpeg', 'uploads/dokumen/695faf670c2d6.jpeg', 'uploads/dokumen/695faf670c5ef.jpeg', '2026-01-08 21:31:12', '2026-01-08 21:31:12', '1223565', 2, '2026-01-08', '2026-03-08', 'uploads/dokumen/695fb1a071615.png', '21356', '2026-01-08', 'uploads/dokumen/695fb1a071b65.jpeg', 'uploads/dokumen/695fb1a071fe9.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_identitas`
--

CREATE TABLE `izin_identitas` (
  `id_identitas` int(11) NOT NULL,
  `id_izin` int(11) NOT NULL,
  `nama_lengkap` varchar(150) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `kebangsaan` varchar(100) DEFAULT NULL,
  `alamat_rumah` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `negara` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `alamat_indonesia` text DEFAULT NULL,
  `kota_indonesia` varchar(100) DEFAULT NULL,
  `provinsi_indonesia` varchar(100) DEFAULT NULL,
  `kode_pos_indonesia` varchar(10) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_identitas`
--

INSERT INTO `izin_identitas` (`id_identitas`, `id_izin`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kebangsaan`, `alamat_rumah`, `kota`, `provinsi`, `negara`, `kode_pos`, `alamat_indonesia`, `kota_indonesia`, `provinsi_indonesia`, `kode_pos_indonesia`, `email`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(53, 72, 'Beni Milian Liufeto', 'SoE', '2004-07-08', 'Laki-laki', 'Indonesia', 'Jl. Diponegoro No', 'SoE', 'Nusa Tenggara Timur', 'Indonesia', '85511', 'Matani', 'Kupang', 'Nusa Tenggara Timur', '85511', 'beniliufeto08@gmail.com', '081238340603', 'uploads/foto/695faeafdec93.jpg', '2026-01-08 21:18:39', '2026-01-08 21:22:31'),
(54, 73, 'Beni Milian Liufeto', 'SoE', '2004-07-08', 'Laki-laki', 'Indonesia', 'Jl. Diponegoro No', 'SoE', 'Nusa Tenggara Timur', 'Indonesia', '85511', 'Matani', 'Kupang', 'Nusa Tenggara Timur', '85511', 'beniliufeto08@gmail.com', '081238340603', 'uploads/foto/695faeafdec93.jpg', '2026-01-08 21:30:16', '2026-01-08 21:30:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_paspor`
--

CREATE TABLE `izin_paspor` (
  `id_paspor` int(11) NOT NULL,
  `id_izin` int(11) NOT NULL,
  `nomor_paspor` varchar(50) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `scan_paspor` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_paspor`
--

INSERT INTO `izin_paspor` (`id_paspor`, `id_izin`, `nomor_paspor`, `tanggal_pengajuan`, `tanggal_berakhir`, `scan_paspor`, `created_at`, `updated_at`) VALUES
(20, 72, '2-11-4401', '2026-01-15', '2026-04-08', 'uploads/dokumen/695faf670b0ca.jpeg', '2026-01-08 21:21:43', '2026-01-08 21:21:43'),
(21, 73, '2-11-4401', '2026-01-15', '2026-04-08', 'uploads/dokumen/695faf670b0ca.jpeg', '2026-01-08 21:31:12', '2026-01-08 21:31:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `izin_studi`
--

CREATE TABLE `izin_studi` (
  `id_studi` int(11) NOT NULL,
  `id_izin` int(11) NOT NULL,
  `universitas` varchar(150) DEFAULT NULL,
  `jenjang_studi` varchar(50) DEFAULT NULL,
  `dok_kerjasama` varchar(255) DEFAULT NULL,
  `mulai_belajar` date DEFAULT NULL,
  `lama_studi` varchar(20) DEFAULT NULL,
  `periode_dari` date DEFAULT NULL,
  `periode_sampai` date DEFAULT NULL,
  `lokasi_provinsi` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `izin_studi`
--

INSERT INTO `izin_studi` (`id_studi`, `id_izin`, `universitas`, `jenjang_studi`, `dok_kerjasama`, `mulai_belajar`, `lama_studi`, `periode_dari`, `periode_sampai`, `lokasi_provinsi`, `created_at`, `updated_at`) VALUES
(21, 72, 'Universitas Nusa Cendana', 'S-1', 'uploads/dokumen/695faf15e5714.pdf', '2026-01-08', '3 Bulan', '2026-01-08', '2026-04-09', 'Nusa Tenggara Timur', '2026-01-08 21:20:21', '2026-01-08 21:20:21'),
(22, 73, 'Universitas Nusa Cendana', 'S-1', 'uploads/dokumen/695faf15e5714.pdf', '2026-01-08', '3 Bulan', '2026-01-08', '2026-04-09', 'Nusa Tenggara Timur', '2026-01-08 21:30:28', '2026-01-08 21:30:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `verification_token` varchar(100) DEFAULT NULL,
  `reset_password_token` varchar(100) DEFAULT NULL,
  `reset_password_expired` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verification_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `username`, `email`, `profile_photo`, `password`, `no_hp`, `email_verified_at`, `verification_token`, `reset_password_token`, `reset_password_expired`, `created_at`, `updated_at`, `verification_expires_at`) VALUES
(4, 'Beni Milian Liufeto', 'Hitachi', 'beniliufeto08@gmail.com', '69441cc03c28d_4.jpg', '$2y$10$nUAl8OeOU32Em4.eDylf7eqn2r/QcAl6Oa3cdX5pggCeVa6y5wh.2', '081238340603', '2025-12-17 02:24:55', NULL, NULL, NULL, '2025-12-17 02:24:26', '2025-12-18 23:24:48', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `izin_belajar`
--
ALTER TABLE `izin_belajar`
  ADD PRIMARY KEY (`id_izin`),
  ADD KEY `fk_izin_user` (`id_user`);

--
-- Indeks untuk tabel `izin_dokumen_pendukung`
--
ALTER TABLE `izin_dokumen_pendukung`
  ADD PRIMARY KEY (`id_dokumen`),
  ADD KEY `fk_dokumen_izin` (`id_izin`);

--
-- Indeks untuk tabel `izin_identitas`
--
ALTER TABLE `izin_identitas`
  ADD PRIMARY KEY (`id_identitas`),
  ADD KEY `fk_identitas_izin` (`id_izin`);

--
-- Indeks untuk tabel `izin_paspor`
--
ALTER TABLE `izin_paspor`
  ADD PRIMARY KEY (`id_paspor`),
  ADD KEY `fk_paspor_izin` (`id_izin`);

--
-- Indeks untuk tabel `izin_studi`
--
ALTER TABLE `izin_studi`
  ADD PRIMARY KEY (`id_studi`),
  ADD KEY `fk_studi_izin` (`id_izin`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `izin_belajar`
--
ALTER TABLE `izin_belajar`
  MODIFY `id_izin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `izin_dokumen_pendukung`
--
ALTER TABLE `izin_dokumen_pendukung`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `izin_identitas`
--
ALTER TABLE `izin_identitas`
  MODIFY `id_identitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `izin_paspor`
--
ALTER TABLE `izin_paspor`
  MODIFY `id_paspor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `izin_studi`
--
ALTER TABLE `izin_studi`
  MODIFY `id_studi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `izin_belajar`
--
ALTER TABLE `izin_belajar`
  ADD CONSTRAINT `fk_izin_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_dokumen_pendukung`
--
ALTER TABLE `izin_dokumen_pendukung`
  ADD CONSTRAINT `fk_dokumen_izin` FOREIGN KEY (`id_izin`) REFERENCES `izin_belajar` (`id_izin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_identitas`
--
ALTER TABLE `izin_identitas`
  ADD CONSTRAINT `fk_identitas_izin` FOREIGN KEY (`id_izin`) REFERENCES `izin_belajar` (`id_izin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_paspor`
--
ALTER TABLE `izin_paspor`
  ADD CONSTRAINT `fk_paspor_izin` FOREIGN KEY (`id_izin`) REFERENCES `izin_belajar` (`id_izin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `izin_studi`
--
ALTER TABLE `izin_studi`
  ADD CONSTRAINT `fk_studi_izin` FOREIGN KEY (`id_izin`) REFERENCES `izin_belajar` (`id_izin`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
