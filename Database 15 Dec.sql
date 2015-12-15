CREATE DATABASE  IF NOT EXISTS `testmeta` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `testmeta`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: testmeta
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `admin_texts`
--

DROP TABLE IF EXISTS `admin_texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `text` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_texts`
--

LOCK TABLES `admin_texts` WRITE;
/*!40000 ALTER TABLE `admin_texts` DISABLE KEYS */;
INSERT INTO `admin_texts` VALUES (1,'instructions','<p>Here are the instructions.</p>');
/*!40000 ALTER TABLE `admin_texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer_text` varchar(300) NOT NULL,
  `answer_option_id` int(11) NOT NULL,
  `is_multiple` tinyint(1) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `visible_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,1,'',34,0,1,1),(2,2,'I am Murat',-1,0,1,2),(3,4,'',-1,1,1,3),(4,1,'',36,0,2,2),(5,4,'',-1,1,2,1),(8,4,'',-1,1,6,1),(9,1,'',35,0,6,2),(10,4,'',-1,1,7,1),(11,1,'',36,0,7,2),(12,2,'User ABC',-1,0,7,3),(13,4,'',-1,1,8,1),(14,1,'',35,0,8,2);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compilation_parts`
--

DROP TABLE IF EXISTS `compilation_parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compilation_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compilation_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL,
  `visible_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compilation_parts`
--

LOCK TABLES `compilation_parts` WRITE;
/*!40000 ALTER TABLE `compilation_parts` DISABLE KEYS */;
INSERT INTO `compilation_parts` VALUES (2,3,2,'Question',5),(3,3,7,'Document',3),(4,3,4,'Question',2),(5,3,1,'Question',4),(6,4,2,'Document',1),(7,4,4,'Question',2),(8,4,6,'Document',3),(9,4,1,'Question',4),(42,9,2,'Document',1),(43,9,1,'Question',2),(44,9,2,'Question',3),(45,3,2,'Document',1),(50,12,2,'Document',1),(51,12,4,'Question',2);
/*!40000 ALTER TABLE `compilation_parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compilations`
--

DROP TABLE IF EXISTS `compilations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compilations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `url_key` varchar(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compilations`
--

LOCK TABLES `compilations` WRITE;
/*!40000 ALTER TABLE `compilations` DISABLE KEYS */;
INSERT INTO `compilations` VALUES (3,'Test Compilation 1',1,'080252575640f447e9c829d2dcc52dc1'),(4,'Comp 2',1,'dd3717affd1175b37aba4c2887c1b032'),(9,'Test 5',0,'96dc5f7b3e4a6bdc9dc021227d0ed7d3'),(12,'Comp 3',0,'adf0f642f2d308cbfd3fa0df5b4dbbc1');
/*!40000 ALTER TABLE `compilations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiple_answers`
--

DROP TABLE IF EXISTS `multiple_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multiple_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_answers`
--

LOCK TABLES `multiple_answers` WRITE;
/*!40000 ALTER TABLE `multiple_answers` DISABLE KEYS */;
INSERT INTO `multiple_answers` VALUES (1,5,3),(2,6,3),(3,5,5),(4,6,5),(5,7,5),(6,5,8),(7,7,8),(8,5,10),(9,6,10),(10,5,13),(11,6,13);
/*!40000 ALTER TABLE `multiple_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL,
  `visible_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (5,'Helsinki',4,1),(6,'Tampere',4,2),(7,'Oslo',4,3),(31,'Three',7,3),(32,'One',7,1),(34,'This is a book.',1,1),(35,'This is a car.',1,2),(36,'This is a house.',1,3),(37,'Four',7,4),(38,'Two',7,2);
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `text` varchar(500) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'Test Question 1','What is this?',2),(2,'Test Question 2','Who are you?',1),(4,'Question 1','Which cities are in Finland?',3),(7,'Test 1','What?',2);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Murat'),(2,'Test'),(6,'Test User'),(7,'ABC'),(8,'User A');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
INSERT INTO `uploads` VALUES (2,'Test_Number_5.pdf','Test File 1'),(6,'Test_Document_2.pdf','Doc 2'),(7,'Test_Document__3.pdf','File 3');
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(180) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$08znXrDYGLWfChcw2L9fVe1.vHt0gEPHdF9NOdyKfjN/g2o0NbjZS',1),(3,'testuser','$2y$10$Urvc0UvisdFaVYyvwwJL0.ySUM626a8IgTo9lHZqtM8nRXcqUOiHK',0),(4,'test2','$2y$10$KJhs.CqLBCM62rAz1HPGNuO/l6oGZzWBjUfEqK.SVx2Cacm8Ap9J6',0),(6,'abc','$2y$10$cDUHCGrzOce5rMKKjGeQoOreOy9q1juT7E30.zKgjC8yDXtfTZlde',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-15 13:46:59
