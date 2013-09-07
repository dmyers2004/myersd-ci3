-- MySQL dump 10.13  Distrib 5.5.29, for osx10.6 (i386)
--
-- Host: localhost    Database: ci3
-- ------------------------------------------------------
-- Server version	5.5.29

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
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `module_name` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource` (`resource`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES (1,'/nav/*',1,'Show All Menus',0,''),(14,'/bugz/ticket/edit/title',1,'Edit Bug Title',0,''),(15,'/bugz/ticket/edit/description',1,'Edit Bug Description',0,''),(16,'/bugz/ticket/edit/priority',1,'Edit Bug Priority',0,''),(17,'/bugz/ticket/edit/status',1,'Edit Bug Status',0,''),(18,'/bugz/ticket/edit/owner',1,'Edit Bug Owner',0,''),(19,'/bugz/ticket/edit/tags',1,'Edit Bug Tags',0,''),(20,'/bugz/ticket/edit/project',1,'Edit Bug Project',0,''),(21,'/bugz/ticket/edit/assignedto',1,'Edit Bug Assigned To',0,''),(22,'/bugz/ticket/add/note',1,'Add Bug Note',0,''),(23,'/bugz/project/edit',1,'Edit Projects',0,''),(24,'/bugz/tags/edit',1,'Edit Tags',0,''),(25,'/bugz/priority/edit',1,'Edit Priorities',0,''),(26,'/bugz/status/edit',1,'Edit Statuses',0,''),(27,'/nav/internal/*',1,'See Internal Menus',0,''),(28,'/nav/permission/*',1,'See Permission Menus',0,''),(29,'/nav/bugz/*',1,'See Bugz Menus',0,''),(30,'/nav/apc/*',1,'See APC Menus',0,''),(32,'/bugz/ticket/add',1,'Create New Ticket',0,''),(33,'/bugz/ticket/delete',1,'Can Delete Tickets',0,''),(34,'/bugz/ticket/edit',1,'Can I Edit Tickets',0,''),(35,'/url/admin/*',1,'Access to Admin Urls',0,''),(36,'/url/ticket/*',1,'Access to Ticket Urls',0,''),(39,'/url/bugz/*',1,'Access to BugZ Urls',0,''),(40,'/name/222',0,'Tyson Dog',0,'');
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_access`
--

