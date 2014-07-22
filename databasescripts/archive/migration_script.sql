	
/* Alter table in target */
ALTER TABLE `useraccount` 
	  ADD COLUMN `farmgroupid` int(11) unsigned DEFAULT NULL,
	  ADD COLUMN `subgroupid` int(11) unsigned DEFAULT NULL,
	  ADD COLUMN `regno` varchar(15) DEFAULT NULL,
	  ADD COLUMN `refno` varchar(15) DEFAULT NULL,
	  ADD COLUMN `alias` varchar(255) DEFAULT '',
	  ADD COLUMN `prefix` varchar(15) DEFAULT NULL,
	  ADD COLUMN `salutation` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `signature` varchar(50) DEFAULT NULL,
	  ADD COLUMN `educationlevel` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `maritalstatus` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `numberofchildren` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `numberofdependants` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `totalhousehold` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `nextofkin_name` varchar(255) DEFAULT NULL,
	  ADD COLUMN `nextofkin_phone` varchar(45) DEFAULT NULL,
	  ADD COLUMN `nextofkin_email` varchar(50) DEFAULT NULL,
	  ADD COLUMN `isinvited` tinyint(4) DEFAULT NULL,
	  ADD COLUMN `isphoneinvited` tinyint(4) unsigned DEFAULT '0',
	  ADD COLUMN `hasacceptedinvite` tinyint(4) unsigned DEFAULT NULL,
	  ADD COLUMN `invitedbyid` int(11) unsigned DEFAULT NULL,
	  ADD COLUMN `dateinvited` date DEFAULT NULL,
	  ADD COLUMN `regdate` date DEFAULT NULL,
	  ADD COLUMN `lat` varchar(10) DEFAULT NULL,
	  ADD COLUMN `lng` varchar(10) DEFAULT NULL,
	  ADD COLUMN `lat_gps` varchar(15) DEFAULT NULL,
	  ADD COLUMN `lng_gps` varchar(15) DEFAULT NULL,
	  ADD COLUMN `farmingtypes` varchar(50) DEFAULT NULL,
	  ADD COLUMN `supporttypes` varchar(50) DEFAULT NULL,
	  ADD COLUMN `activitytypes` varchar(50) DEFAULT NULL,
	  ADD COLUMN `supportprovider` varchar(50) DEFAULT NULL,
	  ADD COLUMN `leadershiprole` varchar(50) DEFAULT NULL,
	  ADD COLUMN `selfregistered` tinyint(4) unsigned DEFAULT '0',
	ADD KEY `fk_useraccount_farmgroupid` (`farmgroupid`),
	ADD KEY `fk_useraccount_subgroupid` (`subgroupid`),
	ADD KEY `fk_useraccount_invitedbyid` (`invitedbyid`);
/* Alter ForeignKey(s)in target */

