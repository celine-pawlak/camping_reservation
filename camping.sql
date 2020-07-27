-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 27 juil. 2020 à 14:04
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `note_sejour`, `titre_avis`, `texte_avis`, `post_date`, `id_utilisateur`, `id_reservation`) VALUES
(16, 3, 'Ça va', 'Le séjour était sympa. Le cadre est joli. ', '2020-07-27', 13, 15),
(14, 5, 'AU TOP', 'Ce camping est une nouvelle pépite, je reviendrais !', '2020-07-13', 12, 14),
(15, 4, 'Génial', 'Ce séjour était génial, ce camping reste mon favori. A l\'année prochaine !', '2020-07-25', 12, 13);

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_lieux`
--

INSERT INTO `detail_lieux` (`id_detail_lieu`, `nom_lieu`, `prix_journalier`, `id_reservation`) VALUES
(12, 'Le Maquis', '10', 15),
(11, 'Les Pins', '10', 14),
(10, 'La Plage', '10', 13);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail_types_emplacement`
--

INSERT INTO `detail_types_emplacement` (`id_detail_type_emplacement`, `nom_type_emplacement`, `nb_emplacements_reserves`, `id_reservation`) VALUES
(15, 'CampingCar', 2, 15),
(14, 'Tente', 1, 15),
(13, 'Tente', 2, 14),
(12, 'CampingCar', 2, 13);

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
(2, 'Les Pins', 4, '10'),
(3, 'Le Maquis', 4, '10');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id_option`, `nom_option`, `prix_option`) VALUES
(1, 'Acc&egrave;s borne &eacute;lectrique', '2'),
(2, 'Acc&egrave;s Disco-Club &ldquo;Les girelles dansantes&rdquo;', '17'),
(3, 'Yoga, Frisbee et Ski Nautique', '30');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix_detail`
--

INSERT INTO `prix_detail` (`id_prix_detail`, `nb_emplacement`, `prix_journalier`, `prix_options`, `nb_jours`, `prix_total`, `id_reservation`) VALUES
(5, 0, '0', '30', 2, '60', 11);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `date_debut`, `date_fin`, `id_utilisateur`) VALUES
(14, '2020-07-06', '2020-07-11', 12),
(13, '2020-07-20', '2020-07-23', 12),
(15, '2020-07-20', '2020-07-25', 13);

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
(2, 'CampingCar', 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `register_date`, `password`, `is_admin`, `num_tel`, `gender`, `avatar`) VALUES
(15, 'admin', 'admin', 'admin@admin.com', '2020-07-27 15:22:15', '$2y$10$/ExrdKu5fH9wiGXpgKkiHOpbp.5psBDbB82BUKPTlulgPuHX7MC0i', 1, '0000000000', 'Non genré', 'css/images/no-image.png'),
(13, 'Doe', 'Jane', 'jane.doe@gmail.com', '2020-07-27 15:20:15', '$2y$10$uJV1ZyL16RcnwPI4gRtk.u90.NN9ok76zZUgJRY5pef7kFwUHRaXq', 0, '0704030201', 'Femme', 'css/images/no-image.png'),
(12, 'Doe', 'John', 'john.doe@gmail.com', '2020-07-27 15:19:34', '$2y$10$B6e9RnnkT1kA6pvhVWIKAuNJ2DEULyYSBQ/AbBE668WwbKm5vc8ka', 0, '0601020304', 'Homme', 'css/images/no-image.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
