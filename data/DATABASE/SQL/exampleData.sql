-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2016 at 02:26 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `lis`
--

--
-- Dumping data for table `StudentGrade`
--

INSERT INTO `StudentGrade` (`id`, `student_id`, `grade_choice_id`, `teacher_id`, `independent_work_id`, `module_id`, `subject_round_id`, `contact_lesson_id`, `created_by`, `updated_by`, `notes`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, NULL, 1, 1, 1, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(2, 1, 3, 1, NULL, 1, 1, 2, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(3, 1, 3, 1, NULL, 1, 1, 4, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(4, 1, 4, 1, NULL, 1, 1, 5, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(5, 1, 6, 1, 1, NULL, NULL, NULL, 2, NULL, 'Tehtud', NULL, '2016-05-05 00:00:00', NULL),
(6, 1, 6, 1, 1, NULL, NULL, NULL, 2, NULL, 'Note', 0, '2016-05-08 00:00:00', NULL),
(7, 1, 4, 1, NULL, NULL, 2, NULL, 2, NULL, 'Tehtud', NULL, '2016-05-09 00:00:00', NULL);
