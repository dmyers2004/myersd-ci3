# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: ci3
# Generation Time: 2013-07-25 13:37:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `access`;

CREATE TABLE `access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `module_name` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;

INSERT INTO `access` (`id`, `resource`, `active`, `description`, `type`, `module_name`)
VALUES
	(1,'/nav/*',1,'Show All Menus',0,''),
	(4,'/nav/chess',0,'chess',2,'Chess'),
	(5,'/nav/testing',1,'testing',1,NULL),
	(6,'sdfsdf',1,'dfdsfsdf',1,NULL),
	(7,'fghfghfgh',0,'fghfghfgh',0,NULL),
	(9,'/users/delete_all',1,'Delete All Users',0,''),
	(10,'/menu/user/create',1,'Create User',2,'User'),
	(11,'/cookies/edit',1,'Cookie Access',1,NULL),
	(12,'/nav/level2',1,'Level 2',2,'Level'),
	(13,'/nav/level4',0,'Level 3',0,'');

/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ci_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`,`ip_address`,`user_agent`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`)
VALUES
	('3c413bd675f1294933735aa4089551cd','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374756551,'last_activity|i:1374756551;session_id|s:32:\"3c413bd675f1294933735aa4089551cd\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),
	('963e96ec1f07440cad6d6c9289247359','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374759307,'last_activity|i:1374759307;session_id|s:32:\"963e96ec1f07440cad6d6c9289247359\";history-1|s:31:\"http://ci3.vcap.me/admin/access\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),
	('c562ac58da0f9c8d9a7ad05af3169bd2','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374757992,'last_activity|i:1374757992;session_id|s:32:\"c562ac58da0f9c8d9a7ad05af3169bd2\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),
	('d2efcd937d6e991a7c85baea1c68d562','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374755586,'last_activity|i:1374755586;session_id|s:32:\"d2efcd937d6e991a7c85baea1c68d562\";history-1|s:32:\"http://ci3.vcap.me/admin/menubar\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),
	('d3f94e66e576a8ef959b13db0ddb2449','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374758804,'last_activity|i:1374758804;session_id|s:32:\"d3f94e66e576a8ef959b13db0ddb2449\";history-1|s:30:\"http://ci3.vcap.me/admin/group\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}'),
	('da28264ff01d7f1351471df1b0e7be0e','127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) App',1374757083,'last_activity|i:1374757083;session_id|s:32:\"da28264ff01d7f1351471df1b0e7be0e\";history-1|s:32:\"http://ci3.vcap.me/admin/setting\";user|O:8:\"stdClass\":15:{s:2:\"id\";s:1:\"1\";s:8:\"username\";s:6:\"dmyers\";s:5:\"email\";s:15:\"donmyers@me.com\";s:9:\"activated\";s:1:\"1\";s:6:\"banned\";s:1:\"0\";s:10:\"ban_reason\";N;s:16:\"new_password_key\";N;s:22:\"new_password_requested\";N;s:9:\"new_email\";N;s:13:\"new_email_key\";N;s:7:\"last_ip\";s:9:\"127.0.0.1\";s:10:\"last_login\";s:19:\"2013-07-19 07:46:42\";s:7:\"created\";s:19:\"2013-04-03 19:37:06\";s:8:\"modified\";s:19:\"2013-07-19 07:46:42\";s:8:\"group_id\";s:1:\"1\";}status|s:1:\"1\";group_id|s:1:\"1\";group_roles|a:1:{i:0;s:2:\"/*\";}');

/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table group_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `group_access`;

CREATE TABLE `group_access` (
  `group_id` bigint(20) unsigned NOT NULL,
  `access_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `group_access` WRITE;
/*!40000 ALTER TABLE `group_access` DISABLE KEYS */;

INSERT INTO `group_access` (`group_id`, `access_id`)
VALUES
	(1,6),
	(1,7),
	(1,11),
	(1,10),
	(1,1),
	(1,4),
	(1,5),
	(1,12),
	(1,13),
	(1,9),
	(5,1),
	(5,4),
	(5,5),
	(5,12),
	(5,13);

