-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 04 mars 2018 à 22:05
-- Version du serveur :  10.1.26-MariaDB-0+deb9u1
-- Version de PHP :  7.0.27-0+deb9u1
CREATE DATABASE Astruck;
USE Astruck;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `Astruck`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_user`) VALUES
(21, 16),
(23, 17),
(22, 18);

-- --------------------------------------------------------

--
-- Structure de la table `archive_commande`
--

CREATE TABLE `archive_commande` (
  `date_gestion_archive` datetime NOT NULL,
  `obj_archive` varchar(1000) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `date_commande` date NOT NULL,
  `heure_commande` time NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `gestion_planning`
--

CREATE TABLE `gestion_planning` (
  `date_gestion_planning` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_planning` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `gestion_produit`
--

CREATE TABLE `gestion_produit` (
  `date_gestion_produit` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `gestion_type`
--

CREATE TABLE `gestion_type` (
  `date_gestion_type` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `gestion_user`
--

CREATE TABLE `gestion_user` (
  `date_gestion_user` datetime NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `id_planning` int(11) NOT NULL,
  `jour` varchar(10) NOT NULL,
  `latitude` decimal(8,6) NOT NULL,
  `longitude` decimal(8,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  `image` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `id_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id_type` int(11) NOT NULL,
  `nom` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `tel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `FK_achat_id_produit` (`id_produit`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `FK_admin_id_user` (`id_user`);

--
-- Index pour la table `archive_commande`
--
ALTER TABLE `archive_commande`
  ADD PRIMARY KEY (`id_admin`,`id_commande`),
  ADD KEY `FK_archive_commande_id_commande` (`id_commande`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `FK_commande_id_user` (`id_user`);

--
-- Index pour la table `gestion_planning`
--
ALTER TABLE `gestion_planning`
  ADD PRIMARY KEY (`id_admin`,`id_planning`),
  ADD KEY `FK_gestion_planning_id_planning` (`id_planning`);

--
-- Index pour la table `gestion_produit`
--
ALTER TABLE `gestion_produit`
  ADD PRIMARY KEY (`id_admin`,`id_produit`),
  ADD KEY `FK_gestion_produit_id_produit` (`id_produit`);

--
-- Index pour la table `gestion_type`
--
ALTER TABLE `gestion_type`
  ADD PRIMARY KEY (`id_admin`,`id_type`),
  ADD KEY `FK_gestion_type_id_type` (`id_type`);

--
-- Index pour la table `gestion_user`
--
ALTER TABLE `gestion_user`
  ADD PRIMARY KEY (`id_user`,`id_admin`),
  ADD KEY `FK_gestion_user_id_admin` (`id_admin`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id_planning`),
  ADD UNIQUE KEY `jour` (`jour`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `FK_produit_id_type` (`id_type`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `planning`
--
ALTER TABLE `planning`
  MODIFY `id_planning` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `FK_achat_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `FK_achat_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_admin_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `archive_commande`
--
ALTER TABLE `archive_commande`
  ADD CONSTRAINT `FK_archive_commande_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `FK_archive_commande_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_commande_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `gestion_planning`
--
ALTER TABLE `gestion_planning`
  ADD CONSTRAINT `FK_gestion_planning_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `FK_gestion_planning_id_planning` FOREIGN KEY (`id_planning`) REFERENCES `planning` (`id_planning`);

--
-- Contraintes pour la table `gestion_produit`
--
ALTER TABLE `gestion_produit`
  ADD CONSTRAINT `FK_gestion_produit_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `FK_gestion_produit_id_produit` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `gestion_type`
--
ALTER TABLE `gestion_type`
  ADD CONSTRAINT `FK_gestion_type_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `FK_gestion_type_id_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`);

--
-- Contraintes pour la table `gestion_user`
--
ALTER TABLE `gestion_user`
  ADD CONSTRAINT `FK_gestion_user_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `FK_gestion_user_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_produit_id_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




--
-- Déchargement des données de la table `planning`
--

INSERT INTO `planning` (`id_planning`, `jour`, `latitude`, `longitude`) VALUES
(1, 'Lundi', '48.123425', '-1.214545'),
(3, 'Mercredi', '47.985411', '-1.415621'),
(4, 'Jeudi', '48.652314', '-1.235453'),
(5, 'Mardi', '48.214586', '-1.125451'),
(6, 'Vendredi', '48.451235', '-1.215463');


--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `email`, `mdp`, `tel`) VALUES
(16, 'gogo', 'Jean', 'jean.gogol@gmail.com', '281c9d348b1dd60bf07e326bd6f4db43cd4c3df189ba3dab8d1ac4b9e8b26c1d', '0754265422'),
(17, 'Coley', 'Jeremy', 'j.coley@laposte.net', 'd2fff6e8634192dca30205efc1bbc64ab5c10dc966aeb12ba82567e2ae0d1f1b', '0643711302'),
(18, 'aucun', 'Dieu', 'dieu@paradis.fr', 'd4e4834e1ba938446544cae8d1a9607e2f0277adaf8615d66826683dc55f94ab', '0600000000');


--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `nom`) VALUES
(1, 'Menu'),
(2, 'Boisson'),
(3, 'Dessert'),
(4, 'Hamburger');

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom`, `prix`, `image`, `description`, `id_type`) VALUES
(1, 'Menu classique', '8.50', 'classique.png', '1 burger et 1 accompagnement (frites ou potatoes ou salade) + 1 boisson OU un dessert', 1),
(2, 'Menu maxi', '9.50', 'maxi.png', '1 burger et 1 accompagnement (frites ou potatoes ou salade) + 1 boisson ET un dessert', 1),
(3, 'Menu original', '7.50', 'original.png', '1 burger et 1 boisson', 1),
(4, 'Menu mini', '7.00', 'mini.png', '1 burger et 1 accompagnement (fites ou potatoes ou salade)', 1),
(5, 'Accompagnement', '2.50', 'salade.png', 'Frites ou Potatoes ou Salade', 4),
(6, 'Vegan', '6.00', 'vegan.png', 'Le burger vegetarien (salade, tomate, oignons, galette de légumes)', 4),
(7, 'Cheeseburger', '6.00', 'cheese.png', 'Le classique cheeseburger (ketchup, moutarde, oignons, fromage et steaks)', 4),
(8, 'Chevre', '6.00', 'chevre.png', 'Burger au délicieux fromage de chevre (sauce fromage blanc, salade, tomate, oignons, steaks, fromage)', 4),
(9, 'Poisson', '6.00', 'poisson.png', 'Specialite au colin panne (sauce tartare, salade, tomate, poisson panné)', 4),
(10, 'Bacon', '6.00', 'bacon.png', 'Hamburger au bon bacon grille (ketchup, moutarde, tomate, bacon et fromage)', 4),
(11, 'Poulet', '6.00', 'poulet.png', 'Hamburger au poulet croustillant (mayonnaise, salade, tomate et poulet frit)', 4),
(12, 'Snickers', '2.00', 'snickers.png', 'Barre snack Snickers', 3),
(13, 'Muffin', '3.00', 'muffin.png', 'Muffin au pepites de chocolat', 3),
(14, 'Cookie', '3.00', 'cookie.png', 'Delicieux cookie aux pepites de chocolat', 3),
(15, 'Flan', '3.00', 'flan.png', 'Part de flan vanille', 3),
(16, 'Kinder', '2.00', 'kinder.png', 'Duo de barres Kinder bueno', 3),
(17, 'Pot de glace', '3.00', 'glace.png', 'Pot de glace saveur vanille-fraise', 3),
(18, 'Fruits', '3.00', 'fruits.png', 'Petits cartiers de pommes, d\'ananas et de raisins', 3),
(19, 'Brownie', '3.00', 'brownie.png', 'Brownie au chocolat et eclats de noisettes', 3),
(20, 'Twix', '2.00', 'twix.png', 'Duo de barres Twix', 3),
(21, 'Cafe', '1.00', 'cafe.png', 'Cafe americano', 2),
(22, 'Coca-cola', '2.00', 'cocacola.png', 'Canette de Coca-Cola 33cl', 2),
(23, 'Ice-Tea', '2.00', 'icetea.png', 'Canette de Lipton Ice-Tea 33cl', 2),
(24, 'The', '1.50', 'the.png', 'Infusion de the vert menthe', 2),
(25, 'Minutemaid', '2.00', 'minutemaid.png', 'Canette de Minute Maid pomme 33cl', 2),
(26, 'Fanta', '2.00', 'fanta.png', 'Canette de Fanta orange 33cl', 2),
(27, 'Breizh-Cola', '2.00', 'breizhcola.png', 'Canette de Breizh-Cola 33cl', 2),
(28, 'Chocolat Chaud', '1.50', 'chocolat.png', 'Delicieux chocolat chaud et sa creme fouettee', 2);

