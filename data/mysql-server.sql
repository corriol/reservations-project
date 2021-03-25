-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Temps de generació: 25-03-2021 a les 18:17:29
-- Versió del servidor: 8.0.19
-- Versió de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `reservations`
--
CREATE DATABASE IF NOT EXISTS `reservations` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `reservations`;

-- --------------------------------------------------------

--
-- Estructura de la taula `court`
--

CREATE TABLE `court` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Bolcament de dades per a la taula `court`
--

INSERT INTO `court` (`id`, `name`) VALUES
(1, 'Multiesport'),
(2, 'Bàsquet'),
(3, 'Pàdel 2'),
(4, 'Pàdel 1'),
(5, 'Fútbol 7');

-- --------------------------------------------------------

--
-- Estructura de la taula `reservation`
--

CREATE TABLE `reservation` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `court_id` int NOT NULL,
  `timeslot_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Bolcament de dades per a la taula `reservation`
--

INSERT INTO `reservation` (`id`, `name`, `date`, `court_id`, `timeslot_id`) VALUES
(3, 'Artur Maians', '2020-11-27', 1, 1),
(5, 'Pere Malonda', '2020-11-27', 1, 4),
(8, 'Vicent', '2021-03-02', 1, 2),
(9, 'sadfasd fasdf asdf asdf asd', '2021-03-28', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de la taula `timeslot`
--

CREATE TABLE `timeslot` (
  `id` int NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Bolcament de dades per a la taula `timeslot`
--

INSERT INTO `timeslot` (`id`, `name`) VALUES
(1, '09:00'),
(2, '10:00'),
(3, '11:00'),
(4, '12:00');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_court_timeslot` (`date`,`court_id`,`timeslot_id`) USING BTREE,
  ADD KEY `court_id` (`court_id`),
  ADD KEY `timeslot_id` (`timeslot_id`) USING BTREE;

--
-- Índexs per a la taula `timeslot`
--
ALTER TABLE `timeslot`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `court`
--
ALTER TABLE `court`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la taula `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la taula `timeslot`
--
ALTER TABLE `timeslot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_court` FOREIGN KEY (`court_id`) REFERENCES `court` (`id`),
  ADD CONSTRAINT `reservation_timeslot` FOREIGN KEY (`timeslot_id`) REFERENCES `timeslot` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
