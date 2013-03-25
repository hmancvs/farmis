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


SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `lookuptype`;
CREATE TABLE `lookuptype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `displayname` varchar(50) NOT NULL,
  `listable` tinyint(4) unsigned DEFAULT '1',
  `updatable` tinyint(4) unsigned DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL,
  `createdby` int(11) unsigned NOT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `lookuptype` DISABLE KEYS */;
INSERT INTO `lookuptype` (`id`,`name`,`displayname`,`listable`,`updatable`,`description`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`) VALUES 
 (1,'YES_NO','Yes No Boolean ',1,0,'Yes, No value options.','2012-03-01 12:00:00',2012,NULL,NULL),
 (2,'TRANSACTION_TYPES','Transaction Types',1,0,'System Audit Trail transaction types.','2012-03-01 12:00:00',2012,NULL,NULL),
 (3,'LIST_ITEM_COUNT_OPTIONS','Listing Items Per Page Values',1,0,'Available number of items per page on lists','2012-03-01 12:00:00',2012,NULL,NULL),
 (4,'ACTIVE_STATUS','Active Status Boolean',1,0,'Whether a user is active or not','2012-03-01 12:00:00',2012,NULL,NULL),
 (7,'GENDER','Gender Values',1,0,'The different gender values','2012-03-19 18:50:51',2012,NULL,NULL),
 (8,'SALUTATION','Salutations',1,1,'The different salutations Mr, Mrs, Dr, etc','2009-05-12 19:18:15',2012,NULL,NULL),
 (9,'ALL_CONTACT_TYPES','Business Directory Categories',1,1,'The types of contacts in the business directory','2011-05-05 14:40:51',2012,NULL,NULL),
 (10,'FORUM_CATEGORIES','Community Forum Categories',1,1,'Categorization for forum posts','2011-11-22 10:49:09',2012,NULL,NULL),
 (11,'LAND_MEASURE_UNITS','Land Measure Units',1,1,'The units for land measure','2012-03-01 12:00:00',2012,NULL,NULL),
 (12,'LAND_ACQUIRE_METHODS','Land Acquiring Methods',1,1,'The methods used to acquire farmer land','2012-03-01 12:00:00',2012,NULL,NULL),
 (13,'ACTION_STATUS','Activity Statuses',1,1,'The progress status values','2012-03-01 12:00:00',2012,NULL,NULL),
 (14,'INPUT_TYPES','Season Input Types',1,1,'The categories of Season Inputs','2012-03-01 12:00:00',2012,NULL,NULL),
 (15,'EXPENSE_TYPES','Expense Types',1,1,'The categories of Season Expenses','2012-03-01 12:00:00',2012,NULL,NULL),
 (16,'TILLAGE_TYPES','Tillage Types',1,1,'The types of Tillage','2012-03-01 12:00:00',2012,NULL,NULL),
 (17,'PRIMARY_TILLAGE_METHODS','Primary Tillage Methods',1,1,'The primary methods of Tillage','2012-03-01 12:00:00',2012,NULL,NULL),
 (18,'SECONDARY_TILLAGE_METHODS','Secondary Tillage Methods',1,1,'The secondary methods of Tillage','2012-03-01 12:00:00',2012,NULL,NULL),
 (19,'DEPTH_UNITS','Depth Units',1,1,'The units of measure for depth','2012-03-01 12:00:00',2012,NULL,NULL),
 (20,'SEEDING_UNITS','Seeding Units',1,1,'The units of measure for seeding','2012-03-01 12:00:00',2012,NULL,NULL),
 (21,'PLANTING_UNITS','Planting Units',1,1,'The units for the different planting methods','2012-03-01 12:00:00',2012,NULL,NULL),
 (22,'PLANTING_METHODS','Planting Methods',1,1,'The planting methods available','2012-03-01 12:00:00',2012,NULL,NULL),
 (23,'TREATMENT_METHODS','Treatment Methods',1,1,'The treatment methods','2012-03-01 12:00:00',2012,NULL,NULL),
 (24,'TREATMENT_MEASURE_UNITS','Treatment Measure Units',1,1,'The units of measure for treatment','2012-03-01 12:00:00',2012,NULL,NULL),
 (25,'TREATMENT_VOLUME_UNITS','Treatment Volume Units',1,1,'The volume units  for season treatment','2012-03-01 12:00:00',2012,NULL,NULL),
 (26,'SEASON_TIMING_VALUES','Season Timing Values',1,1,'The season timing points','2012-03-01 12:00:00',2012,NULL,NULL),
 (27,'SEASON_TREATMENT_TYPES','Season Treatment Types',1,1,'The season treatment types','2012-03-01 12:00:00',2012,NULL,NULL),
 (28,'SEASON_TREATMENT_FORMS','Season Treatment Forms',1,1,'The season treatment forms','2012-03-01 12:00:00',2012,NULL,NULL),
 (29,'SEASON_HARVEST_UNITS','Season Harvest Units',1,1,'The season treatment forms','2012-03-01 12:00:00',2012,NULL,NULL),
 (30,'YIELD_UNITS','Harvest Yield Units',1,1,'The units for yield','2012-03-01 12:00:00',2012,NULL,NULL),
 (31,'HARVEST_METHODS','Harvest Methods ',1,1,'The season harvesting methods','2012-03-01 12:00:00',2012,NULL,NULL),
 (32,'SALES_DESTINATIONS','Season Sales Parties',1,1,'The party to whom produce is sold to','2012-03-01 12:00:00',2012,NULL,NULL),
 (33,'INVENTORY_TYPES','Farm Inventory Types',1,1,'The types of inventory','2012-03-01 12:00:00',2012,NULL,NULL),
 (34,'SERVICE_TYPES','Inventory Service Types',1,1,'The methods of inventory servicing','2012-03-01 12:00:00',2012,NULL,NULL),
 (35,'FINANCIAL_INSTITUTIONS','Financial Credit Institutions',1,1,'The financial institutions providing farmer support','2012-03-01 12:00:00',2012,NULL,NULL),
 (36,'ALL_CLIENTS','Client List',1,1,'The clients providing support to farmers','2012-03-01 12:00:00',2012,NULL,NULL),
 (37,'CONTACTUS_CATEGORIES','Contact Us Form Categories',1,1,'The contactus form categories','2012-03-01 12:00:00',2012,NULL,NULL),
 (38,'SALES_PRICING_TYPES','Season Sales Types',1,1,'The forms of sale at end of season','2012-03-01 12:00:00',2012,NULL,NULL),
 (39,'FARMING_TYPES','Types of Farming',1,1,'The types of farming available','2012-03-01 12:00:00',2012,NULL,NULL),
 (40,'SUPPORT_TYPES','Farm Group Support Types',1,1,'The types of farming support received by farmers in groups','2012-03-01 12:00:00',2012,NULL,NULL),
 (41,'ACTIVITY_FORMS','Farmer Business Sectors',1,1,'Other forms of activities other than farming','2012-03-01 12:00:00',2012,NULL,NULL),
 (42,'FARMING_TOOLS','Farm Tools',1,1,'The tools used for farming','2012-03-01 12:00:00',2012,NULL,NULL),
 (43,'EDUCATION_LEVELS','Farmer Education Level',1,1,'The education level for farmers','2012-03-01 12:00:00',2012,NULL,NULL),
 (44,'MARITAL_STATUS_VALUES','Farmer Marital Status',1,1,'Farmer marital status values','2012-03-01 12:00:00',2012,NULL,NULL),
 (45,'FARM_GROUP_TYPES','Farm Group Types',1,1,'The farm group types','2012-03-01 12:00:00',2012,NULL,NULL);
