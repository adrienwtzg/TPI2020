-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 07 juin 2020 à 23:03
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tpi_evaluation`
--

-- --------------------------------------------------------

--
-- Structure de la table `criteres`
--

CREATE TABLE `criteres` (
  `idCritere` int(11) NOT NULL,
  `critere` varchar(50) NOT NULL,
  `definition` text NOT NULL,
  `pointsMax` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `criteres`
--

INSERT INTO `criteres` (`idCritere`, `critere`, `definition`, `pointsMax`, `idCategorie`) VALUES
(1, 'Organisation quotidienne', 'L\'élève s\'organise quotidiennement.', 8, 3),
(2, 'Attitude pendant les rendez-vous', 'L\'élève reste attentif, concentré, et s\'intéresse aux propositions du client.', 7, 2),
(3, 'Indépendance.', 'L\'élève est indépendant et auto-didacte dans son travail.', 12, 1),
(9, 'Demande de l\'aide', 'Demande de l\'aide à un camarade ou un professeur avec des questions pertinentes et réflechies.', 4, 1),
(10, 'Travail pendant les heures', 'L\'élève travaille pendant le temps alloué au travail.', 5, 2),
(17, 'Travail en groupe', 'L\'élève travaille en groupe.', 15, 3),
(24, 'Recherches avancées', 'Crée ses propres recherches.', 12, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `criteres`
--
ALTER TABLE `criteres`
  ADD PRIMARY KEY (`idCritere`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `criteres`
--
ALTER TABLE `criteres`
  MODIFY `idCritere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
