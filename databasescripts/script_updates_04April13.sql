
/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

SET foreign_key_checks = 0;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_addressid` ;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_createdby` ;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_farmerid` ;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_historyid` ;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_lastupdatedby` ;

ALTER TABLE `farm` DROP FOREIGN KEY `fk_farm_parentid` ;

ALTER TABLE `farmpreseason` DROP FOREIGN KEY `fk_farmpreseason_farmerid` ;

ALTER TABLE `farmpreseason` DROP FOREIGN KEY `fk_farmpreseason_farmid` ;

ALTER TABLE `farmpreseason` DROP FOREIGN KEY `fk_farmpreseason_loanid` ;

ALTER TABLE `farmpreseason` DROP FOREIGN KEY `fk_farmpreseason_userid` ;

ALTER TABLE `farmpreseasondetail` DROP FOREIGN KEY `fk_farmpreseasondetail_loanid` ;

ALTER TABLE `loan` DROP FOREIGN KEY `fk_loan_preseasonid` ;

ALTER TABLE `season` DROP FOREIGN KEY `fk_season_createdby` ;

ALTER TABLE `season` DROP FOREIGN KEY `fk_season_cropid` ;

ALTER TABLE `season` DROP FOREIGN KEY `fk_season_farmerid` ;

ALTER TABLE `season` DROP FOREIGN KEY `fk_season_farmid` ;

ALTER TABLE `season` DROP FOREIGN KEY `fk_season_loanid` ;


/* Alter table in target */
ALTER TABLE `farm` 
	CHANGE `notes` `notes` mediumtext  COLLATE utf8_general_ci NULL after `hashistory`, 
	CHANGE `addressid` `addressid` int(10) unsigned   NULL after `notes`, 
	CHANGE `farmingtools` `farmingtools` varchar(50)  COLLATE utf8_general_ci NULL after `addressid`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `farmingtools`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NOT NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, 
	DROP COLUMN `historyid`, 
	DROP KEY `fk_farm_historyid`;

/* Alter table in target */
ALTER TABLE `farmpreseason` 
	CHANGE `notes` `notes` varchar(1000)  COLLATE utf8_general_ci NULL after `usedloan`, 
	CHANGE `datecreated` `datecreated` date   NULL after `notes`, 
	CHANGE `createdby` `createdby` int(11)   NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` date   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11)   NULL after `lastupdatedate`, 
	DROP COLUMN `loanid`, 
	DROP KEY `fk_farmpreseason_loanid`;

/* Alter table in target */
ALTER TABLE `farmpreseasondetail` 
	DROP COLUMN `loanid`, 
	DROP KEY `fk_farmpreseasondetail_loanid`;

/* Alter table in target */
-- ALTER TABLE `loan`;

/* Alter table in target */
ALTER TABLE `season` 
	CHANGE `notes` `notes` varchar(1000)  COLLATE utf8_general_ci NULL after `fieldsizeunit`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `notes`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NOT NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, 
	CHANGE `cropid` `cropid` int(11) unsigned   NULL after `lastupdatedby`, 
	DROP COLUMN `loanid`, 
	DROP KEY `fk_season_loanid`;

/* Alter ForeignKey(s)in target */

ALTER TABLE `loan`
ADD CONSTRAINT `fk_loan_preseasonid` 
FOREIGN KEY (`preseasonid`) REFERENCES `farmpreseasondetail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 

/* The foreign keys that were dropped are now re-created*/

ALTER TABLE `farm`
ADD CONSTRAINT `fk_farm_addressid` 
FOREIGN KEY (`addressid`) REFERENCES `address` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `farm`
ADD CONSTRAINT `fk_farm_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farm`
ADD CONSTRAINT `fk_farm_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farm`
ADD CONSTRAINT `fk_farm_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farm`
ADD CONSTRAINT `fk_farm_parentid` 
FOREIGN KEY (`parentid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmpreseason`
ADD CONSTRAINT `fk_farmpreseason_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmpreseason`
ADD CONSTRAINT `fk_farmpreseason_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmpreseason`
ADD CONSTRAINT `fk_farmpreseason_userid` 
FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `season`
ADD CONSTRAINT `fk_season_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `season`
ADD CONSTRAINT `fk_season_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `season`
ADD CONSTRAINT `fk_season_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `season`
ADD CONSTRAINT `fk_season_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_createdby` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_farmerid` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_farmid` ;

ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_lastupdatedby` ;

ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_createdby` ;

ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_cropid` ;

ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_farmid` ;

ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_lastupdatedby` ;

ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_seasonid` ;

ALTER TABLE `seasontillage` DROP FOREIGN KEY `fk_seasontillage_createdby` ;

ALTER TABLE `seasontillage` DROP FOREIGN KEY `fk_seasontillage_farmid` ;

ALTER TABLE `seasontillage` DROP FOREIGN KEY `fk_seasontillage_lastupdatedby` ;

