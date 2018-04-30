-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: shareddb1d.hosting.stackcp.net
-- Creato il: Ott 26, 2017 alle 09:43
-- Versione del server: 10.1.14-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officina-3137abd2`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ACTIVITIES`
--

CREATE TABLE `ACTIVITIES` (
  `ID` int(11) NOT NULL,
  `LABEL` varchar(255) NOT NULL,
  `TIMESTRAP` datetime DEFAULT NULL,
  `USERID` int(10) DEFAULT NULL,
  `IP_ADDRESS` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ASSIGNED_JOBS`
--

CREATE TABLE `ASSIGNED_JOBS` (
  `ID` int(11) NOT NULL,
  `JOB_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ASSIGNED_AT` date NOT NULL,
  `PRIORITY` int(11) NOT NULL,
  `REMOVED_AT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `JOBS`
--

CREATE TABLE `JOBS` (
  `ID` int(11) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `NOTE` varchar(255) NOT NULL,
  `CREATED_AT` date NOT NULL,
  `UPDATED_AT` date DEFAULT NULL,
  `OPENED_AT` date DEFAULT NULL,
  `CLOSED_AT` date DEFAULT NULL,
  `ESTIMATED_TIME` int(11) NOT NULL,
  `DELIVERY` date NOT NULL,
  `WORKED_HOURS` int(10) DEFAULT '0',
  `PRIORITY` int(10) DEFAULT '0',
  `STATUS` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `JOBS_ACTIVITIES`
--

CREATE TABLE `JOBS_ACTIVITIES` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `ASSIGNED_JOB_ID` int(11) NOT NULL,
  `CREATD_AT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `JOBS_TIME`
--

CREATE TABLE `JOBS_TIME` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `JOB_ACTIVITY_ID` int(11) NOT NULL,
  `TIME` int(10) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `USERS`
--

CREATE TABLE `USERS` (
  `ID` int(10) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `ACCESS` date NOT NULL,
  `LEVEL_ID` int(11) NOT NULL,
  `ISWORKING` int(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ACTIVITIES`
--
ALTER TABLE `ACTIVITIES`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `ASSIGNED_JOBS`
--
ALTER TABLE `ASSIGNED_JOBS`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `JOBS`
--
ALTER TABLE `JOBS`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `JOBS_ACTIVITIES`
--
ALTER TABLE `JOBS_ACTIVITIES`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `JOBS_TIME`
--
ALTER TABLE `JOBS_TIME`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `ACTIVITIES`
--
ALTER TABLE `ACTIVITIES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT per la tabella `ASSIGNED_JOBS`
--
ALTER TABLE `ASSIGNED_JOBS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `JOBS`
--
ALTER TABLE `JOBS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `JOBS_ACTIVITIES`
--
ALTER TABLE `JOBS_ACTIVITIES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `JOBS_TIME`
--
ALTER TABLE `JOBS_TIME`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `USERS`
--
ALTER TABLE `USERS`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
