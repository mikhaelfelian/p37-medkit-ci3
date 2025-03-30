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


-- Dumping database structure for db_medkit_ci3
DROP DATABASE IF EXISTS `db_medkit_ci3`;
CREATE DATABASE IF NOT EXISTS `db_medkit_ci3` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `db_medkit_ci3`;

-- Dumping structure for table db_medkit_ci3.admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `id_poli` int(11) NOT NULL DEFAULT 0,
  `poli` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `cpostname` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `level_user` varchar(15) NOT NULL DEFAULT 'user',
  `email` varchar(25) DEFAULT NULL,
  `no_telp` varchar(25) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `nip` varchar(5) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `datelogin` datetime NOT NULL,
  `cUser` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `datecreate` datetime NOT NULL,
  `dateupdate` datetime NOT NULL,
  `photo` varchar(100) NOT NULL,
  `kd_approve` int(3) NOT NULL,
  `aboutme` text DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `google+` varchar(100) DEFAULT NULL,
  `patch` varchar(100) DEFAULT NULL,
  `ccode` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `crgcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cmainmenu` varchar(10) DEFAULT NULL,
  `csubmenu` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_user`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.adm_menu
DROP TABLE IF EXISTS `adm_menu`;
CREATE TABLE IF NOT EXISTS `adm_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `class_` varchar(15) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `parentid` int(3) DEFAULT NULL,
  `cUser` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `dCreateDate` datetime DEFAULT '0000-00-00 00:00:00',
  `dLastUpdate` datetime DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.adm_smenu
