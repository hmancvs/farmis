	
DELETE from `lookuptype` where id >= 11;
ALTER table lookuptypevalue AUTO_INCREMENT = 1;

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(11, 'LAND_MEASURE_UNITS',	'The units for land measure',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(11,	'1',	'Acres',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(11,	'2',	'Hectares',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(11,	'3',	'Sq.Feet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(11,	'4',	'Sq.Meters',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(11,	'5',	'Sq.Yards',	1,	'2012-03-01 12:00:00',	NULL,	NULL);


INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(12, 'LAND_ACQUIRE_METHODS',	'The methods used to acquire farmer land',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(12,	'1',	'Personal',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(12,	'2',	'Hired',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(12,	'3',	'Leased',	1,	'2012-03-01 12:00:00',	NULL,	NULL);


INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(13, 'ACTION_STATUS',	'The progress status values',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(13,	'1',	'Not Started',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(13,	'2',	'In Progress',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(13,	'3',	'Completed',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(14, 'INPUT_TYPES',	'The categories of Season Inputs',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(14,	'1',	'Seeds',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'2',	'Machinery',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'3',	'Insectcide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'4',	'Fungicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'5',	'Herbicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'6',	'Fertiliser',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(14,	'7',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(15, 'EXPENSE_TYPES',	'The categories of Season Expenses',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(15,	'1',	'Transport',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'2',	'Labour',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'3',	'Rent',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'4',	'Salaries',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'5',	'Allowances',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'6',	'Consultancy',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'7',	'Training',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'8',	'Brokrage',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'9',	'Marketing',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'10',	'Taxes',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'11',	'Machinery',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(15,	'12',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(16, 'TILLAGE_TYPES',	'The types of Tillage',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(16,	'1',	'Chem Fallow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'2',	'Conservation Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'4',	'Minimum Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'5',	'Mulch Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'6',	'No Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'7',	'Ridge Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'8',	'Roll Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'9',	'Strip Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'10',	'Zone Till',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(16,	'11',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(17, 'PRIMARY_TILLAGE_METHODS',	'The primary methods of Tillage',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(17,	'1',	'Wooden plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'2',	'Indigenous plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'4',	'Soil Turning Ploughs',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'5',	'Mouldboard Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'6',	'One way Disc',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'7',	'Offset disc',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'8',	'Tine Implement',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'9',	'Disc Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'10',	'One-way Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'11',	'Subsoil Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'12',	'Chisel Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'13',	'Ridge Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'14',	'Rotary Plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'15',	'Basin Lister',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(17,	'16',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(18, 'SECONDARY_TILLAGE_METHODS',	'The secondary methods of Tillage',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(18,	'1',	'Tractor Drawn Cultivator',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'2',	'Sweep Cultivator',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'3',	'Harrows',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'4',	'Disc Harrow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'5',	'Blade Harrow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'6',	'Indigenous Blade Harrowsw',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'7',	'Plank and Roller',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'8',	'Country plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'9',	'Ridge plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'10',	'Bund former',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'11',	'Peg tooth harrow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'12',	'Disc cultivator',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'13',	'Tined cultivator',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'14',	'Rotovator',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(18,	'15',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(19, 'DEPTH_UNITS',	'The units of measure for depth',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(19,	'1',	'Feet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(19,	'2',	'Inches',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(19,	'3',	'Millimeters',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(19,	'4',	'Centimeters',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(19,	'5',	'Yards',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(20, 'SEEDING_UNITS',	'The units of measure for seeding',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(20,	'1',	'Seeds/Sq.Feet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(20,	'2',	'Seeds/Sq.Meter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(20,	'3',	'Seeds/Sq.Yard',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(20,	'4',	'Seeds/Acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(21, 'PLANTING_UNITS',	'The units for the different planting methods',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(21,	'1',	'Seeds',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(21,	'2',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(22, 'PLANTING_METHODS',	'The planting methods available',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(22,	'1',	'Broadcasting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'2',	'Seedbedding',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'3',	'Pre-sowing',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'4',	'Open-fielding',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'5',	'Dibbling',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'6',	'Transplanting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(22,	'7',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(23, 'TREATMENT_METHODS',	'The treatment methods',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(23,	'1',	'Broadcasting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'2',	'Seedbedding',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'3',	'1/128th Acre Method',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'4',	'5940 Method',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'5',	'Overall Broadcast Spray',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'6',	'Foliar',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'7',	'Stump Treatment',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'8',	'Basal Bark',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'9',	'Spot Sprays',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'10',	'Wiping Treatments',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'11',	'1 Inch away',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'12',	'2 Inch away',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'13',	'Aerial',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'14',	'Air Blast',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'15',	'Backpack Spray',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'16',	'Band',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'17',	'Banding',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'18',	'Broadcast',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'19',	'Chemigation',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'20',	'Co-Application',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'21',	'Electro-static',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'22',	'Fertigation',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'23',	'Ground',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'24',	'Hooded Sprayer',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'25',	'Impregnate',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'26',	'In Furrow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'27',	'Injected',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'28',	'Mis-Application',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'29',	'Planter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'30',	'Rope Wick',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'31',	'SideDress',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'32',	'Surface',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'33',	'T Band',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(23,	'34',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(24, 'TREATMENT_MEASURE_UNITS',	'The units of measure for treatment',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(24,	'1',	'Ltrs/SqFeet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'2',	'MLtrs/SqFeet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'3',	'cc/SqFeet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'4',	'Ltrs/SqMeter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'5',	'MLtrs/SqMeter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'6',	'cc/SqMeter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'7',	'Kgs/SqFeet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'8',	'grams/SqFeet',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'9',	'Kgs/SqMeter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(24,	'10',	'grams/SqMeter',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(25, 'TREATMENT_VOLUME_UNITS',	'The volume units  for season treatment',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(25,	'1',	'Ltrs',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(25,	'2',	'MLtrs',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(25,	'3',	'cc',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(25,	'4',	'Gallons',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(25,	'5',	'Kgs',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(25,	'6',	'grams',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(26, 'SEASON_TIMING_VALUES',	'The season timing points',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(26,	'1',	'Pre Planting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'2',	'Planting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'3',	'Dormancy',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'4',	'Pre Harvest',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'5',	'Post Harvest',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'6',	'Mid Season',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'7',	'Burndown',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'8',	'PreEmerge',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'9',	'PostEmerge',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'10',	'PreFlood',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'11',	'Layby',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(26,	'12',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);


INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(27, 'SEASON_TREATMENT_TYPES',	'The season treatment types',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(27,	'1',	'Algicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'2',	'AntiMicrobial',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'3',	'Attractant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'4',	'Biopesticide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'5',	'Biocide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'6',	'Disinfectant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'7',	'Fungicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'8',	'Fumigant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'9',	'Herbicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'10',	'Insecticide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'12',	'Miticides',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'13',	'Molluscicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'14',	'Nematicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'15',	'Ovicide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'16',	'Pheromone',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'17',	'Repellant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'18',	'Rodenticide',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'19',	'Defoliant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'20',	'Desiccant',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(27,	'21',	'Growth Regulator',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(28, 'SEASON_TREATMENT_FORMS',	'The season treatment forms',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(28,	'1',	'Liquid',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(28,	'2',	'Solid',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(29, 'SEASON_HARVEST_UNITS',	'The season treatment forms',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(29,	'1',	'kg',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'2',	'grammes',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'3',	'tonnes',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'4',	'bag',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'5',	'pieces',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'6',	'wheelbarrow',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'7',	'crates',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'8',	'bunches',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'9',	'handfuls',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'10',	'debe/jerican',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'11',	'bundle heaps',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'12',	'basins',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'13',	'baskets',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'14',	'cups',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(29,	'15',	'boxes',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(30, 'YIELD_UNITS',	'The units for yield',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(30,	'1',	'kgs/acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'2',	'kgs/hectare',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'3',	'tonnes/acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'4',	'tonnes/hectare',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'5',	'bags/acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'6',	'bags/hectare',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'7',	'bunches/acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'8',	'bunches/hectare',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'9',	'pieces/acre',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(30,	'10',	'pieces/hectare',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(31, 'HARVEST_METHODS',	'The season harvesting methods',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(31,	'1',	'Manual harvesting',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(31,	'2',	'Machine threshing',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(31,	'3',	'Machine reaping',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(31,	'4',	'Combined harvesting',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(32, 'SALES_DESTINATIONS',	'The party to whom produce is sold to',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(32,	'1',	'Broker',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'2',	'Transporter',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'3',	'Wholesaler',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'4',	'Retailer',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'5',	'Family',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'6',	'Institution',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'7',	'Farm Group',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(32,	'8',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(33, 'INVENTORY_TYPES',	'The types of inventory',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(33,	'1',	'Assest Inventory',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(33,	'2',	'Production Inventory',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(33,	'3',	'Output Inventory',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(34, 'SERVICE_TYPES',	'The methods of inventory servicing',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(34,	'1',	'Repair',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(34,	'2',	'Standard',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(34,	'3',	'Warranty',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(35, 'FINANCIAL_INSTITUTIONS',	'The financial institutions providing farmer support',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(35,	'1',	'Equity Bank',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'2',	'Pride Microfinance',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'3',	'Centenary Bank',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'4',	'Opportunity Uganda',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'5',	'Post Bank',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'6',	'Finca Uganda',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'7',	'Standard Chartered Bank',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'8',	'Stanbic Bank',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'9',	'Bank of Africa',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(35,	'10',	'Housing Finance',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(36, 'ALL_CLIENTS',	'The clients providing support to farmers',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(36,	'1',	'Mukwano',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(36,	'2',	'Harvest Plus',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(36,	'3',	'Vedco',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(37, 'CONTACTUS_CATEGORIES',	'The contactus form categories',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(37,	'1',	'Feedback',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'2',	'Ask a Question',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'3',	'Submit a Bug',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'4',	'Sign up Problems',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'5',	'Account compromised',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'6',	'Failed to Login',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'7',	'Suggestion',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'8',	'Need Help',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(37,	'9',	'Other',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(38, 'SALES_PRICING_TYPES',	'The forms of sale at end of season',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(38,	'1',	'Farm Gate Price',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(38,	'2',	'Assembly Market Price',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(38,	'3',	'Store Price',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(38,	'4',	'Wholesale Price',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(38,	'5',	'Retail Price',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(39, 'FARMING_TYPES',	'The types of farming available',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(39,	'1',	'Subsistance Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'2',	'Commercial Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'3',	'Ranching',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'4',	'Dry and Irrigated Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'5',	'Mixed Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'6',	'Single Crop Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'7',	'Multi-crop Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'8',	'Diversified Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'9',	'Specialised Farming',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(39,	'10',	'Shifting Cultivation',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(40, 'SUPPORT_TYPES',	'The types of farming support received by farmers in groups',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(40,	'1',	'Farming Inputs',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'2',	'Loans',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'3',	'Training',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'4',	'Market Research',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'5',	'Advertising',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'6',	'Market Information',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'7',	'Advisory Services',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'8',	'Brokerage',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'9',	'Farming Equipment',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(40,	'10',	'Saving Scheme',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(41, 'ACTIVITY_FORMS',	'Other forms of activities other than farming',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(41,	'1',	'Poultry',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(41,	'2',	'Fishing',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(41,	'3',	'Trading',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(41,	'4',	'Livestock',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(41,	'5',	'Piggery',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(42, 'FARMING_TOOLS',	'The tools used for farming',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(42,	'1',	'Hoe',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'2',	'Spade',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'3',	'Axe',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'4',	'Panga',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'5',	'Rake',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'6',	'Tractor',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'7',	'Watering can',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'8',	'Ox plough',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'9',	'Weighing scale',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'10',	'Slasher',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'11',	'Tarpaulin',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'12',	'Gum boots',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(42,	'13',	'Spraying machine',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(43, 'EDUCATION_LEVELS',	'The education level for farmers',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(43,	'1',	'Degree',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'2',	'Diploma',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'8',	'Institution',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'3',	'A-Level',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'4',	'0-Level',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'5',	'P.7',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'7',	'Less than P.7',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(43,	'6',	'None',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(44, 'MARITAL_STATUS_VALUES',	'Farmer marital status values',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(44,	'1',	'Married',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(44,	'2',	'Single',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(44,	'3',	'Divorced',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(44,	'4',	'Widowed',	1,	'2012-03-01 12:00:00',	NULL,	NULL);

INSERT INTO `lookuptype` (`id`, `name`, `description`, `datecreated`, `createdby`, `lastupdatedate`, `lastupdatedby`) VALUES
(45, 'FARM_GROUP_TYPES',	'The farm group types',	'2012-03-01 12:00:00',	1,	NULL,	NULL);
INSERT INTO `lookuptypevalue` (`lookuptypeid`, `lookuptypevalue`, `lookupvaluedescription`, `createdby`, `datecreated`, `lastupdatedate`, `lastupdatedby`) VALUES
(45,	'1',	'DFA',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(45,	'3',	'Cooperative Society',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(45,	'2',	'NGO',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(45,	'4',	'SACCO',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(45,	'5',	'Organization',	1,	'2012-03-01 12:00:00',	NULL,	NULL),
(45,	'6',	'Farm Group',	1,	'2012-03-01 12:00:00',	NULL,	NULL);


UPDATE farmpreseasondetail set fieldsizeunit = 1 where fieldsizeunit = 4;
ALTER TABLE `farm` CHANGE `landactivesize` `landactivesize` decimal(10,2)   NULL after `landsize`, COMMENT='';
ALTER TABLE `farmpreseasondetail` 
	CHANGE `totalplanted` `totalplanted` decimal(2,0) unsigned   NULL after `inputsource`, 
	CHANGE `yield` `yield` decimal(10,2) unsigned   NULL after `totalplantedunit`, 
	CHANGE `totalharvest` `totalharvest` decimal(10,2) unsigned   NULL after `yieldunit`, 
	CHANGE `quantitysold` `quantitysold` decimal(10,2) unsigned   NULL after `totalharvestunit`, COMMENT=''; 