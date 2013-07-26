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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES (1,'/nav/*',1,'Show All Menus',0,''),(14,'/bugz/ticket/edit/title',1,'Edit Bug Title',0,''),(15,'/bugz/ticket/edit/description',1,'Edit Bug Description',0,''),(16,'/bugz/ticket/edit/priority',1,'Edit Bug Priority',0,''),(17,'/bugz/ticket/edit/status',1,'Edit Bug Status',0,''),(18,'/bugz/ticket/edit/owner',1,'Edit Bug Owner',0,''),(19,'/bugz/ticket/edit/tags',1,'Edit Bug Tags',0,''),(20,'/bugz/ticket/edit/project',1,'Edit Bug Project',0,''),(21,'/bugz/ticket/edit/assignedto',1,'Edit Bug Assigned To',0,''),(22,'/bugz/ticket/add/note',1,'Add Bug Note',0,''),(23,'/bugz/project/edit',1,'Edit Projects',0,''),(24,'/bugz/tags/edit',1,'Edit Tags',0,''),(25,'/bugz/priority/edit',1,'Edit Priorities',0,''),(26,'/bugz/status/edit',1,'Edit Statuses',0,''),(27,'/nav/internal/*',1,'See Internal Menus',0,''),(28,'/nav/permission/*',1,'See Permission Menus',0,''),(29,'/nav/bugz/*',1,'See Bugz Menus',0,''),(30,'/nav/apc/*',1,'See APC Menus',0,''),(32,'/bugz/ticket/add',1,'Create New Ticket',0,''),(33,'/bugz/ticket/delete',1,'Can Delete Tickets',0,''),(34,'/bugz/ticket/edit',1,'Can I Edit Tickets',0,''),(35,'/url/admin/*',1,'Access to Admin Urls',0,''),(36,'/url/ticket/*',1,'Access to Ticket Urls',0,''),(39,'/url/bugz/*',1,'Access to BugZ Urls',0,'');
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`,`ip_address`,`user_agent`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('3c413bd675f1294933735aa4089551cd','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374756551,'last_activity|i:1374756551;session_id|s:32:\"3c413bd675f1294933735aa4089551cd\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),('963e96ec1f07440cad6d6c9289247359','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374759307,'last_activity|i:1374759307;session_id|s:32:\"963e96ec1f07440cad6d6c9289247359\";history-1|s:31:\"http://ci3.vcap.me/admin/access\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),('c562ac58da0f9c8d9a7ad05af3169bd2','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374757992,'last_activity|i:1374757992;session_id|s:32:\"c562ac58da0f9c8d9a7ad05af3169bd2\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),('d2efcd937d6e991a7c85baea1c68d562','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374755586,'last_activity|i:1374755586;session_id|s:32:\"d2efcd937d6e991a7c85baea1c68d562\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),('d3f94e66e576a8ef959b13db0ddb2449','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374758804,'last_activity|i:1374758804;session_id|s:32:\"d3f94e66e576a8ef959b13db0ddb2449\";history-1|s:30:\"http://ci3.vcap.me/admin/group\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),('da28264ff01d7f1351471df1b0e7be0e','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374757083,'last_activity|i:1374757083;session_id|s:32:\"da28264ff01d7f1351471df1b0e7be0e\";history-1|s:32:\"http://ci3.vcap.me/admin/setting\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
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
INSERT INTO `group_access` VALUES (1,6),(1,7),(1,11),(1,10),(1,1),(1,4),(1,5),(1,12),(1,13),(1,9),(5,1),(5,4),(5,5),(5,12),(5,13);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Admin','Administrator Group'),(5,'Clients','Client group name');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nav`
--

LOCK TABLES `nav` WRITE;
/*!40000 ALTER TABLE `nav` DISABLE KEYS */;
INSERT INTO `nav` VALUES (1,'/nav/permission','','Permission',0,13,'',1),(2,'/nav/permission/users','/admin/user','Users',1,14,'',1),(3,'/nav/permission/groups','/admin/group','Groups',1,15,'',1),(4,'/nav/permission/access','/admin/access','Access',1,16,'',1),(7,'/nav/menubar','/admin/menubar','Menubar',17,13,'',1),(9,'/nav/dashboard','/admin/dashboard','Dashboard',0,11,'',1),(14,'/nav/setting','/admin/setting','Settings',17,14,'',1),(15,'/nav/cookies','/auth','Cookie',0,16,'',0),(17,'/nav/internal','','Internal',0,12,'',1),(18,'/nav/views','/views','Views',17,17,'',0),(19,'/nav/media','/admin/media','Media Manager',17,15,'',1),(20,'/nav/wysiwyg','/admin/media/wysiwyg','WYSIWYG',17,16,'',1),(21,'/menu/here','/menu/url','Menu',0,15,'',0),(23,'/nav/apc','','APC',0,14,'',1),(24,'/nav/clear apc','/admin/utility/apcclear','Clear',23,16,'',1),(25,'/nav/apcinfo','/admin/utility/apcinfo','Info',23,15,'',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'View fixer','fixer value','view',1,0,''),(2,'new','Testing','coffee',1,0,NULL),(3,'New Setting','Yes','view',1,0,NULL),(5,'settinga','settingb','new group',1,0,NULL),(6,'title','dmfw','page',1,1,NULL),(7,'page_brand','dmfw2','page',1,1,''),(8,'foo','bar','paths',1,2,'paths'),(9,'admin home','/admin/','paths',1,2,'paths'),(10,'meta_description','Example Application','page',1,1,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(3,3,NULL,NULL),(4,4,NULL,NULL),(5,5,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dmyers','$2a$08$bWxKQ277UkI9Tjr54yTiO.qTC1sd5FnnZXxBAE5wqGl1Goc77ynpW','donmyers@me.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','2013-07-25 08:28:07','2013-04-03 19:37:06','2013-07-25 12:28:07',1),(2,'donmyers','$2a$08$W5.XVPhabGVmtUsZX4M01u2GAFrA63JD.qv5ENGzh3mVHY1KLogOi','don@myers.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-04-09 04:03:41','2013-04-29 20:47:41',1),(3,'General','$2a$08$yGAFJYB7GrNw8sLwj0fEIOJh2SpbGo2g34/soOrGotAtw2ujlEELa','general@user.com',1,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-04-09 15:26:56','2013-05-15 00:25:29',5),(5,'Joe Coffee','$2a$08$SlOHdCx4EhyQ.WxlaKEFP.5sq6jmK1c5FbRhXRs6vXRk27QQqIkhC','joe@example.com',0,0,NULL,NULL,NULL,NULL,NULL,'127.0.0.1','0000-00-00 00:00:00','2013-06-05 15:19:34','2013-06-25 22:36:16',5);
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

-- Dump completed on 2013-07-26  9:58:48
