-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 03 juin 2020 à 09:02
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
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `idCategorie` int(11) NOT NULL,
  `categorie` varchar(50) NOT NULL,
  `specification` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `categorie`, `specification`) VALUES
(1, 'Technique du projet', 'Technique technologique et conceptuelle de l\'élève dans son travail au sein du projet'),
(2, 'Attitude professionnelle', 'Attitude de l\'élève en milieu professionnel'),
(3, 'Aptitude professionnelle', 'Capacité de l\'élève à apprendre de lui même et raisonner de manière organisée et structurée');

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
(1, 'Organisation quotidienne', 'L\'élève s\'organise quotidiennement', 10, 3),
(2, 'Attitude pendant les rendez-vous', 'L\'élève reste attentif, concentré, et s\'intéresse aux propositions du client.', 7, 2),
(3, 'Indépendance', 'L\'élève est indépendant et auto-didacte dans son travail', 10, 1),
(9, 'Demande de l\'aide', 'Demande de l&#39;aide à un camarade ou un professeur avec des questions pertinentes et réflechies.', 4, 1),
(10, 'Travail pendant les heures', 'L\'élève travaille pendant le temps alloué au travail.', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `criteres_projets`
--

CREATE TABLE `criteres_projets` (
  `idProjet` int(11) NOT NULL,
  `idCritere` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `criteres_projets`
--

INSERT INTO `criteres_projets` (`idProjet`, `idCritere`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 9),
(3, 1),
(3, 2),
(3, 10),
(11, 1),
(11, 3),
(11, 10),
(16, 1),
(16, 2),
(16, 3),
(16, 9),
(16, 10);

-- --------------------------------------------------------

--
-- Structure de la table `domaines`
--

CREATE TABLE `domaines` (
  `idDomaine` int(11) NOT NULL,
  `domaine` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `domaines`
--

INSERT INTO `domaines` (`idDomaine`, `domaine`) VALUES
(1, 'Web'),
(2, 'Infrastructure'),
(3, 'Programmation');

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `idEleve` int(11) NOT NULL,
  `classe` varchar(20) NOT NULL,
  `annee` varchar(20) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `eleves`
--

INSERT INTO `eleves` (`idEleve`, `classe`, `annee`, `idUtilisateur`) VALUES
(1, 'I.DA-P3C', '3', 1),
(2, 'I.DA-P3C', '3', 5),
(3, 'I.DA-P3C', '3', 6),
(4, 'I.DA-P3C', '3', 7),
(5, 'I.DA-P3C', '3', 8);

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE `evaluations` (
  `idEvaluation` int(11) NOT NULL,
  `observation` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `pointsObtenus` varchar(20) NOT NULL,
  `idEleve` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  `idCritere` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evaluations`
--

INSERT INTO `evaluations` (`idEvaluation`, `observation`, `date`, `pointsObtenus`, `idEleve`, `idProjet`, `idCritere`) VALUES
(10, 'Bravo', '2020-06-02', '10', 1, 2, 1),
(9, 'asd', '2020-06-02', '7', 1, 2, 2),
(8, 'sda', '2020-06-02', '4', 1, 2, 9),
(7, 'aaa', '2020-06-02', '10', 1, 2, 3),
(11, 'asdasd', '2020-06-02', '0', 2, 2, 3),
(12, 'asd', '2020-06-02', '0', 2, 2, 9),
(13, 'sdsd', '2020-06-02', '0', 2, 2, 2),
(14, 'df', '2020-06-02', '0', 2, 2, 1),
(15, '', '2020-06-02', '4', 4, 3, 2),
(16, '', '2020-06-02', '3', 4, 3, 10),
(17, '', '2020-06-02', '6', 4, 3, 1),
(18, 'Pas vraiment...', '2020-06-02', '5', 1, 3, 2),
(19, 'Souvent perturbé.', '2020-06-02', '3', 1, 3, 10),
(20, 'Aucune organisation', '2020-06-02', '2', 1, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `idProjet` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `client` varchar(50) NOT NULL,
  `dureePrevue` varchar(10) NOT NULL,
  `dateDebut` date NOT NULL,
  `idDomaine` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`idProjet`, `titre`, `description`, `client`, `dureePrevue`, `dateDebut`, `idDomaine`, `idUtilisateur`) VALUES
(2, 'PRO-VELO', 'Site d&#39;itinéraire de vélo.', 'GE-Roule', '2', '2020-05-25', 1, 2),
(3, 'GE-soif', 'Localise les fontaines autour de l&#39;utilisateur à Genève.', 'CFPT', '2', '2020-05-25', 1, 2),
(4, 'Pointeuse', 'Permet de controler la présence des élèves aux cours', 'CFPT', '2', '2020-05-25', 2, 3),
(11, 'GUMPRUNTE', 'Emprunt de livres d&#39;école.', 'CFPT', '15', '2020-05-29', 1, 2),
(16, 'as', 'ass', 'sssa', '1', '2020-05-25', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `travaille_pour`
--

CREATE TABLE `travaille_pour` (
  `idProjet` int(11) NOT NULL,
  `idEleve` int(11) NOT NULL,
  `estEvalue` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `travaille_pour`
--

INSERT INTO `travaille_pour` (`idProjet`, `idEleve`, `estEvalue`) VALUES
(2, 2, 1),
(2, 1, 1),
(3, 4, 1),
(3, 2, 0),
(16, 1, 0),
(3, 1, 1),
(11, 4, 0),
(16, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `motDePasse` varchar(500) NOT NULL,
  `statut` enum('1','2','3') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `motDePasse`, `statut`) VALUES
(1, 'Witzig', 'Adrien', 'adrien.wtzg@eduge.ch', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', '3'),
(2, 'Weber', 'Sandrine', 'edu-webers@eduge.ch', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', '2'),
(3, 'Travenjak', 'Jasmina', 'edu-travnjakj@eduge.ch', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', '2'),
(5, 'Szeless', 'Tatjana', 'tatjana.szlss@eduge.ch', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', '3'),
(6, 'Meier', 'Luc', 'luc.mr@eduge.ch', '', '3'),
(7, 'Morel', 'Yannick', 'yannick.mrl@eduge.ch', '', '3'),
(8, 'Tissot', 'Thomas', 'thomas.tsst@eduge.ch', '', '3');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Index pour la table `criteres`
--
ALTER TABLE `criteres`
  ADD PRIMARY KEY (`idCritere`);

--
-- Index pour la table `criteres_projets`
--
ALTER TABLE `criteres_projets`
  ADD PRIMARY KEY (`idProjet`,`idCritere`);

--
-- Index pour la table `domaines`
--
ALTER TABLE `domaines`
  ADD PRIMARY KEY (`idDomaine`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`idEleve`);

--
-- Index pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`idEvaluation`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`idProjet`);

--
-- Index pour la table `travaille_pour`
--
ALTER TABLE `travaille_pour`
  ADD PRIMARY KEY (`idProjet`,`idEleve`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `criteres`
--
ALTER TABLE `criteres`
  MODIFY `idCritere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `domaines`
--
ALTER TABLE `domaines`
  MODIFY `idDomaine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `idEleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `idEvaluation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `idProjet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