ALTER TABLE `useraccount`
ADD CONSTRAINT `fk_useraccount_farmgroupid` FOREIGN KEY (`farmgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_useraccount_subgroupid` FOREIGN KEY (`subgroupid`) REFERENCES `farmgroup` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `fk_useraccount_invitedbyid` FOREIGN KEY (`invitedbyid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `useraccount` 
  ADD COLUMN `districtid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `countyid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `subcountyid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `parishid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `villageid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `streetaddress` varchar(255) DEFAULT NULL,
  ADD COLUMN `city` varchar(50) DEFAULT NULL,
  ADD COLUMN `state` varchar(50) DEFAULT NULL,
  ADD COLUMN `zipcode` varchar(15) DEFAULT NULL,
  ADD KEY `fk_useraccount_districtid` (`districtid`),
  ADD KEY `fk_useraccount_countyid` (`countyid`),
  ADD KEY `fk_useraccount_subcountyid` (`subcountyid`),
  ADD KEY `fk_useraccount_parishid` (`parishid`),
  ADD KEY `fk_useraccount_villageid` (`villageid`);
  
ALTER TABLE `useraccount`  
  ADD CONSTRAINT `fk_useraccount_countyid` FOREIGN KEY (`countyid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_useraccount_districtid` FOREIGN KEY (`districtid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_useraccount_parishid` FOREIGN KEY (`parishid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_useraccount_subcountyid` FOREIGN KEY (`subcountyid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_useraccount_villageid` FOREIGN KEY (`villageid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
  
ALTER TABLE `useraccount` 
  ADD COLUMN `businessname` varchar(255) NOT NULL,
  ADD COLUMN `shortname` varchar(50) DEFAULT NULL,
  ADD COLUMN `description` varchar(255) DEFAULT NULL,
  ADD COLUMN `bizstartyear` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `bizstartmonth` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `logo` varchar(50) DEFAULT NULL,
  ADD COLUMN `landsize` decimal(10,2) unsigned DEFAULT NULL,
  ADD COLUMN `landactivesize` decimal(10,2) DEFAULT NULL,
  ADD COLUMN `landunits` tinyint(4) unsigned DEFAULT NULL,
  ADD COLUMN `landacquiremethod` tinyint(4) DEFAULT NULL,
  ADD COLUMN `landarea` varchar(50) DEFAULT NULL,
  ADD COLUMN `gpsmeta` varchar(500) DEFAULT NULL,
  ADD COLUMN `numberofbranches` tinyint(4) DEFAULT NULL,
  ADD COLUMN `numberoffields` tinyint(4) unsigned DEFAULT NULL,
  ADD COLUMN `numberofemployees` tinyint(4) DEFAULT NULL,
  ADD COLUMN `hashistory` tinyint(4) unsigned DEFAULT NULL,
  ADD COLUMN `farmingtools` varchar(50) DEFAULT NULL;
  
ALTER TABLE `useraccount`
ADD COLUMN `phone` varchar(15) DEFAULT NULL,
  ADD COLUMN `phone_activationkey` varchar(10) DEFAULT NULL,
  ADD COLUMN `phone_activationdate` datetime DEFAULT NULL,
  ADD COLUMN `phone_isactivated` tinyint(4) unsigned DEFAULT '0',
  ADD COLUMN `phone2` varchar(15) DEFAULT NULL,
  ADD COLUMN `phone2_activationkey` varchar(10) DEFAULT NULL,
  ADD COLUMN `phone2_activationdate` datetime DEFAULT NULL,
  ADD COLUMN `phone2_isactivated` tinyint(4) unsigned DEFAULT '0',
  ADD KEY `fk_useraccount_phone` (`phone`),
  ADD KEY `fk_useraccount_phone2` (`phone2`);

ALTER TABLE `farmgroup` 
  ADD COLUMN `districtid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `countyid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `subcountyid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `parishid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `villageid` int(11) unsigned DEFAULT NULL,
  ADD COLUMN `streetaddress` varchar(255) DEFAULT NULL,
  ADD COLUMN `city` varchar(50) DEFAULT NULL,
  ADD COLUMN `state` varchar(50) DEFAULT NULL,
  ADD COLUMN `zipcode` varchar(15) DEFAULT NULL,
  ADD KEY `fk_farmgroup_districtid` (`districtid`),
  ADD KEY `fk_farmgroup_countyid` (`countyid`),
  ADD KEY `fk_farmgroup_subcountyid` (`subcountyid`),
  ADD KEY `fk_farmgroup_parishid` (`parishid`),
  ADD KEY `fk_farmgroup_villageid` (`villageid`);

ALTER TABLE `farmgroup`  
  ADD CONSTRAINT `fk_farmgroup_countyid` FOREIGN KEY (`countyid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_farmgroup_districtid` FOREIGN KEY (`districtid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_farmgroup_parishid` FOREIGN KEY (`parishid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_farmgroup_subcountyid` FOREIGN KEY (`subcountyid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_farmgroup_villageid` FOREIGN KEY (`villageid`) REFERENCES `location` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
  
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`firstname` = f.`firstname`;  
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`lastname` = f.`lastname`;  
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`othernames` = f.`othernames`;  
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`farmgroupid` = f.`farmgroupid`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`subgroupid` = f.`subgroupid`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`regno` = f.`regno`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`refno` = f.`refno`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`alias` = f.`alias`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`prefix` = f.`prefix`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`salutation` = f.`salutation`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`signature` = f.`signature`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`educationlevel` = f.`educationlevel`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`maritalstatus` = f.`maritalstatus`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`numberofchildren` = f.`numberofchildren`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`numberofdependants` = f.`numberofdependants`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`totalhousehold` = f.`totalhousehold`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`nextofkin_name` = f.`nextofkin_name`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`nextofkin_phone` = f.`nextofkin_phone`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`nextofkin_email` = f.`nextofkin_email`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`isinvited` = f.`isinvited`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`isphoneinvited` = f.`isphoneinvited`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`hasacceptedinvite` = f.`hasacceptedinvite`;
UPDATE farmer f set f.invitedbyid = NULL where f.id = 451;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`invitedbyid` = f.`invitedbyid`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`dateinvited` = f.`dateinvited`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`regdate` = f.`regdate`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`lat` = f.`lat`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`lng` = f.`lng`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`lat_gps` = f.`lat_gps`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`lng_gps` = f.`lng_gps`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`farmingtypes` = f.`farmingtypes`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`supporttypes` = f.`supporttypes`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`activitytypes` = f.`activitytypes`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`supportprovider` = f.`supportprovider`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`leadershiprole` = f.`leadershiprole`;
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`selfregistered` = f.`selfregistered`;

UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`locationid` = a.`districtid` where a.`districtid` <> u.`locationid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`districtid` = a.`districtid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`countyid` = a.`countyid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`subcountyid` = a.`subcountyid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`parishid` = a.`parishid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`villageid` = a.`villageid`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`streetaddress` = a.`streetaddress`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`city` = a.`city`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`state` = a.`state`;
UPDATE useraccount u inner join address a on (u.id = a.userid) SET u.`zipcode` = a.`zipcode`;

UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`businessname` = f.`businessname`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`shortname` = f.`shortname`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`description` = f.`description`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`bizstartyear` = f.`bizstartyear`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`bizstartmonth` = f.`bizstartmonth`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`logo` = f.`logo`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`landsize` = f.`landsize`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`landactivesize` = f.`landactivesize`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`landunits` = f.`landunits`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`landacquiremethod` = f.`landacquiremethod`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`landarea` = f.`landarea`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`gpsmeta` = f.`gpsmeta`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`numberofbranches` = f.`numberofbranches`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`numberoffields` = f.`numberoffields`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`numberofemployees` = f.`numberofemployees`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`hashistory` = f.`hashistory`;
UPDATE useraccount u inner join farm f on (u.farmerid = f.farmerid) SET u.`farmingtools` = f.`farmingtools`;

UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 1) SET u.`phone` = p.`phone`;
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 1) SET u.`phone_activationkey` = p.`activationkey`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 1) SET u.`phone_activationdate` = p.`activationdate`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 1) SET u.`phone_isactivated` = p.`isactivated`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 0) SET u.`phone2` = p.`phone`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 0) SET u.`phone2_activationkey` = p.`activationkey`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 0) SET u.`phone2_activationdate` = p.`activationdate`;  
UPDATE useraccount u inner join userphone p on (u.id = p.userid AND p.isprimary = 0) SET u.`phone2_isactivated` = p.`isactivated`;  

