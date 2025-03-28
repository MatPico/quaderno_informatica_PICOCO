-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 16, 2025 alle 20:47
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
-- Database: `carpooling`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `autista`
--

CREATE TABLE `autista` (
  `id_autista` int(11) NOT NULL,
  `id_macchina` int(11) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cognome` varchar(50) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `numero_patente` varchar(20) DEFAULT NULL,
  `scadenza_patente` date DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ruolo` enum('autista','passeggero') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `macchina`
--

CREATE TABLE `macchina` (
  `id_macchina` int(11) NOT NULL,
  `colore` varchar(20) DEFAULT NULL,
  `modello` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `anno` year(4) DEFAULT NULL,
  `posti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `passeggero`
--

CREATE TABLE `passeggero` (
  `id_passeggero` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cognome` varchar(50) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `numero_carta_identita` varchar(20) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ruolo` enum('autista','passeggero') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `id_prenotazione` int(11) NOT NULL,
  `id_viaggio` int(11) DEFAULT NULL,
  `id_passeggero` int(11) DEFAULT NULL,
  `stato` enum('attiva','rifiutata','chiusa','cancellata') DEFAULT 'attiva'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `valutazione`
--

CREATE TABLE `valutazione` (
  `id_valutazione` int(11) NOT NULL,
  `id_autista` int(11) DEFAULT NULL,
  `id_passeggero` int(11) DEFAULT NULL,
  `voto` int(11) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `ruolo` enum('autista','passeggero') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `viaggio`
--

CREATE TABLE `viaggio` (
  `id_viaggio` int(11) NOT NULL,
  `id_autista` int(11) DEFAULT NULL,
  `citta_partenza` varchar(100) DEFAULT NULL,
  `citta_arrivo` varchar(100) DEFAULT NULL,
  `ora_partenza` datetime DEFAULT NULL,
  `ora_arrivo` datetime DEFAULT NULL,
  `tempo_stimato` time DEFAULT NULL,
  `contributo_economico` decimal(10,2) DEFAULT NULL,
  `max_posti` int(11) DEFAULT NULL,
  `stato` enum('attivo','chiuso','cancellato') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autista`
--
ALTER TABLE `autista`
  ADD PRIMARY KEY (`id_autista`);

--
-- Indici per le tabelle `macchina`
--
ALTER TABLE `macchina`
  ADD PRIMARY KEY (`id_macchina`);

--
-- Indici per le tabelle `passeggero`
--
ALTER TABLE `passeggero`
  ADD PRIMARY KEY (`id_passeggero`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`id_prenotazione`),
  ADD KEY `id_viaggio` (`id_viaggio`),
  ADD KEY `id_passeggero` (`id_passeggero`);

--
-- Indici per le tabelle `valutazione`
--
ALTER TABLE `valutazione`
  ADD PRIMARY KEY (`id_valutazione`),
  ADD KEY `id_autista` (`id_autista`),
  ADD KEY `id_passeggero` (`id_passeggero`);

--
-- Indici per le tabelle `viaggio`
--
ALTER TABLE `viaggio`
  ADD PRIMARY KEY (`id_viaggio`),
  ADD KEY `id_autista` (`id_autista`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `autista`
--
ALTER TABLE `autista`
  MODIFY `id_autista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `macchina`
--
ALTER TABLE `macchina`
  MODIFY `id_macchina` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `passeggero`
--
ALTER TABLE `passeggero`
  MODIFY `id_passeggero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `valutazione`
--
ALTER TABLE `valutazione`
  MODIFY `id_valutazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `viaggio`
--
ALTER TABLE `viaggio`
  MODIFY `id_viaggio` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggio` (`id_viaggio`),
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`id_passeggero`) REFERENCES `passeggero` (`id_passeggero`);

--
-- Limiti per la tabella `valutazione`
--
ALTER TABLE `valutazione`
  ADD CONSTRAINT `valutazione_ibfk_1` FOREIGN KEY (`id_autista`) REFERENCES `autista` (`id_autista`),
  ADD CONSTRAINT `valutazione_ibfk_2` FOREIGN KEY (`id_passeggero`) REFERENCES `passeggero` (`id_passeggero`);

--
-- Limiti per la tabella `viaggio`
--
ALTER TABLE `viaggio`
  ADD CONSTRAINT `viaggio_ibfk_1` FOREIGN KEY (`id_autista`) REFERENCES `autista` (`id_autista`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
