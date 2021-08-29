-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 mars 2021 à 08:06
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kartina`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse_facturation`
--

DROP TABLE IF EXISTS `adresse_facturation`;
CREATE TABLE IF NOT EXISTS `adresse_facturation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` int(11) NOT NULL,
  `rue` longtext NOT NULL,
  `artiste_id` int(11) NOT NULL,
  `n_rue` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adresse_facturation_artiste1_idx` (`artiste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `adresse_livraison`
--

DROP TABLE IF EXISTS `adresse_livraison`;
CREATE TABLE IF NOT EXISTS `adresse_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` int(11) NOT NULL,
  `rue` longtext NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `artiste_id` int(11) NOT NULL,
  `n_rue` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adresse_livraison_artiste1_idx` (`artiste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `artiste`
--

DROP TABLE IF EXISTS `artiste`;
CREATE TABLE IF NOT EXISTS `artiste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(225) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `civilite` varchar(45) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `siret` int(11) DEFAULT NULL,
  `isArtist` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `artiste`
--

INSERT INTO `artiste` (`id`, `email`, `mdp`, `civilite`, `nom`, `prenom`, `telephone`, `siret`, `isArtist`) VALUES
(1, 'lalauxclement@gmail.com', 'mdp', '0', 'lalaux', 'clement', 761147926, NULL, 0),
(21, 'lalauxclement@gmail.com', '$2y$10$vvLQ3UYIsXgcQuxaMyDWAOMYSW2.N3XDKzaczRDoizehUcdVW9jkG', '0', 'Lalaux', 'Clement', 761147926, NULL, 0),
(22, 'lalauxclement@gmail.com', '$2y$10$4xOXfO7n.iFmAIBB.xiVxu9T/pW0WXBOtocC9l2v4OxjwAOzT4cVO', '0', 'Lalaux', 'Clement', 761147926, NULL, 0),
(23, 'lalauxclement@gmail.com', '$2y$10$huZvC57qqpcp8EyGcO/YHef2L5cykpAdintq5YbRlqH8fE0eOF9me', '0', 'Jean', 'Valjean', 761147926, NULL, 0),
(24, 'lalauxclement@gmail.com', '$2y$10$ghNR69Bg.IS1azJXvO/DTeEkfan2958jtd6scLgHmXVR5VSuwek5m', '0', 'Jean', 'Valjean', 761147926, NULL, 0),
(25, 'feliciaportal@gmail.com', '$2y$10$bmpayK/CwF0PSJVr7/XoYeL7fmfiZvi6gaSMUHhIlLIQ0A9c7.em6', '1', 'Portal', 'Felicia', 123456789, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cadre`
--

DROP TABLE IF EXISTS `cadre`;
CREATE TABLE IF NOT EXISTS `cadre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cadre` varchar(255) NOT NULL,
  `pourcentage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cadre`
--

INSERT INTO `cadre` (`id`, `cadre`, `pourcentage`) VALUES
(1, 'sans encadrement', 0),
(2, 'encadrement noir satin', 45),
(3, 'encadrement blanc satin', 45),
(4, 'encadrement noyer', 45),
(5, 'encadrement chene', 45),
(6, 'encadrement aluminium noir', 0),
(7, 'encadrement bois blanc', 0),
(8, 'encadrement acajou mat', 0),
(9, 'encadrement aluminium brosse', 0);

-- --------------------------------------------------------

--
-- Structure de la table `finition`
--

DROP TABLE IF EXISTS `finition`;
CREATE TABLE IF NOT EXISTS `finition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `finition` varchar(45) NOT NULL,
  `pourcentage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `finition`
--

INSERT INTO `finition` (`id`, `finition`, `pourcentage`) VALUES
(1, 'passe-partout noir', 0),
(2, 'passe-partout blanc', 40),
(3, 'support aluminium', 160),
(4, 'support aluminium avec verre acrylique', 235),
(5, 'tirage sur papier photo', 0);

-- --------------------------------------------------------

--
-- Structure de la table `format`
--

DROP TABLE IF EXISTS `format`;
CREATE TABLE IF NOT EXISTS `format` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `format` varchar(45) NOT NULL,
  `pourcentage` varchar(45) NOT NULL,
  `cover` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `format`
--

INSERT INTO `format` (`id`, `format`, `pourcentage`, `cover`) VALUES
(1, 'classique', '30', 'classic'),
(2, 'grand', '60', 'large'),
(3, 'géant', '120', 'giant'),
(4, 'collector', '300', 'collector');

-- --------------------------------------------------------

--
-- Structure de la table `orientation`
--