ALTER TABLE `seasontracking` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasontracking_userid` (`userid`),
ADD CONSTRAINT `fk_seasontracking_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasontracking s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasontillage` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasontillage_userid` (`userid`),
ADD CONSTRAINT `fk_seasontillage_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasontillage s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasonplanting` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasonplanting_userid` (`userid`),
ADD CONSTRAINT `fk_seasonplanting_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasontillage s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasonlabour` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasonlabour_userid` (`userid`),
ADD CONSTRAINT `fk_seasonlabour_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasonlabour s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasoninput` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasoninput_userid` (`userid`),
ADD CONSTRAINT `fk_seasoninput_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasoninput s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasonharvest` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasonharvest_userid` (`userid`),
ADD CONSTRAINT `fk_seasonharvest_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasonharvest s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasondetail` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasondetail_userid` (`userid`),
ADD CONSTRAINT `fk_seasondetail_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasondetail s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `seasonactivity` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_seasonactivity_userid` (`userid`),
ADD CONSTRAINT `fk_seasonactivity_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE seasonactivity s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `season` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_season_userid` (`userid`),
ADD CONSTRAINT `fk_season_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE season s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `sales` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_sales_userid` (`userid`),
ADD CONSTRAINT `fk_sales_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE sales s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `loan` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_loan_userid` (`userid`),
ADD CONSTRAINT `fk_loan_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE loan s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `inventory` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_inventory_userid` (`userid`),
ADD CONSTRAINT `fk_inventory_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE inventory s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `inventorycategory` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_inventorycategory_userid` (`userid`),
ADD CONSTRAINT `fk_inventorycategory_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE inventorycategory s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `farmingtype` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_farmingtype_userid` (`userid`),
ADD CONSTRAINT `fk_farmingtype_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE farmingtype s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

