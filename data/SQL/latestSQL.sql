-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2015 at 02:08 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `lis`
--

-- --------------------------------------------------------

--
-- Table structure for table `Absence`
--

CREATE TABLE IF NOT EXISTS `Absence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `absence_reason_id` int(11) DEFAULT NULL,
  `student_id` bigint(20) NOT NULL,
  `contact_lesson_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9E7D955E1E51A10` (`absence_reason_id`),
  KEY `IDX_B9E7D955CB944F1A` (`student_id`),
  KEY `IDX_B9E7D955A30922ED` (`contact_lesson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `AbsenceReason`
--

CREATE TABLE IF NOT EXISTS `AbsenceReason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Administrator`
--

CREATE TABLE IF NOT EXISTS `Administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) NOT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EBA14DA477153098` (`code`),
  UNIQUE KEY `UNIQ_EBA14DA463918838` (`lis_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ContactLesson`
--

CREATE TABLE IF NOT EXISTS `ContactLesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_round_id` bigint(20) NOT NULL,
  `lessonDate` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationAK` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EBB4C6A39E7D1CC8` (`subject_round_id`),
  KEY `contactlessonlessondate` (`lessonDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GradeChoice`
--

CREATE TABLE IF NOT EXISTS `GradeChoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GradeIndependentWork`
--

CREATE TABLE IF NOT EXISTS `GradeIndependentWork` (
  `id` int(11) NOT NULL,
  `independent_work_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_25FD4330EA0B7FD9` (`independent_work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GradeModule`
--

CREATE TABLE IF NOT EXISTS `GradeModule` (
  `id` int(11) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1A35327CAFC2B591` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GradeSubjectRound`
--

CREATE TABLE IF NOT EXISTS `GradeSubjectRound` (
  `id` int(11) NOT NULL,
  `subject_round_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_39B1A56B9E7D1CC8` (`subject_round_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GradingType`
--

CREATE TABLE IF NOT EXISTS `GradingType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gradingType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GradingTypeToModule`
--

CREATE TABLE IF NOT EXISTS `GradingTypeToModule` (
  `module_id` bigint(20) NOT NULL,
  `grading_type_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`,`grading_type_id`),
  KEY `IDX_444C5752AFC2B591` (`module_id`),
  KEY `IDX_444C5752F54FA8CE` (`grading_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GradingTypeToSubject`
--

CREATE TABLE IF NOT EXISTS `GradingTypeToSubject` (
  `subject_id` bigint(20) NOT NULL,
  `grading_type_id` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`,`grading_type_id`),
  KEY `IDX_4B56CE2923EDC87` (`subject_id`),
  KEY `IDX_4B56CE29F54FA8CE` (`grading_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vocation_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AC016BC14A14BDC1` (`vocation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `IndependentWork`
--

CREATE TABLE IF NOT EXISTS `IndependentWork` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_round_id` bigint(20) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `duedate` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationAK` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E5124F99E7D1CC8` (`subject_round_id`),
  KEY `IDX_6E5124F941807E1D` (`teacher_id`),
  KEY `homeworkdate` (`duedate`),
  KEY `independentworkduedate` (`duedate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `LisUser`
--

CREATE TABLE IF NOT EXISTS `LisUser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_83ABA295E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Module`
--

CREATE TABLE IF NOT EXISTS `Module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vocation_id` bigint(20) NOT NULL,
  `module_type_id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B88231E4A14BDC1` (`vocation_id`),
  KEY `IDX_B88231E6E37B28A` (`module_type_id`),
  KEY `modulename` (`name`),
  KEY `modulecode` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModuleType`
--

CREATE TABLE IF NOT EXISTS `ModuleType` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moduletypename` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE IF NOT EXISTS `Rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `RoomsToContactLesson`
--

CREATE TABLE IF NOT EXISTS `RoomsToContactLesson` (
  `contact_lesson_id` int(11) NOT NULL,
  `rooms_id` int(11) NOT NULL,
  PRIMARY KEY (`contact_lesson_id`,`rooms_id`),
  KEY `IDX_841B4FA0A30922ED` (`contact_lesson_id`),
  KEY `IDX_841B4FA08E2368AB` (`rooms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE IF NOT EXISTS `Student` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) NOT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_789E96AF77153098` (`code`),
  UNIQUE KEY `UNIQ_789E96AF63918838` (`lis_user_id`),
  KEY `IDX_789E96AFFE54D947` (`group_id`),
  KEY `studentcode` (`code`),
  KEY `studentfirstname` (`firstName`),
  KEY `studentlastname` (`lastName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `StudentGrade`
--

CREATE TABLE IF NOT EXISTS `StudentGrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `grade_choice_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `dtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2AC510BCB944F1A` (`student_id`),
  KEY `IDX_E2AC510BEBCFFF9A` (`grade_choice_id`),
  KEY `IDX_E2AC510B41807E1D` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Subject`
--

CREATE TABLE IF NOT EXISTS `Subject` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationAllAK` int(11) NOT NULL,
  `durationContactAK` int(11) NOT NULL,
  `durationIndependentAK` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_347307E6AFC2B591` (`module_id`),
  KEY `subjectname` (`name`),
  KEY `subjectcode` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `SubjectRound`
--

CREATE TABLE IF NOT EXISTS `SubjectRound` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3F1EA0823EDC87` (`subject_id`),
  KEY `IDX_D3F1EA08FE54D947` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Teacher`
--

CREATE TABLE IF NOT EXISTS `Teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7F4B9F4977153098` (`code`),
  UNIQUE KEY `UNIQ_7F4B9F4963918838` (`lis_user_id`),
  KEY `teachercode` (`code`),
  KEY `teacherfirstname` (`firstName`),
  KEY `teacherlastname` (`lastName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TeacherToContactLesson`
--

CREATE TABLE IF NOT EXISTS `TeacherToContactLesson` (
  `contact_lesson_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`contact_lesson_id`,`teacher_id`),
  KEY `IDX_EEF902AFA30922ED` (`contact_lesson_id`),
  KEY `IDX_EEF902AF41807E1D` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TeacherToSubjectRound`
--

CREATE TABLE IF NOT EXISTS `TeacherToSubjectRound` (
  `subject_round_id` bigint(20) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`subject_round_id`,`teacher_id`),
  KEY `IDX_9E62F5CF9E7D1CC8` (`subject_round_id`),
  KEY `IDX_9E62F5CF41807E1D` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Vocation`
--

CREATE TABLE IF NOT EXISTS `Vocation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationEKAP` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4A93C67E77153098` (`code`),
  KEY `vocationname` (`name`),
  KEY `vocationcode` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Absence`
--
ALTER TABLE `Absence`
  ADD CONSTRAINT `FK_B9E7D955A30922ED` FOREIGN KEY (`contact_lesson_id`) REFERENCES `ContactLesson` (`id`),
  ADD CONSTRAINT `FK_B9E7D955CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  ADD CONSTRAINT `FK_B9E7D955E1E51A10` FOREIGN KEY (`absence_reason_id`) REFERENCES `AbsenceReason` (`id`);

--
-- Constraints for table `Administrator`
--
ALTER TABLE `Administrator`
  ADD CONSTRAINT `FK_EBA14DA463918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`);

--
-- Constraints for table `ContactLesson`
--
ALTER TABLE `ContactLesson`
  ADD CONSTRAINT `FK_EBB4C6A39E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `GradeIndependentWork`
--
ALTER TABLE `GradeIndependentWork`
  ADD CONSTRAINT `FK_25FD4330BF396750` FOREIGN KEY (`id`) REFERENCES `StudentGrade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_25FD4330EA0B7FD9` FOREIGN KEY (`independent_work_id`) REFERENCES `IndependentWork` (`id`);

--
-- Constraints for table `GradeModule`
--
ALTER TABLE `GradeModule`
  ADD CONSTRAINT `FK_1A35327CBF396750` FOREIGN KEY (`id`) REFERENCES `StudentGrade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1A35327CAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`);

--
-- Constraints for table `GradeSubjectRound`
--
ALTER TABLE `GradeSubjectRound`
  ADD CONSTRAINT `FK_39B1A56BBF396750` FOREIGN KEY (`id`) REFERENCES `StudentGrade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_39B1A56B9E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`);

--
-- Constraints for table `GradingTypeToModule`
--
ALTER TABLE `GradingTypeToModule`
  ADD CONSTRAINT `FK_444C5752F54FA8CE` FOREIGN KEY (`grading_type_id`) REFERENCES `GradingType` (`id`),
  ADD CONSTRAINT `FK_444C5752AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `GradingTypeToSubject`
--
ALTER TABLE `GradingTypeToSubject`
  ADD CONSTRAINT `FK_4B56CE29F54FA8CE` FOREIGN KEY (`grading_type_id`) REFERENCES `GradingType` (`id`),
  ADD CONSTRAINT `FK_4B56CE2923EDC87` FOREIGN KEY (`subject_id`) REFERENCES `Subject` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Group`
--
ALTER TABLE `Group`
  ADD CONSTRAINT `FK_AC016BC14A14BDC1` FOREIGN KEY (`vocation_id`) REFERENCES `Vocation` (`id`);

--
-- Constraints for table `IndependentWork`
--
ALTER TABLE `IndependentWork`
  ADD CONSTRAINT `FK_6E5124F941807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  ADD CONSTRAINT `FK_6E5124F99E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Module`
--
ALTER TABLE `Module`
  ADD CONSTRAINT `FK_B88231E6E37B28A` FOREIGN KEY (`module_type_id`) REFERENCES `ModuleType` (`id`),
  ADD CONSTRAINT `FK_B88231E4A14BDC1` FOREIGN KEY (`vocation_id`) REFERENCES `Vocation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `RoomsToContactLesson`
--
ALTER TABLE `RoomsToContactLesson`
  ADD CONSTRAINT `FK_841B4FA08E2368AB` FOREIGN KEY (`rooms_id`) REFERENCES `Rooms` (`id`),
  ADD CONSTRAINT `FK_841B4FA0A30922ED` FOREIGN KEY (`contact_lesson_id`) REFERENCES `ContactLesson` (`id`);

--
-- Constraints for table `Student`
--
ALTER TABLE `Student`
  ADD CONSTRAINT `FK_789E96AFFE54D947` FOREIGN KEY (`group_id`) REFERENCES `Group` (`id`),
  ADD CONSTRAINT `FK_789E96AF63918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`);

--
-- Constraints for table `StudentGrade`
--
ALTER TABLE `StudentGrade`
  ADD CONSTRAINT `FK_E2AC510B41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  ADD CONSTRAINT `FK_E2AC510BCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  ADD CONSTRAINT `FK_E2AC510BEBCFFF9A` FOREIGN KEY (`grade_choice_id`) REFERENCES `GradeChoice` (`id`);

--
-- Constraints for table `Subject`
--
ALTER TABLE `Subject`
  ADD CONSTRAINT `FK_347307E6AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `SubjectRound`
--
ALTER TABLE `SubjectRound`
  ADD CONSTRAINT `FK_D3F1EA08FE54D947` FOREIGN KEY (`group_id`) REFERENCES `Group` (`id`),
  ADD CONSTRAINT `FK_D3F1EA0823EDC87` FOREIGN KEY (`subject_id`) REFERENCES `Subject` (`id`);

--
-- Constraints for table `Teacher`
--
ALTER TABLE `Teacher`
  ADD CONSTRAINT `FK_7F4B9F4963918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`);

--
-- Constraints for table `TeacherToContactLesson`
--
ALTER TABLE `TeacherToContactLesson`
  ADD CONSTRAINT `FK_EEF902AF41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  ADD CONSTRAINT `FK_EEF902AFA30922ED` FOREIGN KEY (`contact_lesson_id`) REFERENCES `ContactLesson` (`id`);

--
-- Constraints for table `TeacherToSubjectRound`
--
ALTER TABLE `TeacherToSubjectRound`
  ADD CONSTRAINT `FK_9E62F5CF41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  ADD CONSTRAINT `FK_9E62F5CF9E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`);

