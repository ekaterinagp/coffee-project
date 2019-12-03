-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2019 at 09:39 AM
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

--
-- Database: `properpour`
--
CREATE DATABASE IF NOT EXISTS `properpour` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `properpour`;

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
(33, NULL, NULL, NULL, NULL, NULL, NULL, 6, 9, '123456781234567890', '12/2', '123', '0.0000', 'I', '2019-12-03 08:36:05', 'root', 'localhost'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, 7, 10, '4555400091110086', '06/2', '888', '0.0000', 'I', '2019-12-03 08:36:49', 'root', 'localhost'),
(35, 6, 9, '123456781234567890', '12/2', '123', '0.0000', 6, 9, '123456781234567890', '12/2', '123', '50.0000', 'U', '2019-12-03 08:37:30', 'root', 'localhost');

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
(59, NULL, 0, NULL, NULL, NULL, NULL, 40, 1, '2019-12-03 08:37:30', '50.00', '0.99', 6, 'I', '2019-12-03 08:37:30', 'root', 'localhost');

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
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00', NULL, '0.0000', 'I', '2019-12-02 16:25:59', 'root', 'localhost'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-02', NULL, '0.0000', 'I', '2019-12-02 22:01:45', 'root', 'localhost'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-02', NULL, '0.0000', 'I', '2019-12-02 22:02:39', 'root', 'localhost'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 'Pippi', 'Langstromp', 'langstromp@yahoo.com', 'pippi', '03dfe83128ab8c6f0b6406a887f58b8d87b139c5cf040db96e891424', 'Lygten 16, 2400', 1, '43434343', '2019-12-02', NULL, '0.0000', 'I', '2019-12-02 22:14:02', 'root', 'localhost');

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
(1, 'Copenhagen'),
(2, 'Roskilde'),
(3, 'Århus');

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
(1, 'Guatemala'),
(2, 'Ethiopia'),
(3, 'Sumatra'),
(4, 'Brazil'),
(5, 'Nicaragua'),
(6, 'Kenya');

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
(6, '123456781234567890', '12/2', '123', '50.0000', 9),
(7, '4555400091110086', '06/2', '888', '0.0000', 10);

--
-- Triggers `tcreditcard`
--
DELIMITER $$
CREATE TRIGGER `trgDeleteCreditCard` AFTER DELETE ON `tcreditcard` FOR EACH ROW BEGIN
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
             'I', 
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
             'U', 
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
(1, 'The Coffee', 1, '50.00', 6),
(2, 'Greater Goods', 1, '75.00', 10),
(3, 'Hugo Melo', 2, '20.00', 200);

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
(40, 1, '2019-12-03 08:37:30', '50.00', '12.50', 6);

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
    'I', 
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
    'U', 
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
(8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '0.0000'),
(9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-02 22:01:45', NULL, '0.0000'),
(10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-02 22:02:39', NULL, '0.0000'),
(11, 'Pippi', 'Langstromp', 'langstromp@yahoo.com', 'pippi', '03dfe83128ab8c6f0b6406a887f58b8d87b139c5cf040db96e891424', 'Lygten 16, 2400', 1, '43434343', '2019-12-02 22:14:02', NULL, '0.0000');

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
             'I', 
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
             'U', 
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
  MODIFY `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tauditpurchase`
--
ALTER TABLE `tauditpurchase`
  MODIFY `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `taudituser`
--
ALTER TABLE `taudituser`
  MODIFY `nAuditUserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tcity`
--
ALTER TABLE `tcity`
  MODIFY `nCityID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tcoffeetype`
--
ALTER TABLE `tcoffeetype`
  MODIFY `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tcreditcard`
--
ALTER TABLE `tcreditcard`
  MODIFY `nCreditCardID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tproduct`
--
ALTER TABLE `tproduct`
  MODIFY `nProductID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tpurchase`
--
ALTER TABLE `tpurchase`
  MODIFY `nPurchaseID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tsubscriptiontype`
--
ALTER TABLE `tsubscriptiontype`
  MODIFY `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `nUserID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
