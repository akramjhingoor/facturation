-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 02 Octobre 2015 à 07:37
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `maisondesligues`
--

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `numfacture` int(11) NOT NULL,
  `datefacture` date NOT NULL,
  `echeance` date NOT NULL,
  `compte_ligue` int(11) NOT NULL,
  PRIMARY KEY (`numfacture`),
  KEY `compte_ligue` (`compte_ligue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`numfacture`, `datefacture`, `echeance`, `compte_ligue`) VALUES
(5180, '2014-01-15', '2014-01-30', 411007),
(5181, '2015-03-15', '2015-03-30', 411008),
(5182, '2015-09-10', '2015-09-25', 411009);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_facture`
--

CREATE TABLE IF NOT EXISTS `ligne_facture` (
  `numfacture` int(11) NOT NULL,
  `code_prestation` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  PRIMARY KEY (`numfacture`,`code_prestation`),
  KEY `code_prestation` (`code_prestation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ligne_facture`
--

INSERT INTO `ligne_facture` (`numfacture`, `code_prestation`, `quantite`) VALUES
(5180, 1, 40),
(5180, 3, 250),
(5180, 4, 30),
(5181, 1, 100),
(5181, 4, 50),
(5182, 2, 100),
(5182, 3, 155);

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE IF NOT EXISTS `ligue` (
  `numcompte` int(11) NOT NULL,
  `intitule` varchar(30) NOT NULL,
  `nomtresorier` varchar(20) NOT NULL,
  `adrue` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `ville` varchar(20) NOT NULL,
  PRIMARY KEY (`numcompte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ligue`
--

INSERT INTO `ligue` (`numcompte`, `intitule`, `nomtresorier`, `adrue`, `cp`, `ville`) VALUES
(411007, 'Ligue Lorraine d''Escrime', 'Valérie LAHEURTE', '13 rue Jean Moulin - BP 70001', 54510, 'TOMBLAINE'),
(411008, 'Ligue Lorraine de Football', 'Pierre LENOIR', '13 rue Jean Moulin - BP 70001', 54510, 'TOMBLAINE'),
(411009, 'Ligue Lorraine de Basket', 'Mohamed BOURGARD', '13 rue Jean Moulin - BP 70001', 54510, 'TOMBLAINE'),
(411010, 'Ligue Lorraine de Baby Foot', 'Sylvain DELAHOUSSE', '13 rue Jean Moulin - BP 70001', 54510, 'TOMBLAINE'),
(411011, 'Ligue Lorraine de Futsal', 'Jean-Luc RASTA', '182 avenue Pierre et Marie Curie', 54510, 'TOMBLAINE');

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE IF NOT EXISTS `prestation` (
  `codepres` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL,
  `prix_unitaire` float NOT NULL,
  PRIMARY KEY (`codepres`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prestation`
--

INSERT INTO `prestation` (`codepres`, `libelle`, `prix_unitaire`) VALUES
(1, 'Affanchissement', 3.34),
(2, 'Photocopies couleur', 0.24),
(3, 'Photocopies NoirBlan', 0.06),
(4, 'Gestion des Colis', 8.24);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`compte_ligue`) REFERENCES `ligue` (`numcompte`);

--
-- Contraintes pour la table `ligne_facture`
--
ALTER TABLE `ligne_facture`
  ADD CONSTRAINT `ligne_facture_ibfk_1` FOREIGN KEY (`numfacture`) REFERENCES `facture` (`numfacture`),
  ADD CONSTRAINT `ligne_facture_ibfk_2` FOREIGN KEY (`code_prestation`) REFERENCES `prestation` (`codepres`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
