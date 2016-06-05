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

--
-- Dumping data for table `LisUser`
--

INSERT INTO `LisUser` (`id`, `email`, `password`, `state`, `trashed`) VALUES
(1, 'admin@test.ee', '$2y$04$AU51wB0xGadFQjFc5phO3uT0BM.qxhxnISaaWGQar7EIK/ey.1wyy', 1, NULL),
(2, 'teacher@test.ee', '$2y$04$ocbbROW65YQQev738HEsR.QLKnx4ZpNJJ.g6z9nbJrvuYnOYqyojC', 1, NULL),
(3, 'student@test.ee', '$2y$04$3h7XLsCS8AFUyKb0HUHfh.pa7j.5qfeTtpkL9qEMAqpci2fRfsIoq', 1, NULL);

--
-- Dumping data for table `Vocation`
--

INSERT INTO `Vocation` (`id`, `created_by`, `updated_by`, `name`, `vocationCode`, `durationEKAP`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Tarkvara arendaja', '123123', 240, NULL, '2016-05-08 10:39:25', NULL),
(2, 1, NULL, 'Multimeedia', '987654', 240, NULL, '2016-05-08 10:39:44', NULL);

--
-- Database: `lis`
--

--
-- Dumping data for table `Administrator`
--

INSERT INTO `Administrator` (`id`, `lis_user_id`, `created_by`, `updated_by`, `firstName`, `lastName`, `name`, `email`, `personalCode`, `superAdministrator`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'firstName572f16694ce14', 'lastName572f16694ce5f', 'lastName572f16694ce5f, firstName572f16694ce14', 'admin@test.ee', 'code572f16694cea4', 1, NULL, '2016-05-08 13:35:21', '2016-05-08 13:35:21');

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`id`, `created_by`, `updated_by`, `name`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '31', NULL, '2016-05-08 10:46:03', NULL),
(2, 1, NULL, '33', NULL, '2016-05-08 10:46:07', NULL);

--
-- Dumping data for table `GradeChoice`
--
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


--
-- Dumping data for table `GradingType`
--

