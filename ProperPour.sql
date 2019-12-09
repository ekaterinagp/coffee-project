-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2019 at 03:10 PM
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
DROP DATABASE IF EXISTS `properpour`;
CREATE DATABASE `properpour` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `properpour`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `purchaseSubscriptionTransaction` (IN `pnUserID` MEDIUMINT, IN `pnSubscriptionTypeID` MEDIUMINT, IN `pnCreditCardID` MEDIUMINT, IN `pnTaxAmount` DECIMAL(4,2))  NO SQL
BEGIN
 	
    DECLARE vnTaxAmount DECIMAL(4,2);
    DECLARE vnPrice DECIMAL(4,2);
    DECLARE vnProductID INT;
    DECLARE vnPurchaseID INT;
    DECLARE vnUserSubscriptionID INT;
    
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
   		SHOW ERRORS;
        ROLLBACK;  -- rollback any error in the transaction
    END;
    
   	START TRANSACTION;
       
   	SELECT tsubscriptiontype.nProductID, tproduct.nPrice 
      	INTO vnProductID, vnPrice
  		FROM tsubscriptiontype INNER JOIN tproduct ON
  		tsubscriptiontype.nProductID = tproduct.nProductID
  		 WHERE pnSubscriptionTypeID = tsubscriptiontype.nSubscriptionTypeID;   
    SELECT vnPrice * pnTaxAmount
        INTO vnTaxAmount 
        FROM tproduct
        WHERE vnProductID = nProductID;
        
        INSERT INTO tusersubscription(
                nUserSubscriptionID,
                nUserID,
                dSubscription,
                dCancellation,
                nSubscriptionTypeID
            )
            VALUES(
                DEFAULT,
                pnUserID,
                DEFAULT,
                DEFAULT,
                pnSubscriptionTypeID);
                
       	SET vnUserSubscriptionID=  LAST_INSERT_ID() ;
          
        INSERT INTO tpurchase( 
            nPurchaseID,
            nProductId,
            dPurchase,
            nNetAmount,
            nTax,
            nCreditCardID)        
        VALUES(
            DEFAULT,
            vnProductID,
            DEFAULT,
            vnPrice,
            vnTaxAmount,
            pnCreditCardID);
            
        SET vnPurchaseID = LAST_INSERT_ID();
                        
        INSERT INTO tsubscriptionpurchase(
                nUserSubscriptionID,
                nPurchaseID)
            VALUES(
                vnUserSubscriptionID,
            	vnPurchaseID);
                
    UPDATE tcreditcard 
        SET tcreditcard.nTotalPurchaseAmount = tcreditcard.nTotalPurchaseAmount+vnPrice+vnTaxAmount
        WHERE nCreditCardID=pnCreditCardID; 

     UPDATE tproduct
        SET tproduct.nStock = nStock-1
        WHERE nProductID = vnProductID;

      UPDATE tuser
        SET tuser.nTotalPurchaseAmount = tuser.nTotalPurchaseAmount+vnPrice+vnTaxAmount
        WHERE nUserID = pnUserID;
	
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `purchaseTransaction` (IN `pnProductID` INT, IN `pnCreditCardID` MEDIUMINT, IN `pnUserID` MEDIUMINT, IN `pnTaxAmount` DECIMAL(4,2))  NO SQL
BEGIN
 	
    DECLARE vnTaxAmount DECIMAL(4,2);
    DECLARE vnPrice DECIMAL(4,2);
   	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
   		SHOW ERRORS;
        ROLLBACK;  -- rollback any error in the transaction
    END;

    START TRANSACTION;

    SELECT nPrice  
        INTO vnPrice 
        FROM tproduct 
        WHERE pnProductID = nProductID;
        
    SELECT tproduct.nPrice * pnTaxAmount
        INTO vnTaxAmount 
        FROM tproduct
        WHERE pnProductID = nProductID;
               
     INSERT INTO tpurchase( 
            nProductId,
            nNetAmount,
            nTax,
            nCreditCardID)        
        VALUES(
            pnProductID,
            vnPrice,
            vnTaxAmount,
            pnCreditCardID);
                  
    UPDATE tcreditcard 
        SET tcreditcard.nTotalPurchaseAmount = tcreditcard.nTotalPurchaseAmount + vnPrice + vnTaxAmount
        WHERE nCreditCardID = pnCreditCardID; 
        
    UPDATE tproduct
        SET tproduct.nStock = nStock-1
        WHERE nProductID = pnProductID;
                
    UPDATE tuser
        SET tuser.nTotalPurchaseAmount = tuser.nTotalPurchaseAmount+vnPrice+vnTaxAmount
        WHERE nUserID = pnUserID;

	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setDeleteDateSubscription` (IN `pnUserSubscription` INT)  NO SQL
BEGIN

UPDATE tusersubscription
	SET dCancellation= CURRENT_TIMESTAMP()
    WHERE nUserSubscriptionID=pnUserSubscription;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setDeleteUserDate` (IN `pnUserId` INT(50))  NO SQL
BEGIN

