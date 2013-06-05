# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: ci3
# Generation Time: 2013-05-12 01:13:19 +0000
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;

INSERT INTO `access` (`id`, `resource`, `active`, `description`)
VALUES
	(1,'/nav/*',1,'Show All Menus'),
	(4,'/nav/chess',1,'chess'),
	(5,'/nav/testing',1,'testing'),
	(6,'sdfsdf',1,'dfdsfsdf'),
	(7,'fghfghfgh',1,'fghfghfgh'),
	(9,'tyutyutyu',1,'ggytyu'),
	(10,'/menu/user/create',1,'Create User'),
	(11,'/cookies/edit',1,'Cookie Access'),
	(12,'/nav/level2',1,'Level 2'),
	(13,'/nav/level3',1,'Level 3');

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
	(2,1),
	(2,4),
	(2,5),
	(2,12),
	(2,13),
	(1,7),
	(1,9),
	(1,4),
	(1,5),
	(1,13);

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
	(2,'Clients','Client group');

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
	(2,'/nav/permission/users','/admin/user','Users',1,10.1,'',1),
	(3,'/nav/permission/groups','/admin/group','Groups',1,10.3,'',1),
	(4,'/nav/permission/access','/admin/access','Access',1,10.5,'',1),
	(7,'/nav/menubar','/admin/menubar','Menubar',17,5.1,'',1),
	(8,'/nav/menu','','Cheese',0,22,'',0),
	(9,'/nav/dashboard','/','Dashboard',0,0,'',1),
	(14,'/nav/setting','/admin/setting','Settings',17,5.2,'',1),
	(15,'/nav/cookies','/admin/auth','Cookie',0,1,'',0),
	(17,'/nav/internal','','Internal',0,12,'',1),
	(18,'/nav/views','/views','Views',17,0,'',0);

/*!40000 ALTER TABLE `nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` mediumtext NOT NULL,
  `option_group` varchar(55) NOT NULL DEFAULT 'site',
  `auto_load` tinyint(1) NOT NULL,
  PRIMARY KEY (`option_id`,`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;

INSERT INTO `setting` (`option_id`, `option_name`, `option_value`, `option_group`, `auto_load`)
VALUES
	(1,'fixer','fixer value','view',1),
	(2,'new','Testing','coffee',1);

/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
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
	(3,3,NULL,NULL);

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
	(1,X'646D79657273',X'243261243038246257784B51323737556B4939546A7235347954694F2E71544331736435466E6E5A5878424145357771476C31476F633737796E7057',X'61646D696E4061646D696E2E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','2013-05-11 19:49:32','2013-04-03 19:37:06','2013-05-11 19:49:32',1),
	(2,X'646F6E6D79657273',X'2432612430382457352E58565068616247566D7455735A58344D30317532474146724136334A442E717635454E477A68336D564859314B4C6F674F69',X'646F6E406D796572732E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','0000-00-00 00:00:00','2013-04-09 04:03:41','2013-04-29 16:47:41',1),
	(3,X'47656E6572616C',X'24326124303824794741464A59423747724E7738734C776A306645494F4A6832537062476F326733342F736F4F72476F7441747732756A6C45454C61',X'67656E6572616C40757365722E636F6D',1,0,NULL,NULL,NULL,NULL,NULL,X'3132372E302E302E31','0000-00-00 00:00:00','2013-04-09 15:26:56','2013-04-29 16:47:45',5);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
