CREATE DATABASE IF NOT EXISTS amercars_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE amercars_crm;

SET FOREIGN_KEY_CHECKS = 0;

# Dump of table action_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `action_log`;

CREATE TABLE `action_log` (
                              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                              `table_name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `id_model` int(11) unsigned DEFAULT NULL,
                              `id_user` int(11) unsigned DEFAULT NULL,
                              `ipv4` int(10) unsigned DEFAULT NULL,
                              `action` enum('create','view','update','delete','export','print') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `data` text COLLATE utf8mb4_unicode_ci,
                              `data_new` text COLLATE utf8mb4_unicode_ci,
                              `created_at` timestamp NULL DEFAULT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

# Dump of table auth_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
                             `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                             `type` smallint(6) NOT NULL,
                             `description` text COLLATE utf8_unicode_ci,
                             `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                             `data` blob,
                             `created_at` int(11) DEFAULT NULL,
                             `updated_at` int(11) DEFAULT NULL,
                             PRIMARY KEY (`name`),
                             KEY `rule_name` (`rule_name`),
                             KEY `idx-auth_item-type` (`type`),
                             CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES
    ('/branch/*',2,'Філії',NULL,NULL,1652448230,1652448230),
    ('/brand/*',2,'Бренди',NULL,NULL,1652448242,1652448242),
    ('/category/*',2,'Категорії',NULL,NULL,1652448244,1652448244),
    ('/currency/*',2,'Курс валют',NULL,NULL,1652448247,1652448247),
    ('/customer/*',2,'Кліенти',NULL,NULL,1652448250,1652448250),
    ('/export/*',2,'Експорт прайс-листа',NULL,NULL,1652448253,1652448253),
    ('/income/*',2,'Прихід товару',NULL,NULL,1652448255,1652448255),
    ('/manager/*',2,'Менеджери',NULL,NULL,1652448257,1652448257),
    ('/order-status/*',2,'Статуси замовлень',NULL,NULL,1652448267,1652448267),
    ('/order/*',2,'Замовлення',NULL,NULL,1652448263,1652448263),
    ('/product/*',2,'Товари',NULL,NULL,1652448270,1652448270),
    ('/report/*',2,'Звіти',NULL,NULL,1652448273,1652448273),
    ('/vendor/*',2,'Постачальники',NULL,NULL,1652448276,1652448276),
    ('/warehouse/*',2,'Склади',NULL,NULL,1652448279,1652448279),
    ('admin',1,'Администратор, Полный доступ',NULL,NULL,1652448126,1652459129),
    ('cashier',1,'Касир',NULL,NULL,1652450668,1652459186),
    ('delete',2,'Удаление',NULL,NULL,1655921850,1655921850),
    ('deleter',1,'Удаление',NULL,NULL,1655921899,1655921899),
    ('dropshipper',1,'Дропшипер',NULL,NULL,1652450766,1652459201),
    ('manager',1,'Менеджер',NULL,NULL,1652450635,1652459164),
    ('stockman',1,'Кладовщик',NULL,NULL,1652450717,1652459227);

/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;



# Dump of table auth_assignment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
                                   `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                   `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                   `created_at` int(11) DEFAULT NULL,
                                   PRIMARY KEY (`item_name`,`user_id`),
                                   KEY `idx-auth_assignment-user_id` (`user_id`),
                                   CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`)
VALUES
    ('admin','1',1655922831),
    ('admin','2',1652448290),
    ('deleter','1',1655922831),
    ('manager','607',1665755841),
    ('manager','608',1665755851),
    ('manager','621',1665755857),
    ('manager','622',1665755861);

/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item_child
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
                                   `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                   `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                   PRIMARY KEY (`parent`,`child`),
                                   KEY `child` (`child`),
                                   CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
                                   CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES
    ('admin','/branch/*'),
    ('admin','/brand/*'),
    ('manager','/brand/*'),
    ('admin','/category/*'),
    ('manager','/category/*'),
    ('admin','/currency/*'),
    ('cashier','/currency/*'),
    ('admin','/customer/*'),
    ('manager','/customer/*'),
    ('admin','/export/*'),
    ('cashier','/export/*'),
    ('dropshipper','/export/*'),
    ('admin','/income/*'),
    ('cashier','/income/*'),
    ('manager','/income/*'),
    ('stockman','/income/*'),
    ('admin','/manager/*'),
    ('admin','/order-status/*'),
    ('admin','/order/*'),
    ('cashier','/order/*'),
    ('manager','/order/*'),
    ('admin','/product/*'),
    ('cashier','/product/*'),
    ('dropshipper','/product/*'),
    ('manager','/product/*'),
    ('stockman','/product/*'),
    ('admin','/report/*'),
    ('cashier','/report/*'),
    ('manager','/report/*'),
    ('admin','/vendor/*'),
    ('admin','/warehouse/*'),
    ('stockman','/warehouse/*'),
    ('deleter','delete');

/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_rule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
                             `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                             `data` blob,
                             `created_at` int(11) DEFAULT NULL,
                             `updated_at` int(11) DEFAULT NULL,
                             PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table branch
# ------------------------------------------------------------

DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                          `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;

INSERT INTO `branch` (`id`, `name`, `address`)
VALUES
    (1,'Магазин americancars','Софіївська Борщагівка, вул. Соборна, 146'),
    (2,'Магазин на Софії','с. Софіївська Борщагівка'),
    (3,'Сквира склад','Сквира');

