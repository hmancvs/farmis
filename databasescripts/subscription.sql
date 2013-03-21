-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.24-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema farmis
--

CREATE DATABASE IF NOT EXISTS farmis;
USE farmis;

--
-- Definition of table `membershipplan`
--

DROP TABLE IF EXISTS `membershipplan`;
CREATE TABLE `membershipplan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `trialdays` decimal(4,0) unsigned DEFAULT '1',
  `usagedays` decimal(10,0) unsigned DEFAULT '0',
  `amount` decimal(10,0) unsigned DEFAULT NULL,
  `nooffarms` decimal(4,0) unsigned DEFAULT NULL,
  `noofseasons` decimal(4,0) unsigned DEFAULT NULL,
  `noofactivities` decimal(4,0) unsigned DEFAULT NULL,
  `calendarenabled` tinyint(4) unsigned DEFAULT NULL,
  `mapsenabled` tinyint(4) unsigned DEFAULT NULL,
  `reportsenabled` tinyint(4) unsigned DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `createdby` int(11) unsigned NOT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membershipplan_name_unique` (`name`) USING BTREE,
  KEY `fk_membershipplan_createdby` (`createdby`),
  KEY `fk_membershipplan_lastupdatedby` (`lastupdatedby`),
  CONSTRAINT `fk_membershipplan_createdby` FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_membershipplan_lastupdatedby` FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `membershipplan`
--

/*!40000 ALTER TABLE `membershipplan` DISABLE KEYS */;
INSERT INTO `membershipplan` (`id`,`name`,`trialdays`,`usagedays`,`amount`,`nooffarms`,`noofseasons`,`noofactivities`,`calendarenabled`,`mapsenabled`,`reportsenabled`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`) VALUES 
 (1,'Basic','30','180','0','1','1','10',1,1,0,'2013-01-01 00:00:00',1,NULL,NULL),
 (2,'Premium','0','180','9200',NULL,NULL,NULL,1,1,1,'2013-01-01 00:00:00',1,NULL,NULL),
 (3,'Enterprise',NULL,NULL,NULL,NULL,NULL,NULL,1,1,1,'2013-01-01 00:00:00',1,NULL,NULL),
 (4,'Farm Group','30','365','360000',NULL,NULL,NULL,1,1,1,'2013-01-01 00:00:00',1,NULL,NULL);
/*!40000 ALTER TABLE `membershipplan` ENABLE KEYS */;


--
-- Definition of table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `membershipplanid` int(11) unsigned NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `isactive` tinyint(4) NOT NULL,
  `istrial` tinyint(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscription_membershipplanid` (`membershipplanid`),
  KEY `fk_subscription_userid` (`userid`) USING BTREE,
  KEY `index_subscription_isactive` (`isactive`) USING BTREE,
  KEY `index_subscription_istrial` (`istrial`),
  CONSTRAINT `fk_subscription_membershipplanid` FOREIGN KEY (`membershipplanid`) REFERENCES `membershipplan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_subscription_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscription`
--

/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
INSERT INTO `subscription` (`id`,`userid`,`membershipplanid`,`startdate`,`enddate`,`isactive`,`istrial`) VALUES 
 (9,38,1,'2013-01-24','2013-02-23',1,1),
 (10,40,1,'2013-01-24','2013-02-23',1,1),
 (11,360,1,'2013-02-01','2013-03-03',1,1),
 (12,2402,1,'2013-03-04','2013-04-03',1,1),
 (13,2790,4,'2013-03-19','2013-04-18',1,1);
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
