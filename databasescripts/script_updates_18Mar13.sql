/* Alter table in target */
ALTER TABLE `farmpreseasondetail` 
	ADD COLUMN `nextseasonrevenue` decimal(10,0) unsigned  NULL DEFAULT '0' after `transactionconstraints`, 
	ADD COLUMN `financetype` tinyint(4) unsigned   NULL after `nextseasonrevenue`, 
	ADD COLUMN `loanid` int(11) unsigned   NULL after `financetype`, 
	ADD KEY `fk_farmpreseasondetail_loanid`(`loanid`), COMMENT='';

/* Alter ForeignKey(s)in target */

ALTER TABLE `farmpreseasondetail`
ADD CONSTRAINT `fk_farmpreseasondetail_loanid` 
FOREIGN KEY (`loanid`) REFERENCES `loan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/* Alter table in target */
ALTER TABLE `loan` 
	CHANGE `interestrate` `interestrate` decimal(10,2) unsigned   NULL after `principal`, COMMENT=''; 
	
ALTER TABLE `farmpreseasondetail` 
	CHANGE `nextseasonrevenue` `nextseasonrevenue` decimal(10,0) unsigned   NULL after `transactionconstraints`, 
	ADD COLUMN `nextseasonprodn` decimal(10,2) unsigned   NULL after `nextseasonrevenue`, 
	ADD COLUMN `nextseasonprodnunit` int(10) unsigned   NULL after `nextseasonprodn`, 
	CHANGE `financetype` `financetype` tinyint(4) unsigned   NULL DEFAULT '0' after `nextseasonprodnunit`, 
	CHANGE `loanid` `loanid` int(11) unsigned   NULL after `financetype`, COMMENT='';
	
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

/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `payment` DROP FOREIGN KEY `fk_payment_userid` ;
ALTER TABLE `subscription` DROP FOREIGN KEY `fk_subscription_membershipplanid` ;
ALTER TABLE `subscription` DROP FOREIGN KEY `fk_subscription_userid` ;

/* Alter table in target */
ALTER TABLE `payment` 
	CHANGE `userid` `userid` int(11) unsigned   NULL after `id`, 
	ADD COLUMN `farmerid` int(11) unsigned   NULL after `userid`, 
	ADD COLUMN `farmgroupid` int(11) unsigned   NULL after `farmerid`, 
	CHANGE `stem` `stem` tinyint(4)   NOT NULL after `farmgroupid`, 
	ADD COLUMN `item` varchar(500)  COLLATE utf8_general_ci NOT NULL after `stem`, 
	ADD COLUMN `subscriptionid` int(11) unsigned   NULL after `item`, 
	CHANGE `trxcode` `trxcode` varchar(32)  COLLATE utf8_general_ci NULL after `subscriptionid`, 
	CHANGE `trxdate` `trxdate` date   NOT NULL after `trxcode`, 
	ADD COLUMN `description` varchar(500)  COLLATE utf8_general_ci NULL after `trxdate`, 
	CHANGE `phone` `phone` varchar(15)  COLLATE utf8_general_ci NULL after `description`, 
	ADD COLUMN `amount` decimal(10,0) unsigned   NOT NULL DEFAULT '0' after `phone`, 
	ADD COLUMN `status` tinyint(4) unsigned   NOT NULL DEFAULT '3' after `amount`, 
	ADD COLUMN `paymenttype` tinyint(4) unsigned   NOT NULL DEFAULT '2' after `status`, 
	ADD COLUMN `verifiedbyid` int(11) unsigned   NULL after `paymenttype`, 
	ADD COLUMN `verifier` varchar(255)  COLLATE utf8_general_ci NULL after `verifiedbyid`, 
	ADD COLUMN `datecreated` datetime   NULL after `verifier`, 
	DROP COLUMN `itemid`, 
	ADD KEY `fk_payment_farmerid`(`farmerid`), 
	ADD KEY `fk_payment_farmgroupid`(`farmgroupid`), 
	ADD KEY `fk_payment_subscriptionid`(`subscriptionid`), COMMENT='';

/* Alter table in target */
ALTER TABLE `subscription` 
	CHANGE `id` `id` int(20) unsigned   NOT NULL auto_increment first, 
	CHANGE `userid` `userid` int(11) unsigned   NULL after `id`, 
	ADD COLUMN `farmerid` int(11) unsigned   NULL after `userid`, 
	ADD COLUMN `farmgroupid` int(11) unsigned   NULL after `farmerid`, 
	ADD COLUMN `planid` int(11) unsigned   NOT NULL after `farmgroupid`, 
	CHANGE `startdate` `startdate` date   NOT NULL after `planid`, 
	CHANGE `enddate` `enddate` date   NOT NULL after `startdate`, 
	CHANGE `isactive` `isactive` tinyint(4)   NOT NULL after `enddate`, 
	CHANGE `istrial` `istrial` tinyint(4) unsigned   NULL after `isactive`, 
	ADD COLUMN `verifiedbyid` int(11) unsigned   NULL after `istrial`, 
	ADD COLUMN `verifier` varchar(255)  COLLATE utf8_general_ci NULL after `verifiedbyid`, 
	ADD COLUMN `datecreated` datetime   NULL after `verifier`, 
	DROP COLUMN `membershipplanid`, 
	ADD KEY `fk_subscription_farmerid`(`farmerid`), 
	ADD KEY `fk_subscription_farmgroupid`(`farmgroupid`), 
	DROP KEY `fk_subscription_membershipplanid`, add KEY `fk_subscription_membershipplanid`(`planid`), COMMENT='';

UPDATE `subscription` SET planid = 1;

/* Alter ForeignKey(s)in target */

ALTER TABLE `payment`
ADD CONSTRAINT `fk_payment_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `payment`
ADD CONSTRAINT `fk_payment_farmgroupid` 
FOREIGN KEY (`farmgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `payment`
ADD CONSTRAINT `fk_payment_subscriptionid` 
FOREIGN KEY (`subscriptionid`) REFERENCES `subscription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/* Alter ForeignKey(s)in target */

ALTER TABLE `subscription`
ADD CONSTRAINT `fk_subscription_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `subscription`
ADD CONSTRAINT `fk_subscription_farmgroupid` 
FOREIGN KEY (`farmgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `subscription`
ADD CONSTRAINT `fk_subscription_planid` 
FOREIGN KEY (`planid`) REFERENCES `membershipplan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/* The foreign keys that were dropped are now re-created*/
ALTER TABLE `payment`
ADD CONSTRAINT `fk_payment_userid` 
FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `subscription`
ADD CONSTRAINT `fk_subscription_userid` 
FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