DROP TABLE IF EXISTS `adm_smenu`;
CREATE TABLE IF NOT EXISTS `adm_smenu` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `class_` varchar(15) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `parentid` int(3) DEFAULT NULL,
  `add` int(1) DEFAULT 1,
  `edit` int(1) DEFAULT 1,
  `del` int(1) DEFAULT 1,
  `cUser` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `dCreateDate` datetime DEFAULT '0000-00-00 00:00:00',
  `dLastUpdate` datetime DEFAULT NULL,
  `aktif` varchar(1) DEFAULT 'y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.ci_sessions
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mcompany
DROP TABLE IF EXISTS `mcompany`;
CREATE TABLE IF NOT EXISTS `mcompany` (
  `id` int(11) NOT NULL,
  `cCode` varchar(5) NOT NULL DEFAULT '',
  `cName` varchar(50) NOT NULL DEFAULT '',
  `cTitle` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cAddress1` varchar(50) NOT NULL DEFAULT '',
  `cAddress2` varchar(50) DEFAULT '',
  `cAddress3` varchar(50) DEFAULT '',
  `cCity` varchar(30) DEFAULT '',
  `cCodeNation` varchar(10) DEFAULT '',
  `cContact` varchar(50) DEFAULT '',
  `cPhone1` varchar(20) DEFAULT '',
  `cPhone2` varchar(20) DEFAULT '',
  `cPhone3` varchar(20) DEFAULT '',
  `cFax1` varchar(20) DEFAULT '',
  `cFax2` varchar(20) DEFAULT '',
  `cEmail` varchar(50) DEFAULT '',
  `cnpwp` varchar(50) DEFAULT '',
  `ctaxaddress` varchar(50) DEFAULT '',
  `cFaxRegNo` varchar(50) DEFAULT '',
  `cPresident` varchar(50) DEFAULT '',
  `cAccountDir` varchar(50) DEFAULT '',
  `ctechnicDir` varchar(50) DEFAULT '',
  `cMarketDir` varchar(50) DEFAULT '',
  `cLabel` longblob DEFAULT NULL,
  `dCurrDate` datetime DEFAULT NULL,
  `dCreateDate` datetime DEFAULT NULL,
  `dLastUpdate` datetime DEFAULT NULL,
  `SUser` varchar(10) DEFAULT '',
  `cLogo` varchar(100) DEFAULT NULL,
  `cDefault` varchar(1) DEFAULT '',
  `cMemo` longtext DEFAULT NULL,
  `cWall` longblob DEFAULT NULL,
  `sWall` longtext DEFAULT NULL,
  `cbank` varchar(5) DEFAULT '',
  `cnorek` varchar(25) DEFAULT NULL,
  `cTaxdir` varchar(100) DEFAULT '',
  `cRegCode` varchar(3) DEFAULT '',
  `cCoaCode` char(2) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mdepart
DROP TABLE IF EXISTS `mdepart`;
CREATE TABLE IF NOT EXISTS `mdepart` (
  `id` int(11) NOT NULL,
  `cCode` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `cCompname` varchar(35) DEFAULT NULL,
  `cRgCode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cRgName` varchar(50) DEFAULT NULL,
  `cDeptcode` varchar(3) NOT NULL,
  `cDeptname` varchar(25) NOT NULL,
  `cFlag` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mkotakab
DROP TABLE IF EXISTS `mkotakab`;
CREATE TABLE IF NOT EXISTS `mkotakab` (
  `id` int(125) NOT NULL,
  `KdKab` varchar(125) NOT NULL,
  `NmKabKot` varchar(125) NOT NULL,
  `kordinat` varchar(25) DEFAULT NULL,
  `PusPem` varchar(125) NOT NULL,
  `NmKabKotLkp` varchar(125) NOT NULL,
  `KdKbKt` varchar(125) NOT NULL,
  `KdProp` varchar(125) NOT NULL,
  `NoBPS` varchar(125) NOT NULL,
  `LWil` double NOT NULL,
  `JmlPendd2` int(11) NOT NULL,
  `TSeptik` int(11) NOT NULL,
  `TTSeptik` int(11) NOT NULL,
  `TdkPunya` int(11) NOT NULL,
  `TAFasBAB` int(11) NOT NULL,
  `UserName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mmenu
DROP TABLE IF EXISTS `mmenu`;
CREATE TABLE IF NOT EXISTS `mmenu` (
  `menu_id` int(11) DEFAULT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `class_` varchar(15) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `parentid` int(3) DEFAULT NULL,
  `aktif` varchar(1) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mmenu_sb
DROP TABLE IF EXISTS `mmenu_sb`;
CREATE TABLE IF NOT EXISTS `mmenu_sb` (
  `menu_id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `class_` varchar(15) DEFAULT NULL,
  `icon` varchar(40) NOT NULL,
  `link` varchar(100) NOT NULL,
  `parentid` int(11) NOT NULL,
  `aktif` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mpoli
DROP TABLE IF EXISTS `mpoli`;
CREATE TABLE IF NOT EXISTS `mpoli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_poli` int(11) NOT NULL DEFAULT 0,
  `id_view` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kode` varchar(50) NOT NULL,
  `poli` varchar(160) NOT NULL,
  `icon` varchar(50) NOT NULL DEFAULT 'fa-hospital-o',
  `style` varchar(50) NOT NULL DEFAULT 'btn-info',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `status_tmpl` enum('0','1','2') NOT NULL DEFAULT '0',
  `status_ant` enum('0','1') NOT NULL DEFAULT '1',
  `sp` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'SP = 1 untuk di depan',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mposition
DROP TABLE IF EXISTS `mposition`;
CREATE TABLE IF NOT EXISTS `mposition` (
  `id` int(11) NOT NULL,
  `cposcode` varchar(5) DEFAULT NULL,
  `cpostname` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mprofile
DROP TABLE IF EXISTS `mprofile`;
CREATE TABLE IF NOT EXISTS `mprofile` (
  `cid` int(11) NOT NULL,
  `cnama` varchar(100) DEFAULT NULL,
  `calamat` varchar(100) DEFAULT NULL,
  `ckota` varchar(50) DEFAULT NULL,
  `chp` varchar(30) DEFAULT NULL,
  `cfax` varchar(30) DEFAULT NULL,
  `cemail` varchar(50) DEFAULT NULL,
  `clogo` varchar(100) DEFAULT NULL,
  `cjudul` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mprov
DROP TABLE IF EXISTS `mprov`;
CREATE TABLE IF NOT EXISTS `mprov` (
  `id` int(11) NOT NULL,
  `cProvCode` varchar(15) DEFAULT '',
  `cProvName` varchar(100) DEFAULT '',
  `cLandCode` varchar(100) DEFAULT '',
  `cLogoProv` longtext DEFAULT NULL,
  `cCoordninat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mregion
DROP TABLE IF EXISTS `mregion`;
CREATE TABLE IF NOT EXISTS `mregion` (
  `id` int(11) NOT NULL,
  `cCode` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `cCompname` varchar(35) DEFAULT NULL,
  `cProvName` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cRgCode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cRgName` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cIrisCode` varchar(5) DEFAULT NULL,
  `cAlamat` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cNoTelepon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cMobile` varchar(20) DEFAULT NULL,
  `cNoFax` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKota` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKacabang` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKamarketing` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKaservice` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKasparepart` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cKakeu` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cDealerCode` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cService` int(2) NOT NULL DEFAULT 0,
  `cSales` int(2) NOT NULL DEFAULT 0,
  `cDownpay` int(2) NOT NULL DEFAULT 0,
  `cCoaCode` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cRgStatus` char(3) NOT NULL DEFAULT 'CAB',
  `cNoRegis` char(3) DEFAULT '001'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.mview
DROP TABLE IF EXISTS `mview`;
CREATE TABLE IF NOT EXISTS `mview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT current_timestamp(),
  `kode` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_ion_groups
DROP TABLE IF EXISTS `tbl_ion_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `akses` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_ion_login_attempts
DROP TABLE IF EXISTS `tbl_ion_login_attempts`;
CREATE TABLE IF NOT EXISTS `tbl_ion_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_ion_modules
DROP TABLE IF EXISTS `tbl_ion_modules`;
CREATE TABLE IF NOT EXISTS `tbl_ion_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL DEFAULT 0,
  `modules` varchar(50) DEFAULT NULL,
  `modules_action` varchar(50) DEFAULT NULL,
  `modules_name` varchar(50) DEFAULT NULL,
  `modules_route` varchar(50) DEFAULT NULL,
  `modules_param` varchar(50) DEFAULT NULL,
  `modules_icon` varchar(50) DEFAULT NULL,
  `is_parent` enum('0','1') DEFAULT '0',
  `is_sidebar` enum('0','1') DEFAULT '0',
  `is_view` enum('0','1') DEFAULT '0',
  `is_save` enum('0','1') DEFAULT '0',
  `is_update` enum('0','1') DEFAULT '0',
  `is_delete` enum('0','1') DEFAULT '0',
  `note` text DEFAULT NULL,
  `sort` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_ion_users
DROP TABLE IF EXISTS `tbl_ion_users`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `id_app` int(11) unsigned NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_selector` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `remember_selector` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned DEFAULT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `nama_dpn` varchar(50) DEFAULT NULL,
  `nama_blk` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `pss` varchar(50) DEFAULT NULL,
  `file_name` text DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `status_gudang` enum('0','1','2') DEFAULT '0',
  `tipe` enum('0','1','2') DEFAULT '1' COMMENT '0=none;\r\n1=karyawan;\r\n2=pasien;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59946 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_ion_users_groups
DROP TABLE IF EXISTS `tbl_ion_users_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `group_id` mediumint(8) unsigned DEFAULT NULL,
  `access` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `tbl_ion_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_ion_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=84100 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_ass_pny
DROP TABLE IF EXISTS `tbl_m_ass_pny`;
CREATE TABLE IF NOT EXISTS `tbl_m_ass_pny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 41,
  `tgl_simpan` datetime DEFAULT current_timestamp(),
  `kode` varchar(50) DEFAULT NULL,
  `penyakit` varchar(160) DEFAULT NULL,
  `satuan` varchar(160) DEFAULT NULL,
  `nilai` varchar(160) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '1',
  `tipe` int(11) DEFAULT 16,
  `status_posisi` enum('N','L','R') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel data asesment berisi tentang data nama penyakit';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_departemen
DROP TABLE IF EXISTS `tbl_m_departemen`;
CREATE TABLE IF NOT EXISTS `tbl_m_departemen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `dept` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data departemen / divisi';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_gelar
DROP TABLE IF EXISTS `tbl_m_gelar`;
CREATE TABLE IF NOT EXISTS `tbl_m_gelar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gelar` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_gudang
DROP TABLE IF EXISTS `tbl_m_gudang`;
CREATE TABLE IF NOT EXISTS `tbl_m_gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode` varchar(160) DEFAULT NULL,
  `gudang` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1','2','3') DEFAULT NULL COMMENT '1 = Gudang aktif\r\n2 = Gudang Bazar (tertentu)\r\n0 = Gudang simpan (stok)\r\n3 = Gudang Brg Keluar / Pinjam / dll',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_icd
DROP TABLE IF EXISTS `tbl_m_icd`;
CREATE TABLE IF NOT EXISTS `tbl_m_icd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_modif` datetime DEFAULT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `icd` text DEFAULT NULL,
  `diagnosa_en` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_icd` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18552 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data tentang ICD 10 (Daftar Penyakit).\r\nsesuai satu sehat';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_jabatan
DROP TABLE IF EXISTS `tbl_m_jabatan`;
CREATE TABLE IF NOT EXISTS `tbl_m_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data jabatan';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_jenis_kerja
DROP TABLE IF EXISTS `tbl_m_jenis_kerja`;
CREATE TABLE IF NOT EXISTS `tbl_m_jenis_kerja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_kamar
DROP TABLE IF EXISTS `tbl_m_kamar`;
CREATE TABLE IF NOT EXISTS `tbl_m_kamar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT current_timestamp(),
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `kamar` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `jml` int(11) DEFAULT 0,
  `jml_max` int(11) DEFAULT 0,
  `style` varchar(50) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk Menyimpan data kamar';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan
DROP TABLE IF EXISTS `tbl_m_karyawan`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_app` int(4) DEFAULT 0,
  `id_user` int(4) DEFAULT 0,
  `id_poli` int(4) DEFAULT 0,
  `id_user_group` int(4) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `kategori` varchar(10) DEFAULT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `sip` varchar(100) DEFAULT NULL,
  `str` varchar(100) DEFAULT NULL,
  `no_ijin` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT '0000-00-00',
  `tmp_lahir` varchar(100) DEFAULT NULL,
  `nama_dpn` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nama_blk` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `alamat_dom` text DEFAULT NULL,
  `jabatan` varchar(160) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `jns_klm` enum('L','P','') DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `no_rmh` varchar(160) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `file_ext` varchar(10) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1=perawat\\r\\n2=dokter\\r\\n3=kasir\\r\\n4=analis\\r\\n5=radiografer\\r\\n6=farmasi',
  `status_aps` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_absen
DROP TABLE IF EXISTS `tbl_m_karyawan_absen`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_absen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `wkt_masuk` time DEFAULT '00:00:00',
  `wkt_keluar` time DEFAULT '00:00:00',
  `scan1` time DEFAULT '00:00:00',
  `scan2` time DEFAULT '00:00:00',
  `scan3` time DEFAULT '00:00:00',
  `scan4` time DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_jadwal
DROP TABLE IF EXISTS `tbl_m_karyawan_jadwal`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_poli` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `hari_1` varchar(50) DEFAULT NULL,
  `hari_2` varchar(50) DEFAULT NULL,
  `hari_3` varchar(50) DEFAULT NULL,
  `hari_4` varchar(50) DEFAULT NULL,
  `hari_5` varchar(50) DEFAULT NULL,
  `hari_6` varchar(50) DEFAULT NULL,
  `hari_7` varchar(50) DEFAULT NULL,
  `waktu` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_prtk` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_m_karyawan_jadwal_tbl_m_karyawan` (`id_karyawan`),
  CONSTRAINT `FK_tbl_m_karyawan_jadwal_tbl_m_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `tbl_m_karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data riwayat sertifikasi karyawan';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_kel
DROP TABLE IF EXISTS `tbl_m_karyawan_kel`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_kel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `nm_ayah` varchar(160) DEFAULT NULL,
  `nm_ibu` varchar(160) DEFAULT NULL,
  `nm_pasangan` varchar(160) DEFAULT NULL,
  `nm_anak` text DEFAULT NULL,
  `tgl_lhr_ayah` date DEFAULT '0000-00-00',
  `tgl_lhr_ibu` date DEFAULT '0000-00-00',
  `tgl_lhr_psg` date DEFAULT '0000-00-00',
  `jns_pasangan` enum('0','1','2') DEFAULT '0',
  `file_name` varchar(160) DEFAULT NULL,
  `file_name_ktp` varchar(160) DEFAULT NULL,
  `file_ext` varchar(160) DEFAULT NULL,
  `file_ext_ktp` varchar(160) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_type_ktp` varchar(50) DEFAULT NULL,
  `status_kawin` enum('0','1','2','3') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_peg
DROP TABLE IF EXISTS `tbl_m_karyawan_peg`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_peg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dept` int(11) DEFAULT 0,
  `id_jabatan` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `kode` varchar(160) DEFAULT NULL,
  `no_bpjs_tk` varchar(50) DEFAULT NULL,
  `no_bpjs_ks` varchar(50) DEFAULT NULL,
  `no_npwp` varchar(50) DEFAULT NULL,
  `no_ptkp` varchar(5) DEFAULT NULL,
  `no_rek` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tipe` int(11) DEFAULT 0 COMMENT 'Status karyawan kotrak, dll',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_karyawan_peg_tbl_m_karyawan` (`id_karyawan`),
  CONSTRAINT `FK_tbl_m_karyawan_peg_tbl_m_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `tbl_m_karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_pend
DROP TABLE IF EXISTS `tbl_m_karyawan_pend`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_pend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `no_dok` varchar(160) DEFAULT NULL,
  `pendidikan` varchar(160) DEFAULT NULL,
  `jurusan` varchar(160) DEFAULT NULL,
  `instansi` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `thn_masuk` year(4) DEFAULT NULL,
  `thn_keluar` year(4) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `file_ext` varchar(160) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `status_lulus` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_karyawan_pend_tbl_m_karyawan` (`id_karyawan`),
  CONSTRAINT `FK_tbl_m_karyawan_pend_tbl_m_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `tbl_m_karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data riwayat pendidikan karyawan';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_poli
DROP TABLE IF EXISTS `tbl_m_karyawan_poli`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_poli` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK__tbl_m_karyawan` (`id_karyawan`),
  CONSTRAINT `FK__tbl_m_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `tbl_m_karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_sert
DROP TABLE IF EXISTS `tbl_m_karyawan_sert`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_sert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `no_dok` varchar(160) DEFAULT NULL,
  `pt` varchar(160) DEFAULT NULL,
  `instansi` varchar(160) DEFAULT NULL,
  `tipe` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `file_name` varchar(160) DEFAULT NULL,
  `file_ext` varchar(160) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_m_karyawan_pend_tbl_m_karyawan` (`id_karyawan`) USING BTREE,
  CONSTRAINT `FK_tbl_m_karyawan_sert_tbl_m_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `tbl_m_karyawan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan data riwayat sertifikasi karyawan';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_karyawan_tipe
DROP TABLE IF EXISTS `tbl_m_karyawan_tipe`;
CREATE TABLE IF NOT EXISTS `tbl_m_karyawan_tipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_kategori
DROP TABLE IF EXISTS `tbl_m_kategori`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `status_lab` enum('0','1') DEFAULT '0',
  `status_stok` enum('0','1') DEFAULT '1',
  `status` enum('0','1') DEFAULT '1' COMMENT '0=disabled;\r\n1=aktif;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_kategori_cuti
DROP TABLE IF EXISTS `tbl_m_kategori_cuti`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori_cuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_kategori_spiro
DROP TABLE IF EXISTS `tbl_m_kategori_spiro`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori_spiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `jml_ukur` decimal(10,2) DEFAULT 0.00,
  `jml_pred` decimal(10,2) DEFAULT 0.00,
  `jml_pred2` decimal(10,2) DEFAULT 0.00 COMMENT 'Dalam jumlah persen',
  `jml_lln` decimal(10,2) DEFAULT 0.00,
  `status` enum('0','1') DEFAULT '1' COMMENT '0=disabled;\\r\\n1=aktif;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_mcu
DROP TABLE IF EXISTS `tbl_m_mcu`;
CREATE TABLE IF NOT EXISTS `tbl_m_mcu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `id_kategori` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `pemeriksaan` varchar(160) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `status_bag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_mcu_header
DROP TABLE IF EXISTS `tbl_m_mcu_header`;
CREATE TABLE IF NOT EXISTS `tbl_m_mcu_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `param` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Table untuk MCU Header';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_mcu_kat
DROP TABLE IF EXISTS `tbl_m_mcu_kat`;
CREATE TABLE IF NOT EXISTS `tbl_m_mcu_kat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kat` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(60) DEFAULT NULL,
  `kategori` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `status_utm` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_mcu_pny
DROP TABLE IF EXISTS `tbl_m_mcu_pny`;
CREATE TABLE IF NOT EXISTS `tbl_m_mcu_pny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `penyakit` varchar(50) DEFAULT NULL,
  `status_tmp` enum('0','1','2') DEFAULT '0' COMMENT '0=default\r\n1=Sisi Kiri\r\n2=Sisi Kanan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data Penyakit pada modul MCU';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_merk
DROP TABLE IF EXISTS `tbl_m_merk`;
CREATE TABLE IF NOT EXISTS `tbl_m_merk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `merk` varchar(160) DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pasien
DROP TABLE IF EXISTS `tbl_m_pasien`;
CREATE TABLE IF NOT EXISTS `tbl_m_pasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gelar` int(11) DEFAULT 0,
  `id_kategori` int(11) DEFAULT 0,
  `id_pekerjaan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `kode_dpn` varchar(50) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `nama` varchar(160) DEFAULT NULL,
  `nama_pgl` varchar(160) DEFAULT NULL,
  `no_telp` varchar(50) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `no_rmh` varchar(50) DEFAULT NULL,
  `tmp_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `alamat_dom` text DEFAULT NULL,
  `kel` varchar(50) DEFAULT NULL,
  `instansi` varchar(160) DEFAULT NULL,
  `instansi_alamat` text DEFAULT NULL,
  `kec` varchar(50) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `file_name` varchar(50) DEFAULT NULL,
  `file_name_id` varchar(50) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_ext` varchar(50) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL COMMENT 'Foto Pasien',
  `alergi` text DEFAULT NULL,
  `jns_klm` enum('L','P') DEFAULT 'L',
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `status_pas` enum('0','1','2') NOT NULL DEFAULT '0',
  `sp` enum('0','1','2') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51506 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pasien_poin
DROP TABLE IF EXISTS `tbl_m_pasien_poin`;
CREATE TABLE IF NOT EXISTS `tbl_m_pasien_poin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `jml_poin` decimal(10,2) DEFAULT 0.00,
  `jml_poin_nom` decimal(10,2) DEFAULT 0.00,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_pasien_poin_tbl_m_pasien` (`id_pasien`),
  CONSTRAINT `FK_tbl_m_pasien_poin_tbl_m_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `tbl_m_pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48945 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan
DROP TABLE IF EXISTS `tbl_m_pelanggan`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode` varchar(160) DEFAULT NULL,
  `nik` varchar(160) DEFAULT NULL,
  `nama` varchar(360) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(160) DEFAULT NULL,
  `cp` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan_agt
DROP TABLE IF EXISTS `tbl_m_pelanggan_agt`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_agt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan_grup` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `potongan` decimal(13,2) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan_deposit
DROP TABLE IF EXISTS `tbl_m_pelanggan_deposit`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT 0,
  `id_pelanggan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `jml_deposit` decimal(32,4) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan_deposit_hist
DROP TABLE IF EXISTS `tbl_m_pelanggan_deposit_hist`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_deposit_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `jml_deposit` decimal(32,4) NOT NULL,
  `debet` decimal(32,4) NOT NULL,
  `kredit` decimal(32,4) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan_diskon
DROP TABLE IF EXISTS `tbl_m_pelanggan_diskon`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_diskon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL DEFAULT 0,
  `id_kategori` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL,
  `disk1` decimal(10,2) NOT NULL DEFAULT 0.00,
  `disk2` decimal(10,2) NOT NULL DEFAULT 0.00,
  `disk3` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_pelanggan_diskon_tbl_m_pelanggan` (`id_pelanggan`),
  CONSTRAINT `FK_tbl_m_pelanggan_diskon_tbl_m_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_m_pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1660 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_pelanggan_grup
DROP TABLE IF EXISTS `tbl_m_pelanggan_grup`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_grup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `grup` varchar(160) NOT NULL DEFAULT '0',
  `pot_nominal` decimal(13,2) NOT NULL DEFAULT 0.00,
  `pot_persen` decimal(13,2) NOT NULL DEFAULT 0.00,
  `keterangan` text NOT NULL,
  `status_deposit` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_penjamin
DROP TABLE IF EXISTS `tbl_m_penjamin`;
CREATE TABLE IF NOT EXISTS `tbl_m_penjamin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT current_timestamp(),
  `kode` varchar(160) DEFAULT NULL,
  `penjamin` varchar(160) DEFAULT NULL,
  `persen` decimal(10,2) DEFAULT 0.00,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel master penjamin yang berisi penjamin pelayanan.\r\nYang berupa :\r\n- UMUM (Pasien UMUM / Bayar Duit Cash)\r\n- ASURANSI (Pasien spt Mandiri InHealth, ManuLife, dll)\r\n- BPJS (Pasti sudah tahu semua)';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_platform
DROP TABLE IF EXISTS `tbl_m_platform`;
CREATE TABLE IF NOT EXISTS `tbl_m_platform` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `kode` varchar(160) DEFAULT NULL,
  `akun` varchar(160) DEFAULT NULL,
  `platform` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `persen` decimal(10,1) DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `status_akt` enum('0','1','2') DEFAULT '0' COMMENT 'Cash\\r\\nAsuransi',
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=503 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_poli
DROP TABLE IF EXISTS `tbl_m_poli`;
CREATE TABLE IF NOT EXISTS `tbl_m_poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode` varchar(64) DEFAULT NULL,
  `lokasi` varchar(64) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `warna` varchar(64) DEFAULT NULL,
  `post_location` varchar(100) DEFAULT NULL,
  `tipe` enum('1','2') DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `status_online` enum('0','1') DEFAULT '0',
  `status_ant` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_poli_tipe
DROP TABLE IF EXISTS `tbl_m_poli_tipe`;
CREATE TABLE IF NOT EXISTS `tbl_m_poli_tipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk
DROP TABLE IF EXISTS `tbl_m_produk`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_satuan` int(11) DEFAULT 7,
  `id_kategori` int(11) DEFAULT 0,
  `id_kategori_lab` int(11) DEFAULT 0,
  `id_kategori_gol` int(11) DEFAULT 0,
  `id_lokasi` int(11) DEFAULT 0,
  `id_merk` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_user_arsip` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_simpan_arsip` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(65) DEFAULT NULL,
  `barcode` varchar(65) DEFAULT NULL,
  `produk` varchar(160) DEFAULT NULL,
  `produk_alias` text DEFAULT NULL,
  `produk_kand` text DEFAULT NULL,
  `produk_kand2` text DEFAULT NULL,
  `jml` float DEFAULT NULL,
  `jml_display` float DEFAULT 0,
  `jml_limit` float DEFAULT 0,
  `harga_beli` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `harga_beli_ppn` decimal(10,2) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `harga_jual_het` int(11) DEFAULT NULL,
  `harga_hasil` decimal(10,2) DEFAULT NULL,
  `harga_grosir` decimal(10,2) DEFAULT NULL,
  `remun_tipe` enum('0','1','2') DEFAULT '0',
  `remun_perc` decimal(10,2) DEFAULT 0.00,
  `remun_nom` decimal(10,2) DEFAULT 0.00,
  `apres_tipe` enum('0','1','2') DEFAULT '0',
  `apres_perc` decimal(10,2) DEFAULT 0.00,
  `apres_nom` decimal(10,2) unsigned DEFAULT 0.00,
  `status_promo` enum('0','1') DEFAULT '0',
  `status_subt` enum('0','1') DEFAULT '0',
  `status_lab` enum('0','1') DEFAULT '0',
  `status_brg_dep` enum('0','1') DEFAULT '0',
  `status_stok` enum('0','1') DEFAULT '0',
  `status_racikan` enum('0','1') DEFAULT '0',
  `status_etiket` enum('0','1','2') DEFAULT '0' COMMENT '0=netral;\r\n1=etiket putih;\r\n2=etiket biru;',
  `status_hps` enum('0','1') DEFAULT '0',
  `sl` enum('0','1','2') DEFAULT '0',
  `sp` enum('0','1') DEFAULT '0',
  `so` enum('0','1') DEFAULT '0',
  `status` int(11) DEFAULT NULL COMMENT '2=tindakan\r\n3=lab\r\n4=obat\r\n5=radiologi\r\n6=racikan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3765 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_deposit
DROP TABLE IF EXISTS `tbl_m_produk_deposit`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `debet` decimal(10,2) NOT NULL,
  `kredit` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_deposit_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_deposit_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_harga
DROP TABLE IF EXISTS `tbl_m_produk_harga`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_harga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` date NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `harga` decimal(32,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_harga_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_harga_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_hist
DROP TABLE IF EXISTS `tbl_m_produk_hist`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT 0,
  `id_gudang` int(11) DEFAULT 1,
  `id_user` int(11) DEFAULT 0,
  `id_pelanggan` int(11) DEFAULT 0,
  `id_supplier` int(11) DEFAULT 0,
  `id_penjualan` int(11) DEFAULT 0,
  `id_pembelian` int(11) DEFAULT 0,
  `id_pembelian_det` int(11) DEFAULT 0,
  `id_so` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_ed` date DEFAULT '0000-00-00',
  `no_nota` varchar(100) DEFAULT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `kode_batch` varchar(100) DEFAULT NULL,
  `produk` varchar(100) DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `nominal` decimal(10,2) DEFAULT 0.00,
  `jml` int(11) DEFAULT 0,
  `jml_satuan` int(11) DEFAULT 1,
  `satuan` varchar(50) DEFAULT NULL,
  `status` enum('1','2','3','4','5','6','7','8') DEFAULT NULL COMMENT '1 = Stok Masuk Pembelian\\r\\n2 = Stok Masuk\\r\\n3 = Stok Masuk Retur Jual\\r\\n4 = Stok Keluar Penjualan\\r\\n5 = Stok Keluar Retur Beli\\r\\n6 = SO\\r\\n7 = Stok Keluar\\r\\n8 = Mutasi Antar Gd',
  `sp` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=704273 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_hist_harga
DROP TABLE IF EXISTS `tbl_m_produk_hist_harga`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_hist_harga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_harga` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_pembelian` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `nom_awal` decimal(10,2) DEFAULT NULL,
  `nom_akhir` decimal(10,2) DEFAULT NULL,
  `status` enum('1','2') DEFAULT NULL COMMENT '1 = Harga Beli\r\n2 = Harga Jual',
  PRIMARY KEY (`id`),
  KEY `id_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_hist_harga_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_nominal
DROP TABLE IF EXISTS `tbl_m_produk_nominal`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_nominal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `nominal` decimal(10,0) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_nominal_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_nominal_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Nominal Deposit';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_promo
DROP TABLE IF EXISTS `tbl_m_produk_promo`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL DEFAULT 0,
  `id_promo` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `disk1` decimal(10,2) NOT NULL,
  `disk2` decimal(10,2) NOT NULL,
  `disk3` decimal(10,2) NOT NULL,
  `keterangan` mediumtext NOT NULL,
  `tipe` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_promo_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_promo_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_ref
DROP TABLE IF EXISTS `tbl_m_produk_ref`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT 0,
  `id_produk_item` int(11) DEFAULT 0,
  `id_satuan` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `item` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT 0.00,
  `jml` decimal(10,2) DEFAULT 0.00,
  `jml_satuan` int(11) DEFAULT 0,
  `satuan` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_lab_tbl_m_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=1145 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_ref_input
DROP TABLE IF EXISTS `tbl_m_produk_ref_input`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_ref_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(160) DEFAULT NULL,
  `item_value` text DEFAULT NULL,
  `item_value_l1` text DEFAULT NULL,
  `item_value_l2` text DEFAULT NULL,
  `item_value_p1` text DEFAULT NULL,
  `item_value_p2` text DEFAULT NULL,
  `item_satuan` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK__tbl_m_produk` (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_saldo
DROP TABLE IF EXISTS `tbl_m_produk_saldo`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_saldo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `jml` int(11) NOT NULL,
  `jml_satuan` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_saldo_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_saldo_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_satuan
DROP TABLE IF EXISTS `tbl_m_produk_satuan`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `satuan` varchar(160) DEFAULT NULL,
  `jml` int(11) DEFAULT 0,
  `harga` decimal(10,2) DEFAULT 0.00,
  `diskon` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_satuan_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_satuan_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2604 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_produk_stok
DROP TABLE IF EXISTS `tbl_m_produk_stok`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `id_gudang` int(11) DEFAULT 1,
  `id_user` int(11) DEFAULT 1,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `jml` float DEFAULT 0,
  `jml_satuan` float DEFAULT 1,
  `satuan` varchar(160) DEFAULT NULL,
  `satuanKecil` varchar(160) DEFAULT 'PCS',
  `status` enum('0','1','2') DEFAULT '0',
  `so` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_stok_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_stok_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2480 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_promo
DROP TABLE IF EXISTS `tbl_m_promo`;
CREATE TABLE IF NOT EXISTS `tbl_m_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime NOT NULL,
  `promo` varchar(160) NOT NULL,
  `keterangan` text NOT NULL,
  `nominal` decimal(10,4) NOT NULL,
  `disk1` decimal(10,4) NOT NULL,
  `disk2` decimal(10,4) NOT NULL,
  `disk3` decimal(10,4) NOT NULL,
  `tipe` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_sales
DROP TABLE IF EXISTS `tbl_m_sales`;
CREATE TABLE IF NOT EXISTS `tbl_m_sales` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_app` int(4) NOT NULL DEFAULT 0,
  `id_user` int(4) NOT NULL DEFAULT 0,
  `id_user_group` int(4) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kategori` varchar(10) DEFAULT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `disk1` decimal(11,2) DEFAULT NULL,
  `disk2` decimal(11,2) DEFAULT NULL,
  `disk3` decimal(11,2) DEFAULT NULL,
  `status` enum('0','1','2','3','4') DEFAULT NULL COMMENT '1=perawat\r\n2=dokter\r\n3=kasir\r\n4=lab',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_satuan
DROP TABLE IF EXISTS `tbl_m_satuan`;
CREATE TABLE IF NOT EXISTS `tbl_m_satuan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `satuanTerkecil` varchar(250) NOT NULL,
  `satuanBesar` varchar(250) DEFAULT NULL,
  `jml` int(11) NOT NULL,
  `status` enum('1','0') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_satuan_pakai
DROP TABLE IF EXISTS `tbl_m_satuan_pakai`;
CREATE TABLE IF NOT EXISTS `tbl_m_satuan_pakai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `satuan` varchar(250) NOT NULL,
  `status` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_m_supplier
DROP TABLE IF EXISTS `tbl_m_supplier`;
CREATE TABLE IF NOT EXISTS `tbl_m_supplier` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `npwp` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `kota` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `no_tlp` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `no_hp` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pendaftaran
DROP TABLE IF EXISTS `tbl_pendaftaran`;
CREATE TABLE IF NOT EXISTS `tbl_pendaftaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gelar` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_poli` int(11) DEFAULT 0,
  `id_platform` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_pekerjaan` int(11) DEFAULT 0,
  `id_ant` int(11) DEFAULT 0,
  `id_instansi` int(11) DEFAULT 0,
  `id_referall` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `no_urut` int(11) DEFAULT 0,
  `no_antrian` int(11) DEFAULT 0,
  `nik` varchar(160) DEFAULT NULL,
  `nama` varchar(160) DEFAULT NULL,
  `nama_pgl` varchar(160) DEFAULT NULL,
  `tmp_lahir` varchar(160) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jns_klm` enum('L','P') DEFAULT 'L',
  `kontak` varchar(50) DEFAULT NULL,
  `kontak_rmh` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `alamat_dom` text DEFAULT NULL,
  `instansi` varchar(160) DEFAULT NULL,
  `instansi_alamat` text DEFAULT NULL,
  `alergi` text DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `file_base64_id` longtext DEFAULT NULL,
  `tipe_bayar` int(11) DEFAULT 0 COMMENT '0 = tidak ada;\r\n1 = UMUM;\r\n2 = ASURANSI;\r\n3 = BPJS;',
  `tipe_rawat` int(11) DEFAULT 0,
  `tipe` int(11) DEFAULT 0,
  `status` enum('1','2') DEFAULT '1',
  `status_akt` enum('0','1','2') DEFAULT '1' COMMENT '0=pend\r\n1=konfirm\r\n2=selesai',
  `status_hdr` enum('0','1') DEFAULT '1',
  `status_gc` enum('0','1') DEFAULT '0',
  `status_dft` enum('0','1','2') DEFAULT '1',
  `status_hps` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pendaftaran_gc
DROP TABLE IF EXISTS `tbl_pendaftaran_gc`;
CREATE TABLE IF NOT EXISTS `tbl_pendaftaran_gc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pendaftaran` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `jns_klm` enum('L','P') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tmp_lahir` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `file_name` text DEFAULT NULL,
  `status_hub` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_pendaftaran_gc_tbl_pendaftaran` (`id_pendaftaran`),
  CONSTRAINT `FK_tbl_pendaftaran_gc_tbl_pendaftaran` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tbl_pendaftaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pengaturan_cabang
DROP TABLE IF EXISTS `tbl_pengaturan_cabang`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_cabang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `keterangan` varchar(256) DEFAULT NULL,
  `npwp` varchar(256) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(160) DEFAULT NULL,
  `no_tlp` varchar(160) DEFAULT NULL,
  `sn` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pengaturan_mail
DROP TABLE IF EXISTS `tbl_pengaturan_mail`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proto` enum('mail','sendmail','smtp') NOT NULL,
  `host` varchar(160) NOT NULL,
  `user` varchar(160) NOT NULL,
  `pass` varchar(160) NOT NULL,
  `port` int(11) NOT NULL,
  `timeout` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pengaturan_notif
DROP TABLE IF EXISTS `tbl_pengaturan_notif`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_notif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(160) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_pengaturan_profile
DROP TABLE IF EXISTS `tbl_pengaturan_profile`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengaturan` int(10) unsigned NOT NULL DEFAULT 0,
  `npwp` char(15) NOT NULL DEFAULT '',
  `nama` varchar(100) NOT NULL DEFAULT '',
  `alamat` varchar(100) NOT NULL DEFAULT '',
  `kota` varchar(50) NOT NULL DEFAULT '',
  `telpon` varchar(30) NOT NULL DEFAULT '',
  `fax` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `jenis_usaha` varchar(45) NOT NULL DEFAULT '',
  `klu` char(6) NOT NULL DEFAULT '',
  `pemilik` varchar(100) NOT NULL DEFAULT '',
  `npwp_pemilik` char(15) NOT NULL DEFAULT '',
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sdm_cuti
DROP TABLE IF EXISTS `tbl_sdm_cuti`;
CREATE TABLE IF NOT EXISTS `tbl_sdm_cuti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_manajemen` int(11) DEFAULT 0,
  `id_kategori` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `keterangan` text DEFAULT NULL COMMENT 'Alasan cuti karyawan',
  `no_surat` varchar(100) DEFAULT NULL,
  `ttd` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_type` varchar(25) DEFAULT NULL,
  `file_ext` varchar(10) DEFAULT NULL,
  `catatan` text DEFAULT NULL COMMENT 'Catatan dari manajemen HR',
  `status` enum('0','1','2') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan tabel pengajuan cuti karyawan';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sdm_surat_krj
DROP TABLE IF EXISTS `tbl_sdm_surat_krj`;
CREATE TABLE IF NOT EXISTS `tbl_sdm_surat_krj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_pimpinan` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `kode` varchar(50) DEFAULT NULL,
  `judul` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tipe` enum('0','1','2') DEFAULT '0',
  `status` enum('0','1') DEFAULT '0',
  `status_acc` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sdm_surat_tgs
DROP TABLE IF EXISTS `tbl_sdm_surat_tgs`;
CREATE TABLE IF NOT EXISTS `tbl_sdm_surat_tgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_karyawan` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_pimpinan` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `kode` varchar(50) DEFAULT NULL,
  `judul` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `tipe` enum('0','1','2') DEFAULT '0',
  `status` enum('0','1') DEFAULT '0',
  `status_acc` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sdm_surat_tgs_kary
DROP TABLE IF EXISTS `tbl_sdm_surat_tgs_kary`;
CREATE TABLE IF NOT EXISTS `tbl_sdm_surat_tgs_kary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_surat_tgs` int(11) DEFAULT 0,
  `id_karyawan` int(11) DEFAULT 0,
  `nik` varchar(25) DEFAULT NULL,
  `nama` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_sdm_surat_tgs_kary_tbl_sdm_surat_tgs` (`id_surat_tgs`),
  CONSTRAINT `FK_tbl_sdm_surat_tgs_kary_tbl_sdm_surat_tgs` FOREIGN KEY (`id_surat_tgs`) REFERENCES `tbl_sdm_surat_tgs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sessions
DROP TABLE IF EXISTS `tbl_sessions`;
CREATE TABLE IF NOT EXISTS `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sessions_back
DROP TABLE IF EXISTS `tbl_sessions_back`;
CREATE TABLE IF NOT EXISTS `tbl_sessions_back` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT 0,
  `user_data` longblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB AUTO_INCREMENT=176928 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_sessions_front
DROP TABLE IF EXISTS `tbl_sessions_front`;
CREATE TABLE IF NOT EXISTS `tbl_sessions_front` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT 0,
  `user_data` longblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB AUTO_INCREMENT=58786 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_beli
DROP TABLE IF EXISTS `tbl_trans_beli`;
CREATE TABLE IF NOT EXISTS `tbl_trans_beli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) DEFAULT 0,
  `id_penerima` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_bayar` date DEFAULT '0000-00-00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `id_supplier` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_po` int(11) DEFAULT NULL,
  `no_nota` varchar(160) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `no_po` varchar(160) DEFAULT NULL,
  `supplier` varchar(160) DEFAULT NULL,
  `jml_total` decimal(32,2) DEFAULT 0.00,
  `disk1` decimal(32,2) DEFAULT 0.00,
  `disk2` decimal(32,2) DEFAULT 0.00,
  `disk3` decimal(32,2) DEFAULT 0.00,
  `jml_potongan` decimal(32,2) DEFAULT 0.00,
  `jml_retur` decimal(32,2) DEFAULT 0.00,
  `jml_diskon` decimal(32,2) DEFAULT 0.00,
  `jml_biaya` decimal(32,2) DEFAULT 0.00,
  `jml_ongkir` decimal(32,2) DEFAULT 0.00,
  `jml_subtotal` decimal(32,2) DEFAULT 0.00,
  `jml_dpp` decimal(32,2) DEFAULT 0.00,
  `ppn` int(11) DEFAULT 0,
  `jml_ppn` decimal(32,2) DEFAULT 0.00,
  `jml_gtotal` decimal(32,2) DEFAULT 0.00,
  `jml_bayar` decimal(32,2) DEFAULT 0.00,
  `jml_kembali` decimal(32,2) DEFAULT 0.00,
  `jml_kurang` decimal(32,2) DEFAULT 0.00,
  `status_bayar` int(11) DEFAULT NULL,
  `status_nota` int(11) DEFAULT 0,
  `status_ppn` enum('0','1','2') DEFAULT NULL,
  `status_retur` enum('0','1') DEFAULT NULL,
  `status_penerimaan` enum('0','1','2','3') DEFAULT '0',
  `metode_bayar` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status_jurnal` enum('0','1') DEFAULT '0',
  `status_hps` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idSupplier` (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=3707 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_beli_det
DROP TABLE IF EXISTS `tbl_trans_beli_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_beli_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT 0,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_terima` date DEFAULT NULL,
  `tgl_ed` date DEFAULT '0000-00-00',
  `no_nota` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `kode_batch` varchar(50) DEFAULT NULL,
  `produk` varchar(160) DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT NULL,
  `jml_satuan` int(11) DEFAULT NULL,
  `jml_diterima` int(11) DEFAULT 0,
  `jml_retur` int(11) DEFAULT 0,
  `satuan` varchar(160) DEFAULT NULL,
  `satuan_retur` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `harga` decimal(32,2) DEFAULT NULL,
  `harga_het` decimal(32,2) DEFAULT NULL,
  `disk1` decimal(10,2) DEFAULT NULL,
  `disk2` decimal(10,2) DEFAULT NULL,
  `disk3` decimal(10,2) DEFAULT NULL,
  `diskon` decimal(32,2) DEFAULT NULL,
  `potongan` decimal(32,2) DEFAULT NULL,
  `subtotal` decimal(32,2) DEFAULT NULL,
  `status_brg` int(11) DEFAULT NULL,
  `sp` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idBarang` (`id_produk`),
  KEY `FK_tbl_trans_beli_det_tbl_trans_beli` (`id_pembelian`),
  CONSTRAINT `FK_tbl_trans_beli_det_tbl_trans_beli` FOREIGN KEY (`id_pembelian`) REFERENCES `tbl_trans_beli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13586 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_beli_plat
DROP TABLE IF EXISTS `tbl_trans_beli_plat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_beli_plat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_platform` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `platform` varchar(160) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `nominal` decimal(32,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `no_nota` (`id_pembelian`),
  CONSTRAINT `FK_tbl_trans_beli_plat_tbl_trans_beli` FOREIGN KEY (`id_pembelian`) REFERENCES `tbl_trans_beli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_beli_po
DROP TABLE IF EXISTS `tbl_trans_beli_po`;
CREATE TABLE IF NOT EXISTS `tbl_trans_beli_po` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) DEFAULT 0,
  `id_penerima` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `no_nota` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `supplier` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `pengiriman` text DEFAULT NULL,
  `status_nota` int(11) DEFAULT 0,
  `status_retur` enum('0','1') DEFAULT NULL,
  `status_penerimaan` enum('0','1','2','3') DEFAULT NULL,
  `metode_bayar` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status_jurnal` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idSupplier` (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=3845 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_beli_po_det
DROP TABLE IF EXISTS `tbl_trans_beli_po_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_beli_po_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `produk` varchar(160) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `jml_satuan` int(11) DEFAULT NULL,
  `satuan` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `keterangan_itm` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idBarang` (`id_produk`),
  KEY `FK_tbl_trans_beli_po_det_tbl_trans_beli_po` (`id_pembelian`),
  CONSTRAINT `FK_tbl_trans_beli_po_det_tbl_trans_beli_po` FOREIGN KEY (`id_pembelian`) REFERENCES `tbl_trans_beli_po` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13837 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual
DROP TABLE IF EXISTS `tbl_trans_jual`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_sales` int(11) NOT NULL,
  `id_app` int(11) NOT NULL,
  `id_promo` int(11) DEFAULT NULL,
  `id_lokasi` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_gudang` int(11) DEFAULT NULL,
  `no_nota` varchar(50) NOT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode_nota_dpn` varchar(50) DEFAULT NULL,
  `kode_nota_blk` varchar(50) DEFAULT NULL,
  `kode_fp` varchar(50) DEFAULT NULL,
  `tgl_bayar` date DEFAULT '0000-00-00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `platform` varchar(160) DEFAULT NULL,
  `jml_total` decimal(32,2) DEFAULT 0.00,
  `jml_biaya` decimal(32,2) DEFAULT 0.00,
  `jml_ongkir` decimal(32,2) DEFAULT 0.00,
  `jml_retur` decimal(32,2) DEFAULT 0.00,
  `diskon` decimal(32,2) DEFAULT 0.00,
  `jml_diskon` decimal(32,2) DEFAULT 0.00,
  `jml_subtotal` decimal(32,2) DEFAULT 0.00,
  `ppn` int(11) DEFAULT 0,
  `jml_ppn` decimal(32,2) DEFAULT 0.00,
  `jml_gtotal` decimal(32,2) DEFAULT 0.00,
  `jml_bayar` decimal(32,2) DEFAULT 0.00,
  `jml_kembali` decimal(32,2) DEFAULT 0.00,
  `jml_kurang` decimal(32,2) DEFAULT 0.00,
  `disk1` decimal(32,2) DEFAULT 0.00,
  `jml_disk1` decimal(32,2) DEFAULT 0.00,
  `disk2` decimal(32,2) DEFAULT 0.00,
  `jml_disk2` decimal(32,2) DEFAULT 0.00,
  `disk3` decimal(32,2) DEFAULT 0.00,
  `jml_disk3` decimal(32,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `breadcrump` text DEFAULT NULL,
  `anamnesa` text DEFAULT NULL,
  `metode_bayar` int(11) DEFAULT NULL,
  `status` enum('0','1','2','3','4') DEFAULT '0' COMMENT '\r\n1=pos\r\n2=rajal\r\n3=ranap',
  `status_nota` int(11) DEFAULT NULL COMMENT '1=anamnesa\r\n2=pemeriksaan\r\n3=tindakan\r\n4=obat\r\n5=dokter\r\n6=pembayaran\r\n7=finish',
  `status_ppn` enum('0','1') DEFAULT '0',
  `status_bayar` enum('0','1','2') DEFAULT '0',
  `status_retur` enum('0','1','2') DEFAULT '0',
  `status_jurnal` enum('0','1') DEFAULT '0',
  `status_grosir` enum('0','1') DEFAULT '0',
  `status_lap` enum('0','1') DEFAULT '1',
  `status_pjk` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `no_nota` (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_det
DROP TABLE IF EXISTS `tbl_trans_jual_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `produk` varchar(256) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` decimal(32,2) DEFAULT NULL,
  `harga_pokok` decimal(32,2) DEFAULT NULL,
  `disk1` decimal(32,2) DEFAULT NULL,
  `disk2` decimal(32,2) DEFAULT NULL,
  `disk3` decimal(32,2) DEFAULT NULL,
  `jml` int(6) DEFAULT NULL,
  `jml_satuan` int(6) DEFAULT NULL,
  `diskon` decimal(32,2) DEFAULT NULL,
  `potongan` decimal(32,2) DEFAULT NULL,
  `subtotal` decimal(32,2) DEFAULT NULL,
  `status_app` enum('0','1') DEFAULT NULL,
  `status_hrg` int(11) DEFAULT NULL,
  `status_brg` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_det_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_diskon
DROP TABLE IF EXISTS `tbl_trans_jual_diskon`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_diskon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL DEFAULT 0,
  `id_pelanggan` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `disk1` decimal(10,2) NOT NULL,
  `disk2` decimal(10,2) NOT NULL,
  `disk3` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_diskon_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_hist
DROP TABLE IF EXISTS `tbl_trans_jual_hist`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_hist_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_pen
DROP TABLE IF EXISTS `tbl_trans_jual_pen`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_pen` (
  `no_nota` varchar(50) NOT NULL,
  `id_app` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kode_nota_dpn` varchar(50) DEFAULT NULL,
  `kode_nota_blk` varchar(50) DEFAULT NULL,
  `kode_fp` varchar(50) NOT NULL,
  `id_promo` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date NOT NULL,
  `platform` varchar(160) NOT NULL,
  `jml_total` decimal(32,2) NOT NULL,
  `jml_diskon` decimal(32,2) NOT NULL,
  `jml_biaya` decimal(32,2) NOT NULL,
  `jml_subtotal` decimal(32,2) NOT NULL,
  `ppn` int(11) NOT NULL,
  `jml_ppn` decimal(32,2) NOT NULL,
  `jml_gtotal` decimal(32,2) NOT NULL,
  `jml_retur` decimal(32,2) NOT NULL,
  `jml_bayar` decimal(32,2) NOT NULL,
  `jml_kembali` decimal(32,2) NOT NULL,
  `jml_kurang` decimal(32,2) NOT NULL,
  `jml_ongkir` decimal(32,2) NOT NULL,
  `disk1` decimal(32,2) NOT NULL,
  `jml_disk1` decimal(32,2) NOT NULL,
  `disk2` decimal(32,2) NOT NULL,
  `jml_disk2` decimal(32,2) NOT NULL,
  `disk3` decimal(32,2) NOT NULL,
  `jml_disk3` decimal(32,2) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_sales` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `metode_bayar` enum('0','1','2') NOT NULL,
  `status_nota` enum('0','1','2','3') NOT NULL,
  `status_ppn` enum('0','1') NOT NULL,
  `status_bayar` enum('0','1','2') NOT NULL,
  `status_retur` enum('0','1','2') NOT NULL,
  PRIMARY KEY (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_pen_det
DROP TABLE IF EXISTS `tbl_trans_jual_pen_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_pen_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_satuan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `produk` varchar(256) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `keterangan` text NOT NULL,
  `harga` decimal(32,2) NOT NULL,
  `disk1` decimal(32,2) NOT NULL,
  `disk2` decimal(32,2) NOT NULL,
  `disk3` decimal(32,2) NOT NULL,
  `jml` int(6) NOT NULL,
  `jml_satuan` int(6) NOT NULL,
  `diskon` decimal(32,2) NOT NULL,
  `potongan` decimal(32,2) NOT NULL,
  `subtotal` decimal(32,2) NOT NULL,
  `status_app` enum('0','1') NOT NULL,
  `status_hrg` int(11) NOT NULL,
  `status_brg` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_jual_pen_det_tbl_trans_jual_pen` (`no_nota`),
  CONSTRAINT `FK_tbl_trans_jual_pen_det_tbl_trans_jual_pen` FOREIGN KEY (`no_nota`) REFERENCES `tbl_trans_jual_pen` (`no_nota`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_jual_plat
DROP TABLE IF EXISTS `tbl_trans_jual_plat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_plat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL DEFAULT 0,
  `id_platform` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `platform` varchar(160) NOT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `nominal` decimal(32,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_penjualan` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_plat_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_konsul
DROP TABLE IF EXISTS `tbl_trans_konsul`;
CREATE TABLE IF NOT EXISTS `tbl_trans_konsul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_medcheck` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `judul` varchar(60) DEFAULT NULL,
  `posting` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_konsul_dokter
DROP TABLE IF EXISTS `tbl_trans_konsul_dokter`;
CREATE TABLE IF NOT EXISTS `tbl_trans_konsul_dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_konsul` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_konsul_dokter_tbl_trans_konsul` (`id_konsul`),
  CONSTRAINT `FK_tbl_trans_konsul_dokter_tbl_trans_konsul` FOREIGN KEY (`id_konsul`) REFERENCES `tbl_trans_konsul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck
DROP TABLE IF EXISTS `tbl_trans_medcheck`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) DEFAULT 1,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_nurse` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_farmasi` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_instansi` int(11) DEFAULT 0,
  `id_poli` int(11) DEFAULT 0,
  `id_dft` int(11) DEFAULT 0 COMMENT 'ID yang diambil dari tbl_pendaftaran kolom id',
  `id_ant` int(11) DEFAULT 0,
  `id_kasir` int(11) DEFAULT 0,
  `id_icd` int(11) DEFAULT 0,
  `id_icd10` int(11) DEFAULT 0,
  `id_referall` int(11) DEFAULT 0,
  `id_encounter` text DEFAULT NULL,
  `id_condition` text DEFAULT NULL,
  `id_post_location` text DEFAULT NULL,
  `uuid` text DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_periksa` datetime DEFAULT NULL,
  `tgl_periksa_lab` datetime DEFAULT NULL,
  `tgl_periksa_lab_keluar` datetime DEFAULT NULL,
  `tgl_periksa_rad` datetime DEFAULT NULL,
  `tgl_periksa_rad_kirim` datetime DEFAULT NULL,
  `tgl_periksa_rad_baca` datetime DEFAULT NULL,
  `tgl_periksa_rad_keluar` datetime DEFAULT NULL,
  `tgl_periksa_pen` datetime DEFAULT NULL,
  `tgl_resep_msk` datetime DEFAULT NULL,
  `tgl_resep_klr` datetime DEFAULT NULL,
  `tgl_resep_byr` datetime DEFAULT NULL,
  `tgl_resep_trm` datetime DEFAULT NULL,
  `tgl_ranap` datetime DEFAULT NULL,
  `tgl_ranap_keluar` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `tgl_ttd` datetime DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `no_rm` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `no_akun` varchar(50) DEFAULT NULL,
  `no_nota` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dokter` varchar(160) DEFAULT NULL,
  `dokter_nik` varchar(160) DEFAULT NULL,
  `poli` varchar(160) DEFAULT NULL,
  `pasien` varchar(160) DEFAULT NULL,
  `pasien_alamat` varchar(160) DEFAULT NULL,
  `pasien_nik` varchar(160) DEFAULT NULL,
  `keluhan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ttv` text DEFAULT NULL,
  `ttv_st` varchar(50) DEFAULT NULL,
  `ttv_bb` varchar(50) DEFAULT NULL,
  `ttv_tb` varchar(50) DEFAULT NULL,
  `ttv_td` varchar(50) DEFAULT NULL,
  `ttv_sistole` varchar(50) DEFAULT NULL,
  `ttv_diastole` varchar(50) DEFAULT NULL,
  `ttv_nadi` varchar(50) DEFAULT NULL,
  `ttv_laju` varchar(50) DEFAULT NULL,
  `ttv_saturasi` varchar(50) DEFAULT NULL,
  `ttv_skala` varchar(50) DEFAULT NULL,
  `ttd_obat` text DEFAULT NULL,
  `diagnosa` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `anamnesa` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pemeriksaan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `program` text DEFAULT NULL,
  `alergi` text DEFAULT NULL,
  `metode` int(11) DEFAULT 0,
  `platform` int(11) DEFAULT 0,
  `jml_total` decimal(10,2) DEFAULT 0.00,
  `jml_ongkir` decimal(10,2) DEFAULT 0.00,
  `jml_dp` decimal(10,2) DEFAULT 0.00,
  `jml_diskon` decimal(10,2) DEFAULT 0.00,
  `diskon` decimal(10,2) DEFAULT 0.00,
  `jml_potongan` decimal(10,2) DEFAULT 0.00,
  `jml_potongan_poin` decimal(10,2) DEFAULT 0.00,
  `jml_subtotal` decimal(10,2) DEFAULT 0.00,
  `jml_ppn` decimal(10,2) DEFAULT 0.00,
  `ppn` decimal(10,2) DEFAULT 0.00,
  `jml_gtotal` decimal(10,2) DEFAULT 0.00,
  `jml_bayar` decimal(10,2) DEFAULT 0.00,
  `jml_kembali` decimal(10,2) DEFAULT 0.00,
  `jml_kurang` decimal(10,2) DEFAULT 0.00,
  `jml_poin` decimal(10,2) DEFAULT 0.00,
  `jml_poin_nom` decimal(10,2) DEFAULT 0.00,
  `tipe` int(11) DEFAULT 0 COMMENT '2=rajal;3=ranap;',
  `tipe_bayar` int(11) DEFAULT 0 COMMENT '0 = tidak ada;\r\n1 = UMUM;\r\n2 = ASURANSI;\r\n3 = BPJS;',
  `status` int(11) DEFAULT 0 COMMENT '1=anamnesa;\r\n2=tindakan;\r\n3=obat;\r\n4=laborat;\r\n5=dokter;\r\n6=pembayaran;\r\n7=finish',
  `status_bayar` int(11) DEFAULT 0 COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;',
  `status_nota` int(11) DEFAULT 0 COMMENT '0=pend;\r\n1=proses;\r\n2=finish;\r\n3=batal',
  `status_hps` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status_pos` enum('0','1','2') DEFAULT '0',
  `status_periksa` enum('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status_resep` enum('0','1','2') DEFAULT '0' COMMENT '1=Non-racikan\r\n2=Racikan',
  `sp` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=99272 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_apres
DROP TABLE IF EXISTS `tbl_trans_medcheck_apres`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_apres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `tgl_simpan` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `item` varchar(168) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT NULL,
  `apres_perc` decimal(10,2) DEFAULT NULL,
  `apres_nom` decimal(10,2) DEFAULT NULL,
  `apres_subtotal` decimal(10,2) DEFAULT NULL,
  `apres_tipe` int(11) DEFAULT 0 COMMENT '1=persen\r\n2=nominal',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_apres_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_apres_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_ass_fisik
DROP TABLE IF EXISTS `tbl_trans_medcheck_ass_fisik`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_ass_fisik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\\\\\\\\r\\\\\\\\n1=proses\\\\\\\\r\\\\\\\\n2=diterima\\\\\\\\r\\\\\\\\n3=ditolak\\\\\\\\r\\\\\\\\n4=farmasi\\\\\\\\r\\\\\\\\n5=farmasi_proses',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_ass_fisik_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_ass_fisik_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2609 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan data form fisik';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_ass_fisik_hsl
DROP TABLE IF EXISTS `tbl_trans_medcheck_ass_fisik_hsl`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_ass_fisik_hsl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(10) DEFAULT 0,
  `id_medcheck_ass` int(10) DEFAULT 0,
  `id_item` int(10) DEFAULT 0,
  `id_user` int(10) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(100) DEFAULT NULL,
  `item_value` int(10) DEFAULT 0,
  `item_value2` varchar(160) DEFAULT NULL,
  `item_value3` varchar(50) DEFAULT NULL,
  `tipe` int(10) DEFAULT 0,
  `status_posisi` enum('N','L','R') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_ass_fisik_hsl_tbl_trans_medcheck_ass_fisik` (`id_medcheck_ass`),
  CONSTRAINT `FK_tbl_trans_medcheck_ass_fisik_hsl_tbl_trans_medcheck_ass_fisik` FOREIGN KEY (`id_medcheck_ass`) REFERENCES `tbl_trans_medcheck_ass_fisik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=331879 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan hasil pemeriksaan assesment';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_ass_ranap
DROP TABLE IF EXISTS `tbl_trans_medcheck_ass_ranap`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_ass_ranap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_surat` varchar(50) DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `riwayat_skg` text DEFAULT NULL,
  `riwayat_klg` text DEFAULT NULL,
  `penyakit` text DEFAULT NULL,
  `ket_ranap` text DEFAULT NULL,
  `pemeriksaan` text DEFAULT NULL,
  `askep_masalah` text DEFAULT NULL,
  `askep_tujuan` text DEFAULT NULL,
  `skala_nyeri` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n1=proses\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n2=diterima\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n3=ditolak\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n4=farmasi\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n5=farmasi_proses',
  `status_rnp` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_ass_ranap_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_ass_ranap_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan data form fisik';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_ass_ranap_obat
DROP TABLE IF EXISTS `tbl_trans_medcheck_ass_ranap_obat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_ass_ranap_obat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ass_ranap` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `param` varchar(50) DEFAULT NULL,
  `param_nilai` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_Ass_ranap` (`id_ass_ranap`),
  CONSTRAINT `FK_Ass_ranap` FOREIGN KEY (`id_ass_ranap`) REFERENCES `tbl_trans_medcheck_ass_ranap` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan riwayat minum obat pada assesment rawat inap';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_ass_rnp
DROP TABLE IF EXISTS `tbl_trans_medcheck_ass_rnp`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_ass_rnp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n1=proses\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n2=diterima\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n3=ditolak\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n4=farmasi\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n5=farmasi_proses',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan data form fisik';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_det
DROP TABLE IF EXISTS `tbl_trans_medcheck_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_resep` int(11) NOT NULL DEFAULT 0,
  `id_resep_det` int(11) NOT NULL DEFAULT 0,
  `id_resep_det_rc` int(11) DEFAULT 0,
  `id_lab` int(11) NOT NULL DEFAULT 0,
  `id_lab_kat` int(11) NOT NULL DEFAULT 0,
  `id_rad` int(11) NOT NULL DEFAULT 0,
  `id_mcu` int(11) NOT NULL DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_item_kat` int(11) DEFAULT 0,
  `id_item_sat` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_perawat` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_radiografer` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_baca` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `item` varchar(160) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT 0.00,
  `jml_resep` decimal(10,2) DEFAULT 0.00,
  `jml_satuan` decimal(10,2) DEFAULT 0.00,
  `satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `file_rad` longtext DEFAULT NULL,
  `resep` longtext DEFAULT NULL,
  `kesan_rad` longtext DEFAULT NULL,
  `hasil_rad` longtext DEFAULT NULL,
  `hasil_lab` text DEFAULT NULL,
  `dosis` text DEFAULT NULL,
  `dosis_ket` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT 0.00,
  `disk1` decimal(10,2) DEFAULT 0.00,
  `disk2` decimal(10,2) DEFAULT 0.00,
  `disk3` decimal(10,2) DEFAULT 0.00,
  `diskon` decimal(10,2) DEFAULT 0.00,
  `potongan` decimal(10,2) DEFAULT 0.00,
  `potongan_poin` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `status` int(11) DEFAULT 0 COMMENT '0=null\r\n1=obat\r\n2=lab\r\n3=tindakan\r\n4=radiologi',
  `status_ctk` enum('0','1') DEFAULT '0',
  `status_hsl` enum('0','1') DEFAULT '0',
  `status_hsl_lab` enum('0','1') DEFAULT '0',
  `status_hsl_rad` enum('0','1') DEFAULT '0',
  `status_baca` enum('0','1','2') DEFAULT '0' COMMENT '0=belum;\\r\\n1=sudah;',
  `status_post` enum('0','1','2') DEFAULT '0' COMMENT '0=pend\r\n1=posted\r\n2=canceled',
  `status_remun` enum('0','1','2') DEFAULT '0',
  `status_pj` enum('0','1','2') DEFAULT '0' COMMENT 'Status Penjamin (UMUM, BPJS, dll)\r\n0=tidak\r\n1=ya',
  `status_rc` enum('0','1','2') DEFAULT '0',
  `status_rf` enum('0','1') DEFAULT '0',
  `status_pkt` enum('0','1') DEFAULT '0',
  `sp` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_det_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_det_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=969489 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_dokter
DROP TABLE IF EXISTS `tbl_trans_medcheck_dokter`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_dokter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0' COMMENT 'Menyimpan status dokter utama, jika 1 maka menandakan dokter utama, jika 0 merupakan raber',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_dokter_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_dokter_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94731 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk mengakomodasi fitur rawat bersama.\r\nTabel ini akan menyimpan id_dokter, id_medcheck.';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_file
DROP TABLE IF EXISTS `tbl_trans_medcheck_file`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_medcheck_det` int(11) NOT NULL DEFAULT 0,
  `id_berkas` int(11) NOT NULL DEFAULT 0,
  `id_medcheck_rsm` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_rad` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `judul` varchar(160) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `file_name_ori` varchar(160) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `file_ext` varchar(160) DEFAULT NULL,
  `file_type` varchar(160) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `file_base64_foto` longtext DEFAULT NULL,
  `status` enum('0','1','2','3') DEFAULT '0' COMMENT '0=none;\\r\\n1=berkas unggah;\\r\\n2=resume;\\r\\n3=Bukti Bayar',
  `sp` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_file_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27555 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_hist
DROP TABLE IF EXISTS `tbl_trans_medcheck_hist`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_item` int(11) NOT NULL DEFAULT 0,
  `id_item_kat` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_hist_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_hist_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_icd
DROP TABLE IF EXISTS `tbl_trans_medcheck_icd`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_icd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_rm` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_icd` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `icd` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `diagnosa_en` text DEFAULT NULL,
  `status_icd` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK__tbl_trans_medcheck` (`id_medcheck`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27880 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan multiple ICD';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_kamar
DROP TABLE IF EXISTS `tbl_trans_medcheck_kamar`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_kamar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_inform` int(11) DEFAULT 0,
  `id_kamar` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kamar` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_kamar_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_kamar_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1675 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk Menyimpan Kamar perawatan per transaksi';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_konsul
DROP TABLE IF EXISTS `tbl_trans_medcheck_konsul`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_konsul` (
  `id` int(11) NOT NULL,
  `id_medcheck` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_konsul` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `judul` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_kwi
DROP TABLE IF EXISTS `tbl_trans_medcheck_kwi`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_kwi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `dari` varchar(160) DEFAULT NULL,
  `nominal` decimal(10,2) DEFAULT 0.00,
  `ket` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `status_kwi` enum('1','2','3') DEFAULT '1' COMMENT '1=Kwitansi;\r\n2=DP\r\n3=TPP (Tarif Permintaan Pasien)',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_kwi_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_kwi_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6716 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan kwitansi';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_dokter_kirim` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `item` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\\r\\n1=proses\\r\\n2=diterima\\r\\n3=ditolak\\r\\n4=farmasi\\r\\n5=farmasi_proses',
  `status_cvd` enum('0','1','2') DEFAULT '0' COMMENT '0=tidak\r\n1=rapid\r\n2=pcr',
  `status_lis` enum('0','1') DEFAULT '0' COMMENT 'Update status dari Mesin LIS',
  `status_normal` enum('0','1','2') DEFAULT '0',
  `status_duplo` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_lab_tbl_trans_medcheck` (`id_medcheck`) USING BTREE,
  CONSTRAINT `FK_tbl_trans_medcheck_lab_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29707 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_audiometri
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_audiometri`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_audiometri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `id_dokter_kirim` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `no_sample` varchar(255) DEFAULT NULL,
  `hasil` text DEFAULT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_medcheck` (`id_medcheck`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_ekg
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_ekg`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_ekg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(160) DEFAULT NULL,
  `hsl_irama` varchar(160) DEFAULT NULL COMMENT 'Irama',
  `hsl_frek` varchar(160) DEFAULT NULL COMMENT 'Frekuensi',
  `hsl_axis` varchar(160) DEFAULT NULL COMMENT 'Axis',
  `hsl_pos` varchar(160) DEFAULT NULL COMMENT 'Posisi',
  `hsl_zona` varchar(160) DEFAULT NULL COMMENT 'Zona Transisi',
  `hsl_gelp` varchar(160) DEFAULT NULL COMMENT 'Gelombang P',
  `hsl_int` varchar(160) DEFAULT NULL COMMENT 'Interval P - R',
  `hsl_qrs` varchar(160) DEFAULT NULL COMMENT 'Kompleks QRS',
  `hsl_st` varchar(160) DEFAULT NULL COMMENT 'Segment ST',
  `hsl_gelt` varchar(160) DEFAULT NULL COMMENT 'Gelombang T',
  `hsl_gelu` varchar(160) DEFAULT NULL COMMENT 'Gelombang U',
  `hsl_lain` varchar(160) DEFAULT NULL COMMENT 'Lain-lain',
  `kesimpulan` mediumtext DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_lab_ekg_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_ekg_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1442 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Untuk menyimpan data ekg';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_ekg_file
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_ekg_file`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_ekg_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_lab_ekg` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `judul` varchar(160) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `file_name_orig` varchar(160) DEFAULT NULL,
  `file_ext` varchar(50) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `sp` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_lab_ekg_file_tbl_trans_medcheck_lab_ekg` (`id_lab_ekg`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_ekg_file_tbl_trans_medcheck_lab_ekg` FOREIGN KEY (`id_lab_ekg`) REFERENCES `tbl_trans_medcheck_lab_ekg` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=685 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_hsl
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_hsl`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_hsl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_lab` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_item_ref` int(11) DEFAULT 0,
  `id_item_ref_ip` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(160) DEFAULT NULL,
  `item_satuan` varchar(100) DEFAULT NULL,
  `item_value` text DEFAULT NULL,
  `item_hasil` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `status_hsl_lab` enum('0','1') DEFAULT '0',
  `status_hsl_wrn` enum('0','1') DEFAULT '0',
  `sp` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_lab_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_hsl_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=332229 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan nilai normal lab';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_spiro
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_spiro`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_spiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `keluhan` varchar(160) DEFAULT NULL,
  `riwayat` varchar(160) DEFAULT NULL,
  `ref` varchar(160) DEFAULT NULL,
  `tb` int(11) DEFAULT NULL,
  `bb` int(11) DEFAULT NULL,
  `imt` int(11) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `anjuran` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\\\\r\\\\n1=proses\\\\r\\\\n2=diterima\\\\r\\\\n3=ditolak\\\\r\\\\n4=farmasi\\\\r\\\\n5=farmasi_proses',
  `status_rokok` enum('0','1','2') DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_lab_spiro_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_spiro_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=631 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan data spirometri';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_lab_spiro_hsl
DROP TABLE IF EXISTS `tbl_trans_medcheck_lab_spiro_hsl`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_lab_spiro_hsl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(10) DEFAULT 0,
  `id_lab_spiro` int(10) DEFAULT 0,
  `id_lab_spiro_kat` int(10) DEFAULT 0,
  `id_user` int(10) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(100) DEFAULT NULL,
  `item_value` decimal(10,2) DEFAULT 0.00,
  `item_value2` decimal(10,2) DEFAULT 0.00,
  `item_value3` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_lab_spiro_hsl_tbl_trans_medcheck` (`id_medcheck`),
  KEY `FK_tbl_trans_medcheck_lab_spiro_hsl_tbl_trans_medcheck_lab_spiro` (`id_lab_spiro`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_spiro_hsl_tbl_trans_medcheck_lab_spiro` FOREIGN KEY (`id_lab_spiro`) REFERENCES `tbl_trans_medcheck_lab_spiro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Untuk menyimpan hasil pemeriksaan spirometri';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_mcu
DROP TABLE IF EXISTS `tbl_trans_medcheck_mcu`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_mcu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_mcu` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `item` longtext DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=pend\\\\r\\\\n1=proses\\\\r\\\\n2=diterima\\\\r\\\\n3=ditolak\\\\r\\\\n4=farmasi\\\\r\\\\n5=farmasi_proses',
  `status_mcu` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_mcu_tbl_trans_medcheck` (`id_medcheck`) USING BTREE,
  CONSTRAINT `FK_tbl_trans_medcheck_mcu_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_mcu_det
DROP TABLE IF EXISTS `tbl_trans_medcheck_mcu_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_mcu_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_mcu` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `param` varchar(160) DEFAULT NULL,
  `param_nilai` text DEFAULT NULL,
  `param_sat` text DEFAULT NULL,
  `param_sat2` text DEFAULT NULL,
  `status_bag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_mcu_det_tbl_trans_medcheck_mcu` (`id_mcu`) USING BTREE,
  CONSTRAINT `FK_tbl_trans_medcheck_mcu_det_tbl_trans_medcheck_mcu` FOREIGN KEY (`id_mcu`) REFERENCES `tbl_trans_medcheck_mcu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_pen_hrv
DROP TABLE IF EXISTS `tbl_trans_medcheck_pen_hrv`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_pen_hrv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_analis` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_lab` varchar(160) DEFAULT NULL,
  `hsl_mhr` varchar(160) DEFAULT NULL COMMENT 'Irama',
  `hsl_sdnn` varchar(160) DEFAULT NULL COMMENT 'Frekuensi',
  `hsl_rmssd` varchar(160) DEFAULT NULL COMMENT 'Axis',
  `hsl_psi` varchar(160) DEFAULT NULL COMMENT 'Posisi',
  `hsl_lhhf` varchar(160) DEFAULT NULL COMMENT 'Zona Transisi',
  `hsl_eb` varchar(160) DEFAULT NULL COMMENT 'Gelombang P',
  `hsl_ans` varchar(160) DEFAULT NULL COMMENT 'Interval P - R',
  `hsl_pi` varchar(160) DEFAULT NULL COMMENT 'Kompleks QRS',
  `hsl_es` varchar(160) DEFAULT NULL COMMENT 'Segment ST',
  `hsl_rrv` varchar(160) DEFAULT NULL COMMENT 'Gelombang T',
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_lab_hrv_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_lab_hrv_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Untuk menyimpan pemeriksaan penunjang hrv';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_plat
DROP TABLE IF EXISTS `tbl_trans_medcheck_plat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_plat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_platform` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `platform` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `nominal` decimal(32,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_plat_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=100788 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_rad
DROP TABLE IF EXISTS `tbl_trans_medcheck_rad`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_rad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_radiografer` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_dokter_kirim` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_rad` varchar(50) DEFAULT NULL,
  `no_sample` varchar(50) DEFAULT NULL,
  `dokter_kirim` varchar(160) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `item` longtext DEFAULT NULL,
  `status` int(11) DEFAULT 0 COMMENT '0=pend\\\\r\\\\n1=proses\\\\r\\\\n2=diterima\\\\r\\\\n3=ditolak\\\\r\\\\n4=farmasi\\\\r\\\\n5=farmasi_proses',
  `status_dokter_krm` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_rad_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_rad_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11771 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_rad_det
DROP TABLE IF EXISTS `tbl_trans_medcheck_rad_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_rad_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_medcheck_det` int(11) NOT NULL DEFAULT 0,
  `id_rad` int(11) NOT NULL DEFAULT 0,
  `id_radiografer` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `item_name` varchar(100) DEFAULT NULL,
  `item_value` text DEFAULT NULL,
  `item_note` text DEFAULT NULL,
  `file` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_rad_det_tbl_trans_medcheck_rad` (`id_rad`),
  CONSTRAINT `FK_tbl_trans_medcheck_rad_det_tbl_trans_medcheck_rad` FOREIGN KEY (`id_rad`) REFERENCES `tbl_trans_medcheck_rad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22699 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_rad_file
DROP TABLE IF EXISTS `tbl_trans_medcheck_rad_file`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_rad_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_rad` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `judul` varchar(160) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `file_name_orig` varchar(160) DEFAULT NULL,
  `file_ext` varchar(50) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_base64` longtext DEFAULT NULL,
  `sp` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_rad_file_tbl_trans_medcheck_rad` (`id_rad`),
  CONSTRAINT `FK_tbl_trans_medcheck_rad_file_tbl_trans_medcheck_rad` FOREIGN KEY (`id_rad`) REFERENCES `tbl_trans_medcheck_rad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8610 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_remun
DROP TABLE IF EXISTS `tbl_trans_medcheck_remun`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_remun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `item` varchar(168) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT NULL,
  `remun_perc` decimal(10,2) DEFAULT NULL,
  `remun_nom` decimal(10,2) DEFAULT NULL,
  `remun_subtotal` decimal(10,2) DEFAULT NULL,
  `remun_tipe` int(11) DEFAULT 0 COMMENT '1=persen\r\n2=nominal',
  PRIMARY KEY (`id`),
  KEY `FK__tbl_trans_medcheck` (`id_medcheck`),
  KEY `FK_tbl_trans_medcheck_remun_tbl_trans_medcheck_det` (`id_medcheck_det`),
  CONSTRAINT `FK_tbl_trans_medcheck_remun_tbl_trans_medcheck_det` FOREIGN KEY (`id_medcheck_det`) REFERENCES `tbl_trans_medcheck_det` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=184567 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_resep
DROP TABLE IF EXISTS `tbl_trans_medcheck_resep`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_resep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_pasien` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_farmasi` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_keluar` datetime DEFAULT '0000-00-00 00:00:00',
  `no_resep` varchar(50) DEFAULT NULL,
  `nm_resep` varchar(160) DEFAULT NULL,
  `ket` varchar(160) DEFAULT NULL,
  `file_name` varchar(160) DEFAULT NULL,
  `item` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0=pend\r\n1=proses\r\n2=diterima\r\n3=ditolak\r\n4=farmasi\r\n5=farmasi_proses',
  `status_plg` enum('0','1') DEFAULT '0' COMMENT 'Status Obat Pulang untuk pasien rawat inap',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_resep_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_resep_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121840 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tabel ini menyimpan no resep dan siapa yg membuat resepnya beserta siapa yang menerima resep tersebut';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_resep_det
DROP TABLE IF EXISTS `tbl_trans_medcheck_resep_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_resep_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `id_resep` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_item_ref` int(11) DEFAULT 0,
  `id_item_kat` int(11) DEFAULT 0,
  `id_item_sat` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_ed` date DEFAULT '0000-00-00',
  `kode` varchar(50) DEFAULT NULL,
  `item` varchar(160) DEFAULT NULL,
  `dosis` varchar(160) DEFAULT NULL,
  `dosis_ket` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `resep` longtext DEFAULT NULL,
  `harga` decimal(20,6) DEFAULT NULL,
  `jml` decimal(20,2) DEFAULT NULL,
  `jml_satuan` decimal(20,2) DEFAULT NULL,
  `subtotal` decimal(20,2) DEFAULT NULL,
  `disk1` decimal(20,2) DEFAULT NULL,
  `disk2` decimal(20,2) DEFAULT NULL,
  `disk3` decimal(20,2) DEFAULT NULL,
  `diskon` decimal(20,2) DEFAULT NULL,
  `potongan` decimal(20,2) DEFAULT NULL,
  `satuan` varchar(160) DEFAULT NULL,
  `status_mkn` enum('0','1','2','3','4') DEFAULT '0' COMMENT '0=none;\\r\\n1=sebelum makan;\\r\\n2=satt makan;\\r\\n3=sesudah makan;\\r\\n4=lain',
  `status_resep` int(11) DEFAULT 0 COMMENT '0=pend;\\r\\n1=diterima;\\r\\n2=ditolak (barang habis / diganti);\\r\\n3=batal;\\r\\n4=proses;',
  `status_pj` enum('0','1','2') DEFAULT '0' COMMENT 'Status Penjamin (UMUM, BPJS, dll)\r\n0=tidak\r\n1=ya',
  `status_etiket` enum('0','1','2') DEFAULT '0' COMMENT '0=netral;\\r\\n1=etiket putih\\r\\n2=etiket biru',
  `sp` enum('0','1','2') DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_resep_det_tbl_trans_medcheck` (`id_resep`),
  CONSTRAINT `FK_tbl_trans_medcheck_resep_det_tbl_trans_medcheck_resep` FOREIGN KEY (`id_resep`) REFERENCES `tbl_trans_medcheck_resep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=468779 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_resep_det_rc
DROP TABLE IF EXISTS `tbl_trans_medcheck_resep_det_rc`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_resep_det_rc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_resep` int(11) DEFAULT 0,
  `id_resep_det` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_item_kat` int(11) DEFAULT 0,
  `id_item_sat` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(160) DEFAULT NULL,
  `item` varchar(160) DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT NULL,
  `jml_satuan` decimal(10,2) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `satuan_farmasi` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `catatan` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_resep_det_rc_tbl_trans_medcheck_resep_det` (`id_resep_det`),
  CONSTRAINT `FK_tbl_trans_medcheck_resep_det_rc_tbl_trans_medcheck_resep_det` FOREIGN KEY (`id_resep_det`) REFERENCES `tbl_trans_medcheck_resep_det` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70341 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin COMMENT='Tabel ini untuk menyimpan detail resep';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_resume
DROP TABLE IF EXISTS `tbl_trans_medcheck_resume`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `no_surat` varchar(160) DEFAULT NULL,
  `no_sample` varchar(160) DEFAULT NULL,
  `pasien` varchar(160) DEFAULT NULL,
  `saran` longtext DEFAULT NULL,
  `kesimpulan` longtext DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0',
  `status_rsm` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_resume_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_resume_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5950 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_resume_det
DROP TABLE IF EXISTS `tbl_trans_medcheck_resume_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_resume_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_resume` int(11) DEFAULT 0,
  `id_mcu_header` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_produk` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `param` varchar(160) DEFAULT NULL,
  `param_nilai` text DEFAULT NULL,
  `status_rnp` enum('0','1') DEFAULT '0',
  `status_trp` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_resume_det_tbl_trans_medcheck_resume` (`id_resume`),
  CONSTRAINT `FK_tbl_trans_medcheck_resume_det_tbl_trans_medcheck_resume` FOREIGN KEY (`id_resume`) REFERENCES `tbl_trans_medcheck_resume` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51158 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_retur
DROP TABLE IF EXISTS `tbl_trans_medcheck_retur`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_retur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `item` varchar(160) DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT 0.00,
  `status_item` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_retur_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_retur_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19682 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_rm
DROP TABLE IF EXISTS `tbl_trans_medcheck_rm`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_rm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_perawat` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_icd` int(11) DEFAULT 0,
  `id_icd10` int(11) DEFAULT 0,
  `kode` varchar(50) DEFAULT '0',
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_modif` datetime DEFAULT '0000-00-00 00:00:00',
  `anamnesa` mediumtext DEFAULT NULL,
  `pemeriksaan` mediumtext DEFAULT NULL,
  `diagnosa` mediumtext DEFAULT NULL,
  `terapi` mediumtext DEFAULT NULL,
  `program` mediumtext DEFAULT NULL,
  `ttv_skala` decimal(10,2) DEFAULT NULL,
  `ttv_saturasi` decimal(10,2) DEFAULT NULL,
  `ttv_laju` decimal(10,2) DEFAULT NULL,
  `ttv_nadi` decimal(10,2) DEFAULT NULL,
  `ttv_diastole` decimal(10,2) DEFAULT NULL,
  `ttv_sistole` decimal(10,2) DEFAULT NULL,
  `ttv_tb` decimal(10,2) DEFAULT NULL,
  `ttv_bb` decimal(10,2) DEFAULT NULL,
  `ttv_st` decimal(10,2) DEFAULT NULL,
  `ns_subj` longtext DEFAULT NULL,
  `ns_obj` longtext DEFAULT NULL,
  `ns_ass` longtext DEFAULT NULL,
  `ns_prog` longtext DEFAULT NULL,
  `status` enum('0','1','2') DEFAULT '0' COMMENT '0=tidak\r\n1=perawat\r\n2=dokter',
  `tipe` enum('0','1','2') DEFAULT '0' COMMENT '0 = nothing\r\n1 = perawat\r\n2 = dokter',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_rm_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_rm_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16779 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_stok
DROP TABLE IF EXISTS `tbl_trans_medcheck_stok`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_medcheck_det` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_gudang` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` datetime DEFAULT '0000-00-00 00:00:00',
  `item` varchar(160) DEFAULT NULL,
  `stok_awal` decimal(10,2) DEFAULT 0.00,
  `jml` decimal(10,2) DEFAULT 0.00,
  `stok_akhir` decimal(10,2) DEFAULT 0.00,
  `keterangan` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_stok_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_stok_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=457503 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_surat
DROP TABLE IF EXISTS `tbl_trans_medcheck_surat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_surat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `tgl_kontrol` date DEFAULT '0000-00-00',
  `no_surat` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `lahir_tgl` datetime DEFAULT '0000-00-00 00:00:00',
  `lahir_nm` varchar(160) DEFAULT NULL,
  `lahir_nm_ayah` varchar(160) DEFAULT NULL,
  `lahir_nm_ibu` varchar(160) DEFAULT NULL,
  `mati_tgl` datetime DEFAULT '0000-00-00 00:00:00',
  `mati_tmp` varchar(160) DEFAULT NULL,
  `mati_penyebab` varchar(160) DEFAULT NULL,
  `ruj_dokter` varchar(160) DEFAULT NULL,
  `ruj_faskes` varchar(160) DEFAULT NULL,
  `ruj_keluhan` text DEFAULT NULL,
  `ruj_diagnosa` text DEFAULT NULL,
  `ruj_terapi` text DEFAULT NULL,
  `jns_klm` varchar(50) DEFAULT NULL,
  `cvd_tgl_periksa` date DEFAULT '0000-00-00',
  `cvd_tgl_awal` date DEFAULT '0000-00-00',
  `cvd_tgl_akhir` date DEFAULT '0000-00-00',
  `vks_tgl_periksa` date DEFAULT '0000-00-00',
  `nza_tgl_periksa` date DEFAULT '0000-00-00' COMMENT 'Bebas Napza / Narkoba',
  `nza_status` enum('0','1','2') DEFAULT '0' COMMENT '0 = Belum;\\r\\n1 = Posistif;\\r\\n2 = Negatif;',
  `hml_periksa` text DEFAULT NULL,
  `hml_tipe_ijin` enum('0','1','2') DEFAULT '0',
  `hml_tipe_terbang` enum('0','1','2') DEFAULT '0',
  `hml_tgl_awal` date DEFAULT '0000-00-00',
  `hml_tgl_akhir` date DEFAULT '0000-00-00',
  `hml_status_sehat` enum('0','1','2') DEFAULT '0',
  `trb_tgl_awal` date DEFAULT '0000-00-00',
  `trb_tgl_akhir` date DEFAULT '0000-00-00',
  `trb_periksa` text DEFAULT NULL,
  `trb_tipe_terbang` enum('0','1','2') DEFAULT '0',
  `tb` decimal(10,2) DEFAULT NULL,
  `td` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bb` decimal(10,2) DEFAULT NULL,
  `tht_lt_kanan` varchar(100) DEFAULT NULL,
  `tht_lt_kiri` varchar(100) DEFAULT NULL,
  `tht_membran_kanan` varchar(100) DEFAULT NULL,
  `tht_membran_kiri` varchar(100) DEFAULT NULL,
  `tht_mukosa_kanan` varchar(100) DEFAULT NULL,
  `tht_mukosa_kiri` varchar(100) DEFAULT NULL,
  `tht_konka_kanan` varchar(100) DEFAULT NULL,
  `tht_konka_kiri` varchar(100) DEFAULT NULL,
  `tht_timpa_kanan` varchar(100) DEFAULT NULL,
  `tht_timpa_kiri` varchar(100) DEFAULT NULL,
  `tht_tonsil_tg` varchar(100) DEFAULT NULL,
  `tht_mukosa_tg` varchar(100) DEFAULT NULL,
  `tht_faring_tg` varchar(100) DEFAULT NULL,
  `tht_audio` text DEFAULT NULL,
  `tht_kesimpulan` text DEFAULT NULL,
  `bw` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `bw_ket` text DEFAULT NULL,
  `jml_hari` int(11) DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tipe` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0' COMMENT '1=Surat Sehat\\\\\\\\r\\\\\\\\n2=Surat Sakit\\\\\\\\r\\\\\\\\n3=Surat Ranap\\\\\\\\r\\\\\\\\n4=Surat Kontrol\\\\\\\\r\\\\\\\\n5=Surat Hsl Radiolog\\\\\\\\r\\\\\\\\n6=Surat Kematian\\\\\\\\r\\\\\\\\n7=Surat Hsl Covid',
  `hasil` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status` enum('0','1','2','3','4','5','6','7','8','9','10') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status_sembuh` enum('0','1','2','3','4') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_surat_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_surat_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21081 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_surat_inform
DROP TABLE IF EXISTS `tbl_trans_medcheck_surat_inform`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_surat_inform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_ruang` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_lahir` date DEFAULT '0000-00-00',
  `no_surat` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nama` varchar(160) DEFAULT NULL,
  `nama_saksi1` varchar(160) DEFAULT NULL,
  `nama_saksi2` varchar(160) DEFAULT NULL,
  `jns_klm` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `ruang` varchar(160) DEFAULT NULL,
  `penjamin` varchar(160) DEFAULT NULL,
  `penanggung` varchar(160) DEFAULT NULL,
  `tindakan` text DEFAULT NULL,
  `file_name1` varchar(160) DEFAULT NULL,
  `file_name2` varchar(160) DEFAULT NULL,
  `file_name3` varchar(160) DEFAULT NULL,
  `file_name4` varchar(160) DEFAULT NULL,
  `file_name5` varchar(160) DEFAULT NULL,
  `file_name6` varchar(160) DEFAULT NULL,
  `tipe` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0' COMMENT '1=Surat Sehat\\r\\n2=Surat Sakit\\r\\n3=Surat Ranap\\r\\n4=Surat Kontrol\\r\\n5=Surat Hsl Radiolog\\r\\n6=Surat Kematian\\r\\n7=Surat Hsl Covid',
  `status` enum('0','1','2','3','4','5','6','7','8','9','10') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status_hub` enum('0','1','2','3','4','5','6') DEFAULT '0' COMMENT 'Status Kekerabatan',
  `status_stj` enum('0','1','2') DEFAULT '0',
  `status_ttd` enum('0','1') DEFAULT '0' COMMENT 'Sudah ttd atau belum',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tbl_trans_medcheck_surat_inform_tbl_trans_medcheck` (`id_medcheck`) USING BTREE,
  CONSTRAINT `FK_tbl_trans_medcheck_surat_inform_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4999 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_medcheck_trf
DROP TABLE IF EXISTS `tbl_trans_medcheck_trf`;
CREATE TABLE IF NOT EXISTS `tbl_trans_medcheck_trf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `id_poli_asal` int(11) DEFAULT 0,
  `id_poli_tujuan` int(11) DEFAULT 0,
  `id_pasien` int(11) DEFAULT 0,
  `id_dokter` int(11) DEFAULT 0,
  `tipe` int(11) DEFAULT 0,
  `tipe_asal` int(11) DEFAULT 0,
  `tipe_tujuan` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `no_surat` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `keterangan_dokter` text DEFAULT NULL,
  `keterangan_perawat` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_medcheck_trf_tbl_trans_medcheck` (`id_medcheck`),
  CONSTRAINT `FK_tbl_trans_medcheck_trf_tbl_trans_medcheck` FOREIGN KEY (`id_medcheck`) REFERENCES `tbl_trans_medcheck` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7549 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_mutasi
DROP TABLE IF EXISTS `tbl_trans_mutasi`;
CREATE TABLE IF NOT EXISTS `tbl_trans_mutasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_user_terima` int(11) DEFAULT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `kode_nota_dpn` varchar(50) DEFAULT NULL,
  `kode_nota_blk` varchar(50) DEFAULT NULL,
  `tgl_masuk` date DEFAULT '0000-00-00',
  `tgl_keluar` date DEFAULT '0000-00-00',
  `id_gd_asal` int(11) DEFAULT NULL,
  `id_gd_tujuan` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_nota` enum('0','1','2','3','4') DEFAULT '0',
  `status_terima` enum('0','1') DEFAULT '0',
  `tipe` enum('0','1','2','3') DEFAULT '0' COMMENT '1 = Pindah Gudang\r\n2 = Stok Masuk\r\n3 = Stok Keluar',
  PRIMARY KEY (`id`),
  KEY `no_nota` (`no_nota`)
) ENGINE=InnoDB AUTO_INCREMENT=666 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Mencatat transaksi mutasi antar gudang';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_mutasi_det
DROP TABLE IF EXISTS `tbl_trans_mutasi_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_mutasi_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mutasi` int(11) NOT NULL DEFAULT 0,
  `id_satuan` int(11) DEFAULT 0,
  `id_item` int(11) DEFAULT 0,
  `id_user` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_terima` datetime DEFAULT NULL,
  `tgl_ed` varchar(50) DEFAULT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `kode_batch` varchar(50) DEFAULT NULL,
  `produk` varchar(256) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jml` int(6) DEFAULT 0,
  `jml_diterima` int(6) DEFAULT 0,
  `jml_satuan` int(6) DEFAULT NULL,
  `status_brg` enum('0','1') DEFAULT '0',
  `status_terima` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_mutasi` (`id_mutasi`),
  CONSTRAINT `FK_tbl_trans_gudang_det_tbl_trans_gudang` FOREIGN KEY (`id_mutasi`) REFERENCES `tbl_trans_mutasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23687 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Mencatat transaksi mutasi antar gudang';

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_retur_beli
DROP TABLE IF EXISTS `tbl_trans_retur_beli`;
CREATE TABLE IF NOT EXISTS `tbl_trans_retur_beli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT 0,
  `id_pelanggan` int(11) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `id_pembelian` int(11) NOT NULL DEFAULT 0,
  `tgl_simpan` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_nota` varchar(50) DEFAULT NULL,
  `no_retur` varchar(50) DEFAULT NULL,
  `jml_total` decimal(32,2) DEFAULT NULL,
  `ppn` decimal(32,2) DEFAULT NULL,
  `jml_ppn` decimal(32,2) DEFAULT NULL,
  `jml_retur` decimal(32,2) DEFAULT NULL,
  `status_retur` int(11) NOT NULL,
  `status_ppn` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCustomer` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_retur_beli_det
DROP TABLE IF EXISTS `tbl_trans_retur_beli_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_retur_beli_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_retur_beli` int(11) DEFAULT NULL,
  `id_beli_det` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT '0000-00-00 00:00:00',
  `kode` varchar(50) DEFAULT NULL,
  `produk` varchar(256) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` decimal(32,2) DEFAULT NULL,
  `disk1` decimal(10,2) DEFAULT NULL,
  `disk2` decimal(10,2) DEFAULT NULL,
  `disk3` decimal(10,2) DEFAULT NULL,
  `jml` int(6) DEFAULT NULL,
  `jml_satuan` int(6) DEFAULT NULL,
  `diskon` decimal(32,2) DEFAULT NULL,
  `potongan` decimal(32,2) DEFAULT NULL,
  `subtotal` decimal(32,2) DEFAULT NULL,
  `status_retur` enum('1','2') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_retur_beli_det_tbl_trans_retur_beli` (`id_retur_beli`),
  CONSTRAINT `FK_tbl_trans_retur_beli_det_tbl_trans_retur_beli` FOREIGN KEY (`id_retur_beli`) REFERENCES `tbl_trans_retur_beli` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_retur_jual
DROP TABLE IF EXISTS `tbl_trans_retur_jual`;
CREATE TABLE IF NOT EXISTS `tbl_trans_retur_jual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) DEFAULT 0,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_user_auth` int(11) DEFAULT NULL,
  `id_penjualan` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `no_retur` varchar(50) DEFAULT '0',
  `no_nota` varchar(50) DEFAULT '0',
  `jml_total` decimal(32,2) DEFAULT NULL,
  `jml_diskon` decimal(32,2) DEFAULT NULL,
  `ppn` decimal(32,2) DEFAULT NULL,
  `jml_ppn` decimal(32,2) DEFAULT NULL,
  `jml_retur` decimal(32,2) DEFAULT NULL,
  `jml_gtotal` decimal(32,2) DEFAULT NULL,
  `status_retur` int(11) DEFAULT NULL,
  `status_ppn` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idCustomer` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_retur_jual_det
DROP TABLE IF EXISTS `tbl_trans_retur_jual_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_retur_jual_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_retur_jual` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `produk` varchar(256) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` decimal(32,2) DEFAULT NULL,
  `disk1` decimal(10,2) DEFAULT NULL,
  `disk2` decimal(10,2) DEFAULT NULL,
  `disk3` decimal(10,2) DEFAULT NULL,
  `jml` int(6) DEFAULT NULL,
  `jml_satuan` int(6) DEFAULT NULL,
  `diskon` decimal(32,2) DEFAULT NULL,
  `potongan` decimal(32,2) DEFAULT NULL,
  `subtotal` decimal(32,2) DEFAULT NULL,
  `status_retur` enum('1','2','3') DEFAULT NULL,
  `status_nota` enum('1','2') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_retur_jual_det_tbl_trans_retur_jual` (`id_retur_jual`),
  CONSTRAINT `FK_tbl_trans_retur_jual_det_tbl_trans_retur_jual` FOREIGN KEY (`id_retur_jual`) REFERENCES `tbl_trans_retur_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_stok_tmp
DROP TABLE IF EXISTS `tbl_trans_stok_tmp`;
CREATE TABLE IF NOT EXISTS `tbl_trans_stok_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) DEFAULT 0,
  `id_item_det` int(11) DEFAULT 0,
  `item` varchar(160) DEFAULT NULL,
  `keterangan` varchar(160) DEFAULT NULL,
  `stok_awal` decimal(10,2) DEFAULT 0.00,
  `jml` decimal(10,2) DEFAULT 0.00,
  `stok_akhir` decimal(10,2) DEFAULT 0.00,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_trans_stok_tmp_glob
DROP TABLE IF EXISTS `tbl_trans_stok_tmp_glob`;
CREATE TABLE IF NOT EXISTS `tbl_trans_stok_tmp_glob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) DEFAULT 0,
  `jml` decimal(10,2) DEFAULT 0.00,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_backup
DROP TABLE IF EXISTS `tbl_util_backup`;
CREATE TABLE IF NOT EXISTS `tbl_util_backup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NULL DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  `file_name` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_eksport
DROP TABLE IF EXISTS `tbl_util_eksport`;
CREATE TABLE IF NOT EXISTS `tbl_util_eksport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_import
DROP TABLE IF EXISTS `tbl_util_import`;
CREATE TABLE IF NOT EXISTS `tbl_util_import` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `file` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_log
DROP TABLE IF EXISTS `tbl_util_log`;
CREATE TABLE IF NOT EXISTS `tbl_util_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `id_user` int(11) DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_log_satusehat
DROP TABLE IF EXISTS `tbl_util_log_satusehat`;
CREATE TABLE IF NOT EXISTS `tbl_util_log_satusehat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medcheck` int(11) NOT NULL DEFAULT 0,
  `no_register` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `response_status` longtext DEFAULT NULL,
  `postdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7391 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_so
DROP TABLE IF EXISTS `tbl_util_so`;
CREATE TABLE IF NOT EXISTS `tbl_util_so` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_gudang` int(11) DEFAULT 0,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `satuan` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nm_file` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `dl_file` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `reset` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `status` enum('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=864 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tbl_util_so_det
DROP TABLE IF EXISTS `tbl_util_so_det`;
CREATE TABLE IF NOT EXISTS `tbl_util_so_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_so` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tgl_simpan` datetime DEFAULT NULL,
  `tgl_modif` datetime DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `produk` varchar(100) DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `jml` decimal(10,2) DEFAULT NULL,
  `jml_sys` decimal(10,2) DEFAULT NULL,
  `jml_so` decimal(10,2) DEFAULT NULL,
  `jml_sls` decimal(10,2) DEFAULT NULL,
  `jml_satuan` int(11) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `sp` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_tbl_util_so_det_tbl_util_so` (`id_so`),
  CONSTRAINT `FK_tbl_util_so_det_tbl_util_so` FOREIGN KEY (`id_so`) REFERENCES `tbl_util_so` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12110 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.tr_queue
DROP TABLE IF EXISTS `tr_queue`;
CREATE TABLE IF NOT EXISTS `tr_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_view` int(11) NOT NULL DEFAULT 0,
  `id_medcheck` int(11) DEFAULT 0,
  `id_dft` int(11) DEFAULT 0,
  `ddate` date DEFAULT NULL,
  `cnoro` varchar(35) DEFAULT NULL,
  `ncount` decimal(3,0) DEFAULT NULL,
  `ccustsrv` varchar(35) DEFAULT NULL,
  `cnote` text DEFAULT NULL,
  `csflagqu` varchar(15) DEFAULT NULL,
  `csflaghd` varchar(15) DEFAULT NULL,
  `ccode` varchar(5) DEFAULT NULL,
  `crgcode` varchar(5) DEFAULT NULL,
  `ddatestart` datetime DEFAULT NULL,
  `ddatepross` datetime DEFAULT NULL,
  `ddateend` datetime DEFAULT NULL,
  `cUser` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `suara` varchar(160) DEFAULT '',
  `suara2` varchar(160) DEFAULT '',
  `status` enum('0','1','2') DEFAULT '0',
  `status_pgl` enum('0','1') DEFAULT '0',
  `dCreateDate` datetime DEFAULT '0000-00-00 00:00:00',
  `dLastUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247327 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_medkit_ci3.vtrans_antrian
DROP TABLE IF EXISTS `vtrans_antrian`;
CREATE TABLE IF NOT EXISTS `vtrans_antrian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nttrans` int(11) DEFAULT NULL,
  `ddate` date DEFAULT NULL,
  `cflag` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for view db_medkit_ci3.v_alert_medcheck
DROP VIEW IF EXISTS `v_alert_medcheck`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_alert_medcheck` (
	`id_pertama` INT(11) NOT NULL,
	`id_kedua` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`id_dokter` INT(11) NULL,
	`dokter` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_periksa` DATETIME NULL,
	`tgl_periksa_duplikat` DATETIME NULL,
	`selisih_menit` BIGINT(21) NULL,
	`id_user_pertama` INT(11) NULL,
	`id_user_kedua` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_alert_medcheck_det
DROP VIEW IF EXISTS `v_alert_medcheck_det`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_alert_medcheck_det` (
	`id_pertama` INT(11) NOT NULL,
	`id_kedua` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`id_dokter` INT(11) NULL,
	`dokter` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_periksa` DATETIME NULL,
	`tgl_periksa_duplikat` DATETIME NULL,
	`selisih_menit` BIGINT(21) NULL,
	`id_user_pertama` INT(11) NULL,
	`id_user_kedua` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_karyawan_absen
DROP VIEW IF EXISTS `v_karyawan_absen`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_karyawan_absen` (
	`id` INT(4) NOT NULL,
	`id_user` INT(4) NULL,
	`nama_dpn` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama_blk` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`tgl_masuk` DATE NULL,
	`wkt_masuk` TIME NULL,
	`wkt_keluar` TIME NULL,
	`scan1` TIME NULL,
	`scan2` TIME NULL,
	`scan3` TIME NULL,
	`scan4` TIME NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_laporan_stok
DROP VIEW IF EXISTS `v_laporan_stok`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_laporan_stok` (
	`id` INT(11) NOT NULL,
	`tgl_simpan` DATETIME NULL,
	`item` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`stok` FLOAT NULL,
	`laku` DECIMAL(32,2) NULL,
	`sisa_stok` DOUBLE NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_master_absen
DROP VIEW IF EXISTS `v_master_absen`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_master_absen` (
	`id` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`nama_dpn` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama_blk` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATE NULL,
	`wkt_masuk` TIME NULL,
	`wkt_keluar` TIME NULL,
	`scan1` TIME NULL,
	`scan2` TIME NULL,
	`scan3` TIME NULL,
	`scan4` TIME NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_master_dokter
DROP VIEW IF EXISTS `v_master_dokter`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_master_dokter` (
	`id` INT(4) NOT NULL,
	`id_user` INT(4) NULL,
	`id_poli` INT(11) NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_dpn` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama_blk` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`hari_1` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_2` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_3` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_4` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_5` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_6` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`hari_7` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`status_prtk` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck
DROP VIEW IF EXISTS `v_medcheck`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck` (
	`id` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`id_nurse` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_pasien` INT(11) NULL,
	`id_referall` INT(11) NULL,
	`id_poli` INT(11) NULL,
	`id_dft` INT(11) NULL COMMENT 'ID yang diambil dari tbl_pendaftaran kolom id',
	`id_ant` INT(11) NULL,
	`id_kasir` INT(11) NULL,
	`id_instansi` INT(11) NULL,
	`id_encounter` TEXT NULL COLLATE 'utf8_general_ci',
	`id_condition` TEXT NULL COLLATE 'utf8_general_ci',
	`id_location` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`id_icd` INT(11) NULL,
	`id_icd10` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`tgl_periksa` DATETIME NULL,
	`tgl_periksa_lab` DATETIME NULL,
	`tgl_periksa_rad` DATETIME NULL,
	`tgl_periksa_pen` DATETIME NULL,
	`tgl_ranap` DATETIME NULL,
	`tgl_keluar` DATETIME NULL,
	`tgl_bayar` DATETIME NULL,
	`tgl_ttd` DATETIME NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_akun` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`no_nota` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nik_dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama_dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`kode` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nik_pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`keluhan` TEXT NULL COLLATE 'latin1_swedish_ci',
	`ttv` TEXT NULL COLLATE 'utf8_general_ci',
	`ttv_st` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_bb` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_tb` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_td` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_sistole` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_diastole` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_nadi` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_laju` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_saturasi` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_skala` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`diagnosa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`anamnesa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`pemeriksaan` TEXT NULL COLLATE 'latin1_swedish_ci',
	`program` TEXT NULL COLLATE 'utf8_general_ci',
	`alergi` TEXT NULL COLLATE 'utf8_general_ci',
	`metode` INT(11) NULL,
	`platform` INT(11) NULL,
	`jml_total` DECIMAL(10,2) NULL,
	`jml_dp` DECIMAL(10,2) NULL,
	`jml_diskon` DECIMAL(10,2) NULL,
	`jml_potongan` DECIMAL(10,2) NULL,
	`jml_potongan_poin` DECIMAL(10,2) NULL,
	`jml_subtotal` DECIMAL(10,2) NULL,
	`jml_ppn` DECIMAL(10,2) NULL,
	`ppn` DECIMAL(10,2) NULL,
	`jml_gtotal` DECIMAL(10,2) NULL,
	`jml_bayar` DECIMAL(10,2) NULL,
	`jml_kembali` DECIMAL(10,2) NULL,
	`jml_kurang` DECIMAL(10,2) NULL,
	`jml_poin` DECIMAL(10,2) NULL,
	`jml_poin_nom` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`tipe_bayar` INT(11) NULL COMMENT '0 = tidak ada;\r\n1 = UMUM;\r\n2 = ASURANSI;\r\n3 = BPJS;',
	`status` INT(11) NULL COMMENT '1=anamnesa;\r\n2=tindakan;\r\n3=obat;\r\n4=laborat;\r\n5=dokter;\r\n6=pembayaran;\r\n7=finish',
	`status_bayar` INT(11) NULL COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;',
	`status_nota` INT(11) NULL COMMENT '0=pend;\r\n1=proses;\r\n2=finish;\r\n3=batal',
	`status_hps` ENUM('0','1') NULL COLLATE 'latin1_swedish_ci',
	`status_pos` ENUM('0','1','2') NULL COLLATE 'utf8_general_ci',
	`status_periksa` ENUM('0','1','2') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_apotik
DROP VIEW IF EXISTS `v_medcheck_apotik`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_apotik` (
	`id` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`item` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`harga` DECIMAL(10,2) NULL,
	`jml` DECIMAL(10,2) NULL,
	`subtotal` DECIMAL(10,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_apres
DROP VIEW IF EXISTS `v_medcheck_apres`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_apres` (
	`id` INT(11) NOT NULL,
	`id_dokter` INT(11) NULL,
	`tgl_simpan` TIMESTAMP NULL,
	`dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`dokter_blk` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_pgl` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`item` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`jml` DECIMAL(10,2) NULL,
	`harga` DECIMAL(10,2) NULL,
	`apres_nom` DECIMAL(10,2) NULL,
	`apres_subtotal` DECIMAL(10,2) NULL,
	`apres_perc` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status_produk` INT(11) NULL COMMENT '2=tindakan\r\n3=lab\r\n4=obat\r\n5=radiologi\r\n6=racikan'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_bukti
DROP VIEW IF EXISTS `v_medcheck_bukti`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_bukti` (
	`id` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`id_user` INT(11) NOT NULL,
	`tgl_simpan` DATETIME NOT NULL,
	`username` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`judul` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`file_name` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`status` ENUM('0','1','2','3') NULL COMMENT '0=none;\\r\\n1=berkas unggah;\\r\\n2=resume;\\r\\n3=Bukti Bayar' COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_dokter
DROP VIEW IF EXISTS `v_medcheck_dokter`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_dokter` (
	`id` INT(11) NOT NULL,
	`id_dft` INT(11) NULL COMMENT 'ID yang diambil dari tbl_pendaftaran kolom id',
	`id_user` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`id_nurse` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_pasien` INT(11) NULL,
	`id_poli` INT(11) NULL,
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`no_nota` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`tgl_simpan` DATETIME NULL,
	`waktu_masuk` TIME NULL,
	`tgl_bayar` DATETIME NULL,
	`tgl_keluar` DATETIME NULL,
	`waktu_keluar` TIME NULL,
	`jml_total` DECIMAL(10,2) NULL,
	`jml_gtotal` DECIMAL(10,2) NULL,
	`ppn` DECIMAL(10,2) NULL,
	`jml_ppn` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` INT(11) NULL COMMENT '1=anamnesa;\r\n2=tindakan;\r\n3=obat;\r\n4=laborat;\r\n5=dokter;\r\n6=pembayaran;\r\n7=finish',
	`status_hps` ENUM('0','1') NULL COLLATE 'latin1_swedish_ci',
	`status_nota` INT(11) NULL COMMENT '0=pend;\r\n1=proses;\r\n2=finish;\r\n3=batal',
	`status_bayar` INT(11) NULL COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;',
	`status_periksa` ENUM('0','1','2') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_hapus
DROP VIEW IF EXISTS `v_medcheck_hapus`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_hapus` (
	`id` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`id_nurse` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_pasien` INT(11) NULL,
	`id_poli` INT(11) NULL,
	`id_dft` INT(11) NULL COMMENT 'ID yang diambil dari tbl_pendaftaran kolom id',
	`id_ant` INT(11) NULL,
	`id_kasir` INT(11) NULL,
	`id_icd` INT(11) NULL,
	`id_icd10` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`tgl_periksa` DATETIME NULL,
	`tgl_periksa_lab` DATETIME NULL,
	`tgl_periksa_rad` DATETIME NULL,
	`tgl_periksa_pen` DATETIME NULL,
	`tgl_ranap` DATETIME NULL,
	`tgl_keluar` DATETIME NULL,
	`tgl_bayar` DATETIME NULL,
	`tgl_ttd` DATETIME NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_akun` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`no_nota` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`keluhan` TEXT NULL COLLATE 'latin1_swedish_ci',
	`ttv` TEXT NULL COLLATE 'utf8_general_ci',
	`ttv_st` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_bb` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_tb` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_td` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_sistole` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_diastole` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_nadi` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_laju` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_saturasi` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`ttv_skala` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`diagnosa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`anamnesa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`pemeriksaan` TEXT NULL COLLATE 'latin1_swedish_ci',
	`program` TEXT NULL COLLATE 'utf8_general_ci',
	`alergi` TEXT NULL COLLATE 'utf8_general_ci',
	`metode` INT(11) NULL,
	`platform` INT(11) NULL,
	`jml_total` DECIMAL(10,2) NULL,
	`jml_dp` DECIMAL(10,2) NULL,
	`jml_diskon` DECIMAL(10,2) NULL,
	`jml_potongan` DECIMAL(10,2) NULL,
	`jml_subtotal` DECIMAL(10,2) NULL,
	`jml_ppn` DECIMAL(10,2) NULL,
	`ppn` DECIMAL(10,2) NULL,
	`jml_gtotal` DECIMAL(10,2) NULL,
	`jml_bayar` DECIMAL(10,2) NULL,
	`jml_kembali` DECIMAL(10,2) NULL,
	`jml_kurang` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`tipe_bayar` INT(11) NULL COMMENT '0 = tidak ada;\r\n1 = UMUM;\r\n2 = ASURANSI;\r\n3 = BPJS;',
	`status` INT(11) NULL COMMENT '1=anamnesa;\r\n2=tindakan;\r\n3=obat;\r\n4=laborat;\r\n5=dokter;\r\n6=pembayaran;\r\n7=finish',
	`status_bayar` INT(11) NULL COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;',
	`status_nota` INT(11) NULL COMMENT '0=pend;\r\n1=proses;\r\n2=finish;\r\n3=batal',
	`status_hps` ENUM('0','1') NULL COLLATE 'latin1_swedish_ci',
	`status_pos` ENUM('0','1','2') NULL COLLATE 'utf8_general_ci',
	`status_periksa` ENUM('0','1','2') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_lab
DROP VIEW IF EXISTS `v_medcheck_lab`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_lab` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`OrderDateTime` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`TrxID` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`PasienId` INT(11) NOT NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`Nik` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`PasienName` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`Address` TEXT NULL COLLATE 'latin1_swedish_ci',
	`Gender` ENUM('L','P') NULL COLLATE 'latin1_swedish_ci',
	`BirthDate` DATE NULL,
	`BirthPlace` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`DokterPerujukName` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`no_lab` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`status` INT(11) NULL COMMENT '0=pend\\r\\n1=proses\\r\\n2=diterima\\r\\n3=ditolak\\r\\n4=farmasi\\r\\n5=farmasi_proses',
	`status_lis` ENUM('0','1') NULL COMMENT 'Update status dari Mesin LIS' COLLATE 'latin1_swedish_ci',
	`status_cvd` ENUM('0','1','2') NULL COMMENT '0=tidak\r\n1=rapid\r\n2=pcr' COLLATE 'latin1_swedish_ci',
	`status_duplo` ENUM('0','1','2') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_lab_item
DROP VIEW IF EXISTS `v_medcheck_lab_item`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_lab_item` (
	`id_lab` INT(11) NULL,
	`TindakanId` INT(11) NULL,
	`TindakanName` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_mcu
DROP VIEW IF EXISTS `v_medcheck_mcu`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_mcu` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NULL,
	`id_instansi` INT(11) NULL,
	`id_pasien` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`nama_pgl` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_surat` VARCHAR(1) NULL COLLATE 'armscii8_bin',
	`saran` LONGTEXT NULL COLLATE 'armscii8_bin',
	`kesimpulan` LONGTEXT NULL COLLATE 'armscii8_bin'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_omset
DROP VIEW IF EXISTS `v_medcheck_omset`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_omset` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`id_poli` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`id_item` INT(11) NULL,
	`id_item_kat` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`tgl_bayar` DATETIME NULL,
	`no_akun` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`tgl_lahir` DATE NULL,
	`kode` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`item` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`jml` DECIMAL(10,2) NULL,
	`harga` DECIMAL(10,2) NULL,
	`diskon` DECIMAL(10,2) NULL,
	`potongan` DECIMAL(10,2) NULL,
	`potongan_poin` DECIMAL(10,2) NULL,
	`subtotal` DECIMAL(10,2) NULL,
	`jml_gtotal` DECIMAL(10,2) NULL,
	`status_pkt` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status` INT(11) NULL COMMENT '0=null\r\n1=obat\r\n2=lab\r\n3=tindakan\r\n4=radiologi',
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`tipe_bayar` INT(11) NULL COMMENT '0 = tidak ada;\r\n1 = UMUM;\r\n2 = ASURANSI;\r\n3 = BPJS;',
	`metode` INT(11) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_pen_ekg
DROP VIEW IF EXISTS `v_medcheck_pen_ekg`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_pen_ekg` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`jns_klm` ENUM('L','P') NULL COLLATE 'latin1_swedish_ci',
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` ENUM('0','1') NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_pen_hrv
DROP VIEW IF EXISTS `v_medcheck_pen_hrv`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_pen_hrv` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`jns_klm` ENUM('L','P') NULL COLLATE 'latin1_swedish_ci',
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` ENUM('0','1') NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_pen_spiro
DROP VIEW IF EXISTS `v_medcheck_pen_spiro`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_pen_spiro` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`id_user` INT(11) NULL,
	`id_analis` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`jns_klm` ENUM('L','P') NULL COLLATE 'latin1_swedish_ci',
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` INT(11) NULL COMMENT '0=pend\\\\r\\\\n1=proses\\\\r\\\\n2=diterima\\\\r\\\\n3=ditolak\\\\r\\\\n4=farmasi\\\\r\\\\n5=farmasi_proses'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_plat
DROP VIEW IF EXISTS `v_medcheck_plat`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_plat` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NOT NULL,
	`id_platform` INT(11) NOT NULL,
	`tgl_simpan` DATETIME NOT NULL,
	`no_nota` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`platform` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`keterangan` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`nominal` DECIMAL(32,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_referall
DROP VIEW IF EXISTS `v_medcheck_referall`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_referall` (
	`id` INT(11) NOT NULL,
	`id_user` INT(4) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_karyawan` VARCHAR(1) NULL COLLATE 'latin1_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_remun
DROP VIEW IF EXISTS `v_medcheck_remun`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_remun` (
	`id` INT(11) NOT NULL,
	`id_dokter` INT(11) NULL,
	`tgl_simpan` TIMESTAMP NULL,
	`dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`dokter_blk` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_pgl` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`item` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`jml` DECIMAL(10,2) NULL,
	`harga` DECIMAL(10,2) NULL,
	`remun_nom` DECIMAL(10,2) NULL,
	`remun_subtotal` DECIMAL(10,2) NULL,
	`remun_perc` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status_produk` INT(11) NULL COMMENT '2=tindakan\r\n3=lab\r\n4=obat\r\n5=radiologi\r\n6=racikan'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_resep
DROP VIEW IF EXISTS `v_medcheck_resep`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_resep` (
	`id` INT(11) NULL,
	`id_dft` INT(11) NULL COMMENT 'ID yang diambil dari tbl_pendaftaran kolom id',
	`id_pasien` INT(11) NULL,
	`id_resep` INT(11) NOT NULL,
	`id_farmasi` INT(11) NULL,
	`id_user` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nik` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`tgl_lahir` DATE NULL,
	`alamat` TEXT NULL COLLATE 'latin1_swedish_ci',
	`jns_klm` ENUM('L','P') NULL COLLATE 'latin1_swedish_ci',
	`tgl_resep_msk` DATETIME NULL,
	`tgl_resep_klr` DATETIME NULL,
	`ttd_obat` TEXT NULL COLLATE 'utf8_general_ci',
	`no_resep` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` INT(11) NULL COMMENT '0=pend\r\n1=proses\r\n2=diterima\r\n3=ditolak\r\n4=farmasi\r\n5=farmasi_proses',
	`status_plg` ENUM('0','1') NULL COMMENT 'Status Obat Pulang untuk pasien rawat inap' COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_rm
DROP VIEW IF EXISTS `v_medcheck_rm`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_rm` (
	`id` INT(11) NOT NULL,
	`id_medcheck` INT(11) NULL,
	`id_user` INT(11) NULL,
	`id_dokter` INT(11) NULL,
	`id_pasien` INT(11) NULL,
	`id_icd10` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`kode` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`tgl_lahir` DATE NULL,
	`anamnesa` MEDIUMTEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`pemeriksaan` MEDIUMTEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`diagnosa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`terapi` MEDIUMTEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`program` MEDIUMTEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`ttv_skala` DECIMAL(10,2) NULL,
	`ttv_saturasi` DECIMAL(10,2) NULL,
	`ttv_laju` DECIMAL(10,2) NULL,
	`ttv_nadi` DECIMAL(10,2) NULL,
	`ttv_diastole` DECIMAL(10,2) NULL,
	`ttv_sistole` DECIMAL(10,2) NULL,
	`ttv_tb` DECIMAL(10,2) NULL,
	`ttv_bb` DECIMAL(10,2) NULL,
	`ttv_st` DECIMAL(10,2) NULL,
	`tipe` ENUM('0','1','2') NULL COMMENT '0 = nothing\r\n1 = perawat\r\n2 = dokter' COLLATE 'utf8mb4_unicode_ci',
	`status` ENUM('0','1','2') NULL COMMENT '0=tidak\r\n1=perawat\r\n2=dokter' COLLATE 'utf8mb4_unicode_ci',
	`status_bayar` INT(11) NULL COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_rm_rj
DROP VIEW IF EXISTS `v_medcheck_rm_rj`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_rm_rj` (
	`id` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`kode` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`pasien` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`diagnosa` TEXT NULL COLLATE 'latin1_swedish_ci',
	`kode_icd` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`icd` TEXT NULL COLLATE 'utf8mb4_general_ci',
	`diagnosa_en` TEXT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_tracer
DROP VIEW IF EXISTS `v_medcheck_tracer`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_tracer` (
	`id` INT(11) NOT NULL,
	`id_poli` INT(11) NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_pgl` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_simpan` DATETIME NULL,
	`tanggal` DATE NULL,
	`wkt_daftar` DATETIME NULL,
	`wkt_periksa` DATETIME NULL,
	`wkt_sampling_msk` DATETIME NULL,
	`wkt_sampling_klr` DATETIME NULL,
	`wkt_rad_msk` DATETIME NULL,
	`wkt_rad_klr` DATETIME NULL,
	`wkt_rad_krm` DATETIME NULL,
	`wkt_rad_baca` DATETIME NULL,
	`wkt_resep_msk` DATETIME NULL,
	`wkt_resep_klr` DATETIME NULL,
	`wkt_resep_byr` DATETIME NULL,
	`wkt_resep_trm` DATETIME NULL,
	`wkt_farmasi_msk` DATETIME NULL,
	`wkt_farmasi_klr` DATETIME NULL,
	`wkt_ranap` DATETIME NULL,
	`wkt_ranap_keluar` DATETIME NULL,
	`wkt_selesai` DATETIME NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status` INT(11) NULL COMMENT '1=anamnesa;\r\n2=tindakan;\r\n3=obat;\r\n4=laborat;\r\n5=dokter;\r\n6=pembayaran;\r\n7=finish'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_medcheck_visit
DROP VIEW IF EXISTS `v_medcheck_visit`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_medcheck_visit` (
	`id` INT(11) NOT NULL,
	`id_pasien` INT(11) NULL,
	`id_poli` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`poli` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`kode` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`tgl_lahir` DATE NULL,
	`jml_gtotal` DECIMAL(10,2) NULL,
	`tipe` INT(11) NULL COMMENT '2=rajal;3=ranap;',
	`status_bayar` INT(11) NULL COMMENT '0=belum;\r\n1=lunas;\r\n2=kurang;'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_pasien_poin
DROP VIEW IF EXISTS `v_pasien_poin`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_pasien_poin` (
	`id` INT(11) NOT NULL,
	`pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`jml_poin` DECIMAL(10,2) NULL,
	`jml_poin_nom` DECIMAL(10,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_produk
DROP VIEW IF EXISTS `v_produk`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_produk` (
	`id` INT(11) NOT NULL,
	`id_satuan` INT(11) NULL,
	`id_kategori` INT(11) NULL,
	`id_kategori_lab` INT(11) NULL,
	`id_kategori_gol` INT(11) NULL,
	`id_lokasi` INT(11) NULL,
	`id_merk` INT(11) NULL,
	`id_user` INT(11) NULL,
	`id_user_arsip` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_modif` DATETIME NULL,
	`tgl_simpan_arsip` DATETIME NULL,
	`kode` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`barcode` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`produk` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`produk_alias` TEXT NULL COLLATE 'utf8_general_ci',
	`produk_kand` TEXT NULL COLLATE 'utf8_general_ci',
	`produk_kand2` TEXT NULL COLLATE 'utf8_general_ci',
	`jml` DOUBLE NULL,
	`jml_display` FLOAT NULL,
	`jml_limit` FLOAT NULL,
	`harga_beli` INT(11) NULL,
	`subtotal` DECIMAL(10,2) NULL,
	`harga_beli_ppn` DECIMAL(10,2) NULL,
	`harga_jual` INT(11) NULL,
	`harga_jual_het` INT(11) NULL,
	`harga_hasil` DECIMAL(10,2) NULL,
	`harga_grosir` DECIMAL(10,2) NULL,
	`remun_tipe` ENUM('0','1','2') NULL COLLATE 'utf8_general_ci',
	`remun_perc` DECIMAL(10,2) NULL,
	`remun_nom` DECIMAL(10,2) NULL,
	`apres_tipe` ENUM('0','1','2') NULL COLLATE 'utf8_general_ci',
	`apres_perc` DECIMAL(10,2) NULL,
	`apres_nom` DECIMAL(10,2) UNSIGNED NULL,
	`status_promo` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_subt` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_lab` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_brg_dep` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_stok` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_racikan` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status_etiket` ENUM('0','1','2') NULL COMMENT '0=netral;\r\n1=etiket putih;\r\n2=etiket biru;' COLLATE 'utf8_general_ci',
	`status_hps` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`sl` ENUM('0','1','2') NULL COLLATE 'utf8_general_ci',
	`sp` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`so` ENUM('0','1') NULL COLLATE 'utf8_general_ci',
	`status` INT(11) NULL COMMENT '2=tindakan\r\n3=lab\r\n4=obat\r\n5=radiologi\r\n6=racikan'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_produk_hist
DROP VIEW IF EXISTS `v_produk_hist`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_produk_hist` (
	`id` INT(11) NOT NULL,
	`id_produk` INT(11) NULL,
	`id_gudang` INT(11) NULL,
	`id_user` INT(11) NULL,
	`id_pelanggan` INT(11) NULL,
	`id_supplier` INT(11) NULL,
	`id_penjualan` INT(11) NULL,
	`id_pembelian` INT(11) NULL,
	`id_pembelian_det` INT(11) NULL,
	`id_so` INT(11) NULL,
	`tgl_simpan` DATETIME NULL,
	`tgl_masuk` DATETIME NULL,
	`no_nota` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`kode` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`produk` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`keterangan` LONGTEXT NULL COLLATE 'utf8_general_ci',
	`nominal` DECIMAL(10,2) NULL,
	`jml` INT(11) NULL,
	`jml_satuan` INT(11) NULL,
	`satuan` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`status` ENUM('1','2','3','4','5','6','7','8') NULL COMMENT '1 = Stok Masuk Pembelian\\r\\n2 = Stok Masuk\\r\\n3 = Stok Masuk Retur Jual\\r\\n4 = Stok Keluar Penjualan\\r\\n5 = Stok Keluar Retur Beli\\r\\n6 = SO\\r\\n7 = Stok Keluar\\r\\n8 = Mutasi Antar Gd' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_produk_stok
DROP VIEW IF EXISTS `v_produk_stok`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_produk_stok` (
	`id` INT(11) NULL,
	`kode` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`barcode` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`item` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`produk_alias` TEXT NULL COLLATE 'utf8_general_ci',
	`produk_kand` TEXT NULL COLLATE 'utf8_general_ci',
	`jml` FLOAT NULL,
	`stok` DOUBLE NULL,
	`status` INT(11) NULL COMMENT '2=tindakan\r\n3=lab\r\n4=obat\r\n5=radiologi\r\n6=racikan'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_produk_stok_keluar
DROP VIEW IF EXISTS `v_produk_stok_keluar`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_produk_stok_keluar` (
	`id` INT(11) NOT NULL,
	`tgl_simpan` DATETIME NULL,
	`item` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`stok_keluar` DECIMAL(32,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_produk_stok_masuk
DROP VIEW IF EXISTS `v_produk_stok_masuk`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_produk_stok_masuk` (
	`id` INT(11) NOT NULL,
	`tgl_simpan` DATETIME NULL,
	`item` VARCHAR(1) NULL COLLATE 'utf8_general_ci',
	`stok_masuk` DECIMAL(32,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_satusehat
DROP VIEW IF EXISTS `v_satusehat`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_satusehat` (
	`id` INT(11) NOT NULL,
	`id_location` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`id_encounter` TEXT NULL COLLATE 'utf8_general_ci',
	`id_condition` TEXT NULL COLLATE 'utf8_general_ci',
	`waktu_kedatangan` DATETIME NULL,
	`waktu_periksa` DATETIME NULL,
	`waktu_selesai_periksa` DATETIME NULL,
	`no_rm` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`no_register` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nik_pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nama_pasien` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`nik_dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`nama_dokter` VARCHAR(1) NULL COLLATE 'latin1_general_ci',
	`kode_poliklinik` INT(11) NULL,
	`nama_poliklinik` VARCHAR(1) NULL COLLATE 'latin1_swedish_ci',
	`kode_diagnosa` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`nama_diagnosa` TEXT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_medkit_ci3.v_trans_kamar
DROP VIEW IF EXISTS `v_trans_kamar`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_trans_kamar` (
	`id` INT(11) NOT NULL,
	`kode` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`kamar` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`tipe` VARCHAR(1) NULL COLLATE 'utf8mb4_general_ci',
	`jml_max` INT(11) NULL,
	`jml` BIGINT(21) NULL,
	`sisa` BIGINT(22) NULL
) ENGINE=MyISAM;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_alert_medcheck`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_alert_medcheck` AS select `t1`.`id` AS `id_pertama`,`t2`.`id` AS `id_kedua`,`t1`.`id_pasien` AS `id_pasien`,`t1`.`no_rm` AS `no_rm`,`t1`.`pasien` AS `pasien`,`t1`.`id_dokter` AS `id_dokter`,`t1`.`dokter` AS `dokter`,`t1`.`tgl_periksa` AS `tgl_periksa`,`t2`.`tgl_periksa` AS `tgl_periksa_duplikat`,timestampdiff(MINUTE,`t1`.`tgl_periksa`,`t2`.`tgl_periksa`) AS `selisih_menit`,`t1`.`id_user` AS `id_user_pertama`,`t2`.`id_user` AS `id_user_kedua` from (`tbl_trans_medcheck` `t1` join `tbl_trans_medcheck` `t2` on(`t1`.`id_pasien` = `t2`.`id_pasien` and `t1`.`id_dokter` = `t2`.`id_dokter` and `t1`.`tgl_periksa` = `t2`.`tgl_periksa` and `t1`.`id` <> `t2`.`id` and abs(timestampdiff(MINUTE,`t1`.`tgl_periksa`,`t2`.`tgl_periksa`)) <= 10)) order by `t1`.`tgl_periksa` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_alert_medcheck_det`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_alert_medcheck_det` AS select `t1`.`id` AS `id_pertama`,`t2`.`id` AS `id_kedua`,`t1`.`id_pasien` AS `id_pasien`,`t1`.`no_rm` AS `no_rm`,`t1`.`pasien` AS `pasien`,`t1`.`id_dokter` AS `id_dokter`,`t1`.`dokter` AS `dokter`,`t1`.`tgl_periksa` AS `tgl_periksa`,`t2`.`tgl_periksa` AS `tgl_periksa_duplikat`,timestampdiff(MINUTE,`t1`.`tgl_periksa`,`t2`.`tgl_periksa`) AS `selisih_menit`,`t1`.`id_user` AS `id_user_pertama`,`t2`.`id_user` AS `id_user_kedua` from (`tbl_trans_medcheck` `t1` join `tbl_trans_medcheck` `t2` on(`t1`.`id_pasien` = `t2`.`id_pasien` and `t1`.`id_dokter` = `t2`.`id_dokter` and `t1`.`tgl_periksa` = `t2`.`tgl_periksa` and `t1`.`id` <> `t2`.`id` and abs(timestampdiff(MINUTE,`t1`.`tgl_periksa`,`t2`.`tgl_periksa`)) <= 10)) order by `t1`.`tgl_periksa` desc limit 150 ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_karyawan_absen`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_karyawan_absen` AS select `tbl_m_karyawan`.`id` AS `id`,`tbl_m_karyawan`.`id_user` AS `id_user`,`tbl_m_karyawan`.`nama_dpn` AS `nama_dpn`,`tbl_m_karyawan`.`nama` AS `nama`,`tbl_m_karyawan`.`nama_blk` AS `nama_blk`,`tbl_m_karyawan_absen`.`tgl_masuk` AS `tgl_masuk`,`tbl_m_karyawan_absen`.`wkt_masuk` AS `wkt_masuk`,`tbl_m_karyawan_absen`.`wkt_keluar` AS `wkt_keluar`,`tbl_m_karyawan_absen`.`scan1` AS `scan1`,`tbl_m_karyawan_absen`.`scan2` AS `scan2`,`tbl_m_karyawan_absen`.`scan3` AS `scan3`,`tbl_m_karyawan_absen`.`scan4` AS `scan4` from (`tbl_m_karyawan_absen` join `tbl_m_karyawan` on(`tbl_m_karyawan_absen`.`id_karyawan` = `tbl_m_karyawan`.`id`)) order by `tbl_m_karyawan_absen`.`tgl_masuk` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_laporan_stok`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_laporan_stok` AS select `tbl_trans_medcheck_det`.`id` AS `id`,`tbl_trans_medcheck_det`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_produk`.`produk` AS `item`,`tbl_m_produk`.`jml` AS `stok`,sum(`tbl_trans_medcheck_det`.`jml`) AS `laku`,`tbl_m_produk`.`jml` - sum(`tbl_trans_medcheck_det`.`jml`) AS `sisa_stok` from (`tbl_trans_medcheck_det` join `tbl_m_produk` on(`tbl_trans_medcheck_det`.`id_item` = `tbl_m_produk`.`id`)) where `tbl_trans_medcheck_det`.`status` = '4' and `tbl_trans_medcheck_det`.`jml` >= 0 group by `tbl_m_produk`.`produk` order by `tbl_trans_medcheck_det`.`id` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_master_absen`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_master_absen` AS select `tbl_m_karyawan_absen`.`id` AS `id`,`tbl_m_karyawan_absen`.`id_user` AS `id_user`,`tbl_m_karyawan`.`nama_dpn` AS `nama_dpn`,`tbl_m_karyawan`.`nama` AS `nama`,`tbl_m_karyawan`.`nama_blk` AS `nama_blk`,`tbl_m_karyawan_absen`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_karyawan_absen`.`tgl_masuk` AS `tgl_masuk`,`tbl_m_karyawan_absen`.`wkt_masuk` AS `wkt_masuk`,`tbl_m_karyawan_absen`.`wkt_keluar` AS `wkt_keluar`,`tbl_m_karyawan_absen`.`scan1` AS `scan1`,`tbl_m_karyawan_absen`.`scan2` AS `scan2`,`tbl_m_karyawan_absen`.`scan3` AS `scan3`,`tbl_m_karyawan_absen`.`scan4` AS `scan4` from (`tbl_m_karyawan_absen` join `tbl_m_karyawan` on(`tbl_m_karyawan_absen`.`id_karyawan` = `tbl_m_karyawan`.`id`)) order by `tbl_m_karyawan`.`id` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_master_dokter`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_master_dokter` AS SELECT 
    k.id AS id,
    k.id_user AS id_user,
    j.id_poli AS id_poli,
    p.lokasi AS poli,
    k.nama_dpn AS nama_dpn,
    k.nama AS nama,
    k.nama_blk AS nama_blk,
    j.hari_1 AS hari_1,
    j.hari_2 AS hari_2,
    j.hari_3 AS hari_3,
    j.hari_4 AS hari_4,
    j.hari_5 AS hari_5,
    j.hari_6 AS hari_6,
    j.hari_7 AS hari_7,
    j.status_prtk AS status_prtk
FROM 
    tbl_m_karyawan_jadwal j
JOIN 
    tbl_m_karyawan k ON j.id_karyawan = k.id
JOIN 
    tbl_m_poli p ON j.id_poli = p.id
ORDER BY 
    p.id ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck` AS select distinct `tm`.`id` AS `id`,`tm`.`id_user` AS `id_user`,`tm`.`id_dokter` AS `id_dokter`,`tm`.`id_nurse` AS `id_nurse`,`tm`.`id_analis` AS `id_analis`,`tm`.`id_pasien` AS `id_pasien`,`tm`.`id_referall` AS `id_referall`,`tm`.`id_poli` AS `id_poli`,`tm`.`id_dft` AS `id_dft`,`tm`.`id_ant` AS `id_ant`,`tm`.`id_kasir` AS `id_kasir`,`tm`.`id_instansi` AS `id_instansi`,`tm`.`id_encounter` AS `id_encounter`,`tm`.`id_condition` AS `id_condition`,`poli`.`post_location` AS `id_location`,`tm`.`id_icd` AS `id_icd`,`tm`.`id_icd10` AS `id_icd10`,`tm`.`tgl_simpan` AS `tgl_simpan`,`tm`.`tgl_modif` AS `tgl_modif`,`tm`.`tgl_masuk` AS `tgl_masuk`,`tm`.`tgl_periksa` AS `tgl_periksa`,`tm`.`tgl_periksa_lab` AS `tgl_periksa_lab`,`tm`.`tgl_periksa_rad` AS `tgl_periksa_rad`,`tm`.`tgl_periksa_pen` AS `tgl_periksa_pen`,`tm`.`tgl_ranap` AS `tgl_ranap`,`tm`.`tgl_keluar` AS `tgl_keluar`,`tm`.`tgl_bayar` AS `tgl_bayar`,`tm`.`tgl_ttd` AS `tgl_ttd`,`tm`.`no_rm` AS `no_rm`,`tm`.`no_akun` AS `no_akun`,`tm`.`no_nota` AS `no_nota`,`poli`.`lokasi` AS `poli`,`mk`.`nik` AS `nik_dokter`,concat(`mk`.`nama_dpn`,' ',`mk`.`nama`,' ',`mk`.`nama_blk`) AS `nama_dokter`,concat(`pasien`.`kode_dpn`,'',`pasien`.`kode`) AS `kode`,`pasien`.`nik` AS `nik_pasien`,`tm`.`pasien` AS `pasien`,`pasien`.`tgl_lahir` AS `tgl_lahir`,`tm`.`keluhan` AS `keluhan`,`tm`.`ttv` AS `ttv`,`tm`.`ttv_st` AS `ttv_st`,`tm`.`ttv_bb` AS `ttv_bb`,`tm`.`ttv_tb` AS `ttv_tb`,`tm`.`ttv_td` AS `ttv_td`,`tm`.`ttv_sistole` AS `ttv_sistole`,`tm`.`ttv_diastole` AS `ttv_diastole`,`tm`.`ttv_nadi` AS `ttv_nadi`,`tm`.`ttv_laju` AS `ttv_laju`,`tm`.`ttv_saturasi` AS `ttv_saturasi`,`tm`.`ttv_skala` AS `ttv_skala`,`tm`.`diagnosa` AS `diagnosa`,`tm`.`anamnesa` AS `anamnesa`,`tm`.`pemeriksaan` AS `pemeriksaan`,`tm`.`program` AS `program`,`tm`.`alergi` AS `alergi`,`tm`.`metode` AS `metode`,`tm`.`platform` AS `platform`,`tm`.`jml_total` AS `jml_total`,`tm`.`jml_dp` AS `jml_dp`,`tm`.`jml_diskon` AS `jml_diskon`,`tm`.`jml_potongan` AS `jml_potongan`,`tm`.`jml_potongan_poin` AS `jml_potongan_poin`,`tm`.`jml_subtotal` AS `jml_subtotal`,`tm`.`jml_ppn` AS `jml_ppn`,`tm`.`ppn` AS `ppn`,`tm`.`jml_gtotal` AS `jml_gtotal`,`tm`.`jml_bayar` AS `jml_bayar`,`tm`.`jml_kembali` AS `jml_kembali`,`tm`.`jml_kurang` AS `jml_kurang`,`tm`.`jml_poin` AS `jml_poin`,`tm`.`jml_poin_nom` AS `jml_poin_nom`,`tm`.`tipe` AS `tipe`,`tm`.`tipe_bayar` AS `tipe_bayar`,`tm`.`status` AS `status`,`tm`.`status_bayar` AS `status_bayar`,`tm`.`status_nota` AS `status_nota`,`tm`.`status_hps` AS `status_hps`,`tm`.`status_pos` AS `status_pos`,`tm`.`status_periksa` AS `status_periksa` from (((`tbl_trans_medcheck` `tm` join `tbl_m_poli` `poli` on(`tm`.`id_poli` = `poli`.`id`)) join `tbl_m_pasien` `pasien` on(`tm`.`id_pasien` = `pasien`.`id`)) left join `tbl_m_karyawan` `mk` on(`tm`.`id_dokter` = `mk`.`id_user`)) where `tm`.`status_hps` = '0' order by `tm`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_apotik`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_apotik` AS select `tbl_trans_medcheck`.`id` AS `id`,`tbl_trans_medcheck`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_trans_medcheck_det`.`item` AS `item`,`tbl_trans_medcheck_det`.`harga` AS `harga`,`tbl_trans_medcheck_det`.`jml` AS `jml`,`tbl_trans_medcheck_det`.`subtotal` AS `subtotal` from ((`tbl_trans_medcheck_det` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_det`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) where `tbl_trans_medcheck`.`tipe` = '6' and `tbl_trans_medcheck`.`status_bayar` = '1' order by `tbl_trans_medcheck`.`id` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_apres`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_apres` AS select `tbl_trans_medcheck_apres`.`id` AS `id`,`tbl_trans_medcheck_apres`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_apres`.`tgl_simpan` AS `tgl_simpan`,concat(`tbl_m_karyawan`.`nama_dpn`,' ',`tbl_m_karyawan`.`nama`) AS `dokter`,`tbl_m_karyawan`.`nama_blk` AS `dokter_blk`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_m_pasien`.`nama_pgl` AS `nama_pgl`,`tbl_trans_medcheck_det`.`item` AS `item`,`tbl_trans_medcheck_det`.`jml` AS `jml`,`tbl_trans_medcheck_apres`.`harga` AS `harga`,`tbl_trans_medcheck_apres`.`apres_nom` AS `apres_nom`,`tbl_trans_medcheck_apres`.`apres_subtotal` AS `apres_subtotal`,`tbl_trans_medcheck_apres`.`apres_perc` AS `apres_perc`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_m_produk`.`status` AS `status_produk` from ((((((`tbl_trans_medcheck_apres` join `tbl_trans_medcheck` on(`tbl_trans_medcheck`.`id` = `tbl_trans_medcheck_apres`.`id_medcheck`)) join `tbl_trans_medcheck_det` on(`tbl_trans_medcheck_det`.`id` = `tbl_trans_medcheck_apres`.`id_medcheck_det`)) join `tbl_m_pasien` on(`tbl_m_pasien`.`id` = `tbl_trans_medcheck`.`id_pasien`)) join `tbl_m_poli` on(`tbl_m_poli`.`id` = `tbl_trans_medcheck`.`id_poli`)) join `tbl_m_produk` on(`tbl_m_produk`.`id` = `tbl_trans_medcheck_apres`.`id_item`)) join `tbl_m_karyawan` on(`tbl_m_karyawan`.`id_user` = `tbl_trans_medcheck_apres`.`id_dokter`)) order by `tbl_trans_medcheck_apres`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_bukti`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_bukti` AS select `tbl_trans_medcheck`.`id` AS `id`,`tbl_trans_medcheck`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck_file`.`id_user` AS `id_user`,`tbl_trans_medcheck_file`.`tgl_simpan` AS `tgl_simpan`,`tbl_ion_users`.`first_name` AS `username`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_trans_medcheck_file`.`judul` AS `judul`,`tbl_trans_medcheck_file`.`file_name` AS `file_name`,`tbl_trans_medcheck_file`.`status` AS `status` from ((`tbl_trans_medcheck_file` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_file`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_ion_users` on(`tbl_trans_medcheck_file`.`id_user` = `tbl_ion_users`.`id`)) where `tbl_trans_medcheck`.`status_hps` = '0' and `tbl_trans_medcheck_file`.`status` = '3' order by `tbl_trans_medcheck_file`.`tgl_simpan` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_dokter`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_dokter` AS select `tm`.`id` AS `id`,`tm`.`id_dft` AS `id_dft`,`tm`.`id_user` AS `id_user`,if(`tmd`.`id_dokter` <> '',`tmd`.`id_dokter`,`tm`.`id_dokter`) AS `id_dokter`,`tm`.`id_nurse` AS `id_nurse`,`tm`.`id_analis` AS `id_analis`,`tm`.`id_pasien` AS `id_pasien`,`tm`.`id_poli` AS `id_poli`,`tm`.`pasien` AS `pasien`,`tm`.`no_nota` AS `no_nota`,`tm`.`no_rm` AS `no_rm`,`tm`.`tgl_simpan` AS `tgl_simpan`,cast(`tm`.`tgl_masuk` as time) AS `waktu_masuk`,`tm`.`tgl_bayar` AS `tgl_bayar`,`tm`.`tgl_keluar` AS `tgl_keluar`,cast(`tm`.`tgl_keluar` as time) AS `waktu_keluar`,`tm`.`jml_total` AS `jml_total`,`tm`.`jml_gtotal` AS `jml_gtotal`,`tm`.`ppn` AS `ppn`,`tm`.`jml_ppn` AS `jml_ppn`,`tm`.`tipe` AS `tipe`,`tm`.`status` AS `status`,`tm`.`status_hps` AS `status_hps`,`tm`.`status_nota` AS `status_nota`,`tm`.`status_bayar` AS `status_bayar`,`tm`.`status_periksa` AS `status_periksa` from (`tbl_trans_medcheck` `tm` join `tbl_trans_medcheck_dokter` `tmd` on(`tmd`.`id_medcheck` = `tm`.`id`)) where `tm`.`status_pos` = '0' and `tm`.`status_hps` = '0' order by `tm`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_hapus`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_hapus` AS select `tbl_trans_medcheck`.`id` AS `id`,`tbl_trans_medcheck`.`id_user` AS `id_user`,`tbl_trans_medcheck`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck`.`id_nurse` AS `id_nurse`,`tbl_trans_medcheck`.`id_analis` AS `id_analis`,`tbl_trans_medcheck`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck`.`id_poli` AS `id_poli`,`tbl_trans_medcheck`.`id_dft` AS `id_dft`,`tbl_trans_medcheck`.`id_ant` AS `id_ant`,`tbl_trans_medcheck`.`id_kasir` AS `id_kasir`,`tbl_trans_medcheck`.`id_icd` AS `id_icd`,`tbl_trans_medcheck`.`id_icd10` AS `id_icd10`,`tbl_trans_medcheck`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck`.`tgl_modif` AS `tgl_modif`,`tbl_trans_medcheck`.`tgl_masuk` AS `tgl_masuk`,`tbl_trans_medcheck`.`tgl_periksa` AS `tgl_periksa`,`tbl_trans_medcheck`.`tgl_periksa_lab` AS `tgl_periksa_lab`,`tbl_trans_medcheck`.`tgl_periksa_rad` AS `tgl_periksa_rad`,`tbl_trans_medcheck`.`tgl_periksa_pen` AS `tgl_periksa_pen`,`tbl_trans_medcheck`.`tgl_ranap` AS `tgl_ranap`,`tbl_trans_medcheck`.`tgl_keluar` AS `tgl_keluar`,`tbl_trans_medcheck`.`tgl_bayar` AS `tgl_bayar`,`tbl_trans_medcheck`.`tgl_ttd` AS `tgl_ttd`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_trans_medcheck`.`no_akun` AS `no_akun`,`tbl_trans_medcheck`.`no_nota` AS `no_nota`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_m_pasien`.`nama_pgl` AS `pasien`,`tbl_trans_medcheck`.`keluhan` AS `keluhan`,`tbl_trans_medcheck`.`ttv` AS `ttv`,`tbl_trans_medcheck`.`ttv_st` AS `ttv_st`,`tbl_trans_medcheck`.`ttv_bb` AS `ttv_bb`,`tbl_trans_medcheck`.`ttv_tb` AS `ttv_tb`,`tbl_trans_medcheck`.`ttv_td` AS `ttv_td`,`tbl_trans_medcheck`.`ttv_sistole` AS `ttv_sistole`,`tbl_trans_medcheck`.`ttv_diastole` AS `ttv_diastole`,`tbl_trans_medcheck`.`ttv_nadi` AS `ttv_nadi`,`tbl_trans_medcheck`.`ttv_laju` AS `ttv_laju`,`tbl_trans_medcheck`.`ttv_saturasi` AS `ttv_saturasi`,`tbl_trans_medcheck`.`ttv_skala` AS `ttv_skala`,`tbl_trans_medcheck`.`diagnosa` AS `diagnosa`,`tbl_trans_medcheck`.`anamnesa` AS `anamnesa`,`tbl_trans_medcheck`.`pemeriksaan` AS `pemeriksaan`,`tbl_trans_medcheck`.`program` AS `program`,`tbl_trans_medcheck`.`alergi` AS `alergi`,`tbl_trans_medcheck`.`metode` AS `metode`,`tbl_trans_medcheck`.`platform` AS `platform`,`tbl_trans_medcheck`.`jml_total` AS `jml_total`,`tbl_trans_medcheck`.`jml_dp` AS `jml_dp`,`tbl_trans_medcheck`.`jml_diskon` AS `jml_diskon`,`tbl_trans_medcheck`.`jml_potongan` AS `jml_potongan`,`tbl_trans_medcheck`.`jml_subtotal` AS `jml_subtotal`,`tbl_trans_medcheck`.`jml_ppn` AS `jml_ppn`,`tbl_trans_medcheck`.`ppn` AS `ppn`,`tbl_trans_medcheck`.`jml_gtotal` AS `jml_gtotal`,`tbl_trans_medcheck`.`jml_bayar` AS `jml_bayar`,`tbl_trans_medcheck`.`jml_kembali` AS `jml_kembali`,`tbl_trans_medcheck`.`jml_kurang` AS `jml_kurang`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_trans_medcheck`.`tipe_bayar` AS `tipe_bayar`,`tbl_trans_medcheck`.`status` AS `status`,`tbl_trans_medcheck`.`status_bayar` AS `status_bayar`,`tbl_trans_medcheck`.`status_nota` AS `status_nota`,`tbl_trans_medcheck`.`status_hps` AS `status_hps`,`tbl_trans_medcheck`.`status_pos` AS `status_pos`,`tbl_trans_medcheck`.`status_periksa` AS `status_periksa` from ((`tbl_trans_medcheck` join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_m_poli` on(`tbl_trans_medcheck`.`id_poli` = `tbl_m_poli`.`id`)) where `tbl_trans_medcheck`.`status_hps` = '1' order by `tbl_trans_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_lab`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_lab` AS select `tbl_trans_medcheck_lab`.`id` AS `id`,`tbl_trans_medcheck_lab`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_lab`.`tgl_simpan` AS `OrderDateTime`,`tbl_trans_medcheck_lab`.`tgl_modif` AS `tgl_modif`,`tbl_trans_medcheck`.`no_rm` AS `TrxID`,`tbl_m_pasien`.`id` AS `PasienId`,concat(`tbl_m_pasien`.`kode_dpn`,'',`tbl_m_pasien`.`kode`) AS `no_rm`,`tbl_m_pasien`.`nik` AS `Nik`,`tbl_m_pasien`.`nama_pgl` AS `PasienName`,`tbl_m_pasien`.`alamat` AS `Address`,`tbl_m_pasien`.`jns_klm` AS `Gender`,`tbl_m_pasien`.`tgl_lahir` AS `BirthDate`,`tbl_m_pasien`.`tmp_lahir` AS `BirthPlace`,concat(coalesce(`tbl_m_karyawan`.`nama_dpn`,''),case when `tbl_m_karyawan`.`nama_dpn` is not null and `tbl_m_karyawan`.`nama_dpn` <> '' then ' ' else '' end,coalesce(`tbl_m_karyawan`.`nama`,''),case when `tbl_m_karyawan`.`nama` is not null and `tbl_m_karyawan`.`nama` <> '' and `tbl_m_karyawan`.`nama_blk` is not null and `tbl_m_karyawan`.`nama_blk` <> '' then ', ' else '' end,coalesce(`tbl_m_karyawan`.`nama_blk`,'')) AS `DokterPerujukName`,`tbl_trans_medcheck_lab`.`no_lab` AS `no_lab`,`tbl_trans_medcheck_lab`.`status` AS `status`,`tbl_trans_medcheck_lab`.`status_lis` AS `status_lis`,`tbl_trans_medcheck_lab`.`status_cvd` AS `status_cvd`,`tbl_trans_medcheck_lab`.`status_duplo` AS `status_duplo` from (((`tbl_trans_medcheck_lab` join `tbl_m_pasien` on(`tbl_m_pasien`.`id` = `tbl_trans_medcheck_lab`.`id_pasien`)) join `tbl_m_karyawan` on(`tbl_m_karyawan`.`id` = `tbl_trans_medcheck_lab`.`id_dokter`)) join `tbl_trans_medcheck` on(`tbl_trans_medcheck_lab`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) where year(`tbl_trans_medcheck_lab`.`tgl_simpan`) > '2024' order by `tbl_trans_medcheck_lab`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_lab_item`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_lab_item` AS select `tbl_trans_medcheck_lab_hsl`.`id_lab` AS `id_lab`,`tbl_trans_medcheck_lab_hsl`.`id_item_ref_ip` AS `TindakanId`,`tbl_trans_medcheck_lab_hsl`.`item_name` AS `TindakanName` from (`tbl_trans_medcheck_lab_hsl` join `tbl_trans_medcheck_lab` on(`tbl_trans_medcheck_lab`.`id` = `tbl_trans_medcheck_lab_hsl`.`id_lab`)) order by `tbl_trans_medcheck_lab_hsl`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_mcu`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_mcu` AS select `tbl_trans_medcheck_resume`.`id` AS `id`,`tbl_trans_medcheck_resume`.`id_medcheck` AS `id_medcheck`,`tbl_pendaftaran`.`id_instansi` AS `id_instansi`,`tbl_m_pasien`.`id` AS `id_pasien`,`tbl_trans_medcheck_resume`.`id_user` AS `id_user`,`tbl_trans_medcheck_resume`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_pasien`.`nama_pgl` AS `nama_pgl`,`tbl_trans_medcheck_resume`.`no_surat` AS `no_surat`,`tbl_trans_medcheck_resume`.`saran` AS `saran`,`tbl_trans_medcheck_resume`.`kesimpulan` AS `kesimpulan` from (((`tbl_trans_medcheck_resume` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_resume`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_pendaftaran` on(`tbl_trans_medcheck`.`id_dft` = `tbl_pendaftaran`.`id`)) where `tbl_trans_medcheck`.`tipe` = '5' order by `tbl_trans_medcheck_resume`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_omset`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_omset` AS select `tbl_trans_medcheck_det`.`id` AS `id`,`tbl_trans_medcheck`.`id` AS `id_medcheck`,`tbl_trans_medcheck`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck`.`id_poli` AS `id_poli`,`tbl_trans_medcheck`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_det`.`id_item` AS `id_item`,`tbl_trans_medcheck_det`.`id_item_kat` AS `id_item_kat`,`tbl_trans_medcheck_det`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck`.`tgl_masuk` AS `tgl_masuk`,`tbl_trans_medcheck`.`tgl_bayar` AS `tgl_bayar`,`tbl_trans_medcheck`.`no_akun` AS `no_akun`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_m_pasien`.`nama_pgl` AS `pasien`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_trans_medcheck_det`.`kode` AS `kode`,`tbl_trans_medcheck_det`.`item` AS `item`,`tbl_trans_medcheck_det`.`jml` AS `jml`,`tbl_trans_medcheck_det`.`harga` AS `harga`,`tbl_trans_medcheck_det`.`diskon` AS `diskon`,`tbl_trans_medcheck_det`.`potongan` AS `potongan`,`tbl_trans_medcheck_det`.`potongan_poin` AS `potongan_poin`,`tbl_trans_medcheck_det`.`subtotal` AS `subtotal`,`tbl_trans_medcheck`.`jml_gtotal` AS `jml_gtotal`,`tbl_trans_medcheck_det`.`status_pkt` AS `status_pkt`,`tbl_trans_medcheck_det`.`status` AS `status`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_trans_medcheck`.`tipe_bayar` AS `tipe_bayar`,`tbl_trans_medcheck`.`metode` AS `metode` from ((`tbl_trans_medcheck_det` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_det`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) where `tbl_trans_medcheck`.`status_hps` = '0' and `tbl_trans_medcheck`.`status_bayar` = '1' order by `tbl_trans_medcheck_det`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_pen_ekg`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_pen_ekg` AS select `tbl_trans_medcheck_lab_ekg`.`id` AS `id`,`tbl_trans_medcheck_lab_ekg`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_lab_ekg`.`id_user` AS `id_user`,`tbl_trans_medcheck_lab_ekg`.`id_analis` AS `id_analis`,`tbl_trans_medcheck_lab_ekg`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_lab_ekg`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck_lab_ekg`.`tgl_modif` AS `tgl_modif`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_m_pasien`.`jns_klm` AS `jns_klm`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_trans_medcheck_lab_ekg`.`status` AS `status` from (((`tbl_trans_medcheck_lab_ekg` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_lab_ekg`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_m_poli` on(`tbl_trans_medcheck`.`id_poli` = `tbl_m_poli`.`id`)) order by `tbl_trans_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_pen_hrv`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_pen_hrv` AS select `tbl_trans_medcheck_pen_hrv`.`id` AS `id`,`tbl_trans_medcheck_pen_hrv`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_pen_hrv`.`id_user` AS `id_user`,`tbl_trans_medcheck_pen_hrv`.`id_analis` AS `id_analis`,`tbl_trans_medcheck_pen_hrv`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_pen_hrv`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck_pen_hrv`.`tgl_modif` AS `tgl_modif`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_m_pasien`.`jns_klm` AS `jns_klm`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_trans_medcheck_pen_hrv`.`status` AS `status` from (((`tbl_trans_medcheck_pen_hrv` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_pen_hrv`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_m_poli` on(`tbl_trans_medcheck`.`id_poli` = `tbl_m_poli`.`id`)) order by `tbl_trans_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_pen_spiro`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_pen_spiro` AS select `tbl_trans_medcheck_lab_spiro`.`id` AS `id`,`tbl_trans_medcheck_lab_spiro`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_lab_spiro`.`id_user` AS `id_user`,`tbl_trans_medcheck_lab_spiro`.`id_analis` AS `id_analis`,`tbl_trans_medcheck_lab_spiro`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_lab_spiro`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck_lab_spiro`.`tgl_modif` AS `tgl_modif`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_m_pasien`.`jns_klm` AS `jns_klm`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_trans_medcheck_lab_spiro`.`status` AS `status` from (((`tbl_trans_medcheck_lab_spiro` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_lab_spiro`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_m_poli` on(`tbl_trans_medcheck`.`id_poli` = `tbl_m_poli`.`id`)) order by `tbl_trans_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_plat`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_plat` AS select `tbl_trans_medcheck_plat`.`id` AS `id`,`tbl_trans_medcheck_plat`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_plat`.`id_platform` AS `id_platform`,`tbl_trans_medcheck_plat`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck_plat`.`no_nota` AS `no_nota`,`tbl_trans_medcheck_plat`.`platform` AS `platform`,`tbl_trans_medcheck_plat`.`keterangan` AS `keterangan`,`tbl_trans_medcheck_plat`.`nominal` AS `nominal` from `tbl_trans_medcheck_plat` group by `tbl_trans_medcheck_plat`.`id_medcheck`,`tbl_trans_medcheck_plat`.`id_platform`,`tbl_trans_medcheck_plat`.`tgl_simpan`,`tbl_trans_medcheck_plat`.`nominal` order by `tbl_trans_medcheck_plat`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_referall`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_referall` AS select `tm`.`id` AS `id`,`k`.`id_user` AS `id_user`,`tm`.`tgl_simpan` AS `tgl_simpan`,`tm`.`tgl_masuk` AS `tgl_masuk`,concat(`p`.`kode_dpn`,'',`p`.`kode`) AS `no_rm`,`p`.`nama_pgl` AS `nama_pasien`,`k`.`nama` AS `nama_karyawan` from ((`tbl_trans_medcheck` `tm` left join `tbl_m_pasien` `p` on(`tm`.`id_pasien` = `p`.`id`)) left join `tbl_m_karyawan` `k` on(`tm`.`id_referall` = `k`.`id_user`)) where `tm`.`id_referall` is not null and `tm`.`id_referall` <> '' and `tm`.`id_referall` <> '0' ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_remun`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_remun` AS select `tbl_trans_medcheck_remun`.`id` AS `id`,`tbl_trans_medcheck_remun`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_remun`.`tgl_simpan` AS `tgl_simpan`,concat(`tbl_m_karyawan`.`nama_dpn`,' ',`tbl_m_karyawan`.`nama`) AS `dokter`,`tbl_m_karyawan`.`nama_blk` AS `dokter_blk`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`no_rm` AS `no_rm`,`tbl_m_pasien`.`nama_pgl` AS `nama_pgl`,`tbl_trans_medcheck_det`.`item` AS `item`,`tbl_trans_medcheck_det`.`jml` AS `jml`,`tbl_trans_medcheck_remun`.`harga` AS `harga`,`tbl_trans_medcheck_remun`.`remun_nom` AS `remun_nom`,`tbl_trans_medcheck_remun`.`remun_subtotal` AS `remun_subtotal`,`tbl_trans_medcheck_remun`.`remun_perc` AS `remun_perc`,`tbl_trans_medcheck`.`tipe` AS `tipe`,`tbl_m_produk`.`status` AS `status_produk` from ((((((`tbl_trans_medcheck_remun` join `tbl_trans_medcheck` on(`tbl_trans_medcheck`.`id` = `tbl_trans_medcheck_remun`.`id_medcheck`)) join `tbl_trans_medcheck_det` on(`tbl_trans_medcheck_det`.`id` = `tbl_trans_medcheck_remun`.`id_medcheck_det`)) join `tbl_m_pasien` on(`tbl_m_pasien`.`id` = `tbl_trans_medcheck`.`id_pasien`)) join `tbl_m_poli` on(`tbl_m_poli`.`id` = `tbl_trans_medcheck`.`id_poli`)) join `tbl_m_produk` on(`tbl_m_produk`.`id` = `tbl_trans_medcheck_remun`.`id_item`)) join `tbl_m_karyawan` on(`tbl_m_karyawan`.`id_user` = `tbl_trans_medcheck_remun`.`id_dokter`)) order by `tbl_trans_medcheck_remun`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_resep`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_resep` AS select `tm`.`id` AS `id`,`tm`.`id_dft` AS `id_dft`,`tm`.`id_pasien` AS `id_pasien`,`tmr`.`id` AS `id_resep`,`tm`.`id_farmasi` AS `id_farmasi`,`tmr`.`id_user` AS `id_user`,`tm`.`tgl_simpan` AS `tgl_simpan`,`tm`.`no_rm` AS `no_rm`,`mp`.`lokasi` AS `poli`,`mps`.`nik` AS `nik`,`mps`.`nama_pgl` AS `pasien`,`mps`.`tgl_lahir` AS `tgl_lahir`,`mps`.`alamat` AS `alamat`,`mps`.`jns_klm` AS `jns_klm`,`tmr`.`tgl_simpan` AS `tgl_resep_msk`,`tm`.`tgl_ttd` AS `tgl_resep_klr`,`tm`.`ttd_obat` AS `ttd_obat`,`tmr`.`no_resep` AS `no_resep`,`tm`.`tipe` AS `tipe`,`tmr`.`status` AS `status`,`tmr`.`status_plg` AS `status_plg` from (`tbl_trans_medcheck_resep` `tmr` left join (((`tbl_trans_medcheck` `tm` join `tbl_m_pasien` `mps` on(`tm`.`id_pasien` = `mps`.`id`)) join `tbl_m_poli` `mp` on(`tm`.`id_poli` = `mp`.`id`)) join `tbl_pendaftaran` `tp` on(`tm`.`id_dft` = `tp`.`id`)) on(`tm`.`id` = `tmr`.`id_medcheck`)) where `tm`.`status_hps` = '0' order by `tmr`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_rm`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_rm` AS select `tbl_trans_medcheck_rm`.`id` AS `id`,`tbl_trans_medcheck_rm`.`id_medcheck` AS `id_medcheck`,`tbl_trans_medcheck_rm`.`id_user` AS `id_user`,`tbl_trans_medcheck_rm`.`id_dokter` AS `id_dokter`,`tbl_trans_medcheck_rm`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck_rm`.`id_icd10` AS `id_icd10`,`tbl_trans_medcheck_rm`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck`.`tgl_masuk` AS `tgl_masuk`,`tbl_trans_medcheck`.`no_rm` AS `kode`,`tbl_m_pasien`.`nama_pgl` AS `nama`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_trans_medcheck_rm`.`anamnesa` AS `anamnesa`,`tbl_trans_medcheck_rm`.`pemeriksaan` AS `pemeriksaan`,`tbl_trans_medcheck`.`diagnosa` AS `diagnosa`,`tbl_trans_medcheck_rm`.`terapi` AS `terapi`,`tbl_trans_medcheck_rm`.`program` AS `program`,`tbl_trans_medcheck_rm`.`ttv_skala` AS `ttv_skala`,`tbl_trans_medcheck_rm`.`ttv_saturasi` AS `ttv_saturasi`,`tbl_trans_medcheck_rm`.`ttv_laju` AS `ttv_laju`,`tbl_trans_medcheck_rm`.`ttv_nadi` AS `ttv_nadi`,`tbl_trans_medcheck_rm`.`ttv_diastole` AS `ttv_diastole`,`tbl_trans_medcheck_rm`.`ttv_sistole` AS `ttv_sistole`,`tbl_trans_medcheck_rm`.`ttv_tb` AS `ttv_tb`,`tbl_trans_medcheck_rm`.`ttv_bb` AS `ttv_bb`,`tbl_trans_medcheck_rm`.`ttv_st` AS `ttv_st`,`tbl_trans_medcheck_rm`.`tipe` AS `tipe`,`tbl_trans_medcheck_rm`.`status` AS `status`,`tbl_trans_medcheck`.`status_bayar` AS `status_bayar` from ((`tbl_trans_medcheck_rm` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_rm`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) join `tbl_m_pasien` on(`tbl_trans_medcheck_rm`.`id_pasien` = `tbl_m_pasien`.`id`)) where `tbl_trans_medcheck`.`status_hps` = '0' order by `tbl_trans_medcheck_rm`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_rm_rj`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_rm_rj` AS select `tbl_trans_medcheck`.`id` AS `id`,`tbl_trans_medcheck`.`id_pasien` AS `id_pasien`,`tbl_trans_medcheck`.`tgl_simpan` AS `tgl_simpan`,`tbl_trans_medcheck`.`tgl_masuk` AS `tgl_masuk`,concat(`tbl_m_pasien`.`kode_dpn`,'',`tbl_m_pasien`.`kode`) AS `kode`,`tbl_trans_medcheck`.`pasien` AS `pasien`,`tbl_m_pasien`.`tgl_lahir` AS `tgl_lahir`,`tbl_m_poli`.`lokasi` AS `poli`,`tbl_trans_medcheck`.`diagnosa` AS `diagnosa`,`tbl_trans_medcheck_icd`.`kode` AS `kode_icd`,`tbl_trans_medcheck_icd`.`icd` AS `icd`,`tbl_trans_medcheck_icd`.`diagnosa_en` AS `diagnosa_en` from (((`tbl_trans_medcheck` join `tbl_trans_medcheck_icd` on(`tbl_trans_medcheck`.`id` = `tbl_trans_medcheck_icd`.`id_medcheck`)) join `tbl_m_pasien` on(`tbl_trans_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) join `tbl_m_poli` on(`tbl_trans_medcheck`.`id_poli` = `tbl_m_poli`.`id`)) where `tbl_trans_medcheck`.`tipe` = '2' order by `tbl_trans_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_tracer`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_tracer` AS select distinct `tm`.`id` AS `id`,`tm`.`id_poli` AS `id_poli`,`tm`.`no_rm` AS `no_rm`,`tm`.`pasien` AS `nama_pgl`,`tm`.`tgl_simpan` AS `tgl_simpan`,cast(`tm`.`tgl_simpan` as date) AS `tanggal`,`p`.`tgl_simpan` AS `wkt_daftar`,`tm`.`tgl_periksa` AS `wkt_periksa`,`tml`.`tgl_simpan` AS `wkt_sampling_msk`,`tml`.`tgl_keluar` AS `wkt_sampling_klr`,`tmr`.`tgl_simpan` AS `wkt_rad_msk`,`tm`.`tgl_periksa_rad_keluar` AS `wkt_rad_klr`,`tm`.`tgl_periksa_rad_kirim` AS `wkt_rad_krm`,`tm`.`tgl_periksa_rad_baca` AS `wkt_rad_baca`,`tmrp`.`tgl_simpan` AS `wkt_resep_msk`,`tmrp`.`tgl_keluar` AS `wkt_resep_klr`,`tm`.`tgl_bayar` AS `wkt_resep_byr`,`tm`.`tgl_ttd` AS `wkt_resep_trm`,`tmrp`.`tgl_simpan` AS `wkt_farmasi_msk`,`tmrp`.`tgl_keluar` AS `wkt_farmasi_klr`,`tm`.`tgl_ranap` AS `wkt_ranap`,`tm`.`tgl_ranap_keluar` AS `wkt_ranap_keluar`,`tm`.`tgl_bayar` AS `wkt_selesai`,`tm`.`tipe` AS `tipe`,`tm`.`status` AS `status` from ((((`tbl_trans_medcheck` `tm` join `tbl_pendaftaran` `p` on(`p`.`id` = `tm`.`id_dft`)) left join `tbl_trans_medcheck_lab` `tml` on(`tml`.`id_medcheck` = `tm`.`id`)) left join `tbl_trans_medcheck_rad` `tmr` on(`tmr`.`id_medcheck` = `tm`.`id`)) left join `tbl_trans_medcheck_resep` `tmrp` on(`tmrp`.`id_medcheck` = `tm`.`id`)) where `tm`.`status_hps` = '0' group by `tm`.`no_rm`,`tm`.`tgl_simpan` order by `tm`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_medcheck_visit`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_medcheck_visit` AS select `v_medcheck`.`id` AS `id`,`v_medcheck`.`id_pasien` AS `id_pasien`,`v_medcheck`.`id_poli` AS `id_poli`,`v_medcheck`.`tgl_bayar` AS `tgl_simpan`,`v_medcheck`.`tgl_masuk` AS `tgl_masuk`,`v_medcheck`.`poli` AS `poli`,`v_medcheck`.`no_rm` AS `no_rm`,`v_medcheck`.`kode` AS `kode`,`v_medcheck`.`pasien` AS `nama`,`v_medcheck`.`tgl_lahir` AS `tgl_lahir`,`v_medcheck`.`jml_gtotal` AS `jml_gtotal`,`v_medcheck`.`tipe` AS `tipe`,`v_medcheck`.`status_bayar` AS `status_bayar` from `v_medcheck` order by `v_medcheck`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_pasien_poin`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_pasien_poin` AS select `tbl_m_pasien`.`id` AS `id`,`tbl_m_pasien`.`nama_pgl` AS `pasien`,`tbl_m_pasien_poin`.`jml_poin` AS `jml_poin`,`tbl_m_pasien_poin`.`jml_poin_nom` AS `jml_poin_nom` from (`tbl_m_pasien_poin` join `tbl_m_pasien` on(`tbl_m_pasien_poin`.`id_pasien` = `tbl_m_pasien`.`id`)) order by `tbl_m_pasien_poin`.`jml_poin` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_produk`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_produk` AS select `p`.`id` AS `id`,`p`.`id_satuan` AS `id_satuan`,`p`.`id_kategori` AS `id_kategori`,`p`.`id_kategori_lab` AS `id_kategori_lab`,`p`.`id_kategori_gol` AS `id_kategori_gol`,`p`.`id_lokasi` AS `id_lokasi`,`p`.`id_merk` AS `id_merk`,`p`.`id_user` AS `id_user`,`p`.`id_user_arsip` AS `id_user_arsip`,`p`.`tgl_simpan` AS `tgl_simpan`,`p`.`tgl_modif` AS `tgl_modif`,`p`.`tgl_simpan_arsip` AS `tgl_simpan_arsip`,`p`.`kode` AS `kode`,`p`.`barcode` AS `barcode`,`p`.`produk` AS `produk`,`p`.`produk_alias` AS `produk_alias`,`p`.`produk_kand` AS `produk_kand`,`p`.`produk_kand2` AS `produk_kand2`,coalesce(sum(`s`.`jml`),0) AS `jml`,`p`.`jml_display` AS `jml_display`,`p`.`jml_limit` AS `jml_limit`,`p`.`harga_beli` AS `harga_beli`,`p`.`subtotal` AS `subtotal`,`p`.`harga_beli_ppn` AS `harga_beli_ppn`,`p`.`harga_jual` AS `harga_jual`,`p`.`harga_jual_het` AS `harga_jual_het`,`p`.`harga_hasil` AS `harga_hasil`,`p`.`harga_grosir` AS `harga_grosir`,`p`.`remun_tipe` AS `remun_tipe`,`p`.`remun_perc` AS `remun_perc`,`p`.`remun_nom` AS `remun_nom`,`p`.`apres_tipe` AS `apres_tipe`,`p`.`apres_perc` AS `apres_perc`,`p`.`apres_nom` AS `apres_nom`,`p`.`status_promo` AS `status_promo`,`p`.`status_subt` AS `status_subt`,`p`.`status_lab` AS `status_lab`,`p`.`status_brg_dep` AS `status_brg_dep`,`p`.`status_stok` AS `status_stok`,`p`.`status_racikan` AS `status_racikan`,`p`.`status_etiket` AS `status_etiket`,`p`.`status_hps` AS `status_hps`,`p`.`sl` AS `sl`,`p`.`sp` AS `sp`,`p`.`so` AS `so`,`p`.`status` AS `status` from (`tbl_m_produk` `p` left join `tbl_m_produk_stok` `s` on(`p`.`id` = `s`.`id_produk`)) group by `p`.`id` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_produk_hist`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_produk_hist` AS select `tbl_m_produk_hist`.`id` AS `id`,`tbl_m_produk_hist`.`id_produk` AS `id_produk`,`tbl_m_produk_hist`.`id_gudang` AS `id_gudang`,`tbl_m_produk_hist`.`id_user` AS `id_user`,`tbl_m_produk_hist`.`id_pelanggan` AS `id_pelanggan`,`tbl_m_produk_hist`.`id_supplier` AS `id_supplier`,`tbl_m_produk_hist`.`id_penjualan` AS `id_penjualan`,`tbl_m_produk_hist`.`id_pembelian` AS `id_pembelian`,`tbl_m_produk_hist`.`id_pembelian_det` AS `id_pembelian_det`,`tbl_m_produk_hist`.`id_so` AS `id_so`,`tbl_m_produk_hist`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_produk_hist`.`tgl_masuk` AS `tgl_masuk`,`tbl_m_produk_hist`.`no_nota` AS `no_nota`,`tbl_m_produk`.`kode` AS `kode`,`tbl_m_produk`.`produk` AS `produk`,`tbl_m_produk_hist`.`keterangan` AS `keterangan`,`tbl_m_produk_hist`.`nominal` AS `nominal`,`tbl_m_produk_hist`.`jml` AS `jml`,`tbl_m_produk_hist`.`jml_satuan` AS `jml_satuan`,`tbl_m_produk_hist`.`satuan` AS `satuan`,`tbl_m_produk_hist`.`status` AS `status` from (`tbl_m_produk_hist` join `tbl_m_produk` on(`tbl_m_produk_hist`.`id_produk` = `tbl_m_produk`.`id`)) order by `tbl_m_produk_hist`.`id` desc ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_produk_stok`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_produk_stok` AS select `tbl_m_produk`.`id` AS `id`,`tbl_m_produk`.`kode` AS `kode`,`tbl_m_produk`.`barcode` AS `barcode`,`tbl_m_produk`.`produk` AS `item`,`tbl_m_produk`.`produk_alias` AS `produk_alias`,`tbl_m_produk`.`produk_kand` AS `produk_kand`,`tbl_m_produk`.`jml` AS `jml`,sum(`tbl_m_produk_stok`.`jml`) AS `stok`,`tbl_m_produk`.`status` AS `status` from (`tbl_m_produk_stok` left join `tbl_m_produk` on(`tbl_m_produk`.`id` = `tbl_m_produk_stok`.`id_produk`)) group by `tbl_m_produk`.`produk` order by `tbl_m_produk`.`produk` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_produk_stok_keluar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_produk_stok_keluar` AS select `tbl_m_produk`.`id` AS `id`,`tbl_trans_medcheck_det`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_produk`.`produk` AS `item`,sum(`tbl_trans_medcheck_det`.`jml`) AS `stok_keluar` from (`tbl_trans_medcheck_det` join `tbl_m_produk` on(`tbl_trans_medcheck_det`.`id_item` = `tbl_m_produk`.`id`)) where `tbl_m_produk`.`status` = '4' group by `tbl_trans_medcheck_det`.`tgl_simpan` order by `tbl_m_produk`.`id`,`tbl_trans_medcheck_det`.`tgl_simpan` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_produk_stok_masuk`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_produk_stok_masuk` AS select `tbl_m_produk`.`id` AS `id`,`tbl_trans_beli_det`.`tgl_simpan` AS `tgl_simpan`,`tbl_m_produk`.`produk` AS `item`,sum(`tbl_trans_beli_det`.`jml`) AS `stok_masuk` from (`tbl_trans_beli_det` join `tbl_m_produk` on(`tbl_trans_beli_det`.`id_produk` = `tbl_m_produk`.`id`)) where `tbl_m_produk`.`status` = '4' group by `tbl_trans_beli_det`.`tgl_simpan` order by `tbl_m_produk`.`id`,`tbl_trans_beli_det`.`tgl_simpan` ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_satusehat`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_satusehat` AS select `v_medcheck`.`id` AS `id`,`v_medcheck`.`id_location` AS `id_location`,`v_medcheck`.`id_encounter` AS `id_encounter`,`v_medcheck`.`id_condition` AS `id_condition`,`v_medcheck`.`tgl_simpan` AS `waktu_kedatangan`,`v_medcheck`.`tgl_periksa` AS `waktu_periksa`,`v_medcheck`.`tgl_modif` AS `waktu_selesai_periksa`,`v_medcheck`.`kode` AS `no_rm`,`v_medcheck`.`no_rm` AS `no_register`,`tbl_m_pasien`.`nik` AS `nik_pasien`,`tbl_m_pasien`.`nama_pgl` AS `nama_pasien`,`v_medcheck`.`nik_dokter` AS `nik_dokter`,`v_medcheck`.`nama_dokter` AS `nama_dokter`,`v_medcheck`.`id_poli` AS `kode_poliklinik`,`v_medcheck`.`poli` AS `nama_poliklinik`,`tbl_m_icd`.`kode` AS `kode_diagnosa`,`tbl_m_icd`.`icd` AS `nama_diagnosa` from (((`v_medcheck` join `tbl_trans_medcheck_icd` on(`tbl_trans_medcheck_icd`.`id_medcheck` = `v_medcheck`.`id`)) join `tbl_m_pasien` on(`v_medcheck`.`id_pasien` = `tbl_m_pasien`.`id`)) left join `tbl_m_icd` on(`tbl_trans_medcheck_icd`.`id_icd` = `tbl_m_icd`.`id`)) where `v_medcheck`.`status_bayar` = '1' and `v_medcheck`.`nik_pasien` <> '-' and `v_medcheck`.`nik_pasien` <> '0' and `v_medcheck`.`nik_pasien` <> '' and `v_medcheck`.`nik_dokter` <> '-' and `v_medcheck`.`id_location` is not null and `v_medcheck`.`id_encounter` is null and cast(`v_medcheck`.`tgl_simpan` as date) = curdate() group by `v_medcheck`.`tgl_simpan` order by `v_medcheck`.`id` desc limit 100 ;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_trans_kamar`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_trans_kamar` AS select `tbl_m_kamar`.`id` AS `id`,`tbl_m_kamar`.`kode` AS `kode`,`tbl_m_kamar`.`kamar` AS `kamar`,`tbl_m_kamar`.`tipe` AS `tipe`,`tbl_m_kamar`.`jml_max` AS `jml_max`,(select count(0) from (`tbl_trans_medcheck_kamar` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_kamar`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) where `tbl_trans_medcheck_kamar`.`id_kamar` = `tbl_m_kamar`.`id` and `tbl_trans_medcheck_kamar`.`status` = '1' and `tbl_trans_medcheck`.`status_bayar` = '0') AS `jml`,`tbl_m_kamar`.`jml_max` - (select count(0) from (`tbl_trans_medcheck_kamar` join `tbl_trans_medcheck` on(`tbl_trans_medcheck_kamar`.`id_medcheck` = `tbl_trans_medcheck`.`id`)) where `tbl_trans_medcheck_kamar`.`id_kamar` = `tbl_m_kamar`.`id` and `tbl_trans_medcheck_kamar`.`status` = '1' and `tbl_trans_medcheck`.`status_bayar` = '0') AS `sisa` from `tbl_m_kamar` where `tbl_m_kamar`.`status` = '1' order by `tbl_m_kamar`.`id` ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
