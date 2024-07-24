-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2024 at 06:03 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gest_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(5, 'Electronique'),
(6, 'Telephone'),
(8, 'Tablette');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_produit` int NOT NULL,
  `quantites` int NOT NULL,
  `date_commande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `fk_produit` (`id_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_produit`, `quantites`, `date_commande`, `id_commande`, `nom_client`) VALUES
(22, 50, '2024-07-23 15:17:18', 38, 'Rabe'),
(25, 1, '2024-07-24 08:26:07', 41, 'Luck'),
(24, 12, '2024-07-23 15:40:57', 40, 'Aina');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prix_unitaire` int NOT NULL,
  `id_categorie` int NOT NULL,
  `quantiter` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_produit`),
  KEY `fk_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom`, `prix_unitaire`, `id_categorie`, `quantiter`) VALUES
(26, 'Asus Rog phone', 2000000, 6, 100),
(25, 'arduino nano', 20000, 5, 99),
(24, 'Arduino mega', 70000, 5, 88);

-- --------------------------------------------------------

--
-- Table structure for table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id_responsable` int NOT NULL AUTO_INCREMENT,
  `nom_responsable` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `nom_utilisateur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `admin_access` enum('oui','non') NOT NULL DEFAULT 'non',
  PRIMARY KEY (`id_responsable`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  UNIQUE KEY `nom_utilisateur_2` (`nom_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `nom_responsable`, `mdp`, `nom_utilisateur`, `admin_access`) VALUES
(1, 'Administrateur', 'admin', 'admin', 'oui'),
(8, 'lolo', '123', 'lolo', 'non');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
