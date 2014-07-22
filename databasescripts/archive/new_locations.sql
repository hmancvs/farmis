DELETE from `location` where id = 43800;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43800, 'Igembe South Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where countyid = 43800;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43801, 'Akachiu', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43802, 'Antubeiga', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43803, 'Antubochiu', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43804, 'Athi', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43805, 'Athiru Gaiti', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43806, 'Giika', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43807, 'Kabuline', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43808, 'Kangeta', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43809, 'Kantihiari', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43810, 'Kiegoi', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43811, 'Kiengu', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43812, 'Kiguru', '', 4, 'KE', 43493, 43737, 43800, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);


DELETE from `location` where id = 43830;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43830, 'Igembe Central Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
-- no wards available for igembe central


DELETE from `location` where id = 43840;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43840, 'Igembe North Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43840;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43841, 'Akirangondu', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43842, 'Antubetwe Kiongo', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43843, 'Antuambui', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43844, 'Athirurunjine', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43845, 'Kabachi', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43846, 'Kawiru', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43847, 'Luciati', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43848, 'Naathu', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43849, 'Ntunene', '', 4, 'KE', 43493, 43737, 43840, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);



DELETE from `location` where id = 43850;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43850, 'Tigania West Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43840;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43851, 'Akithi', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43852, 'Kianjai', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43853, 'Kimachia', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43854, 'Kiorimba', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43855, 'Kitheo', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43856, 'Mbeu', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43857, 'Miathene', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43858, 'Mituntu', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43859, 'Nkomo', '', 4, 'KE', 43493, 43737, 43850, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43860;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43860, 'Tigania East Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43860;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43861, 'Ankamia', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43862, 'Antuanduru', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43863, 'Buuri', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43864, 'Karama', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43865, 'Kiguchwa', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43866, 'Micii Mikuru', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43867, 'Mikinduri East', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43868, 'Mikinduri West', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43869, 'Thankatha', '', 4, 'KE', 43493, 43737, 43860, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
	

DELETE from `location` where id = 43870;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43870, 'North Imenti Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43870;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43871, 'Cathedral', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43872, 'Central', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43873, 'Commercial', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43874, 'Hospital', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43875, 'Kaaga', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43876, 'Milimani', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43877, 'Mwendantu', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43878, 'Stadium', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43879, 'Chugu', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43880, 'Giaki', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43881, 'Kiirua', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43882, 'Kirimara', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43883, 'Kisima', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43884, 'Ntakira', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43885, 'Ontulili', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43886, 'Ruiri', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43887, 'Thuura', '', 4, 'KE', 43493, 43737, 43870, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43888;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43888, 'Buuri Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43888;


DELETE from `location` where id = 43890;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43890, 'Central Imenti Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43890;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43891, 'Gatimbi', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43892, 'Kariene', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43893, 'Katheri', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43894, 'Kiagu', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43895, 'Kibaranyaki', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43896, 'Kibirichia', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43897, 'Kithirune', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43898, 'Kithirune', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43899, 'Mwangathia', '', 4, 'KE', 43493, 43737, 43890, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
	

DELETE from `location` where id = 43900;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43900, 'South Imenti Constituency', '', 3, 'KE', 43493, 43737, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43900;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43901, 'Abogeta', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43902, 'Igoji', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43903, 'Igoki', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43904, 'Kanyakine', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43905, 'Mikumbune', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43906, 'Mitiine', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43907, 'Mitunguu', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43908, 'Mkuene', '', 4, 'KE', 43493, 43737, 43900, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
	
-- 

DELETE from `location` where id = 43910;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43910, 'Mount Elgon Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where countyid = 43910;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43911, 'Chemoge', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43912, 'Chepkube', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43913, 'Cheptais', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43914, 'Chepyuk', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43915, 'Chesikak', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43916, 'Chongeywo', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43917, 'Elgon', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43918, 'Emmia', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43919, 'Kapkateny', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43920, 'Kaptama', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43921, 'Namorio', '', 4, 'KE', 43497, 43714, 43910, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);


