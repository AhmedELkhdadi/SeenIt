-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le :  mar. 23 mars 2021 à 18:44
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `seenit`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_com` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `id_post` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `follows`
--

CREATE TABLE `follows` (
  `follower` varchar(25) NOT NULL,
  `followed` varchar(25) NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `moment`
--

CREATE TABLE `moment` (
  `id_moment` varchar(23) NOT NULL,
  `Description` text NOT NULL,
  `img_moment` varchar(30) NOT NULL DEFAULT 'no_moment.png',
  `article` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `moment`
--

INSERT INTO `moment` (`id_moment`, `Description`, `img_moment`, `article`) VALUES
('5f459f10c025d', 'reminds me that I have a belly buttong', '5f459f10c025d.png', '39'),
('5f4c1bce14c68', 'it\'s you who is the traitor.', '5f4c1bce14c68.png', '45'),
('5f4c3a73078d0', 'survive this', '5f4c3a73078d0.png', '45'),
('5f4c3eb679f8a', 'all of a sudden, the mastermind gets shipped tomorrow', '5f4c3eb679f8a.png', '45'),
('5f4c4f1547724', 'I had a good life', '5f4c4f1547724.png', '45'),
('5f4c50f63686e', '', '5f4c50f63686e.png', '45'),
('5f4c53920c7c9', 'u haven\'t actualy given up ?', '5f4c53920c7c9.png', '45'),
('5f4c57d7846ea', 'ain\'t nobody eating this ', '5f4c57d7846ea.png', '45'),
('5f4c587852920', 'nice knowing you Emma', '5f4c587852920.png', '45'),
('5f4c599071d59', 'still alive ', '5f4c599071d59.png', '45'),
('5f4c5ec48163c', 'they\'ll show you something cool, so shut up and follow', '5f4c5ec48163c.png', '45'),
('5f4c620f38d4b', 'I did it to survive, longer than anyone.', '5f4c620f38d4b.png', '45'),
('5f4c6274c0493', 'Run childer, I hope you can find true happiness', '5f4c6274c0493.png', '45'),
('5f56d92ab4dd2', 'Ughh !', '5f56d92ab4dd2.png', '5f56d910ce8f4'),
('5f57ef803800d', 'head... boom ! ', '5f57ef803800d.png', '5f56d910ce8f4'),
('5f57f21be796a', 'Daddy\'s home ', '5f57f21be796a.png', '5f56d910ce8f4');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `code` varchar(80) DEFAULT NULL,
  `login` varchar(25) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `title` varchar(80) NOT NULL,
  `imgUrl` text NOT NULL DEFAULT '../images/no_poster'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `quotes`
--

CREATE TABLE `quotes` (
  `id_quote` varchar(23) NOT NULL,
  `article` varchar(20) NOT NULL,
  `quote` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `quotes`
--

INSERT INTO `quotes` (`id_quote`, `article`, `quote`) VALUES
('5f6bfb14c64c4', '5f6bef62ca570', 'Look for what\'s out there, not what you want to be there.'),
('5f6c0ed0331ca', '5f6bef62ca570', 'Sometimes you need to dangle your feet in the water in ordre ro atract the sharks.');

-- --------------------------------------------------------

--
-- Structure de la table `towatcharticle`
--

CREATE TABLE `towatcharticle` (
  `id_tw` int(11) NOT NULL,
  `code` varchar(80) NOT NULL,
  `login` varchar(25) NOT NULL,
  `imgUrl` text NOT NULL,
  `title` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `login` varchar(25) NOT NULL,
  `pwd` varchar(25) NOT NULL,
  `name` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `notifications` int(11) NOT NULL DEFAULT 0,
  `image` varchar(35) NOT NULL DEFAULT 'no-image.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`login`, `pwd`, `name`, `Email`, `notifications`, `image`) VALUES
(' stephando', '123456', 'Ahmed ', 'bene100@hotmail.fr', 0, 'no-image.png'),
('ahmed', 'ousskaka', 'this a name', 'bene100@hotmail.fr', 0, 'no-image.png'),
('asa', '123456', 'qqq', 'bene100@hotmail.fr', 0, 'no-image.png'),
('asaaa', 'qwerty', 'qqq', 'bene100@hotmail.fr', 0, 'no-image.png'),
('asaaaa', 'ousskaka123', 'qqq', 'bene100@hotmail.fr', 0, 'no-image.png'),
('heh', '123456', 'heheh', 'bene100@hotmail.fr', 0, 'no-image.png'),
('hhh', 'ousskaka123', 'Ahmed Elkhdadi', 'ahmedelkhdadi@gmail.com', 0, 'no-image.png'),
('oussam', '123456', 'ahmed', 'bene100@hotmail.fr', 0, 'no-image.png'),
('oussama', '123456', 'ahmed', 'bene100@hotmail.fr', 0, 'no-image.png'),
('stephando', '123456', 'Ahmed ', 'bene100@hotmail.fr', 0, 'no-image.png');

-- --------------------------------------------------------

--
-- Structure de la table `watchedarticle`
--

CREATE TABLE `watchedarticle` (
  `id_w` varchar(20) NOT NULL,
  `code` varchar(80) NOT NULL,
  `login` varchar(25) NOT NULL,
  `thought` text DEFAULT NULL,
  `date` date NOT NULL,
  `rating` int(2) DEFAULT NULL,
  `title` varchar(80) NOT NULL,
  `imgUrl` text NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `watchedarticle`
--

INSERT INTO `watchedarticle` (`id_w`, `code`, `login`, `thought`, `date`, `rating`, `title`, `imgUrl`, `status`) VALUES
('35', '/title/tt3032476/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-08-23', 8, 'Better Call Saul&nbsp;            ', 'https://m.media-amazon.com/images/M/MV5BMGE4YzY4NGEtOWYyYS00ZDk2LWExMmMtZDIyODhiMmNlMGE0XkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('39', '/title/tt9686708/?ref_=fn_tt_tt_2', 'stephando', 'veyr funny movie, chill and emotional.', '2020-08-25', 8, 'The King of Staten Island&nbsp;(2020)             ', 'https://m.media-amazon.com/images/M/MV5BYzkxMzMzOTgtNmZhMS00MGM0LTk3MzUtMjE1MzI4MzU5ZjkzXkEyXkFqcGdeQXVyMDA4NzMyOA@@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('40', '/title/tt10888708/?ref_=fn_tt_tt_1', 'stephando', 'kid\'s show,amusing to watch but not rly that good.', '2020-08-27', 5, 'The Sleepover&nbsp;(2020)             ', 'https://m.media-amazon.com/images/M/MV5BZmE1Mjg5ZjgtYjkzYi00OWYxLWEyMDQtYjI3NWE1ZTc3N2Q3XkEyXkFqcGdeQXVyNjEwNTM2Mzc@._V1_UX182_CR0,0,182,268_AL_.jpg', 'unfinished'),
('44', '/title/tt9484998/?ref_=fn_tt_tt_1', 'stephando', 'good movie with some really funny moments, the concept is done many times but it is well executed.', '2020-08-29', 7, 'Palm Springs&nbsp;(2020)             ', 'https://m.media-amazon.com/images/M/MV5BYjk0MTgzMmQtZmY2My00NmE5LWExNGUtYjZkNTA3ZDkyMTJiXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_UY268_CR0,0,182,268_AL_.jpg', 'seenIt'),
('45', '/title/tt8788458/?ref_=fn_tt_tt_1', 'stephando', '', '2020-08-30', 8, 'Yakusoku no Neverland&nbsp;            ', 'https://m.media-amazon.com/images/M/MV5BMTYwYjYyZDgtMTQ3My00YTI4LThmZTUtZmU1MjllOWRlOTdhXkEyXkFqcGdeQXVyMzgxODM4NjM@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f5279a9450d3', '/title/tt0264464/?ref_=fn_tt_tt_1', 'stephando', 'very good movie about the real life con man Frank Abagnal, one of the best manhunts with a very good set of actors.', '2020-09-04', 9, 'Catch Me If You Can&nbsp;(2002)             ', 'https://m.media-amazon.com/images/M/MV5BMTY5MzYzNjc5NV5BMl5BanBnXkFtZTYwNTUyNTc2._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f52ea1855d97', '/title/tt2369047/?ref_=fn_tt_tt_1', 'stephando', 'very representative of the life of the poor moroccan life ', '2020-09-05', 8, 'Les chevaux de Dieu&nbsp;(2012)             ', 'https://m.media-amazon.com/images/M/MV5BNTk3NzE0MDAwOF5BMl5BanBnXkFtZTgwMjgzMTA3MTE@._V1_UY268_CR3,0,182,268_AL_.jpg', 'seenIt'),
('5f56d910ce8f4', '/title/tt1190634/?ref_=fn_tt_tt_1', 'stephando', 'This show is so unique in the sense that it\'s not afraid to show gorry scenes and the super-heroes are in fact the villains, which is unusual to say the least.', '2020-09-08', 8, 'The Boys&nbsp;            ', 'https://m.media-amazon.com/images/M/MV5BNGEyOGJiNWEtMTgwMi00ODU4LTlkMjItZWI4NjFmMzgxZGY2XkEyXkFqcGdeQXVyNjcyNjcyMzQ@._V1_UX182_CR0,0,182,268_AL_.jpg', 'watching'),
('5f6be411ce527', '/title/tt0278488/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-09-24', 8, 'How High&nbsp;(2001)             ', 'https://m.media-amazon.com/images/M/MV5BZWZlNWE3MjctMDJmYS00ZTAyLWFkYmEtMzllNjU0ZDY5ODA2XkEyXkFqcGdeQXVyNDk3NzU2MTQ@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f6be46f67227', '/title/tt1959563/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-09-24', 8, 'The Hitman\'s Bodyguard&nbsp;(2017)             ', 'https://m.media-amazon.com/images/M/MV5BMjQ5NjA2NDg1MV5BMl5BanBnXkFtZTgwMDAzNDc4MjI@._V1_UX182_CR0,0,182,268_AL_.jpg', 'unfinished'),
('5f6be491ec7f4', '/title/tt0111161/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-09-24', 10, 'The Shawshank Redemption&nbsp;(1994)             ', 'https://m.media-amazon.com/images/M/MV5BMDFkYTc0MGEtZmNhMC00ZDIzLWFmNTEtODM1ZmRlYWMwMWFmXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f6be4aa00909', '/title/tt1645170/?ref_=fn_tt_tt_1', 'stephando', 'very good but the version on netflix is very short and lots of scenes were cut.', '2020-09-24', 8, 'The Dictator&nbsp;(2012)             ', 'https://m.media-amazon.com/images/M/MV5BNTlkOWYzZDYtNzQ1MS00YTNkLTkyYTItMjBmNjgyMDBlMjI4XkEyXkFqcGdeQXVyNTIzOTk5ODM@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f6be4d005dc7', '/title/tt3381008/?ref_=fn_tt_tt_1', 'stephando', 'very funny', '2020-09-24', 6, 'Grimsby&nbsp;(2016)             ', 'https://m.media-amazon.com/images/M/MV5BMjE0NTE3MjMwNV5BMl5BanBnXkFtZTgwMDc5NjQxODE@._V1_UX182_CR0,0,182,268_AL_.jpg', 'watching'),
('5f6be505b7d5f', '/title/tt0068646/?ref_=fn_tt_tt_1', 'stephando', '', '2020-09-24', 10, 'The Godfather&nbsp;(1972)             ', 'https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_UY268_CR3,0,182,268_AL_.jpg', 'watching'),
('5f6bef62ca570', '/title/tt7846844/?ref_=fn_tt_tt_1', 'stephando', 'good enough to keep you watching, but nothing special.', '2020-09-24', 6, 'Enola Holmes&nbsp;(2020)             ', 'https://m.media-amazon.com/images/M/MV5BZjNkNzk0ZjEtM2M1ZC00MmMxLTlmOWEtNWRlZTc1ZTUyNzY4XkEyXkFqcGdeQXVyMTEyMjM2NDc2._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f6ea84767bbc', '/title/tt2278388/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-09-26', NULL, 'The Grand Budapest Hotel&nbsp;(2014)             ', 'https://m.media-amazon.com/images/M/MV5BMzM5NjUxOTEyMl5BMl5BanBnXkFtZTgwNjEyMDM0MDE@._V1_UX182_CR0,0,182,268_AL_.jpg', 'seenIt'),
('5f793662d5c14', '/title/tt12227418/?ref_=fn_tt_tt_1', 'stephando', 'start exchiting, but it became so chaotic and rushed afterwards, the power lvl sky rocketed out of no where and without any sign of training or anything, good enough to keep you watching and that\'s it&nbsp;', '0000-00-00', 6, 'The God of High School&nbsp;            ', 'https://m.media-amazon.com/images/M/MV5BYjljYmYzNjMtZWY5YS00OGZjLTk4MTYtNDZmYzkxYjgyMDMzXkEyXkFqcGdeQXVyODM2NjQzOTA@._V1_UY268_CR3,0,182,268_AL_.jpg', 'watching'),
('5f94571b02184', '/title/tt2098220/?ref_=fn_tt_tt_1', 'stephando', NULL, '2020-10-24', NULL, 'Hunter x Hunter&nbsp;            ', 'https://m.media-amazon.com/images/M/MV5BZjNmZDhkN2QtNDYyZC00YzJmLTg0ODUtN2FjNjhhMzE3ZmUxXkEyXkFqcGdeQXVyNjc2NjA5MTU@._V1_UX182_CR0,0,182,268_AL_.jpg', 'watching');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_com`),
  ADD KEY `login` (`login`);

