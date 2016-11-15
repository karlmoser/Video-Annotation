# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.49)
# Database: annotations
# Generation Time: 2016-04-19 23:34:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table annotations
# ------------------------------------------------------------

CREATE TABLE `annotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_time` double(10,2) NOT NULL,
  `end_time` double(10,2) NOT NULL,
  `position` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table annotations_text
# ------------------------------------------------------------

CREATE TABLE `annotations_text` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(256) DEFAULT NULL,
  `annotation_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table followers
# ------------------------------------------------------------

CREATE TABLE `followers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) unsigned DEFAULT NULL,
  `following` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table messages
# ------------------------------------------------------------

CREATE TABLE `messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` int(11) unsigned DEFAULT NULL,
  `sender` int(11) unsigned DEFAULT NULL,
  `annotation` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_picture` varchar(256) DEFAULT NULL,
  `bio` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `profile_picture`, `bio`)
VALUES
	(2,'shermanzac','sherman','shermanzach@gmail.com','/uploads/profile_pictures/shermanzac',NULL),
	(3,'developer','peanutbutter','developer@oregonstate.edu','/uploads/profile_pictures/default',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table videos
# ------------------------------------------------------------

CREATE TABLE `videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creator` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(512) DEFAULT NULL,
  `src` varchar(512) DEFAULT NULL,
  `permissions` varchar(11) DEFAULT '',
  `thumbnail` varchar(512) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