/*!40000 ALTER TABLE `group_access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `description`)
VALUES
	(1,'Admin','Administrator Group'),
	(5,'Clients','Client group name');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nav`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `nav` WRITE;
/*!40000 ALTER TABLE `nav` DISABLE KEYS */;

INSERT INTO `nav` (`id`, `resource`, `url`, `text`, `parent_id`, `sort`, `class`, `active`)
VALUES
	(1,'/nav/permission','','Permission',0,13,'',1),
	(2,'/nav/permission/users','/admin/user','Users',1,14,'',1),
	(3,'/nav/permission/groups','/admin/group','Groups',1,15,'',1),
	(4,'/nav/permission/access','/admin/access','Access',1,16,'',1),
	(7,'/nav/menubar','/admin/menubar','Menubar',17,13,'',1),
	(9,'/nav/dashboard','/admin/dashboard','Dashboard',0,11,'',1),
	(14,'/nav/setting','/admin/setting','Settings',17,14,'',1),
	(15,'/nav/cookies','/auth','Cookie',0,16,'',0),
	(17,'/nav/internal','','Internal',0,12,'',1),
	(18,'/nav/views','/views','Views',17,17,'',0),
	(19,'/nav/media','/admin/media','Media Manager',17,15,'',1),
	(20,'/nav/wysiwyg','/admin/media/wysiwyg','WYSIWYG',17,16,'',1),
	(21,'/menu/here','/menu/url','Menu',0,15,'',0),
	(23,'/nav/apc','','APC',0,14,'',1),
	(24,'/nav/clear apc','/admin/utility/apcclear','Clear',23,16,'',1),
	(25,'/nav/apcinfo','/admin/utility/apcinfo','Info',23,15,'',1);

/*!40000 ALTER TABLE `nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `group` varchar(55) NOT NULL DEFAULT 'site',
  `auto_load` tinyint(1) NOT NULL,
  `type` int(1) DEFAULT '1',
  `module_name` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `value`, `group`, `auto_load`, `type`, `module_name`)
VALUES
	(1,'View fixer','fixer value','view',1,0,''),
	(2,'new','Testing','coffee',1,0,NULL),
	(3,'New Setting','Yes','view',1,0,NULL),
	(5,'settinga','settingb','new group',1,0,NULL),
	(6,'title','dmfw','page',1,1,NULL),
	(7,'page_brand','dmfw2','page',1,1,''),
	(8,'foo','bar','paths',1,2,'paths'),
	(9,'admin home','/admin/','paths',1,2,'paths'),
	(10,'meta_description','Example Application','page',1,1,'');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_autologin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_autologin`;

CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



# Dump of table user_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_profiles`;

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`)
VALUES
	(1,1,NULL,NULL),
	(2,2,NULL,NULL),
	(3,3,NULL,NULL),
	(4,4,NULL,NULL),
	(5,5,NULL,NULL);

/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `group_id`)
VALUES
	(1,X'646D79657273',X'243261243038246257784B51323737556B4939546A7235347954694F2E71544331736435466E6E5A5878424145357771476C31476F633737796E7057',X'646F6E6D79657273406D652E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','2013-07-25 08:28:07','2013-04-03 19:37:06','2013-07-25 08:28:07',1),
	(2,X'646F6E6D79657273',X'2432612430382457352E58565068616247566D7455735A58344D30317532474146724136334A442E717635454E477A68336D564859314B4C6F674F69',X'646F6E406D796572732E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','0000-00-00 00:00:00','2013-04-09 04:03:41','2013-04-29 16:47:41',1),
	(3,X'47656E6572616C',X'24326124303824794741464A59423747724E7738734C776A306645494F4A6832537062476F326733342F736F4F72476F7441747732756A6C45454C61',X'67656E6572616C40757365722E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','0000-00-00 00:00:00','2013-04-09 15:26:56','2013-05-14 20:25:29',5),
	(5,X'4A6F6520436F66666565',X'24326124303824536C4F4864437834456879512E57786C614B4546502E357371366A6D4B31633546625268585273367658526B3237515171496B6843',X'6A6F65406578616D706C652E636F6D',0,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','0000-00-00 00:00:00','2013-06-05 15:19:34','2013-06-25 18:36:16',5);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