DROP TABLE IF EXISTS `orientation`;
CREATE TABLE IF NOT EXISTS `orientation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orientation` varchar(45) NOT NULL,
  `cover` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orientation`
--

INSERT INTO `orientation` (`id`, `orientation`, `cover`) VALUES
(1, 'portrait', 'vert'),
(2, 'paysage', 'horiz'),
(3, 'carré', 'carre'),
(4, 'panoramique', 'pano');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artiste_id` int(11) NOT NULL,
  `adresse_facturation_id` int(11) NOT NULL,
  `adresse_livraison_id` int(11) NOT NULL,
  `isCheckout` tinyint(4) NOT NULL,
  `date_commande` date DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_panier_artiste1_idx` (`artiste_id`),
  KEY `fk_panier_adresse_facturation1_idx` (`adresse_facturation_id`),
  KEY `fk_panier_adresse_livraison1_idx` (`adresse_livraison_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `quantité` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date_publication` date NOT NULL,
  `theme_id` int(11) NOT NULL,
  `artiste_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_photo_categorie_idx` (`theme_id`),
  KEY `fk_photo_artiste1_idx` (`artiste_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo_has_format`
--

DROP TABLE IF EXISTS `photo_has_format`;
CREATE TABLE IF NOT EXISTS `photo_has_format` (
  `photo_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`,`format_id`),
  KEY `fk_photo_has_format_format1_idx` (`format_id`),
  KEY `fk_photo_has_format_photo1_idx` (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photo_has_orientation`
--

DROP TABLE IF EXISTS `photo_has_orientation`;
CREATE TABLE IF NOT EXISTS `photo_has_orientation` (
  `photo_id` int(11) NOT NULL,
  `orientation_id` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`,`orientation_id`),
  KEY `fk_photo_has_orientation_orientation1_idx` (`orientation_id`),
  KEY `fk_photo_has_orientation_photo1_idx` (`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produit_panier`
--

DROP TABLE IF EXISTS `produit_panier`;
CREATE TABLE IF NOT EXISTS `produit_panier` (
  `id_produit_panier` int(11) NOT NULL AUTO_INCREMENT,
  `panier_id` int(11) NOT NULL,
  `cadre_id` int(11) NOT NULL,
  `finition_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id_produit_panier`),
  KEY `fk_produit_panier_panier1_idx` (`panier_id`),
  KEY `fk_produit_panier_cadre1_idx` (`cadre_id`),
  KEY `fk_produit_panier_finition1_idx` (`finition_id`),
  KEY `fk_produit_panier_format1_idx` (`format_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

DROP TABLE IF EXISTS `theme`;
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id`, `theme`) VALUES
(1, 'mode'),
(2, 'urban'),
(3, 'noir et blanc'),
(4, 'nature'),
(5, 'voyage'),
(6, 'rêve et création'),
(7, 'sport et création'),
(8, 'célébrités et histoire');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse_facturation`
--
ALTER TABLE `adresse_facturation`
  ADD CONSTRAINT `fk_adresse_facturation_artiste1` FOREIGN KEY (`artiste_id`) REFERENCES `artiste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `adresse_livraison`
--
ALTER TABLE `adresse_livraison`
  ADD CONSTRAINT `fk_adresse_livraison_artiste1` FOREIGN KEY (`artiste_id`) REFERENCES `artiste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_panier_adresse_facturation1` FOREIGN KEY (`adresse_facturation_id`) REFERENCES `adresse_facturation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_panier_adresse_livraison1` FOREIGN KEY (`adresse_livraison_id`) REFERENCES `adresse_livraison` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_panier_artiste1` FOREIGN KEY (`artiste_id`) REFERENCES `artiste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `fk_photo_artiste1` FOREIGN KEY (`artiste_id`) REFERENCES `artiste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_photo_categorie` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `photo_has_format`
--
ALTER TABLE `photo_has_format`
  ADD CONSTRAINT `fk_photo_has_format_format1` FOREIGN KEY (`format_id`) REFERENCES `format` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_photo_has_format_photo1` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `photo_has_orientation`
--
ALTER TABLE `photo_has_orientation`
  ADD CONSTRAINT `fk_photo_has_orientation_orientation1` FOREIGN KEY (`orientation_id`) REFERENCES `orientation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_photo_has_orientation_photo1` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `produit_panier`
--
ALTER TABLE `produit_panier`
  ADD CONSTRAINT `fk_produit_panier_cadre1` FOREIGN KEY (`cadre_id`) REFERENCES `cadre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produit_panier_finition1` FOREIGN KEY (`finition_id`) REFERENCES `finition` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produit_panier_format1` FOREIGN KEY (`format_id`) REFERENCES `format` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produit_panier_panier1` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
