-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 14, 2015 at 12:18 AM
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
('1e9f4cb3e9c86e888d36061a8d8e94a37995f19e', 'CrowdedApp', 'testuser', '2015-11-11 21:56:48', NULL),
('4ab3688fba3304dfd5cce473900d51c73ac36006', 'CrowdedApp', 'testuser', '2015-11-12 19:17:01', 'get_user'),
('4ab7906cd10df167323aec9e0fa4fba326b522e6', 'CrowdedApp', 'testuser', '2015-11-12 23:35:00', NULL),
('58ad17b8fd3c73215290009c6cc9b69ec8fc7b1b', 'CrowdedApp', 'testuser', '2015-11-13 18:56:21', 'get_user'),
('6a8c6035917a5e9a7f13f9fdb04f01c6f46737d5', 'CrowdedApp', 'testuser', '2015-11-13 18:51:28', NULL),
('8b11ced0494cc44f558fdf767d5bd6a8ddc26890', 'CrowdedApp', 'testuser', '2015-11-12 22:34:05', 'get_user'),
('a2a6936be441b7280aa6bcc9592a59d5409f84d9', 'CrowdedApp', 'testuser', '2015-11-11 22:01:23', 'get_user'),
('a7343802190884ef98067637ec10a6c017bffc66', 'CrowdedApp', 'testuser', '2015-11-11 18:43:30', NULL),
('f5fbc5fa8739b0f0dddaa4a21726514718c5a39c', 'CrowdedApp', 'testuser', '2015-11-12 23:57:13', NULL);

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
('admin', '$2a$10$44nfKuBG6HqfQ3I7LoCiQeNO80KI/OhQdBrz3FwcSqqtNikSvdVyG', '/admin', NULL, NULL, 'admin'),
('CrowdedApp', '', '/crowded/auth', NULL, 'get_user edit_own_user get_users', NULL);

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
('561d11bf473956d8807b662ee7ec59dc13d828a3', 'CrowdedApp', 'testuser', '2015-11-27 17:51:28', NULL),
('5ceeb83657fdfb7249223f3b5decca2cb5a2fd38', 'CrowdedApp', 'testuser', '2015-11-26 22:35:00', NULL),
('7e506b2049aeb27032fbfa336d061ed0412e4694', 'CrowdedApp', 'testuser', '2015-11-26 22:30:08', 'get_user'),
('933ee7c70659845376538510cdf37e2c886dab8a', 'CrowdedApp', 'testuser', '2015-11-25 20:56:48', NULL),
('a727f6f44624e317374f5cba85c6c5a0a1216c75', 'CrowdedApp', 'testuser', '2015-11-27 17:56:21', 'get_user'),
('bb7186c290fb7edfb1514758d988902b791f2405', 'CrowdedApp', 'testuser', '2015-11-26 22:57:13', NULL),
('bc1c6d62eb558d80e047c3eb148edf8fc5b00b5f', 'CrowdedApp', 'testuser', '2015-11-25 17:43:30', NULL),
('d54c7186195c548d687de02572ecb6742beeb5e6', 'CrowdedApp', 'testuser', '2015-11-26 18:17:01', 'get_user'),
('fb8e8048bb79d6c4cdba59ac69d4cc85f253bd3c', 'CrowdedApp', 'testuser', '2015-11-25 21:01:23', 'get_user');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `type` varchar(255) NOT NULL DEFAULT 'supported',
  `scope` varchar(2000) DEFAULT NULL,
  `client_id` varchar(80) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL,
  KEY `scope` (`scope`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_scopes`
--

INSERT INTO `oauth_scopes` (`type`, `scope`, `client_id`, `is_default`) VALUES
('supported', 'get_user', NULL, NULL),
('supported', 'get_users', NULL, NULL),
('supported', 'edit_user', NULL, NULL),
('supported', 'edit_own_user', NULL, NULL),
('supported', 'create_user', NULL, NULL),
('supported', 'delete_user', NULL, NULL),
('supported', 'send_email', NULL, NULL);

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
(2, 'testuser', '$2a$10$44nfKuBG6HqfQ3I7LoCiQeNO80KI/OhQdBrz3FwcSqqtNikSvdVyG', 'testuser@gmail.com', NULL, 'user', 'active', '2015-09-07 16:38:48');

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
  `scopes` text,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`roleId`, `isDefault`, `scopes`) VALUES
('admin', 0, 'get_user get_users edit_user create_user delete_user send_email'),
('guest', 1, ''),
('staff', 0, 'get_user get_users edit_user create_user'),
('user', 0, 'get_user edit_own_user get_users');

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
