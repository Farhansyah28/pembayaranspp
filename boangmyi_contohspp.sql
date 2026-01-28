-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2026 at 03:31 PM
-- Server version: 10.6.24-MariaDB
-- PHP Version: 8.4.16

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boangmyi_contohspp`
--

-- --------------------------------------------------------

--
-- Table structure for table `angkatan`
--

CREATE TABLE `angkatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL COMMENT 'Contoh: Angkatan 1',
  `tahun_masuk` year(4) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `angkatan`
--

INSERT INTO `angkatan` (`id`, `nama`, `tahun_masuk`, `keterangan`, `created_at`) VALUES
(1, 'Angkatan 1', '2020', 'Angkatan pertama pesantren', '2026-01-17 11:57:39'),
(2, 'Angkatan 2', '2021', 'Angkatan kedua', '2026-01-17 11:57:39'),
(3, 'Angkatan 3', '2022', 'Angkatan ketiga', '2026-01-17 11:57:39'),
(4, 'Angkatan 4', '2023', 'Angkatan keempat', '2026-01-17 11:57:39'),
(5, 'Angkatan 5', '2024', 'Angkatan kelima', '2026-01-17 11:57:39'),
(6, 'Angkatan 6', '2025', 'Angkatan keenam', '2026-01-17 11:57:39'),
(7, 'Angkatan 7', '2026', 'Angkatan ketujuh', '2026-01-17 11:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_transfer`
--

CREATE TABLE `bukti_transfer` (
  `id` int(10) UNSIGNED NOT NULL,
  `pembayaran_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(50) NOT NULL COMMENT 'image/jpeg, image/png, application/pdf',
  `file_size` int(10) UNSIGNED NOT NULL COMMENT 'in bytes',
  `uploaded_by` int(10) UNSIGNED NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('072524a7617873ec3db2a728f91fca4236c3a93c', '198.235.24.37', 1769472715, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393437323731353b),
('07e5e5b4e8c674cf47d6de37f06e4ab49517abe0', '182.2.164.185', 1768686700, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383638363730303b),
('0al18e8j5mgietasb7rnp5shqljrhmnb', '::1', 1768655391, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635353339313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('0cc6bc3eddc473d9d666ca6139a3c38fb3fff391', '149.57.180.40', 1768934284, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383933343238343b),
('0nf13bf0o6ir3qrju7rp5iran6fp9fai', '::1', 1768658371, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635383337313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('109d170033e3814e096f495cb5799ae668c7f3d9', '205.210.31.57', 1769355073, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393335353037333b),
('1a0c2effbdcf5c723700636c3a62abd7d1951960', '182.3.37.50', 1768661398, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383636313332343b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('1n7qk46qo0d2mhrduo5vv2foj5mjr13v', '::1', 1768656806, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635363830363b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('23d1dc34c0308d98542248ffc4af39b645d7a804', '119.235.211.59', 1769500641, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393530303539363b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('2a793703d9ec7342519794a6a37daf68b4e2738c', '180.252.89.186', 1768806349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383830363334393b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('3d61485c9925bc872aa8975a8144a574ac61f196', '180.252.89.186', 1768806040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383830363034303b),
('3fb0e4c43b58d32aba9f5403d3e3a7b7f1bf9a15', '119.235.211.59', 1768979691, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937393639313b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('4024e65fd4dc34702434dd6cf642e1423c7ef739', '93.158.90.71', 1769239026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393233393032363b),
('4863a0e2f6d3f66b272e439e2d101116c25eda4e', '182.2.164.185', 1768699448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383639393434383b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('508f2d73dfb362121bc4e42e8242220dace57e32', '119.235.211.59', 1768872777, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383837323737373b),
('5afp0m9mci6bj4g0cdlm9v8kfth5flnu', '::1', 1768652159, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635323135393b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('655b533da47b6be686daf11471ebf4dd32e06a9b', '192.36.109.73', 1768974285, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937343238353b),
('6b9df599e447d332aa4c444b50ca7bab46946f4f', '180.252.89.186', 1768897864, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383839373836343b),
('6imr4mv751m07i0ci1ie44hirirdm6ls', '::1', 1768652563, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635323536333b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b737563636573737c733a32383a2253616e74726920626572686173696c20646974616d6261686b616e2e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('7136c25ffc1a1fbaedbc4d77722990ce98fbc7a5', '114.10.79.155', 1768885120, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383838353132303b),
('7409c952e36c9511edaeffd8074657827912447e', '205.210.31.57', 1769355072, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393335353037323b),
('7856eb034f34263d757b6633cb40ec75952e416a', '205.210.31.232', 1769132223, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393133323232333b),
('7d3483047363bf1f976b335bf94a19e6cb2ecc53', '23.27.145.42', 1769289013, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393238393031333b),
('7shpcl14ha7pvjphededus1kp8j922nn', '::1', 1768653214, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635333231343b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('82815a3f3a59b992bcad8c41dd27cb6d4c52fd40', '192.71.12.112', 1769242547, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393234323534373b),
('8525ec5b76839afc0aa68adbb390232f908fc5ff', '182.3.37.50', 1768661324, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383636313332343b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('8a6d03fa95a5427517e0df86b5e7b0ccd4513486', '146.196.96.122', 1768873904, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383837333930343b),
('8fd4bc5880ea4927d9dc04150ed25a8d0240809e', '205.210.31.235', 1769129013, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393132393031333b),
('934c05a180c4d5e8ca5289bc52ae9a222f57cb8f', '182.2.164.185', 1768686511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383638363531313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('9593d9d2779d57dc2c2714a14b8d634599422f99', '98.84.1.175', 1768911945, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383931313934353b),
('99b1ac7151d1d6cd92bce613511c99a8376dd87b', '149.57.180.33', 1768931285, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383933313238353b),
('9e74cfe2ec15f5b31800aec52dcb4ac6642abad0', '198.235.24.231', 1769184270, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393138343237303b),
('9f148cc42525ecb9a9318c8e43b2d8fa5607edb8', '182.2.164.185', 1768699448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383639393434383b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('9qt6as7u1n3sotrgu9okom9b7almrnp3', '::1', 1768658403, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635383337313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('a154f466d0eb6810dc48ec1450e2985ad4dacdb4', '114.10.76.238', 1768701519, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383730313531393b),
('a45aa0d97ac3410774c1cafd3a4402120751c94a', '198.235.24.135', 1769457316, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393435373331363b),
('a623fb14916811a8ab05864ba0957bed9ef86f5b', '192.36.109.98', 1768974284, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937343238343b),
('a993194ebd354106bc3ab1956372ac17ea4e0b38', '114.10.77.162', 1768792542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383739323534323b),
('ab2dec5b14b7fd4292bcddccb96a405b6b392f62', '93.158.90.70', 1769239025, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393233393032353b),
('afcfc4d28bc7d0212d2733b95b8a36989700ce45', '93.158.90.155', 1769486764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393438363736343b),
('b306aaa2f91c4470139fbc33077b997d4b535232', '198.235.24.37', 1769472715, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393437323731353b),
('bb8af7bc1a8bb6adb06deca3bc08110b16a8e3a1', '180.252.89.186', 1768806395, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383830363339353b),
('c43658d44d3fc80efcdd5797fa891b50ea4db47a', '83.140.247.225', 1768975456, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937353435363b),
('c530af4210f25e48dd702c6bd5502f8761c8dfb5', '192.71.126.26', 1769242546, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393234323534363b),
('c81c6bcdf1d51faddb9a318fe8f74f4c38cbeb2c', '198.235.24.135', 1769457315, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393435373331353b),
('c97665ff0a0287f2b2da77a28ca7d6fd54d11c2b', '182.2.164.185', 1768687223, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383638373232333b),
('cc65bbc9c7009905b5d9e4d0315b59cdf1d5606a', '149.57.180.65', 1769021610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393032313630393b),
('d0081bcfff46d6164405ea3e553abd3e4fdeaaad', '98.84.1.175', 1768911943, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383931313934333b),
('d248c763a7152b46c2d5e84a1b623b53a4bd064a', '119.235.211.59', 1768979739, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937393639313b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('d5576da538b8ea6ecf52e35a2269c8bc0f578a30', '182.2.164.185', 1768687336, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383638373332343b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('dseb17tebbh9na0lirkplsvktjftlmtv', '::1', 1768654811, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635343831313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b737563636573737c733a32393a2250656d6261796172616e20626572686173696c20646973696d70616e2e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('e01d987dbfa4769c199e7d6ba6fb1a7a4772c6da', '119.235.211.59', 1768875008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383837353030383b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('e699c00ce0b0cec27944b74e237c159974f2297e', '93.158.90.36', 1769484119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393438343131393b),
('eff3ba9c9b3b84002763c219e39fd8eb5b847180', '23.27.145.44', 1769112353, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393131323335323b),
('f3242236715c5af8ea0a3ac7122f3e56a7740c70', '119.235.211.59', 1768875008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383837353030383b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('f4dbb859c6ce94c234af74904b64e467d954d4e6', '93.158.90.153', 1769486763, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393438363736333b),
('f9e733e863d11796b52e6673f869974a1e3f63b1', '114.10.78.247', 1769226804, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393232363830343b),
('fd7ed3e2d591dd1cb206c16292d048d5d6df46f9', '192.121.38.126', 1768975455, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383937353435353b),
('fde7e413d7c6c21ea7339ac5dce93383a2706240', '93.158.90.45', 1769484117, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393438343131373b),
('gjr5rj546lld1aiv2vab9uucpn2p000l', '::1', 1768657516, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635373531363b),
('hb990jli1bl31olvqsmrvd20bmja60kd', '::1', 1768657991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635373939313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b),
('j7rkknqh08090u65c1nao01f3olqgf57', '::1', 1768652871, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635323837313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b737563636573737c733a33323a224b6572696e67616e616e20626572686173696c20646974616d6261686b616e2e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('lubn9qnsd0e4kdjop399btappplom7bc', '::1', 1768651857, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635313835373b757365725f69647c733a313a2232223b757365726e616d657c733a353a2261646d696e223b726f6c657c733a31343a2241444d494e5f4b4555414e47414e223b6c6f676765645f696e7c623a313b),
('nr7189h32t1tm83eck2soq0p08corl56', '::1', 1768657056, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635373035363b),
('p4mfcntmhtn8jr5h8bev6igvuu23983g', '::1', 1768656339, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383635363333393b757365725f69647c733a313a2231223b757365726e616d657c733a31303a22737570657261646d696e223b726f6c657c733a31313a2253555045525f41444d494e223b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `jenjang`
--

CREATE TABLE `jenjang` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(20) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenjang`
--

INSERT INTO `jenjang` (`id`, `nama`, `keterangan`, `created_at`) VALUES
(1, 'SMP', 'Sekolah Menengah Pertama', '2026-01-17 11:57:39'),
(2, 'SMA', 'Sekolah Menengah Atas', '2026-01-17 11:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenjang_id` int(10) UNSIGNED NOT NULL,
  `tingkat` tinyint(4) NOT NULL COMMENT '1-6',
  `nama` varchar(50) NOT NULL COMMENT 'Contoh: Kelas 1 SMP',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `jenjang_id`, `tingkat`, `nama`, `created_at`) VALUES
(1, 1, 1, 'Kelas 1 SMP', '2026-01-17 11:57:39'),
(2, 1, 2, 'Kelas 2 SMP', '2026-01-17 11:57:39'),
(3, 1, 3, 'Kelas 3 SMP', '2026-01-17 11:57:39'),
(4, 2, 1, 'Kelas 1 SMA', '2026-01-17 11:57:39'),
(5, 2, 2, 'Kelas 2 SMA', '2026-01-17 11:57:39'),
(6, 2, 3, 'Kelas 3 SMA', '2026-01-17 11:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `keringanan_spp`
--

CREATE TABLE `keringanan_spp` (
  `id` int(10) UNSIGNED NOT NULL,
  `santri_id` int(10) UNSIGNED NOT NULL,
  `tipe` enum('PERSEN','NOMINAL') NOT NULL,
  `nilai` decimal(10,2) NOT NULL COMMENT 'Jika PERSEN: 0-100, jika NOMINAL: nominal rupiah',
  `alasan` text NOT NULL,
  `mulai_berlaku` date NOT NULL,
  `berakhir` date DEFAULT NULL COMMENT 'NULL = berlaku selamanya',
  `aktif` tinyint(1) DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keringanan_spp`
--

INSERT INTO `keringanan_spp` (`id`, `santri_id`, `tipe`, `nilai`, `alasan`, `mulai_berlaku`, `berakhir`, `aktif`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'PERSEN', 50.00, 'Yatiem', '2026-01-17', NULL, 1, 1, '2026-01-17 12:27:43', '2026-01-17 12:27:43');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `modul` varchar(50) NOT NULL COMMENT 'Auth, Santri, Pembayaran, dll',
  `data_before` text DEFAULT NULL COMMENT 'JSON data sebelum perubahan',
  `data_after` text DEFAULT NULL COMMENT 'JSON data setelah perubahan',
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `user_id`, `aktivitas`, `modul`, `data_before`, `data_after`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'Menambah santri: Farhansyah', 'Santri', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:22:38'),
(2, 1, 'Generate tagihan bulan 1 2026 untuk 4 santri', 'Tagihan', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:24:41'),
(3, 1, 'Menambahkan keringanan untuk santri ID 1', 'Keringanan', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:27:43'),
(4, 1, 'Input pembayaran cash Rp 550000 untuk tagihan ID 1', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:28:13'),
(5, 1, 'Input pembayaran cash Rp 550000 untuk tagihan ID 2', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:28:35'),
(6, 1, 'Input pembayaran cash Rp 50000 untuk tagihan ID 4', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:28:44'),
(7, 1, 'Input pembayaran cash Rp 650000 untuk tagihan ID 3', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:29:03'),
(8, 1, 'Generate tagihan bulan 2 2026 untuk 4 santri', 'Tagihan', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:29:35'),
(9, 1, 'Input pembayaran cash Rp 600000 untuk tagihan ID 8', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:29:49'),
(10, 1, 'Input pembayaran cash Rp 550000 untuk tagihan ID 4', 'Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 12:33:47'),
(11, 1, 'Memperbarui pengaturan branding pesantren', 'Pengaturan', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 13:47:34'),
(12, 1, 'Memperbarui pengaturan branding pesantren', 'Pengaturan', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 13:47:35'),
(13, 2, 'Generate tagihan bulan 1 2026 untuk 0 santri (OPTI MODE)', 'Tagihan', NULL, NULL, '114.10.76.238', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', '2026-01-18 01:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(10) UNSIGNED NOT NULL,
  `tagihan_id` int(10) UNSIGNED NOT NULL,
  `metode` enum('CASH','TRANSFER') NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `status` enum('PENDING','VERIFIED','REJECTED') DEFAULT 'VERIFIED' COMMENT 'PENDING untuk transfer, VERIFIED untuk cash',
  `catatan` text DEFAULT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL COMMENT 'User yang input/verifikasi',
  `verified_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `tagihan_id`, `metode`, `jumlah`, `tanggal_bayar`, `status`, `catatan`, `admin_id`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'CASH', 550000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:28:13', '2026-01-17 12:28:13'),
(2, 2, 'CASH', 550000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:28:35', '2026-01-17 12:28:35'),
(3, 4, 'CASH', 50000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:28:44', '2026-01-17 12:28:44'),
(4, 3, 'CASH', 650000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:29:03', '2026-01-17 12:29:03'),
(5, 8, 'CASH', 600000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:29:49', '2026-01-17 12:29:49'),
(6, 4, 'CASH', 550000.00, '2026-01-17 00:00:00', 'VERIFIED', '', 1, NULL, '2026-01-17 12:33:47', '2026-01-17 12:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(10) UNSIGNED NOT NULL,
  `h_key` varchar(50) NOT NULL,
  `h_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `h_key`, `h_value`, `created_at`, `updated_at`) VALUES
(1, 'nama_pesantren', 'Pesantren Daar El Manshur', '2026-01-17 13:45:11', '2026-01-17 13:47:34'),
(2, 'alamat_pesantren', 'Jl. Pendidikan No. 123, Kota Santri', '2026-01-17 13:45:11', '2026-01-17 13:45:11'),
(3, 'telepon_pesantren', '0812-3456-7890', '2026-01-17 13:45:11', '2026-01-17 13:45:11'),
(4, 'logo_pesantren', 'logo_1768657654.jpg', '2026-01-17 13:45:11', '2026-01-17 13:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'User account untuk santri login',
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas_id` int(10) UNSIGNED NOT NULL,
  `angkatan_id` int(10) UNSIGNED NOT NULL,
  `wali_user_id` int(10) UNSIGNED NOT NULL COMMENT 'User ID dari wali santri',
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','LULUS','KELUAR') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `user_id`, `nis`, `nama`, `kelas_id`, `angkatan_id`, `wali_user_id`, `jenis_kelamin`, `tanggal_lahir`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, '2024001', 'Muhammad Rizki', 1, 5, 3, 'L', '2010-05-15', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(2, NULL, '2024002', 'Fatimah Zahra', 1, 5, 3, 'P', '2010-08-20', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(3, NULL, '2024003', 'Ahmad Fauzi', 4, 6, 4, 'L', '2008-03-12', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(4, NULL, '2025001', 'Farhansyah', 2, 6, 3, 'L', '1999-12-28', 'ACTIVE', '2026-01-17 12:22:38', '2026-01-17 12:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_spp`
--

CREATE TABLE `tagihan_spp` (
  `id` int(10) UNSIGNED NOT NULL,
  `santri_id` int(10) UNSIGNED NOT NULL,
  `tahun_ajaran_id` int(10) UNSIGNED NOT NULL,
  `bulan` tinyint(4) NOT NULL COMMENT '1-12',
  `tahun` year(4) NOT NULL,
  `tarif_awal` decimal(10,2) NOT NULL COMMENT 'Tarif sebelum potongan',
  `keringanan_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID keringanan yang digunakan',
  `potongan` decimal(10,2) DEFAULT 0.00 COMMENT 'Nominal potongan',
  `nominal_akhir` decimal(10,2) NOT NULL COMMENT 'Tarif setelah potongan',
  `jumlah_dibayar` decimal(10,2) DEFAULT 0.00 COMMENT 'Total yang sudah dibayar',
  `status` enum('BELUM_BAYAR','CICILAN','LUNAS') DEFAULT 'BELUM_BAYAR',
  `jatuh_tempo` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihan_spp`
--

INSERT INTO `tagihan_spp` (`id`, `santri_id`, `tahun_ajaran_id`, `bulan`, `tahun`, `tarif_awal`, `keringanan_id`, `potongan`, `nominal_akhir`, `jumlah_dibayar`, `status`, `jatuh_tempo`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2026', 550000.00, NULL, 0.00, 550000.00, 0.00, 'LUNAS', '2026-01-10', '2026-01-17 12:24:40', '2026-01-17 12:28:13'),
(2, 2, 2, 1, '2026', 550000.00, NULL, 0.00, 550000.00, 0.00, 'LUNAS', '2026-01-10', '2026-01-17 12:24:40', '2026-01-17 12:28:35'),
(3, 3, 2, 1, '2026', 650000.00, NULL, 0.00, 650000.00, 0.00, 'LUNAS', '2026-01-10', '2026-01-17 12:24:40', '2026-01-17 12:29:03'),
(4, 4, 2, 1, '2026', 550000.00, NULL, 0.00, 550000.00, 0.00, 'LUNAS', '2026-01-10', '2026-01-17 12:24:40', '2026-01-17 12:33:47'),
(5, 1, 2, 2, '2026', 550000.00, 1, 275000.00, 275000.00, 0.00, 'BELUM_BAYAR', '2026-02-10', '2026-01-17 12:29:35', '2026-01-17 12:29:35'),
(6, 2, 2, 2, '2026', 550000.00, NULL, 0.00, 550000.00, 0.00, 'BELUM_BAYAR', '2026-02-10', '2026-01-17 12:29:35', '2026-01-17 12:29:35'),
(7, 3, 2, 2, '2026', 650000.00, NULL, 0.00, 650000.00, 0.00, 'BELUM_BAYAR', '2026-02-10', '2026-01-17 12:29:35', '2026-01-17 12:29:35'),
(8, 4, 2, 2, '2026', 550000.00, NULL, 0.00, 550000.00, 0.00, 'LUNAS', '2026-02-10', '2026-01-17 12:29:35', '2026-01-17 12:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(20) NOT NULL COMMENT 'Format: 2024/2025',
  `tahun_mulai` year(4) NOT NULL,
  `tahun_selesai` year(4) NOT NULL,
  `aktif` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `nama`, `tahun_mulai`, `tahun_selesai`, `aktif`, `created_at`, `updated_at`) VALUES
(1, '2024/2025', '2024', '2025', 0, '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(2, '2025/2026', '2025', '2026', 1, '2026-01-17 11:57:39', '2026-01-17 11:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `tarif_spp`
--

CREATE TABLE `tarif_spp` (
  `id` int(10) UNSIGNED NOT NULL,
  `tahun_ajaran_id` int(10) UNSIGNED NOT NULL,
  `jenjang_id` int(10) UNSIGNED NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarif_spp`
--

INSERT INTO `tarif_spp` (`id`, `tahun_ajaran_id`, `jenjang_id`, `nominal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 500000.00, 'SPP SMP Tahun 2024/2025', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(2, 1, 2, 600000.00, 'SPP SMA Tahun 2024/2025', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(3, 2, 1, 550000.00, 'SPP SMP Tahun 2025/2026', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(4, 2, 2, 650000.00, 'SPP SMA Tahun 2025/2026', '2026-01-17 11:57:39', '2026-01-17 11:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('SUPER_ADMIN','ADMIN_KEUANGAN','SANTRI','WALI_SANTRI') NOT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$vWGHKk5dyDe9hDoJg/lnnuDcwNnnB1GXlUMyXp4pvdISv20cOEygW', 'SUPER_ADMIN', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 12:09:40'),
(2, 'admin', '$2y$10$vWGHKk5dyDe9hDoJg/lnnuDcwNnnB1GXlUMyXp4pvdISv20cOEygW', 'ADMIN_KEUANGAN', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 12:09:40'),
(3, 'wali001', '$2y$10$vWGHKk5dyDe9hDoJg/lnnuDcwNnnB1GXlUMyXp4pvdISv20cOEygW', 'WALI_SANTRI', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 12:09:40'),
(4, 'wali002', '$2y$10$vWGHKk5dyDe9hDoJg/lnnuDcwNnnB1GXlUMyXp4pvdISv20cOEygW', 'WALI_SANTRI', 'ACTIVE', '2026-01-17 11:57:39', '2026-01-17 12:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `wali_santri`
--

CREATE TABLE `wali_santri` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wali_santri`
--

INSERT INTO `wali_santri` (`id`, `user_id`, `nama`, `no_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ahmad Hidayat', '081234567890', 'Jl. Pesantren No. 1, Jakarta', '2026-01-17 11:57:39', '2026-01-17 11:57:39'),
(2, 4, 'Siti Fatimah', '081234567891', 'Jl. Pesantren No. 2, Jakarta', '2026-01-17 11:57:39', '2026-01-17 11:57:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angkatan`
--
ALTER TABLE `angkatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nama` (`nama`),
  ADD KEY `idx_tahun_masuk` (`tahun_masuk`);

--
-- Indexes for table `bukti_transfer`
--
ALTER TABLE `bukti_transfer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_pembayaran` (`pembayaran_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `idx_pembayaran` (`pembayaran_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `jenjang`
--
ALTER TABLE `jenjang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nama` (`nama`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_jenjang_tingkat` (`jenjang_id`,`tingkat`),
  ADD KEY `idx_jenjang` (`jenjang_id`);

--
-- Indexes for table `keringanan_spp`
--
ALTER TABLE `keringanan_spp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_santri` (`santri_id`),
  ADD KEY `idx_aktif` (`aktif`),
  ADD KEY `idx_mulai_berlaku` (`mulai_berlaku`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_modul` (`modul`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `idx_tagihan` (`tagihan_id`),
  ADD KEY `idx_metode` (`metode`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_tanggal` (`tanggal_bayar`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `h_key` (`h_key`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_nis` (`nis`),
  ADD KEY `idx_nama` (`nama`),
  ADD KEY `idx_kelas` (`kelas_id`),
  ADD KEY `idx_angkatan` (`angkatan_id`),
  ADD KEY `idx_wali` (`wali_user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `tagihan_spp`
--
ALTER TABLE `tagihan_spp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tagihan` (`santri_id`,`tahun_ajaran_id`,`bulan`,`tahun`),
  ADD KEY `keringanan_id` (`keringanan_id`),
  ADD KEY `idx_santri` (`santri_id`),
  ADD KEY `idx_tahun_ajaran` (`tahun_ajaran_id`),
  ADD KEY `idx_bulan_tahun` (`bulan`,`tahun`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_jatuh_tempo` (`jatuh_tempo`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_nama` (`nama`),
  ADD KEY `idx_aktif` (`aktif`);

--
-- Indexes for table `tarif_spp`
--
ALTER TABLE `tarif_spp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tahun_jenjang` (`tahun_ajaran_id`,`jenjang_id`),
  ADD KEY `jenjang_id` (`jenjang_id`),
  ADD KEY `idx_tahun_ajaran` (`tahun_ajaran_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `wali_santri`
--
ALTER TABLE `wali_santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_id` (`user_id`),
  ADD KEY `idx_no_hp` (`no_hp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angkatan`
--
ALTER TABLE `angkatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bukti_transfer`
--
ALTER TABLE `bukti_transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenjang`
--
ALTER TABLE `jenjang`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keringanan_spp`
--
ALTER TABLE `keringanan_spp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tagihan_spp`
--
ALTER TABLE `tagihan_spp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tarif_spp`
--
ALTER TABLE `tarif_spp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wali_santri`
--
ALTER TABLE `wali_santri`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukti_transfer`
--
ALTER TABLE `bukti_transfer`
  ADD CONSTRAINT `bukti_transfer_ibfk_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bukti_transfer_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keringanan_spp`
--
ALTER TABLE `keringanan_spp`
  ADD CONSTRAINT `keringanan_spp_ibfk_1` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keringanan_spp_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan_spp` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `santri_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `santri_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `santri_ibfk_3` FOREIGN KEY (`angkatan_id`) REFERENCES `angkatan` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `santri_ibfk_4` FOREIGN KEY (`wali_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `tagihan_spp`
--
ALTER TABLE `tagihan_spp`
  ADD CONSTRAINT `tagihan_spp_ibfk_1` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tagihan_spp_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tagihan_spp_ibfk_3` FOREIGN KEY (`keringanan_id`) REFERENCES `keringanan_spp` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tarif_spp`
--
ALTER TABLE `tarif_spp`
  ADD CONSTRAINT `tarif_spp_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tarif_spp_ibfk_2` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wali_santri`
--
ALTER TABLE `wali_santri`
  ADD CONSTRAINT `wali_santri_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