ALTER TABLE `expense` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL,
ADD KEY `fk_expense_userid` (`userid`),
ADD CONSTRAINT `fk_expense_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
UPDATE expense s inner join farm f on (s.farmid = f.id) inner join useraccount u on (f.farmerid = u.farmerid) SET s.userid = u.id;

-- add regsource to useraccount
ALTER TABLE `useraccount` ADD COLUMN `regsource` tinyint(4) unsigned DEFAULT '0';
UPDATE useraccount u inner join farmer f on (u.farmerid = f.id) SET u.`regsource` = f.`regsource`;

ALTER TABLE `farmgroup` ADD COLUMN `country` varchar(2) DEFAULT 'UG';
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`country` = a.`country`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`districtid` = a.`districtid`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`countyid` = a.`countyid`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`subcountyid` = a.`subcountyid`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`parishid` = a.`parishid`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`villageid` = a.`villageid`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`streetaddress` = a.`streetaddress`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`city` = a.`city`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`state` = a.`state`;
UPDATE farmgroup f inner join address a on (f.id = a.farmgroupid) SET f.`zipcode` = a.`zipcode`;

UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`country` = a.`country` where f.country is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`districtid` = a.`districtid` where f.districtid is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`countyid` = a.`countyid` where f.countyid is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`subcountyid` = a.`subcountyid` where f.subcountyid is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`parishid` = a.`parishid` where f.parishid is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`villageid` = a.`villageid` where f.villageid is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`streetaddress` = a.`streetaddress` where f.streetaddress is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`city` = a.`city` where f.city is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`state` = a.`state` where f.`state` is null;
UPDATE farmgroup f inner join address a on (f.addressid = f.id) SET f.`zipcode` = a.`zipcode` where f.zipcode is null;

-- add userid, drop farmid on inventory
ALTER TABLE `inventory` ADD COLUMN `seasonid` int(11) unsigned DEFAULT NULL;
ALTER TABLE `inventory` ADD CONSTRAINT `fk_inventory_seasonid` FOREIGN KEY (`seasonid`) REFERENCES `season` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `inventory` DROP FOREIGN KEY `fk_inventory_farmid`, DROP COLUMN `farmid`; 
   
-- Drop columns
-- Remove addressid from useraccount
ALTER TABLE `comment` DROP COLUMN `farmerid`; 

ALTER TABLE `contact` ADD CONSTRAINT `fk_contact_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `contact` DROP FOREIGN KEY `fk_contact_farmerid`, DROP COLUMN `farmerid`, DROP COLUMN `farmid`; 

-- preseasondetails updates
ALTER TABLE `farmpreseasondetail` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL;
ALTER TABLE `farmpreseasondetail` ADD CONSTRAINT `fk_farmpreseasondetail_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
UPDATE `farmpreseasondetail` as fpd inner join farmpreseason as fp on (fpd.preseasonid = fp.id) inner join farmer f on (fp.farmerid = f.id) set fpd.userid = f.userid where fpd.userid is null;
UPDATE `farmpreseasondetail` as fpd inner join farmpreseason as fp on (fpd.preseasonid = fp.id) inner join farmer f on (fp.farmerid = f.id) set fp.userid = f.userid where fp.userid is null;
DELETE from farmpreseasondetail where preseasonid is null;
ALTER TABLE `farmpreseasondetail` DROP FOREIGN KEY `fk_farmpreseasondetail_farmid`, DROP COLUMN `farmid`;  

-- preseason updates
ALTER TABLE `farmpreseason` DROP FOREIGN KEY `fk_farmpreseason_farmerid`, DROP FOREIGN KEY `fk_farmpreseason_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`; 

-- document
ALTER TABLE `document` DROP FOREIGN KEY `fk_document_farmerid`, DROP FOREIGN KEY `fk_document_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- inventory category
ALTER TABLE `inventorycategory` DROP FOREIGN KEY `fk_inventorycategory_farmid`, DROP COLUMN `farmid`;

-- loan updates
ALTER TABLE `loan` DROP FOREIGN KEY `fk_loan_farmerid`, DROP FOREIGN KEY `fk_loan_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- notes
ALTER TABLE `notes` ADD COLUMN `userid` int(11) unsigned DEFAULT NULL;
ALTER TABLE `notes` DROP FOREIGN KEY `fk_notes_farmerid`, DROP FOREIGN KEY `fk_notes_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- expenses
ALTER TABLE `expense` DROP FOREIGN KEY `fk_expense_farmerid`, DROP FOREIGN KEY `fk_expense_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- sales
ALTER TABLE `sales` DROP FOREIGN KEY `fk_sales_farmerid`, DROP FOREIGN KEY `fk_sales_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- seasonactivity
ALTER TABLE `seasonactivity` DROP FOREIGN KEY `fk_seasonactivity_farmid`,  DROP COLUMN `farmid`;