UPDATE tuser
	SET dDeleteUser= CURRENT_TIMESTAMP()
    WHERE nUserID=pnUserId;

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
(35, 6, 9, '123456781234567890', '12/2', '123', '0.0000', 6, 9, '123456781234567890', '12/2', '123', '50.0000', 'U', '2019-12-03 08:37:30', 'root', 'localhost'),
(40, 6, 9, '123456781234567890', '12/2', '123', '50.0000', 6, 9, '123456781234567890', '12/2', '123', '112.5000', 'U', '2019-12-03 10:43:59', 'root', 'localhost'),
(41, 6, 9, '123456781234567890', '12/2', '123', '112.5000', 6, 9, '123456781234567890', '12/2', '123', '125.9900', 'U', '2019-12-03 10:57:00', 'root', 'localhost'),
(42, 6, 9, '123456781234567890', '12/2', '123', '125.9900', 6, 9, '123456781234567890', '12/2', '123', '176.9800', 'U', '2019-12-03 10:57:35', 'root', 'localhost'),
(43, 6, 9, '123456781234567890', '12/2', '123', '176.9800', 6, 9, '123456781234567890', '12/2', '123', '239.4800', 'U', '2019-12-03 10:58:41', 'root', 'localhost'),
(48, 7, 10, '4555400091110086', '06/2', '888', '0.0000', 7, 10, '4555400091110086', '06/2', '888', '62.5000', 'U', '2019-12-03 13:45:51', 'root', 'localhost'),
(49, 7, 10, '4555400091110086', '06/2', '888', '62.5000', 7, 10, '4555400091110086', '06/2', '888', '125.0000', 'U', '2019-12-03 13:47:40', 'root', 'localhost'),
(52, 7, 10, '4555400091110086', '06/2', '888', '125.0000', 7, 10, '4555400091110086', '06/2', '888', '187.5000', 'U', '2019-12-03 13:58:42', 'root', 'localhost'),
(53, 6, 9, '123456781234567890', '12/2', '123', '239.4800', 6, 9, '123456781234567890', '12/2', '123', '0.0000', 'U', '2019-12-03 14:00:35', 'root', 'localhost'),
(54, 7, 10, '4555400091110086', '06/2', '888', '187.5000', 7, 10, '4555400091110086', '06/2', '888', '187.0000', 'U', '2019-12-03 14:00:40', 'root', 'localhost'),
(55, 7, 10, '4555400091110086', '06/2', '888', '187.0000', 7, 10, '4555400091110086', '06/2', '888', '0.0000', 'U', '2019-12-03 14:00:48', 'root', 'localhost'),
(56, 7, 10, '4555400091110086', '06/2', '888', '0.0000', 7, 10, '4555400091110086', '06/2', '888', '62.5000', 'U', '2019-12-03 14:01:43', 'root', 'localhost'),
(57, 6, 9, '123456781234567890', '12/2', '123', '0.0000', 6, 9, '123456781234567890', '12/2', '123', '43.7500', 'U', '2019-12-05 08:59:31', 'root', 'localhost'),
(58, 6, 9, '123456781234567890', '12/2', '123', '43.7500', 6, 9, '123456781234567890', '12/2', '123', '62.9500', 'U', '2019-12-05 09:08:29', 'root', 'localhost'),
(69, 7, 10, '4555400091110086', '06/2', '888', '62.5000', 7, 10, '4555400091110086', '06/2', '888', '137.5000', 'U', '2019-12-07 17:15:17', 'root', 'localhost'),
(70, 7, 10, '4555400091110086', '06/2', '888', '137.5000', 7, 10, '4555400091110086', '06/2', '888', '221.8200', 'U', '2019-12-07 17:15:50', 'root', 'localhost'),
(72, NULL, NULL, NULL, NULL, NULL, NULL, 9, 24, '5656565656565656', '08/3', '345', '0.0000', 'I', '2019-12-07 17:21:50', 'root', 'localhost'),
(74, 9, 24, '5656565656565656', '08/3', '345', '0.0000', 9, 24, '5656565656565656', '08/3', '345', '55.8000', 'U', '2019-12-07 17:24:42', 'root', 'localhost'),
(75, 9, 24, '5656565656565656', '08/3', '345', '55.8000', 9, 24, '5656565656565656', '08/3', '345', '84.5500', 'U', '2019-12-07 17:26:37', 'root', 'localhost'),
(76, NULL, NULL, NULL, NULL, NULL, NULL, 10, 9, '12345678912345666', '01/3', '432', '0.0000', 'I', '2019-12-07 17:35:51', 'root', 'localhost'),
(77, 10, 9, '12345678912345666', '01/3', '432', '0.0000', 10, 9, '12345678912345666', '01/3', '432', '127.4900', 'U', '2019-12-07 17:36:31', 'root', 'localhost'),
(78, NULL, NULL, NULL, NULL, NULL, NULL, 11, 10, '123456781234560000', '08/3', '665', '0.0000', 'I', '2019-12-09 13:12:08', 'root', 'localhost'),
(79, NULL, NULL, NULL, NULL, NULL, NULL, 12, 24, '4555400091110099', '05/2', '987', '0.0000', 'I', '2019-12-09 13:12:36', 'root', 'localhost'),
(80, NULL, NULL, NULL, NULL, NULL, NULL, 13, 8, '123456789012345666', '01/2', '777', '0.0000', 'I', '2019-12-09 13:16:43', 'root', 'localhost'),
(81, NULL, NULL, NULL, NULL, NULL, NULL, 14, 8, '123456781234567777', '03/2', '876', '0.0000', 'I', '2019-12-09 13:17:22', 'root', 'localhost'),
(82, NULL, NULL, NULL, NULL, NULL, NULL, 15, 18, '123435781234567890', '01/3', '657', '0.0000', 'I', '2019-12-09 13:18:04', 'root', 'localhost'),
(83, NULL, NULL, NULL, NULL, NULL, NULL, 16, 18, '333456781234567890', '05/2', '432', '0.0000', 'I', '2019-12-09 13:18:24', 'root', 'localhost'),
(84, NULL, NULL, NULL, NULL, NULL, NULL, 17, 16, '125556781234567890', '07/2', '345', '0.0000', 'I', '2019-12-09 13:18:47', 'root', 'localhost'),
(85, NULL, NULL, NULL, NULL, NULL, NULL, 18, 16, '123486781234567890', '04/3', '243', '0.0000', 'I', '2019-12-09 13:19:21', 'root', 'localhost'),
(86, NULL, NULL, NULL, NULL, NULL, NULL, 19, 23, '123455581234567890', '12/3', '098', '0.0000', 'I', '2019-12-09 13:19:43', 'root', 'localhost'),
(87, NULL, NULL, NULL, NULL, NULL, NULL, 20, 23, '123456781234567777', '20/2', '443', '0.0000', 'I', '2019-12-09 13:20:14', 'root', 'localhost'),
(88, NULL, NULL, NULL, NULL, NULL, NULL, 21, 15, '123456781234567788', '07/3', '990', '0.0000', 'I', '2019-12-09 13:21:09', 'root', 'localhost'),
(89, NULL, NULL, NULL, NULL, NULL, NULL, 22, 15, '123456781237767890', '06/5', '890', '0.0000', 'I', '2019-12-09 13:22:23', 'root', 'localhost'),
(90, NULL, NULL, NULL, NULL, NULL, NULL, 23, 26, '123456781234561111', '08/2', '554', '0.0000', 'I', '2019-12-09 13:22:52', 'root', 'localhost'),
(91, NULL, NULL, NULL, NULL, NULL, NULL, 24, 26, '123456999234567890', '09/2', '767', '0.0000', 'I', '2019-12-09 13:23:41', 'root', 'localhost'),
(92, NULL, NULL, NULL, NULL, NULL, NULL, 25, 21, '123456333234567890', '02/2', '090', '0.0000', 'I', '2019-12-09 13:24:20', 'root', 'localhost'),
(93, NULL, NULL, NULL, NULL, NULL, NULL, 26, 21, '123393981234567890', '11/2', '656', '0.0000', 'I', '2019-12-09 13:25:07', 'root', 'localhost'),
(96, 12, 24, '4555400091110099', '05/2', '987', '0.0000', 12, 24, '4555400091110099', '05/2', '987', '55.0000', 'U', '2019-12-09 13:44:39', 'root', 'localhost'),
(97, 12, 24, '4555400091110099', '05/2', '987', '55.0000', 12, 24, '4555400091110099', '05/2', '987', '83.7500', 'U', '2019-12-09 13:47:35', 'root', 'localhost'),
(98, 12, 24, '4555400091110099', '05/2', '987', '83.7500', 12, 24, '4555400091110099', '05/2', '987', '138.7500', 'U', '2019-12-09 13:47:54', 'root', 'localhost'),
(99, 12, 24, '4555400091110099', '05/2', '987', '138.7500', 12, 24, '4555400091110099', '05/2', '987', '213.7500', 'U', '2019-12-09 13:49:47', 'root', 'localhost'),
(100, 13, 8, '123456789012345666', '01/2', '777', '0.0000', 13, 8, '123456789012345666', '01/2', '777', '85.0000', 'U', '2019-12-09 13:51:37', 'root', 'localhost'),
(101, 16, 18, '333456781234567890', '05/2', '432', '0.0000', 16, 18, '333456781234567890', '05/2', '432', '68.0000', 'U', '2019-12-09 13:52:29', 'root', 'localhost'),
(102, 15, 18, '123435781234567890', '01/3', '657', '0.0000', 15, 18, '123435781234567890', '01/3', '657', '43.7500', 'U', '2019-12-09 14:05:29', 'root', 'localhost'),
(103, 14, 8, '123456781234567777', '03/2', '876', '0.0000', 14, 8, '123456781234567777', '03/2', '876', '28.7500', 'U', '2019-12-09 14:09:06', 'root', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `tauditpurchase`
--

CREATE TABLE `tauditpurchase` (
  `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL,
  `nOldPurchaseID` int(11) DEFAULT NULL,
  `nOldProductID` mediumint(9) DEFAULT NULL,
  `dOldPurchase` timestamp NULL DEFAULT NULL,
  `nOldNetAmount` decimal(5,2) DEFAULT NULL,
  `nOldTax` decimal(4,2) DEFAULT NULL,
  `nOldCreditCardID` mediumint(9) DEFAULT NULL,
  `nNewPurchaseID` int(11) DEFAULT NULL,
  `nNewProductID` mediumint(9) DEFAULT NULL,
  `dNewPurchase` timestamp NULL DEFAULT NULL,
  `nNewNetAmount` decimal(5,2) DEFAULT NULL,
  `nNewTax` decimal(4,2) DEFAULT NULL,
  `nNewCreditCardID` mediumint(9) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimestamp` timestamp NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tauditpurchase`
--

INSERT INTO `tauditpurchase` (`nAuditPurchaseID`, `nOldPurchaseID`, `nOldProductID`, `dOldPurchase`, `nOldNetAmount`, `nOldTax`, `nOldCreditCardID`, `nNewPurchaseID`, `nNewProductID`, `dNewPurchase`, `nNewNetAmount`, `nNewTax`, `nNewCreditCardID`, `cAction`, `dTimestamp`, `cDBUser`, `cHost`) VALUES
(59, NULL, 0, NULL, NULL, NULL, NULL, 40, 1, '2019-12-03 08:37:30', '50.00', '0.99', 6, 'I', '2019-12-03 08:37:30', 'root', 'localhost'),
(66, NULL, 0, NULL, NULL, NULL, NULL, 47, 1, '2019-12-03 10:43:59', '50.00', '0.99', 6, 'I', '2019-12-03 10:43:59', 'root', 'localhost'),
(67, NULL, 0, NULL, NULL, NULL, NULL, 48, 1, '2019-12-03 10:57:00', '0.99', '0.99', 6, 'I', '2019-12-03 10:57:00', 'root', 'localhost'),
(68, 48, 1, '2019-12-03 10:57:00', '0.99', '0.99', 6, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 10:57:16', 'root', 'localhost'),
(69, NULL, 0, NULL, NULL, NULL, NULL, 49, 1, '2019-12-03 10:57:35', '50.00', '0.99', 6, 'I', '2019-12-03 10:57:35', 'root', 'localhost'),
(70, NULL, 0, NULL, NULL, NULL, NULL, 50, 1, '2019-12-03 10:58:41', '50.00', '0.99', 6, 'I', '2019-12-03 10:58:41', 'root', 'localhost'),
(76, NULL, 0, NULL, NULL, NULL, NULL, 56, 1, '2019-12-03 13:45:51', '50.00', '0.99', 7, 'I', '2019-12-03 13:45:51', 'root', 'localhost'),
(77, NULL, 0, NULL, NULL, NULL, NULL, 57, 1, '2019-12-03 13:47:40', '50.00', '0.99', 7, 'I', '2019-12-03 13:47:40', 'root', 'localhost'),
(80, NULL, 0, NULL, NULL, NULL, NULL, 60, 1, '2019-12-03 13:58:42', '50.00', '0.99', 7, 'I', '2019-12-03 13:58:42', 'root', 'localhost'),
(81, 40, 1, '2019-12-03 08:37:30', '50.00', '0.99', 6, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:53', 'root', 'localhost'),
(82, 47, 1, '2019-12-03 10:43:59', '50.00', '0.99', 6, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:55', 'root', 'localhost'),
(83, 49, 1, '2019-12-03 10:57:35', '50.00', '0.99', 6, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:55', 'root', 'localhost'),
(84, 50, 1, '2019-12-03 10:58:41', '50.00', '0.99', 6, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:56', 'root', 'localhost'),
(85, 56, 1, '2019-12-03 13:45:51', '50.00', '0.99', 7, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:56', 'root', 'localhost'),
(86, 57, 1, '2019-12-03 13:47:40', '50.00', '0.99', 7, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:57', 'root', 'localhost'),
(87, 60, 1, '2019-12-03 13:58:42', '50.00', '0.99', 7, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-03 14:00:58', 'root', 'localhost'),
(88, NULL, 0, NULL, NULL, NULL, NULL, 61, 1, '2019-12-03 14:01:43', '50.00', '0.99', 7, 'I', '2019-12-03 14:01:43', 'root', 'localhost'),
(89, NULL, 0, NULL, NULL, NULL, NULL, 62, 4, '2019-12-05 08:59:31', '35.00', '8.75', 6, 'I', '2019-12-05 08:59:31', 'root', 'localhost'),
(90, NULL, 0, NULL, NULL, NULL, NULL, 63, 5, '2019-12-05 09:08:29', '12.00', '7.20', 6, 'I', '2019-12-05 09:08:29', 'root', 'localhost'),
(99, NULL, 0, NULL, NULL, NULL, NULL, 67, 1, '2019-12-07 17:06:07', '1.00', '1.00', 7, 'I', '2019-12-07 17:06:07', 'root', 'localhost'),
(100, 67, 1, '2019-12-07 17:06:07', '1.00', '1.00', 7, NULL, 0, NULL, NULL, NULL, NULL, 'D', '2019-12-07 17:06:45', 'root', 'localhost'),
(103, NULL, 0, NULL, NULL, NULL, NULL, 70, 10, '2019-12-07 17:12:22', '55.00', '13.75', 7, 'I', '2019-12-07 17:12:22', 'root', 'localhost'),
(104, NULL, NULL, NULL, NULL, NULL, NULL, 71, 6, '2019-12-07 17:15:17', '60.00', '15.00', 7, 'I', '2019-12-07 17:15:17', 'root', 'localhost'),
(105, NULL, NULL, NULL, NULL, NULL, NULL, 72, 5, '2019-12-07 17:15:50', '68.00', '16.32', 7, 'I', '2019-12-07 17:15:50', 'root', 'localhost'),
(108, NULL, NULL, NULL, NULL, NULL, NULL, 76, 8, '2019-12-07 17:24:42', '45.00', '10.80', 9, 'I', '2019-12-07 17:24:42', 'root', 'localhost'),
(109, NULL, NULL, NULL, NULL, NULL, NULL, 77, 1, '2019-12-07 17:26:37', '23.00', '5.75', 9, 'I', '2019-12-07 17:26:37', 'root', 'localhost'),
(110, NULL, NULL, NULL, NULL, NULL, NULL, 78, 3, '2019-12-07 17:36:31', '99.99', '27.50', 10, 'I', '2019-12-07 17:36:31', 'root', 'localhost'),
(113, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, '2019-12-09 13:44:39', '44.00', '11.00', 12, 'I', '2019-12-09 13:44:39', 'root', 'localhost'),
(114, NULL, NULL, NULL, NULL, NULL, NULL, 80, 1, '2019-12-09 13:47:35', '23.00', '5.75', 12, 'I', '2019-12-09 13:47:35', 'root', 'localhost'),
(115, NULL, NULL, NULL, NULL, NULL, NULL, 81, 2, '2019-12-09 13:47:54', '44.00', '11.00', 12, 'I', '2019-12-09 13:47:54', 'root', 'localhost'),
(116, NULL, NULL, NULL, NULL, NULL, NULL, 82, 6, '2019-12-09 13:49:47', '60.00', '15.00', 12, 'I', '2019-12-09 13:49:47', 'root', 'localhost'),
(117, NULL, NULL, NULL, NULL, NULL, NULL, 83, 5, '2019-12-09 13:51:37', '68.00', '17.00', 13, 'I', '2019-12-09 13:51:37', 'root', 'localhost'),
(118, NULL, NULL, NULL, NULL, NULL, NULL, 84, 5, '2019-12-09 13:52:29', '68.00', '0.00', 16, 'I', '2019-12-09 13:52:29', 'root', 'localhost'),
(119, NULL, NULL, NULL, NULL, NULL, NULL, 85, 4, '2019-12-09 14:05:29', '35.00', '8.75', 15, 'I', '2019-12-09 14:05:29', 'root', 'localhost'),
(120, NULL, NULL, NULL, NULL, NULL, NULL, 86, 1, '2019-12-09 14:09:06', '23.00', '5.75', 14, 'I', '2019-12-09 14:09:06', 'root', 'localhost');

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
  `dOldNewUser` timestamp NULL DEFAULT NULL,
  `dOldDeleteUser` timestamp NULL DEFAULT NULL,
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
  `dNewNewUser` timestamp NULL DEFAULT NULL,
  `dNewDeleteUser` timestamp NULL DEFAULT NULL,
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
(0, 9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-01 23:00:00', NULL, '0.0000', 9, NULL, 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-01 23:00:00', NULL, '43.7500', 'U', '2019-12-05 08:59:31', 'root', 'localhost'),
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '0.0000', 'I', '2019-12-02 16:25:59', 'root', 'localhost'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-01 23:00:00', NULL, '0.0000', 'I', '2019-12-02 22:01:45', 'root', 'localhost'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '0.0000', 'I', '2019-12-02 22:02:39', 'root', 'localhost'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 'Pippi', 'Langstromp', 'langstromp@yahoo.com', 'pippi', '03dfe83128ab8c6f0b6406a887f58b8d87b139c5cf040db96e891424', 'Lygten 16, 2400', 1, '43434343', '2019-12-01 23:00:00', NULL, '0.0000', 'I', '2019-12-02 22:14:02', 'root', 'localhost'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, 'Allan', 'Tostrup', 'tostrup@gmail', 'tostr', '079a32e16994cf4c8fcf2de227ccf26990d913b013c60c2e4eef4945', 'Guldbergsgade 120, 2400', 1, '1234599', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:49:32', 'root', 'localhost'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 'Maria', 'Marense', 'masense@gmail', 'marense', 'c0f41139453b47880ce6757d3f3b5e69722625dd4e0b2d834a0aeaed', 'Rosengade 55, 2800', 3, '45454545', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:50:58', 'root', 'localhost'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 'Mike', 'Mikeson', 'mm@mail.com', 'mikeson', 'fb984f4bad7bc64f56f67744cd2dd869ca84968ab620b1d615b724bb', 'Carlsbergsvej 120', 2, '12344321', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:52:04', 'root', 'localhost'),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 'Lisa', 'Larsen', 'lars@gmail.com', 'lars', 'f67ec754183f332e47f97eb3997ba917da5adca443f41e5be2614f18', 'Jagtvej 564, 2100', 1, '87654321', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:52:50', 'root', 'localhost'),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, 'Raleigh', 'Tyson', 'tyson@yahoo.com', 'tyson', '1bb4b2fcb1ebd6d9de87cfff5e8c78c67bb17ef1981d0356afc27000', 'Lyngybej 120, 2800', 1, '76767676', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:53:44', 'root', 'localhost'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 'Sophie', 'Jensen', 'jense@gmail.com', 'sohje', '1d46523873c515fe0303257388bcffb4b32a369ddd79c62a04746744', 'Jensengade 44, 7904', 3, '66778899', '2019-12-02 23:00:00', NULL, '0.0000', 'I', '2019-12-03 10:54:48', 'root', 'localhost'),
(11, 10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '125.0000', 10, NULL, 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '187.5000', 'U', '2019-12-03 13:58:42', 'root', 'localhost'),
(12, 10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '187.5000', 10, NULL, 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '0.0000', 'U', '2019-12-03 14:01:29', 'root', 'localhost'),
(13, 10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '0.0000', 10, NULL, 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-01 23:00:00', NULL, '62.5000', 'U', '2019-12-03 14:01:43', 'root', 'localhost'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 18, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:03:57', 'root', 'localhost'),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:04:35', 'root', 'localhost'),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:05:24', 'root', 'localhost'),
(17, 20, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-03 23:00:00', NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2019-12-04 12:05:34', 'root', 'localhost'),
(18, 19, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-03 23:00:00', NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2019-12-04 12:05:43', 'root', 'localhost'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 'Don', 'Jens', 'jens@don.dk', 'donJens', 'bbd2eaa465a570feed6a0f368550b9da88f89194f29466c649920dab', 'Randersvej,12 1234 Randers', 3, '11556438', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:30:04', 'root', 'localhost'),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, 'Elisabet', 'Coolish', 'cool@cool.com', 'eli', '302c401c2dfb70269d43b24504cb80baad56564f91633a0392001444', 'Ryparken, 11 2100 København', 2, '34563456', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:40:42', 'root', 'localhost'),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 'Eleanor', 'Coolish', 'cool@cool.dk', 'eler', '302c401c2dfb70269d43b24504cb80baad56564f91633a0392001444', 'Ryparken 13 2100 København', 2, '34563456', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:41:58', 'root', 'localhost'),
(22, 22, 'Elisabet', 'Coolish', 'cool@cool.com', 'eli', '302c401c2dfb70269d43b24504cb80baad56564f91633a0392001444', 'Ryparken, 11 2100 København', 2, '34563456', '2019-12-03 23:00:00', NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2019-12-04 12:42:25', 'root', 'localhost'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, 'Nina', 'Ricci', 'nina@gmail.com', 'ninaRich', '43f648533b07a340a204b8a9504c75aa457ddc5180209d01aad571e0', 'Coolvej, 14 2387 Nestved', 5, '37809754', '2019-12-03 23:00:00', NULL, '0.0000', 'I', '2019-12-04 12:45:37', 'root', 'localhost'),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 'TEst', 'test', 'test', 'test', '227a85d5903ded14be5bf67cce0eb95295b120142e4358efcb2ad279', 'test', 6, '12345678', '2019-12-06 23:00:00', NULL, '0.0000', 'I', '2019-12-07 17:19:21', 'root', 'localhost'),
(25, 25, 'TEst', 'test', 'test', 'test', '227a85d5903ded14be5bf67cce0eb95295b120142e4358efcb2ad279', 'test', 6, '12345678', '2019-12-06 23:00:00', NULL, '0.0000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2019-12-07 17:19:48', 'root', 'localhost'),
(26, 9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-02 22:01:45', NULL, '43.7500', 9, NULL, 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-02 22:01:45', NULL, '171.2400', 'U', '2019-12-07 17:36:31', 'root', 'localhost'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'Jens', 'Jakobsen', 'jakob@gmail.com', 'jensssss', '7e6a4309ddf6e8866679f61ace4f621b0e3455ebac2e831a60f13cd1', 'Ulvej 156, 2100', 15, '12345699', '2019-12-09 11:55:21', NULL, '0.0000', 'I', '2019-12-09 11:55:21', 'root', 'localhost'),
(28, 24, 'Nina', 'Ricci', 'nina@gmail.com', 'ninaRich', '43f648533b07a340a204b8a9504c75aa457ddc5180209d01aad571e0', 'Coolvej, 14 2387 Nestved', 5, '37809754', '2019-12-04 12:45:37', NULL, '223.3000', 24, NULL, 'Ricci', 'nina@gmail.com', 'ninaRich', '43f648533b07a340a204b8a9504c75aa457ddc5180209d01aad571e0', 'Coolvej, 14 2387 Nestved', 5, '37809754', '2019-12-04 12:45:37', NULL, '298.3000', 'U', '2019-12-09 13:49:48', 'root', 'localhost'),
(29, 8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '0.0000', 8, NULL, 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '85.0000', 'U', '2019-12-09 13:51:37', 'root', 'localhost'),
(30, 18, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-04 12:03:57', NULL, '0.0000', 18, NULL, 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-04 12:03:57', NULL, '68.0000', 'U', '2019-12-09 13:52:29', 'root', 'localhost'),
(31, 18, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-04 12:03:57', NULL, '68.0000', 18, NULL, 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-04 12:03:57', NULL, '111.7500', 'U', '2019-12-09 14:05:29', 'root', 'localhost'),
(32, 8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '85.0000', 8, NULL, 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '113.7500', 'U', '2019-12-09 14:09:06', 'root', 'localhost');

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
(2, 'Århus'),
(3, 'Odense'),
(4, 'Roskilde'),
(5, 'Lyngby'),
(6, 'Aalborg'),
(7, 'Silkeborg'),
(8, 'Ballerup'),
(9, 'Hellerup'),
(10, 'Holte'),
(11, 'Horsens'),
(12, 'Randers'),
(13, 'Sønderborg'),
(14, 'Helsingør'),
(15, 'Dragør'),
(16, 'Charlottenlund'),
(17, 'Frederiksberg'),
(18, 'Valby'),
(19, 'Whateverby'),
(20, 'Herlev'),
(21, 'Vanløse');

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
(1, 'Colombia'),
(2, 'Ethiopia'),
(3, 'Sumatra'),
(4, 'Brazil'),
(5, 'Nicaragua'),
(6, 'Blend');

-- --------------------------------------------------------

--
-- Table structure for table `tcreditcard`
--

CREATE TABLE `tcreditcard` (
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL,
  `cIBAN` char(18) NOT NULL,
  `cExpiration` char(4) NOT NULL,
  `cCCV` char(3) NOT NULL,
  `nTotalPurchaseAmount` decimal(18,4) NOT NULL DEFAULT 0.0000,
  `nUserID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tcreditcard`
--

INSERT INTO `tcreditcard` (`nCreditCardID`, `cIBAN`, `cExpiration`, `cCCV`, `nTotalPurchaseAmount`, `nUserID`) VALUES
(6, '123456781234567890', '12/2', '123', '62.9500', 9),
(7, '4555400091110086', '06/2', '888', '221.8200', 10),
(9, '5656565656565656', '08/3', '345', '84.5500', 24),
(10, '12345678912345666', '01/3', '432', '127.4900', 9),
(11, '123456781234560000', '08/3', '665', '0.0000', 10),
(12, '4555400091110099', '05/2', '987', '213.7500', 24),
(13, '123456789012345666', '01/2', '777', '85.0000', 8),
(14, '123456781234567777', '03/2', '876', '28.7500', 8),
(15, '123435781234567890', '01/3', '657', '43.7500', 18),
(16, '333456781234567890', '05/2', '432', '68.0000', 18),
(17, '125556781234567890', '07/2', '345', '0.0000', 16),
(18, '123486781234567890', '04/3', '243', '0.0000', 16),
(19, '123455581234567890', '12/3', '098', '0.0000', 23),
(20, '123456781234567777', '20/2', '443', '0.0000', 23),
(21, '123456781234567788', '07/3', '990', '0.0000', 15),
(22, '123456781237767890', '06/5', '890', '0.0000', 15),
(23, '123456781234561111', '08/2', '554', '0.0000', 26),
(24, '123456999234567890', '09/2', '767', '0.0000', 26),
(25, '123456333234567890', '02/2', '090', '0.0000', 21),
(26, '123393981234567890', '11/2', '656', '0.0000', 21);

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
  `nPrice` decimal(5,2) NOT NULL DEFAULT 0.00,
  `nStock` int(11) NOT NULL DEFAULT 0,
  `bActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tproduct`
--

INSERT INTO `tproduct` (`nProductID`, `cName`, `nCoffeeTypeID`, `nPrice`, `nStock`, `bActive`) VALUES
(1, 'Organic Tierra Del Sol', 5, '23.00', 142, 1),
(2, 'Greater Goods', 6, '44.00', 8, 1),
(3, 'Hugo Melo', 1, '110.00', 199, 1),
(4, 'Light It Up', 4, '35.00', 99, 1),
(5, 'Full Steam', 3, '68.00', 98, 1),
(6, 'Coffee Manufactory', 2, '60.00', 99, 1),
(7, 'Little Nap Coffee Beans', 6, '25.00', 100, 1),
(8, 'Atlas Coffee', 5, '45.00', 99, 1),
(9, 'Kintore Coffee', 6, '40.00', 100, 1),
(10, 'Lavazza', 2, '55.00', 100, 1),
(21, 'Read Coffee Bag', 1, '35.00', 150, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tpurchase`
--

CREATE TABLE `tpurchase` (
  `nPurchaseID` int(8) UNSIGNED NOT NULL,
  `nProductID` int(10) UNSIGNED NOT NULL,
  `dPurchase` timestamp NOT NULL DEFAULT current_timestamp(),
  `nNetAmount` decimal(5,2) NOT NULL,
  `nTax` decimal(4,2) NOT NULL,
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpurchase`
--

INSERT INTO `tpurchase` (`nPurchaseID`, `nProductID`, `dPurchase`, `nNetAmount`, `nTax`, `nCreditCardID`) VALUES
(0, 2, '2019-12-09 13:44:39', '44.00', '11.00', 12),
(61, 1, '2019-12-03 14:01:43', '50.00', '12.50', 7),
(62, 4, '2019-12-05 08:59:31', '35.00', '8.75', 6),
(63, 5, '2019-12-05 09:08:29', '12.00', '7.20', 6),
(70, 10, '2019-12-07 17:12:22', '55.00', '13.75', 7),
(71, 6, '2019-12-07 17:15:17', '60.00', '15.00', 7),
(72, 5, '2019-12-07 17:15:50', '68.00', '16.32', 7),
(76, 8, '2019-12-07 17:24:42', '45.00', '10.80', 9),
(77, 1, '2019-12-07 17:26:37', '23.00', '5.75', 9),
(78, 3, '2019-12-07 17:36:31', '99.99', '27.50', 10),
(80, 1, '2019-12-09 13:47:35', '23.00', '5.75', 12),
(81, 2, '2019-12-09 13:47:54', '44.00', '11.00', 12),
(82, 6, '2019-12-09 13:49:47', '60.00', '15.00', 12),
(83, 5, '2019-12-09 13:51:37', '68.00', '17.00', 13),
(84, 5, '2019-12-09 13:52:29', '68.00', '0.00', 16),
(85, 4, '2019-12-09 14:05:29', '35.00', '8.75', 15),
(86, 1, '2019-12-09 14:09:06', '23.00', '5.75', 14);

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

--
-- Dumping data for table `tsubscriptionpurchase`
--

INSERT INTO `tsubscriptionpurchase` (`nUserSubscriptionID`, `nPurchaseID`) VALUES
(1, 77),
(2, 78),
(4, 81),
(5, 82),
(6, 83),
(7, 84),
(8, 85),
(10, 86);

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

--
-- Dumping data for table `tsubscriptiontype`
--

INSERT INTO `tsubscriptiontype` (`nSubscriptionTypeID`, `nProductID`, `cName`, `nQuantity`) VALUES
(1, 1, 'Organic Tierra Del Sol Subscription', 1),
(2, 3, 'Hugo Melo Subscription', 1),
(3, 4, 'Ligh It Up Subscription', 1),
(4, 5, 'Full Steam Subscription', 1),
(5, 6, 'Coffee Manufactory Subscription', 1),
(7, 2, 'Greater Goods Subscription', 1);

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
  `nCityID` mediumint(8) UNSIGNED NOT NULL,
  `cPhoneNo` char(8) NOT NULL,
  `dNewUser` timestamp NOT NULL DEFAULT current_timestamp(),
  `dDeleteUser` timestamp NULL DEFAULT NULL,
  `nTotalPurchaseAmount` decimal(18,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tuser`
--

INSERT INTO `tuser` (`nUserID`, `cName`, `cSurname`, `cEmail`, `cUsername`, `cPassword`, `cAddress`, `nCityID`, `cPhoneNo`, `dNewUser`, `dDeleteUser`, `nTotalPurchaseAmount`) VALUES
(8, 'Jonas', 'Jonassen', 'jonse@jonse.com', 'jonse', 'd63dc919e201d7bc4c825630d2cf25fdc93d4b2f0d46706d29038d01', 'Ryparken 120, 2100', 1, '55555555', '0000-00-00 00:00:00', NULL, '113.7500'),
(9, 'Anna', 'Nielsen', 'anna@mail.com', 'annaniel', 'a7470858e79c282bc2f6adfd831b132672dfd1224c1e78cbf5bcd057', 'Tagensvej 1, 2400', 1, '54545454', '2019-12-02 22:01:45', NULL, '171.2400'),
(10, 'Frida', 'Kahlo', 'frida@mail.com', 'fridak', '7d463f13fa3d3a1525050aaeb08c8b855763ed813553175c6d1f2833', 'Emdrupvej 266, 2100', 1, '12345678', '2019-12-02 22:02:39', NULL, '62.5000'),
(11, 'Pippi', 'Langstromp', 'langstromp@yahoo.com', 'pippi', '03dfe83128ab8c6f0b6406a887f58b8d87b139c5cf040db96e891424', 'Lygten 16, 2400', 1, '43434343', '2019-12-02 22:14:02', NULL, '0.0000'),
(12, 'Allan', 'Tostrup', 'tostrup@gmail', 'tostr', '079a32e16994cf4c8fcf2de227ccf26990d913b013c60c2e4eef4945', 'Guldbergsgade 120, 2400', 1, '1234599', '2019-12-03 10:49:32', NULL, '0.0000'),
(13, 'Maria', 'Marense', 'masense@gmail', 'marense', 'c0f41139453b47880ce6757d3f3b5e69722625dd4e0b2d834a0aeaed', 'Rosengade 55, 2800', 3, '45454545', '2019-12-03 10:50:58', NULL, '0.0000'),
(14, 'Mike', 'Mikeson', 'mm@mail.com', 'mikeson', 'fb984f4bad7bc64f56f67744cd2dd869ca84968ab620b1d615b724bb', 'Carlsbergsvej 120', 2, '12344321', '2019-12-03 10:52:04', NULL, '0.0000'),
(15, 'Lisa', 'Larsen', 'lars@gmail.com', 'lars', 'f67ec754183f332e47f97eb3997ba917da5adca443f41e5be2614f18', 'Jagtvej 564, 2100', 1, '87654321', '2019-12-03 10:52:50', NULL, '0.0000'),
(16, 'Raleigh', 'Tyson', 'tyson@yahoo.com', 'tyson', '1bb4b2fcb1ebd6d9de87cfff5e8c78c67bb17ef1981d0356afc27000', 'Lyngybej 120, 2800', 1, '76767676', '2019-12-03 10:53:44', NULL, '0.0000'),
(17, 'Sophie', 'Jensen', 'jense@gmail.com', 'sohje', '1d46523873c515fe0303257388bcffb4b32a369ddd79c62a04746744', 'Jensengade 44, 7904', 3, '66778899', '2019-12-03 10:54:48', NULL, '0.0000'),
(18, 'Olga', 'Smith', 'olga@olga.com', 'olga1', 'b986a019f4c1cf3fffe37f7cfe9eb60d57b621fe5a28f3df6245fdeb', 'Ovej,1 Koge 1234', 2, '11223344', '2019-12-04 12:03:57', NULL, '111.7500'),
(21, 'Don', 'Jens', 'jens@don.dk', 'donJens', 'bbd2eaa465a570feed6a0f368550b9da88f89194f29466c649920dab', 'Randersvej,12 1234 Randers', 3, '11556438', '2019-12-04 12:30:04', NULL, '0.0000'),
(23, 'Eleanor', 'Coolish', 'cool@cool.dk', 'eler', '302c401c2dfb70269d43b24504cb80baad56564f91633a0392001444', 'Ryparken 13 2100 København', 2, '34563456', '2019-12-04 12:41:58', NULL, '0.0000'),
(24, 'Nina', 'Ricci', 'nina@gmail.com', 'ninaRich', '43f648533b07a340a204b8a9504c75aa457ddc5180209d01aad571e0', 'Coolvej, 14 2387 Nestved', 5, '37809754', '2019-12-04 12:45:37', NULL, '298.3000'),
(26, 'Jens', 'Jakobsen', 'jakob@gmail.com', 'jensssss', '7e6a4309ddf6e8866679f61ace4f621b0e3455ebac2e831a60f13cd1', 'Ulvej 156, 2100', 15, '12345699', '2019-12-09 11:55:21', NULL, '0.0000');

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
    	( nAuditUserID,
  nOldUserID,
  cOldName,
  cOldSurname ,
  cOldEmail, 
  cOldUsername ,
  cOldPassword,
  cOldAddress,
  nOldCityID,
  cOldPhoneNo,
  dOldNewUser,
  dOldDeleteUser,
  nOldTotalPurchaseAmount,
  nNewUserID,
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
  dTimeStamp, 
  cDBUser, 
  cHost
        )
     VALUES (
         DEFAULT,
         old.nUserID,
            old.cName,
            old.cSurname ,
            old.cEmail, 
            old.cUsername ,
            old.cPassword,
            old.cAddress,
            old.nCityID,
            old.cPhoneNo,
            old.dNewUser,
            old.dDeleteUser,
            old.nTotalPurchaseAmount,
            new.nUserID,
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
            DEFAULT,
            SUBSTRING(CURRENT_USER(),1,LOCATE('@', CURRENT_USER())-1), 	
            SUBSTRING(CURRENT_USER(),LOCATE('@', CURRENT_USER())+1)
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
-- Dumping data for table `tusersubscription`
--

INSERT INTO `tusersubscription` (`nUserSubscriptionID`, `nUserID`, `dSubscription`, `dCancellation`, `nSubscriptionTypeID`) VALUES
(1, 24, '2019-12-07 17:26:37', NULL, 1),
(2, 9, '2019-12-07 17:36:31', NULL, 2),
(4, 24, '2019-12-09 13:47:54', NULL, 7),
(5, 24, '2019-12-09 13:49:47', NULL, 5),
(6, 8, '2019-12-09 13:51:37', NULL, 4),
(7, 18, '2019-12-09 13:52:29', NULL, 4),
(8, 18, '2019-12-09 14:05:29', NULL, 3),
(10, 8, '2019-12-09 14:09:06', NULL, 1);

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
  MODIFY `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `tauditpurchase`
--
ALTER TABLE `tauditpurchase`
  MODIFY `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `taudituser`
--
ALTER TABLE `taudituser`
  MODIFY `nAuditUserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tcity`
--
ALTER TABLE `tcity`
  MODIFY `nCityID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tcoffeetype`
--
ALTER TABLE `tcoffeetype`
  MODIFY `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tcreditcard`
--
ALTER TABLE `tcreditcard`
  MODIFY `nCreditCardID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tproduct`
--
ALTER TABLE `tproduct`
  MODIFY `nProductID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tpurchase`
--
ALTER TABLE `tpurchase`
  MODIFY `nPurchaseID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tsubscriptiontype`
--
ALTER TABLE `tsubscriptiontype`
  MODIFY `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tuser`
--
ALTER TABLE `tuser`
  MODIFY `nUserID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tusersubscription`
--
ALTER TABLE `tusersubscription`
  MODIFY `nUserSubscriptionID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `tpurchase_ibfk_2` FOREIGN KEY (`nCreditCardID`) REFERENCES `tcreditcard` (`nCreditCardID`),
  ADD CONSTRAINT `tpurchase_ibfk_3` FOREIGN KEY (`nProductID`) REFERENCES `tproduct` (`nProductID`);

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
