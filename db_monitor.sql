-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Apr 2020 pada 16.10
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `client`
--

CREATE TABLE `client` (
  `idc` int(11) NOT NULL,
  `perusahaan` varchar(200) NOT NULL,
  `wa` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `client`
--

INSERT INTO `client` (`idc`, `perusahaan`, `wa`, `alamat`, `user_id`) VALUES
(6, 'Prakoso Store', '081225892', 'Jalan Godean', 20),
(7, 'Fauziah', '0832232323', 'Dero', 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `devel`
--

CREATE TABLE `devel` (
  `idd` int(11) NOT NULL,
  `job` int(11) NOT NULL,
  `wa` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `devel`
--

INSERT INTO `devel` (`idd`, `job`, `wa`, `alamat`, `user_id`) VALUES
(5, 1, '08123232', 'Bantul', 8),
(6, 2, '0832323', 'Depok', 9),
(7, 3, '0832323', 'Magelang', 10),
(8, 1, '08539150000', 'Sleman', 14),
(12, 3, '08232332', 'Sleman', 24);

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluasi`
--

CREATE TABLE `evaluasi` (
  `ide` int(11) NOT NULL,
  `ket` text NOT NULL,
  `tskid` int(11) NOT NULL,
  `dos` int(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `evaluasi`
--

INSERT INTO `evaluasi` (`ide`, `ket`, `tskid`, `dos`, `created`) VALUES
(1, 'Tampilan Landing Page Kurang cerah, mohon untuk dicerahkan lagi ya mas', 1, 1, '2020-04-09 19:08:20'),
(2, 'Recomended Produk tolong diberikan ada per tanggal nya', 2, 1, '2020-04-09 19:08:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `prj_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `page`
--

INSERT INTO `page` (`id`, `nama`, `keterangan`, `prj_id`, `created`) VALUES
(1, 'Landing Page', 'Berisi Halaman awal ketika website dibuka', 2, '2020-04-06 17:52:50'),
(2, 'Gallery', 'Berisi konten koleksi produk dari toko online', 2, '2020-04-06 17:53:42'),
(3, 'Kategori Produk', 'Berisi Kategori tiap produk', 2, '2020-04-06 17:54:39'),
(7, 'Dashboard Pemberkasan', 'berisi list progress', 5, '2020-04-08 19:39:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `tsk` int(11) NOT NULL,
  `dev` int(11) NOT NULL,
  `prj` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `client` int(11) NOT NULL,
  `dsg` int(11) NOT NULL,
  `fe` int(11) NOT NULL,
  `be` int(11) NOT NULL,
  `done` int(1) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id`, `nama`, `keterangan`, `client`, `dsg`, `fe`, `be`, `done`, `created`) VALUES
(2, 'Sistem Informasi PP Muhammadiyah Yogyakarta', 'Sistem Informasi untuk pendataan online unversitas muhammadiyah Yogyakarta', 20, 14, 9, 24, 1, '2020-04-06 17:48:06'),
(5, 'Sistem Pemberkasan', 'gdfgdgdf', 21, 8, 9, 10, 0, '2020-04-08 19:38:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `pg_id` int(11) NOT NULL,
  `prjid` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `task`
--

INSERT INTO `task` (`id`, `nama`, `keterangan`, `pg_id`, `prjid`, `created`) VALUES
(1, 'Landing Page Paralax', 'Landing Page dengan paralax effect', 1, 2, '2020-04-10 22:46:38'),
(2, 'Produk terkini', 'Menampilkan produk terkini', 1, 2, '2020-04-10 22:47:08'),
(3, 'Produk Terbaru', 'Produk terbaru dapat ditampilkan', 1, 2, '2020-04-10 22:47:38'),
(4, 'Show Gallery Produk', 'Menampilkan semua galeri produk', 2, 2, '2020-04-10 22:48:24'),
(5, 'Menampilkan Galery pruduk sesuai kategori', 'Menampilkan galery produk group by kategori', 2, 2, '2020-04-10 22:49:52'),
(6, 'Kategori Produk 3 Tingkat', 'Menampilkan kategori dengan 3 tingkat', 3, 2, '2020-04-10 22:50:24'),
(7, 'Dashboard tampilan grafik', 'Grafik tampilan yang menarik dalam bentuk chart', 7, 5, '2020-04-10 22:51:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(256) NOT NULL,
  `active` int(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `nama`, `email`, `password`, `active`, `created`, `role`) VALUES
(1, 'ulzaalkindi', 'Ulza Alkindi', 'ulza.alkindi3@gmail.com', '$2y$10$VO0JQegsz958ZAiuFytGGenJqaE0PscQ/qjJSFWfY5c9KTxFLxMXO', 1, '2020-03-28 23:15:51', 1),
(8, 'cindymon', 'Cindy Monica Silitonga', 'rizaladinosu21@gmail.com', '$2y$10$/qOax2RV7SdW.qgG5c4JROI8N8O6CQkXTQDLSwMV4jmpeFhTUMg6i', 1, '2020-03-31 11:51:36', 2),
(9, 'liza', 'Liza Natalia', 'brokerjays6@gmail.com', '$2y$10$U58TK3z9n7FFLjM0qV1CaOpGgYwzWcY9Gecmii8alBguwMhkbBr4e', 1, '2020-03-31 11:59:22', 2),
(10, 'linda', 'Linda Kurniasih', 'linda@gmail.com', '$2y$10$CxgPm25iHWD3psql6T6uFu0SH2D19bQ0kQHpgdGofCVy7B.fRMAjW', 1, '2020-03-31 12:00:31', 2),
(14, 'iqbal', 'Yusuf Iqbal Cahyo', 'ulza.alkindi3@gmail.com', '$2y$10$.dcmidLToTFyR2UUX0tip.kMwZxk/hgpI4bkRfC4d.bOU8uN.ftN2', 1, '2020-04-01 10:48:39', 2),
(20, 'veland', 'Velandani Prakoso M. SOS', 'brokerjays6@gmail.com', '$2y$10$pq8tEyEgae30gVKDPEWxWeeXFl7S84QzxMjHHAVko7JzJRKv8oOq2', 1, '2020-04-06 14:22:42', 3),
(21, 'satrio', 'Satrio Pandega', 'satrio@gmail.com', '$2y$10$1yu4EiPJzX9ZE.0k7k9V7uYNHO1wMuBY4K88vZkmdbzZORQMQv.AO', 1, '2020-04-06 14:23:16', 3),
(24, 'galih', 'Galih Atmaja', 'jadiberkah0001@gmail.com', '$2y$10$wVOD3MtVcAGYd5HCK9dQEedoVnZvm.j7N1as/IXlgorq2FHJdqREW', 1, '2020-04-06 15:01:24', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idc`);

--
-- Indeks untuk tabel `devel`
--
ALTER TABLE `devel`
  ADD PRIMARY KEY (`idd`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  ADD PRIMARY KEY (`ide`);

--
-- Indeks untuk tabel `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `client`
--
ALTER TABLE `client`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `devel`
--
ALTER TABLE `devel`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `evaluasi`
--
ALTER TABLE `evaluasi`
  MODIFY `ide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `devel`
--
ALTER TABLE `devel`
  ADD CONSTRAINT `devel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