-- season detail
ALTER TABLE `seasondetail` DROP FOREIGN KEY `fk_seasondetail_farmid`, DROP FOREIGN KEY fk_seasondetail_seasonid, DROP FOREIGN KEY fk_seasondetail_userid, DROP FOREIGN KEY fk_seasondetail_cropid;
DROP TABLE seasondetail;

-- season harvest
ALTER TABLE `seasonharvest` DROP FOREIGN KEY `fk_seasonharvest_farmid`,  DROP COLUMN `farmid`;

-- season input
ALTER TABLE `seasoninput` DROP FOREIGN KEY `fk_seasoninput_farmerid`, DROP FOREIGN KEY `fk_seasoninput_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- seasonlabour
ALTER TABLE `seasonlabour` DROP FOREIGN KEY `fk_seasonlabour_farmid`, DROP FOREIGN KEY `fk_seasonlabour_farmerid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- seasonplanting
ALTER TABLE `seasonplanting` DROP FOREIGN KEY `fk_seasonplanting_farmid`,  DROP COLUMN `farmid`;
UPDATE `seasonplanting` sp inner join season s on (sp.seasonid = s.id) set sp.userid = s.userid where sp.userid is null;

-- seasontillage
ALTER TABLE `seasontillage` DROP FOREIGN KEY `fk_seasontillage_farmid`,  DROP COLUMN `farmid`;

-- seasontracking
ALTER TABLE `seasontracking` DROP FOREIGN KEY `fk_seasontracking_farmid`,  DROP COLUMN `farmid`;

-- seasonlabour
ALTER TABLE `subscription` DROP FOREIGN KEY `fk_subscription_farmerid`, DROP COLUMN `farmerid`;

-- seasonlabour
ALTER TABLE `farmcrop` DROP FOREIGN KEY `fk_farmcrop_farmid`, DROP FOREIGN KEY `fk_farmcrop_farmerid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

-- address
ALTER TABLE `address` DROP FOREIGN KEY `fk_address_farmid`, DROP FOREIGN KEY `fk_address_farmerid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;
DELETE from `address` where userid is null AND farmgroupid is null AND organisationid is null;
ALTER TABLE `address` DROP COLUMN `organisationid`;

-- payment
ALTER TABLE `payment` DROP FOREIGN KEY `fk_payment_farmerid`,  DROP COLUMN `farmerid`;

-- season
ALTER TABLE `season` DROP FOREIGN KEY `fk_season_farmerid`, DROP FOREIGN KEY `fk_season_farmid`,  DROP COLUMN `farmerid`, DROP COLUMN `farmid`;

ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_addressid`, DROP COLUMN addressid;
-- ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_farmerid;
-- ALTER TABLE `useraccount` DROP COLUMN farmerid;

-- Drop tables
SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `userphone` DROP FOREIGN KEY fk_userphone_userid;
DROP TABLE userphone;
-- ALTER TABLE `useraccount` DROP COLUMN farmerid;
ALTER TABLE `track` DROP FOREIGN KEY fk_farmtrack_farm1, DROP FOREIGN KEY fk_track_season1;
DROP TABLE IF EXISTS track;
DROP TABLE IF EXISTS tellfriend;
DROP TABLE IF EXISTS farmland;
DROP TABLE IF EXISTS gpsmeta;
DROP TABLE IF EXISTS farmingtype;
DROP TABLE IF EXISTS organisationdistrict, organisation;
DROP TABLE IF EXISTS offer;
DROP TABLE IF EXISTS expensedetail;
DROP TABLE IF EXISTS expense;

DROP TABLE IF EXISTS commoditypricedetails;
DROP TABLE IF EXISTS commoditypricesubmission;
DROP TABLE IF EXISTS pricesourcecategory;
DROP TABLE IF EXISTS pricecategory;
DROP TABLE IF EXISTS commoditypricecategory;
DROP TABLE IF EXISTS pricesource;

DROP TABLE IF EXISTS farm; 
DROP TABLE IF EXISTS farmer; 
DROP TABLE IF EXISTS address;

SET FOREIGN_KEY_CHECKS = 1;
ALTER TABLE useraccount AUTO_INCREMENT = 3350;

-- DELETE FROM farmcrop where userid is null;
UPDATE appconfig set optionvalue = '8000000' where optionname = 'maximumfilesize';