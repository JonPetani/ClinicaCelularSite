-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2020 at 07:43 PM
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
  `VerifyCode` varchar(30) DEFAULT NULL COMMENT 'Email Verify/Recovery Code'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Listing of all Customer Created Accounts on System';

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerId`, `FirstName`, `LastName`, `Password`, `EmailAddress`, `Phone`, `MobilePhone`, `ZipCode`, `Address`, `KeepLoggedIn`, `EmailList`, `VerifiedAccount`, `SecureMethod`, `IVLength`, `CipherKey`, `VerifyCode`) VALUES
(4, 'Juanita', 'Senora', 'i46VpTRCHyUt9vn', 'UnstoppableStreletsy@gmail.com', '22-3445-5654', '703-348-1101', '45948', '234, Yin Yang Way,', 1, 1, 1, 'camellia-256-cfb', '€-½(]íÀFÂ’à×5', ':Sm`X2_2[IF6RcwIxv;7ZW', 'mXfk2oE?cBeDYw@wuJoKaB0c');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(11) NOT NULL COMMENT 'Employee Account ID',
  `First` varchar(40) NOT NULL COMMENT 'First Name',
  `Last` varchar(40) NOT NULL COMMENT 'Last Name',
  `EmailAddress` varchar(65) NOT NULL COMMENT 'Email Address',
  `Role` varchar(50) NOT NULL COMMENT 'Role in Company',
  `Salary` double NOT NULL COMMENT 'Set Salary for Employee',
  `Password` varchar(30) NOT NULL COMMENT 'Secure Password',
  `SecureMethod` varchar(30) DEFAULT NULL COMMENT 'cipher method for session',
  `IVLength` text COMMENT 'Iv Length for Cipher',
  `CipherKey` varchar(30) DEFAULT NULL COMMENT 'cipher key',
  `VerifyCode` varchar(30) DEFAULT NULL COMMENT 'Account Recovery Code'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Employee Account Table';

-- --------------------------------------------------------

--
-- Table structure for table `sitecodes`
--

CREATE TABLE `sitecodes` (
  `CodeID` int(11) NOT NULL COMMENT 'Code Index ID',
  `CodeName` varchar(60) NOT NULL COMMENT 'Code Name/Purpose',
  `CodeValue` varchar(30) NOT NULL COMMENT 'Code Value Itself',
  `LastUpdated` date NOT NULL COMMENT 'Last Time This Code Value Was Modified For Maintenence Purposes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds Security Codes on Platform (Mainly for Employee Stuff)';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `sitecodes`
--
ALTER TABLE `sitecodes`
  ADD PRIMARY KEY (`CodeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Customer Id', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sitecodes`
--
ALTER TABLE `sitecodes`
  MODIFY `CodeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Code Index ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
