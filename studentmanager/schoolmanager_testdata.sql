-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 jul 2024 om 13:05
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolmanager`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mentors`
--

CREATE TABLE `mentors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Mentors table';

--
-- Gegevens worden geëxporteerd voor tabel `mentors`
--

INSERT INTO `mentors` (`id`, `first_name`, `last_name`, `dob`, `email`, `phone`) VALUES
(4, 'Annelies de Boer', '', '1980-03-01', 'annelies.deboer@example.com', '06 - 12345678'),
(5, 'Peter van Dijk', '', '1975-06-10', 'peter.vandijk@example.com', '06-23456789'),
(6, 'Fatima El Amrani', '', '1982-09-05', 'elamrani@example.com', '06-34567890'),
(7, 'Dennis Nieuw', '', '1988-12-12', 'dbr@dbrf.com', '02490324234');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schoolclasses`
--

CREATE TABLE `schoolclasses` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `year` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Schoolclasses table';

--
-- Gegevens worden geëxporteerd voor tabel `schoolclasses`
--

INSERT INTO `schoolclasses` (`id`, `name`, `year`, `mentor_id`) VALUES
(1, '1A', 1, 7),
(2, '2B', 2, 5),
(3, '3C', 3, 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schooldata`
--

CREATE TABLE `schooldata` (
  `name` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `schooldata`
--

INSERT INTO `schooldata` (`name`, `city`, `phone`, `email`) VALUES
('OSG Piter Jelles', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Students table';

--
-- Gegevens worden geëxporteerd voor tabel `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `dob`, `email`, `phone`, `class_id`) VALUES
(114, 'Jan de Vries', '', '2005-01-10', 'jan.devres@example.com', '06-12345678', 1),
(115, 'Lisa Jansen', '', '2005-03-05', 'lisa.jansen@example.com', '06-23456789', 1),
(116, 'Mohammed Ali', '', '2004-05-15', 'mohammed.ali@example.com', '06-34567890', 1),
(117, 'Emma van Dijk', '', '2005-08-20', 'emma.vandijk@example.com', '06-45678901', 1),
(118, 'Luca Bakker', '', '2004-12-03', 'luca.bakker@example.com', '06-56789012', 1),
(119, 'Sophie de Jong', '', '2005-07-18', 'sophie.dejong@example.com', '06-67890123', 2),
(120, 'Daan Visser', '', '2004-09-22', 'daan.visser@example.com', '06-78901234', 2),
(121, 'Anna Hendriks', '', '2005-06-09', 'anna.hendriks@example.com', '06-89012345', 2),
(122, 'Thomas Kuijpers', '', '2004-02-14', 'thomas.kuijpers@example.com', '06-90123456', 2),
(123, 'Evi Meijer', '', '2004-10-30', 'evi.meijer@example.com', '06-01234567', 2),
(124, 'Sem van der Meer', '', '2005-11-07', 'sem.vandermeer@example.com', '06-11223344', 3),
(125, 'Zoë Peters', '', '2004-04-25', 'zoe.peters@example.com', '06-22334455', 3),
(126, 'Timo Smit', '', '2005-12-12', 'timo.smit@example.com', '06-33445566', 3),
(127, 'Femke de Boer', '', '2004-09-28', 'femke.deboer@example.com', '06-44556677', 3),
(128, 'Ruben van Leeuwen', '', '2005-01-08', 'ruben.vanleeuwen@example.com', '06-55667788', 1),
(129, 'Dennis Bronk', '', '1989-12-01', 'dennis@bronk-ict.nl', '0640872193', -1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `schoolclasses`
--
ALTER TABLE `schoolclasses`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `schoolclasses`
--
ALTER TABLE `schoolclasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
