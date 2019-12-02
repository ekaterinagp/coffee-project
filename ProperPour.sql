-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2019 at 09:49 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE IF NOT EXISTS `ProperPour`;
USE `ProperPour`;
--
-- Database: `properpour`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `purchaseTransaction` (IN `pnProductID` MEDIUMINT, IN `pnCreditCardID` MEDIUMINT)  NO SQL
BEGIN


DECLARE vnTaxAmount DECIMAL(4,2);
DECLARE vnPrice DECIMAL(4,2);
DECLARE vnCreditCardID INT;
DECLARE vnUserID INT;
DECLARE vnUserTotalPurchaseAmount DECIMAL(18,4);
DECLARE vnCreditCardTotalPurchaseAmount DECIMAL(18,4);

SELECT nPrice  
	into vnPrice 
    FROM tproduct 
    WHERE pnProductID = nProductID;
    
SELECT  nUserID
	INTO vnUserID
    FROM tcreditcard
    WHERE pnCreditCardID = nCreditCardID;
    
SELECT tproduct.nPrice * 0.25
	INTO vnTaxAmount 
	FROM tproduct
   WHERE pnProductID = nProductID;


START TRANSACTION;
	INSERT INTO tpurchase( 
        nPurchaseID,
        nProductId,
        dPurchase,
        nNetAmount,
        nTax,
        nCreditCardID)
        
 	VALUES(
        DEFAULT,
        pnProductID,
        CURRENT_TIMESTAMP(),
        vnPrice,
        vnTaxAmount,
       	pnCreditCardID);
        
  
 UPDATE tcreditcard 
	SET nTotalPurchaseAmount = nTotalPurchaseAmount+vnPrice
 	WHERE nCreditCardID=pnCreditCardID; 
   
  
	UPDATE tproduct
  	SET nStock = nStock-1
    WHERE nProductID = pnProductID;
  

COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setDeleteDate` (IN `vnUserId` INT(50))  NO SQL
BEGIN

UPDATE tuser
	SET dDeleteUser= CURRENT_TIMESTAMP()
    WHERE tuser.nUserID=vcUserID;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tauditcreditcard`
--

