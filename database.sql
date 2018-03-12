-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `test_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `test_db`;

DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE `tbl_department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_department` (`id`, `name`, `description`) VALUES
(1,	'PHP',	'PHP'),
(2,	'Java',	'Java'),
(3,	'iPhone',	'iPhone');

DROP TABLE IF EXISTS `tbl_employee`;
CREATE TABLE `tbl_employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(10) unsigned NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tbl_employee` (`id`, `department_id`, `first_name`, `last_name`, `email`, `contact_number`, `status`) VALUES
(1,	3,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active'),
(2,	2,	'Adam',	'Smith',	'adam.smith@gmail.com',	'32196456',	'active'),
(3,	1,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active'),
(4,	1,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active'),
(5,	1,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active'),
(6,	2,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active'),
(7,	3,	'dsfsdfsdfsd',	'sdfsdfsdfsd',	'dfsdfds@gmail.com',	'24354534534',	'active');
-- 2018-03-12 14:44:26
