-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.28-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dump della struttura di tabella banca.bonifici
CREATE TABLE IF NOT EXISTS `bonifici` (
  `IDContoDestinatario` int(11) NOT NULL,
  `IDContoMittente` int(11) NOT NULL,
  `SommaDenaro` decimal(10,2) NOT NULL,
  `IDBonifico` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDBonifico`),
  KEY `FK_bonifici_conticorrenti` (`IDContoDestinatario`),
  KEY `FK_bonifici_conticorrenti_2` (`IDContoMittente`),
  CONSTRAINT `FK_bonifici_conticorrenti` FOREIGN KEY (`IDContoDestinatario`) REFERENCES `conticorrenti` (`NumeroConto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_bonifici_conticorrenti_2` FOREIGN KEY (`IDContoMittente`) REFERENCES `conticorrenti` (`NumeroConto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella banca.bonifici: ~0 rows (circa)

-- Dump della struttura di tabella banca.conticorrenti
CREATE TABLE IF NOT EXISTS `conticorrenti` (
  `NumeroConto` int(11) NOT NULL AUTO_INCREMENT,
  `IDUtente` int(11) NOT NULL,
  `Saldo` decimal(20,2) DEFAULT 0.00,
  PRIMARY KEY (`NumeroConto`),
  KEY `FK_conticorrenti_utenti` (`IDUtente`),
  CONSTRAINT `FK_conticorrenti_utenti` FOREIGN KEY (`IDUtente`) REFERENCES `utenti` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella banca.conticorrenti: ~0 rows (circa)

-- Dump della struttura di tabella banca.transazioni
CREATE TABLE IF NOT EXISTS `transazioni` (
  `IDTransazione` int(11) NOT NULL AUTO_INCREMENT,
  `NumeroConto` int(11) NOT NULL,
  `Importo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `DataTransazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `TipoTransazione` enum('Deposito','Prelievo') NOT NULL,
  PRIMARY KEY (`IDTransazione`),
  KEY `FK_transazioni_conticorrenti` (`NumeroConto`),
  CONSTRAINT `FK_transazioni_conticorrenti` FOREIGN KEY (`NumeroConto`) REFERENCES `conticorrenti` (`NumeroConto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella banca.transazioni: ~0 rows (circa)

-- Dump della struttura di tabella banca.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  `Cognome` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella banca.utenti: ~0 rows (circa)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;