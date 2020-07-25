-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 23 juil. 2020 à 13:25
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camping`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(11) NOT NULL AUTO_INCREMENT,
  `note_sejour` int(11) NOT NULL,
  `titre_avis` varchar(50) NOT NULL,
  `texte_avis` varchar(500) NOT NULL,
  `post_date` date NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `note_sejour`, `titre_avis`, `texte_avis`, `post_date`, `id_utilisateur`, `id_reservation`) VALUES
(1, 4, 'Titre', 'Ceci est mon avis.', '2020-07-23', 10, 8);

-- --------------------------------------------------------

--
-- Structure de la table `detail_lieux`
--

DROP TABLE IF EXISTS `detail_lieux`;
CREATE TABLE IF NOT EXISTS `detail_lieux` (
  `id_detail_lieu` int(11) NOT NULL AUTO_INCREMENT,
  `nom_lieu` varchar(200) NOT NULL,
  `prix_journalier` decimal(10,0) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  PRIMARY KEY (`id_detail_lieu`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_lieux`
--

INSERT INTO `detail_lieux` (`id_detail_lieu`, `nom_lieu`, `prix_journalier`, `id_reservation`) VALUES
(1, 'Les Pins', '10', 1),
(2, 'Les Pins', '10', 2),
(4, 'Les Pins', '10', 6),
(5, 'Les Pins', '10', 7),
(6, 'La Plage', '10', 8);

-- --------------------------------------------------------

--
-- Structure de la table `detail_options`
--

DROP TABLE IF EXISTS `detail_options`;
CREATE TABLE IF NOT EXISTS `detail_options` (
  `id_detail_option` int(11) NOT NULL AUTO_INCREMENT,
  `nom_option` varchar(200) NOT NULL,
  `prix_option` decimal(10,0) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  PRIMARY KEY (`id_detail_option`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_options`
--

INSERT INTO `detail_options` (`id_detail_option`, `nom_option`, `prix_option`, `id_reservation`) VALUES
(4, 'Accès Disco-Club “Les girelles dansantes”', '17', 6),
(3, 'Accès borne électrique', '2', 6),
(5, 'Accès borne électrique', '2', 7),
(6, 'Accès borne électrique', '2', 8);

-- --------------------------------------------------------

--
-- Structure de la table `detail_types_emplacement`
--

DROP TABLE IF EXISTS `detail_types_emplacement`;
CREATE TABLE IF NOT EXISTS `detail_types_emplacement` (
  `id_detail_type_emplacement` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_emplacement` varchar(200) NOT NULL,
  `nb_emplacements_reserves` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  UNIQUE KEY `id_detail_type_emplacement` (`id_detail_type_emplacement`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_types_emplacement`
--

INSERT INTO `detail_types_emplacement` (`id_detail_type_emplacement`, `nom_type_emplacement`, `nb_emplacements_reserves`, `id_reservation`) VALUES
(1, 'Tente', 1, 1),
(2, 'Camping', 2, 1),
(3, 'Tente', 1, 2),
(5, 'Tente', 2, 6),
(6, 'Camping', 2, 6),
(7, 'Tente', 1, 7),
(8, 'Tente', 1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

DROP TABLE IF EXISTS `lieux`;
CREATE TABLE IF NOT EXISTS `lieux` (
  `id_lieu` int(11) NOT NULL AUTO_INCREMENT,
  `nom_lieu` varchar(100) NOT NULL,
  `emplacements_disponibles` int(11) NOT NULL,
  `prix_journalier` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_lieu`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`id_lieu`, `nom_lieu`, `emplacements_disponibles`, `prix_journalier`) VALUES
(1, 'La Plage', 4, '10'),
(2, 'Les Pins', 8, '10'),
(3, 'Le Maquis', 1, '10');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id_newsletter`, `email`) VALUES
(1, 'test@test.com'),
(2, 'test3@test.com');

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id_option` int(11) NOT NULL AUTO_INCREMENT,
  `nom_option` varchar(100) NOT NULL,
  `prix_option` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_option`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id_option`, `nom_option`, `prix_option`) VALUES
(1, 'Accès borne électrique', '2'),
(2, 'Accès Disco-Club “Les girelles dansantes”', '17');

-- --------------------------------------------------------

--
-- Structure de la table `prix_detail`
--

DROP TABLE IF EXISTS `prix_detail`;
CREATE TABLE IF NOT EXISTS `prix_detail` (
  `id_prix_detail` int(11) NOT NULL AUTO_INCREMENT,
  `nb_emplacement` int(11) NOT NULL,
  `prix_journalier` decimal(10,0) NOT NULL,
  `prix_options` decimal(10,0) NOT NULL,
  `nb_jours` int(11) NOT NULL,
  `prix_total` decimal(10,0) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  PRIMARY KEY (`id_prix_detail`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix_detail`
--

INSERT INTO `prix_detail` (`id_prix_detail`, `nb_emplacement`, `prix_journalier`, `prix_options`, `nb_jours`, `prix_total`, `id_reservation`) VALUES
(1, 4, '40', '19', 3, '177', 6),
(2, 1, '10', '2', 2, '24', 7),
(3, 1, '10', '2', 2, '24', 8);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_reservation`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `date_debut`, `date_fin`, `id_utilisateur`) VALUES
(1, '2020-07-14', '2020-07-25', 10),
(2, '2020-07-24', '2020-07-27', 10),
(7, '2020-07-22', '2020-07-23', 10),
(6, '2020-07-23', '2020-07-25', 10),
(8, '2020-07-22', '2020-07-23', 10);

-- --------------------------------------------------------

--
-- Structure de la table `types_emplacement`
--

DROP TABLE IF EXISTS `types_emplacement`;
CREATE TABLE IF NOT EXISTS `types_emplacement` (
  `id_type_emplacement` int(11) NOT NULL AUTO_INCREMENT,
  `nom_type_emplacement` varchar(100) NOT NULL,
  `nb_emplacements` int(11) NOT NULL,
  PRIMARY KEY (`id_type_emplacement`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `types_emplacement`
--

INSERT INTO `types_emplacement` (`id_type_emplacement`, `nom_type_emplacement`, `nb_emplacements`) VALUES
(1, 'Tente', 1),
(2, 'Camping', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `register_date` datetime NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `num_tel` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `register_date`, `password`, `is_admin`, `num_tel`, `gender`, `avatar`) VALUES
(8, 'test', 'test', 'test2@test.com', '2020-07-10 20:47:41', '$2y$10$AOxEmREeoGH38DKNLUXvBuPOZ21iGYR22RIQlHolcRBFtHcrt0ewq', 0, '1234567891', '', ''),
(7, 'test', 'test', 'test@test.com', '2020-07-10 20:11:46', '$2y$10$EdGvotOOiUWZdfxNsJbm2uXbFm8ZAUArvtpo8dhpPWPGmokaVpNPi', 0, '123', '', ''),
(9, 'Test', 'Test', 'test5@test.com', '2020-07-14 17:14:41', '$2y$10$8QoUBp9QCXysNbXnzzhTV.jbCYODXL2evjTENe5Ek06QbXp1wcjcS', 0, '0000000000', '', ''),
(10, 'Test', 'Test', 'test3@test.com', '2020-07-15 13:05:30', '$2y$10$5jXUMjgkWYl4NpWLO1KOZuagn/54owqmfqtcGRXtwM4Kbgan.dCR2', 1, '0000000000', '', 'css/images/no-image.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
