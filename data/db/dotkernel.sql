-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 25, 2015 at 11:42 PM
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

--
-- Dumping data for table `oauth_authorization_codes`
--

INSERT INTO `oauth_authorization_codes` (`authorization_code`, `client_id`, `user_id`, `redirect_uri`, `expires`, `scope`, `id_token`) VALUES
('d6e1017a2357579b4ee464abccaf923e7d242cba', 'CrowdedApp', 'testuser', '/oauth/receivecode', '2015-11-25 21:41:55', 'openid profile get_users edit_own_user', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODA4MCIsInN1YiI6InRlc3R1c2VyIiwiYXVkIjoiQ3Jvd2RlZEFwcCIsImlhdCI6MTQ0ODQ4NzY4NSwiZXhwIjoxNDQ4NDk4NDg1LCJhdXRoX3RpbWUiOjE0NDg0ODc2ODV9.1hc1BsxuyV4Hz9iwBjL-k9aHX1P4TX6aPwUvqTdjqqkOfqjbu7rkK1ZjBcf8dv8yi3DbQTFFPX90Qm_yxPiifpA-ITKduI9iBdgBT0XN6eRB6GbyFhmghmrr3hP-Io1oXMpq0EaeE3Bq5q5Gx7RWJqBVy-nAayfkAsFnAEffqEg');

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
('CrowdedApp', '', '/oauth/receivecode', NULL, 'openid offline_access profile email address phone get_user get_users edit_own_user', NULL);

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
-- Table structure for table `oauth_public_keys`
--

CREATE TABLE IF NOT EXISTS `oauth_public_keys` (
  `client_id` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) NOT NULL,
  `private_key` varchar(2000) NOT NULL,
  `encryption_algorithm` varchar(100) NOT NULL DEFAULT 'RS256',
  UNIQUE KEY `client_id_2` (`client_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_public_keys`
--

INSERT INTO `oauth_public_keys` (`client_id`, `public_key`, `private_key`, `encryption_algorithm`) VALUES
(NULL, '-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDZjLo+8X1F6gfL0R8JDpwehVnj\nyCN6bS9odBc0DxsiIBIkw9IeXAejmAODJd0hi0YoYTOiB3fQQ6kiwzwXyPU6Rryr\nJ2MnowWSEbX7wxJnTpoiUpx2xrlUmYewuQOkkf9dR2KlOZHVT36r6+6ggHgK363s\nMvjeVlwM+7hnnn8dyQIDAQAB\n-----END PUBLIC KEY-----', '-----BEGIN RSA PRIVATE KEY-----\nMIICWwIBAAKBgQDZjLo+8X1F6gfL0R8JDpwehVnjyCN6bS9odBc0DxsiIBIkw9Ie\nXAejmAODJd0hi0YoYTOiB3fQQ6kiwzwXyPU6RryrJ2MnowWSEbX7wxJnTpoiUpx2\nxrlUmYewuQOkkf9dR2KlOZHVT36r6+6ggHgK363sMvjeVlwM+7hnnn8dyQIDAQAB\nAoGARJFGYnBau553tpXC4mfobPY6zsBV7lBbkOCGL7JTKv5QuaW+pDL9dWKEOOHG\nQLxU8IUycO9JpCqvNHW0iwqbv52kgUeblmP/1GFIYJwebTEnFELjWyU+7OHvnzcm\n7L63xckqMcvRR7yiYIb3vsp19MwM+R+4Wwh/YFOmnKAnasECQQDvegJ1D9TgLhi8\nES6djLAF9n2k5/eCQiHqW2d2BcA6bbE6u5BgNRvZZdlGKEcNVK3SKsJuBswDW+b+\n9iJcYvFTAkEA6I9pr8lVithckV76TWRJbtt+4Pgj8dmGwEUPE7ijbeukgKfv5Dr4\nWNJ2hb8jrym32PEnO4IZc8nnfJLf2F5E8wJAOCBgcw9C1Uf4hBuC0Won1z3uNLgp\nSl41lLfXh9HRO+B5qUpMjD/mRw2X3tmRzY4LLzbWWvM83YyslxUY+I44AQJAMSwJ\nm6qFVMs0n2QmpnB6+l6csDKnXv6weDzh2DilDZvSd4WKuoYhdp5hgxwMDoBSqCMt\nOW7jtNDPCk7/137vMwJAFZN6Xg5cMQAZJlmlR0y+nZUzKlHuZhyWVLPozKSjEiJP\noaA6Ibn8qmLVdfroTTV7U8lYiLK6uhQ7RSLQV89AGg==\n-----END RSA PRIVATE KEY-----', 'RS256');

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

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `type` varchar(255) NOT NULL DEFAULT 'supported',
  `scope` varchar(255) DEFAULT NULL,
  `client_id` varchar(80) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_scopes`
--

INSERT INTO `oauth_scopes` (`type`, `scope`, `client_id`, `is_default`, `description`) VALUES
('api', 'get_user', NULL, NULL, 'Client can view any particular user info'),
('api', 'get_users', NULL, NULL, 'Client can view the list of users'),
('api', 'edit_user', NULL, NULL, 'Client can edit any user'),
('api', 'edit_own_user', NULL, NULL, 'Client can edit its own user info'),
('api', 'create_user', NULL, NULL, 'Client can create other users'),
('api', 'delete_user', NULL, NULL, 'Client can delete a user'),
('api', 'send_email', NULL, NULL, 'Client can use the send mail function'),
('openid', 'openid', NULL, NULL, 'OpenId Connect enable id_token in response'),
('user_claim', 'profile', NULL, NULL, 'Client can read profile data'),
('openid', 'offline_access', NULL, NULL, 'Enable refresh token for openid connect'),
('user_claim', 'email', NULL, NULL, 'Client can read user email'),
('user_claim', 'address', NULL, NULL, 'Client can read user''s address'),
('user_claim', 'phone', NULL, NULL, 'Client can read user''s phone');

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
('admin', 0, 'openid offline_access profile email address phone  get_user get_users edit_user create_user delete_user send_email'),
('guest', 1, ''),
('staff', 0, 'openid offline_access profile email address phone get_user get_users edit_user create_user'),
('user', 0, 'openid offline_access profile email address phone get_user edit_own_user get_users');

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
