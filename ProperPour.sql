-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2019 at 01:00 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET AUTOCOMMIT = 0;
-- START TRANSACTION;
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ProperPour`
--

-- --------------------------------------------------------

--
-- Table structure for table `TAuditCreditCard`
--
CREATE DATABASE IF NOT EXISTS `ProperPour`;
USE `ProperPour`;

CREATE TABLE `TAuditCreditCard` (
  `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL,
  `nOldCreditCard` mediumint(8) UNSIGNED DEFAULT NULL,
  `nOldUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldIBAN` char(18) DEFAULT NULL,
  `cOldExpiration` char(4) DEFAULT NULL,
  `cOldCCV` char(3) DEFAULT NULL,
  `nOldTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `nNewCreditCard` mediumint(8) UNSIGNED DEFAULT NULL,
  `nNewUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewIBAN` char(18) DEFAULT NULL,
  `cNewExpiration` char(4) DEFAULT NULL,
  `cNewCCV` char(3) DEFAULT NULL,
  `nNewTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TAuditPurchase`
--

CREATE TABLE `TAuditPurchase` (
  `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL,
  `nOldPurchaseID` int(11) DEFAULT NULL,
  `dOldPurchase` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nOldNetAmount` decimal(4,2) DEFAULT NULL,
  `nOldTax` decimal(2,2) DEFAULT NULL,
  `nOldCreditCardID` mediumint(9) DEFAULT NULL,
  `nNewPurchaseID` int(11) DEFAULT NULL,
  `dNewPurchase` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nNewNetAmount` decimal(4,2) DEFAULT NULL,
  `nNewTax` decimal(2,2) DEFAULT NULL,
  `nNewCreditCardID` mediumint(9) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TAuditUser`
--

CREATE TABLE `TAuditUser` (
  `nAuditUserID` bigint(20) UNSIGNED NOT NULL,
  `cOldUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldName` varchar(50) DEFAULT NULL,
  `cOldSurname` varchar(50) DEFAULT NULL,
  `cOldEmail` varchar(255) DEFAULT NULL,
  `cOldUsername` varchar(30) DEFAULT NULL,
  `cOldPassword` char(56) DEFAULT NULL,
  `cOldAddress` varchar(255) DEFAULT NULL,
  `nOldCityID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cOldPhoneNo` char(8) DEFAULT NULL,
  `dOldNewUser` timestamp DEFAULT NULL,
  `dOldDeleteUser` timestamp DEFAULT NULL,
  `nOldTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `cNewUserID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewName` varchar(50) DEFAULT NULL,
  `cNewSurname` varchar(50) DEFAULT NULL,
  `cNewEmail` varchar(255) DEFAULT NULL,
  `cNewUsername` varchar(30) DEFAULT NULL,
  `cNewPassword` char(56) DEFAULT NULL,
  `cNewAddress` varchar(255) DEFAULT NULL,
  `nNewCityID` mediumint(8) UNSIGNED DEFAULT NULL,
  `cNewPhoneNo` char(8) DEFAULT NULL,
  `dNewNewUser` timestamp DEFAULT NULL,
  `dNewDeleteUser` timestamp DEFAULT NULL,
  `nNewTotalPurchaseAmount` decimal(18,4) DEFAULT NULL,
  `cAction` char(1) NOT NULL,
  `dTimeStamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `cDBUser` varchar(255) NOT NULL,
  `cHost` varchar(255) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TCity`
--

