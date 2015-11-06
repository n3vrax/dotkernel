-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2015 at 09:54 PM
-- Server version: 5.5.23
-- PHP Version: 5.6.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dotkernel`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_transporter`
--

CREATE TABLE IF NOT EXISTS `email_transporter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `connectionClass` enum('smtp','plain','login','crammd5') NOT NULL DEFAULT 'smtp',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `secure` enum('ssl','tls') NOT NULL DEFAULT 'ssl',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email_transporter`
--

INSERT INTO `email_transporter` (`id`, `name`, `hostname`, `port`, `connectionClass`, `username`, `password`, `secure`, `active`, `dateCreated`) VALUES
(1, 'test', 'smtp.google.com', 564, 'login', 'test', '1234', 'tls', 1, '2015-09-07 16:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`access_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('04c678587ff3369b5e2bcb923fff7d848b93954a', 'admin', 'admin', '2015-11-05 19:23:14', NULL),
('12fa8fdb3b6a690172a38f5fad80c738da852a5f', 'admin', 'admin', '2015-11-03 22:06:23', NULL),
('1b7060c9d245cd5a037971ce55949750c390e3e8', 'admin', 'admin', '2015-09-07 19:05:21', NULL),
('474eb15cecb3ba48fc1fc4d02e5dfdba4e3b5d31', 'admin', 'admin', '2015-09-07 18:43:18', NULL),
('4a1c289d3714c85ef542a7dbbfd7a2a99210dbe6', 'admin', 'admin', '2015-11-04 21:12:20', NULL),
('548f0195ac2cfa980dad90ff84f9d1be137e0ed9', 'admin', 'admin', '2015-09-07 19:32:36', NULL),
('858a4322426ee753b5f1421e6bf99ab76a26bd35', 'admin', 'admin', '2015-09-07 19:11:28', NULL),
('de530c9a699c9582444d35d8422c8d82ce93c8a0', 'admin', 'admin', '2015-09-07 19:12:24', NULL),
('ea025d919074840c5708ef5f34e44d3bf7683480', 'admin', 'admin', '2015-11-03 23:21:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  `id_token` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`authorization_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) NOT NULL,
  `redirect_uri` varchar(2000) NOT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(2000) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('admin', '$2a$10$44nfKuBG6HqfQ3I7LoCiQeNO80KI/OhQdBrz3FwcSqqtNikSvdVyG', '/admin', NULL, NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_jwt`
--

CREATE TABLE IF NOT EXISTS `oauth_jwt` (
  `client_id` varchar(80) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`refresh_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('2cff1998408c8c82303b3427f3976229190b78e0', 'admin', 'admin', '2015-09-21 18:12:24', NULL),
('45795e29752729fe618468c30f57df756602ed16', 'admin', 'admin', '2015-11-17 22:21:20', NULL),
('65db494d8e22215af172f51fa35aaff49f2f110d', 'admin', 'admin', '2015-09-21 18:11:28', NULL),
('7b25a2077795bd19e2f08ecc178b20ad201dfcf5', 'admin', 'admin', '2015-09-21 18:05:21', NULL),
('a1ff75309ec1b855baeb25a851276f9b0f4245dd', 'admin', 'admin', '2015-09-21 18:32:36', NULL),
('b2b99a055f6c574705366b7c1c8f490537f2ac0b', 'admin', 'admin', '2015-11-18 20:12:20', NULL),
('d287136653c603fecc7df13dc971bc2c9fb3a41f', 'admin', 'admin', '2015-11-17 21:06:23', NULL),
('d9446e1487a90f5fcbb00db0d78f0d3885127a18', 'admin', 'admin', '2015-09-21 17:43:18', NULL),
('e8ce3c484ec62bee877b3a91297f130b18440137', 'admin', 'admin', '2015-11-19 18:23:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `type` varchar(255) NOT NULL DEFAULT 'supported',
  `scope` varchar(2000) DEFAULT NULL,
  `client_id` varchar(80) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scopes`
--

CREATE TABLE IF NOT EXISTS `scopes` (
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) NOT NULL,
  `email` varchar(255) NOT NULL,
  `displayName` varchar(255) DEFAULT NULL,
  `roleId` varchar(255) NOT NULL DEFAULT 'guest',
  `state` enum('active','inactive','unconfirmed','deleted') NOT NULL DEFAULT 'unconfirmed',
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `roleId` (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `displayName`, `roleId`, `state`, `dateCreated`) VALUES
(1, 'admin', '$2a$10$44nfKuBG6HqfQ3I7LoCiQeNO80KI/OhQdBrz3FwcSqqtNikSvdVyG', 'admin@gmail.com', NULL, 'admin', 'active', '2015-09-07 16:38:48'),
(2, 'testuser', '$2a$10$44nfKuBG6HqfQ3I7LoCiQeNO80KI/OhQdBrz3FwcSqqtNikSvdVyG', 'testuser@gmail.com', NULL, 'member', 'active', '2015-09-07 16:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `userId` int(10) unsigned NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postalCode` varchar(10) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`userId`, `firstName`, `lastName`, `address`, `city`, `region`, `country`, `postalCode`, `phone`, `dateCreated`) VALUES
(1, 'Tiberiu', 'Popa', NULL, NULL, NULL, NULL, NULL, NULL, '2015-09-07 16:38:48'),
(2, 'Test', 'User', NULL, NULL, NULL, NULL, NULL, NULL, '2015-09-07 16:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `roleId` varchar(255) NOT NULL,
  `isDefault` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`roleId`, `isDefault`) VALUES
('admin', 0),
('guest', 1),
('member', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` bigint(20) unsigned NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `user_role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
