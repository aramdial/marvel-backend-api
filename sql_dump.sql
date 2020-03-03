CREATE DATABASE  IF NOT EXISTS `marvel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `marvel`;
-- MySQL dump 10.13  Distrib 8.0.19, for macos10.15 (x86_64)
--
-- Host: localhost    Database: marvel
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `character_list`
--

DROP TABLE IF EXISTS `character_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character_list` (
  `characterListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`characterListId`),
  KEY `fk_character_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_character_list_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `character_summary`
--

DROP TABLE IF EXISTS `character_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `character_summary` (
  `characterSummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`characterSummaryId`),
  KEY `fk_character_summ_listid` (`listId`),
  CONSTRAINT `fk_character_summ_listid` FOREIGN KEY (`listId`) REFERENCES `character_list` (`characterListId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `characters`
--

DROP TABLE IF EXISTS `characters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `characters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  `resourceURI` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1017101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comic_list`
--

DROP TABLE IF EXISTS `comic_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comic_list` (
  `comicListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`comicListId`),
  KEY `fk_comic_list_characterid_idx` (`characterId`),
  KEY `fk_comic_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_comic_list_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_comic_list_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comic_summary`
--

DROP TABLE IF EXISTS `comic_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comic_summary` (
  `comicSummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`comicSummaryId`),
  KEY `fk_comic_summ_listid_idx` (`listId`),
  CONSTRAINT `fk_comic_summ_listid` FOREIGN KEY (`listId`) REFERENCES `comic_list` (`comicListId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `creator_list`
--

DROP TABLE IF EXISTS `creator_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creator_list` (
  `creatorListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`creatorListId`),
  KEY `fk_creator_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_creator_list_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `creator_summary`
--

DROP TABLE IF EXISTS `creator_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creator_summary` (
  `creatorSummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`creatorSummaryId`),
  KEY `fk_creator_summ_listid` (`listId`),
  CONSTRAINT `fk_creator_summ_listid` FOREIGN KEY (`listId`) REFERENCES `creator_list` (`creatorListId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_list`
--

DROP TABLE IF EXISTS `event_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_list` (
  `eventListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`eventListId`),
  KEY `fk_event_list_characterid_idx` (`characterId`),
  KEY `fk_event_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_event_list_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_event_list_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_summary`
--

DROP TABLE IF EXISTS `event_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_summary` (
  `eventSummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`eventSummaryId`),
  KEY `fk_event_summ_listid` (`listId`),
  CONSTRAINT `fk_event_summ_listid` FOREIGN KEY (`listId`) REFERENCES `event_list` (`eventListId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `series` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `resourceURI` varchar(255) DEFAULT NULL,
  `startYear` int DEFAULT NULL,
  `endYear` int DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_list`
--

DROP TABLE IF EXISTS `series_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `series_list` (
  `seriesListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`seriesListId`),
  KEY `fk_series_list_characterid_idx` (`characterId`),
  KEY `fk_series_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_res_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_res_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `series_summary`
--

DROP TABLE IF EXISTS `series_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `series_summary` (
  `seriesSummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`seriesSummaryId`),
  KEY `fk_series_summ_listid_idx` (`listId`),
  CONSTRAINT `fk_series_summ_listid` FOREIGN KEY (`listId`) REFERENCES `series_list` (`seriesListId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `story_list`
--

DROP TABLE IF EXISTS `story_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story_list` (
  `storyListId` int NOT NULL AUTO_INCREMENT,
  `available` int DEFAULT NULL,
  `returned` int DEFAULT NULL,
  `collectionURI` varchar(255) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`storyListId`),
  KEY `fk_story_list_characterid_idx` (`characterId`),
  KEY `fk_story_list_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_story_list_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_story_list_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `story_summary`
--

DROP TABLE IF EXISTS `story_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `story_summary` (
  `storySummaryId` int NOT NULL AUTO_INCREMENT,
  `resourceURI` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `listId` int DEFAULT NULL,
  PRIMARY KEY (`storySummaryId`),
  KEY `fk_comic_summ_listid_idx` (`listId`),
  CONSTRAINT `fk_story_summ_listid` FOREIGN KEY (`listId`) REFERENCES `story_list` (`storyListId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `thumbnails`
--

DROP TABLE IF EXISTS `thumbnails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thumbnails` (
  `thumbId` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`thumbId`),
  KEY `fk_thumb_characterid_idx` (`characterId`),
  KEY `fk_thumb_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_thumb_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_thumb_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `urls`
--

DROP TABLE IF EXISTS `urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `urls` (
  `url_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `characterId` int DEFAULT NULL,
  `seriesId` int DEFAULT NULL,
  PRIMARY KEY (`url_id`),
  KEY `fk_url_characterid_idx` (`characterId`),
  KEY `fk_url_seriesid_idx` (`seriesId`),
  CONSTRAINT `fk_url_characterid` FOREIGN KEY (`characterId`) REFERENCES `characters` (`id`),
  CONSTRAINT `fk_url_seriesid` FOREIGN KEY (`seriesId`) REFERENCES `series` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-03  1:16:35
