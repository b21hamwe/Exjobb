-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 10 maj 2024 kl 14:15
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `exjobb`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `bok`
--

CREATE TABLE `bok` (
  `id` int(11) NOT NULL,
  `boktitel` varchar(50) DEFAULT NULL,
  `omslag` varchar(15) DEFAULT NULL,
  `författarId` int(11) DEFAULT NULL,
  `bokserieId` int(11) DEFAULT NULL,
  `inledningstext` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `bokserie`
--

CREATE TABLE `bokserie` (
  `id` int(11) NOT NULL,
  `serietitel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `författare`
--

CREATE TABLE `författare` (
  `id` int(11) NOT NULL,
  `namn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `bok`
--
ALTER TABLE `bok`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `bokserie`
--
ALTER TABLE `bokserie`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `författare`
--
ALTER TABLE `författare`
  ADD PRIMARY KEY (`namn`) USING BTREE,
  

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
