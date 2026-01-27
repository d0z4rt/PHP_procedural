-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 jan. 2026 à 10:42
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `api_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `individu`
--

DROP TABLE IF EXISTS `individu`;
CREATE TABLE IF NOT EXISTS `individu` (
  `individu_id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `salaire` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`individu_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `individu`
--

INSERT INTO `individu` (`individu_id`, `nom`, `prenom`, `age`, `sexe`, `service_id`, `salaire`) VALUES
(1, 'Durant', 'Claire', 26, 'F', 1, 8000.00),
(2, 'Deketer', 'Stephane', 31, 'M', 2, 5000.00),
(3, 'Messian', 'Marie', 49, 'F', 3, 6000.00),
(4, 'Vanier', 'Cyril', 49, 'M', 4, 7000.00);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`service_id`, `nom_service`) VALUES
(1, 'informatique'),
(2, 'gestion'),
(3, 'production'),
(4, 'client');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `individu`
--
ALTER TABLE `individu`
  ADD CONSTRAINT `individu_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;