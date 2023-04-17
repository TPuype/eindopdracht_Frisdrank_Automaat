-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220623.a68b47d354
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 sep 2022 om 10:54
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frisdrank`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dranken`
--

CREATE TABLE `dranken` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` float NOT NULL,
  `aantal` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `dranken`
--

INSERT INTO `dranken` (`id`, `naam`, `prijs`, `aantal`, `img`) VALUES
(1, 'Coca-Cola', 2, 8, 'img/cola.jpg'),
(2, 'Fanta', 1.6, 0, 'img/fanta.jpg'),
(3, 'Sprite', 1.8, 6, 'img/sprite.jpg'),
(4, 'Iced-Tea', 1.7, 15, 'img/icetea.jpg'),
(5, 'Canada Dry', 2, 17, 'img/canadadry.jpg'),
(6, 'Cécémel', 2, 19, 'img/cecemel.jpg'),
(7, 'Red Bull', 2, 10, 'img/redbull.jpg'),
(8, 'Dr Pepper', 1.8, 10, 'img/thegooddoctor.jpg'),
(9, 'Schweppes', 2, 3, 'img/schweppes.jpg'),
(10, 'Jupiler', 2.2, 12, 'img/jupiler.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kassa`
--

CREATE TABLE `kassa` (
  `muntId` int(11) NOT NULL,
  `aantal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `kassa`
--

INSERT INTO `kassa` (`muntId`, `aantal`) VALUES
(1, 2),
(2, 0),
(3, 0),
(4, 0),
(5, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `valuta`
--

CREATE TABLE `valuta` (
  `id` int(11) NOT NULL,
  `munt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `valuta`
--

INSERT INTO `valuta` (`id`, `munt`) VALUES
(1, 2),
(2, 1),
(3, 0.5),
(4, 0.2),
(5, 0.1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `dranken`
--
ALTER TABLE `dranken`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `kassa`
--
ALTER TABLE `kassa`
  ADD PRIMARY KEY (`muntId`);

--
-- Indexen voor tabel `valuta`
--
ALTER TABLE `valuta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `dranken`
--
ALTER TABLE `dranken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `kassa`
--
ALTER TABLE `kassa`
  MODIFY `muntId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `valuta`
--
ALTER TABLE `valuta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