DROP TABLE IF EXISTS `group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_access` (
  `group_id` bigint(20) unsigned NOT NULL,
  `access_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_access`
--

LOCK TABLES `group_access` WRITE;
/*!40000 ALTER TABLE `group_access` DISABLE KEYS */;
INSERT INTO `group_access` VALUES (1,6),(1,7),(1,11),(1,10),(1,1),(1,4),(1,5),(1,12),(1,13),(1,9),(5,1),(5,4),(5,5),(5,12),(5,13),(7,14),(7,16),(7,17),(7,18),(7,19),(7,20),(7,22),(7,23),(7,24),(7,25),(7,26),(7,33),(7,34);
/*!40000 ALTER TABLE `group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Admin','Administrator Group'),(5,'Clients','Client group name'),(6,'Super User','Super User Not Admin'),(7,'Smoke2','Mirrors');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nav`
--

DROP TABLE IF EXISTS `nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `text` varchar(64) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT '0',
  `sort` float DEFAULT '0',
  `class` varchar(64) DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav`
--

LOCK TABLES `nav` WRITE;
/*!40000 ALTER TABLE `nav` DISABLE KEYS */;
INSERT INTO `nav` VALUES (1,'/nav/permission','','Permission',0,14,'',1),(2,'/nav/permission/users','/admin/user','Users',1,15,'',1),(3,'/nav/permission/groups','/admin/group','Groups',1,16,'',1),(4,'/nav/permission/access','/admin/access','Access',1,17,'',1),(7,'/nav/menubar','/admin/menubar','Menubar',17,14,'',1),(9,'/nav/dashboard','/admin/dashboard','Dashboard',0,12,'',1),(14,'/nav/setting','/admin/setting','Settings',17,15,'',1),(15,'/nav/cookies','/auth','Cookie',0,17,'',0),(17,'/nav/internal','','Internal',0,13,'',1),(18,'/nav/views','/views','Views',17,18,'',0),(19,'/nav/media','/admin/media','Media Manager',17,16,'',1),(20,'/nav/wysiwyg','/admin/media/wysiwyg','WYSIWYG',17,17,'',1),(21,'/menu/here','/menu/url','Menu',0,16,'',0),(23,'/nav/apc','','APC',0,15,'',1),(24,'/nav/clear apc','/admin/utility/apcclear','Clear',23,17,'',1),(25,'/nav/apcinfo','/admin/utility/apcinfo','Info',23,16,'',1),(26,'/nav/cookie/cookie-sub','/nav/cookie/cookie-sub','Cookie Sub',15,18,'',1),(27,'/nav/cookie/sub-menu-2','/cookies','Sub Menu 2',15,19,'',1),(30,'Cookie','','New',15,0,'',1),(31,'/new/tyson','/nav/tyson','New Tyson',15,0,'',1);
/*!40000 ALTER TABLE `nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `group` varchar(55) NOT NULL DEFAULT 'site',
  `auto_load` tinyint(1) NOT NULL,
  `type` int(1) DEFAULT '1',
  `module_name` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'View fixer','fixer value','view',1,0,NULL),(2,'new','Testing','coffee',1,0,NULL),(5,'settinga','settingb','new group',1,0,NULL),(6,'title','dmfw','page',1,1,NULL),(7,'page_brand','dmfw2','page',1,1,''),(8,'foo','bar','paths',0,2,''),(9,'admin home','/admin/','paths',1,2,'paths'),(10,'meta_description','Example Application','page',1,1,''),(11,'Testing','New Testing setting','coffee',1,0,''),(12,'Shunk','Shoe','coffee',0,0,''),(13,'Monkey','Testing Monkey','new group',1,0,''),(14,'New Setting','New Setting Value','bogus',0,0,NULL),(15,'Newer Setting','This is the value','view',1,0,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_autologin`
--

DROP TABLE IF EXISTS `user_autologin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_autologin`
--

LOCK TABLES `user_autologin` WRITE;
/*!40000 ALTER TABLE `user_autologin` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_autologin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(3,3,NULL,NULL),(4,4,NULL,NULL),(5,5,NULL,NULL),(6,6,NULL,NULL),(7,7,NULL,NULL);
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dmyers','$2a$08$CC7FLTRNpzRJUsHXX2C1h.b8U02jUuG9.cM0.GBsHzaERHB1U8hTm','donmyers@me.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2013-09-06 20:14:31','2013-04-03 19:37:06','2013-09-07 00:14:31',1),(2,'donmyers','$2a$08$W5.XVPhabGVmtUsZX4M01u2GAFrA63JD.qv5ENGzh3mVHY1KLogOi','don@myers.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-04-09 04:03:41','2013-04-29 20:47:41',1),(3,'General','$2a$08$yGAFJYB7GrNw8sLwj0fEIOJh2SpbGo2g34/soOrGotAtw2ujlEELa','general@user.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-04-09 15:26:56','2013-05-15 00:25:29',5),(5,'Joe Coffee','','joe@example.com',0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-06-05 15:19:34','2013-08-21 17:43:01',5),(6,'Donald','$2a$08$W1SiBCC2/XD3X2oWzi0oO.47q/gY.mlXx7uYPSHBpt8PeK26ny7re','don@me.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-08-21 14:09:00','2013-08-21 18:09:00',1),(7,'Tyson','','tyson@me.com',0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-08-21 14:10:03','2013-08-21 18:10:14',5);
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

-- Dump completed