--
-- Index pour la table `follows`
--
ALTER TABLE `follows`
  ADD KEY `follows_ibfk_1` (`followed`),
  ADD KEY `follower` (`follower`);

--
-- Index pour la table `moment`
--
ALTER TABLE `moment`
  ADD PRIMARY KEY (`id_moment`),
  ADD KEY `article` (`article`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `login` (`login`);

--
-- Index pour la table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id_quote`),
  ADD KEY `article` (`article`);

--
-- Index pour la table `towatcharticle`
--
ALTER TABLE `towatcharticle`
  ADD PRIMARY KEY (`id_tw`),
  ADD KEY `login` (`login`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `watchedarticle`
--
ALTER TABLE `watchedarticle`
  ADD PRIMARY KEY (`id_w`),
  ADD KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `towatcharticle`
--
ALTER TABLE `towatcharticle`
  MODIFY `id_tw` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`login`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`followed`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`follower`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `moment`
--
ALTER TABLE `moment`
  ADD CONSTRAINT `moment_ibfk_1` FOREIGN KEY (`article`) REFERENCES `watchedarticle` (`id_w`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`login`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`article`) REFERENCES `watchedarticle` (`id_w`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `towatcharticle`
--
ALTER TABLE `towatcharticle`
  ADD CONSTRAINT `towatcharticle_ibfk_1` FOREIGN KEY (`login`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `watchedarticle`
--
ALTER TABLE `watchedarticle`
  ADD CONSTRAINT `watchedarticle_ibfk_1` FOREIGN KEY (`login`) REFERENCES `users` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
