SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `membershipplan`;
CREATE TABLE `membershipplan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `trialdays` decimal(10,0) unsigned DEFAULT '1',
  `usagedays` decimal(10,0) unsigned DEFAULT '0',
  `amount` decimal(10,0) unsigned DEFAULT NULL,
  `nooffarms` decimal(10,0) unsigned DEFAULT NULL,
  `noofseasons` decimal(10,0) unsigned DEFAULT NULL,
  `noofactivities` decimal(10,0) unsigned DEFAULT NULL,
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
 (1,'Basic','0','30','0',NULL,NULL,NULL,1,0,0,'2013-01-01 00:00:00',1,NULL,NULL),
 (2,'Premium','0','180','9200',NULL,NULL,NULL,1,1,1,'2013-01-01 00:00:00',1,NULL,NULL),
 (3,'Basic Farm Group','0','15','0',NULL,NULL,NULL,1,0,0,'2013-01-01 00:00:00',1,NULL,NULL),
 (4,'Premium Farm Group','0','365','360000',NULL,NULL,NULL,1,1,1,'2013-01-01 00:00:00',1,NULL,NULL);
/*!40000 ALTER TABLE `membershipplan` ENABLE KEYS */;

SET foreign_key_checks = 1;