-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Machine: localhost:3306
-- Genereertijd: 14 mrt 2017 om 11:55
-- Serverversie: 10.1.21-MariaDB
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `getadedi_base`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `naam` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT 'gebruiker naam',
  `wachtwoord` tinytext CHARACTER SET utf8 NOT NULL COMMENT 'hash',
  `rechten` varchar(1) CHARACTER SET utf8 NOT NULL COMMENT 'Rechten',
  `groep` varchar(3) CHARACTER SET utf8 NOT NULL COMMENT 'Groep',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`naam`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='gebruikers Tabel' AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `naam`, `wachtwoord`, `rechten`, `groep`) VALUES
(1, 'Admin', 'sha1:64000:18:uRHXJLT5+Mh/Bv1gNZgac/dkaUqg0ybe:OH2QfIjk+htOBUQJ8aDLtRZf', '3', '1');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groep`
--

CREATE TABLE IF NOT EXISTS `groep` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user` text COLLATE utf8_bin NOT NULL COMMENT 'user id',
  `naam` tinytext COLLATE utf8_bin NOT NULL COMMENT 'groepnaam',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Groep Tabel' AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `groep`
--

INSERT INTO `groep` (`id`, `user`, `naam`) VALUES
(1, '1', 'Admin');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_sessions`
--

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fingerprint` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `data` text COLLATE latin1_general_ci,
  `access` int(32) NOT NULL DEFAULT '0',
  `date` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
