-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 23, 2026 at 09:09 PM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recensement_citoyen_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_complet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant` (`identifiant`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrateur`
--

INSERT INTO `administrateur` (`id`, `identifiant`, `mot_de_passe`, `nom_complet`, `date_creation`) VALUES
(1, 'admin', '$2b$10$STKylNsaby9vbs7OAslfD.dvsWvg1QduCJZCqwjOqxpvZVSP2NCFC', 'Agent Communal Test', '2026-07-18 23:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `citoyen`
--

DROP TABLE IF EXISTS `citoyen`;
CREATE TABLE IF NOT EXISTS `citoyen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `numero_copie` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('en_attente','valide','rejete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_copie` (`numero_copie`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `citoyen`
--

INSERT INTO `citoyen` (`id`, `nom`, `prenom`, `date_naissance`, `numero_copie`, `mot_de_passe`, `statut`, `date_creation`) VALUES
(1, 'rako', 'johan', '2026-08-07', '10110110101', '$2y$10$A6fouZUwTGD0CRFSW7wL/u.Mn30sEcTGkdF0gbKAUd.uBTxQnA46y', 'valide', '2026-07-14 20:57:23'),
(2, 'RAKOTOMANANA', 'Johan', '2007-04-18', '101102', '$2y$10$QTITh8/V9AoO79GCVfUEu.ZzNdalcgmMJ6ntTMir9TdrM/cNTdtZW', 'rejete', '2026-07-15 20:57:23'),
(3, 'e', 'e', '2026-07-07', '101', '$2y$10$bXhQk7q1ceuExIS3pdFn9uA64OcHKEqaqTEJ0uwVGe30KLcp5IzhS', 'valide', '2026-07-16 20:57:23'),
(4, 'jzs', 'aa', '2026-06-30', '1012', '$2y$10$hFYOa9r5yoT.lJNfxFUmhu.WJ.gErrnezMn2gffEpJ/ubniGqXq.W', 'valide', '2026-07-17 20:57:23'),
(5, 'rako', 'johan', '2026-07-08', '1013', '$2y$10$OtQkln3RxvaefL7B5kCfZ.UvTSjMpJzjDEgiqJY5jyNyuB4zvRO5e', 'valide', '2026-07-18 20:57:23'),
(6, 'rako', 'johan', '2026-07-08', '1014', '$2y$10$ayna82DIpyxX/ctqnN0SHOTjccdg0XtFlkcbh0E4UClmO/TSUgjKm', 'valide', '2026-07-19 20:57:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
