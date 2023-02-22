-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2023 at 04:18 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_stok_warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_website`
--

CREATE TABLE `detail_website` (
  `detail_website_id` int(255) NOT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site_deskripsi` text DEFAULT NULL,
  `notelp` varchar(255) DEFAULT NULL,
  `nama_kontak` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `alamat_universitas` text DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `site_favicon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_website`
--

INSERT INTO `detail_website` (`detail_website_id`, `site_title`, `email`, `site_deskripsi`, `notelp`, `nama_kontak`, `facebook`, `instagram`, `youtube`, `telegram`, `alamat_universitas`, `images`, `site_favicon`) VALUES
(1, 'Aether Wotah', 'aethertech@gmail.com', 'Website Aplikasi Warehouse', '62812345678', 'Admin AetherWota', 'https://www.facebook.com/link_anda/', 'https://www.instagram.com/link_anda/', 'https://www.youtube.com/c/link_anda', 'https://t.me/link_anda', 'Jl. Gedung Arca Gg. Jawa No. 4 Medan, Sumatera Utara 20217', '083cde61f641b32b98afab9e7c5c5b01.jpg', 'cbbe7b63257146a21e7ef85d91704866.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_absensi`
--

CREATE TABLE `tbl_absensi` (
  `id_absensi` int(255) NOT NULL,
  `id_user_absensi` int(255) DEFAULT NULL,
  `ip_adress_absensi_masuk` varchar(255) DEFAULT NULL,
  `ip_adress_absensi_keluar` varchar(255) DEFAULT NULL,
  `tgl_absensi_masuk` timestamp NULL DEFAULT current_timestamp(),
  `tgl_absensi_keluar` timestamp NULL DEFAULT current_timestamp(),
  `ket_absensi` varchar(255) DEFAULT NULL,
  `kehadiran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_stock`
--

CREATE TABLE `tbl_add_stock` (
  `add_stock_id` int(255) NOT NULL,
  `kode_add_stock` varchar(255) DEFAULT NULL,
  `bahan_baku_id` int(255) DEFAULT NULL,
  `jumlah_add_stock` varchar(255) DEFAULT NULL,
  `biaya_dikeluarkan` varchar(255) DEFAULT NULL,
  `check_proses` int(10) DEFAULT 0,
  `add_stock_stock_user_id` int(255) DEFAULT NULL,
  `tgl_buat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cicil`
--

CREATE TABLE `tbl_cicil` (
  `id` int(255) NOT NULL,
  `kode_transaksi_cicil` varchar(255) DEFAULT NULL,
  `id_konsumen_cicil` int(255) DEFAULT NULL,
  `cicilan` varchar(255) DEFAULT NULL,
  `telah_dibayar` varchar(255) DEFAULT '0',
  `jumlah_telah_dibayar` varchar(255) DEFAULT '0',
  `jumlah_cicilan` varchar(255) DEFAULT NULL,
  `jenis_cicilan` varchar(255) DEFAULT NULL,
  `ket_cicilan` varchar(255) DEFAULT NULL,
  `id_user_cicil` int(255) DEFAULT NULL,
  `tgl_update` timestamp NULL DEFAULT current_timestamp(),
  `tgl_update_bayar` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home`
--

CREATE TABLE `tbl_home` (
  `home_id` int(11) NOT NULL,
  `home_caption_1` varchar(255) DEFAULT NULL,
  `home_caption_2` longtext DEFAULT NULL,
  `home_bg_heading` varchar(50) DEFAULT NULL,
  `home_bg_heading2` varchar(50) DEFAULT NULL,
  `home_bg_heading3` varchar(50) DEFAULT NULL,
  `home_bg_testimonial` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_home`
--

INSERT INTO `tbl_home` (`home_id`, `home_caption_1`, `home_caption_2`, `home_bg_heading`, `home_bg_heading2`, `home_bg_heading3`, `home_bg_testimonial`) VALUES
(1, 'Japanese Language NAT-TEST', 'The Japanese Language NAT-TEST is an examination that measures the Japanese language ability of students who are not native Japanese speakers.The tests are separated by difficulty (five levels) and general ability is measured in three categories: Grammar/Vocabulary, Listening and Reading Comprehension. The format of the exam and the types of questions are equivalent to those that appear on the Japanese-Language Proficiency Test (JLPT).', 'portfolio-details-1.jpg', 'portfolio-details-2.jpg', 'portfolio-details-3.jpg', 'nat-tes4.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_cicilan`
--

CREATE TABLE `tbl_jenis_cicilan` (
  `id_jenis_cicilan` int(255) NOT NULL,
  `nama_cicilan` varchar(255) DEFAULT NULL,
  `tenor` varchar(255) DEFAULT NULL,
  `jumlah_tenor` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_harga`
--

CREATE TABLE `tbl_jenis_harga` (
  `id_jenis_harga` int(255) NOT NULL,
  `kode_jharga` varchar(255) DEFAULT NULL,
  `nama_jenis_harga` varchar(255) DEFAULT NULL,
  `kategori_jenis` varchar(255) DEFAULT NULL,
  `jenis_harga` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(255) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_konsumen`
--

CREATE TABLE `tbl_konsumen` (
  `id_konsumen` int(255) NOT NULL,
  `id_cus` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `user_status` int(255) DEFAULT NULL,
  `hutang` int(255) DEFAULT NULL,
  `tgl_ubah_konsumen` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_retur_barang`
--

CREATE TABLE `tbl_list_retur_barang` (
  `retur_id` int(255) NOT NULL,
  `retur_kode_surat_jalan` varchar(255) DEFAULT NULL,
  `retur_bahan_baku_id` varchar(255) DEFAULT NULL,
  `retur_jumlah` int(255) DEFAULT NULL,
  `retur_nilai_saham` int(255) DEFAULT NULL,
  `retur_user_id` int(255) DEFAULT NULL,
  `retur_tgl_buat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_surat_jalan`
--

CREATE TABLE `tbl_list_surat_jalan` (
  `ls_surat_jalan_id` int(255) NOT NULL,
  `kode_ls_surat_jalan` varchar(255) DEFAULT NULL,
  `bahan_baku_id` varchar(255) DEFAULT NULL,
  `jumlah_ls_surat_jalan` int(255) DEFAULT NULL,
  `check_proses_ls_surat_jalan` int(10) DEFAULT 0,
  `ls_surat_jalan_user_id` int(255) DEFAULT NULL,
  `tgl_buat_ls_surat_jalan` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_transaksi`
--

CREATE TABLE `tbl_list_transaksi` (
  `id_transaksi` int(255) NOT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `id_konsumen_transaksi` int(255) DEFAULT NULL,
  `jumlah_pembelian` varchar(255) DEFAULT NULL,
  `jumlah_dibayar` varchar(255) DEFAULT NULL,
  `jenis_transaksi` varchar(255) DEFAULT NULL,
  `total_belanja` varchar(255) DEFAULT NULL,
  `dapatkan_hutang` varchar(255) DEFAULT NULL,
  `tenorbulan` varchar(255) DEFAULT NULL,
  `tenorcicil` varchar(255) DEFAULT NULL,
  `id_user_transaksi` int(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tgl_transaksi` timestamp NULL DEFAULT current_timestamp(),
  `tgl_ubah` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

CREATE TABLE `tbl_log` (
  `id` int(11) NOT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `tgl_log` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengeluaran`
--

CREATE TABLE `tbl_pengeluaran` (
  `id_pengeluaran` int(255) NOT NULL,
  `ket_pengeluaran` text DEFAULT NULL,
  `biaya_pengeluaran` int(255) DEFAULT NULL,
  `tgl_pengeluaran` timestamp NULL DEFAULT current_timestamp(),
  `imgbukti` varchar(255) DEFAULT NULL,
  `id_user_pengeluaran` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produksi_selesai`
--

CREATE TABLE `tbl_produksi_selesai` (
  `produksi_selesai_id` int(255) NOT NULL,
  `kode_produksi_selesai` varchar(255) DEFAULT NULL,
  `produksi_selesai_jenis` int(255) DEFAULT NULL,
  `produksi_selesai_jumlah` varchar(255) DEFAULT NULL,
  `produksi_selesai_biaya` varchar(255) DEFAULT NULL,
  `produksi_selesai_catatan` text DEFAULT NULL,
  `produksi_selesai_tgl` timestamp NULL DEFAULT current_timestamp(),
  `produksi_selesai_user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produksi_stock`
--

CREATE TABLE `tbl_produksi_stock` (
  `produksi_id` int(255) NOT NULL,
  `kode_produksi` varchar(255) DEFAULT NULL,
  `bahan_baku_id` int(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `biaya_dikeluarkan` varchar(255) DEFAULT NULL,
  `check_proses` int(10) DEFAULT 0,
  `produksi_stock_user_id` int(255) DEFAULT NULL,
  `tgl_buat` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekap_cash`
--

CREATE TABLE `tbl_rekap_cash` (
  `id_cash` int(255) NOT NULL,
  `id_cicil_cancel` int(255) DEFAULT NULL,
  `nota_cash` varchar(255) DEFAULT NULL,
  `ket_cash` text DEFAULT NULL,
  `total_cash` varchar(255) DEFAULT NULL,
  `tgl_cash` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rusak`
--

CREATE TABLE `tbl_rusak` (
  `produksi_id_rusak` int(255) NOT NULL,
  `kode_produksi_rusak` varchar(255) DEFAULT NULL,
  `bahan_baku_id_rusak` int(255) DEFAULT NULL,
  `jumlah_rusak` int(255) DEFAULT NULL,
  `biaya_dikeluarkan_rusak` int(255) DEFAULT NULL,
  `check_proses_rusak` int(10) DEFAULT 0,
  `produksi_stock_user_id_rusak` int(255) DEFAULT NULL,
  `tgl_buat_rusak` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `id_satuan` int(255) NOT NULL,
  `nama_satuan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_selesai_add_stock`
--

CREATE TABLE `tbl_selesai_add_stock` (
  `produksi_selesai_id` int(255) NOT NULL,
  `kode_add_stock_selesai` varchar(255) DEFAULT NULL,
  `add_stock_jumlah` varchar(255) DEFAULT NULL,
  `add_stock_selesai_biaya` varchar(255) DEFAULT NULL,
  `add_stock_catatan` text DEFAULT NULL,
  `add_stock_selesai_tgl` timestamp NULL DEFAULT current_timestamp(),
  `suplier` text DEFAULT NULL,
  `add_stock_selesai_user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site`
--

CREATE TABLE `tbl_site` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(100) DEFAULT NULL,
  `site_title` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `site_description` text DEFAULT NULL,
  `site_favicon` varchar(50) DEFAULT NULL,
  `site_logo_header` varchar(50) DEFAULT NULL,
  `site_logo_footer` varchar(50) DEFAULT NULL,
  `site_logo_big` varchar(50) DEFAULT NULL,
  `site_facebook` varchar(150) DEFAULT NULL,
  `site_twitter` varchar(150) DEFAULT NULL,
  `site_instagram` varchar(150) DEFAULT NULL,
  `site_youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_site`
--

INSERT INTO `tbl_site` (`site_id`, `site_name`, `site_title`, `site_description`, `site_favicon`, `site_logo_header`, `site_logo_footer`, `site_logo_big`, `site_facebook`, `site_twitter`, `site_instagram`, `site_youtube`) VALUES
(1, 'Admin Portal', 'Medan Test Center for Japanese Language NAT-TEST', 'Medan Test Center for Japanese Language NAT - TEST', 'nat-tes1.webp', 'Untitled-11.png', 'favicon.png', 'bg211.png', 'https://www.facebook.com/keeki/', 'https://twitter.com/keeki/', 'https://www.instagram.com/keeki/', 'https://www.youtube.com/c/keeki');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

CREATE TABLE `tbl_stock` (
  `id_stock` int(255) NOT NULL,
  `kode_stock` varchar(255) DEFAULT NULL,
  `nama_stock` varchar(255) DEFAULT NULL,
  `kategori_stock` int(255) DEFAULT NULL,
  `kategori_material` varchar(255) DEFAULT NULL,
  `satuan_stock` int(255) DEFAULT NULL,
  `harga_beli` int(255) DEFAULT NULL,
  `stock` varchar(255) DEFAULT '0',
  `stock_minimal` int(255) DEFAULT NULL,
  `nilai_saham` varchar(255) DEFAULT '0',
  `tgl_tambah` timestamp NULL DEFAULT current_timestamp(),
  `tgl_ubah` timestamp NULL DEFAULT current_timestamp(),
  `user_id_stock` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_produksi`
--

CREATE TABLE `tbl_stock_produksi` (
  `id_stock` int(255) NOT NULL,
  `kode_stock` varchar(255) DEFAULT NULL,
  `nama_stock` varchar(255) DEFAULT NULL,
  `kategori_stock` int(255) DEFAULT NULL,
  `kategori_material` varchar(255) DEFAULT NULL,
  `satuan_stock` int(255) DEFAULT NULL,
  `harga_beli` varchar(255) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `stock_minimal` int(255) DEFAULT NULL,
  `nilai_saham` varchar(255) DEFAULT NULL,
  `tgl_tambah` timestamp NULL DEFAULT current_timestamp(),
  `tgl_ubah` timestamp NULL DEFAULT current_timestamp(),
  `user_id_stock` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat_jalan`
--

CREATE TABLE `tbl_surat_jalan` (
  `surat_jalan_id` int(255) NOT NULL,
  `kode_surat_jalan` varchar(255) DEFAULT NULL,
  `jumlah_surat_jalan` varchar(255) DEFAULT NULL,
  `id_user_surat_jalan` int(255) DEFAULT NULL,
  `diserahkan_sj` varchar(255) DEFAULT NULL,
  `penerima_sj` varchar(255) DEFAULT NULL,
  `diketahui_sj` varchar(255) DEFAULT NULL,
  `catatan_surat_jalan` text DEFAULT NULL,
  `tgl_surat_jalan` timestamp NULL DEFAULT current_timestamp(),
  `tgl_ubah_surat_jalan` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `transaksi_id` int(255) NOT NULL,
  `kode_transaksi_list` varchar(255) DEFAULT NULL,
  `konsumen_transaksi_id` int(255) DEFAULT NULL,
  `bahan_baku_id` varchar(255) DEFAULT NULL,
  `jumlah_transaksi` varchar(255) DEFAULT NULL,
  `harga_jual_konsumen` varchar(255) DEFAULT NULL,
  `harga_jual_transaksi` varchar(255) DEFAULT NULL,
  `harga_modal_transaksi` varchar(255) DEFAULT NULL,
  `check_proses_transaksi` int(10) DEFAULT 0,
  `transaksi_user_id` int(255) DEFAULT NULL,
  `tgl_buat_transaksi` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(60) DEFAULT NULL,
  `user_password` varchar(40) DEFAULT NULL,
  `user_level` varchar(10) DEFAULT NULL,
  `user_status` varchar(10) DEFAULT '1',
  `user_photo` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_level`, `user_status`, `user_photo`) VALUES
(1, 'Zikry', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', '1', '6d86194de5b5455fd90f1ae951307d45.webp'),
(2, 'Hendra Ekspedisi', 'ekspedisi@gmail.com', '928920597d85e012970304984e633a5a', '3', '1', '0455c308a1c9922f734fd2d977b34fe8.webp'),
(3, 'Rahmat Warehouse', 'warehouse@gmail.com', '372d30dd2849813ef674855253900679', '2', '1', '8cf49c4c37f819e7cb3a1fbdb82955a2.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_website`
--
ALTER TABLE `detail_website`
  ADD PRIMARY KEY (`detail_website_id`);

--
-- Indexes for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `tbl_add_stock`
--
ALTER TABLE `tbl_add_stock`
  ADD PRIMARY KEY (`add_stock_id`);

--
-- Indexes for table `tbl_cicil`
--
ALTER TABLE `tbl_cicil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home`
--
ALTER TABLE `tbl_home`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `tbl_jenis_cicilan`
--
ALTER TABLE `tbl_jenis_cicilan`
  ADD PRIMARY KEY (`id_jenis_cicilan`);

--
-- Indexes for table `tbl_jenis_harga`
--
ALTER TABLE `tbl_jenis_harga`
  ADD PRIMARY KEY (`id_jenis_harga`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_konsumen`
--
ALTER TABLE `tbl_konsumen`
  ADD PRIMARY KEY (`id_konsumen`);

--
-- Indexes for table `tbl_list_retur_barang`
--
ALTER TABLE `tbl_list_retur_barang`
  ADD PRIMARY KEY (`retur_id`);

--
-- Indexes for table `tbl_list_surat_jalan`
--
ALTER TABLE `tbl_list_surat_jalan`
  ADD PRIMARY KEY (`ls_surat_jalan_id`);

--
-- Indexes for table `tbl_list_transaksi`
--
ALTER TABLE `tbl_list_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_log`
--
ALTER TABLE `tbl_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tbl_produksi_selesai`
--
ALTER TABLE `tbl_produksi_selesai`
  ADD PRIMARY KEY (`produksi_selesai_id`);

--
-- Indexes for table `tbl_produksi_stock`
--
ALTER TABLE `tbl_produksi_stock`
  ADD PRIMARY KEY (`produksi_id`);

--
-- Indexes for table `tbl_rekap_cash`
--
ALTER TABLE `tbl_rekap_cash`
  ADD PRIMARY KEY (`id_cash`);

--
-- Indexes for table `tbl_rusak`
--
ALTER TABLE `tbl_rusak`
  ADD PRIMARY KEY (`produksi_id_rusak`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tbl_selesai_add_stock`
--
ALTER TABLE `tbl_selesai_add_stock`
  ADD PRIMARY KEY (`produksi_selesai_id`);

--
-- Indexes for table `tbl_site`
--
ALTER TABLE `tbl_site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indexes for table `tbl_stock_produksi`
--
ALTER TABLE `tbl_stock_produksi`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indexes for table `tbl_surat_jalan`
--
ALTER TABLE `tbl_surat_jalan`
  ADD PRIMARY KEY (`surat_jalan_id`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`transaksi_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_website`
--
ALTER TABLE `detail_website`
  MODIFY `detail_website_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  MODIFY `id_absensi` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_add_stock`
--
ALTER TABLE `tbl_add_stock`
  MODIFY `add_stock_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cicil`
--
ALTER TABLE `tbl_cicil`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_home`
--
ALTER TABLE `tbl_home`
  MODIFY `home_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_jenis_cicilan`
--
ALTER TABLE `tbl_jenis_cicilan`
  MODIFY `id_jenis_cicilan` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_jenis_harga`
--
ALTER TABLE `tbl_jenis_harga`
  MODIFY `id_jenis_harga` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_konsumen`
--
ALTER TABLE `tbl_konsumen`
  MODIFY `id_konsumen` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_list_retur_barang`
--
ALTER TABLE `tbl_list_retur_barang`
  MODIFY `retur_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_list_surat_jalan`
--
ALTER TABLE `tbl_list_surat_jalan`
  MODIFY `ls_surat_jalan_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_list_transaksi`
--
ALTER TABLE `tbl_list_transaksi`
  MODIFY `id_transaksi` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_log`
--
ALTER TABLE `tbl_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pengeluaran`
--
ALTER TABLE `tbl_pengeluaran`
  MODIFY `id_pengeluaran` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_produksi_selesai`
--
ALTER TABLE `tbl_produksi_selesai`
  MODIFY `produksi_selesai_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_produksi_stock`
--
ALTER TABLE `tbl_produksi_stock`
  MODIFY `produksi_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rekap_cash`
--
ALTER TABLE `tbl_rekap_cash`
  MODIFY `id_cash` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_rusak`
--
ALTER TABLE `tbl_rusak`
  MODIFY `produksi_id_rusak` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `id_satuan` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_selesai_add_stock`
--
ALTER TABLE `tbl_selesai_add_stock`
  MODIFY `produksi_selesai_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_site`
--
ALTER TABLE `tbl_site`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  MODIFY `id_stock` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stock_produksi`
--
ALTER TABLE `tbl_stock_produksi`
  MODIFY `id_stock` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_surat_jalan`
--
ALTER TABLE `tbl_surat_jalan`
  MODIFY `surat_jalan_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `transaksi_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
