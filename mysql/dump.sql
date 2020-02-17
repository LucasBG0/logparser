-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: parser
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `GAMES`
--

DROP TABLE IF EXISTS `GAMES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GAMES` (
  `game_id` int(11) NOT NULL,
  `total_kills` int(11) DEFAULT NULL,
  `time_start` text,
  `time_finish` text,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GAMES`
--

LOCK TABLES `GAMES` WRITE;
/*!40000 ALTER TABLE `GAMES` DISABLE KEYS */;
INSERT INTO `GAMES` VALUES (1,0,'0:00','20:37'),(3,4,'0:00','1:47'),(4,105,'1:47','12:13'),(5,14,'12:13','54:21'),(6,29,'0:00','3:32'),(7,130,'3:32','11:22'),(8,89,'11:22','16:35'),(9,67,'16:35','21:52'),(10,60,'0:00','3:47'),(11,20,'0:00','2:33'),(12,160,'2:33','10:28'),(13,6,'10:28','11:03'),(14,122,'11:03','16:53'),(15,3,'16:53','981:27'),(16,0,'981:27','981:39'),(17,13,'0:00','1:53'),(18,7,'0:00','0:35'),(19,95,'0:35','6:10'),(20,3,'6:10','6:34'),(21,131,'6:34','14:11');
/*!40000 ALTER TABLE `GAMES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `KILLSBYMENS`
--

DROP TABLE IF EXISTS `KILLSBYMENS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `KILLSBYMENS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kills` int(11) DEFAULT NULL,
  `player_name` text,
  `game_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `killsbymens_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `GAMES` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `KILLSBYMENS`
--

LOCK TABLES `KILLSBYMENS` WRITE;
/*!40000 ALTER TABLE `KILLSBYMENS` DISABLE KEYS */;
INSERT INTO `KILLSBYMENS` VALUES (1,213,'MOD_ROCKET',3),(2,186,'MOD_TRIGGER_HURT',3),(3,44,'MOD_FALLING',3),(4,132,'MOD_RAILGUN',4),(5,346,'MOD_ROCKET_SPLASH',4),(6,45,'MOD_MACHINEGUN',4),(7,25,'MOD_SHOTGUN',4),(8,25,'MOD_TELEFRAG',10),(9,24,'MOD_BFG_SPLASH',10),(10,16,'MOD_BFG',10),(11,2,'MOD_CRUSH',10);
/*!40000 ALTER TABLE `KILLSBYMENS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PLAYERS`
--

DROP TABLE IF EXISTS `PLAYERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PLAYERS` (
  `player_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_game_id` int(11) DEFAULT NULL,
  `kills` int(11) DEFAULT NULL,
  `player_name` text,
  `game_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`player_id`),
  KEY `game_id` (`game_id`),
  CONSTRAINT `players_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `GAMES` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PLAYERS`
--

LOCK TABLES `PLAYERS` WRITE;
/*!40000 ALTER TABLE `PLAYERS` DISABLE KEYS */;
INSERT INTO `PLAYERS` VALUES (1,3,145,'Isgalamido',3),(2,2,0,'Mocinha',3),(3,1022,232,'world',3),(4,4,120,'Zeh',3),(5,2,48,'Dono da Bola',3),(6,5,91,'Assasinu Credi',4),(7,2,108,'Oootsimo',6),(8,6,0,'UnnamedPlayer',6),(9,6,0,'Maluquinho',6),(10,6,-9,'Mal',6),(11,8,32,'Chessus',7);
/*!40000 ALTER TABLE `PLAYERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-17 13:26:24
