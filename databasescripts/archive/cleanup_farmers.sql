 
 -- mysql update production
 ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_createdby`;
 ALTER TABLE `useraccount` DROP FOREIGN KEY `fk_useraccount_lastupdatedby`;
 ALTER TABLE `farmgroup` DROP FOREIGN KEY `fk_farmgroup_createdby`;
 ALTER TABLE `farmgroup` DROP FOREIGN KEY `fk_farmgroup_lastupdatedby`;
 
 UPDATE useraccount set createdby = 2239 where createdby = 1891;
 UPDATE useraccount set createdby = 2237 where createdby = 183;
 UPDATE useraccount set farmgroupid = 47 where createdby = 5459 AND farmgroupid is null;
 
 -- rita users
 UPDATE farmgroup set createdby = 1, lastupdatedby = 1 where id in(2939,1790,2801);
 DELETE FROM useraccount where createdby = 2939;
 DELETE FROM useraccount where id = 2939;
 DELETE FROM useraccount where createdby = 1790;
 DELETE FROM useraccount where id = 1790;
 DELETE FROM useraccount where createdby = 2801;
 DELETE FROM useraccount where id = 2801;
 
 UPDATE useraccount set farmgroupid = 111 where createdby = 3625 and farmgroupid is null;
 UPDATE useraccount set farmgroupid = 111 where createdby = 3626 and farmgroupid is null;
 UPDATE useraccount set farmgroupid = 133 where createdby = 4553 and farmgroupid is null;
 UPDATE useraccount set farmgroupid = 47 where createdby = 5464 and farmgroupid is null;
 UPDATE useraccount set farmgroupid = 48 where createdby = 176 and farmgroupid is null;
 
 UPDATE useraccount set createdby = 1 where `createdby` IN ('2937', '2936');
 DELETE FROM useraccount where id in(890,1827,2568,3027,2945,2949);

 UPDATE `useraccount` set regno = concat('UGF/', CONCAT_WS('',SUBSTR(year(datecreated),-2,2),LPAD(MONTH(datecreated),2,'0')), '/',LPAD(farmerid,4,'0')) where `type` = '2' AND `farmgroupid` IS NULL AND `country` LIKE '%UG%' AND `selfregistered` = '1' AND `farmerid` IS NOT NULL AND (regno <> concat('UGF/', CONCAT_WS('',SUBSTR(year(datecreated),-2,2),LPAD(MONTH(datecreated),2,'0')), '/',LPAD(farmerid,4,'0')) OR regno is null OR regno = '');
 
 UPDATE `useraccount` set regno = concat('UGF/', CONCAT_WS('',SUBSTR(year(datecreated),-2,2),LPAD(MONTH(datecreated),2,'0')), '/',LPAD(id,4,'0')) where `type` = '2' AND `farmgroupid` IS NULL AND `country` LIKE '%UG%' AND `farmerid` IS NULL AND (regno <> concat('UGF/', CONCAT_WS('',SUBSTR(year(datecreated),-2,2),LPAD(MONTH(datecreated),2,'0')), '/',LPAD(id,4,'0')) OR regno is null OR regno = '');
 
  UPDATE `useraccount` set refno = LPAD(id,4,'0') where `type` = '2' AND `country` LIKE '%UG%' AND `farmerid` IS NULL AND (refno is null OR refno = '');  
  
  UPDATE `useraccount` set regno ='', refno = LPAD(id,4,'0') where `type` <> '2' AND `country` LIKE '%UG%';
  
  UPDATE `useraccount` set regno = concat('UGF/', LPAD(farmgroupid,4,'0'), '/',LPAD(id,4,'0')) where `type` = '2' AND `farmgroupid` IS NOT NULL AND `country` LIKE '%UG%' AND farmerid is null AND (regno <> concat('UGF/', LPAD(farmgroupid,4,'0'), '/',LPAD(id,4,'0')) OR regno is null OR regno = '');
  
  -- duplicate users marked for deletion
  DELETE FROM useraccount where id in(42,95,99,101,148,179,578,593,104,604,660,5472,5513,6095,5958,401,1019,996,1001,1011,1040,1095,945,938);
  -- delete duplicate crops in farm crop
  
  UPDATE `farmgroup` set regno = concat('KD', LPAD(id,4,'0')) where `country` LIKE '%KE%';

  UPDATE `farmgroup` set regno = concat('UD', LPAD(id,4,'0')) where `country` LIKE '%UG%';