INSERT INTO `GradingType` (`id`, `created_by`, `updated_by`, `name`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Eristav', NULL, '2016-05-08 10:38:29', NULL),
(2, 1, NULL, 'Mitte eristav', NULL, '2016-05-08 10:38:36', NULL);

--
-- Dumping data for table `ModuleType`
--

INSERT INTO `ModuleType` (`id`, `created_by`, `updated_by`, `name`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Põhiõpingud', NULL, '2016-05-08 10:39:04', NULL),
(2, 1, NULL, 'Valikõpingud', NULL, '2016-05-08 10:39:11', NULL);


--
-- Dumping data for table `Module`
--

INSERT INTO `Module` (`id`, `vocation_id`, `module_type_id`, `created_by`, `updated_by`, `name`, `duration`, `moduleCode`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 'Andmebaaside alused', 40, '456654', NULL, '2016-05-08 10:40:19', NULL),
(2, 1, 1, 1, NULL, 'Programmeerimise alused', 40, '321654', NULL, '2016-05-08 10:40:37', NULL);


--
-- Dumping data for table `GradingTypeToModule`
--

INSERT INTO `GradingTypeToModule` (`module_id`, `grading_type_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2);

--
-- Dumping data for table `Subject`
--

INSERT INTO `Subject` (`id`, `module_id`, `created_by`, `updated_by`, `subjectCode`, `name`, `durationAllAK`, `durationContactAK`, `durationIndependentAK`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '654987', 'Andmebaaside alused', 40, 25, 15, NULL, '2016-05-08 10:41:31', NULL),
(2, 2, 1, NULL, '654879', 'Programmeerimise alused', 40, 25, 15, NULL, '2016-05-08 10:41:56', NULL);

--
-- Dumping data for table `GradingTypeToSubject`
--

INSERT INTO `GradingTypeToSubject` (`subject_id`, `grading_type_id`) VALUES
(1, 1),
(2, 1);

--
-- Dumping data for table `StudentGroup`
--

INSERT INTO `StudentGroup` (`id`, `vocation_id`, `created_by`, `updated_by`, `name`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'TA_2014', NULL, '2016-05-08 10:43:56', NULL),
(2, 2, 1, NULL, 'MM_2014', NULL, '2016-05-08 10:44:16', NULL),
(3, 1, 1, NULL, 'TA_2015', NULL, '2016-05-08 10:44:24', NULL);

--
-- Dumping data for table `Teacher`
--

INSERT INTO `Teacher` (`id`, `lis_user_id`, `created_by`, `updated_by`, `firstName`, `lastName`, `name`, `email`, `personalCode`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 'Silver', 'Silluta', 'Silluta, Silver', 'teacher@test.ee', 'code572f167069f62', NULL, '2016-05-08 13:35:28', '2016-05-08 13:35:28');

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`id`, `lis_user_id`, `created_by`, `updated_by`, `firstName`, `lastName`, `name`, `email`, `personalCode`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 1, 'Jane', 'Doe', 'Doe, Jane', 'jane.doe@test.ee', '48816045555', 0, '2016-05-08 13:35:34', '2016-05-08 10:43:19'),
(2, NULL, 1, NULL, 'John', 'Doe', 'Doe, John', 'john.doe@test.ee', '38110034444', NULL, '2016-05-08 10:42:55', NULL);

--
-- Dumping data for table `SubjectRound`
--

INSERT INTO `SubjectRound` (`id`, `subject_id`, `group_id`, `module_id`, `vocation_id`, `created_by`, `updated_by`, `name`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 'Andmebaaside alused', 0, '2016-05-08 10:48:17', '2016-05-08 10:48:56'),
(2, 2, 1, 2, 1, 1, NULL, 'Programeerimise alused', NULL, '2016-05-08 10:54:07', NULL);

--
-- Dumping data for table `IndependentWork`
--

INSERT INTO `IndependentWork` (`id`, `subject_round_id`, `teacher_id`, `created_by`, `updated_by`, `duedate`, `name`, `description`, `durationAK`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, NULL, '2016-05-31 00:00:00', 'Andmebaas', 'Loo hobuste andmebaas', 10, NULL, '2016-05-08 00:00:00', NULL),
(2, 1, 1, 2, NULL, '2016-06-01 00:00:00', 'Andmebaas ORM', 'Loo hobuste andmebaas', 20, NULL, '2016-05-08 00:00:00', NULL);

--
-- Dumping data for table `StudentInGroups`
--

INSERT INTO `StudentInGroups` (`id`, `student_id`, `student_group_id`, `created_by`, `updated_by`, `status`, `notes`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 1, NULL, NULL, '2016-05-08 10:45:30', NULL),
(2, 2, 1, 1, NULL, 1, NULL, NULL, '2016-05-08 10:45:39', NULL);

--
-- Dumping data for table `TeacherToSubjectRound`
--

INSERT INTO `TeacherToSubjectRound` (`subject_round_id`, `teacher_id`) VALUES
(1, 1),
(2, 1);

--
-- Dumping data for table `ContactLesson`
--

INSERT INTO `ContactLesson` (`id`, `rooms_id`, `subject_round_id`, `student_group_id`, `module_id`, `vocation_id`, `teacher_id`, `created_by`, `updated_by`, `name`, `lessonDate`, `description`, `sequenceNr`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, NULL, 'TA_2014-01.06.2016-1', '2016-06-01 00:00:00', NULL, 1, NULL, '2016-05-08 11:02:19', NULL),
(2, 1, 1, 1, 1, 1, 1, 1, NULL, 'TA_2014-01.06.2016-2', '2016-06-01 00:00:00', NULL, 2, NULL, '2016-05-08 11:02:27', NULL),
(3, 1, 1, 1, 1, 1, 1, 1, NULL, 'TA_2014-01.06.2016-3', '2016-06-01 00:00:00', NULL, 3, NULL, '2016-05-08 11:02:34', NULL),
(4, 1, 1, 1, 1, 1, 1, 1, NULL, 'TA_2014-01.06.2016-4', '2016-06-01 00:00:00', NULL, 4, NULL, '2016-05-08 11:02:40', NULL),
(5, 2, 1, 1, 1, 1, 1, 1, 1, 'TA_2014-02.06.2016-1', '2016-06-02 00:00:00', NULL, 1, 0, '2016-05-08 11:02:49', '2016-05-08 11:03:25'),
(6, 2, 1, 1, 1, 1, 1, 1, 1, 'TA_2014-02.06.2016-2', '2016-06-02 00:00:00', NULL, 2, 0, '2016-05-08 11:03:07', '2016-05-08 11:03:25');

--
-- Dumping data for table `StudentGrade`
--

INSERT INTO `StudentGrade` (`id`, `student_id`, `grade_choice_id`, `teacher_id`, `independent_work_id`, `module_id`, `subject_round_id`, `contact_lesson_id`, `created_by`, `updated_by`, `notes`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(2, 1, 3, 1, NULL, NULL, NULL, 2, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(3, 1, 3, 1, NULL, NULL, NULL, 4, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(4, 1, 4, 1, NULL, NULL, NULL, 5, 2, NULL, NULL, NULL, '2016-06-07 00:00:00', NULL),
(5, 1, 6, 1, 1, NULL, NULL, NULL, 2, NULL, 'Tehtud', NULL, '2016-05-05 00:00:00', NULL),
(6, 1, 3, 1, NULL, 1, NULL, NULL, 2, NULL, 'Note', 0, '2016-05-08 00:00:00', NULL),
(7, 1, 4, 1, NULL, NULL, 1, NULL, 2, NULL, 'Tehtud', NULL, '2016-05-09 00:00:00', NULL),
(8, 1, 6, 1, 2, NULL, NULL, NULL, 2, NULL, 'Tehtud', NULL, '2016-05-05 00:00:00', NULL);

