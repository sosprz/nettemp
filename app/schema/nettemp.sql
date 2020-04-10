-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnueabihf (armv8l)
--
-- Host: localhost    Database: nettemp
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `maps`
--

DROP TABLE IF EXISTS `maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maps` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `map_id` int(255) DEFAULT NULL,
  `pos_y` int(255) DEFAULT NULL,
  `pos_x` int(255) DEFAULT NULL,
  `map_on` varchar(255) DEFAULT NULL,
  `transparent` varchar(255) DEFAULT NULL,
  `control_on_map` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `transparent_bkg` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `background_low` varchar(255) DEFAULT NULL,
  `background_high` varchar(255) DEFAULT NULL,
  `font_color` varchar(255) DEFAULT NULL,
  `font_size` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nt_settings`
--

DROP TABLE IF EXISTS `nt_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nt_settings` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `node_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option` (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensors`
--

DROP TABLE IF EXISTS `sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensors` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `time` varchar(255) DEFAULT NULL,
  `tmp` float DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `rom` varchar(255) DEFAULT NULL,
  `tmp_min` float DEFAULT NULL,
  `tmp_max` float DEFAULT NULL,
  `alarm` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `tmp_5ago` float DEFAULT NULL,
  `adj` float DEFAULT NULL,
  `charts` varchar(255) DEFAULT NULL,
  `i2c` varchar(255) DEFAULT NULL,
  `minmax` varchar(255) DEFAULT NULL,
  `sum` varchar(255) DEFAULT NULL,
  `ch_group` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_time` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `email_delay` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `usb` varchar(255) DEFAULT NULL,
  `stat_min` float DEFAULT NULL,
  `stat_max` float DEFAULT NULL,
  `fiveago` varchar(255) DEFAULT NULL,
  `map_id` int(11) DEFAULT NULL,
  `gpio` varchar(255) DEFAULT NULL,
  `stat_min_time` varchar(255) DEFAULT NULL,
  `stat_max_time` varchar(255) DEFAULT NULL,
  `alarm_status` varchar(255) DEFAULT NULL,
  `alarm_recovery_time` varchar(255) DEFAULT NULL,
  `node` varchar(255) DEFAULT NULL,
  `node_url` varchar(255) DEFAULT NULL,
  `node_token` text DEFAULT NULL,
  `nodata` varchar(255) DEFAULT NULL,
  `sid` int(6) DEFAULT NULL,
  `gid` varchar(255) DEFAULT NULL,
  `nodata_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `rom` (`rom`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit2` varchar(255) DEFAULT NULL,
  `ico` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `min` varchar(255) DEFAULT NULL,
  `max` varchar(255) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `value3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  `jwt` varchar(255) DEFAULT NULL,
  `receive_mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-09  9:17:57