CREATE TABLE `tauditcreditcard` (
  `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL,
  `nOldCreditCardID` mediumint(8) UNSIGNED DEFAULT NULL,
  `nOldUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldIBAN` char(18) DEFAULT NULL,
  `cOldExpiration` char(4) DEFAULT NULL,
  `cOldCCV` char(3) DEFAULT NULL,
  `nOldTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `nNewCreditCardID` mediumint(8) UNSIGNED DEFAULT NULL,
  `nNewUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewIBAN` char(18) DEFAULT NULL,
  `cNewExpiration` char(4) DEFAULT NULL,
  `cNewCCV` char(3) DEFAULT NULL,
  `nNewTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tauditcreditcard`
--

INSERT INTO `tauditcreditcard` (`nAuditCreditCardID`, `nOldCreditCardID`, `nOldUserID`, `cOldIBAN`, `cOldExpiration`, `cOldCCV`, `nOldTotalPurchaseAmount`, `nNewCreditCardID`, `nNewUserID`, `cNewIBAN`, `cNewExpiration`, `cNewCCV`, `nNewTotalPurchaseAmount`, `cAction`, `dTimestamp`, `cDBUser`, `cHost`) VALUES
(2, 3, 8, '123456781234567890', '12/2', '333', '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2019-12-02 16:29:01', 'root', 'localhost'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 4, 8, '123456781234555555', '04/2', '123', '0.0000', 'D', '2019-12-02 16:36:17', 'root', 'localhost'),
(4, 4, 8, '123456781234555555', '04/2', '123', '0.0000', 4, 8, '123456781234555555', '04/2', '124', '0.0000', 'D', '2019-12-02 16:36:26', 'root', 'localhost'),
(9, 4, 8, '123456781234555555', '04/2', '124', '0.0000', 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:12:17', 'root', 'localhost'),
(10, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', '50.0000', 'D', '2019-12-02 20:14:08', 'root', 'localhost'),
(11, 4, 8, '123456781234555555', '04/2', '124', '50.0000', 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:14:58', 'root', 'localhost'),
(12, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:19:12', 'root', 'localhost'),
(13, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:37:50', 'root', 'localhost'),
(14, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', '2.0000', 'D', '2019-12-02 20:38:44', 'root', 'localhost'),
(15, 4, 8, '123456781234555555', '04/2', '124', '2.0000', 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:39:00', 'root', 'localhost'),
(16, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:39:59', 'root', 'localhost'),
(17, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', NULL, 'D', '2019-12-02 20:41:13', 'root', 'localhost'),
(18, 4, 8, '123456781234555555', '04/2', '124', NULL, 4, 8, '123456781234555555', '04/2', '124', '20.0000', 'D', '2019-12-02 20:41:32', 'root', 'localhost'),
(19, 4, 8, '123456781234555555', '04/2', '124', '20.0000', 4, 8, '123456781234555555', '04/2', '124', '70.0000', 'D', '2019-12-02 20:41:40', 'root', 'localhost'),
(24, 4, 8, '123456781234555555', '04/2', '124', '70.0000', 4, 8, '123456781234555555', '04/2', '124', '120.0000', 'D', '2019-12-02 20:43:57', 'root', 'localhost'),
(26, 4, 8, '123456781234555555', '04/2', '124', '120.0000', 4, 8, '123456781234555555', '04/2', '124', '170.0000', 'D', '2019-12-02 20:45:50', 'root', 'localhost'),
(27, 4, 8, '123456781234555555', '04/2', '124', '170.0000', 4, 8, '123456781234555555', '04/2', '124', '220.0000', 'D', '2019-12-02 20:46:06', 'root', 'localhost'),
(29, 4, 8, '123456781234555555', '04/2', '124', '220.0000', 4, 8, '123456781234555555', '04/2', '124', '270.0000', 'D', '2019-12-02 20:49:12', 'root', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `tauditpurchase`
--

CREATE TABLE `tauditpurchase` (
  `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL,
  `nOldPurchaseID` int(11) DEFAULT NULL,
  `nOldProductID` mediumint(9) NOT NULL,
  `dOldPurchase` timestamp NULL DEFAULT NULL,
  `nOldNetAmount` decimal(4,2) DEFAULT NULL,
  `nOldTax` decimal(2,2) DEFAULT NULL,
  `nOldCreditCardID` mediumint(9) DEFAULT NULL,
  `nNewPurchaseID` int(11) DEFAULT NULL,
  `nNewProductID` mediumint(9) NOT NULL,
  `dNewPurchase` timestamp NULL DEFAULT NULL,
  `nNewNetAmount` decimal(4,2) DEFAULT NULL,
  `nNewTax` decimal(2,2) DEFAULT NULL,
  `nNewCreditCardID` mediumint(9) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimestamp` timestamp NULL DEFAULT NULL,
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tauditpurchase`
--

INSERT INTO `tauditpurchase` (`nAuditPurchaseID`, `nOldPurchaseID`, `nOldProductID`, `dOldPurchase`, `nOldNetAmount`, `nOldTax`, `nOldCreditCardID`, `nNewPurchaseID`, `nNewProductID`, `dNewPurchase`, `nNewNetAmount`, `nNewTax`, `nNewCreditCardID`, `cAction`, `dTimestamp`, `cDBUser`, `cHost`) VALUES
(1, NULL, 0, NULL, NULL, NULL, NULL, 2, 1, '2019-12-02 16:59:58', '50.00', '0.00', 4, 'D', '2019-12-02 16:59:58', 'root', 'localhost'),
(6, NULL, 0, NULL, NULL, NULL, NULL, 7, 1, '2019-12-02 19:54:07', '50.00', '0.99', 4, 'D', '2019-12-02 19:54:07', 'root', 'localhost'),
(7, NULL, 0, NULL, NULL, NULL, NULL, 8, 1, '2019-12-02 20:08:10', '50.00', '0.99', 4, 'D', '2019-12-02 20:08:10', 'root', 'localhost'),
(8, NULL, 0, NULL, NULL, NULL, NULL, 9, 2, '2019-12-02 20:10:29', '75.00', '0.99', 4, 'D', '2019-12-02 20:10:29', 'root', 'localhost'),
(9, NULL, 0, NULL, NULL, NULL, NULL, 10, 1, '2019-12-02 20:11:29', '50.00', '0.99', 4, 'D', '2019-12-02 20:11:29', 'root', 'localhost'),
(10, 7, 1, '2019-12-02 19:54:07', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:11:40', 'root', 'localhost'),
(11, 8, 1, '2019-12-02 20:08:10', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:11:42', 'root', 'localhost'),
(12, NULL, 0, NULL, NULL, NULL, NULL, 11, 1, '2019-12-02 20:12:17', '50.00', '0.99', 4, 'D', '2019-12-02 20:12:17', 'root', 'localhost'),
(13, NULL, 0, NULL, NULL, NULL, NULL, 12, 1, '2019-12-02 20:14:58', '50.00', '0.99', 4, 'D', '2019-12-02 20:14:58', 'root', 'localhost'),
(14, NULL, 0, NULL, NULL, NULL, NULL, 13, 1, '2019-12-02 20:19:12', '50.00', '0.99', 4, 'D', '2019-12-02 20:19:12', 'root', 'localhost'),
(17, NULL, 0, NULL, NULL, NULL, NULL, 16, 2, '2019-12-02 20:32:18', '75.00', '0.99', 4, 'D', '2019-12-02 20:32:18', 'root', 'localhost'),
(18, 9, 2, '2019-12-02 20:10:29', '75.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:33:21', 'root', 'localhost'),
(19, 10, 1, '2019-12-02 20:11:29', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:33:23', 'root', 'localhost'),
(20, 11, 1, '2019-12-02 20:12:17', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:33:25', 'root', 'localhost'),
(21, NULL, 0, NULL, NULL, NULL, NULL, 18, 2, '2019-12-02 20:33:46', '75.00', '0.99', 4, 'D', '2019-12-02 20:33:46', 'root', 'localhost'),
(23, NULL, 0, NULL, NULL, NULL, NULL, 20, 1, '2019-12-02 20:34:38', '50.00', '0.99', 4, 'D', '2019-12-02 20:34:38', 'root', 'localhost'),
(24, NULL, 0, NULL, NULL, NULL, NULL, 21, 1, '2019-12-02 20:35:07', '50.00', '0.99', 4, 'D', '2019-12-02 20:35:07', 'root', 'localhost'),
(25, 21, 1, '2019-12-02 20:35:07', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:15', 'root', 'localhost'),
(26, 20, 1, '2019-12-02 20:34:38', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:18', 'root', 'localhost'),
(27, 18, 2, '2019-12-02 20:33:46', '75.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:20', 'root', 'localhost'),
(28, 12, 1, '2019-12-02 20:14:58', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:53', 'root', 'localhost'),
(29, 13, 1, '2019-12-02 20:19:12', '50.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:55', 'root', 'localhost'),
(30, 16, 2, '2019-12-02 20:32:18', '75.00', '0.99', 4, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-02 20:35:56', 'root', 'localhost'),
(31, NULL, 0, NULL, NULL, NULL, NULL, 22, 1, '2019-12-02 20:36:04', '50.00', '0.99', 4, 'D', '2019-12-02 20:36:04', 'root', 'localhost'),
(32, NULL, 0, NULL, NULL, NULL, NULL, 23, 2, '2019-12-02 20:36:22', '75.00', '0.99', 4, 'D', '2019-12-02 20:36:22', 'root', 'localhost'),
(33, NULL, 0, NULL, NULL, NULL, NULL, 24, 1, '2019-12-02 20:37:50', '50.00', '0.99', 4, 'D', '2019-12-02 20:37:50', 'root', 'localhost'),
(34, NULL, 0, NULL, NULL, NULL, NULL, 25, 1, '2019-12-02 20:39:00', '50.00', '0.99', 4, 'D', '2019-12-02 20:39:00', 'root', 'localhost'),
(35, NULL, 0, NULL, NULL, NULL, NULL, 26, 1, '2019-12-02 20:39:59', '50.00', '0.99', 4, 'D', '2019-12-02 20:39:59', 'root', 'localhost'),
(36, NULL, 0, NULL, NULL, NULL, NULL, 27, 1, '2019-12-02 20:41:13', '50.00', '0.99', 4, 'D', '2019-12-02 20:41:13', 'root', 'localhost'),
(37, NULL, 0, NULL, NULL, NULL, NULL, 28, 1, '2019-12-02 20:41:40', '50.00', '0.99', 4, 'D', '2019-12-02 20:41:40', 'root', 'localhost'),
(42, NULL, 0, NULL, NULL, NULL, NULL, 33, 1, '2019-12-02 20:43:57', '50.00', '0.99', 4, 'D', '2019-12-02 20:43:57', 'root', 'localhost'),
(44, NULL, 0, NULL, NULL, NULL, NULL, 35, 1, '2019-12-02 20:45:50', '50.00', '0.99', 4, 'D', '2019-12-02 20:45:50', 'root', 'localhost'),
(45, NULL, 0, NULL, NULL, NULL, NULL, 36, 1, '2019-12-02 20:46:06', '50.00', '0.99', 4, 'D', '2019-12-02 20:46:06', 'root', 'localhost'),
(47, NULL, 0, NULL, NULL, NULL, NULL, 38, 1, '2019-12-02 20:49:12', '50.00', '0.99', 4, 'D', '2019-12-02 20:49:12', 'root', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `taudituser`
--

CREATE TABLE `taudituser` (
  `nAuditUserID` bigint(20) UNSIGNED NOT NULL,
  `nOldUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldName` varchar(50) DEFAULT NULL,
  `cOldSurname` varchar(50) DEFAULT NULL,
  `cOldEmail` varchar(255) DEFAULT NULL,
  `cOldUsername` varchar(30) DEFAULT NULL,
  `cOldPassword` char(56) DEFAULT NULL,
  `cOldAddress` varchar(255) DEFAULT NULL,
  `nOldCityID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldPhoneNo` char(8) DEFAULT NULL,
  `dOldNewUser` date DEFAULT NULL,
  `dOldDeleteUser` date DEFAULT NULL,
  `nOldTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `nNewUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewName` varchar(50) DEFAULT NULL,
  `cNewSurname` varchar(50) DEFAULT NULL,
  `cNewEmail` varchar(255) DEFAULT NULL,
  `cNewUsername` varchar(30) DEFAULT NULL,
  `cNewPassword` char(56) DEFAULT NULL,
  `cNewAddress` varchar(255) DEFAULT NULL,
  `nNewCityID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewPhoneNo` char(8) DEFAULT NULL,
  `dNewNewUser` date DEFAULT NULL,
  `dNewDeleteUser` date DEFAULT NULL,
  `nNewTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taudituser`
--

INSERT INTO `taudituser` (`nAuditUserID`, `nOldUserID`, `cOldName`, `cOldSurname`, `cOldEmail`, `cOldUsername`, `cOldPassword`, `cOldAddress`, `nOldCityID`, `cOldPhoneNo`, `dOldNewUser`, `dOldDeleteUser`, `nOldTotalPurchaseAmount`, `nNewUserID`, `cNewName`, `cNewSurname`, `cNewEmail`, `cNewUsername`, `cNewPassword`, `cNewAddress`, `nNewCityID`, `cNewPhoneNo`, `dNewNewUser`, `dNewDeleteUser`, `nNewTotalPurchaseAmount`, `cAction`, `dTimeStamp`, `cDBUser`, `cHost`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00', NULL, '0.0000', 'D', '2019-12-02 16:25:59', 'root', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `tcity`
--

CREATE TABLE `tcity` (
  `nCityID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcity`
--

INSERT INTO `tcity` (`nCityID`, `cName`) VALUES
(1, 'Copenhagen');

-- --------------------------------------------------------

--
-- Table structure for table `tcoffeetype`
--

CREATE TABLE `tcoffeetype` (
  `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcoffeetype`
--

INSERT INTO `tcoffeetype` (`nCoffeeTypeID`, `cName`) VALUES
(1, 'Guatemala');

-- --------------------------------------------------------

--
-- Table structure for table `tcreditcard`
--

CREATE TABLE `tcreditcard` (
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL,
  `cIBAN` char(18) NOT NULL,
  `cExpiration` char(4) NOT NULL,
  `cCCV` char(3) NOT NULL,
  `nTotalPurchaseAmount` decimal(18,4) DEFAULT 0.0000,
  `nUserID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcreditcard`
--

INSERT INTO `tcreditcard` (`nCreditCardID`, `cIBAN`, `cExpiration`, `cCCV`, `nTotalPurchaseAmount`, `nUserID`) VALUES
(4, '123456781234555555', '04/2', '124', '270.0000', 8);

--
-- Triggers `tcreditcard`
--
DELIMITER $$
CREATE TRIGGER `trgDeleteCreditCard` BEFORE DELETE ON `tcreditcard` FOR EACH ROW BEGIN
	INSERT INTO tauditcreditcard 
    	(nOldCreditCardID, 
         cOldIban,
         cOldExpiration,
         cOldCCV,
         nOldTotalPurchaseAmount,
         nOldUserID,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (old.nCreditCardID,
             old.cIban,
             old.cExpiration, 
             old.cCCV,
             old.nTotalPurchaseAmount,
             old.nUserID, 
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgInsertCreditCard` AFTER INSERT ON `tcreditcard` FOR EACH ROW BEGIN
	INSERT INTO tauditcreditcard 
    	(nNewCreditCardID, 
         cNewIban,
         cNewExpiration,
         cNewCCV,
         nNewTotalPurchaseAmount,
         nNewUserID,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (new.nCreditCardID,
             new.cIban,
             new.cExpiration, 
             new.cCCV,
             new.nTotalPurchaseAmount,
             new.nUserID, 
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgUpdateCreditCard` AFTER UPDATE ON `tcreditcard` FOR EACH ROW BEGIN
	INSERT INTO tauditcreditcard 
    	(nOldCreditCardID, 
         cOldIban,
         cOldExpiration,
         cOldCCV,
         nOldTotalPurchaseAmount,
         nOldUserID,
         nNewCreditCardID, 
         cNewIban,
         cNewExpiration,
         cNewCCV,
         nNewTotalPurchaseAmount,
         nNewUserID,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (old.nCreditCardID,
             old.cIban,
             old.cExpiration, 
             old.cCCV,
             old.nTotalPurchaseAmount,
             old.nUserID, 
             new.nCreditCardID,
             new.cIban,
             new.cExpiration, 
             new.cCCV,
             new.nTotalPurchaseAmount,
             new.nUserID, 
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tproduct`
--

CREATE TABLE `tproduct` (
  `nProductID` int(10) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL,
  `nPrice` decimal(4,2) NOT NULL DEFAULT 0.00,
  `nStock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tproduct`
--

INSERT INTO `tproduct` (`nProductID`, `cName`, `nCoffeeTypeID`, `nPrice`, `nStock`) VALUES
(1, 'The Coffee', 1, '50.00', 7),
(2, 'Greater Goods', 1, '75.00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tpurchase`
--

CREATE TABLE `tpurchase` (
  `nPurchaseID` int(8) UNSIGNED NOT NULL,
  `nProductID` int(10) UNSIGNED NOT NULL,
  `dPurchase` timestamp NOT NULL DEFAULT current_timestamp(),
  `nNetAmount` decimal(4,2) NOT NULL,
  `nTax` decimal(4,2) NOT NULL,
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpurchase`
--

INSERT INTO `tpurchase` (`nPurchaseID`, `nProductID`, `dPurchase`, `nNetAmount`, `nTax`, `nCreditCardID`) VALUES
(22, 1, '2019-12-02 20:36:04', '50.00', '12.50', 4),
(23, 2, '2019-12-02 20:36:22', '75.00', '18.75', 4),
(24, 1, '2019-12-02 20:37:50', '50.00', '12.50', 4),
(25, 1, '2019-12-02 20:39:00', '50.00', '12.50', 4),
(26, 1, '2019-12-02 20:39:59', '50.00', '12.50', 4),
(27, 1, '2019-12-02 20:41:13', '50.00', '12.50', 4),
(28, 1, '2019-12-02 20:41:40', '50.00', '12.50', 4),
(33, 1, '2019-12-02 20:43:57', '50.00', '12.50', 4),
(35, 1, '2019-12-02 20:45:50', '50.00', '12.50', 4),
(36, 1, '2019-12-02 20:46:06', '50.00', '12.50', 4),
(38, 1, '2019-12-02 20:49:12', '50.00', '12.50', 4);

--
-- Triggers `tpurchase`
--
DELIMITER $$
CREATE TRIGGER `trgDeletePurchase` AFTER DELETE ON `tpurchase` FOR EACH ROW BEGIN 

INSERT INTO tauditpurchase(
    nOldProductID,
    nOldPurchaseID,
    dOldPurchase,
    nOldNetAmount,
    nOldTax,
    nOldCreditCardID,
    cAction,
    dTimestamp,
    cDBUser,
    cHost)
  VALUES(
      old.nProductID,
    old.nPurchaseID,
    old.dPurchase,
    old.nNetAmount,
    old.nTax,
    old.nCreditCardID,
    'D', 
    CURRENT_TIMESTAMP(),
    SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 			       SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgInsertPurchase` AFTER INSERT ON `tpurchase` FOR EACH ROW BEGIN 

INSERT INTO tauditpurchase(
    nNewProductID,
    nNewPurchaseID,
    dNewPurchase,
    nNewNetAmount,
    nNewTax,
    nNewCreditCardID,
    cAction,
    dTimestamp,
    cDBUser,
    cHost)
  VALUES(
      new.nProductID,
    new.nPurchaseID,
    new.dPurchase,
    new.nNetAmount,
    new.nTax,
    new.nCreditCardID,
    'D', 
    CURRENT_TIMESTAMP(),
    SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 			       SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgUpdatePurchase` AFTER UPDATE ON `tpurchase` FOR EACH ROW BEGIN 

INSERT INTO tauditpurchase(
    nOldProductID,
    nOldPurchaseID,
    dOldPurchase,
    nOldNetAmount,
    nOldTax,
    nOldCreditCardID,
     nNewProductID,
    nNewPurchaseID,
    dNewPurchase,
    nNewNetAmount,
    nNewTax,
    nNewCreditCardID,
    cAction,
    dTimestamp,
    cDBUser,
    cHost)
  VALUES(
      new.nProductID,
    new.nPurchaseID,
    new.dPurchase,
    new.nNetAmount,
    new.nTax,
    new.nCreditCardID,
    old.nProductID,
    old.nPurchaseID,
    old.dPurchase,
    old.nNetAmount,
    old.nTax,
    old.nCreditCardID,
    'D', 
    CURRENT_TIMESTAMP(),
    SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 			       SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tsubscriptionpurchase`
--

CREATE TABLE `tsubscriptionpurchase` (
  `nUserSubscriptionID` int(10) UNSIGNED NOT NULL,
  `nPurchaseID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tsubscriptiontype`
--

CREATE TABLE `tsubscriptiontype` (
  `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL,
  `nProductID` int(10) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `nQuantity` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tuser`
--

CREATE TABLE `tuser` (
  `nUserID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `cSurname` varchar(50) NOT NULL,
  `cEmail` varchar(255) NOT NULL,
  `cUsername` varchar(30) NOT NULL,
  `cPassword` char(56) NOT NULL,
  `cAddress` varchar(255) NOT NULL,
  `nCityID` mediumint(9) UNSIGNED NOT NULL,
  `cPhoneNo` char(8) NOT NULL,
  `dNewUser` timestamp NOT NULL DEFAULT current_timestamp(),
  `dDeleteUser` date DEFAULT NULL,
  `nTotalPurchaseAmount` decimal(18,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tuser`
--

INSERT INTO `tuser` (`nUserID`, `cName`, `cSurname`, `cEmail`, `cUsername`, `cPassword`, `cAddress`, `nCityID`, `cPhoneNo`, `dNewUser`, `dDeleteUser`, `nTotalPurchaseAmount`) VALUES
(8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '0.0000');

--
-- Triggers `tuser`
--
DELIMITER $$
CREATE TRIGGER `hashPassword` BEFORE INSERT ON `tuser` FOR EACH ROW BEGIN
 SET NEW.cPassword = SHA2(NEW.cPassword,224);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgDeleteUser` AFTER DELETE ON `tuser` FOR EACH ROW BEGIN
	INSERT INTO taudituser
    	(nOldUserID, 
         cOldName,
         cOldSurname,
         cOldEmail,
         cOldUsername,
         cOldPassword,
         cOldAddress,
         nOldCityID,
         cOldPhoneNo,
         dOldNewUser,
         dOldDeleteUser,
         nOldTotalPurchaseAmount,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (old.nUserID, 
         old.cName,
         old.cSurname,
         old.cEmail,
         old.cUsername,
         old.cPassword,
         old.cAddress,
         old.nCityID,
         old.cPhoneNo,
         old.dNewUser,
         old.dDeleteUser,
         old.nTotalPurchaseAmount,
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgInsertUser` AFTER INSERT ON `tuser` FOR EACH ROW BEGIN
	INSERT INTO taudituser
    	(nNewUserID, 
         cNewName,
         cNewSurname,
         cNewEmail,
         cNewUsername,
         cNewPassword,
         cNewAddress,
         nNewCityID,
         cNewPhoneNo,
         dNewNewUser,
         dNewDeleteUser,
         nNewTotalPurchaseAmount,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (new.nUserID, 
         new.cName,
         new.cSurname,
         new.cEmail,
         new.cUsername,
         new.cPassword,
         new.cAddress,
         new.nCityID,
         new.cPhoneNo,
         new.dNewUser,
         new.dDeleteUser,
         new.nTotalPurchaseAmount,
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgUpdateUser` AFTER UPDATE ON `tuser` FOR EACH ROW BEGIN
	INSERT INTO taudituser
    	(nOldUserID, 
         cOldName,
         cOldSurname,
         cOldEmail,
         cOldUsername,
         cOldPassword,
         cOldAddress,
         nOldCityID,
         cOldPhoneNo,
         dOldNewUser,
         dOldDeleteUser,
         nOldTotalPurchaseAmount,
         nNewUserID, 
         cNewName,
         cNewSurname,
         cNewEmail,
         cNewUsername,
         cNewPassword,
         cNewAddress,
         nNewCityID,
         cNewPhoneNo,
         dNewNewUser,
         dNewDeleteUser,
         nNewTotalPurchaseAmount,
         cAction,
         dTimestamp,
         cDBUser,
         cHost
        )
     VALUES (
         old.cName,
         old.cSurname,
         old.cEmail,
         old.cUsername,
         old.cPassword,
         old.cAddress,
         old.nCityID,
         old.cPhoneNo,
         old.dNewUser,
         old.dDeleteUser,
         old.nTotalPurchaseAmount,
         new.nUserID, 
         new.cName,
         new.cSurname,
         new.cEmail,
         new.cUsername,
         new.cPassword,
         new.cAddress,
         new.nCityID,
         new.cPhoneNo,
         new.dNewUser,
         new.dDeleteUser,
         new.nTotalPurchaseAmount,
             'D', 
             CURRENT_TIMESTAMP(),
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 				SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
            );
     
     END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tusersubscription`
--

CREATE TABLE `tusersubscription` (
  `nUserSubscriptionID` int(8) UNSIGNED NOT NULL,
  `nUserID` mediumint(8) UNSIGNED NOT NULL,
  `dSubscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `dCancellation` date DEFAULT NULL,
  `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tauditcreditcard`
--
ALTER TABLE `tauditcreditcard`
  ADD PRIMARY KEY (`nAuditCreditCardID`);

--
-- Indexes for table `tauditpurchase`
--
ALTER TABLE `tauditpurchase`
  ADD PRIMARY KEY (`nAuditPurchaseID`);

--
-- Indexes for table `taudituser`
--
ALTER TABLE `taudituser`
  ADD PRIMARY KEY (`nAuditUserID`);

--
-- Indexes for table `tcity`
--
ALTER TABLE `tcity`
  ADD PRIMARY KEY (`nCityID`);

--
-- Indexes for table `tcoffeetype`
--
ALTER TABLE `tcoffeetype`
  ADD PRIMARY KEY (`nCoffeeTypeID`);

--
-- Indexes for table `tcreditcard`
--
ALTER TABLE `tcreditcard`
  ADD PRIMARY KEY (`nCreditCardID`),
  ADD KEY `nUserID` (`nUserID`);

--
-- Indexes for table `tproduct`
--
ALTER TABLE `tproduct`
  ADD PRIMARY KEY (`nProductID`),
  ADD KEY `nCoffeeTypeID` (`nCoffeeTypeID`);

--
-- Indexes for table `tpurchase`
--
ALTER TABLE `tpurchase`
  ADD PRIMARY KEY (`nPurchaseID`),
  ADD KEY `nProductID` (`nProductID`),
  ADD KEY `nCreditCardID` (`nCreditCardID`);

--
-- Indexes for table `tsubscriptionpurchase`
--
ALTER TABLE `tsubscriptionpurchase`
  ADD PRIMARY KEY (`nUserSubscriptionID`,`nPurchaseID`),
  ADD KEY `nPurchaseID` (`nPurchaseID`),
  ADD KEY `nUserSubscriptionID` (`nUserSubscriptionID`) USING BTREE;

--
-- Indexes for table `tsubscriptiontype`
--
ALTER TABLE `tsubscriptiontype`
  ADD PRIMARY KEY (`nSubscriptionTypeID`),
  ADD KEY `nProductID` (`nProductID`);

--
-- Indexes for table `tuser`
--
ALTER TABLE `tuser`
  ADD PRIMARY KEY (`nUserID`),
  ADD KEY `nCityID` (`nCityID`);

--
-- Indexes for table `tusersubscription`
--
ALTER TABLE `tusersubscription`
  ADD PRIMARY KEY (`nUserSubscriptionID`),
  ADD KEY `nUserID` (`nUserID`),
  ADD KEY `nSubscriptionTypeID` (`nSubscriptionTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tauditcreditcard`
--
ALTER TABLE `tauditcreditcard`
  MODIFY `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tauditpurchase`
--
ALTER TABLE `tauditpurchase`
  MODIFY `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `taudituser`
--
ALTER TABLE `taudituser`
  MODIFY `nAuditUserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tcity`
--
ALTER TABLE `tcity`
  MODIFY `nCityID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tcoffeetype`
--
ALTER TABLE `tcoffeetype`
  MODIFY `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tcreditcard`
--
ALTER TABLE `tcreditcard`
  MODIFY `nCreditCardID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tproduct`
--
ALTER TABLE `tproduct`
  MODIFY `nProductID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tpurchase`
--
ALTER TABLE `tpurchase`
  MODIFY `nPurchaseID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tsubscriptiontype`
--
ALTER TABLE `tsubscriptiontype`
  MODIFY `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `nUserID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tusersubscription`
--
ALTER TABLE `tusersubscription`
  MODIFY `nUserSubscriptionID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tcreditcard`
--
ALTER TABLE `tcreditcard`
  ADD CONSTRAINT `tcreditcard_ibfk_1` FOREIGN KEY (`nUserID`) REFERENCES `tuser` (`nUserID`);

--
-- Constraints for table `tproduct`
--
ALTER TABLE `tproduct`
  ADD CONSTRAINT `tproduct_ibfk_1` FOREIGN KEY (`nCoffeeTypeID`) REFERENCES `tcoffeetype` (`nCoffeeTypeID`);

--
-- Constraints for table `tpurchase`
--
ALTER TABLE `tpurchase`
  ADD CONSTRAINT `tpurchase_ibfk_1` FOREIGN KEY (`nProductID`) REFERENCES `tproduct` (`nProductID`),
  ADD CONSTRAINT `tpurchase_ibfk_2` FOREIGN KEY (`nCreditCardID`) REFERENCES `tcreditcard` (`nCreditCardID`);

--
-- Constraints for table `tsubscriptionpurchase`
--
ALTER TABLE `tsubscriptionpurchase`
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_1` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `tusersubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_2` FOREIGN KEY (`nPurchaseID`) REFERENCES `tpurchase` (`nPurchaseID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_3` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `tusersubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_4` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `tusersubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_5` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `tusersubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_6` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `tusersubscription` (`nUserSubscriptionID`);

--
-- Constraints for table `tsubscriptiontype`
--
ALTER TABLE `tsubscriptiontype`
  ADD CONSTRAINT `tsubscriptiontype_ibfk_1` FOREIGN KEY (`nProductID`) REFERENCES `tproduct` (`nProductID`);

--
-- Constraints for table `tuser`
--
ALTER TABLE `tuser`
  ADD CONSTRAINT `tuser_ibfk_1` FOREIGN KEY (`nCityID`) REFERENCES `tcity` (`nCityID`);

--
-- Constraints for table `tusersubscription`
--
ALTER TABLE `tusersubscription`
  ADD CONSTRAINT `tusersubscription_ibfk_1` FOREIGN KEY (`nUserID`) REFERENCES `tuser` (`nUserID`),
  ADD CONSTRAINT `tusersubscription_ibfk_2` FOREIGN KEY (`nSubscriptionTypeID`) REFERENCES `tsubscriptiontype` (`nSubscriptionTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