DELETE from `location` where id = 43925;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43925, 'Sirisia Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where countyid = 43925;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43926, 'Chebukutumi', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43927, 'Chongoyi', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43928, 'Kulisiru', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43929, 'Ndakalu', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43930, 'Sitabicha / Mwalie East', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43931, 'Tamlega / Mwalie West', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43932, 'Chwele', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43933, 'Luuya / Sirare', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43934, 'Lwandanyi / Namubila', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43935, 'Mukuyuni', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43936, 'Namwela', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43937, 'North Bukusu', '', 4, 'KE', 43497, 43714, 43925, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43940;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43940, 'Kabucchai Constituency', '', 3, 'KE', 43497, 43940, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43941;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43941, 'Bumula Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where countyid = 43941;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43942, 'Mukwa', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43943, 'Siboti', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43944, 'Bumula', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43945, 'Kimaeti', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43946, 'Musikoma', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43947, 'Namasanda', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43948, 'Sio', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43949, 'Siritanyi', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43950, 'South Bukusu', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43951, 'West Bukusu', '', 4, 'KE', 43497, 43714, 43941, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43952;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43952, 'Kanduyi Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43952;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43955, 'Khalaba', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43956, 'Mjini', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43957, 'Sinoko', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43958, 'Stadium', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43959, 'Kibabii', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43960, 'Bukembe', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43961, 'East Sangalo', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43962, 'West Sangalo', '', 4, 'KE', 43497, 43714, 43952, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);


DELETE from `location` where id = 43965;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43965, 'Webuye East', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43970;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43970, 'Kimilili Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where countyid = 43970;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43971, 'Kibingei', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43972, 'Kimilili North', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43973, 'Kimilili South', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43974, 'Maeni', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43975, 'Kamukuywa', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43976, 'Mbakalo', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43977, 'Naitiri', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43978, 'Ndalu', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43979, 'Tongaren', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43990, 'Webuye West', '', 4, 'KE', 43497, 43714, 43970, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 43980;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43980, ' Tongaren Constituency', '', 3, 'KE', 43497, 43714, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

-- 

DELETE from `location` where id = 43981;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43981, ' Gichugu Constituency', '', 3, 'KE', 43491, 43726, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 43981;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(43982, 'Baragwi', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43983, 'Kabare', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43984, 'Karumandi', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43985, 'Kirima', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43986, 'Kutus Central', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43987, 'Ngariama', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(43988, 'Njuki-ini', '', 4, 'KE', 43491, 43726, 43981, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);

DELETE from `location` where id = 44000;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(44000, ' Kerugoya/Kutus Constituency', '', 3, 'KE', 43491, 43726, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 44000;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(44001, 'Kerugoya Central', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44002, 'Kerugoya North', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44003, 'Karumandi', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44004, 'Inoi', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44005, 'Kanyeki-ine', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44006, 'Kerugoya South', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44007, 'Muruana', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44008, 'Mutira', '', 4, 'KE', 43491, 43726, 44000, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);


DELETE from `location` where id = 44010;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(44010, 'Mwea Constituency', '', 3, 'KE', 43491, 43726, NULL, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);
DELETE from `location` where countyid = 44010;
INSERT INTO `location` (`id`,`name`,`description`,`locationtype`,`country`,`regionid`,`districtid`,`countyid`,`subcountyid`,`parishid`,`datecreated`,`createdby`,`lastupdatedate`,`lastupdatedby`,`gpslat`,`gpslng`,`parishname`,`villagename`) VALUES 
(44011, 'Kinyaga', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44012, 'Kutus South', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44013, 'Kangai', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44014, 'Murinduko', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44015, 'Mutithi', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44016, 'Nyangati', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44017, 'Tebere', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL),
(44018, 'Thiba', '', 4, 'KE', 43491, 43726, 44010, NULL, NULL, '2014-01-01 00:00:00', '1',NULL,NULL,NULL,NULL,NULL,NULL);


