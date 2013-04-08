
SET foreign_key_checks = 0;
/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_createdby` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_farmerid` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_farmid` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_lastupdatedby` ;

ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_createdby` ;

ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_cropid` ;

ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_farmid` ;

ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_lastupdatedby` ;

ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_seasonid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_createdby` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_cropid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_farmid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_lastupdatedby` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_seasonid` ;


/* Alter table in target */
ALTER TABLE `sales` 
	ADD COLUMN `financetype` tinyint(4) unsigned   NULL after `addtodir`, 
	CHANGE `notes` `notes` varchar(1000)  COLLATE utf8_general_ci NULL after `financetype`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `notes`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NOT NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, 
	ADD KEY `fk_sales_cropid`(`cropid`), COMMENT='';

/* Alter table in target */
ALTER TABLE `seasonharvest` 
	CHANGE `yield` `yield` decimal(10,2) unsigned   NULL after `method`, 
	CHANGE `totalharvest` `totalharvest` decimal(10,2) unsigned   NULL after `yieldunit`, COMMENT='';

/* Create table in target */
CREATE TABLE `seasonlabour`(
	`id` int(11) unsigned NOT NULL  auto_increment , 
	`farmerid` int(11) unsigned NULL  , 
	`farmid` int(11) unsigned NULL  , 
	`seasonid` int(11) unsigned NULL  , 
	`type` tinyint(4) unsigned NULL  DEFAULT '1' , 
	`activityname` varchar(255) COLLATE utf8_general_ci NULL  , 
	`mcount` decimal(10,0) unsigned NULL  , 
	`mhoursperday` decimal(10,2) unsigned NULL  , 
	`mtotaldays` decimal(10,2) unsigned NULL  , 
	`wcount` decimal(10,0) unsigned NULL  , 
	`whoursperday` decimal(10,2) unsigned NULL  , 
	`wtotaldays` decimal(10,2) unsigned NULL  , 
	`kcount` decimal(10,0) unsigned NULL  , 
	`khoursperday` decimal(10,2) unsigned NULL  , 
	`ktotaldays` decimal(10,2) unsigned NULL  , 
	`quantity` decimal(10,2) unsigned NULL  , 
	`quantityunit` int(10) unsigned NULL  , 
	`fieldsize` decimal(10,2) unsigned NULL  , 
	`fieldsizeunit` tinyint(4) unsigned NULL  , 
	`fieldcost` decimal(10,0) unsigned NULL  , 
	`itempaid` varchar(50) COLLATE utf8_general_ci NULL  , 
	`itemqty` decimal(10,2) unsigned NULL  , 
	`unitprice` decimal(10,0) unsigned NULL  , 
	`amount` decimal(10,0) unsigned NULL  DEFAULT '0' , 
	`datecreated` datetime NOT NULL  , 
	`createdby` int(11) unsigned NOT NULL  , 
	`lastupdatedate` datetime NULL  , 
	`lastupdatedby` int(11) unsigned NULL  , 
	`inputid` int(10) unsigned NULL  , 
	`tillageid` int(11) unsigned NULL  , 
	`plantingid` int(11) unsigned NULL  , 
	`trackingid` int(11) unsigned NULL  , 
	`activityid` int(11) unsigned NULL  , 
	`harvestid` int(11) unsigned NULL  , 
	`saleid` int(11) unsigned NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `fk_seasonlabour_createdby`(`createdby`) , 
	KEY `fk_seasonlabour_lastupdatedby`(`lastupdatedby`) , 
	KEY `fk_seasonlabour_farmerid`(`farmerid`) , 
	KEY `fk_seasonlabour_seasonid`(`seasonid`) , 
	KEY `fk_seasonlabour_farmid`(`farmid`) , 
	KEY `fk_seasonlabour_activityid`(`activityid`) , 
	KEY `fk_seasonlabour_harvestid`(`harvestid`) , 
	KEY `fk_seasonlabour_inputid`(`inputid`) , 
	KEY `fk_seasonlabour_plantingid`(`plantingid`) , 
	KEY `fk_seasonlabour_saleid`(`saleid`) , 
	KEY `fk_seasonlabour_tillageid`(`tillageid`) , 
	KEY `fk_seasonlabour_trackingid`(`trackingid`) 
) ENGINE=InnoDB DEFAULT CHARSET='utf8';


/* Alter table in target */
ALTER TABLE `seasontracking` 
	CHANGE `itemrate` `itemrate` decimal(10,2) unsigned   NULL after `timing`, 
	CHANGE `totalapplied` `totalapplied` decimal(10,2) unsigned   NULL after `itemrateunit`, COMMENT='';

/* Alter ForeignKey(s)in target */

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_seasonid` 
FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/* Create ForeignKey(s) in Second database */ 

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_activityid` 
FOREIGN KEY (`activityid`) REFERENCES `seasonactivity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_harvestid` 
FOREIGN KEY (`harvestid`) REFERENCES `seasonharvest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_inputid` 
FOREIGN KEY (`inputid`) REFERENCES `seasoninput` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_plantingid` 
FOREIGN KEY (`plantingid`) REFERENCES `seasonplanting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_saleid` 
FOREIGN KEY (`saleid`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_seasonid` 
FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_tillageid` 
FOREIGN KEY (`tillageid`) REFERENCES `seasontillage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonlabour`
ADD CONSTRAINT `fk_seasonlabour_trackingid` 
FOREIGN KEY (`trackingid`) REFERENCES `seasontracking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 

/* The foreign keys that were dropped are now re-created*/

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sales`
ADD CONSTRAINT `fk_sales_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonharvest`
ADD CONSTRAINT `fk_seasonharvest_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonharvest`
ADD CONSTRAINT `fk_seasonharvest_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonharvest`
ADD CONSTRAINT `fk_seasonharvest_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonharvest`
ADD CONSTRAINT `fk_seasonharvest_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonharvest`
ADD CONSTRAINT `fk_seasonharvest_seasonid` 
FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontracking`
ADD CONSTRAINT `fk_seasontracking_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontracking`
ADD CONSTRAINT `fk_seasontracking_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontracking`
ADD CONSTRAINT `fk_seasontracking_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontracking`
ADD CONSTRAINT `fk_seasontracking_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontracking`
ADD CONSTRAINT `fk_seasontracking_seasonid` 
FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


SET foreign_key_checks = 1;