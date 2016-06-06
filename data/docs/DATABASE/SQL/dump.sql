-- MySQL dump 10.13  Distrib 5.7.11, for osx10.9 (x86_64)
--
-- Host: localhost    Database: lis
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Absence`
--

DROP TABLE IF EXISTS `Absence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Absence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `absence_reason_id` bigint(20) DEFAULT NULL,
  `student_id` bigint(20) NOT NULL,
  `contact_lesson_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9E7D955E1E51A10` (`absence_reason_id`),
  KEY `IDX_B9E7D955CB944F1A` (`student_id`),
  KEY `IDX_B9E7D955A30922ED` (`contact_lesson_id`),
  KEY `IDX_B9E7D955DE12AB56` (`created_by`),
  KEY `IDX_B9E7D95516FE72E1` (`updated_by`),
  KEY `absence_index_trashed` (`trashed`),
  CONSTRAINT `FK_B9E7D95516FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_B9E7D955A30922ED` FOREIGN KEY (`contact_lesson_id`) REFERENCES `ContactLesson` (`id`),
  CONSTRAINT `FK_B9E7D955CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  CONSTRAINT `FK_B9E7D955DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_B9E7D955E1E51A10` FOREIGN KEY (`absence_reason_id`) REFERENCES `AbsenceReason` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Absence`
--