/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table brand
# ------------------------------------------------------------

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `id_image` int(11) DEFAULT NULL,
                         `name` varchar(255) NOT NULL,
                         `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
                         `prod_count` int(11) NOT NULL DEFAULT '0',
                         `status` tinyint(1) NOT NULL DEFAULT '1',
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;

INSERT INTO `brand` (`id`, `id_image`, `name`, `url`, `prod_count`, `status`)
VALUES
    (1,NULL,'CHRYSLER','chrysler',0,1),
    (2,NULL,'ZF lifeguardfluid 8','zf-lifeguardfluid-8',0,1),
    (3,NULL,'DAYCO','dayco',0,1),
    (4,NULL,'Mopar','mopar',0,1),
    (5,NULL,'CLOYES','cloyes',0,1),
    (6,NULL,'permatex','permatex',0,1),
    (7,NULL,'FEBI','febi',0,1),
    (8,NULL,'FORD','ford',0,1),
    (9,NULL,'LEMFORDER','lemforder',0,1),
    (10,NULL,'MOTORCRAFT','motorcraft',0,1),
    (11,NULL,'Ultrapower','ultrapower',0,1),
    (12,NULL,'GM','gm',0,1),
    (13,NULL,'CARQUEST','carquest',0,1),
    (14,NULL,'HONDA','honda',0,1),
    (15,NULL,'MONROE','monroe',0,1),
    (16,NULL,'Proact','proact',0,1),
    (17,NULL,'Kendall','kendall',0,1),
    (18,NULL,'GPD','gpd',0,1),
    (19,NULL,'fiat','fiat',0,1),
    (20,NULL,'Full Force','full-force',0,1),
    (21,NULL,'TYC','tyc',0,1),
    (22,NULL,'Maserati','maserati',0,1),
    (23,NULL,'АВТОМАРКЕТ','avtomarket',0,1),
    (24,NULL,'MOOG','moog',0,1),
    (25,NULL,'ISKRA','iskra',0,1),
    (26,NULL,'Dorman','dorman',0,1),
    (27,NULL,'DURA-GO','dura-go',0,1),
    (28,NULL,'Dura Max','dura-max',0,1),
    (29,NULL,'AFTERMARKET','aftermarket',0,1),
    (30,NULL,'Ferrari','ferrari',0,1),
    (31,NULL,'MERCEDES','mercedes',0,1),
    (32,NULL,'Power Service','power-service',0,1),
    (33,NULL,'Victor Reinz','victor-reinz',0,1),
    (34,NULL,'Standard','standard',0,1),
    (35,NULL,'MOBIL','mobil',0,1),
    (36,NULL,'Wynn\'s','wynns',0,1),
    (37,NULL,'BILSTEIN','bilstein',0,1),
    (38,NULL,'Akron','akron',0,1),
    (39,NULL,'Sachs','sachs',0,1),
    (40,NULL,'STRONG ARM','strong-arm',0,1),
    (41,NULL,'KYB','kyb',0,1),
    (42,NULL,'ACDELCO','acdelco',0,1),
    (43,NULL,'FOX','fox',0,1),
    (44,NULL,'CROWN','crown',0,1),
    (45,NULL,'MAGNUM','magnum',0,1),
    (46,NULL,'RANCHO','rancho',0,1),
    (47,NULL,'CARLSON','carlson',0,1),
    (48,NULL,'Kroon OIL','kroon-oil',0,1),
    (49,NULL,'Shell','shell',0,1),
    (50,NULL,'Peak Charge Noat','peak-charge-noat',0,1),
    (51,NULL,'HEPU','hepu',0,1),
    (52,NULL,'BOSS','boss',0,1),
    (53,NULL,'ABE','abe',0,1),
    (54,NULL,'VARIOUS MFR','various-mfr',0,1),
    (55,NULL,'ADVANTECH','advantech',0,1),
    (56,NULL,'Master','master',0,1),
    (57,NULL,'HERKO','herko',0,1),
    (58,NULL,'Nissan','nissan',0,1),
    (59,NULL,'MITSUBISHI','mitsubishi',0,1),
    (60,NULL,'FEL-PRO','fel-pro',0,1),
    (61,NULL,'PHILLIPS 66','phillips-66',0,1),
    (62,NULL,'CARDONE','cardone',0,1),
    (63,NULL,'CHAMPION','champion',0,1),
    (64,NULL,'Tesla','tesla',0,1),
    (65,NULL,'NAPA','napa',0,1),
    (66,NULL,'WORLDPARTS','worldparts',0,1),
    (67,NULL,'SWAG','swag',0,1),
    (68,NULL,'MAZDA','mazda',0,1),
    (69,NULL,'HAYDEN','hayden',0,1),
    (70,NULL,'CLEVITE','clevite',0,1),
    (71,NULL,'ENGINETECH','enginetech',0,1),
    (72,NULL,'SEALED POWER','sealed-power',0,1),
    (73,NULL,'KING','king',0,1),
    (74,NULL,'DNJ','dnj',0,1),
    (75,NULL,'Rebuilder Choice','rebuilder-choice',0,1),
    (76,NULL,'ENGITECH','engitech',0,1),
    (77,NULL,'UA','ua',0,1),
    (78,NULL,'GATES','gates',0,1),
    (79,NULL,'BOSCH','bosch',0,1),
    (80,NULL,'PRONTO','pronto',0,1),
    (81,NULL,'HASTINGS','hastings',0,1),
    (82,NULL,'WIX','wix',0,1),
    (83,NULL,'BLUE PRINT','blue-print',0,1),
    (84,NULL,'BECK/ARNLEY','beckarnley',0,1),
    (85,NULL,'poliyretan','poliyretan',0,1),
    (86,NULL,'MAS','mas',0,1),
    (87,NULL,'PARTS MASTER','parts-master',0,1),
    (88,NULL,'AUTOEXTRA','autoextra',0,1),
    (89,NULL,'Quick Steer','quick-steer',0,1),
    (90,NULL,'MEVOTECH','mevotech',0,1),
    (91,NULL,'WELLS','wells',0,1),
    (92,NULL,'Gorilla','gorilla',0,1),
    (93,NULL,'OAW','oaw',0,1),
    (94,NULL,'Liqui Moly','liqui-moly',0,1),
    (95,NULL,'Rhino pac','rhino-pac',0,1),
    (96,NULL,'MOTIVE','motive',0,1),
    (97,NULL,'FORD RACING','ford-racing',0,1),
    (98,NULL,'CENTRIC PARTS','centric-parts',0,1),
    (99,NULL,'LUK','luk',0,1),
    (100,NULL,'WALLINE','walline',0,1),
    (101,NULL,'ERA','era',0,1),
    (102,NULL,'AIRTEX','airtex',0,1),
    (103,NULL,'TRW','trw',0,1),
    (104,NULL,'DENSO','denso',0,1),
    (105,NULL,'aipelectronics','aipelectronics',0,1),
    (106,NULL,'VM','vm',0,1),
    (107,NULL,'Intermotor','intermotor',0,1),
    (108,NULL,'STANT','stant',0,1),
    (109,NULL,'BENDIX','bendix',0,1),
    (110,NULL,'FERODO','ferodo',0,1),
    (111,NULL,'BRAKEPERFOMANCE','brakeperfomance',0,1),
    (112,NULL,'WAGNER','wagner',0,1),
    (113,NULL,'DURAGO','durago',0,1),
    (114,NULL,'POWER STOP','power-stop',0,1),
    (115,NULL,'NTY','nty',0,1),
    (116,NULL,'ZF','zf',0,1),
    (117,NULL,'PENNZOIL','pennzoil',0,1),
    (118,NULL,'HYUNDAI','hyundai',0,1),
    (119,NULL,'AUTOMOTIVE PARTS','automotive-parts',0,1),
    (120,NULL,'FPS','fps',0,1),
    (121,NULL,'Alkar','alkar',0,1),
    (122,NULL,'PIONNER','pionner',0,1),
    (123,NULL,'DELPHI','delphi',0,1),
    (124,NULL,'WVE','wve',0,1),
    (125,NULL,'Hitachi','hitachi',0,1),
    (126,NULL,'Strattec','strattec',0,1),
    (127,NULL,'Valeo','valeo',0,1),
    (128,NULL,'Wearever','wearever',0,1),
    (129,NULL,'FVP','fvp',0,1),
    (130,NULL,'LPR','lpr',0,1),
    (131,NULL,'AKEBONO','akebono',0,1),
    (132,NULL,'hi-q','hi-q',0,1),
    (133,NULL,'MEYLE','meyle',0,1),
    (134,NULL,'RAYBESTOS','raybestos',0,1),
    (135,NULL,'ROAD HOUSE','road-house',0,1),
    (136,NULL,'FDP BRAKES','fdp-brakes',0,1),
    (137,NULL,'NewTek','newtek',0,1),
    (138,NULL,'NPR','npr',0,1),
    (139,NULL,'TOYOTA','toyota',0,1),
    (140,NULL,'ELRING','elring',0,1),
    (141,NULL,'DANA HOLDING CORP','dana-holding-corp',0,1),
    (142,NULL,'ROUSH','roush',0,1),
    (143,NULL,'ENERGY SUSPENSION','energy-suspension',0,1),
    (144,NULL,'BTA','bta',0,1),
    (145,NULL,'NEXUS','nexus',0,1),
    (146,NULL,'SPICER','spicer',0,1),
    (147,NULL,'PTC','ptc',0,1),
    (148,NULL,'GMB','gmb',0,1),
    (149,NULL,'POLCAR','polcar',0,1),
    (150,NULL,'PHILIPS','philips',0,1),
    (151,NULL,'CEC','cec',0,1),
    (152,NULL,'QUAKER STATE','quaker-state',0,1),
    (153,NULL,'Warren','warren',0,1),
    (154,NULL,'Sunoco','sunoco',0,1),
    (155,NULL,'TP AUTO','tp-auto',0,1),
    (156,NULL,'Zic','zic',0,1),
    (157,NULL,'Red Line','red-line',0,1),
    (158,NULL,'FOUR SEASONS','four-seasons',0,1),
    (159,NULL,'SRL','srl',0,1),
    (160,NULL,'SKP','skp',0,1),
    (161,NULL,'ERISTIC','eristic',0,1),
    (162,NULL,'LEO0001','leo0001',0,1),
    (163,NULL,'Китай','kitaj',0,1),
    (164,NULL,'Chassis RiTe','chassis-rite',0,1),
    (165,NULL,'CTR','ctr',0,1),
    (166,NULL,'Fortune Line','fortune-line',0,1),
    (167,NULL,'Qualis automotive','qualis-automotive',0,1),
    (168,NULL,'BBB Industries','bbb-industries',0,1),
    (169,NULL,'AAP','aap',0,1),
    (170,NULL,'PRIME CHOICE','prime-choice',0,1),
    (171,NULL,'RODATECH','rodatech',0,1),
    (172,NULL,'SKF','skf',0,1),
    (173,NULL,'Mobis','mobis',0,1),
    (174,NULL,'Caffaro','caffaro',0,1),
    (175,NULL,'ARNOTT','arnott',0,1),
    (176,NULL,'OMIX-ADA','omix-ada',0,1),
    (177,NULL,'TIMKEN','timken',0,1),
    (178,NULL,'NATIONAL','national',0,1),
    (179,NULL,'Хімреактив','himreaktiv',0,1),
    (180,NULL,'Rain-x','rain-x',0,1),
    (181,NULL,'Advantage','advantage',0,1),
    (182,NULL,'ANCHOR','anchor',0,1),
    (183,NULL,'Profit','profit',0,1),
    (184,NULL,'AUTOPART','autopart',0,1),
    (185,NULL,'NRF','nrf',0,1),
    (186,NULL,'Four','four',0,1),
    (187,NULL,'Ruville','ruville',0,1),
    (188,NULL,'Volkswagen','volkswagen',0,1),
    (189,NULL,'STARLINE','starline',0,1),
    (190,NULL,'WYNNS','wynns-2',0,1),
    (191,NULL,'TEXTAR','textar',0,1),
    (192,NULL,'FORCH','forch',0,1),
    (193,NULL,'Wurth','wurth',0,1),
    (194,NULL,'Continental','continental',0,1),
    (195,NULL,'DEPO','depo',0,1),
    (196,NULL,'Motive Gear','motive-gear',0,1),
    (197,NULL,'DEA','dea',0,1),
    (198,NULL,'Blic','blic',0,1),
    (199,NULL,'WESTAR','westar',0,1),
    (200,NULL,'VEMA','vema',0,1),
    (201,NULL,'KOYO','koyo',0,1),
    (202,NULL,'bearing','bearing',0,1),
    (203,NULL,'CONCORD','concord',0,1),
    (204,NULL,'NSK','nsk',0,1),
    (205,NULL,'FKG','fkg',0,1),
    (206,NULL,'OPTIMAL','optimal',0,1),
    (207,NULL,'TRAKMOTIVE','trakmotive',0,1),
    (208,NULL,'APWI','apwi',0,1),
    (209,NULL,'APW','apw',0,1),
    (210,NULL,'SURTRACK','surtrack',0,1),
    (211,NULL,'THERMOTEC','thermotec',0,1),
    (212,NULL,'METELLI','metelli',0,1),
    (213,NULL,'US MOTORWORLD','us-motorworld',0,1),
    (214,NULL,'BUSSMANN','bussmann',0,1),
    (215,NULL,'BorgWarner','borgwarner',0,1),
    (216,NULL,'PROSPARK','prospark',0,1),
    (217,NULL,'PRO-SERIES','pro-series',0,1),
    (218,NULL,'MCCORD','mccord',0,1),
    (219,NULL,'MAHLE','mahle',0,1),
    (220,NULL,'PAYEN','payen',0,1),
    (221,NULL,'WALKER','walker',0,1),
    (222,NULL,'sierra','sierra',0,1),
    (223,NULL,'AJUSA','ajusa',0,1),
    (224,NULL,'General Motors','general-motors',0,1),
    (225,NULL,'HANS PRIES','hans-pries',0,1),
    (226,NULL,'GABRIEL','gabriel',0,1),
    (227,NULL,'EBAY','ebay',0,1),
    (228,NULL,'REYBESTOS','reybestos',0,1),
    (229,NULL,'SPIDAN','spidan',0,1),
    (230,NULL,'PARTS MALL','parts-mall',0,1),
    (231,NULL,'EMPIRAUTO','empirauto',0,1),
    (232,NULL,'GNK','gnk',0,1),
    (233,NULL,'Empi','empi',0,1),
    (234,NULL,'CSF','csf',0,1),
    (235,NULL,'OSC','osc',0,1),
    (236,NULL,'NISSENS','nissens',0,1),
    (237,NULL,'SPECTRA PREMIUM','spectra-premium',0,1),
    (238,NULL,'EDA Cooling','eda-cooling',0,1),
    (239,NULL,'APDI/PRO','apdipro',0,1),
    (240,NULL,'Very Lube','very-lube',0,1),
    (241,NULL,'SCANIA','scania',0,1),
    (242,NULL,'Blue Streak','blue-streak',0,1),
    (243,NULL,'RT Off-Road','rt-off-road',0,1),
    (244,NULL,'DONGIL','dongil',0,1),
    (245,NULL,'Pro-1','pro-1',0,1),
    (246,NULL,'EDELMANN','edelmann',0,1),
    (247,NULL,'AUTOFREN','autofren',0,1),
    (248,NULL,'SIGNEDA','signeda',0,1),
    (249,NULL,'INA','ina',0,1),
    (250,NULL,'RTS','rts',0,1),
    (251,NULL,'555','555',0,1),
    (252,NULL,'Suspensia','suspensia',0,1),
    (253,NULL,'REINHOCH','reinhoch',0,1),
    (254,NULL,'BAW','baw',0,1),
    (255,NULL,'DURALAST','duralast',0,1),
    (256,NULL,'Lemferder','lemferder',0,1),
    (257,NULL,'FEBEST','febest',0,1),
    (258,NULL,'ORIGINAL GRADE','original-grade',0,1),
    (259,NULL,'Sasic','sasic',0,1),
    (260,NULL,'FORTUNA','fortuna',0,1),
    (261,NULL,'Tedgum','tedgum',0,1),
    (262,NULL,'Dana','dana',0,1),
    (263,NULL,'WJB','wjb',0,1),
    (264,NULL,'CORTECO','corteco',0,1),
    (265,NULL,'Canbus','canbus',0,1),
    (266,NULL,'AUTOLITE','autolite',0,1),
    (267,NULL,'NGK','ngk',0,1),
    (268,NULL,'E3','e3',0,1),
    (269,NULL,'Volvo','volvo',0,1),
    (270,NULL,'Ctazpromneft','ctazpromneft',0,1),
    (271,NULL,'BIZOL','bizol',0,1),
    (272,NULL,'XCP','xcp',0,1),
    (273,NULL,'DAEWOO','daewoo',0,1),
    (274,NULL,'AYD','ayd',0,1),
    (275,NULL,'Korea','korea',0,1),
    (276,NULL,'TEKNOROT','teknorot',0,1),
    (277,NULL,'CHASSIS PARTS','chassis-parts',0,1),
    (278,NULL,'master pro','master-pro',0,1),
    (279,NULL,'DETROIT AXLE','detroit-axle',0,1),
    (280,NULL,'Alcardone','alcardone',0,1),
    (281,NULL,'Motocraft','motocraft',0,1),
    (282,NULL,'behr','behr',0,1),
    (283,NULL,'MOTORAD','motorad',0,1),
    (284,NULL,'MAHLE / CLEVITE','mahle-clevite',0,1),
    (285,NULL,'Knecht','knecht',0,1),
    (286,NULL,'JC PREMIUM','jc-premium',0,1),
    (287,NULL,'COMMA','comma',0,1),
    (288,NULL,'AIMKO','aimko',0,1),
    (289,NULL,'Brakes Forever','brakes-forever',0,1),
    (290,NULL,'API','api',0,1),
    (291,NULL,'Aimco','aimco',0,1),
    (292,NULL,'NK','nk',0,1),
    (293,NULL,'Raptor Series','raptor-series',0,1),
    (294,NULL,'YAMATO','yamato',0,1),
    (295,NULL,'MCQUAY-NORRIS','mcquay-norris',0,1),
    (296,NULL,'MOTORPRO','motorpro',0,1),
    (297,NULL,'ATP','atp',0,1),
    (298,NULL,'FRAM','fram',0,1),
    (299,NULL,'MANN','mann',0,1),
    (300,NULL,'Vasco','vasco',0,1),
    (301,NULL,'HENGST','hengst',0,1),
    (302,NULL,'Shafer','shafer',0,1),
    (303,NULL,'Alpha Filter','alpha-filter',0,1),
    (304,NULL,'PRIME GUARD','prime-guard',0,1),
    (305,NULL,'trustar','trustar',0,1),
    (306,NULL,'Auto Parts','auto-parts',0,1),
    (307,NULL,'INTERAUTOPARTS','interautoparts',0,1),
    (308,NULL,'PARTS PLUS','parts-plus',0,1),
    (309,NULL,'DENCKERMANN','denckermann',0,1),
    (310,NULL,'Ashika','ashika',0,1),
    (311,NULL,'MIGHTY','mighty',0,1),
    (312,NULL,'Nipparts','nipparts',0,1),
    (313,NULL,'JPN','jpn',0,1),
    (314,NULL,'PREMIUM','premium',0,1),
    (315,NULL,'Champ','champ',0,1),
    (316,NULL,'KOLBENSCHMIDT','kolbenschmidt',0,1),
    (317,NULL,'ECOGARD','ecogard',0,1),
    (318,NULL,'Speed Mate','speed-mate',0,1),
    (319,NULL,'JCPREMIUM','jcpremium',0,1),
    (320,NULL,'Interparts','interparts',0,1),
    (321,NULL,'JAPANPARTS','japanparts',0,1),
    (322,NULL,'JAKOPARTS','jakoparts',0,1),
    (323,NULL,'PUROLATOR','purolator',0,1),
    (324,NULL,'TOKO','toko',0,1),
    (325,NULL,'VAICO','vaico',0,1),
    (326,NULL,'Хомут','homut',0,1),
    (327,NULL,'Long','long',0,1),
    (328,NULL,'GLYCO','glyco',0,1),
    (329,NULL,'MELLING','melling',0,1),
    (330,NULL,'GSP','gsp',0,1),
    (331,NULL,'PASCAL','pascal',0,1),
    (332,NULL,'Driveshaft','driveshaft',0,1),
    (333,NULL,'ANCO','anco',0,1),
    (334,NULL,'ECOKRAFT','ecokraft',0,1),
    (335,NULL,'FILTRON','filtron',0,1),
    (336,NULL,'TIRERACK','tirerack',0,1),
    (337,NULL,'PRONTO/PREMIUM GUARD','prontopremium-guard',0,1),
    (338,NULL,'VERNET','vernet',0,1),
    (339,NULL,'SUBARU','subaru',0,1),
    (340,NULL,'Phantom','phantom',0,1),
    (341,NULL,'XSV','xsv',0,1),
    (342,NULL,'Vitol','vitol',0,1),
    (343,NULL,'MAGNETI MARELLI','magneti-marelli',0,1),
    (344,NULL,'ABS','abs',0,1),
    (345,NULL,'ILJIN KOREA','iljin-korea',0,1),
    (346,NULL,'SATO TECH','sato-tech',0,1),
    (347,NULL,'ECCPP','eccpp',0,1),
    (348,NULL,'PENTIUS','pentius',0,1),
    (349,NULL,'ROCKHILL','rockhill',0,1),
    (350,NULL,'PROFESSIONALS CHOICE','professionals-choice',0,1),
    (351,NULL,'CARLSON/FVP','carlsonfvp',0,1),
    (352,NULL,'QFIX','qfix',0,1),
    (353,NULL,'OEBRAND','oebrand',0,1),
    (354,NULL,'SIDEM','sidem',0,1),
    (355,NULL,'PROTECHNIC','protechnic',0,1),
    (356,NULL,'ASAKASHI','asakashi',0,1),
    (357,NULL,'KAMOKA','kamoka',0,1),
    (358,NULL,'SATISFIED BRAKES','satisfied-brakes',0,1),
    (359,NULL,'SKV','skv',0,1),
    (360,NULL,'SONAR','sonar',0,1),
    (361,NULL,'TOKO CARS','toko-cars',0,1),
    (362,NULL,'LAMDA','lamda',0,1),
    (363,NULL,'EVO','evo',0,1),
    (364,NULL,'K9','k9',0,1),
    (365,NULL,'MANNOL','mannol',0,1),
    (366,NULL,'SUNSONG','sunsong',0,1),
    (367,NULL,'PEMCO','pemco',0,1),
    (368,NULL,'UFI','ufi',0,1),
    (369,NULL,'BRP','brp',0,1),
    (370,NULL,'CHAMP/LUBER-FINER','champluber-finer',0,1),
    (371,NULL,'MOBILETRON','mobiletron',0,1),
    (372,NULL,'KRAUF','krauf',0,1),
    (373,NULL,'ONE SOURCE','one-source',0,1),
    (374,NULL,'NGK/WVE','ngkwve',0,1),
    (375,NULL,'UAC','uac',0,1),
    (376,NULL,'GAP','gap',0,1),
    (377,NULL,'VARIOUS','various',0,1),
    (378,NULL,'EMPIRE','empire',0,1),
    (379,NULL,'SRT','srt',0,1),
    (380,NULL,'SCT','sct',0,1),
    (381,NULL,'NOWAX','nowax',0,1),
    (382,NULL,'Versachem','versachem',0,1),
    (383,NULL,'BANDO','bando',0,1),
    (384,NULL,'DSPARTS','dsparts',0,1),
    (385,NULL,'FA1','fa1',0,1),
    (386,NULL,'VICTOR REINZ/MAHLE','victor-reinzmahle',0,1),
    (387,NULL,'FAG','fag',0,1),
    (388,NULL,'ALPHA','alpha',0,1),
    (389,NULL,'FALCON','falcon',0,1),
    (390,NULL,'Winfil','winfil',0,1),
    (391,NULL,'TUFF SUPPORT','tuff-support',0,1),
    (392,NULL,'MOOG/PRECISION','moogprecision',0,1),
    (393,NULL,'BREMBO','brembo',0,1),
    (394,NULL,'MIZUMOAUTO','mizumoauto',0,1),
    (395,NULL,'DASH','dash',0,1),
    (396,NULL,'SEINSA','seinsa',0,1),
    (397,NULL,'TENCAR','tencar',0,1),
    (398,NULL,'1','1',0,1),
    (399,NULL,'FEDERAL MOGUL','federal-mogul',0,1),
    (400,NULL,'SNR','snr',0,1),
    (401,NULL,'PRO SERIES','pro-series-2',0,1),
    (402,NULL,'DIRECT PARTS','direct-parts',0,1),
    (403,NULL,'UNITED','united',0,1),
    (404,NULL,'MASUMA','masuma',0,1),
    (405,NULL,'PERFECT CIRCLE','perfect-circle',0,1),
    (406,NULL,'ALLIEDSIGNAL','alliedsignal',0,1),
    (407,NULL,'PROSTOP','prostop',0,1),
    (408,NULL,'QH','qh',0,1),
    (409,NULL,'NOK','nok',0,1),
    (410,NULL,'SILLED POWER','silled-power',0,1),
    (411,NULL,'PCI','pci',0,1),
    (412,NULL,'TJB','tjb',0,1),
    (413,NULL,'LOGO CAPS','logo-caps',0,1),
    (414,NULL,'GLASER','glaser',0,1),
    (415,NULL,'SYLVANIA','sylvania',0,1),
    (416,NULL,'ENGI','engi',0,1),
    (417,NULL,'PUTCO','putco',0,1),
    (418,NULL,'MAX GEAR','max-gear',0,1),
    (419,NULL,'ANCHOR/AUTOEXTRA','anchorautoextra',0,1),
    (420,NULL,'STANT/MOTORAD','stantmotorad',0,1),
    (421,NULL,'TOP LINE','top-line',0,1),
    (422,NULL,'DNK','dnk',0,1),
    (423,NULL,'HELLA','hella',0,1),
    (424,NULL,'KOSHIN','koshin',0,1),
    (425,NULL,'BGA','bga',0,1),
    (426,NULL,'FEDERATED','federated',0,1),
    (427,NULL,'AIR LIFT','air-lift',0,1),
    (428,NULL,'CONTITECH','contitech',0,1),
    (429,NULL,'HELP','help',0,1),
    (430,NULL,'DEXWALL','dexwall',0,1),
    (431,NULL,'NUK','nuk',0,1),
    (432,NULL,'SF','sf',0,1),
    (433,NULL,'KIA','kia',0,1),
    (434,NULL,'COBRA','cobra',0,1),
    (435,NULL,'PURFLUX','purflux',0,1),
    (436,NULL,'SUSPA','suspa',0,1),
    (437,NULL,'KAWASAKI','kawasaki',0,1),
    (438,NULL,'POLARIS','polaris',0,1),
    (439,NULL,'UNIFLUX','uniflux',0,1),
    (440,NULL,'USA','usa',0,1),
    (441,NULL,'CHRYSLER/MERCEDES','chryslermercedes',0,1),
    (442,NULL,'NAGS','nags',0,1),
    (443,NULL,'CASTING','casting',0,1),
    (444,NULL,'WALBRO','walbro',0,1),
    (445,NULL,'DRIVESHAFTPARTS','driveshaftparts',0,1),
    (446,NULL,'PREMIUM GUARD','premium-guard',0,1),
    (447,NULL,'TSN','tsn',0,1),
    (448,NULL,'GKI','gki',0,1),
    (449,NULL,'CARQUEST/MOOG','carquestmoog',0,1),
    (450,NULL,'OSRAM','osram',0,1),
    (451,NULL,'TIMKEN/NATIONAL','timkennational',0,1),
    (452,NULL,'STD','std',0,1),
    (453,NULL,'CFR','cfr',0,1),
    (454,NULL,'IGNITION TECH','ignition-tech',0,1),
    (455,NULL,'IJS','ijs',0,1),
    (456,NULL,'CNS MOTORS','cns-motors',0,1),
    (457,NULL,'MCQUAY NORRIS','mcquay-norris-2',0,1),
    (458,NULL,'RBI','rbi',0,1),
    (459,NULL,'AUTOMOTIVE','automotive',0,1),
    (460,NULL,'OEM','oem',0,1),
    (461,NULL,'DPS','dps',0,1),
    (462,NULL,'GIC','gic',0,1),
    (463,NULL,'WOODVIEW','woodview',0,1),
    (464,NULL,'HELLUX','hellux',0,1),
    (465,NULL,'FRICTION MASTER','friction-master',0,1),
    (466,NULL,'FAE','fae',0,1),
    (467,NULL,'MAXUS','maxus',0,1),
    (468,NULL,'KAGER','kager',0,1),
    (469,NULL,'VOIKSVAGEN','voiksvagen',0,1),
    (470,NULL,'BMW','bmw',0,1),
    (471,NULL,'DTS','dts',0,1),
    (472,NULL,'PURRO','purro',0,1),
    (473,NULL,'KROSNO','krosno',0,1),
    (474,NULL,'AIRAID','airaid',0,1),
    (475,NULL,'ATV','atv',0,1),
    (476,NULL,'RAYBESTOS POWERTRAIN','raybestos-powertrain',0,1),
    (477,NULL,'PORSCHE','porsche',0,1),
    (478,NULL,'TBvechi','tbvechi',0,1),
    (479,NULL,'MERCEDES-BENZ','mercedes-benz',0,1),
    (480,NULL,'FENCO','fenco',0,1),
    (481,NULL,'FIDANZA','fidanza',0,1),
    (482,NULL,'VOLAR','volar',0,1),
    (483,NULL,'VIBRANT','vibrant',0,1),
    (484,NULL,'PROLIANCE','proliance',0,1),
    (485,NULL,'MK FILTER','mk-filter',0,1),
    (486,NULL,'AIMСO','aimso',0,1),
    (487,NULL,'SBI','sbi',0,1),
    (488,NULL,'CASTROL','castrol',0,1),
    (489,NULL,'GUARDIAN / ONE SOURCE','guardian-one-source',0,1),
    (490,NULL,'GOODYEAR','goodyear',0,1),
    (491,NULL,'SELVANIYA','selvaniya',0,1),
    (492,NULL,'SUPER QUIET','super-quiet',0,1),
    (493,NULL,'ALFA','alfa',0,1),
    (494,NULL,'G77','g77',0,1),
    (495,NULL,'AIRTEX/WELLS','airtexwells',0,1),
    (496,NULL,'TOPRAN','topran',0,1),
    (497,NULL,'BORG WARNER','borg-warner',0,1),
    (498,NULL,'SHASIS PRO','shasis-pro',0,1),
    (499,NULL,'CX','cx',0,1),
    (500,NULL,'MTECH','mtech',0,1),
    (501,NULL,'FRECCIA','freccia',0,1),
    (502,NULL,'BALDWIN','baldwin',0,1),
    (503,NULL,'CHICAGO RAWHIDE','chicago-rawhide',0,1),
    (504,NULL,'NEAPCO','neapco',0,1),
    (505,NULL,'SURTRACK/TRAKMOTIVE/FVP','surtracktrakmotivefvp',0,1),
    (506,NULL,'BROCK','brock',0,1),
    (507,NULL,'VICTOR REINZ/CARQUEST','victor-reinzcarquest',0,1),
    (508,NULL,'QUICK BRAKE','quick-brake',0,1),
    (509,NULL,'HASTINGS/BALDWIN','hastingsbaldwin',0,1),
    (510,NULL,'3D Auto','3d-auto',0,1),
    (511,NULL,'APPLUS','applus',0,1),
    (512,NULL,'ACS-motorsport','acs-motorsport',0,1),
    (513,NULL,'METRA','metra',0,1),
    (514,NULL,'JAPAN CARS','japan-cars',0,1),
    (515,NULL,'YXPCars','yxpcars',0,1),
    (516,NULL,'AISIN','aisin',0,1),
    (517,NULL,'PRESTOLITE','prestolite',0,1),
    (518,NULL,'CARPARTS','carparts',0,1),
    (519,NULL,'SURESTOP','surestop',0,1),
    (520,NULL,'TYG','tyg',0,1),
    (521,NULL,'GENERAL ELECTRIC','general-electric',0,1),
    (522,NULL,'TOPTUL','toptul',0,1),
    (523,NULL,'CHASSIS PRO','chassis-pro',0,1),
    (524,NULL,'PIONEER','pioneer',0,1),
    (525,NULL,'SIEMENS','siemens',0,1),
    (526,NULL,'RIDER','rider',0,1),
    (527,NULL,'MICRON','micron',0,1),
    (528,NULL,'SIL','sil',0,1),
    (529,NULL,'EPS','eps',0,1),
    (530,NULL,'CANAM BOMBARDIER','canam-bombardier',0,1),
    (531,NULL,'ROMIX','romix',0,1),
    (532,NULL,'GOETZE','goetze',0,1),
    (533,NULL,'FLENNOR','flennor',0,1),
    (534,NULL,'GRAF','graf',0,1),
    (535,NULL,'ВЕС','ves',0,1),
    (536,NULL,'BIG3GASKETS','big3gaskets',0,1),
    (537,NULL,'FAI','fai',0,1),
    (538,NULL,'ISUMO','isumo',0,1),
    (539,NULL,'CONI-SEAL','coni-seal',0,1),
    (540,NULL,'DRIVE RITE','drive-rite',0,1),
    (541,NULL,'STOP MASTER','stop-master',0,1),
    (542,NULL,'FRENKIT','frenkit',0,1),
    (543,NULL,'AUTOMARKET','automarket',0,1),
    (544,NULL,'TRAKMOTIVE/SURTRACK','trakmotivesurtrack',0,1),
    (545,NULL,'MEAT&DORIA','meatdoria',0,1),
    (546,NULL,'WESTAR/PRONTO','westarpronto',0,1),
    (547,NULL,'MATZGER','matzger',0,1),
    (548,NULL,'Presius','presius',0,1),
    (549,NULL,'Felpro','felpro',0,1),
    (550,NULL,'VictorReinz','victorreinz',0,1),
    (551,NULL,'SMP','smp',0,1),
    (552,NULL,'Rock engine','rock-engine',0,1),
    (553,NULL,'EVE','eve',0,1),
    (554,NULL,'SealedPower','sealedpower',0,1),
    (555,NULL,'Autopatrs','autopatrs',0,1),
    (556,NULL,'DT','dt',0,1),
    (557,NULL,'Proserias','proserias',0,1),
    (558,NULL,'Platinum','platinum',0,1),
    (559,NULL,'Eagle eyes','eagle-eyes',0,1),
    (560,NULL,'motorvent','motorvent',0,1),
    (561,NULL,'DriveAxle','driveaxle',0,1),
    (562,NULL,'SPYDER','spyder',0,1),
    (563,NULL,'KABUKI','kabuki',0,1),
    (564,NULL,'DURA LAST','dura-last',0,1),
    (565,NULL,'TEROSON','teroson',0,1),
    (566,NULL,'EXPERT DOT4','expert-dot4',0,1),
    (567,NULL,'XADO','xado',0,1),
    (568,NULL,'AUTOTECHTEILE','autotechteile',0,1),
    (569,NULL,'PROTECH','protech',0,1),
    (570,NULL,'Mevotach','mevotach',0,1),
    (571,NULL,'Phillips','phillips',0,1),
    (572,NULL,'Duramax','duramax',0,1),
    (573,NULL,'SEALED POWER/FEL-PRO','sealed-powerfel-pro',0,1),
    (574,NULL,'Formula','formula',0,1),
    (575,NULL,'ETF','etf',0,1),
    (576,NULL,'MITELLI','mitelli',0,1),
    (577,NULL,'MAHLE/BEHR','mahlebehr',0,1),
    (578,NULL,'KALE','kale',0,1),
    (579,NULL,'CPW','cpw',0,1),
    (580,NULL,'MVPARTS','mvparts',0,1),
    (581,NULL,'JAPANPARTS/NTY','japanpartsnty',0,1),
    (582,NULL,'BBP','bbp',0,1),
    (583,NULL,'BETTER BRAKE PARTS','better-brake-parts',0,1),
    (584,NULL,'FRENKIN','frenkin',0,1),
    (585,NULL,'Steersmarts','steersmarts',0,1),
    (586,NULL,'VAG','vag',0,1),
    (587,NULL,'JAPANPARTS/ ASHIKA','japanparts-ashika',0,1),
    (588,NULL,'Oemarket','oemarket',0,1),
    (589,NULL,'ERT','ert',0,1),
    (590,NULL,'STANDARD/FEDERAL','standardfederal',0,1),
    (591,NULL,'AKUSAN','akusan',0,1),
    (592,NULL,'Market (OEM)','market-oem',0,1),
    (593,NULL,'SKF/DELFI','skfdelfi',0,1),
    (594,NULL,'GKN/Spidan','gknspidan',0,1),
    (595,NULL,'CIFAM','cifam',0,1),
    (596,NULL,'WAIGLOBAL','waiglobal',0,1),
    (597,NULL,'BREMSEN','bremsen',0,1),
    (598,NULL,'CTEK','ctek',0,1),
    (599,NULL,'US MOTOR WORKS','us-motor-works',0,1),
    (600,NULL,'CY MOTOR','cy-motor',0,1),
    (601,NULL,'SANGSIN','sangsin',0,1),
    (602,NULL,'Aluminium','aluminium',0,1),
    (603,NULL,'ASAM','asam',0,1),
    (604,NULL,'DOLZ','dolz',0,1),
    (605,NULL,'DACO','daco',0,1),
    (606,NULL,'PURO','puro',0,1),
    (607,NULL,'HUNDAI','hundai',0,1),
    (608,NULL,'Pro Fusion','pro-fusion',0,1),
    (609,NULL,'ROADMAX','roadmax',0,1),
    (610,NULL,'FCS','fcs',0,1),
    (611,NULL,'NTY/ GSP','nty-gsp',0,1),
    (612,NULL,'PRT','prt',0,1),
    (613,NULL,'metzger','metzger',0,1),
    (614,NULL,'NTY/SRL','ntysrl',0,1),
    (615,NULL,'FACET','facet',0,1),
    (616,NULL,'AKVILON','akvilon',0,1),
    (617,NULL,'Japko','japko',0,1),
    (618,NULL,'HOLSTEIN','holstein',0,1),
    (619,NULL,'NTN','ntn',0,1),
    (620,NULL,'ADRIAUTO','adriauto',0,1),
    (621,NULL,'ad','ad',0,1),
    (622,NULL,'Turborury','turborury',0,1),
    (623,NULL,'QUALCAST','qualcast',0,1),
    (624,NULL,'TOMS AUTOPARTS','toms-autoparts',0,1),
    (625,NULL,'NTK','ntk',0,1),
    (626,NULL,'AZUMI','azumi',0,1),
    (627,NULL,'DIAMOND POWER','diamond-power',0,1),
    (628,NULL,'NSTEEL38','nsteel38',0,1),
    (629,NULL,'JURID','jurid',0,1),
    (630,NULL,'DANA SPICER','dana-spicer',0,1),
    (631,NULL,'REMSA','remsa',0,1),
    (632,NULL,'PROTEC','protec',0,1),
    (633,NULL,'STD USA','std-usa',0,1),
    (634,NULL,'Frenkin / ERT','frenkin-ert',0,1),
    (635,NULL,'NTN/SNR','ntnsnr',0,1),
    (636,NULL,'EPS/FACET','epsfacet',0,1),
    (637,NULL,'Cofle','cofle',0,1),
    (638,NULL,'FORCE','force',0,1),
    (639,NULL,'JTC','jtc',0,1),
    (640,NULL,'KAUTEK','kautek',0,1),
    (641,NULL,'Wunder','wunder',0,1),
    (642,NULL,'FVP/TRAKMOTIVE/SURTRACK/','fvptrakmotivesurtrack',0,1),
    (643,NULL,'OEQUALITY','oequality',0,1),
    (644,NULL,'DRIVE RITE USA','drive-rite-usa',0,1),
    (645,NULL,'APEX','apex',0,1),
    (646,NULL,'Solgy','solgy',0,1),
    (647,NULL,'JP GROUP','jp-group',0,1),
    (648,NULL,'POLYCRAFT','polycraft',0,1),
    (649,NULL,'ROADHOUSE','roadhouse',0,1),
    (650,NULL,'POLMOSTROW','polmostrow',0,1),
    (651,NULL,'PROTEC WIX FILERS','protec-wix-filers',0,1),
    (652,NULL,'POWER TRAIN COMPONENTS','power-train-components',0,1),
    (653,NULL,'ICER','icer',0,1),
    (654,NULL,'OE RENAULT','oe-renault',0,1),
    (655,NULL,'Asam/ Meha','asam-meha',0,1),
    (656,NULL,'Shee-Mar','shee-mar',0,1),
    (657,NULL,'FAIRCHILD','fairchild',0,1),
    (658,NULL,'RENAULT','renault',0,1),
    (659,NULL,'AGS','ags',0,1),
    (660,NULL,'AIC','aic',0,1),
    (661,NULL,'Total','total',0,1),
    (662,NULL,'AS','as',0,1),
    (663,NULL,'EngineMach','enginemach',0,1),
    (664,NULL,'Zilbermann','zilbermann',0,1),
    (665,NULL,'Frenkit/ ERT','frenkit-ert',0,1),
    (666,NULL,'K&N','kn',0,1),
    (667,NULL,'DONALDSON','donaldson',0,1),
    (668,NULL,'VIKA','vika',0,1),
    (669,NULL,'BERU','beru',0,1),
    (670,NULL,'KAVO PARTS','kavo-parts',0,1),
    (671,NULL,'AMPARTS','amparts',0,1),
    (672,NULL,'AUTLOG','autlog',0,1),
    (673,NULL,'Кама Оил','kama-oil',0,1),
    (674,NULL,'ADVANCEIGNITION','advanceignition',0,1),
    (675,NULL,'DP Group','dp-group',0,1),
    (676,NULL,'MANDO','mando',0,1),
    (677,NULL,'Sigma','sigma',0,1),
    (678,NULL,'GOODREM','goodrem',0,1),
    (679,NULL,'TEXACO','texaco',0,1),
    (680,NULL,'DYNAMIC FRICTION','dynamic-friction',0,1),
    (681,NULL,'CARGO','cargo',0,1),
    (682,NULL,'IMPERGOM','impergom',0,1),
    (683,NULL,'NEW JERSEY AMERICAN','new-jersey-american',0,1),
    (684,NULL,'VOCR','vocr',0,1),
    (685,NULL,'Teknorot / Kautek','teknorot-kautek',0,1),
    (686,NULL,'ILJIN','iljin',0,1),
    (687,NULL,'CANAM','canam',0,1),
    (688,NULL,'GUARDIAN','guardian',0,1),
    (689,NULL,'PERFECTION CLUTCH','perfection-clutch',0,1),
    (690,NULL,'BWD','bwd',0,1),
    (691,NULL,'IFJF','ifjf',0,1),
    (692,NULL,'JAPKO/ JAPANPARTS','japko-japanparts',0,1),
    (693,NULL,'Permatex','permatex-2',0,1),
    (694,NULL,'PETRONAS TUTELA','petronas-tutela',0,1),
    (695,NULL,'WIPERS','wipers',0,1),
    (696,NULL,'MENBERS','menbers',0,1),
    (697,NULL,'KEMPARTS','kemparts',0,1),
    (698,NULL,'KOYORAD','koyorad',0,1),
    (699,NULL,'NIGRIN','nigrin',0,1),
    (700,NULL,'Sonnax','sonnax',0,1),
    (701,NULL,'ROSTRA','rostra',0,1),
    (702,NULL,'Transtec','transtec',0,1),
    (703,NULL,'Bosal','bosal',0,1),
    (704,NULL,'sct germany','sct-germany',0,1),
    (705,NULL,'LARES','lares',0,1),
    (706,NULL,'RAISO','raiso',0,1),
    (707,NULL,'GORST','gorst',0,1),
    (708,NULL,'PROLINE','proline',0,1),
    (709,NULL,'GTB','gtb',0,1),
    (710,NULL,'REDLINE','redline',0,1),
    (711,NULL,'MOTUL','motul',0,1),
    (712,NULL,'FISCHER','fischer',0,1),
    (713,NULL,'PA CARGO','pa-cargo',0,1),
    (714,NULL,'PRO STOP','pro-stop',0,1),
    (715,NULL,'AUTOTECNICA','autotecnica',0,1),
    (716,NULL,'GH Parts','gh-parts',0,1),
    (717,NULL,'SAT','sat',0,1),
    (718,NULL,'GH BRAKE CALIPER','gh-brake-caliper',0,1),
    (719,NULL,'Van Wezel','van-wezel',0,1),
    (720,NULL,'KOITO','koito',0,1),
    (721,NULL,'UNITYPARTS','unityparts',0,1),
    (722,NULL,'JOHNSON ELECTRIC ','johnson-electric',0,1);

/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cashdesk
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cashdesk`;

