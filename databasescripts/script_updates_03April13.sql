/* Alter table in target */
ALTER TABLE `season` 
	ADD COLUMN `cropid` int(11) unsigned   NULL after `lastupdatedby`, 
	ADD KEY `fk_season_cropid`(`cropid`), COMMENT='';

/* Drop in Second database */
DROP TABLE `seasoncrop`; 

/* Alter ForeignKey(s)in target */

ALTER TABLE `season`
ADD CONSTRAINT `fk_season_cropid` 
FOREIGN KEY (`cropid`) REFERENCES `commodity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;