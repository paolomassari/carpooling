-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 03, 2022 alle 21:14
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdt`
--
CREATE DATABASE IF NOT EXISTS `bdt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bdt`;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `idcategoria` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`idcategoria`, `nome`) VALUES
(1, 'riparazioni'),
(2, 'elettriche'),
(3, 'idrauliche'),
(4, 'lezioni_scuola');

-- --------------------------------------------------------

--
-- Struttura della tabella `esperti`
--

CREATE TABLE `esperti` (
  `idesperto` int(11) NOT NULL,
  `idsocio` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `prestazioni`
--

CREATE TABLE `prestazioni` (
  `idprestazione` int(11) NOT NULL,
  `descrizione` varchar(20) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idsocioda` int(11) NOT NULL,
  `idsocioa` int(11) NOT NULL,
  `monteore` int(11) NOT NULL,
  `dataprestazione` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `soci`
--

CREATE TABLE `soci` (
  `idsocio` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `monteore` int(11) NOT NULL,
  `idzona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `zone`
--

CREATE TABLE `zone` (
  `idzona` int(11) NOT NULL,
  `descrizione` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indici per le tabelle `esperti`
--
ALTER TABLE `esperti`
  ADD PRIMARY KEY (`idesperto`),
  ADD KEY `e1` (`idcategoria`),
  ADD KEY `e2` (`idsocio`);

--
-- Indici per le tabelle `prestazioni`
--
ALTER TABLE `prestazioni`
  ADD PRIMARY KEY (`idprestazione`),
  ADD KEY `p1` (`idcategoria`),
  ADD KEY `p2` (`idsocioda`),
  ADD KEY `p3` (`idsocioa`);

--
-- Indici per le tabelle `soci`
--
ALTER TABLE `soci`
  ADD PRIMARY KEY (`idsocio`),
  ADD KEY `s1` (`idzona`);

--
-- Indici per le tabelle `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`idzona`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `esperti`
--
ALTER TABLE `esperti`
  MODIFY `idesperto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prestazioni`
--
ALTER TABLE `prestazioni`
  MODIFY `idprestazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `soci`
--
ALTER TABLE `soci`
  MODIFY `idsocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `esperti`
--
ALTER TABLE `esperti`
  ADD CONSTRAINT `e1` FOREIGN KEY (`idcategoria`) REFERENCES `categorie` (`idcategoria`),
  ADD CONSTRAINT `e2` FOREIGN KEY (`idsocio`) REFERENCES `soci` (`idsocio`);

--
-- Limiti per la tabella `prestazioni`
--
ALTER TABLE `prestazioni`
  ADD CONSTRAINT `p1` FOREIGN KEY (`idcategoria`) REFERENCES `categorie` (`idcategoria`),
  ADD CONSTRAINT `p2` FOREIGN KEY (`idsocioda`) REFERENCES `soci` (`idsocio`),
  ADD CONSTRAINT `p3` FOREIGN KEY (`idsocioa`) REFERENCES `soci` (`idsocio`);

--
-- Limiti per la tabella `soci`
--
ALTER TABLE `soci`
  ADD CONSTRAINT `s1` FOREIGN KEY (`idzona`) REFERENCES `zone` (`idzona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