CREATE TABLE `cashdesk` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `id_user` int(10) unsigned DEFAULT NULL,
                            `id_order` int(10) unsigned DEFAULT NULL,
                            `id_method` int(10) unsigned DEFAULT NULL,
                            `amount` double NOT NULL,
                            `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table cashdesk_method
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cashdesk_method`;

CREATE TABLE `cashdesk_method` (
                                   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                   `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cashdesk_method` WRITE;
/*!40000 ALTER TABLE `cashdesk_method` DISABLE KEYS */;

INSERT INTO `cashdesk_method` (`id`, `name`)
VALUES
    (1,'Готівка'),
    (2,'Картка Приват 0258'),
    (3,'Картка Моно 1236');

/*!40000 ALTER TABLE `cashdesk_method` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `id_parent` int(11) unsigned NOT NULL DEFAULT '0',
                            `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
                            `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
                            `sort` int(11) DEFAULT NULL,
                            `status` tinyint(1) NOT NULL DEFAULT '1',
                            PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `id_parent`, `url`, `name`, `sort`, `status`)
VALUES
    (1,0,'dvigatel','Двигун',4,1),
    (2,0,'podveska','Підвіска передня',14,1),
    (3,0,'rulevoe-upravlenie','Рульове управління',17,1),
    (5,0,'pidviska-zadna','Підвіска задня',13,1),
    (6,0,'filri','Фільтри',24,1),
    (7,0,'amortizatori-opori','Амортизатори / опори',1,1),
    (8,0,'stupici-pidsipniki','Ступиці / підшипники / сальники',21,1),
    (9,0,'remeni-roliki','Ремені / ролики',16,1),
    (10,0,'sistema-oholodzenna','Система охолодження',20,1),
    (11,0,'sistema-zapalvanna','Система запалювання',19,1),
    (12,0,'galmivna-sistema','Гальмівна система',3,1),
    (13,0,'elektrika','Електрика',6,1),
    (14,0,'poduski-dviguna-kpp','Подушки двигуна / кпп',15,1),
    (15,0,'detali-privodu','Деталі приводу',5,1),
    (16,0,'kondicioner-opalenna','Кондиціонер/ опалення',9,1),
    (17,0,'kuzovni-detali','Кузовні деталі',10,1),
    (18,0,'mastila-ta-avtohimia','Мастила та автохімія',11,1),
    (23,0,'gajki-bolty-spilki','Гайки, болти, шпильки',2,1),
    (26,0,'detali-mkppakpp','Трансмісія і деталі',22,1),
    (29,0,'other','Інше',8,1),
    (34,0,'tuning','Тюнінг',23,1),
    (35,0,'sceplenie','Зчеплення',7,1),
    (46,0,'detali-salonu','Деталі салону',25,1),
    (47,0,'fari-fonari-lampocki','Фари/ фонарі/ лампочки',26,1),
    (40,0,'sistema-bezopasnosti-airbag','Система безпеки (Airbag)',18,1),
    (43,0,'toplivnaa-sistema','Паливна система',12,1);

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table currency
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currency`;

CREATE TABLE `currency` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                            `value` float NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;

INSERT INTO `currency` (`id`, `name`, `value`, `created_at`, `updated_at`)
VALUES
    (1,'USD',41.9,'2022-04-22 09:59:50','2024-11-29 13:32:48'),
    (2,'EUR',40,'2022-04-22 10:06:29','2022-10-05 10:50:36'),
    (3,'UAH',1,'2022-04-28 09:41:10','2022-05-13 21:25:37');

/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `id_manager` int(11) unsigned DEFAULT NULL,
                            `email` varchar(255) DEFAULT NULL,
                            `discount` tinyint(1) NOT NULL DEFAULT '0',
                            `type` tinyint(1) NOT NULL DEFAULT '1',
                            `lastname` varchar(255) DEFAULT NULL,
                            `firstname` varchar(255) DEFAULT NULL,
                            `middlename` varchar(255) DEFAULT NULL,
                            `birthdate` date DEFAULT NULL,
                            `tel` varchar(255) DEFAULT NULL,
                            `tel2` varchar(255) DEFAULT NULL,
                            `company` varchar(255) DEFAULT NULL,
                            `address` varchar(255) DEFAULT NULL,
                            `city` varchar(255) DEFAULT NULL,
                            `region` int(11) DEFAULT NULL,
                            `automark` varchar(255) DEFAULT NULL,
                            `automodel` varchar(255) DEFAULT NULL,
                            `autovin` varchar(255) DEFAULT NULL,
                            `carrier` varchar(255) DEFAULT NULL,
                            `carrier_city` varchar(255) DEFAULT NULL,
                            `carrier_city_ref` varchar(255) DEFAULT NULL,
                            `carrier_region` varchar(255) DEFAULT NULL,
                            `carrier_region_ref` varchar(255) DEFAULT NULL,
                            `carrier_branch` varchar(255) DEFAULT NULL,
                            `carrier_branch_ref` varchar(255) DEFAULT NULL,
                            `carrier_tel` varchar(255) DEFAULT NULL,
                            `carrier_fio` varchar(255) DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `id_manager`, `email`, `discount`, `type`, `lastname`, `firstname`, `middlename`, `birthdate`, `tel`, `tel2`, `company`, `address`, `city`, `region`, `automark`, `automodel`, `autovin`, `carrier`, `carrier_city`, `carrier_city_ref`, `carrier_region`, `carrier_region_ref`, `carrier_branch`, `carrier_branch_ref`, `carrier_tel`, `carrier_fio`)
VALUES
    (1,1,'9407674@gmail.com',0,1,'Розробник','Олег',NULL,NULL,'380930000999',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    (2,1,'autogroup2013@gmail.com',0,1,'Лісовий','Євгеній',NULL,NULL,'380938309777',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    (463,NULL,'aa0957007927@gmail.com',0,1,'Тельчаров','Евгений','Александрович',NULL,'380958916590','','Магазин автозапчастей','13','Вишневое',NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table filter_auto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `filter_auto`;

CREATE TABLE `filter_auto` (
                               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `id_product` int(11) NOT NULL,
                               `vendor` varchar(255) DEFAULT NULL,
                               `model` varchar(255) DEFAULT NULL,
                               `year` varchar(255) DEFAULT NULL,
                               `engine` varchar(255) DEFAULT NULL,
                               PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `filter_auto` WRITE;
/*!40000 ALTER TABLE `filter_auto` DISABLE KEYS */;

INSERT INTO `filter_auto` (`id`, `id_product`, `vendor`, `model`, `year`, `engine`)
VALUES
    (1,9881,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (2,9881,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (3,9881,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (4,9881,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (5,9881,'Jeep','Cherokee XJ (1984-2001)','1998;1999;2000;2001','2.5;4.0'),
    (14,302,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (15,343,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (16,557,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (17,557,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (18,557,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (19,557,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (20,557,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (21,557,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (22,557,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (23,557,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (24,558,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (25,558,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (26,560,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (27,560,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (28,560,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (29,560,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (30,561,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (31,561,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (32,561,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (33,561,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (34,6113,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (35,6113,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (36,6113,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (37,6113,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (38,561,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (39,561,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (40,561,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (41,561,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (42,560,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (43,560,'Chrysler','Voyager','2000;2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (44,560,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (45,560,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (46,560,'Chrysler','Town&Country','1996;1997;1998;1999;2000;2001;2002;2003;2004;2005',''),
    (47,611,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (48,611,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (49,611,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (50,611,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (51,611,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (52,611,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (53,611,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (54,611,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (55,603,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (56,603,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (57,603,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (58,603,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.5 CRD;3.3;3.8'),
    (59,611,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (60,611,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (61,611,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (62,611,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (63,632,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (64,632,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (65,632,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (66,632,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (67,633,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (68,633,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (69,633,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (70,633,'Dodge','Caravan','1996;1997;1999;2000','2.4;3.0;3.3;3.8'),
    (71,646,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (72,646,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.0;3.3;3.8'),
    (73,646,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (74,646,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (75,883,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.6'),
    (76,890,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6'),
    (77,1186,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (79,1192,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009','4.0;4.6;5.4'),
    (80,1197,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (81,1198,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (82,1238,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (84,1266,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (85,1280,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (86,1704,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (87,1704,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (88,1769,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (89,1769,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (92,1902,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (93,1902,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (96,1926,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (97,1926,'Chrysler','Town&Country','1996;1997;1998;1999;2000',''),
    (98,1926,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (99,1934,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (100,1961,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (101,1961,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (102,1963,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (106,1973,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (107,10020,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (108,10020,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (109,1978,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (110,1978,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (111,1978,'Dodge','Neon 1995-2000','1996;1997;1998;1999',''),
    (112,2206,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (113,2206,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (114,2208,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (115,2208,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (116,2642,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (117,2724,'Chrysler','Voyager','1988;1989;1990;1991;1992;1993;1994;1995','2.5 TD;2.5 бензин;3.0;3.3'),
    (118,2724,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD;3.0;3.3;3.8'),
    (119,2724,'Dodge','Caravan','1988;1989;1990;1991;1992;1993;1994;1995','2.5 бензин;3.0;3.3'),
    (120,2724,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (121,3129,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (122,3108,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (123,3161,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (131,3362,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (132,3363,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (134,3609,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (135,3609,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (136,3609,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (137,3609,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (142,3609,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (143,3609,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (144,3609,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (145,3609,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (146,3665,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (148,7241,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (149,7241,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (150,7241,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (151,7241,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (152,3679,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (153,3679,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (154,3679,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (155,3679,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (156,3684,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (157,3879,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (158,3879,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (159,3883,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (160,7264,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (161,3911,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (162,3889,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (163,3889,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (164,4004,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (165,4135,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (166,7281,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (167,4153,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (169,4261,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (170,4469,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (175,1405,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (181,2525,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (182,2551,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (185,2617,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (186,2617,'Jeep','Cherokee XJ (1984-2001)','1996;1997;1998;1999;2000;2001',''),
    (187,2617,'Jeep','Grand Cherokee WJ (1998-2004)','1996;1997;1998;1999;2000;2001',''),
    (190,2856,'Chrysler','Voyager','1999;2000','2.5 TD'),
    (191,2912,'Chrysler','Voyager','1996;1997;1998','2.5 TD'),
    (192,3029,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (193,3029,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (194,3029,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (198,3224,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (199,3224,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (200,3224,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (201,3642,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (202,3642,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (203,3642,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (207,8435,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (208,8435,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (209,8435,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (213,4260,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (214,4280,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (215,346,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (216,346,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (217,346,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (218,8214,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (219,8214,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (220,8214,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (221,793,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (222,793,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (223,1299,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (224,1299,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (225,1300,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (226,1300,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (227,1356,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (228,1356,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (229,1356,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (234,1407,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (235,1407,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (236,1937,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (237,1937,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (238,1937,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (239,1962,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (240,1962,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (241,1962,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (242,2251,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (243,2251,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (244,2251,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (245,5562,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (246,5562,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (247,5562,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (248,2277,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (249,2415,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (250,2415,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (259,2788,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (260,2788,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (261,3020,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (262,3020,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (263,3047,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (264,3047,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (265,3111,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (266,3129,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (267,3244,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (268,3244,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (269,3244,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (270,3244,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (271,3244,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (272,3244,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (276,6355,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (277,6355,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (278,6355,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (282,4131,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (283,4131,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (284,4131,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (285,4034,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (286,4034,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (287,4133,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (288,4133,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (289,4148,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (290,4148,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (291,4150,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (292,4150,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (293,4150,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (294,4157,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (295,4157,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (296,4157,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (297,4185,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4'),
    (298,4185,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4'),
    (299,4276,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (300,4276,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (301,4442,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3'),
    (302,4442,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.0;3.3'),
    (303,4442,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3'),
    (304,4442,'Chrysler','Voyager','2001;2002;2003;2004','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (305,4442,'Chrysler','Town&Country','2001;2002;2003;2004','3.3;3.8'),
    (306,4442,'Dodge','Caravan','2001;2002;2003;2004','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (316,459,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0'),
    (321,1711,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (322,10352,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6'),
    (324,1862,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.6'),
    (325,1924,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (326,1924,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (327,1924,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (328,1927,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (329,1927,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (330,1927,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (331,2617,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (333,2884,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0'),
    (334,3003,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6'),
    (335,3004,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6'),
    (336,3318,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (337,3318,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (338,3464,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0'),
    (339,3538,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (340,3538,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (341,3538,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (342,3538,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (343,3538,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (344,3538,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (345,3714,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0'),
    (346,6297,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.6'),
    (347,4206,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (348,4456,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (349,4456,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (350,1212,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (352,1709,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (353,1709,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (354,1709,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (358,3194,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (359,3194,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (360,3194,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (361,3194,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (362,3194,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (363,3194,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (364,3609,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (365,3609,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (366,3609,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (367,3609,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (368,3609,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (369,3609,'Chrysler','Town&Country','2001;2002;2003;2004;2005','3.3;3.8'),
    (370,3647,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (371,3642,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (372,3642,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (373,3642,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (374,3672,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (375,3894,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (376,3894,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (377,3894,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (378,4033,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (379,4159,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T'),
    (380,4204,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0;5.2'),
    (384,2074,'Ford','Focus (2010-2018)','2010;2011;2012;2013;2014;2015;2016;2017;2018','2.0'),
    (385,2074,'Ford','Escape (2013-2018)','2013;2014;2015;2016;2017;2018','1.6T;2.0T;2.5'),
    (386,2074,'Ford','C-MAX (2013-2018)','2013;2014;2015;2016;2017;2018','2.0'),
    (387,449,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (388,449,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (389,449,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (391,3808,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (392,6668,'Chrysler','Voyager','1988;1989;1990;1991;1992;1993;1994;1995','2.5 TD;2.5 бензин;3.0;3.3'),
    (393,6668,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (394,6668,'Dodge','Caravan','1988;1989;1990;1991;1992;1993;1994;1995','2.5 бензин;3.0;3.3'),
    (395,6668,'Dodge','Caravan','1996;1997;1998;1999;2000','2.5 бензин;3.0;3.3'),
    (399,1281,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (400,1281,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (401,1281,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (402,300,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (403,300,'Chrysler','Town&Country','1996;1997;1998;1999;2000',''),
    (404,300,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (405,2565,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (406,2565,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (407,656,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD'),
    (408,656,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.5 CRD'),
    (409,1281,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (410,1281,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (411,1281,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (412,1978,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (413,1978,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (414,1978,'Dodge','Neon 1995-2000','1996;1997;1998;1999',''),
    (415,1978,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (416,2274,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (417,2274,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (418,2274,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (421,6402,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4'),
    (422,6402,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4'),
    (425,305,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (426,305,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (427,305,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (431,345,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (432,345,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (433,345,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (434,1964,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (435,1964,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (436,1964,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (437,3878,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (438,3878,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (439,3878,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (440,611,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (441,611,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (442,611,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (443,611,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (444,611,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (445,611,'Chrysler','Town&Country','2001;2002;2003;2004;2005','3.3;3.8'),
    (449,2276,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (450,1984,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (451,1984,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (452,1984,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (453,4034,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (454,4034,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (455,2802,'Chrysler','Voyager','1996;1997;1998;1999;2000','3.3;3.8'),
    (456,2802,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (457,2802,'Dodge','Caravan','1996;1997;1998;1999;2000','3.3;3.8'),
    (458,2205,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (459,2205,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (460,1768,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (461,1768,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (462,1768,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (463,1771,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (464,1771,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (465,1771,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (469,7102,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (470,7102,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (471,7102,'Dodge','Neon 1995-2000','1996;1997;1998;1999;2000',''),
    (472,7102,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (473,6622,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (474,6622,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (475,6622,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (476,7300,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (477,7300,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (478,7300,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (479,2618,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.5 CRD'),
    (480,2618,'Dodge','Caravan','2001;2002;2003;2004;2005','2.5 CRD'),
    (481,5798,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (482,5798,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (483,5798,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (487,1251,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (488,1251,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.0;3.3;3.8'),
    (489,1251,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (490,7072,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (491,7072,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (492,7072,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (493,5539,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (494,5539,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (495,5539,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (496,5539,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (497,5539,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (498,5539,'Chrysler','Town&Country','2001;2002;2003;2004;2005','3.3;3.8'),
    (499,6873,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (506,2861,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (507,2861,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (517,3988,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4'),
    (518,3988,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4'),
    (519,4279,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (520,304,'Chrysler','Town&Country','1996;1997;1998;1999;2000',''),
    (521,304,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (522,304,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (523,3881,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (524,3881,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (528,1372,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0;5.2'),
    (529,2861,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (530,2861,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (531,157,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T'),
    (532,287,'Jeep','Grand Cherokee WK2 (2010-)','2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (533,287,'Dodge','Durango 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6;5.7'),
    (534,1091,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013','3.0D'),
    (535,1143,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0;5.2'),
    (536,1281,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (537,1281,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (538,1281,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (539,1287,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0;5.2'),
    (540,1406,'Dodge','Caliber 2007-2011','2007;2008;2009;2010;2011','1.8;2.0'),
    (541,1406,'Jeep','Patriot (2007-2015)','2007;2008;2009;2010;2011','2.0;2.4'),
    (542,1406,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','2.0;2.4'),
    (546,7574,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4'),
    (547,7574,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4'),
    (548,2775,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (549,2977,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (550,3001,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (551,3963,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (552,3966,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (553,9739,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (554,9739,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (555,4472,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (556,1983,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (557,1983,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (558,1983,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (559,2266,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (560,2266,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (561,3609,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (562,3609,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (563,3609,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (564,3609,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (565,3609,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (566,3609,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (567,4209,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (568,4109,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0;3.6'),
    (569,1548,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0'),
    (570,1549,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','3.6'),
    (571,8218,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (572,8218,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (573,8218,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (574,4162,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','3.6'),
    (575,4198,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0'),
    (578,187,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018','2.4'),
    (581,5562,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (582,5562,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (583,5562,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (584,3889,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (585,3889,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (586,2001,'Jeep','Cherokee KL (2014-2017)','2014;2015;2016;2017','2.4;3.2'),
    (587,2350,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (588,2350,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (589,2350,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (590,2350,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (594,2859,'Chrysler','Voyager','1999;2000','2.5 TD'),
    (595,3492,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (596,1654,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (597,2276,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (598,293,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (599,293,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (600,293,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (601,293,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (602,293,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (603,293,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (604,557,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (605,557,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (606,557,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (607,557,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (608,557,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (609,557,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (610,379,'Jeep','Renegade 2015-2020','2015;2016;2017;2018;2019;2020','1.4;2.4'),
    (611,422,'Jeep','Compass 2011-2017','2011;2012;2013;2014;2015;2016;2017','2.0;2.4'),
    (612,422,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','1.8;2.0;2.4'),
    (613,422,'Jeep','Patriot (2007-2016)','2007;2008;2009;2010;2011;2012;2013;2014;2015;2016','1.8;2.0;2.4'),
    (614,663,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (615,975,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (616,1142,'Jeep','Compass 2011-2017','2011;2012;2013;2014;2015;2016;2017','2.0;2.4'),
    (617,1843,'Dodge','Journey 2009-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (618,1851,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (619,1867,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (620,1936,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (621,1990,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (622,2094,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015','3.0D;3.6;5.7;6.4'),
    (623,2152,'Dodge','Grand Caravan 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020',''),
    (624,2180,'Dodge','Journey 2009-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (625,2343,'Dodge','Grand Caravan 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (626,2375,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (627,2545,'Dodge','Journey 2009-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (628,3043,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (629,3258,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (630,3742,'Chrysler','200','2015;2016;2017','2.4'),
    (631,3820,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (632,3894,'Jeep','Compass 2011-2017','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.0;2.4'),
    (633,4022,'Dodge','Journey 2009-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (634,4074,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015','3.0D'),
    (635,2338,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (640,696534,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (641,696534,'Dodge','Caliber 2007-2011','2007;2008;2009;2010;2011','1.8;2.0'),
    (642,696536,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (643,696536,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','2.0;2.4'),
    (644,696820,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (645,699659,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0'),
    (646,699659,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0;3.6'),
    (647,699659,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','3.6'),
    (648,2854,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018','2.4'),
    (649,2854,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (650,2854,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','1.8;2.0;2.4'),
    (651,2854,'Jeep','Patriot (2007-2016)','2007;2008;2009;2010;2011;2012;2013;2014;2015;2016','1.8;2.0;2.4'),
    (652,2854,'Dodge','Caliber 2007-2011','2007;2008;2009;2010;2011','1.8;2.0');

/*!40000 ALTER TABLE `filter_auto` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table filter_auto_template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `filter_auto_template`;

CREATE TABLE `filter_auto_template` (
                                        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                        `vendor` varchar(255) DEFAULT NULL,
                                        `model` varchar(255) DEFAULT NULL,
                                        `year` varchar(255) DEFAULT NULL,
                                        `engine` varchar(255) DEFAULT NULL,
                                        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `filter_auto_template` WRITE;
/*!40000 ALTER TABLE `filter_auto_template` DISABLE KEYS */;

INSERT INTO `filter_auto_template` (`id`, `vendor`, `model`, `year`, `engine`)
VALUES
    (630,'Chrysler','200','2015;2016;2017','2.4'),
    (97,'Chrysler','Town&Country','1996;1997;1998;1999;2000',''),
    (302,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.0;3.3'),
    (488,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.0;3.3;3.8'),
    (194,'Chrysler','Town&Country','1996;1997;1998;1999;2000','3.3;3.8'),
    (46,'Chrysler','Town&Country','1996;1997;1998;1999;2000;2001;2002;2003;2004;2005',''),
    (305,'Chrysler','Town&Country','2001;2002;2003;2004','3.3;3.8'),
    (369,'Chrysler','Town&Country','2001;2002;2003;2004;2005','3.3;3.8'),
    (199,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (272,'Chrysler','Town&Country','2001;2002;2003;2004;2005;2006;2007','3.3;3.8'),
    (117,'Chrysler','Voyager','1988;1989;1990;1991;1992;1993;1994;1995','2.5 TD;2.5 бензин;3.0;3.3'),
    (191,'Chrysler','Voyager','1996;1997;1998','2.5 TD'),
    (407,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD'),
    (301,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3'),
    (1,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (30,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;2.5 TD;3.3;3.8'),
    (276,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (192,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (170,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD'),
    (118,'Chrysler','Voyager','1996;1997;1998;1999;2000','2.5 TD;3.0;3.3;3.8'),
    (455,'Chrysler','Voyager','1996;1997;1998;1999;2000','3.3;3.8'),
    (190,'Chrysler','Voyager','1999;2000','2.5 TD'),
    (43,'Chrysler','Voyager','2000;2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (304,'Chrysler','Voyager','2001;2002;2003;2004','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (72,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.0;3.3;3.8'),
    (27,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;2.5 CRD;3.3;3.8'),
    (494,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (479,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.5 CRD'),
    (58,'Chrysler','Voyager','2001;2002;2003;2004;2005','2.5 CRD;3.3;3.8'),
    (297,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4'),
    (227,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (387,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (198,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (399,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (221,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (261,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (405,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (291,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (549,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (2,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;2.5 CRD;3.3;3.8'),
    (588,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (408,'Chrysler','Voyager','2001;2002;2003;2004;2005;2006;2007','2.5 CRD'),
    (540,'Dodge','Caliber 2007-2011','2007;2008;2009;2010;2011','1.8;2.0'),
    (119,'Dodge','Caravan','1988;1989;1990;1991;1992;1993;1994;1995','2.5 бензин;3.0;3.3'),
    (303,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3'),
    (284,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;2.5 TD;3.0;3.3;3.8'),
    (3,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.0;3.3;3.8'),
    (29,'Dodge','Caravan','1996;1997;1998;1999;2000','2.4;3.3;3.8'),
    (395,'Dodge','Caravan','1996;1997;1998;1999;2000','2.5 бензин;3.0;3.3'),
    (457,'Dodge','Caravan','1996;1997;1998;1999;2000','3.3;3.8'),
    (70,'Dodge','Caravan','1996;1997;1999;2000','2.4;3.0;3.3;3.8'),
    (306,'Dodge','Caravan','2001;2002;2003;2004','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (33,'Dodge','Caravan','2001;2002;2003;2004;2005','2.4;3.3;3.8'),
    (480,'Dodge','Caravan','2001;2002;2003;2004;2005','2.5 CRD'),
    (298,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4'),
    (229,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8 CRD;3.3;3.8'),
    (389,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;2.8CRD;3.3;3.8'),
    (200,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;2.5 CRD;3.3;3.8'),
    (400,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.4;3.3;3.8'),
    (222,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD'),
    (262,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8 CRD'),
    (406,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','2.5 CRD;2.8CRD'),
    (293,'Dodge','Caravan','2001;2002;2003;2004;2005;2006','3.3;3.8'),
    (4,'Dodge','Caravan','2001;2002;2003;2004;2005;2006;2007','2.4;3.3;3.8'),
    (533,'Dodge','Durango 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6;5.7'),
    (623,'Dodge','Grand Caravan 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020',''),
    (625,'Dodge','Grand Caravan 2011-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (578,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018','2.4'),
    (595,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4'),
    (548,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.4;3.6'),
    (596,'Dodge','Journey 2009-','2009;2010;2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (617,'Dodge','Journey 2009-','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.6'),
    (471,'Dodge','Neon 1995-2000','1996;1997;1998;1999;2000',''),
    (386,'Ford','C-MAX (2013-2018)','2013;2014;2015;2016;2017;2018','2.0'),
    (385,'Ford','Escape (2013-2018)','2013;2014;2015;2016;2017;2018','1.6T;2.0T;2.5'),
    (384,'Ford','Focus (2010-2018)','2010;2011;2012;2013;2014;2015;2016;2017;2018','2.0'),
    (79,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009','4.0;4.6;5.4'),
    (316,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0'),
    (76,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6'),
    (14,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.0;4.6;5.4'),
    (75,'Ford','Mustang (2005-2010)','2005;2006;2007;2008;2009;2010','4.6'),
    (379,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T'),
    (350,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0'),
    (380,'Ford','Mustang (2015-2020)','2015;2016;2017;2018;2019;2020','2.3T;3.7;5.0;5.2'),
    (586,'Jeep','Cherokee KL (2014-2017)','2014;2015;2016;2017','2.4;3.2'),
    (186,'Jeep','Cherokee XJ (1984-2001)','1996;1997;1998;1999;2000;2001',''),
    (5,'Jeep','Cherokee XJ (1984-2001)','1998;1999;2000;2001','2.5;4.0'),
    (612,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','1.8;2.0;2.4'),
    (542,'Jeep','Compass 2006-2010','2006;2007;2008;2009;2010','2.0;2.4'),
    (611,'Jeep','Compass 2011-2017','2011;2012;2013;2014;2015;2016;2017','2.0;2.4'),
    (632,'Jeep','Compass 2011-2017','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','2.0;2.4'),
    (187,'Jeep','Grand Cherokee WJ (1998-2004)','1996;1997;1998;1999;2000;2001',''),
    (534,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013','3.0D'),
    (634,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015','3.0D'),
    (622,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015','3.0D;3.6;5.7;6.4'),
    (551,'Jeep','Grand Cherokee WK2 (2010-)','2011;2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (532,'Jeep','Grand Cherokee WK2 (2010-)','2012;2013;2014;2015;2016;2017;2018;2019;2020','3.0D;3.6;5.7;6.4'),
    (541,'Jeep','Patriot (2007-2015)','2007;2008;2009;2010;2011','2.0;2.4'),
    (613,'Jeep','Patriot (2007-2016)','2007;2008;2009;2010;2011;2012;2013;2014;2015;2016','1.8;2.0;2.4'),
    (610,'Jeep','Renegade 2015-2020','2015;2016;2017;2018;2019;2020','1.4;2.4'),
    (569,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0'),
    (568,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','2.0;3.6'),
    (570,'Jeep','Wrangler JL ( 2018 - )','2018;2019;2020','3.6');

/*!40000 ALTER TABLE `filter_auto_template` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `width` smallint(4) unsigned DEFAULT NULL,
                          `height` smallint(4) unsigned DEFAULT NULL,
                          `ext` varchar(255) DEFAULT NULL,
                          `f_name` varchar(255) DEFAULT NULL,
                          `title` varchar(255) DEFAULT NULL,
                          `description` varchar(255) DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table income
# ------------------------------------------------------------

DROP TABLE IF EXISTS `income`;

CREATE TABLE `income` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `id_vendor` int(11) unsigned NOT NULL,
                          `id_warehouse` int(11) unsigned NOT NULL,
                          `num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                          `created_at` timestamp NULL DEFAULT NULL,
                          `updated_at` timestamp NULL DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table income_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `income_product`;

CREATE TABLE `income_product` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_income` int(11) unsigned NOT NULL,
                                  `id_product` int(11) unsigned DEFAULT NULL,
                                  `id_warehouse` int(11) DEFAULT NULL,
                                  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `upc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                  `price` float NOT NULL,
                                  `quantity` smallint(6) NOT NULL DEFAULT '1',
                                  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
                             `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `apply_time` int(11) DEFAULT NULL,
                             PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
    ('m000000_000000_base',1649757291),
    ('m130524_201442_init',1649757293),
    ('m140506_102106_rbac_init',1652447544),
    ('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1652447544),
    ('m180523_151638_rbac_updates_indexes_without_prefix',1652447544),
    ('m190124_110200_add_verification_token_column_to_user_table',1649757293),
    ('m200409_110543_rbac_update_mssql_trigger',1652447544),
    ('m220523_103510_alter_table_order_add_np',1653322287),
    ('m220524_092541_alter_table_np_internet_document_add_recipientCityRef_recipientWarehouseRef',1653415126),
    ('m220531_132945_alter_table_warehouse_add_price_updated',1654004878),
    ('m220531_193615_alter_table_order_add_paid',1654164641),
    ('m220602_100624_cashdesk',1654164641),
    ('m220613_215003_cashdesk_method',1655158153),
    ('m220825_133020_product_inventory_history',1661436219),
    ('m221125_151344_alter_table_product_add_prom_export',1669390484),
    ('m221130_152424_alter_table_customer_add_autovin',1669822279),
    ('m230207_095452_alter_table_product_add_updated_at',1675764035),
    ('m231110_173537_user_add_branch_ware',1701292369),
    ('m231124_131628_product_qty',1701292390),
    ('m231124_184812_order_product_add_id_warehouse',1701292390),
    ('m240411_115537_create_warehouse_place_table',1712840407);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table np_internet_document
# ------------------------------------------------------------

DROP TABLE IF EXISTS `np_internet_document`;

CREATE TABLE `np_internet_document` (
                                        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                        `id_order` int(11) unsigned DEFAULT NULL,
                                        `TrackingNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Номер накладної',
                                        `CostOnSite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `EstimatedDeliveryDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `Ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `TypeDocument` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `senderFirstName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'І''мя відправника',
                                        `senderMiddleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'По батькові відправника',
                                        `senderLastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Прізвище відправника',
                                        `senderDescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Опис відправника',
                                        `senderPhone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Телефон відправника',
                                        `senderCity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Місто відправника',
                                        `senderRegion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Область відправника',
                                        `senderCitySender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Місто відправника',
                                        `senderSenderAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Адреса відправника',
                                        `senderWarehouse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Відділення відправлення',
                                        `recipientFirstName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'І''мя',
                                        `recipientMiddleName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'По батькові',
                                        `recipientLastName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Прізвище',
                                        `recipientPhone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Телефон',
                                        `recipientCity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Місто',
                                        `recipientCityRef` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `recipientRegion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Область',
                                        `recipientWarehouse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Відділення',
                                        `recipientWarehouseRef` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                        `DateTime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Дата відправлення',
                                        `ServiceType` enum('DoorsDoors','DoorsWarehouse','WarehouseWarehouse','WarehouseDoors') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WarehouseWarehouse' COMMENT 'Тип доставки',
                                        `PaymentMethod` enum('Cash','NonCash') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash' COMMENT 'Тип оплаты',
                                        `PayerType` enum('Sender','Recipient','ThirdPerson') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Recipient' COMMENT 'Хто сплачує доставку',
                                        `Cost` int(11) NOT NULL COMMENT 'Вартість груза, грн',
                                        `SeatsAmount` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Кількість місць',
                                        `Description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Опис грузу',
                                        `CargoType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Parcel' COMMENT 'Тип доставки',
                                        `Weight` float DEFAULT NULL COMMENT 'Вага груза',
                                        `VolumeGeneral` float DEFAULT NULL COMMENT 'Об''єм вантажу, куб. м.',
                                        `BackDelivery_PayerType` enum('Sender','Recipient','ThirdPerson') COLLATE utf8mb4_unicode_ci DEFAULT 'Recipient' COMMENT 'Платник зворотньої доставки',
                                        `BackDelivery_CargoType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Money' COMMENT 'Тип зворотньої доставки',
                                        `BackDelivery_RedeliveryString` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Значення зворотньої доставки',
                                        `status` tinyint(1) DEFAULT NULL COMMENT 'Статус',
                                        `created_at` timestamp NULL DEFAULT NULL COMMENT 'Створено',
                                        `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Оновлено',
                                        PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `np_internet_document` WRITE;
/*!40000 ALTER TABLE `np_internet_document` DISABLE KEYS */;

INSERT INTO `np_internet_document` (`id`, `id_order`, `TrackingNumber`, `CostOnSite`, `EstimatedDeliveryDate`, `Ref`, `TypeDocument`, `senderFirstName`, `senderMiddleName`, `senderLastName`, `senderDescription`, `senderPhone`, `senderCity`, `senderRegion`, `senderCitySender`, `senderSenderAddress`, `senderWarehouse`, `recipientFirstName`, `recipientMiddleName`, `recipientLastName`, `recipientPhone`, `recipientCity`, `recipientCityRef`, `recipientRegion`, `recipientWarehouse`, `recipientWarehouseRef`, `DateTime`, `ServiceType`, `PaymentMethod`, `PayerType`, `Cost`, `SeatsAmount`, `Description`, `CargoType`, `Weight`, `VolumeGeneral`, `BackDelivery_PayerType`, `BackDelivery_CargoType`, `BackDelivery_RedeliveryString`, `status`, `created_at`, `updated_at`)
VALUES
    (1,21,'20450542164834','86','25.05.2022','5c9be442-db8b-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Сергій','Олександрович','Плякін','0969194124','Львів','db5c88f5-391c-11dd-90d9-001a92567626','','Відділення №13 (до 30 кг на одне місце): просп. Чорновола В\'ячеслава, 16Д, прим. 98','0d545f43-e1c2-11e3-8c4a-0050568002cf',NULL,'WarehouseWarehouse','Cash','Recipient',5181,1,'запчастини','Parcel',0.2,NULL,'Recipient','Money','5181',NULL,'2022-05-24 18:00:14',NULL),
    (3,20,'20450544792969','118','01.06.2022','d3aaf354-e0f9-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Казбек','Ахсарбекович','Гутиев','380504403380','Київ','8d5a980d-391c-11dd-90d9-001a92567626','','Відділення №246 (до 30 кг): вул. Сергія Данченка, 6, прим. 28','dc7a6eeb-427e-11e6-a9f2-005056887b8d',NULL,'WarehouseWarehouse','Cash','Recipient',15696,1,'запчастини','Parcel',2,NULL,'Recipient','Money','15696',NULL,'2022-05-31 15:53:34',NULL),
    (5,26,'20450545163134','68','02.06.2022','b42814a5-e1ac-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Вікторія','Анатоліївна','Годіна','0660908892','Запоріжжя','db5c88c6-391c-11dd-90d9-001a92567626','','Відділення №22 (до 30 кг): вул. Чарівна, 119, прим. 146','47402e8e-e1c2-11e3-8c4a-0050568002cf',NULL,'WarehouseWarehouse','Cash','Recipient',1614,1,'запчастини','Parcel',0.6,NULL,'Recipient','Money','1614',NULL,'2022-06-01 13:14:01',NULL),
    (6,27,'20450545503600','44','03.06.2022','c3c9b3fc-e267-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Казбек','Ахсарбекович','Гутиев','380504403380','Київ','8d5a980d-391c-11dd-90d9-001a92567626','','Відділення №246 (до 30 кг): вул. Сергія Данченка, 6, прим. 28','dc7a6eeb-427e-11e6-a9f2-005056887b8d',NULL,'WarehouseWarehouse','Cash','Recipient',826,1,'запчастини','Parcel',1,NULL,'Recipient','Money','826',NULL,'2022-06-02 11:33:03',NULL),
    (7,30,'20450546174243','44','05.06.2022','374de20a-e3df-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Казбек','Ахсарбекович','Гутиев','380504403380','Київ','8d5a980d-391c-11dd-90d9-001a92567626',NULL,'Відділення №246 (до 30 кг): вул. Сергія Данченка, 6, прим. 28','dc7a6eeb-427e-11e6-a9f2-005056887b8d',NULL,'WarehouseWarehouse','Cash','Recipient',771,1,'запчастини','Parcel',0.3,NULL,'Recipient','Money','',NULL,'2022-06-04 08:20:40',NULL),
    (8,32,'20450546985411','105','07.06.2022','5544f4df-e59e-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Константин','Сергеевич','Родько','380980411641','Харків','db5c88e0-391c-11dd-90d9-001a92567626',NULL,'Відділення №16: пл. Ю. Кононенко, 1а (Автобазар \"Лоск\", східна сторона)','1ec09d51-e1c2-11e3-8c4a-0050568002cf',NULL,'WarehouseWarehouse','Cash','Recipient',4945,1,'запчастини','Parcel',5,5,'Recipient','Money','',NULL,'2022-06-06 13:41:14',NULL),
    (9,42,'20450552976449','171','22.06.2022','e5fef200-f15e-11ec-a60f-48df37b921db','InternetDocument','Приватна особа','','',NULL,'0938309777','Київ','Київська',NULL,NULL,'9d74afbe-ed7d-11e4-8a92-005056887b8d','Игорь','Петрович','Аверкин','0679532994','Запоріжжя','db5c88c6-391c-11dd-90d9-001a92567626',NULL,'Відділення №36 (до 30 кг): просп. 40-річчя Перемоги, 9а','775f572a-9c02-11e4-acce-0050568002cf',NULL,'WarehouseWarehouse','Cash','Recipient',10271,1,'запчастини','Parcel',27,NULL,'Recipient','Money','10271',NULL,'2022-06-21 12:37:23',NULL);

/*!40000 ALTER TABLE `np_internet_document` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
                         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `id_manager` int(10) unsigned DEFAULT NULL,
                         `id_customer` int(10) unsigned DEFAULT NULL,
                         `c_fio` varchar(255) DEFAULT '',
                         `c_email` varchar(255) DEFAULT '',
                         `c_tel` varchar(255) DEFAULT '',
                         `o_address` text,
                         `o_city` varchar(255) DEFAULT '',
                         `o_comments` text,
                         `o_payment` varchar(255) DEFAULT '',
                         `o_shipping` varchar(255) DEFAULT '',
                         `o_total` varchar(255) DEFAULT '',
                         `np_city` varchar(255) DEFAULT NULL,
                         `np_city_ref` varchar(255) DEFAULT NULL,
                         `np_region` varchar(255) DEFAULT NULL,
                         `np_region_ref` varchar(255) DEFAULT NULL,
                         `np_warehouse` varchar(255) DEFAULT NULL,
                         `np_warehouse_ref` varchar(255) DEFAULT NULL,
                         `is_paid` tinyint(1) NOT NULL DEFAULT '0',
                         `paid` double DEFAULT NULL,
                         `ip` varchar(255) DEFAULT '',
                         `status` tinyint(1) NOT NULL DEFAULT '1',
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `id_customer` (`id_customer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table order_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_product`;

CREATE TABLE `order_product` (
                                 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_order` int(10) unsigned NOT NULL,
                                 `id_product` int(10) unsigned NOT NULL,
                                 `id_warehouse` int(11) DEFAULT NULL,
                                 `product_name` varchar(255) NOT NULL DEFAULT '',
                                 `upc` varchar(255) DEFAULT NULL,
                                 `price` float NOT NULL,
                                 `quantity` smallint(6) NOT NULL,
                                 `status` tinyint(1) DEFAULT '7',
                                 PRIMARY KEY (`id`),
                                 KEY `id_order` (`id_order`,`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table order_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order_status`;

CREATE TABLE `order_status` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-order, 2-product',
                                `name` varchar(32) NOT NULL,
                                `color` char(8) NOT NULL DEFAULT '',
                                PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table parser_prod
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parser_prod`;

CREATE TABLE `parser_prod` (
                               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `alts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `on_car` text COLLATE utf8mb4_unicode_ci,
                               PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table parser_prod_stg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parser_prod_stg`;

CREATE TABLE `parser_prod_stg` (
                                   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                   `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
                                   `catalog` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `article` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `avail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                   `descr` text COLLATE utf8mb4_unicode_ci,
                                   `cars` text COLLATE utf8mb4_unicode_ci,
                                   `analog` text COLLATE utf8mb4_unicode_ci,
                                   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
                           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                           `id_vendor` int(11) DEFAULT NULL,
                           `id_category` int(11) DEFAULT NULL,
                           `id_brand` int(11) DEFAULT NULL,
                           `id_warehouse` int(11) DEFAULT NULL,
                           `id_image` int(11) DEFAULT NULL,
                           `prom_export` tinyint(1) DEFAULT NULL,
                           `name` varchar(255) NOT NULL DEFAULT '',
                           `url` varchar(255) DEFAULT '',
                           `upc` varchar(255) NOT NULL DEFAULT '',
                           `availability` varchar(255) DEFAULT NULL,
                           `count` int(11) NOT NULL DEFAULT '0',
                           `count_min` smallint(6) DEFAULT '1',
                           `count_max` smallint(6) DEFAULT NULL,
                           `price` float NOT NULL DEFAULT '0',
                           `weight` varchar(255) DEFAULT '',
                           `analog` text,
                           `applicable` text,
                           `image_path` varchar(255) DEFAULT NULL,
                           `is_new` tinyint(1) NOT NULL DEFAULT '1',
                           `extra_charge` tinyint(4) NOT NULL DEFAULT '0',
                           `currency` char(3) DEFAULT 'USD',
                           `ware_place` varchar(255) DEFAULT '',
                           `note` varchar(512) DEFAULT '',
                           `description` text,
                           `meta_title` varchar(521) DEFAULT NULL,
                           `meta_keywords` varchar(512) DEFAULT '',
                           `meta_description` varchar(512) DEFAULT '',
                           `status` tinyint(1) NOT NULL DEFAULT '1',
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           PRIMARY KEY (`id`),
                           KEY `id_category` (`id_category`),
                           KEY `id_brand` (`id_brand`),
                           KEY `id_warehouse` (`id_warehouse`),
                           KEY `id_vendor` (`id_vendor`),
                           KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table product_inventory_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_inventory_history`;

CREATE TABLE `product_inventory_history` (
                                             `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                             `id_product` int(11) unsigned NOT NULL,
                                             `id_warehouse` int(11) DEFAULT NULL,
                                             `id_order` int(11) unsigned DEFAULT NULL,
                                             `id_user` int(11) unsigned DEFAULT NULL,
                                             `status_prev` int(11) DEFAULT NULL,
                                             `status_new` int(11) DEFAULT NULL,
                                             `quantity_prev` int(11) DEFAULT NULL,
                                             `quantity_new` int(11) DEFAULT NULL,
                                             `created_at` timestamp NULL DEFAULT NULL,
                                             `updated_at` timestamp NULL DEFAULT NULL,
                                             PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table product_quantity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_quantity`;

CREATE TABLE `product_quantity` (
                                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_product` int(11) unsigned NOT NULL,
                                    `id_warehouse` int(11) unsigned DEFAULT NULL,
                                    `id_warehouse_place` int(11) DEFAULT NULL,
                                    `count` int(11) unsigned NOT NULL DEFAULT '0',
                                    `price` float DEFAULT NULL,
                                    `ware_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                    `created_at` timestamp NULL DEFAULT NULL,
                                    `updated_at` timestamp NULL DEFAULT NULL,
                                    PRIMARY KEY (`id`),
                                    KEY `idx-id_product` (`id_product`),
                                    KEY `idx-id_warehouse` (`id_warehouse`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) DEFAULT NULL,
                            `const_name` varchar(255) DEFAULT NULL,
                            `value` text,
                            `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `const_name`, `value`, `ts`)
VALUES
    (1,'Нова Пошта: Прізвище відправника','np_lastname','Лісовий','2022-05-21 19:54:00'),
    (2,'Нова Пошта: І\'мя відправника','np_firstname','Євгеній','2022-05-21 19:55:49'),
    (3,'Нова Пошта: По батькові відправника','np_middlename','Олегович','2022-05-21 20:09:46'),
    (4,'Нова Пошта: Місто відправника','np_city','Київ','2022-05-21 20:01:46'),
    (5,'Нова Пошта: Область відправника','np_region','Київська','2022-05-21 20:01:54'),
    (6,'Нова Пошта: Відділення відправлення','np_warehouse','Відділення №327 (до 30 кг): бульв. Вацлава Гавела (ран. Лепсе Івана), 47/15','2022-05-21 20:06:03'),
    (7,'Нова Пошта: Телефон відправника','np_phone','0938309777','2022-05-21 20:06:55'),
    (8,'ЄДРПОУ','edrpou','3372610016','2022-05-21 20:11:43');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table static_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_page`;

CREATE TABLE `static_page` (
                               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `parent_id` int(11) unsigned DEFAULT NULL,
                               `url` varchar(255) DEFAULT '',
                               `title` varchar(255) NOT NULL,
                               `content` text,
                               `meta_title` varchar(255) DEFAULT '',
                               `meta_keywords` text,
                               `meta_description` text,
                               `articles` text,
                               `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `pos` tinyint(4) DEFAULT NULL,
                               `stat` tinyint(1) NOT NULL DEFAULT '1',
                               PRIMARY KEY (`id`),
                               FULLTEXT KEY `title` (`title`),
                               FULLTEXT KEY `content` (`content`),
                               FULLTEXT KEY `keywords` (`meta_keywords`),
                               FULLTEXT KEY `meta_title` (`meta_title`),
                               FULLTEXT KEY `meta_description` (`meta_description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `static_page` WRITE;
/*!40000 ALTER TABLE `static_page` DISABLE KEYS */;

INSERT INTO `static_page` (`id`, `parent_id`, `url`, `title`, `content`, `meta_title`, `meta_keywords`, `meta_description`, `articles`, `dt`, `pos`, `stat`)
VALUES
    (1,NULL,'shipping','Доставка і оплата','<div class=\"ua\" style=\"width:50px;height:30px;\">&nbsp;</div>\n\n<h2><span style=\"font-size:18px\"><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Доставка по Україні</span></span></span>\n</h2>\n\n<p>\n    <span style=\"font-family:tahoma,geneva,sans-serif\">\n    Доставка в Україні здійснюється кур’єрською службою \n        &quot;<a rel=\"nofollow\" href=\"https://novaposhta.ua/office\" target=\"_blank\">Нова Пошта</a>&quot;, \n        можливість відправки замовлення іншими перевізниками уточнюйте у менеджерів. \n        Вартість послуг з перевезення товару оплачує клієнт згідно з \n        <a rel=\"nofollow\" href=\"https://novaposhta.ua/privatnim_klientam/ceny_i_tarify\" target=\"_blank\">\n            тарифами</a> &quot;Нової Пошти&quot;. \n            Замовлення, які складені до 16:00, комплектуються та надсилаються в той же день. \n            Доставку оплачує клієнт під час отримання товару згідно з тарифами перевізника.\n    </span>\n</p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">1. Самовивіз - ви можете самостійно забрати товар.</span>\n</p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">2. Доставка по Києву - здійснюється кур’єром нашої компанії. Деталі умов доставки уточнюйте у менеджера.</span>\n</p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">3. Доставка по Україні - здійснюється кур’єрською службою “Нова пошта”. Можливість доставки іншими перевізниками уточнюйте у менеджерів.</span>\n</p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Способи оплати:</span></p>\n\n<ul>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">1. На картку Приват-банку</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">2. Готівкою в офісі</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">3. Накладеним платежем (при доставці &quot;Новою Поштою&quot;)</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">4. Безготівковий платіж</span></li>\n</ul>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Увага! На товари під замовлення - передплата 50%.</span></p>\n\n<p>&nbsp;</p>\n\n<div class=\"de\" style=\"width:50px;height:30px;\">&nbsp;</div>\n\n<h2><span style=\"font-size:18px;font-family:tahoma,geneva,sans-serif\">ДОСТАВКА З НІМЕЧЧИНИ</span></h2>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Шановні клієнти,<br/>\nЗа доставку великогабаритних деталей ми вимушені виставляти окремий рахунок з розрахунку 400€ за кубічний метр.</span>\n</p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Перелік великогабаритних деталей:</span></p>\n\n<ul>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Лобове та заднє скло</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Кузовні деталі (двері, крила, капот, багажник)</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Великі внутрішні деталі (панель приладів, сидіння, дах)</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Колеса.</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Випускні труби та мости.</span></li>\n</ul>\n\n<p>\n    <span style=\"font-family:tahoma,geneva,sans-serif\">\n  У разі виникнення питання, чи деталь є великогабаритною, просимо \n<a href=\"/contact/\">надіслати нам запит</a> перед замовленням.&nbsp;<br/>\nЗверніть увагу, що часто багато з цих деталей поставляються в упаковці, щоб уникнути пошкоджень під час транспортування. \nВ такому випадку розраховується об’єм упакованої деталі.</span>\n</p>\n\n<p>&nbsp;</p>\n\n<div class=\"us\" style=\"width:50px;height:30px;\">&nbsp;</div>\n\n<h2><span style=\"font-size:18px;font-family:tahoma,geneva,sans-serif\">Доставка&nbsp;з США</span></h2>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Увага! Вартість товару з регіону США не включає вартість доставки!</span></p>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">Вартість доставки регіон США:</span></p>\n\n<ul>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Авіа - 8$/кг</span></li>\n    <li><span style=\"font-family:tahoma,geneva,sans-serif\">Море - 4,5$/кг</span></li>\n</ul>\n\n<p><span style=\"font-family:tahoma,geneva,sans-serif\">\nУвага! Для великогабаритних товарів ми вимушені виставляти окремий рахунок з розрахунку $450/метр кубічний (двері, бампер, дах…)</span>\n</p>\n','Доставка и Оплата. Запчасти для американских автомобилей',NULL,'Осуществляет прямые поставки запчастей из США. Мы поставляем запчасти из Америки напрямую, без посредников, что позволяет устанавливать низкие цены на американские запчасти.',NULL,'2023-09-28 10:11:21',NULL,1),
    (2,NULL,'dodge-parts','Запчастини Dodge','<p><a href=\"/auto-parts/?id_brand=4\" style=\"line-height: 20.8px; margin: 2px;\"><img alt=\"Dodge\" src=\"/images/auto_brand/Dodge.jpeg\" style=\"float:left; height:100px; margin-left:4px; margin-right:4px; width:100px\" title=\"Dodge\" /></a><span style=\"font-size:18px\"><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Додж &ndash; доступна надійність</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nІсторія бренду стартувала 1900 року, коли брати Додж розпочали випуск якісних автозапчастин для автомобільної промисловості, що стрімко зростала. Через чотирнадцять років вони запустили виробництво авто власної марки, яке позиціонувалося, як недороге, але надійне.\n</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nВисока репутація принесла автомобілям Dodge заслужену популярність, а з 1928 року виробничі потужності компанії увійшли до складу корпорації Крайслер.\n</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nЗа вікову історію існування під маркою Додж випускали військові вантажівки, важкі джипи, спортивні купе, кабріолети, компактні малолітражки, седани, пікапи і мінівени.\n</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nУ 1998 році модельний ряд бренду було повністю оновлено. У рамках сучасної стратегії автомобілі Додж позиціонуються, як доступні, надійні та спортивні. Рестайлінг, до якого залучалися і європейські інженери, позитивно позначився на просуванні бренду. Активні продажі Додж почалися в Європі і на пострадянському просторі.\n</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"color:#000000\"><strong><span style=\"font-family:tahoma,geneva,sans-serif\">\nЗапчастини Додж (Dodge) в Україні\n</span></strong></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nЗ урахуванням широкого поширення автомобілів марки Додж, автозапчастини на них не рідкість. Найскрупульозніші власники машин віддають перевагу оригінальним запчастинам, які випускаються низкою американських і європейських виробників.\n</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nНаш інтернет-магазин поставляє тільки якісні автозапчастини для автомобілів Dodge Avenger, Caravan, Dacota, Durango, Intrepid, Journey, Neon, Nitro, Ram, Caliber.\n</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">\nВи можете знайти необхідні автозапчастини Dodge в нашому каталозі самостійно або відправити VIN-запит менеджерам, які зв\'яжуться з вами в короткі терміни.\n</span></span></p>','Запчастини Додж (Dodge) в Україні','Купити запчастини на Dodge 1993-2011 в інтернет магазині americancars.com.ua. Dodge 1993-2011 запчастини в Києві за низькою ціною. Запчастини зі США. Оригінальні запчастини.','Автозапчастини на автомобілі acura, buick, cadillac, chevrolet, chrysler, dodge, jeep, ford, pontiac, hummer. Оригінальні запчастини для автомобілів acura, buick, cadillac, chevrolet, chrysler, dodge, jeep, ford, pontiac, hummer. Деталі до автомобілів acura. Dodge 1993-2011, (Додж 1993-2011)',NULL,'2023-09-28 10:11:21',NULL,1),
    (3,NULL,'chrysler-parts','Запчастини на Chrysler (Крайслер) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1468406376-c1c391620da5565cebf39c10ca652882.jpeg\" style=\"float:left; height:125px; margin-left:4px; margin-right:4px; width:125px\" /></p>\n\n<p><strong><span style=\"color:#000000\"><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\">Крайслер &ndash; история автогиганта</span></span></span></strong></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">В 1924 году промышленник Уолтер Крайслер создает компанию, которой в последующие десятилетия предстоит пережить стремительные взлеты, активную экспансию и поглощения более мощными концернами.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">В 1928 компания приобретает мощности Додж и врывается в тройку лидеров американского автопрома. В это же время начинается запуск автомобилей Плимут и ДеСото.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Успех впечатляющего прорыва объясняется стремлением к техническому совершенству, необычному дизайну и воплощению инновационных идей, которые присущи каждой запчасти Крайслер. Со временем многие нововведения компании станут стандартом автомобильной промышленности.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">В середине пятидесятых годов 20 века компания активно скупает европейские автопредприятия и наращивает присутствие в Старом Свете. Однако в 1970 бренд сталкивается с финансовыми трудностями, решить которые удается только после привлечения антикризисного менеджера Ли Якокку. Он меняет систему управления, предотвращает банкротство и восстанавливает репутацию автогиганта.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">В 1998 в результате объединения с &laquo;ДаймлерБенц&raquo; появляется концерн &laquo;DaimlerChrysler&raquo;, а в 2014 подразделение &nbsp;Chrysler переходит под контроль Fiat.</span></span></p>\n\n<p><strong><span style=\"color:#000000\"><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\">Запчасти на Chrysler (Крайслер) в Украине</span></span></span></strong></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Современные модели Крайслер представлены в нише легковых авто и минивэнов.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Наш интернет магазин поставляет автозапчасти для автомобилей Chrysler Cirrus, Pasifica, Sebring, Voyager, PT Criiser, 300C, 300M.</span></span></p>\n\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Чтобы купить запчасти Крайслер воспользуйтесь поиском в каталоге или отправьте VIN-запрос нашим менеджерам, которые подберут необходимую деталь и сообщат вам о её наличии.</span></span></p>','Запчастини на Chrysler (Крайслер) в Україні','Купить запчасти на Chrysler 1990-2011 в интернет магазине americancars.com.ua. Chrysler 1993-2011 запчасти в Киеве по низкой цене. Запчасти из США. Оригинальные запчасти. Запчасти крайслер вояджер.','Автозапчастини на автомобілі acura, buick, cadillac, chevrolet, chrysler, dodge, jeep, ford, pontiac, hummer. Оригінальні запчастини для автомобілів acura, buick, cadillac, chevrolet, chrysler, dodge, jeep, ford, pontiac, hummer. Chrysler 1993-2011, (Крайслер 1993-2011). Запчастини крайслер вояджер.',NULL,'2023-09-28 10:11:21',NULL,1),
    (4,NULL,'acura-parts','Автозапчастини на автомобілі Acura (Акура) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467702728-0d6ec26491555c71336101dbb8d9ddba.jpeg\" style=\"float:left; height:100px; width:100px\" /></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"font-size:18px\"><strong>Acura</strong><strong> &ndash; представник преміум-класу</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">У 1984 році концерн Honda створив у США дочірній підрозділ для випуску високотехнологічних автомобілів Акура. Перші моделі підтвердили лідерство бренду в сфері інновацій і закріпилися в сегменті престижних авто. Спорткар Integra та седан бізнес-класу Legend упевнено потіснили конкурентів, а представлений 1989 року суперкар NSX було визнано &laquo;Найкращим автомобілем року&raquo;.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">У 1995 компанія починає виробництво динамічних кросоверів. Першопрохідцем стає автомобіль Acura SLX. Через 5 років на ринок виходить середньорозмірний MDX, у 2005 з\'являється компактний RDX, а в 2009 у продаж надходить купеподібний ZDX.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Понад 30 років автомобілі Acura втілюють сміливий дизайн і технологічну досконалість, забезпечуючи своїм власникам безумовний комфорт і розширюючи їхні можливості. Сьогодні бренд щільно влаштувався в популярних нішах - практичних кросоверів і седанів представницького та бізнес-класу.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Автозапчастини на автомобілі Acura (Акура) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">З урахуванням престижності бренду технічне обслуговування і запчастини на Акуру обходяться автовласникам недешево. Купуючи деталі в нашому інтернет-магазині, ви не переплачуєте за послуги посередників і отримуєте комплектуючі за справедливою ціною.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">У каталозі представлені тільки якісні запчастини на Acura. Їх виробництво супроводжується жорсткою системою контролю і тестувань, що виключає заводські дефекти і недоробки готової продукції.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Щоб купити автозапчастини Acura, ви можете самостійно знайти необхідну деталь в каталозі, написати або зателефонувати нашим менеджерам або відправити VIN-запит, заповнивши форму на сайті.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (5,NULL,'buick-parts','Запчастини на автомобілі Buick (Бьюик) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467877466-fe484901abe96de16f10ee778411876d.jpg\" style=\"float:left; height:90px; margin-left:4px; margin-right:4px; width:120px\" /></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"font-size:18px\"><strong>Buick</strong> <strong>&ndash; справжній американець</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Історія одного з найстаріших автомобільних брендів розпочалася 1902 року із заснування компанії інженером Девідом Б\'юїком.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Незважаючи на добротність і технічну перевагу автомобілів Б\'юїк над конкурентами, їхнє серійне виробництво стартувало тільки в 1908 році після входження бренду до складу корпорації General Motors. Марка, що отримала визнання широкої публіки, стала одним із символів справжнього американського стилю, в якому поєднувалися престиж і доступність.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Справжній розквіт бренду почався в 50-х роках, коли після війни активізувався попит на розкішні потужні автомобілі. Однак непродуманий маркетинг і нафтова криза, що вибухнула в 1970-х, стали причиною закономірного спаду продажів і змусила власників переглянути стратегію подальшого просування.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Сучасні автомобілі Б\'юїк представлені компактними передньопривідними моделями середнього класу з відносно невисокою вартістю.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Запчастини для автомобілів Buick (Б\'юїк) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Наш інтернет-магазин пропонує оригінальні та альтернативні запчастини на Б\'юїк за оптимальною ціною. Ми поставляємо тільки якісні комплектуючі від перевірених постачальників, які заслужили позитивну репутацію. Тут ви знайдете деталі для автомобілів Б\'юїк LaCross, Allure, Enclave, Regal.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Щоб купити автозапчастини Б\'юїк, можна скористатися пошуком за каталогом, зв\'язатися з нашими співробітниками електронною поштою і телефоном або відправити VIN-запит, вказавши параметри автомобіля.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (6,NULL,'cadillac-parts','Запчастини Кадиллак (Кадиллак) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1468313466-eda7109dbbfc62b9ec2d7e4940aec1cb.jpg\" style=\"float:left; height:155px; margin-left:4px; margin-right:4px; width:200px\" /><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><span style=\"font-size:18px\"><strong>Cadillac &ndash; втілення розкоші</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">З моменту заснування в 1902 році бренд позиціонується, як виробник автомобілів вищого класу з добротним оздобленням і високоточним опрацюванням всіх деталей. Компанія першою домоглася взаємозамінності стандартних запчастин Кадилак і розробила потужний тихий двигун V8, що став згодом стандартом для американської автопромисловості.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">У 1909 році компанія стає частиною концерну &laquo;General Motors&raquo;, при цьому під брендом Cadillac, націленим на верхній сегмент ринку, випускаються солідні автомобілі класу &laquo;люкс&raquo;.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">У 30-х роках Кадилак займає лідируючу позицію в просуванні прогресивних технічних розробок. У цей же час сформувалася дизайнерська концепція, яка визначила вигляд автомобілів бренду на десятиліття вперед і міцно закріпила за ним статус шикарного авто.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">У новому тисячолітті компанія Cadillac продовжує поставляти на авторинок технічно досконалі моделі з високими експлуатаційними характеристиками і передовими технологіями.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><strong>Запчастини Кадилак (Cadillac) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Реалізований в автомобілях інноваційний підхід передбачає використання виключно високоякісних запчастин на Кадилак. Наш інтернет-магазин допоможе вам придбати деталі від перевірених виробників, які спеціалізуються на виготовленні комплектуючих преміум-класу.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Щоб підібрати і купити автозапчастини Cadillac, скористайтеся функцією пошуку в каталозі за номером або найменуванням деталі, надішліть заповнену форму VIN-запиту або зв\'яжіться з нашими менеджерами за телефоном або електронною поштою</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (7,NULL,'chevrolet-parts','Запчастини на автомобілі Chevrolet (Шевроле) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467877676-b58763d6008272cb8b1276b9bf904a4b.jpg\" style=\"float:left; height:80px; margin-left:4px; margin-right:4px; width:140px\" /><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong><span style=\"font-size:18px\">Chevrolet &ndash; флагман продажів General Motors</span></strong></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Своєю появою в 1911 році бренд Chevrolet зобов\'язаний засновнику концерну General Motors Вільяму Дюранту і знаменитому в ті роки гонщику Луї Шевроле. Перша модель, створена під їхнім керівництвом, виявилася доволі вдалою в технічному плані, але через непомірну дорожнечу залишилася незатребуваною. А тому було вирішено зробити ставку на простоту і дешевизну автомобілів.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">В результаті спрощення комплектації та оптимізації запчастин Шевроле впевнено витіснив конкурентів і став однією з найбільш затребуваних марок на ринку США. Динамічні, надійні, доступні автомобілі дали старт подальшому розвитку бренду, який надовго зайняв лідируючі позиції з продажу в Америці.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">При цьому дизайнерам та інженерам компанії належить чимало розробок, що вплинули на автомобілебудування в усьому світі.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Початок нового тисячоліття ознаменувався для бренду посиленою експансією на ринок Європи та пострадянських країн, що розпочалася після придбання концерном GM виробничих потужностей корейської компанії Daewoo.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Запчастини на автомобілі Chevrolet (Шевроле) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Тим часом, моделі-&laquo;американці&raquo; (Express, Colorado, Equinox, Trailblazer, Avalanche, Suburban, Tahoe, Camaro) залишаються гордістю тисяч автовласників. Для них у нашому інтернет-магазині представлений каталог оригінальних запчастин Chevrolet високої якості.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Щоб вибрати і купити запчастини на Шевроле, достатньо скористатися зручною системою пошуку або надіслати форму VIN-запиту менеджерам, вказавши характеристики автомобіля і параметри деталі, яку ви шукаєте.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (8,NULL,'ford-parts','Оригинальні Запчастини Ford (Форд) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467877962-5f9df2e9c8590b67f0ab9fdb24544e99.jpeg\" style=\"float:left; height:140px; margin-left:4px; margin-right:4px; width:140px\" /></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"font-size:18px\"><strong>Ford &ndash; фаворит масових продажів</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Понад століття компанія Ford є одним із лідерів автомобільного ринку. Від самого початку існування бренд пропонує недорогі, практичні, прості в обслуговуванні та управлінні моделі, орієнтовані на масового споживача.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Спочатку запчастини для автомобілів Форд виробляли інші підприємства і збирали робітники компанії. У 1913 році цехи були обладнані лініями безперервного поетапного складання, що стало початком індустріального перевороту на світовому рівні.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Для оптимізації виробничого процесу було до дрібниць продумано і покращено пристрій складального конвеєра, а для скорочення витрат на оплату праці всі автозапчастини Форд були приведені до єдиного стандарту. У підсумку на ринку з\'явилися першокласні, але доступні автомобілі.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Донині компанія поставляє комерційні та легкові моделі і входить до трійки лідерів з продажу автомобілів у Європі та світі.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Оригінальні запчастини Ford (Форд) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Поряд з випуском готової продукції компанія виробляє весь спектр оригінальних автозапчастин Форд. Завдяки масовій популярності бренду ремонт і технічне обслуговування машин не доставляє проблем автовласникам.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">У нашому інтернет-магазині представлений каталог автозапчастин Ford, який охоплює весь сучасний модельний ряд бренду (Mustang, Expedition, Excursion, Focus, Escape, Contour, Explorer, Edge).</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Ми допомагаємо нашим клієнтам купити запчастини Форд за доступними цінами при мінімальних витратах часу. Просто зв\'яжіться з нашими менеджерами або надішліть з сайту VIN-запит і в короткі терміни отримаєте вичерпну інформацію щодо комплектуючих для вашого авто.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (9,NULL,'lincoln-parts','Оригинальні Запчастини Lincoln (Линкольн) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467878143-43e3bf7f37e5aefbe830e97cc80cfcea.png\" style=\"float:left; height:140px; margin-left:4px; margin-right:4px; width:140px\" /></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><span style=\"font-size:18px\"><strong>Linc</strong><strong>oln</strong><strong> &ndash; люксовий бренд</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Компанія Lincoln була заснована 1917 року, а за п\'ять років увійшла до складу концерну Ford, частиною якого залишається дотепер. Завдяки злиттю та фінансовим вливанням цьому бренду класу люкс вдалося втриматися на плаву в епоху депресії та успішно конкурувати з іншими марками престижних авто.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Аж до 70-х років минулого століття розкішні автомобілі Лінкольн користувалися стабільним попитом у представників влади, великого капіталу і навіть криміналітету. Однак із початком паливної кризи компанія переглянула комплектацію моделей. У підсумку &ndash; вузли, агрегати та запчастини Лінкольн були замінені на фордівські комплектуючі.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Незважаючи на здешевлення, автомобілі Lincoln залишилися в обоймі люксових брендів. Особливо яскравою подією став випуск у 1998 році унікального за дизайном і технічними характеристиками представницького позашляховика Лінкольн Навігатор.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">На цьому робота з оновлення модельного ряду не закінчилася. Як результат, 2000-ті роки ознаменувалися появою нового покоління представницьких автомобілів: кросоверів MKX, MKT і МКС, седанів MKZ і MKS.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><strong>Оригінальні запчастини Lincoln (Лінкольн) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Працюючи з перевіреними постачальниками, ми пропонуємо своїм клієнтам запчастини Lincoln виключно високої якості. Купуючи деталі в нашому інтернет-магазині, ви отримуєте їх за справедливою ціною, без додаткових націнок і економите час.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Крім фірмових комплектуючих у нашому асортименті присутні ліцензовані аналоги, які не поступаються оригіналам. Якщо необхідні запчастини на Лінкольн відсутні в каталозі, ми організуємо їх поставку під замовлення.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (10,NULL,'hummer-parts','Запчастини Hummer (Хаммер) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467878592-752f69cefcfa297617a9012f78e0ae5a.jpg\" style=\"float:left; height:90px; margin-left:4px; margin-right:4px; width:140px\" /></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><span style=\"font-size:18px\"><strong>Hummer</strong><strong> &ndash; </strong><strong>впевнений всюдихід</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">У 1992 році компанія &laquo;General Motors&raquo; зайнялася виробництвом цивільних позашляховиків-всюдиходів Hummer. На той час їхні військові аналоги Хамм-ві понад 10 років перебували на озброєнні американської армії і вражали високою прохідністю і надійністю. Цивільна версія постійно модифікувалася, ставала розкішнішою і комфортнішою. За рахунок підвищеної зносостійкості вузлів і запчастин Хаммер вирізнявся незвичайною витривалістю.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Продажі стартували доволі успішно, а нові моделі Hummer H2 і H3 дали змогу компанії помітно їх підвищити. Крім американського ринку автомобілі-всюдиходи отримали визнання в заможних країнах Близького Сходу і навіть на пострадянському просторі. Однак через ненажерливий двигун і неекологічний імідж Хаммер виявився найменш вигідною в комерційному плані маркою концерну.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Зіткнувшись із фінансовими труднощами, власники GM ухвалили рішення про продаж бренду, і 2010 року американський завод припинив виробництво позашляховиків. Після тривалого узгодження торгова марка, патенти, розробки та дилерська мережа перейшли у власність китайської компанії.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\"><strong>Запчастини Hummer (Хаммер) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Для власників потужних солідних позашляховиків завжди актуальна наявність доступних оригінальних запчастин Хаммер. Висока якість деталей - запорука оптимальної працездатності автомобіля і впевненості водія в безпеці.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Представлені в нашому каталозі автозапчастини на Hummer поставляються безпосередньо від перевірених виробників. Завдяки налагодженим прямим поставкам без посередників ризик придбання неліквідних деталей зводиться до нуля.</span></span></p>\r\n\r\n<p><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"color:#000000\">Зв\'яжіться з нашими менеджерами або надішліть VIN-запит і отримайте повну інформацію про запчастини на Хаммер, які вас цікавлять.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (11,NULL,'pontiac-parts','Запчастини Pontiac (Понтиак) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467882650-dda79ed2c6fcd8625f6f1e051bd1b46e.jpg\" style=\"float:left; height:120px; margin-left:4px; margin-right:4px; width:120px\" /><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"font-size:18px\"><strong>Pontiac &ndash; культовий автомобіль</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Американський бренд Понтіак по праву вважається культовим і подарував світові низку легендарних моделей, які сьогодні входять до колекцій справжніх автолюбителів. Почалося все із заснування в 1983 році компанії з виробництва екіпажів, але самостійна історія, як автомобільної марки, стартувала тільки в 1926. На той момент бренд уже був частиною концерну General Motors, а корпуси і деякі запчастини Pontiac були взаємозамінні з машинами Chevrolet.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Після виходу на ринок популярної моделі Silver Streak бренд стає впізнаваним і впродовж наступних десятиліть залишається одним із найбільш затребуваних. Модельні лінійки регулярно оновлюються відповідно до очікувань публіки і технічних досягнень різних епох. При цьому переглядаються концепції проектування автомобілів, змінюється їхній дизайн, комплектація і запчастини для Понтіак.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Аж до 2010 року, в якому припинилося виробництво машин цього бренду, підрозділ Pontiac випускає різні моделі. Незважаючи на закриття, марка є однією з найяскравіших і найпопулярніших в історії автомобілебудування.</span></span></p>\r\n\r\n<p><span style=\"font-size:18px\"><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Запчастини Pontiac (Понтіак) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">У процесі підбору комплектуючих для автомобіля досвідчені водії вважають за краще довіритися фахівцям.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Консультанти нашого інтернет-магазину допоможуть уникнути помилок і купити автозапчастини Понтіак високої якості за оптимальною ціною.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Ви можете знайти необхідну деталь самостійно в електронному каталозі запчастин Понтіак або відправити VIN-запит з нашого сайту для обробки вашого замовлення менеджерами.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (12,NULL,'jeep-parts','Запчастини Jeep (Джип) в Україні','<p><img alt=\"\" src=\"/userfiles/image/1467882858-3a3a8ece11ae4286f00d9604dd2ac3a8.jpg\" style=\"float:left; height:120px; margin-left:4px; margin-right:4px; width:120px\" /></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\"><span style=\"font-size:18px\"><strong>Jeep</strong> <strong>&ndash; військова легенда</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Історія Jeep, одного з найпопулярніших у світі брендів, почалася в передвоєнні роки. Американська армія оголосила тендер на поставку повнопривідних автомобілів підвищеної прохідності й отримала кілька пропозицій. Після випробувань і модернізації на озброєнні залишили позашляховик компанії Willys, що отримав згодом назву Jeep. Запчастини для нього вирізнялися підвищеною зносостійкістю, вантажопідйомність перевищувала 200 кг, при цьому машина вийшла багатофункціональною і пристосованою до суворого бездоріжжя.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Після закінчення війни компанія починає розробку і випуск цивільних позашляховиків на базі армійської моделі. На початку 50-х років Jeep стає офіційною міжнародною маркою, а Willys переходить у власність корпорації Kaiser. Наступний період ознаменувався появою першого повнопривідного автомобіля Jeep Wagoneer з автоматичною коробкою передач.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Новий виток розвитку настав після об\'єднання з концернами American Motors і Chrysler. У 1974 році народжується нова &laquo;зірка&raquo; бренду &ndash; Cherokee.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-size:18px\"><span style=\"font-family:tahoma,geneva,sans-serif\"><strong>Запчастини Jeep (Джип) в Україні</strong></span></span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Для регулярного технічного обслуговування власники автомобілів такого класу потребують оригінальних комплектуючих від надійних постачальників. У нашому асортименті тільки якісні запчастини на Jeep Гранд Черокі, Коммандер, Ліберті, Вранглер та інші моделі бренду.</span></span></p>\r\n\r\n<p><span style=\"color:#000000\"><span style=\"font-family:tahoma,geneva,sans-serif\">Щоб вибрати автозапчастини Джип, скористайтеся пошуком по електронному каталогу інтернет-магазину або надішліть заповнений VIN-запит нашим менеджерам, які оперативно опрацюють заявку і зв\'яжуться з вами.</span></span></p>','',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (13,NULL,'new-auto-parts','Нові запасні частини для американських автомобілів','<p>Запрошуємо вас в наш магазин \"<strong>AmericanCars</strong>\", де ви знайдете найширший вибір нових запасних частин для американських автомобілів. Ми розуміємо, наскільки важливо для вас забезпечити свій автомобіль надійними деталями, і саме тому ми пропонуємо вам тільки високоякісні продукти від провідних виробників.</p>\n<p>Наш асортимент включає в себе:</p>\n<ol style=\"list-style: decimal;margin-left: 20pt;\">\n	<li>\n		<p><strong>Двигун та трансмісія:</strong> Ми маємо запасні частини для двигунів, коробок передач, ременів, і фільтрів.</p>\n	</li>\n	<li>\n		<p><strong>Системи охолодження та обігріву:</strong> Ви знайдете радіатори, термостати, насоси, і обігрівачі для всіх популярних моделей.</p>\n	</li>\n	<li>\n		<p><strong>Гальмівна система:</strong> Ми пропонуємо гальмівні диски, колодки, гальмівні шланги та багато іншого.</p>\n	</li>\n	<li>\n		<p><strong>Електрика та освітлення:</strong> Замініть дефектні лампи, акумулятори, стартери і генератори.</p>\n	</li>\n	<li>\n		<p><strong>Ходова частина:</strong> Ваша безпека на дорозі наш пріоритет. Ми пропонуємо амортизатори, рульові тяги, шарові опори та інше.</p>\n	</li>\n</ol>\n<p>У нас ви отримаєте не тільки високоякісні запчастини, але і відмінний сервіс клієнтів. Наші фахівці завжди готові вас порадити та допомогти з вибором необхідних деталей.</p>\n<p>Не вагайтесь завітати до нас сьогодні, і ваш автомобіль буде готовий завжди тримати вас на дорозі!</p>','Купити нові запчастини для американських автомобілів. Широкий асортимент запчастин на американські автомобілі',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1),
    (14,NULL,'used-auto-parts','Вживані Запчастини для американських автомобілів','<p>Ласкаво просимо до нашого магазину \"<strong>AmericanCars</strong>\"! Ми спеціалізуємося на наданні надійних вживаних запасних частин для американських автомобілів. Наш асортимент включає в себе:</p>\n<ol style=\"list-style: decimal;margin-left: 20pt;\">\n	<li>\n		<p><strong>Двигун та трансмісія:</strong> Від двигунів до коробок передач, у нас є відмінні вживані запчастини для вашого авто.</p>\n	</li>\n	<li>\n		<p><strong>Кузовні деталі:</strong> Знайдіть двері, крила, бампери та інші кузовні деталі, щоб відновити зовнішній вигляд свого автомобіля.</p>\n	</li>\n	<li>\n		<p><strong>Ходова частина:</strong> Важливість правильного ходового обладнання не можна недооцінювати. Ми маємо амортизатори, рульові тяги та інше.</p>\n	</li>\n	<li>\n		<p><strong>Електрика та освітлення:</strong> Знайдіть ефективні вживані батареї, стартери та лампи для забезпечення безперебійної роботи вашого автомобіля.</p>\n	</li>\n</ol>\n<p>Наша команда спеціалістів готова вас консультувати та допомагати з вибором потрібних деталей. Ми завжди готові забезпечити вас якісними запасними частинами за доступними цінами. Важливо для нас, щоб ваш автомобіль завжди був в хорошому стані, і ми гарантуємо якість наших вживаних запасних частин. Звертайтеся до нас сьогодні і подбайте про свій автомобіль разом з нами!</p>','Запчастини вживані для американських авто.',NULL,NULL,NULL,'2023-09-28 10:11:21',NULL,1);

/*!40000 ALTER TABLE `static_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table static_page_lang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `static_page_lang`;

CREATE TABLE `static_page_lang` (
                                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_model` int(11) unsigned NOT NULL,
                                    `id_lang` tinyint(1) NOT NULL,
                                    `title` varchar(255) DEFAULT NULL,
                                    `content` text,
                                    `meta_title` varchar(255) DEFAULT NULL,
                                    `meta_keywords` text,
                                    `meta_description` text,
                                    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;



# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
                                `id` int(11) unsigned NOT NULL,
                                `paid_by` int(11) unsigned NOT NULL,
                                `paid_to` int(11) unsigned NOT NULL,
                                `amount` decimal(5,2) unsigned NOT NULL,
                                `trdate` datetime NOT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `id_branch` int(11) DEFAULT NULL,
                        `id_warehouse` int(11) DEFAULT NULL,
                        `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                        `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                        `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `status` smallint(6) NOT NULL DEFAULT '10',
                        `role` int(11) NOT NULL DEFAULT '10',
                        `created_at` int(11) NOT NULL,
                        `updated_at` int(11) NOT NULL,
                        `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `username` (`username`),
                        UNIQUE KEY `email` (`email`),
                        UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `id_branch`, `id_warehouse`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `name`, `status`, `role`, `created_at`, `updated_at`, `verification_token`)
VALUES
    (1,'9407674@gmail.com',NULL,NULL,'Qk1MBK4TujX1LMwu4mTBWHsTBUJ-5DeI','$2y$13$Q9C2XpE0j.gt5scbGorlj.axkgOpq7XJQXBpLmCpm.wjeLbZBi55e','hvjb91jx2U4qPpXItywYFGwKcwl5ELaN_1655125340','9407674@gmail.com','Розробник Олег',10,20,1618480037,1655125340,'bopBD5IpXO6YSekndcxZ3goFsbZPNAex_1618480037'),
    (2,'autogroup2013@gmail.com',NULL,NULL,'Qk1MBK4TujX1LMwu4mTBWHsTBUJ-5DeI','$2y$13$Q9C2XpE0j.gt5scbGorlj.axkgOpq7XJQXBpLmCpm.wjeLbZBi55e',NULL,'autogroup2013@gmail.com','Лісовий Євгеній',10,20,1618480037,1652434323,''),
    (463,'aa0957007927@gmail.com',NULL,NULL,'_cvwKTTQfWT7FxPLMCRMAMejn5CUMOI3','$2y$13$W2jNQzmKvYvJwUG0h5kfBOn.ukEvxnH.PdwQTedGsuIjnJuSee8I6',NULL,'aa0957007927@gmail.com',NULL,10,10,1652354240,1652354240,'9f3t8jnAj5BjhtKIOFP7O4-ji5if_0EQ_1652354240');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table vendor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
                          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `name` varchar(255) NOT NULL,
                          `url` varchar(255) DEFAULT '',
                          `site` varchar(255) DEFAULT '',
                          `logo` varchar(255) DEFAULT '',
                          `prod_count` int(10) unsigned DEFAULT NULL,
                          `status` tinyint(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;

INSERT INTO `vendor` (`id`, `name`, `url`, `site`, `logo`, `prod_count`, `status`)
VALUES
    (1,'Americancars','https://americancars.com.ua/price.xlsx','https://americancars.com.ua/','',NULL,1),
    (2,'usamotors','','https://usamotors.com.ua/','',NULL,1),
    (3,'Америка','','','',NULL,1),
    (4,'Європа','','','',NULL,1),
    (5,'Омега','','','',NULL,1),
    (6,'Інтеркарс','','','',NULL,1),
    (7,'Польша Д','','','',NULL,1),
    (8,'Автотехнікс','','','',NULL,1),
    (9,'Рокавто','','','',NULL,1),
    (10,'Ебей','','','',NULL,1);

/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vin_request
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vin_request`;

CREATE TABLE `vin_request` (
                               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `vin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `make` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `engine` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `question` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `status` tinyint(1) NOT NULL DEFAULT '1',
                               `created_at` timestamp NULL DEFAULT NULL,
                               `updated_at` timestamp NULL DEFAULT NULL,
                               PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table warehouse
# ------------------------------------------------------------

DROP TABLE IF EXISTS `warehouse`;

CREATE TABLE `warehouse` (
                             `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(255) NOT NULL DEFAULT '',
                             `alias` varchar(255) DEFAULT NULL,
                             `color` varchar(8) DEFAULT NULL,
                             `region` varchar(255) NOT NULL DEFAULT '',
                             `delivery_time` varchar(255) NOT NULL DEFAULT '',
                             `delivery_price` float NOT NULL,
                             `delivery_terms` varchar(255) NOT NULL DEFAULT '',
                             `extra_charge` tinyint(4) NOT NULL,
                             `currency` char(3) NOT NULL DEFAULT '',
                             `is_new` tinyint(1) NOT NULL DEFAULT '1',
                             `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `price_updated` timestamp NULL DEFAULT NULL,
                             `status` tinyint(1) NOT NULL DEFAULT '1',
                             PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `warehouse` WRITE;
/*!40000 ALTER TABLE `warehouse` DISABLE KEYS */;

INSERT INTO `warehouse` (`id`, `name`, `alias`, `color`, `region`, `delivery_time`, `delivery_price`, `delivery_terms`, `extra_charge`, `currency`, `is_new`, `ts`, `price_updated`, `status`)
VALUES
    (37,'FTP PARTAUTIORITI','Склад P',NULL,'USA','14 днів',0,'',70,'USD',1,'2022-04-18 17:26:34',NULL,1),
    (34,'Основний','Склад 1','purple','UA','В наявності',0,'',10,'USD',1,'2022-04-18 17:26:34',NULL,0),
    (30,'usamotors','Склад U','pink','UA','В наявності',0,'',10,'USD',1,'2022-04-28 11:32:39','2024-11-30 13:00:07',1),
    (35,'Sofia','Склад S','cyan','UA','В наявності',0,'',10,'USD',1,'2023-12-12 21:15:35','2024-06-09 19:00:05',1);

/*!40000 ALTER TABLE `warehouse` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table warehouse_place
# ------------------------------------------------------------

DROP TABLE IF EXISTS `warehouse_place`;

CREATE TABLE `warehouse_place` (
                                   `id` int(11) NOT NULL AUTO_INCREMENT,
                                   `id_warehouse` int(11) NOT NULL,
                                   `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                                   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `warehouse_place` WRITE;
/*!40000 ALTER TABLE `warehouse_place` DISABLE KEYS */;

INSERT INTO `warehouse_place` (`id`, `id_warehouse`, `name`)
VALUES
    (1,35,'D01 підлога'),
    (2,35,'D02'),
    (3,35,'D03'),
    (4,35,'D04'),
    (5,35,'D05'),
    (6,35,'D06 підлога'),
    (7,35,'D07'),
    (8,35,'D08'),
    (9,35,'D09'),
    (10,35,'D10'),
    (11,35,'D11 підлога'),
    (12,35,'D12'),
    (13,35,'D13'),
    (14,35,'D14'),
    (15,35,'D15'),
    (16,35,'D16 підлога'),
    (17,35,'D17'),
    (18,35,'D18'),
    (19,35,'D19'),
    (20,35,'D20'),
    (21,35,'D21 підлога'),
    (22,35,'D22'),
    (23,35,'D23'),
    (24,35,'D24'),
    (25,35,'D25 підлога'),
    (26,35,'D26'),
    (27,35,'D27'),
    (28,35,'D28'),
    (29,35,'D29 підлога'),
    (30,35,'D30'),
    (31,35,'D31'),
    (32,35,'D32'),
    (33,35,'D33 підлога'),
    (34,35,'D34'),
    (35,35,'D35'),
    (36,35,'D36'),
    (37,35,'D37 підлога'),
    (38,35,'D38'),
    (39,35,'D39'),
    (40,35,'D40'),
    (41,35,'C01 підлога'),
    (42,35,'C02'),
    (43,35,'C03'),
    (44,35,'C04'),
    (45,35,'C05'),
    (46,35,'C06 підлога'),
    (47,35,'C07'),
    (48,35,'C08'),
    (49,35,'C09'),
    (50,35,'C10'),
    (51,35,'C11 підлога'),
    (52,35,'C12'),
    (53,35,'C13'),
    (54,35,'C14'),
    (55,35,'C15'),
    (56,35,'C16 підлога'),
    (57,35,'C17'),
    (58,35,'C18'),
    (59,35,'C19'),
    (60,35,'C20'),
    (61,35,'C21 підлога'),
    (62,35,'C22'),
    (63,35,'C23'),
    (64,35,'C24'),
    (65,35,'C25 підлога'),
    (66,35,'C26'),
    (67,35,'C27'),
    (68,35,'C28'),
    (69,35,'C29 підлога'),
    (70,35,'C30'),
    (71,35,'C31'),
    (72,35,'C32'),
    (73,35,'C33 підлога'),
    (74,35,'C34'),
    (75,35,'C35'),
    (76,35,'C36'),
    (77,35,'B01 підлога'),
    (78,35,'B02'),
    (79,35,'B03'),
    (80,35,'B04'),
    (81,35,'B05'),
    (82,35,'B06 підлога'),
    (83,35,'B07'),
    (84,35,'B08'),
    (85,35,'B09'),
    (86,35,'B10'),
    (87,35,'B11 підлога'),
    (88,35,'B12'),
    (89,35,'B13'),
    (90,35,'B14'),
    (91,35,'B15'),
    (92,35,'B16 підлога'),
    (93,35,'B17'),
    (94,35,'B18'),
    (95,35,'B19'),
    (96,35,'B20 підлога'),
    (97,35,'B21'),
    (98,35,'B22'),
    (99,35,'B23'),
    (100,35,'B24 підлога'),
    (101,35,'B25'),
    (102,35,'B26'),
    (103,35,'B27'),
    (104,35,'A01 підлога'),
    (105,35,'A02'),
    (106,35,'A03'),
    (107,35,'A04'),
    (108,35,'A05 підлога'),
    (109,35,'A06'),
    (110,35,'A07'),
    (111,35,'A08'),
    (112,35,'A09 підлога'),
    (113,35,'A10'),
    (114,35,'A11'),
    (115,35,'A12'),
    (116,35,'A13 підлога'),
    (117,35,'A14'),
    (118,35,'A15'),
    (119,35,'A16'),
    (120,35,'A17'),
    (121,35,'A18 підлога'),
    (122,35,'A19'),
    (123,35,'A20'),
    (124,35,'A21'),
    (125,35,'A22'),
    (126,35,'A23 підлога'),
    (127,35,'A24'),
    (128,35,'A25'),
    (129,35,'A26'),
    (130,35,'A27'),
    (131,35,'A28 підлога'),
    (132,35,'A29'),
    (133,35,'A30'),
    (134,35,'A31'),
    (135,35,'A32'),
    (136,35,'A33 підлога'),
    (137,35,'A34'),
    (138,35,'A35'),
    (139,35,'A36'),
    (140,35,'A37'),
    (141,35,'A38 підлога'),
    (142,35,'A39'),
    (143,35,'A40'),
    (144,35,'A41'),
    (145,35,'A42'),
    (146,35,'A43 підлога'),
    (147,35,'A44'),
    (148,35,'A45'),
    (149,35,'A46'),
    (150,35,'A47'),
    (151,35,'A48 підлога'),
    (152,35,'A49'),
    (153,35,'A50'),
    (154,35,'A51'),
    (155,35,'A52 підлога'),
    (156,35,'A53'),
    (157,35,'A54'),
    (158,35,'A55'),
    (159,35,'A56 підлога'),
    (160,35,'A57'),
    (161,35,'A58'),
    (162,35,'A59'),
    (163,35,'A60 підлога'),
    (164,35,'A61'),
    (165,35,'A62'),
    (166,35,'A63'),
    (167,35,'A64 підлога'),
    (168,35,'A65'),
    (169,35,'A66'),
    (170,35,'A67');

SET FOREIGN_KEY_CHECKS = 1;
