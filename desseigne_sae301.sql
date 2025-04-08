-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 18 déc. 2024 à 15:32
-- Version du serveur : 10.3.39-MariaDB-0+deb10u2
-- Version de PHP : 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Base de données : `desseigne_sae301`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ordre` int(11) DEFAULT NULL,
  `titre` text DEFAULT NULL,
  `redacteur` varchar(512) DEFAULT NULL,
  `accroche` text DEFAULT NULL,
  `type` varchar(500) DEFAULT NULL,
  `id_theme` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `ordre`, `titre`, `redacteur`, `accroche`, `type`, `id_theme`) VALUES
(3, 1, 'test', 'test', 'Saisir une accroche ', NULL, 10),
(5, 1, 'Article 1', 'test', 'Saisir une accroche', 'ecson', 7),
(6, 2, 'Article 2', 'imen', 'nohlan et niederschaeffolsheim', 'ecrit', 7),
(7, 2, 'Un nouvel article', 'sam', 'test d article', NULL, 10),
(25, 1, 'je suis un article', 'salome saxo', 'lalalallalalallalalala', 'ecvid', 14),
(29, 3, 'nouveau', 'nouveau', 'nouveau', 'ecrit', 7),
(30, 4, 'Voici un titre ', 'SASHA', 'Lorem Lorem Lorem vvv Lorem Loremvv Lorem LoremLorem Lorem ', 'ecsonvid', 7);

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

CREATE TABLE `element` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ordre` int(11) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `son` varchar(550) DEFAULT NULL,
  `video` varchar(550) DEFAULT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `legende` varchar(1000) DEFAULT NULL,
  `id_article` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `element`
--

INSERT INTO `element` (`id`, `ordre`, `type`, `contenu`, `image`, `son`, `video`, `alt`, `legende`, `id_article`) VALUES
(10, 7, 'h1', 'BONJOUR', '', '', '', '', '', 5),
(22, 1, 'h1', 'test', '', NULL, '', NULL, NULL, 6),
(35, 15, 'son', '', '675c5dbe5375b6.24491156.mp3', NULL, '', NULL, NULL, 5),
(60, 19, 'image', '', '676055fb517996.80810141.gif', '', '', '', 'OUAIS J\'AVOUE OUESH', 5),
(68, 1, 'son', '', '', NULL, '', '', '', 7),
(86, 23, 'imtxt_d', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsudolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '6762ce4a919568.69104447.jpg', '6762ce4a91de70.13975773.jpg', '6762ce4a91def6.59044592.jpg', '', '', 5),
(94, 26, 'imtxt_g', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', '676155e4ebd327.14614476.png', '', '', 'salome saxo', 'SALOME SAXO', 5),
(115, 34, 'h1', 'Mme Jouette', '', '', '', '', '', 5),
(116, 2, 'image', '', '6761886b7e5579.67632147.jpg', '6761886b7ec387.03990742.jpg', '6761886b7ec424.04065725.jpg', '', '', 6),
(127, 3, 'son', '', '', '', '', '', '', 6),
(135, 36, 'citation', 'xqsdqdsqf', '', '', '', 'pablo picasso', 'yes', 5),
(136, 1, 'h1', 'L\'Europe c\'est l\'Europe', '', '', '', '', '', 25),
(139, 2, 'p', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', '', '', '', 'yes', 25),
(140, 3, 'p', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', '', '', '', '', 25),
(141, 38, 'citation', 'je suis la citation des citations', '', '', '', 'palmier', '', 5),
(158, 41, 'citation', 'bonjour je la citation qui cite des citations qui cite des citations avec une citation', '', '', '', 'salome saxo', 'yes', 5),
(163, 1, 'image', 'carrousel', '6762ea73540517.83462767.gif', '6762ea73544720.63581944.gif', '6762ea735447c2.99999796.gif', '', 'sqdds', 29);

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `theme`
--

INSERT INTO `theme` (`id`, `nom`, `description`, `image`) VALUES
(7, 'Ceci est un nouveau titre test youhou', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '6762c6c68d8c93.97553179.jpg'),
(10, 'je suis mobile demain', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '6762a915d7c440.42772960.jpg'),
(14, 'je suis le nouveau theme', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '6762a9231568a9.07922255.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_theme` (`id_theme`);

--
-- Index pour la table `element`
--
ALTER TABLE `element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `element`
--
ALTER TABLE `element`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id`);

--
-- Contraintes pour la table `element`
--
ALTER TABLE `element`
  ADD CONSTRAINT `element_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`);
COMMIT;