ALTER TABLE `seasontillage` DROP FOREIGN KEY `fk_seasontillage_seasonid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_createdby` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_cropid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_farmid` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_lastupdatedby` ;

ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_seasonid` ;


/* Alter table in target */
ALTER TABLE `sales` 
	ADD COLUMN `activityname` varchar(255)  COLLATE utf8_general_ci NULL after `ref`, 
	CHANGE `farmid` `farmid` int(11) unsigned   NULL after `activityname`, 
	CHANGE `farmerid` `farmerid` int(11) unsigned   NULL after `farmid`, 
	CHANGE `seasonid` `seasonid` int(11) unsigned   NULL after `farmerid`, 
	CHANGE `cropid` `cropid` int(11) unsigned   NULL after `seasonid`, 
	CHANGE `startdate` `startdate` date   NULL after `cropid`, 
	CHANGE `enddate` `enddate` date   NULL after `startdate`, 
	CHANGE `status` `status` tinyint(4) unsigned   NULL after `enddate`, 
	CHANGE `quantity` `quantity` decimal(10,2) unsigned   NULL after `status`, 
	CHANGE `quantityunit` `quantityunit` int(10) unsigned   NULL after `quantity`, 
	CHANGE `unitprice` `unitprice` decimal(10,0) unsigned   NULL after `quantityunit`, 
	CHANGE `totalamount` `totalamount` decimal(10,0) unsigned   NULL DEFAULT '0' after `unitprice`, 
	CHANGE `totalexpenses` `totalexpenses` decimal(10,0)   NULL DEFAULT '0' after `totalamount`, 
	CHANGE `clienttype` `clienttype` tinyint(4) unsigned   NULL after `totalexpenses`, 
	CHANGE `contract` `contract` varchar(1000)  COLLATE utf8_general_ci NULL after `clienttype`, 
	CHANGE `clientname` `clientname` varchar(255)  COLLATE utf8_general_ci NULL after `contract`, 
	CHANGE `clientphone` `clientphone` varchar(15)  COLLATE utf8_general_ci NULL after `clientname`, 
	CHANGE `addtodir` `addtodir` tinyint(4) unsigned   NULL after `clientphone`, 
	CHANGE `notes` `notes` varchar(1000)  COLLATE utf8_general_ci NULL after `addtodir`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `notes`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NOT NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`;

/* Alter table in target */
ALTER TABLE `seasonplanting` 
	CHANGE `seedingrate` `seedingrate` decimal(10,2) unsigned   NULL after `method`, 
	CHANGE `totalplanted` `totalplanted` decimal(10,2) unsigned   NULL after `seedingrateunit`;

/* Alter table in target */
ALTER TABLE `seasontillage` 
	CHANGE `depth` `depth` decimal(10,2) unsigned   NULL after `fieldsizeunit`, 
	CHANGE `widthunit` `widthunit` decimal(10,2) unsigned   NULL after `width`;

/* Alter table in target */
ALTER TABLE `seasontracking` 
	ADD COLUMN `activityname` varchar(255)  COLLATE utf8_general_ci NULL after `cropid`, 
	CHANGE `ref` `ref` varchar(50)  COLLATE utf8_general_ci NULL after `activityname`, 
	CHANGE `itemname` `itemname` varchar(255)  COLLATE utf8_general_ci NULL after `ref`, 
	CHANGE `itemtype` `itemtype` int(10) unsigned   NULL after `itemname`, 
	CHANGE `itemform` `itemform` int(10) unsigned   NULL after `itemtype`, 
	CHANGE `itemstorage` `itemstorage` int(10) unsigned   NULL after `itemform`, 
	CHANGE `startdate` `startdate` date   NULL after `itemstorage`, 
	CHANGE `enddate` `enddate` date   NULL after `startdate`, 
	CHANGE `status` `status` tinyint(4) unsigned   NULL after `enddate`, 
	CHANGE `method` `method` tinyint(4) unsigned   NULL after `status`, 
	CHANGE `timing` `timing` tinyint(4) unsigned   NULL after `method`, 
	CHANGE `itemrate` `itemrate` int(10) unsigned   NULL after `timing`, 
	CHANGE `itemrateunit` `itemrateunit` int(10) unsigned   NULL after `itemrate`, 
	CHANGE `totalapplied` `totalapplied` int(10) unsigned   NULL after `itemrateunit`, 
	CHANGE `totalappliedunit` `totalappliedunit` int(10) unsigned   NULL after `totalapplied`, 
	CHANGE `financetype` `financetype` tinyint(4) unsigned   NULL after `totalappliedunit`, 
	CHANGE `totalexpenses` `totalexpenses` decimal(10,0) unsigned   NULL DEFAULT '0' after `financetype`, 
	CHANGE `target` `target` varchar(500)  COLLATE utf8_general_ci NULL after `totalexpenses`, 
	CHANGE `additives` `additives` varchar(500)  COLLATE utf8_general_ci NULL after `target`, 
	CHANGE `notes` `notes` varchar(1000)  COLLATE utf8_general_ci NULL after `additives`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `notes`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NOT NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`; 

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

ALTER TABLE `seasonplanting`
ADD CONSTRAINT `fk_seasonplanting_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonplanting`
ADD CONSTRAINT `fk_seasonplanting_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonplanting`
ADD CONSTRAINT `fk_seasonplanting_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonplanting`
ADD CONSTRAINT `fk_seasonplanting_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasonplanting`
ADD CONSTRAINT `fk_seasonplanting_seasonid` 
FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontillage`
ADD CONSTRAINT `fk_seasontillage_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontillage`
ADD CONSTRAINT `fk_seasontillage_farmid` 
FOREIGN KEY (`farmid`) REFERENCES `farm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontillage`
ADD CONSTRAINT `fk_seasontillage_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `seasontillage`
ADD CONSTRAINT `fk_seasontillage_seasonid` 
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