LOCK TABLES `Absence` WRITE;
/*!40000 ALTER TABLE `Absence` DISABLE KEYS */;
/*!40000 ALTER TABLE `Absence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AbsenceReason`
--

DROP TABLE IF EXISTS `AbsenceReason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AbsenceReason` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6595B548DE12AB56` (`created_by`),
  KEY `IDX_6595B54816FE72E1` (`updated_by`),
  KEY `absencereason_index_trashed` (`trashed`),
  CONSTRAINT `FK_6595B54816FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_6595B548DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AbsenceReason`
--

LOCK TABLES `AbsenceReason` WRITE;
/*!40000 ALTER TABLE `AbsenceReason` DISABLE KEYS */;
/*!40000 ALTER TABLE `AbsenceReason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Administrator`
--

DROP TABLE IF EXISTS `Administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Administrator` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `personalCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `superAdministrator` int(11) NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EBA14DA4FEC554F2` (`personalCode`),
  UNIQUE KEY `UNIQ_EBA14DA463918838` (`lis_user_id`),
  KEY `IDX_EBA14DA4DE12AB56` (`created_by`),
  KEY `IDX_EBA14DA416FE72E1` (`updated_by`),
  KEY `administrator_index_trashed` (`trashed`),
  CONSTRAINT `FK_EBA14DA416FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_EBA14DA463918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_EBA14DA4DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Administrator`
--

LOCK TABLES `Administrator` WRITE;
/*!40000 ALTER TABLE `Administrator` DISABLE KEYS */;
INSERT INTO `Administrator` VALUES (1,10,NULL,NULL,'firstName572338ed83515','lastName572338ed83527','lastName572338ed83527, firstName572338ed83515','adminemail572338ed8353d@mail.ee','code572338ed83533',0,NULL,'2016-04-29 10:35:25','2016-04-29 10:35:25'),(2,11,NULL,NULL,'firstName572338ed9c7dc','lastName572338ed9c7f4','lastName572338ed9c7f4, firstName572338ed9c7dc','adminemail572338ed9c804@mail.ee','code572338ed9c7fc',0,NULL,'2016-04-29 10:35:25','2016-04-29 10:35:25'),(3,12,NULL,NULL,'firstName572338eda6ba1','lastName572338eda6bb9','lastName572338eda6bb9, firstName572338eda6ba1','adminemail572338eda6bc7@mail.ee','code572338eda6bc0',0,NULL,'2016-04-29 10:35:25','2016-04-29 10:35:25'),(4,13,NULL,NULL,'firstName572338edb2d17','lastName572338edb2d2b','lastName572338edb2d2b, firstName572338edb2d17','admin@test.ee','code572338edb2d31',0,NULL,'2016-04-29 10:35:25','2016-04-29 10:35:25');
/*!40000 ALTER TABLE `Administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContactLesson`
--

DROP TABLE IF EXISTS `ContactLesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContactLesson` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rooms_id` bigint(20) NOT NULL,
  `subject_round_id` bigint(20) NOT NULL,
  `student_group_id` bigint(20) NOT NULL,
  `module_id` bigint(20) NOT NULL,
  `vocation_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lessonDate` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequenceNr` int(11) NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EBB4C6A38E2368AB` (`rooms_id`),
  KEY `IDX_EBB4C6A39E7D1CC8` (`subject_round_id`),
  KEY `IDX_EBB4C6A34DDF95DC` (`student_group_id`),
  KEY `IDX_EBB4C6A3AFC2B591` (`module_id`),
  KEY `IDX_EBB4C6A34A14BDC1` (`vocation_id`),
  KEY `IDX_EBB4C6A341807E1D` (`teacher_id`),
  KEY `IDX_EBB4C6A3DE12AB56` (`created_by`),
  KEY `IDX_EBB4C6A316FE72E1` (`updated_by`),
  KEY `contactlesson_index_lessondate` (`lessonDate`),
  KEY `contactlesson_trashed` (`trashed`),
  KEY `contactlesson_description` (`description`),
  KEY `contactlesson_name` (`name`),
  KEY `contactlesson_sequenceNr` (`sequenceNr`),
  CONSTRAINT `FK_EBB4C6A316FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_EBB4C6A341807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EBB4C6A34A14BDC1` FOREIGN KEY (`vocation_id`) REFERENCES `Vocation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EBB4C6A34DDF95DC` FOREIGN KEY (`student_group_id`) REFERENCES `StudentGroup` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EBB4C6A38E2368AB` FOREIGN KEY (`rooms_id`) REFERENCES `Rooms` (`id`),
  CONSTRAINT `FK_EBB4C6A39E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EBB4C6A3AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_EBB4C6A3DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContactLesson`
--

LOCK TABLES `ContactLesson` WRITE;
/*!40000 ALTER TABLE `ContactLesson` DISABLE KEYS */;
INSERT INTO `ContactLesson` VALUES (1,1,1,1,1,1,5,13,NULL,'TA2014-29.04.2016-1','2016-04-29 00:00:00','kes teab mis siia läheb',1,NULL,'2016-04-30 15:56:42',NULL),(2,1,1,1,1,1,5,13,NULL,'TA2014-29.04.2016-2','2016-04-29 00:00:00','kes teab mis siia läheb',2,NULL,'2016-04-30 15:57:18',NULL);
/*!40000 ALTER TABLE `ContactLesson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GradeChoice`
--

DROP TABLE IF EXISTS `GradeChoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GradeChoice` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D7BA4EC6DE12AB56` (`created_by`),
  KEY `IDX_D7BA4EC616FE72E1` (`updated_by`),
  KEY `gradechoice_index_trashed` (`trashed`),
  CONSTRAINT `FK_D7BA4EC616FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_D7BA4EC6DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GradeChoice`
--

LOCK TABLES `GradeChoice` WRITE;
/*!40000 ALTER TABLE `GradeChoice` DISABLE KEYS */;
INSERT INTO `GradeChoice` VALUES (1,13,NULL,'1',NULL,'2016-04-30 15:39:51',NULL),(2,13,NULL,'2',NULL,'2016-04-30 15:39:54',NULL),(3,13,NULL,'3',NULL,'2016-04-30 15:39:56',NULL),(4,13,NULL,'4',NULL,'2016-04-30 15:39:58',NULL),(5,13,NULL,'5',NULL,'2016-04-30 15:40:02',NULL),(6,13,NULL,'A',NULL,'2016-04-30 15:40:05',NULL),(7,13,NULL,'MA',NULL,'2016-04-30 15:40:09',NULL);
/*!40000 ALTER TABLE `GradeChoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GradingType`
--

DROP TABLE IF EXISTS `GradingType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GradingType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_739B38C9DE12AB56` (`created_by`),
  KEY `IDX_739B38C916FE72E1` (`updated_by`),
  KEY `name` (`name`),
  KEY `gradingtype_index_trashed` (`trashed`),
  CONSTRAINT `FK_739B38C916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_739B38C9DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GradingType`
--

LOCK TABLES `GradingType` WRITE;
/*!40000 ALTER TABLE `GradingType` DISABLE KEYS */;
INSERT INTO `GradingType` VALUES (1,13,NULL,'Arvestuslik',NULL,'2016-04-30 15:40:24',NULL),(2,13,13,'Hindeline',0,'2016-04-30 15:40:31','2016-04-30 15:41:00');
/*!40000 ALTER TABLE `GradingType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GradingTypeToModule`
--

DROP TABLE IF EXISTS `GradingTypeToModule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GradingTypeToModule` (
  `module_id` bigint(20) NOT NULL,
  `grading_type_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`,`grading_type_id`),
  KEY `IDX_444C5752AFC2B591` (`module_id`),
  KEY `IDX_444C5752F54FA8CE` (`grading_type_id`),
  CONSTRAINT `FK_444C5752AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_444C5752F54FA8CE` FOREIGN KEY (`grading_type_id`) REFERENCES `GradingType` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GradingTypeToModule`
--

LOCK TABLES `GradingTypeToModule` WRITE;
/*!40000 ALTER TABLE `GradingTypeToModule` DISABLE KEYS */;
INSERT INTO `GradingTypeToModule` VALUES (1,1),(2,1),(1,2),(2,2);
/*!40000 ALTER TABLE `GradingTypeToModule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GradingTypeToSubject`
--

DROP TABLE IF EXISTS `GradingTypeToSubject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GradingTypeToSubject` (
  `subject_id` bigint(20) NOT NULL,
  `grading_type_id` int(11) NOT NULL,
  PRIMARY KEY (`subject_id`,`grading_type_id`),
  KEY `IDX_4B56CE2923EDC87` (`subject_id`),
  KEY `IDX_4B56CE29F54FA8CE` (`grading_type_id`),
  CONSTRAINT `FK_4B56CE2923EDC87` FOREIGN KEY (`subject_id`) REFERENCES `Subject` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4B56CE29F54FA8CE` FOREIGN KEY (`grading_type_id`) REFERENCES `GradingType` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GradingTypeToSubject`
--

LOCK TABLES `GradingTypeToSubject` WRITE;
/*!40000 ALTER TABLE `GradingTypeToSubject` DISABLE KEYS */;
INSERT INTO `GradingTypeToSubject` VALUES (1,1),(2,1),(1,2),(2,2);
/*!40000 ALTER TABLE `GradingTypeToSubject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `IndependentWork`
--

DROP TABLE IF EXISTS `IndependentWork`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IndependentWork` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_round_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `duedate` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationAK` int(11) NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E5124F99E7D1CC8` (`subject_round_id`),
  KEY `IDX_6E5124F941807E1D` (`teacher_id`),
  KEY `IDX_6E5124F9CB944F1A` (`student_id`),
  KEY `IDX_6E5124F9DE12AB56` (`created_by`),
  KEY `IDX_6E5124F916FE72E1` (`updated_by`),
  KEY `independentwork_index_trashed` (`trashed`),
  KEY `independentworkduedate` (`duedate`),
  CONSTRAINT `FK_6E5124F916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_6E5124F941807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  CONSTRAINT `FK_6E5124F99E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`),
  CONSTRAINT `FK_6E5124F9CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  CONSTRAINT `FK_6E5124F9DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `IndependentWork`
--

LOCK TABLES `IndependentWork` WRITE;
/*!40000 ALTER TABLE `IndependentWork` DISABLE KEYS */;
/*!40000 ALTER TABLE `IndependentWork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LisUser`
--

DROP TABLE IF EXISTS `LisUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LisUser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT '1',
  `trashed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_83ABA295E7927C74` (`email`),
  KEY `lisuser_index_trashed` (`trashed`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LisUser`
--

LOCK TABLES `LisUser` WRITE;
/*!40000 ALTER TABLE `LisUser` DISABLE KEYS */;
INSERT INTO `LisUser` VALUES (1,'student@test.ee','$2y$04$hvr8ESw9l676VAqB5leKB.uSEtvMen.jNCPeSeotHCWIy3zwCeC02',1,NULL),(2,'572338b6b2ab6@test.ee','$2y$04$JtyEYstAfhx0dhGVD6qhv.Fl2yEJg42zV76usJEtogW1PpG3E36BC',1,NULL),(3,'572338b6d1e32@test.ee','$2y$04$A56K89X1rWcqNOoY//wMrOsSDcRGpMw/MxKLeg3EJ7KqEhz5ZJWGO',1,NULL),(4,'572338b6e1090@test.ee','$2y$04$JKGDgWrWNhIcYH6hyuBHteHGrlkFP13D0FL49GXt0chp6nyvfw1oq',1,NULL),(6,'572338cedd471@test.ee','$2y$04$pZIKKErqwhWPadNEGMcZdezLB.y1dVnaY9mouejizrLv9CndyQe/G',1,NULL),(7,'572338cef0298@test.ee','$2y$04$Npf.gfHnBP5XmRFKjmTIGOPAYii26P70Rd9o1zdtO2Tf7k3Ghh9ei',1,NULL),(8,'572338cf07b8b@test.ee','$2y$04$Z14IKE0ONp3eVsBOcsyJS.5iDG7CFgo/yUgRyafnC30diDT0kPUxW',1,NULL),(9,'teacher@test.ee','$2y$04$vcdayejPfiR74JXB5EatU.RDbJbwnEtoHeNO3ovCZHzjzQc8dScZC',1,NULL),(10,'572338ed90e33@test.ee','$2y$04$DXA/U6YTXLTDy7sbSV5OK.rzG9fCP7z3qwa4jr5PyEl1Rw4xUEy3i',1,NULL),(11,'572338eda1aea@test.ee','$2y$04$FSzF9pb6vhi7TP0Ms421DOTz134OqPJku4uU6ZAfp.rOCbQf19AVa',1,NULL),(12,'572338edacfc9@test.ee','$2y$04$NCP/T9a4IjDftQTCr4m8pO0bM65K/Q0txyvlCs.ru4yoAWneARzLC',1,NULL),(13,'admin@test.ee','$2y$04$yHc4UIGbq./0sgTjd1J1eeAoPVBjESNd5eP.WeHSGTKdX9a4Ose2i',1,NULL),(14,'5725db0d3e7d0@asd.ee','$2y$04$x89inJ53u9/jDk/7fY30ouSC8/KpyYSrfi72.UINB/OhaJ1IjR0Ju',1,NULL),(15,'5725db3504882@asd.ee','$2y$04$hwRDMqcVzoVHX0p8TD1GlOoSEwF2CiLmriRNUd1cEjlvi/3Da8mci',1,NULL),(16,'5725dc944a929@asd.ee','$2y$04$Gfv.1sRYOSVFMOLgvtxvcO5SuX9aZN0h8oEPowXa5n9RF0xRGuFlO',1,NULL),(17,'5725dd7d411fb@asd.ee','$2y$04$0pXRnNic8kXRF90.zOXfHuTRWeK3EXEDADrUG9CHZSI7l3LOTdFWi',1,NULL),(18,'5725e1adddad0@asd.ee','$2y$04$teRgK6Hh0cLh5vWR6IaCMeb3PpCJZPcrabZEHlcZnvePw0MJe.BDa',1,NULL),(19,'5725e1c5d9541@asd.ee','$2y$04$xs3LJCGWFwVpOQY/7IQ9SuyRaKoBqA.VpsRdIzOOVsT0AENrIib.a',1,NULL),(20,'5725e1fc8e73f@asd.ee','$2y$04$EL1ak62VmjTJTwTGSsn4oOUE5f8k1G5c4UhkYrelawNtuDJ5R6liG',1,NULL),(21,'5725e2519c9be@asd.ee','$2y$04$dLBCwZYmDTv6iOX0JvlP0Olx.fVz8lJMEZjT.cbizx85nm4LjfK6S',1,NULL),(22,'5725e28678c31@asd.ee','$2y$04$gzGL9QyXQOKF6kr/EKdBxeYSiT63Oe9GEbb5vPodF/8N6PwF.taxu',1,NULL),(23,'5725e439d8d2f@asd.ee','$2y$04$6sRpkWs8P0.9P4eLAdAEkOO.HxNfDPPhDgbRLC.qVBuXQ6aAcFIiy',1,NULL),(24,'5725e4ca5655c@asd.ee','$2y$04$3tai.NxP5fAOs7Z4gApUOubj9qyYHlMas9Ua7X6zIuAeSWBbVKDuS',1,NULL),(25,'5725e4d88df0d@asd.ee','$2y$04$9zOhlpElpQjUXpB5HvI7a.aBkW/1It4g06qr/ILfHtwrdx.sgZL/e',1,NULL),(26,'5725e5ba39c3f@asd.ee','$2y$04$lvq2H6fFOPGMgE8qT0pLBepdt/dEZojcudlPs3LwSpNWB5WggzC6y',1,NULL),(27,'5725e6037d1ab@asd.ee','$2y$04$Wp5/YuElDUa1DbCJnVp1NON36Av.7yARbsdcOm.1Ql9LYiLmAztsq',1,NULL),(28,'5725e67346456@asd.ee','$2y$04$65jvpNuB/SJAk4hF/ExF.OFf8z3iELJR8ieFUnlIsP982.hJ81SaW',1,NULL),(29,'5725e693dcf45@asd.ee','$2y$04$7XHbLrcvXrWIkDrYYQnvnO9vYhNvOVGUlwEj8MkYCcw9yxWBgfQkm',1,NULL),(30,'5725e6cb3eac5@asd.ee','$2y$04$OblLtVrAvIaBrF4HJzqZNu4xp7LMg03v0Lc0GzbetfEGb.CfLYxhG',1,NULL),(31,'5725e74908f0f@asd.ee','$2y$04$1zOj2oqwhRWOQV.hXbgjiuW2RuomL1EqCUSL4Xh0nL8NKpHpKm5xK',1,NULL),(32,'5725e75dd1771@asd.ee','$2y$04$33ubLoDM9yd9.3IvwSGdwuy5yCLW4R55X3EPsRmgbWJyXzC7yu6.K',1,NULL);
/*!40000 ALTER TABLE `LisUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Module`
--

DROP TABLE IF EXISTS `Module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Module` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vocation_id` bigint(20) NOT NULL,
  `module_type_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `moduleCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B88231E4A14BDC1` (`vocation_id`),
  KEY `IDX_B88231E6E37B28A` (`module_type_id`),
  KEY `IDX_B88231EDE12AB56` (`created_by`),
  KEY `IDX_B88231E16FE72E1` (`updated_by`),
  KEY `modulename` (`name`),
  KEY `modulecode` (`moduleCode`),
  KEY `moduleduration` (`duration`),
  KEY `module_trashed` (`trashed`),
  CONSTRAINT `FK_B88231E16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_B88231E4A14BDC1` FOREIGN KEY (`vocation_id`) REFERENCES `Vocation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B88231E6E37B28A` FOREIGN KEY (`module_type_id`) REFERENCES `ModuleType` (`id`),
  CONSTRAINT `FK_B88231EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Module`
--

LOCK TABLES `Module` WRITE;
/*!40000 ALTER TABLE `Module` DISABLE KEYS */;
INSERT INTO `Module` VALUES (1,1,1,13,NULL,'Andmebaasid',60,'123456',NULL,'2016-04-30 15:41:43',NULL),(2,1,1,13,NULL,'Tarkvara arendus',60,'456789321',NULL,'2016-04-30 15:42:32',NULL);
/*!40000 ALTER TABLE `Module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ModuleType`
--

DROP TABLE IF EXISTS `ModuleType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ModuleType` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C2A9EBC9DE12AB56` (`created_by`),
  KEY `IDX_C2A9EBC916FE72E1` (`updated_by`),
  KEY `moduletype_name` (`name`),
  KEY `moduletype_index_trashed` (`trashed`),
  CONSTRAINT `FK_C2A9EBC916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_C2A9EBC9DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ModuleType`
--

LOCK TABLES `ModuleType` WRITE;
/*!40000 ALTER TABLE `ModuleType` DISABLE KEYS */;
INSERT INTO `ModuleType` VALUES (1,13,13,'Põhimoodul',0,'2016-04-30 15:39:22','2016-04-30 15:39:33'),(2,13,NULL,'Valikmoodul',NULL,'2016-04-30 15:39:39',NULL);
/*!40000 ALTER TABLE `ModuleType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rooms`
--

DROP TABLE IF EXISTS `Rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rooms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BD603592DE12AB56` (`created_by`),
  KEY `IDX_BD60359216FE72E1` (`updated_by`),
  KEY `roomname` (`name`),
  KEY `room_index_trashed` (`trashed`),
  CONSTRAINT `FK_BD60359216FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_BD603592DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rooms`
--

LOCK TABLES `Rooms` WRITE;
/*!40000 ALTER TABLE `Rooms` DISABLE KEYS */;
INSERT INTO `Rooms` VALUES (1,13,NULL,'21',NULL,'2016-04-30 15:44:00',NULL),(2,13,NULL,'22',NULL,'2016-04-30 15:44:02',NULL);
/*!40000 ALTER TABLE `Rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Student`
--

DROP TABLE IF EXISTS `Student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Student` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `personalCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_789E96AFFEC554F2` (`personalCode`),
  UNIQUE KEY `UNIQ_789E96AF63918838` (`lis_user_id`),
  KEY `IDX_789E96AFDE12AB56` (`created_by`),
  KEY `IDX_789E96AF16FE72E1` (`updated_by`),
  KEY `studentcode` (`personalCode`),
  KEY `studentfirstname` (`firstName`),
  KEY `studentlastname` (`lastName`),
  KEY `studentname` (`name`),
  CONSTRAINT `FK_789E96AF16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_789E96AF63918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_789E96AFDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Student`
--

LOCK TABLES `Student` WRITE;
/*!40000 ALTER TABLE `Student` DISABLE KEYS */;
INSERT INTO `Student` VALUES (1,1,NULL,NULL,'firstName5723388783af8','lastName5723388783b0c','lastName5723388783b0c, firstName5723388783af8','student@test.ee','code5723388783b15',NULL,'2016-04-29 10:33:43','2016-04-29 10:33:43'),(2,2,NULL,NULL,'firstName572338b691d42','lastName572338b691d4c','lastName572338b691d4c, firstName572338b691d42','stdntemail572338b691d5b@gmail.com','code572338b691d55',NULL,'2016-04-29 10:34:30','2016-04-29 10:34:30'),(3,3,NULL,NULL,'firstName572338b6c86da','lastName572338b6c86f5','lastName572338b6c86f5, firstName572338b6c86da','stdntemail572338b6c870f@gmail.com','code572338b6c8706',NULL,'2016-04-29 10:34:30','2016-04-29 10:34:30'),(4,4,NULL,NULL,'firstName572338b6d822d','lastName572338b6d823f','lastName572338b6d823f, firstName572338b6d822d','stdntemail572338b6d8258@gmail.com','code572338b6d8248',NULL,'2016-04-29 10:34:30','2016-04-29 10:34:30'),(5,NULL,NULL,NULL,'firstName572338b6e77cf','lastName572338b6e77e7','lastName572338b6e77e7, firstName572338b6e77cf','student@test.ee','code572338b6e77ef',NULL,'2016-04-29 10:34:30',NULL),(6,NULL,13,NULL,'Eleri','Apsolon','Apsolon, Eleri','eleri@tere.ee','4881234587',NULL,'2016-04-30 15:44:58',NULL),(7,NULL,13,NULL,'Sander','Mets','Mets, Sander','mets@tere.ee','38154872423',NULL,'2016-04-30 15:45:12',NULL);
/*!40000 ALTER TABLE `Student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StudentGrade`
--

DROP TABLE IF EXISTS `StudentGrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StudentGrade` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `grade_choice_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `independent_work_id` bigint(20) DEFAULT NULL,
  `module_id` bigint(20) DEFAULT NULL,
  `subject_round_id` bigint(20) DEFAULT NULL,
  `contact_lesson_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2AC510BCB944F1A` (`student_id`),
  KEY `IDX_E2AC510BEBCFFF9A` (`grade_choice_id`),
  KEY `IDX_E2AC510B41807E1D` (`teacher_id`),
  KEY `IDX_E2AC510BEA0B7FD9` (`independent_work_id`),
  KEY `IDX_E2AC510BAFC2B591` (`module_id`),
  KEY `IDX_E2AC510B9E7D1CC8` (`subject_round_id`),
  KEY `IDX_E2AC510BA30922ED` (`contact_lesson_id`),
  KEY `IDX_E2AC510BDE12AB56` (`created_by`),
  KEY `IDX_E2AC510B16FE72E1` (`updated_by`),
  KEY `studentgrade_index_trashed` (`trashed`),
  CONSTRAINT `FK_E2AC510B16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_E2AC510B41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  CONSTRAINT `FK_E2AC510B9E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`),
  CONSTRAINT `FK_E2AC510BA30922ED` FOREIGN KEY (`contact_lesson_id`) REFERENCES `ContactLesson` (`id`),
  CONSTRAINT `FK_E2AC510BAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`),
  CONSTRAINT `FK_E2AC510BCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  CONSTRAINT `FK_E2AC510BDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_E2AC510BEA0B7FD9` FOREIGN KEY (`independent_work_id`) REFERENCES `IndependentWork` (`id`),
  CONSTRAINT `FK_E2AC510BEBCFFF9A` FOREIGN KEY (`grade_choice_id`) REFERENCES `GradeChoice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StudentGrade`
--

LOCK TABLES `StudentGrade` WRITE;
/*!40000 ALTER TABLE `StudentGrade` DISABLE KEYS */;
/*!40000 ALTER TABLE `StudentGrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StudentGroup`
--

DROP TABLE IF EXISTS `StudentGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StudentGroup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vocation_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D636BBFA4A14BDC1` (`vocation_id`),
  KEY `IDX_D636BBFADE12AB56` (`created_by`),
  KEY `IDX_D636BBFA16FE72E1` (`updated_by`),
  KEY `studentgroup_index_trashed` (`trashed`),
  CONSTRAINT `FK_D636BBFA16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_D636BBFA4A14BDC1` FOREIGN KEY (`vocation_id`) REFERENCES `Vocation` (`id`),
  CONSTRAINT `FK_D636BBFADE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StudentGroup`
--

LOCK TABLES `StudentGroup` WRITE;
/*!40000 ALTER TABLE `StudentGroup` DISABLE KEYS */;
INSERT INTO `StudentGroup` VALUES (1,1,13,NULL,'TA2014',NULL,'2016-04-30 15:45:36',NULL);
/*!40000 ALTER TABLE `StudentGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StudentInGroups`
--

DROP TABLE IF EXISTS `StudentInGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StudentInGroups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `student_group_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DFC1C6E9CB944F1A` (`student_id`),
  KEY `IDX_DFC1C6E94DDF95DC` (`student_group_id`),
  KEY `IDX_DFC1C6E9DE12AB56` (`created_by`),
  KEY `IDX_DFC1C6E916FE72E1` (`updated_by`),
  KEY `studentingroups_index_trashed` (`trashed`),
  KEY `studentingroups_index_status` (`status`),
  CONSTRAINT `FK_DFC1C6E916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_DFC1C6E94DDF95DC` FOREIGN KEY (`student_group_id`) REFERENCES `StudentGroup` (`id`),
  CONSTRAINT `FK_DFC1C6E9CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `Student` (`id`),
  CONSTRAINT `FK_DFC1C6E9DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StudentInGroups`
--

LOCK TABLES `StudentInGroups` WRITE;
/*!40000 ALTER TABLE `StudentInGroups` DISABLE KEYS */;
INSERT INTO `StudentInGroups` VALUES (1,7,1,13,NULL,1,NULL,NULL,'2016-04-30 15:46:14',NULL),(2,6,1,13,NULL,1,NULL,NULL,'2016-04-30 15:46:21',NULL);
/*!40000 ALTER TABLE `StudentInGroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Subject`
--

DROP TABLE IF EXISTS `Subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Subject` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `subjectCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationAllAK` int(11) NOT NULL,
  `durationContactAK` int(11) NOT NULL,
  `durationIndependentAK` int(11) NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_347307E6AFC2B591` (`module_id`),
  KEY `IDX_347307E6DE12AB56` (`created_by`),
  KEY `IDX_347307E616FE72E1` (`updated_by`),
  KEY `subjectname` (`name`),
  KEY `subjectcode` (`subjectCode`),
  KEY `subject_trashed` (`trashed`),
  KEY `subject_durationAllAK` (`durationAllAK`),
  KEY `subject_durationContactAK` (`durationContactAK`),
  KEY `subject_durationIndependentAK` (`durationIndependentAK`),
  CONSTRAINT `FK_347307E616FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_347307E6AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `Module` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_347307E6DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Subject`
--

LOCK TABLES `Subject` WRITE;
/*!40000 ALTER TABLE `Subject` DISABLE KEYS */;
INSERT INTO `Subject` VALUES (1,1,13,NULL,'123456','Sissejuhatus andmebaasidesse',40,30,10,NULL,'2016-04-30 15:43:06',NULL),(2,1,13,NULL,'54678','Andmebaasid teoreetiline',40,30,10,NULL,'2016-04-30 15:43:43',NULL);
/*!40000 ALTER TABLE `Subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SubjectRound`
--

DROP TABLE IF EXISTS `SubjectRound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SubjectRound` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3F1EA0823EDC87` (`subject_id`),
  KEY `IDX_D3F1EA08FE54D947` (`group_id`),
  KEY `IDX_D3F1EA08DE12AB56` (`created_by`),
  KEY `IDX_D3F1EA0816FE72E1` (`updated_by`),
  KEY `subjectround_index_trashed` (`trashed`),
  CONSTRAINT `FK_D3F1EA0816FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_D3F1EA0823EDC87` FOREIGN KEY (`subject_id`) REFERENCES `Subject` (`id`),
  CONSTRAINT `FK_D3F1EA08DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_D3F1EA08FE54D947` FOREIGN KEY (`group_id`) REFERENCES `StudentGroup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SubjectRound`
--

LOCK TABLES `SubjectRound` WRITE;
/*!40000 ALTER TABLE `SubjectRound` DISABLE KEYS */;
INSERT INTO `SubjectRound` VALUES (1,1,1,13,NULL,'Sissejuhatus andmebaasidesse',NULL,'2016-04-30 15:47:11',NULL);
/*!40000 ALTER TABLE `SubjectRound` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Teacher`
--

DROP TABLE IF EXISTS `Teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Teacher` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lis_user_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `personalCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7F4B9F49FEC554F2` (`personalCode`),
  UNIQUE KEY `UNIQ_7F4B9F4963918838` (`lis_user_id`),
  KEY `IDX_7F4B9F49DE12AB56` (`created_by`),
  KEY `IDX_7F4B9F4916FE72E1` (`updated_by`),
  KEY `teachercode` (`personalCode`),
  KEY `teacherfirstname` (`firstName`),
  KEY `teacherlastname` (`lastName`),
  KEY `teachertrashed` (`trashed`),
  CONSTRAINT `FK_7F4B9F4916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_7F4B9F4963918838` FOREIGN KEY (`lis_user_id`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_7F4B9F49DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Teacher`
--

LOCK TABLES `Teacher` WRITE;
/*!40000 ALTER TABLE `Teacher` DISABLE KEYS */;
INSERT INTO `Teacher` VALUES (1,6,NULL,NULL,'tFirstName572338cecf1d0','tLirstName572338cecf1e2','tLirstName572338cecf1e2, tFirstName572338cecf1d0','572338cecf1f7@asd.ee','572338cecf1ed',NULL,'2016-04-29 10:34:54','2016-04-29 10:34:54'),(2,7,NULL,NULL,'tFirstName572338ceea206','tLirstName572338ceea21c','tLirstName572338ceea21c, tFirstName572338ceea206','572338ceea22d@asd.ee','572338ceea225',NULL,'2016-04-29 10:34:54','2016-04-29 10:34:55'),(3,8,NULL,NULL,'tFirstName572338cf022f1','tLirstName572338cf02306','tLirstName572338cf02306, tFirstName572338cf022f1','572338cf02322@asd.ee','572338cf02315',NULL,'2016-04-29 10:34:55','2016-04-29 10:34:55'),(4,9,NULL,NULL,'firstName572338cf0cc3c','lastName572338cf0cc50','lastName572338cf0cc50, firstName572338cf0cc3c','teacher@test.ee','code572338cf0cc70',NULL,'2016-04-29 10:34:55','2016-04-29 10:34:55'),(5,NULL,13,NULL,'Silver','Silluta','Silluta, Silver','silluta@maailm.ee','37812345678',NULL,'2016-04-30 15:44:32',NULL),(6,14,NULL,NULL,'tFirstName5725db0d1c112','tLirstName5725db0d1c11b','tLirstName5725db0d1c11b, tFirstName5725db0d1c112','5725db0d1c127@asd.ee','5725db0d1c121',NULL,'2016-05-01 10:31:41','2016-05-01 10:31:41'),(7,15,NULL,NULL,'tFirstName5725db34e94c6','tLirstName5725db34e94db','tLirstName5725db34e94db, tFirstName5725db34e94c6','5725db34e9502@asd.ee','5725db34e94ef',NULL,'2016-05-01 10:32:21','2016-05-01 10:32:21'),(8,16,NULL,NULL,'tFirstName5725dc9438250','tLirstName5725dc9438259','tLirstName5725dc9438259, tFirstName5725dc9438250','5725dc9438268@asd.ee','5725dc9438261',NULL,'2016-05-01 10:38:12','2016-05-01 10:38:12'),(9,17,NULL,NULL,'tFirstName5725dd7d2e9b6','tLirstName5725dd7d2e9c1','tLirstName5725dd7d2e9c1, tFirstName5725dd7d2e9b6','5725dd7d2e9ce@asd.ee','5725dd7d2e9c7',NULL,'2016-05-01 10:42:05','2016-05-01 10:42:05'),(10,18,NULL,NULL,'tFirstName5725e1adbfeef','tLirstName5725e1adbfefb','tLirstName5725e1adbfefb, tFirstName5725e1adbfeef','5725e1adbff09@asd.ee','5725e1adbff02',NULL,'2016-05-01 10:59:57','2016-05-01 10:59:57'),(11,19,NULL,NULL,'tFirstName5725e1c5baeb9','tLirstName5725e1c5baece','tLirstName5725e1c5baece, tFirstName5725e1c5baeb9','5725e1c5baedf@asd.ee','5725e1c5baed6',NULL,'2016-05-01 11:00:21','2016-05-01 11:00:21'),(12,20,NULL,NULL,'tFirstName5725e1fc6fabe','tLirstName5725e1fc6fad0','tLirstName5725e1fc6fad0, tFirstName5725e1fc6fabe','5725e1fc6fadd@asd.ee','5725e1fc6fad8',NULL,'2016-05-01 11:01:16','2016-05-01 11:01:16'),(13,21,NULL,NULL,'tFirstName5725e25184da2','tLirstName5725e25184dad','tLirstName5725e25184dad, tFirstName5725e25184da2','5725e25184dba@asd.ee','5725e25184db4',NULL,'2016-05-01 11:02:41','2016-05-01 11:02:41'),(14,22,NULL,NULL,'tFirstName5725e2865c3b2','tLirstName5725e2865c3bc','tLirstName5725e2865c3bc, tFirstName5725e2865c3b2','5725e2865c3cc@asd.ee','5725e2865c3c5',NULL,'2016-05-01 11:03:34','2016-05-01 11:03:34'),(15,23,NULL,NULL,'tFirstName5725e439b805e','tLirstName5725e439b8068','tLirstName5725e439b8068, tFirstName5725e439b805e','5725e439b8073@asd.ee','5725e439b806d',NULL,'2016-05-01 11:10:49','2016-05-01 11:10:49'),(16,24,NULL,NULL,'tFirstName5725e4ca38f58','tLirstName5725e4ca38f64','tLirstName5725e4ca38f64, tFirstName5725e4ca38f58','5725e4ca38f72@asd.ee','5725e4ca38f6b',NULL,'2016-05-01 11:13:14','2016-05-01 11:13:14'),(17,25,NULL,NULL,'tFirstName5725e4d871c27','tLirstName5725e4d871c4c','tLirstName5725e4d871c4c, tFirstName5725e4d871c27','5725e4d871c5a@asd.ee','5725e4d871c51',NULL,'2016-05-01 11:13:28','2016-05-01 11:13:28'),(18,26,NULL,NULL,'tFirstName5725e5ba1d29d','tLirstName5725e5ba1d2a8','tLirstName5725e5ba1d2a8, tFirstName5725e5ba1d29d','5725e5ba1d2b6@asd.ee','5725e5ba1d2af',NULL,'2016-05-01 11:17:14','2016-05-01 11:17:14'),(19,27,NULL,NULL,'tFirstName5725e6035f2fa','tLirstName5725e6035f304','tLirstName5725e6035f304, tFirstName5725e6035f2fa','5725e6035f310@asd.ee','5725e6035f309',NULL,'2016-05-01 11:18:27','2016-05-01 11:18:27'),(20,28,NULL,NULL,'tFirstName5725e67333dc5','tLirstName5725e67333dce','tLirstName5725e67333dce, tFirstName5725e67333dc5','5725e67333ddc@asd.ee','5725e67333dd4',NULL,'2016-05-01 11:20:19','2016-05-01 11:20:19'),(21,29,NULL,NULL,'tFirstName5725e693cd408','tLirstName5725e693cd41a','tLirstName5725e693cd41a, tFirstName5725e693cd408','5725e693cd428@asd.ee','5725e693cd423',NULL,'2016-05-01 11:20:51','2016-05-01 11:20:51'),(22,30,NULL,NULL,'tFirstName5725e6cb204a1','tLirstName5725e6cb204aa','tLirstName5725e6cb204aa, tFirstName5725e6cb204a1','5725e6cb204b5@asd.ee','5725e6cb204b0',NULL,'2016-05-01 11:21:47','2016-05-01 11:21:47'),(23,31,NULL,NULL,'tFirstName5725e748ea5a3','tLirstName5725e748ea5bb','tLirstName5725e748ea5bb, tFirstName5725e748ea5a3','5725e748ea5c5@asd.ee','5725e748ea5c0',NULL,'2016-05-01 11:23:53','2016-05-01 11:23:53'),(24,32,NULL,NULL,'tFirstName5725e75db760a','tLirstName5725e75db7614','tLirstName5725e75db7614, tFirstName5725e75db760a','5725e75db7620@asd.ee','5725e75db761a',NULL,'2016-05-01 11:24:13','2016-05-01 11:24:13');
/*!40000 ALTER TABLE `Teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TeacherToSubjectRound`
--

DROP TABLE IF EXISTS `TeacherToSubjectRound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TeacherToSubjectRound` (
  `subject_round_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  PRIMARY KEY (`subject_round_id`,`teacher_id`),
  KEY `IDX_9E62F5CF9E7D1CC8` (`subject_round_id`),
  KEY `IDX_9E62F5CF41807E1D` (`teacher_id`),
  CONSTRAINT `FK_9E62F5CF41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `Teacher` (`id`),
  CONSTRAINT `FK_9E62F5CF9E7D1CC8` FOREIGN KEY (`subject_round_id`) REFERENCES `SubjectRound` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TeacherToSubjectRound`
--

LOCK TABLES `TeacherToSubjectRound` WRITE;
/*!40000 ALTER TABLE `TeacherToSubjectRound` DISABLE KEYS */;
INSERT INTO `TeacherToSubjectRound` VALUES (1,5);
/*!40000 ALTER TABLE `TeacherToSubjectRound` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vocation`
--

DROP TABLE IF EXISTS `Vocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vocation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vocationCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `durationEKAP` int(11) NOT NULL,
  `trashed` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4A93C67E1DB10854` (`vocationCode`),
  KEY `IDX_4A93C67EDE12AB56` (`created_by`),
  KEY `IDX_4A93C67E16FE72E1` (`updated_by`),
  KEY `vocationname` (`name`),
  KEY `vocationcode` (`vocationCode`),
  KEY `vocation_index_trashed` (`trashed`),
  CONSTRAINT `FK_4A93C67E16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `LisUser` (`id`),
  CONSTRAINT `FK_4A93C67EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `LisUser` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vocation`
--

LOCK TABLES `Vocation` WRITE;
/*!40000 ALTER TABLE `Vocation` DISABLE KEYS */;
INSERT INTO `Vocation` VALUES (1,13,NULL,'Tarkvara arendus','123456789',240,NULL,'2016-04-30 15:38:28',NULL),(2,13,NULL,'Multimeedia','654789321',240,NULL,'2016-04-30 15:38:45',NULL);
/*!40000 ALTER TABLE `Vocation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-01 16:12:22
