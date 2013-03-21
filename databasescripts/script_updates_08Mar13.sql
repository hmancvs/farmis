/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `farmer` DROP FOREIGN KEY `fk_farmer_farmgroupid` ;

ALTER TABLE `farmer` DROP FOREIGN KEY `fk_farmer_invitedbyid` ;

ALTER TABLE `farmer` DROP FOREIGN KEY `fk_farmer_lastupdatedby` ;

ALTER TABLE `farmer` DROP FOREIGN KEY `fk_farmer_subgroupid` ;

ALTER TABLE `farmer` DROP FOREIGN KEY `fk_farmer_userid` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_addressid` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_createdby` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_farmerid` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_lastupdatedby` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_locationid` ;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_membershipid` ;


/* Alter table in target */
ALTER TABLE `farmer` 
	ADD COLUMN `isphoneinvited` tinyint(4) unsigned   NULL DEFAULT '0' after `isinvited`, 
	CHANGE `hasacceptedinvite` `hasacceptedinvite` tinyint(4) unsigned   NULL after `isphoneinvited`, 
	CHANGE `invitedbyid` `invitedbyid` int(11) unsigned   NULL after `hasacceptedinvite`, 
	CHANGE `dateinvited` `dateinvited` date   NULL after `invitedbyid`, 
	CHANGE `regdate` `regdate` date   NULL after `dateinvited`, 
	CHANGE `lat` `lat` varchar(10)  COLLATE utf8_general_ci NULL after `regdate`, 
	CHANGE `lng` `lng` varchar(10)  COLLATE utf8_general_ci NULL after `lat`, 
	CHANGE `lat_gps` `lat_gps` varchar(15)  COLLATE utf8_general_ci NULL after `lng`, 
	CHANGE `lng_gps` `lng_gps` varchar(15)  COLLATE utf8_general_ci NULL after `lat_gps`, 
	CHANGE `farmingtypes` `farmingtypes` varchar(50)  COLLATE utf8_general_ci NULL after `lng_gps`, 
	CHANGE `supporttypes` `supporttypes` varchar(50)  COLLATE utf8_general_ci NULL after `farmingtypes`, 
	CHANGE `activitytypes` `activitytypes` varchar(50)  COLLATE utf8_general_ci NULL after `supporttypes`, 
	CHANGE `supportprovider` `supportprovider` varchar(50)  COLLATE utf8_general_ci NULL after `activitytypes`, 
	CHANGE `leadershiprole` `leadershiprole` varchar(50)  COLLATE utf8_general_ci NULL after `supportprovider`, 
	CHANGE `selfregistered` `selfregistered` tinyint(4) unsigned   NULL DEFAULT '0' after `leadershiprole`, 
	CHANGE `datecreated` `datecreated` datetime   NULL after `selfregistered`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, COMMENT='';

/* Alter table in target */
ALTER TABLE `useraccount` 
	ADD COLUMN `dashwizard` tinyint(4) unsigned   NULL DEFAULT '1' after `emailmeonmessage`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `dashwizard`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, COMMENT=''; 

	/* Alter table in target */
ALTER TABLE `useraccount` 
	ADD COLUMN `dashwelcome` tinyint(4) unsigned   NULL DEFAULT '1' after `dashwizard`, 
	CHANGE `datecreated` `datecreated` datetime   NOT NULL after `dashwelcome`, 
	CHANGE `createdby` `createdby` int(11) unsigned   NULL after `datecreated`, 
	CHANGE `lastupdatedate` `lastupdatedate` datetime   NULL after `createdby`, 
	CHANGE `lastupdatedby` `lastupdatedby` int(11) unsigned   NULL after `lastupdatedate`, COMMENT='';

UPDATE `useraccount` SET `dashwizard` = 1;
UPDATE `useraccount` SET `dashwelcome` = 1;	
/* The foreign keys that were dropped are now re-created*/

ALTER TABLE `farmer`
ADD CONSTRAINT `fk_farmer_farmgroupid` 
FOREIGN KEY (`farmgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmer`
ADD CONSTRAINT `fk_farmer_invitedbyid` 
FOREIGN KEY (`invitedbyid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `farmer`
ADD CONSTRAINT `fk_farmer_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `farmer`
ADD CONSTRAINT `fk_farmer_subgroupid` 
FOREIGN KEY (`subgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `farmer`
ADD CONSTRAINT `fk_farmer_userid` 
FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_addressid` 
FOREIGN KEY (`addressid`) REFERENCES `address` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_farmerid` 
FOREIGN KEY (`farmerid`) REFERENCES `farmer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_locationid` 
FOREIGN KEY (`locationid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_membershipid` 
FOREIGN KEY (`membershipplanid`) REFERENCES `membershipplan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


UPDATE `lookuptypevalue` set createdby = 1;
/* Alter table in target */
ALTER TABLE `lookuptypevalue` 
	ADD KEY `fk_lookuptypevalue_createdby`(`createdby`), 
	ADD KEY `fk_lookuptypevalue_lastupdatedby`(`lastupdatedby`), 
	ADD KEY `fk_lookuptypevalue_lookuptypeid`(`lookuptypeid`), COMMENT='';

/* Alter ForeignKey(s)in target */

ALTER TABLE `lookuptypevalue`
ADD CONSTRAINT `fk_lookuptypevalue_createdby` 
FOREIGN KEY (`createdby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lookuptypevalue`
ADD CONSTRAINT `fk_lookuptypevalue_lastupdatedby` 
FOREIGN KEY (`lastupdatedby`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lookuptypevalue`
ADD CONSTRAINT `fk_lookuptypevalue_lookuptypeid` 
FOREIGN KEY (`lookuptypeid`) REFERENCES `lookuptype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;