/*!40000 ALTER TABLE `lookuptype` ENABLE KEYS */;


/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `farmpreseasondetail` DROP FOREIGN KEY `fk_farmpreseasondetail_cropid` ;
ALTER TABLE `farmpreseasondetail` DROP FOREIGN KEY `fk_farmpreseasondetail_loanid` ;
ALTER TABLE `farmpreseasondetail` DROP FOREIGN KEY `fk_farmpreseasondetail_preseasonid` ;

/* Alter table in target */
ALTER TABLE `farmpreseasondetail` 
	ADD COLUMN `farmid` int(11) unsigned   NULL after `preseasonid`, 
	CHANGE `cropid` `cropid` int(11) unsigned   NOT NULL after `farmid`, 
	CHANGE `fieldsize` `fieldsize` decimal(10,2) unsigned   NULL after `cropid`, 
	CHANGE `fieldsizeunit` `fieldsizeunit` int(10) unsigned   NULL after `fieldsize`, 
	CHANGE `inputsource` `inputsource` varchar(255)  COLLATE utf8_general_ci NULL after `fieldsizeunit`, 
	CHANGE `totalplanted` `totalplanted` decimal(2,0) unsigned   NULL after `inputsource`, 
	CHANGE `totalplantedunit` `totalplantedunit` int(10) unsigned   NULL after `totalplanted`, 
	CHANGE `yield` `yield` decimal(10,2) unsigned   NULL after `totalplantedunit`, 
	CHANGE `yieldunit` `yieldunit` int(10) unsigned   NULL after `yield`, 
	CHANGE `totalharvest` `totalharvest` decimal(10,2) unsigned   NULL after `yieldunit`, 
	CHANGE `totalharvestunit` `totalharvestunit` int(10) unsigned   NULL after `totalharvest`, 
	CHANGE `quantitysold` `quantitysold` decimal(10,2) unsigned   NULL after `totalharvestunit`, 
	CHANGE `quantitysoldunit` `quantitysoldunit` int(10) unsigned   NULL after `quantitysold`, 
	CHANGE `unitprice` `unitprice` decimal(10,0) unsigned   NULL after `quantitysoldunit`, 
	CHANGE `totalsalesamount` `totalsalesamount` decimal(10,0) unsigned   NULL DEFAULT '0' after `unitprice`, 
	CHANGE `totalexpenseamount` `totalexpenseamount` double(10,0) unsigned   NULL after `totalsalesamount`, 
	CHANGE `saletype` `saletype` tinyint(4) unsigned   NULL after `totalexpenseamount`, 
	CHANGE `productionconstraints` `productionconstraints` varchar(500)  COLLATE utf8_general_ci NULL after `saletype`, 
	CHANGE `marketingconstraints` `marketingconstraints` varchar(500)  COLLATE utf8_general_ci NULL after `productionconstraints`, 
	CHANGE `transactionconstraints` `transactionconstraints` varchar(500)  COLLATE utf8_general_ci NULL after `marketingconstraints`, 
	CHANGE `nextseasonrevenue` `nextseasonrevenue` decimal(10,0) unsigned   NULL after `transactionconstraints`, 
	CHANGE `nextseasonprodn` `nextseasonprodn` decimal(10,2) unsigned   NULL after `nextseasonrevenue`, 
	CHANGE `nextseasonprodnunit` `nextseasonprodnunit` int(10) unsigned   NULL after `nextseasonprodn`, 
	CHANGE `financetype` `financetype` tinyint(4) unsigned   NULL DEFAULT '0' after `nextseasonprodnunit`, 
	CHANGE `loanid` `loanid` int(11) unsigned   NULL after `financetype`, 
	ADD KEY `fk_farmpreseasondetail_farmid`(`farmid`), COMMENT='';

/* Alter ForeignKey(s)in target */

ALTER TABLE `farmpreseasondetail`
ADD CONSTRAINT `fk_farmpreseasondetail_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 

/* The foreign keys that were dropped are now re-created*/
ALTER TABLE `farmpreseasondetail`
ADD CONSTRAINT `fk_farmpreseasondetail_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmpreseasondetail`
ADD CONSTRAINT `fk_farmpreseasondetail_loanid` 
FOREIGN KEY (`loanid`) REFERENCES `loan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmpreseasondetail`
ADD CONSTRAINT `fk_farmpreseasondetail_preseasonid` 
FOREIGN KEY (`preseasonid`) REFERENCES `farmpreseason` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

SET foreign_key_checks = 1;
