-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2016 at 03:23 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

INSERT INTO `LisUser` (`id`, `email`, `password`, `state`, `trashed`) VALUES
(1, 'admin@test.ee', '$2y$04$AU51wB0xGadFQjFc5phO3uT0BM.qxhxnISaaWGQar7EIK/ey.1wyy', 1, NULL);

INSERT INTO `Administrator` (`id`, `lis_user_id`, `created_by`, `updated_by`, `firstName`, `lastName`, `name`, `email`, `personalCode`, `superAdministrator`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'firstName572f16694ce14', 'lastName572f16694ce5f', 'lastName572f16694ce5f, firstName572f16694ce14', 'admin@test.ee', 'code572f16694cea4', 1, NULL, '2016-05-08 13:35:21', '2016-05-08 13:35:21');

INSERT INTO `GradeChoice` (`id`, `created_by`, `updated_by`, `name`, `lisType`, `description`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '', 'erase', 'LIS_ERASE', NULL, '2016-05-18 00:00:00', NULL),
(2, 1, NULL, '2', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(3, 1, NULL, '3', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(4, 1, NULL, '4', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(5, 1, NULL, '5', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(6, 1, NULL, 'A', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(7, 1, NULL, 'MA', 'gradechoice', 'LIS_GRADECHOICE', NULL, '2016-05-18 00:00:00', NULL),
(8, 1, NULL, 'P', 'absencereason', 'LIS_ABSENCE_NOTEXCUSED', NULL, '2016-05-18 00:00:00', NULL),
(9, 1, NULL, 'T', 'absencereason', 'LIS_AT_WORK', NULL, '2016-05-18 00:00:00', NULL),
(10, 1, NULL, 'H', 'absencereason', 'LIS_SICKDAYS', NULL, '2016-05-18 00:00:00', NULL),
(11, 1, NULL, 'V', 'absencereason', 'LIS_EXCUSED', NULL, '2016-05-18 00:00:00', NULL);