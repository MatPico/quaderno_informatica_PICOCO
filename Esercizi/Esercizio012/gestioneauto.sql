-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 27, 2025 alle 21:25
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestioneauto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `assicurazione`
--

CREATE TABLE `assicurazione` (
  `id_assicurazione` int(11) NOT NULL,
  `nome_compagnia` varchar(100) NOT NULL,
  `numero_polizza` varchar(50) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `targa_auto` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `auto`
--

CREATE TABLE `auto` (
  `targa` varchar(10) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modello` varchar(50) NOT NULL,
  `anno_immatricolazione` year(4) NOT NULL,
  `colore` varchar(30) DEFAULT NULL,
  `id_proprietario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `proprietario`
--

CREATE TABLE `proprietario` (
  `id_proprietario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `codice_fiscale` varchar(16) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `indirizzo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `assicurazione`
--
ALTER TABLE `assicurazione`
  ADD PRIMARY KEY (`id_assicurazione`),
  ADD UNIQUE KEY `numero_polizza` (`numero_polizza`),
  ADD KEY `targa_auto` (`targa_auto`);

--
-- Indici per le tabelle `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`targa`),
  ADD KEY `id_proprietario` (`id_proprietario`);

--
-- Indici per le tabelle `proprietario`
--
ALTER TABLE `proprietario`
  ADD PRIMARY KEY (`id_proprietario`),
  ADD UNIQUE KEY `codice_fiscale` (`codice_fiscale`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `assicurazione`
--
ALTER TABLE `assicurazione`
  MODIFY `id_assicurazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `proprietario`
--
ALTER TABLE `proprietario`
  MODIFY `id_proprietario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `assicurazione`
--
ALTER TABLE `assicurazione`
  ADD CONSTRAINT `assicurazione_ibfk_1` FOREIGN KEY (`targa_auto`) REFERENCES `auto` (`targa`) ON DELETE CASCADE;

--
-- Limiti per la tabella `auto`
--
ALTER TABLE `auto`
  ADD CONSTRAINT `auto_ibfk_1` FOREIGN KEY (`id_proprietario`) REFERENCES `proprietario` (`id_proprietario`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
