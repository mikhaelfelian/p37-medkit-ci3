-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_medkit_ci3.tbl_pengaturan
DROP TABLE IF EXISTS `tbl_pengaturan`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `id_pengaturan` int(3) NOT NULL AUTO_INCREMENT,
  `id_app` int(3) NOT NULL DEFAULT 0,
  `website` varchar(100) NOT NULL,
  `judul` varchar(500) NOT NULL,
  `judul_app` varchar(500) NOT NULL,
  `url_app` varchar(500) NOT NULL,
  `logo` varchar(500) NOT NULL,
  `logo_header` varchar(500) NOT NULL,
  `logo_header_kop` varchar(500) NOT NULL,
  `deskripsi` text NOT NULL,
  `deskripsi_pendek` text NOT NULL,
  `notifikasi` varchar(320) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `email` varchar(360) NOT NULL,
  `pesan` text NOT NULL,
  `tlp` varchar(160) NOT NULL,
  `fax` varchar(160) NOT NULL,
  `url_antrian` varchar(160) NOT NULL,
  `ss_org_id` text NOT NULL,
  `ss_client_id` text NOT NULL,
  `ss_client_secret` text NOT NULL,
  `kode_surat_sht` varchar(50) NOT NULL,
  `kode_surat_skt` varchar(50) NOT NULL,
  `kode_surat_rnp` varchar(50) NOT NULL,
  `kode_surat_kntrl` varchar(50) NOT NULL,
  `kode_surat_lahir` varchar(50) NOT NULL,
  `kode_surat_mati` varchar(50) NOT NULL,
  `kode_surat_covid` varchar(50) NOT NULL,
  `kode_surat_rujukan` varchar(50) NOT NULL,
  `kode_surat_tht` varchar(50) NOT NULL,
  `kode_surat` varchar(50) NOT NULL,
  `kode_resep` varchar(50) NOT NULL,
  `kode_rad` varchar(50) NOT NULL,
  `kode_periksa` varchar(50) NOT NULL,
  `kode_pasien` varchar(50) NOT NULL,
  `apt_apa` varchar(160) NOT NULL,
  `apt_sipa` varchar(160) NOT NULL,
  `ppn` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ppn_tot` int(11) NOT NULL,
  `jml_ppn` int(11) NOT NULL,
  `jml_item` int(11) NOT NULL,
  `jml_limit_stok` int(11) NOT NULL,
  `jml_limit_tempo` int(11) NOT NULL,
  `jml_poin` int(11) NOT NULL,
  `jml_poin_nom` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tahun_poin` int(11) NOT NULL,
  `status_app` enum('pusat','cabang') NOT NULL,
  PRIMARY KEY (`id_pengaturan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_medkit_ci3.tbl_pengaturan: ~1 rows (approximately)
DELETE FROM `tbl_pengaturan`;
INSERT INTO `tbl_pengaturan` (`id_pengaturan`, `id_app`, `website`, `judul`, `judul_app`, `url_app`, `logo`, `logo_header`, `logo_header_kop`, `deskripsi`, `deskripsi_pendek`, `notifikasi`, `alamat`, `kota`, `email`, `pesan`, `tlp`, `fax`, `url_antrian`, `ss_org_id`, `ss_client_id`, `ss_client_secret`, `kode_surat_sht`, `kode_surat_skt`, `kode_surat_rnp`, `kode_surat_kntrl`, `kode_surat_lahir`, `kode_surat_mati`, `kode_surat_covid`, `kode_surat_rujukan`, `kode_surat_tht`, `kode_surat`, `kode_resep`, `kode_rad`, `kode_periksa`, `kode_pasien`, `apt_apa`, `apt_sipa`, `ppn`, `ppn_tot`, `jml_ppn`, `jml_item`, `jml_limit_stok`, `jml_limit_tempo`, `jml_poin`, `jml_poin_nom`, `tahun_poin`, `status_app`) VALUES
	(1, 1, 'esensia.co.id', 'KLINIK UTAMA & LABORATORIUM "ESENSIA"', 'Medkit', 'https://simrs.esensia.co.id', 'logo-esensia-rs.png', 'logo-only.png', 'logo-esensia-2.png', 'logo-es-2.png\r\nKLINIK UTAMA RAWAT JALAN & INAP "ESENSIA"', 'KLINIK RAWAT JALAN & INAP "ESENSIA"', '', 'Jl. Wolter Monginsidi No. 40 Pedurungan - Semarang', 'Semarang', 'cs.esensia@gmail.com', '', 'Telp. (024) 76411636, 6714764', '', 'http://localhost/antrian2', '100018572', 'CeClLF3u1MJ06OpjirNOkPUWiPGBZmzIIyfP6IILYKVBDw7z', 'uvjqFLAEDm7XiijA1Zko8i9pfyMw7xVp8rpybeDTCQyvIoepfYFWiW0jFnbXpPso', 'SKS-ES', 'SKN-ES', 'SKRI-ES', 'SKn-ES', 'DOC-EH', 'DOC-EH', 'DOC-EH', 'DOC-EH', 'SKS-THT', 'DOC-EH', 'PRSC', 'SKRAD-ES', 'SKP', 'PKE', 'Apt. Ungsari Rizki Eka Purwanto, M.Sc--', '449.1/61/DPM-PTSP/SIPA/II/2022', 1.11, 111, 11, 15, 12, 10, 500, 50000.00, 2024, '');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