CREATE TABLE `TCity` (
  `nCityID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TCoffeeType`
--

CREATE TABLE `TCoffeeType` (
  `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TCreditCard`
--

CREATE TABLE `TCreditCard` (
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL,
  `cIBAN` char(18) NOT NULL,
  `cExpiration` char(4) NOT NULL,
  `cCCV` char(3) NOT NULL,
  `nTotalPurchaseAmount` decimal(18,4) DEFAULT 0.0000,
  `nUserID` mediumint(8) UNSIGNED NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TProduct`
--

CREATE TABLE `TProduct` (
  `nProductID` int(10) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL,
  `nPrice` decimal(4,2) NOT NULL DEFAULT 0.00,
  `nStock` int(11) NOT NULL DEFAULT 0
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TPurchase`
--

CREATE TABLE `TPurchase` (
  `nPurchaseID` int(8) UNSIGNED NOT NULL,
  `nProductID` int(10) UNSIGNED NOT NULL,
  `dPurchase` timestamp NOT NULL DEFAULT current_timestamp(),
  `nNetAmount` decimal(4,2) NOT NULL,
  `nTax` decimal(2,2) NOT NULL,
  `nCreditCardID` mediumint(8) UNSIGNED NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TSubscriptionPurchase`
--

CREATE TABLE `TSubscriptionPurchase` (
  `nUserSubscriptionID` int(10) UNSIGNED NOT NULL,
  `nPurchaseID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TSubscriptionType`
--

CREATE TABLE `TSubscriptionType` (
  `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL,
  `nProductID` int(10) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `nQuantity` tinyint(4) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TUser`
--

CREATE TABLE `TUser` (
  `nUserID` mediumint(8) UNSIGNED NOT NULL,
  `cName` varchar(50) NOT NULL,
  `cSurname` varchar(50) NOT NULL,
  `cEmail` varchar(255) NOT NULL,
  `cUsername` varchar(30) NOT NULL,
  `cPassword` char(56) NOT NULL,
  `cAddress` varchar(255) NOT NULL,
  `nCityID` mediumint(9) UNSIGNED NOT NULL,
  `cPhoneNo` char(8) NOT NULL DEFAULT current_timestamp,
  `dNewUser` timestamp NOT NULL,
  `dDeleteUser` timestamp DEFAULT NULL,
  `nTotalPurchaseAmount` decimal(18,4) NOT NULL DEFAULT 0.0000
) ;

-- --------------------------------------------------------

--
-- Table structure for table `TUserSubscription`
--

CREATE TABLE `TUserSubscription` (
  `nUserSubscriptionID` int(8) UNSIGNED NOT NULL,
  `nUserID` mediumint(8) UNSIGNED NOT NULL,
  `dSubscription` timestamp NOT NULL DEFAULT current_timestamp,
  `dCancellation` timestamp DEFAULT NULL,
  `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `TAuditCreditCard`
--
ALTER TABLE `TAuditCreditCard`
  ADD PRIMARY KEY (`nAuditCreditCardID`);

--
-- Indexes for table `TAuditPurchase`
--
ALTER TABLE `TAuditPurchase`
  ADD PRIMARY KEY (`nAuditPurchaseID`);

--
-- Indexes for table `TAuditUser`
--
ALTER TABLE `TAuditUser`
  ADD PRIMARY KEY (`nAuditUserID`);

--
-- Indexes for table `TCity`
--
ALTER TABLE `TCity`
  ADD PRIMARY KEY (`nCityID`);

--
-- Indexes for table `TCoffeeType`
--
ALTER TABLE `TCoffeeType`
  ADD PRIMARY KEY (`nCoffeeTypeID`);

--
-- Indexes for table `TCreditCard`
--
ALTER TABLE `TCreditCard`
  ADD PRIMARY KEY (`nCreditCardID`),
  ADD KEY `nUserID` (`nUserID`);

--
-- Indexes for table `TProduct`
--
ALTER TABLE `TProduct`
  ADD PRIMARY KEY (`nProductID`),
  ADD KEY `nCoffeeTypeID` (`nCoffeeTypeID`);

--
-- Indexes for table `TPurchase`
--
ALTER TABLE `TPurchase`
  ADD PRIMARY KEY (`nPurchaseID`),
  ADD KEY `nProductID` (`nProductID`),
  ADD KEY `nCreditCardID` (`nCreditCardID`);

--
-- Indexes for table `TSubscriptionPurchase`
--
ALTER TABLE `TSubscriptionPurchase`
  ADD PRIMARY KEY (`nUserSubscriptionID`,`nPurchaseID`),
  ADD KEY `nPurchaseID` (`nPurchaseID`),
  ADD KEY `nUserSubscriptionID` (`nUserSubscriptionID`) USING BTREE;

--
-- Indexes for table `TSubscriptionType`
--
ALTER TABLE `TSubscriptionType`
  ADD PRIMARY KEY (`nSubscriptionTypeID`),
  ADD KEY `nProductID` (`nProductID`);

--
-- Indexes for table `TUser`
--
ALTER TABLE `TUser`
  ADD PRIMARY KEY (`nUserID`),
  ADD KEY `nCityID` (`nCityID`);

--
-- Indexes for table `TUserSubscription`
--
ALTER TABLE `TUserSubscription`
  ADD PRIMARY KEY (`nUserSubscriptionID`),
  ADD KEY `nUserID` (`nUserID`),
  ADD KEY `nSubscriptionTypeID` (`nSubscriptionTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TAuditCreditCard`
--
ALTER TABLE `TAuditCreditCard`
  MODIFY `nAuditCreditCardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TAuditPurchase`
--
ALTER TABLE `TAuditPurchase`
  MODIFY `nAuditPurchaseID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TAuditUser`
--
ALTER TABLE `TAuditUser`
  MODIFY `nAuditUserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TCity`
--
ALTER TABLE `TCity`
  MODIFY `nCityID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TCoffeeType`
--
ALTER TABLE `TCoffeeType`
  MODIFY `nCoffeeTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TCreditCard`
--
ALTER TABLE `TCreditCard`
  MODIFY `nCreditCardID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TProduct`
--
ALTER TABLE `TProduct`
  MODIFY `nProductID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TPurchase`
--
ALTER TABLE `TPurchase`
  MODIFY `nPurchaseID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TSubscriptionType`
--
ALTER TABLE `TSubscriptionType`
  MODIFY `nSubscriptionTypeID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TUser`
--
ALTER TABLE `TUser`
  MODIFY `nUserID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TUserSubscription`
--
ALTER TABLE `TUserSubscription`
  MODIFY `nUserSubscriptionID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `TCreditCard`
--
ALTER TABLE `TCreditCard`
  ADD CONSTRAINT `tcreditcard_ibfk_1` FOREIGN KEY (`nUserID`) REFERENCES `TUser` (`nUserID`);

--
-- Constraints for table `TProduct`
--
ALTER TABLE `TProduct`
  ADD CONSTRAINT `tproduct_ibfk_1` FOREIGN KEY (`nCoffeeTypeID`) REFERENCES `TCoffeeType` (`nCoffeeTypeID`);

--
-- Constraints for table `TPurchase`
--
ALTER TABLE `TPurchase`
  ADD CONSTRAINT `tpurchase_ibfk_1` FOREIGN KEY (`nProductID`) REFERENCES `TProduct` (`nProductID`),
  ADD CONSTRAINT `tpurchase_ibfk_2` FOREIGN KEY (`nCreditCardID`) REFERENCES `TCreditCard` (`nCreditCardID`);

--
-- Constraints for table `TSubscriptionPurchase`
--
ALTER TABLE `TSubscriptionPurchase`
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_1` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `TUserSubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_2` FOREIGN KEY (`nPurchaseID`) REFERENCES `TPurchase` (`nPurchaseID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_3` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `TUserSubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_4` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `TUserSubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_5` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `TUserSubscription` (`nUserSubscriptionID`),
  ADD CONSTRAINT `tsubscriptionpurchase_ibfk_6` FOREIGN KEY (`nUserSubscriptionID`) REFERENCES `TUserSubscription` (`nUserSubscriptionID`);

--
-- Constraints for table `TSubscriptionType`
--
ALTER TABLE `TSubscriptionType`
  ADD CONSTRAINT `tsubscriptiontype_ibfk_1` FOREIGN KEY (`nProductID`) REFERENCES `TProduct` (`nProductID`);

--
-- Constraints for table `TUser`
--
ALTER TABLE `TUser`
  ADD CONSTRAINT `tuser_ibfk_1` FOREIGN KEY (`nCityID`) REFERENCES `TCity` (`nCityID`);

--
-- Constraints for table `TUserSubscription`
--
ALTER TABLE `TUserSubscription`
  ADD CONSTRAINT `tusersubscription_ibfk_1` FOREIGN KEY (`nUserID`) REFERENCES `TUser` (`nUserID`),
  ADD CONSTRAINT `tusersubscription_ibfk_2` FOREIGN KEY (`nSubscriptionTypeID`) REFERENCES `TSubscriptionType` (`nSubscriptionTypeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
