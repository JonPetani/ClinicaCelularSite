-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2020 at 11:02 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinicacelular`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerId` int(11) NOT NULL COMMENT 'Customer Id',
  `FirstName` varchar(30) NOT NULL COMMENT 'First Name',
  `LastName` varchar(35) NOT NULL COMMENT 'Late Name',
  `Password` varchar(128) NOT NULL COMMENT 'Password For Login',
  `EmailAddress` varchar(65) NOT NULL COMMENT 'Email Address',
  `Phone` varchar(25) DEFAULT NULL COMMENT 'Phone Number (Non Mobile)',
  `MobilePhone` varchar(25) NOT NULL COMMENT 'Mobile Phone Number (Required for SMS Verify)',
  `ZipCode` varchar(5) NOT NULL COMMENT 'Zip Code',
  `Address` varchar(100) NOT NULL COMMENT 'Location / Address',
  `KeepLoggedIn` tinyint(1) NOT NULL COMMENT 'Whether To Keep Logged In After Closing Browser',
  `EmailList` tinyint(1) NOT NULL COMMENT 'If Customer Wants To Receive Emails With Offers',
  `VerifiedAccount` tinyint(1) NOT NULL COMMENT 'If SMS Verification was done yet',
  `SecureMethod` varchar(30) DEFAULT NULL COMMENT 'cipher method for session',
  `IVLength` text COMMENT 'IV Length for Cipher',
  `CipherKey` varchar(30) DEFAULT NULL COMMENT 'cipher key',
  `VerifyCode` varchar(30) DEFAULT NULL COMMENT 'SMS/Email Code'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Listing of all Customer Created Accounts on System';

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerId`, `FirstName`, `LastName`, `Password`, `EmailAddress`, `Phone`, `MobilePhone`, `ZipCode`, `Address`, `KeepLoggedIn`, `EmailList`, `VerifiedAccount`, `SecureMethod`, `IVLength`, `CipherKey`, `VerifyCode`) VALUES
(1, 'Simon', 'Jacinto', '3javVZYAWpbpCqc', 'SJacinto@tacos.com', '455-445-4454', '76-6998-8765', '48554', '455, taco street, memexico', 1, 1, 0, 'aes-256-cfb8', ':wU~f¸L\'nÎÃ¡ !Ð', 'É³`/pú±…>‹id÷Ç4kÖë', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Customer Id', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
