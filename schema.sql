-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Generation Time: Aug 18, 2013 at 03:52 PM

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_announcements`
--

CREATE TABLE `bayonet_announcements` (
  `announcement_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bayonet_announcements`
--

INSERT INTO `bayonet_announcements` VALUES(0, 'Untitled', '');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_blocks`
--

CREATE TABLE `bayonet_blocks` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(11) NOT NULL DEFAULT '1',
  `weight` int(11) NOT NULL,
  `position` int(1) NOT NULL,
  `dir_name` varchar(32) NOT NULL,
  `title` varchar(30) NOT NULL,
  PRIMARY KEY (`block_id`),
  KEY `active` (`active`,`weight`,`position`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_blocks`
--

INSERT INTO `bayonet_blocks` VALUES(1, 1, 0, 1, 'rudi', 'RUDI');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_downloads`
--

CREATE TABLE `bayonet_downloads` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL COMMENT 'Can contain a relative path',
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bayonet_downloads`
--


-- --------------------------------------------------------

--
-- Table structure for table `bayonet_downloads_categories`
--

CREATE TABLE `bayonet_downloads_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_downloads_categories`
--

INSERT INTO `bayonet_downloads_categories` VALUES(1, 'General');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_events`
--

CREATE TABLE `bayonet_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `title` varchar(15) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `color` varchar(20) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bayonet_events`
--


-- --------------------------------------------------------

--
-- Table structure for table `bayonet_modules`
--

CREATE TABLE `bayonet_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  `dir_name` varchar(32) NOT NULL,
  `status` enum('Inactive','Active') NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_modules`
--

INSERT INTO `bayonet_modules` VALUES(1, 1, 'news', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_navigation`
--

CREATE TABLE `bayonet_navigation` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(200) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `weight` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_navigation`
--

INSERT INTO `bayonet_navigation` VALUES(1, '?load=page&id=1', 'Example page', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_news`
--

CREATE TABLE `bayonet_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `edited` datetime DEFAULT NULL,
  `edited_id` int(10) DEFAULT NULL,
  `category_id` int(6) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_news`
--

INSERT INTO `bayonet_news` VALUES(1, 1, 'Hello World', 'This is a default news article.', '2013-02-10 15:24:14', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_newsreel`
--

CREATE TABLE `bayonet_newsreel` (
  `slide_id` int(6) NOT NULL AUTO_INCREMENT,
  `src` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `visible` int(1) NOT NULL DEFAULT '0',
  `weight` int(10) NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bayonet_newsreel`
--


-- --------------------------------------------------------

--
-- Table structure for table `bayonet_news_categories`
--

CREATE TABLE `bayonet_news_categories` (
  `category_id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `image` varchar(80) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_news_categories`
--

INSERT INTO `bayonet_news_categories` VALUES(1, 'General News', '');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_news_comments`
--

CREATE TABLE `bayonet_news_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `news_id` int(10) NOT NULL,
  `author_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `message` varchar(1000) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bayonet_news_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `bayonet_pages`
--

CREATE TABLE `bayonet_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `page_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(254) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_pages`
--

INSERT INTO `bayonet_pages` VALUES(1, 1, '2008-06-24 04:23:56', 'Example Page', 'Lorem ipsum');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_settings`
--

CREATE TABLE `bayonet_settings` (
  `setting_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `index_modules` varchar(100) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_settings`
--

INSERT INTO `bayonet_settings` VALUES(1, 'Default', 'news');

-- --------------------------------------------------------

--
-- Table structure for table `bayonet_users`
--

CREATE TABLE `bayonet_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level` int(2) NOT NULL DEFAULT '1',
  `all` tinyint(2) NOT NULL,
  `squadleader` tinyint(2) NOT NULL,
  `adjutant` tinyint(2) NOT NULL,
  `quartermaster` tinyint(2) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bayonet_users`
--

INSERT INTO `bayonet_users` VALUES(1, 'admin', 'iayTBD/gOOmYs', 'Admin', 'Bayonet', 'admin@example.com', '2009-10-04 09:11:50', 3, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_awards`
--

CREATE TABLE `rudi_awards` (
  `award_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `weight` int(5) NOT NULL,
  PRIMARY KEY (`award_id`),
  KEY `idx_awards` (`name`,`image`,`description`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `rudi_awards`
--

INSERT INTO `rudi_awards` VALUES(1, 1, 'Distinguished Service Cross', 'DSC.jpg', 'Awarded to those who are exceptional in every regard. The highest honor attainable in the 3rd Infantry Division.', 1);
INSERT INTO `rudi_awards` VALUES(2, 1, 'Silver Star', 'silverstar.jpg', 'Awarded for an act of incredible skill and courage which turns the tide of battle and is inarguably a main factor in our victory in a match.', 3);
INSERT INTO `rudi_awards` VALUES(3, 1, 'Legion of Merit', 'legionofmerit.jpg', 'Awarded for outstanding work on defense.', 4);
INSERT INTO `rudi_awards` VALUES(4, 1, 'Soldiers Medal', 'soldiers.jpg', 'Awarded for creating an ingenious plan for a match that ensures our victory.', 6);
INSERT INTO `rudi_awards` VALUES(5, 1, 'Bronze Star', 'bronzestar.jpg', 'Awarded for an act of incredible skill and courage during a match.', 5);
INSERT INTO `rudi_awards` VALUES(7, 1, 'Army Good Conduct Medal', 'goodconduct.jpg', 'Awarded for outstanding conduct in and out of game.', 16);
INSERT INTO `rudi_awards` VALUES(8, 1, 'Exemplary Attendance Medal', 'exempattendance.jpg', 'Awarded for participated in many division functions and showing up on time.', 13);
INSERT INTO `rudi_awards` VALUES(10, 1, 'Army Service Ribbon', 'armyservice.jpg', 'The Army Service Ribbon is awarded to members of the Army, Army Reserve, and Army National Guard for successful completion of initial-entry training.', 21);
INSERT INTO `rudi_awards` VALUES(11, 1, 'Global War on Terrorism Service Medal', 'gwotsm.jpg', 'Awarded for participating in the Armed Global Warfare - C2 theater of operations.', 18);
INSERT INTO `rudi_awards` VALUES(13, 1, 'National Defense Service Medal', 'nationaldefense.jpg', 'Awarded for serving in a successful military campaign in which the 3rd ID actively participated in.', 19);
INSERT INTO `rudi_awards` VALUES(14, 1, 'Army Commendation Medal', 'armycommendation.jpg', 'Awards may be made for acts of valor performed under a lesser degree than required for award of the Bronze Star or in noncombatant-related heroism.', 14);
INSERT INTO `rudi_awards` VALUES(15, 1, 'Army Achievement Medal', 'armyachievement.jpg', 'Awarded while serving in any capacity with the Army in a non-combat area, distinguished himself by meritorious service or achievement of a lesser degree than required for award of the Army Commendation Medal.', 15);
INSERT INTO `rudi_awards` VALUES(16, 3, 'Valor Device', 'valor_device.png', 'The Valor Device or "Combat V" is displayed on a ribbon (in the case of the 3rd Infantry Division, the Bronze Star Medal) to denote that the medal was awarded as a result of combat with another unit rather than for non-combat related activities.', 0);
INSERT INTO `rudi_awards` VALUES(19, 2, 'Day of Defeat Distinguished Unit Citation', 'MUC.jpg', 'Day of Defeat Distinguished Unit Citation awarded to soldiers who where part of the 3rd ID during the Day of Defeat Campaign.', 0);
INSERT INTO `rudi_awards` VALUES(20, 2, 'Call of Duty Distinguished Unit Citation', 'codduc.jpg', 'Call of Duty Unit Citation awarded to soldiers who where part of the 3rd ID during the Call of Duty Campaign.', 0);
INSERT INTO `rudi_awards` VALUES(21, 2, 'Call of Duty 2 Distinguished Unit Citation', 'cod2duc.jpg', 'Call of Duty 2 Unit Citation awarded to soldiers who were part of the 3rd ID during the Call of Duty 2 Campaign.', 0);
INSERT INTO `rudi_awards` VALUES(22, 2, 'Call of Duty 4 Distinguished Unit Citation', 'cod4duc.jpg', 'Call of Duty 4 Unit Citation awarded to soldiers who were part of the 3rd ID during the Call of Duty 4 Campaign.', 0);
INSERT INTO `rudi_awards` VALUES(23, 4, 'Combat Infantry Badge - 1st Award', 'cib1.png', 'Participating in 8 engagements on the battlefield during a campaign.', 2);
INSERT INTO `rudi_awards` VALUES(24, 4, 'Combat Infantry Badge - 2nd Award', 'cib2.png', 'Participating in 12 engagements on the battlefield during a campaign.', 3);
INSERT INTO `rudi_awards` VALUES(25, 4, 'Combat Infantry Badge - 3rd Award', 'cib3.png', 'Participating in 24 engagements on the battlefield during a campaign.', 4);
INSERT INTO `rudi_awards` VALUES(26, 4, 'Combat Infantry Badge - 4th Award', 'cib4.png', 'Participating in 30 engagements on the battlefield during a campaign.', 5);
INSERT INTO `rudi_awards` VALUES(29, 4, 'Expert Infantryman Badge', 'eib.png', 'Participating in 4 engagements on the battlefield during a campaign.', 1);
INSERT INTO `rudi_awards` VALUES(30, 2, 'ArmA2 Distinguished Unit Citation ', 'arma2duc.jpg', 'ArmA 2 Unit Citation awarded to soldiers who were part of the 3rd ID during the ArmA 2 Campaign. ', 5);
INSERT INTO `rudi_awards` VALUES(31, 1, 'Armed Forces Expeditionary Medal', 'afem.jpg', 'Awarded for participating in the Armed Global Warfare - Panthera Rising theater of operations.', 17);
INSERT INTO `rudi_awards` VALUES(32, 4, 'Combat Medical Badge', '', 'This badge is awarded to soldiers who have successfully completed the medical training course.', 6);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_award_classes`
--

CREATE TABLE `rudi_award_classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rudi_award_classes`
--

INSERT INTO `rudi_award_classes` VALUES(1, 'Medal');
INSERT INTO `rudi_award_classes` VALUES(2, 'Citation');
INSERT INTO `rudi_award_classes` VALUES(3, 'Device');
INSERT INTO `rudi_award_classes` VALUES(4, 'Badge');

-- --------------------------------------------------------

--
-- Table structure for table `rudi_award_record`
--

CREATE TABLE `rudi_award_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `record_note` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `member_id` (`member_id`,`date_added`,`record_note`,`added_by`,`award_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=159 ;

--
-- Dumping data for table `rudi_award_record`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_classes`
--

CREATE TABLE `rudi_classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `idx_classes` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rudi_classes`
--

INSERT INTO `rudi_classes` VALUES(1, 'Soldier');
INSERT INTO `rudi_classes` VALUES(2, 'JNCO');
INSERT INTO `rudi_classes` VALUES(3, 'NCO');
INSERT INTO `rudi_classes` VALUES(5, 'OIC');
INSERT INTO `rudi_classes` VALUES(4, 'SNCO');
INSERT INTO `rudi_classes` VALUES(6, 'SOIC');

-- --------------------------------------------------------

--
-- Table structure for table `rudi_combat_record`
--

CREATE TABLE `rudi_combat_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `war_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `member_id` (`member_id`),
  KEY `idx_combatrecord` (`war_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_combat_record`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_combat_units`
--

CREATE TABLE `rudi_combat_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `detachment` int(11) NOT NULL,
  `type` enum('Company','Platoon','Squad','Fireteam') NOT NULL,
  `leader_id` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  `callsign` varchar(25) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rudi_combat_units`
--

INSERT INTO `rudi_combat_units` VALUES(1, 'Unit', 0, 'Company', 2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `rudi_countries`
--

CREATE TABLE `rudi_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `image` varchar(30) NOT NULL,
  PRIMARY KEY (`country_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Member country' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rudi_countries`
--

INSERT INTO `rudi_countries` VALUES(1, 'United States', 'usa.gif');
INSERT INTO `rudi_countries` VALUES(2, 'Austrailia', 'austrailia.gif');
INSERT INTO `rudi_countries` VALUES(3, 'Canada', 'canada.gif');
INSERT INTO `rudi_countries` VALUES(4, 'Germany', 'germany.gif');
INSERT INTO `rudi_countries` VALUES(5, 'Israel', 'israel.gif');
INSERT INTO `rudi_countries` VALUES(6, 'Japan', 'japan.gif');
INSERT INTO `rudi_countries` VALUES(7, 'Korea', 'korea.gif');
INSERT INTO `rudi_countries` VALUES(8, 'Mexico', 'mexico.gif');
INSERT INTO `rudi_countries` VALUES(9, 'Russia', 'russia.gif');
INSERT INTO `rudi_countries` VALUES(10, 'United Kingdom', 'uk.gif');

-- --------------------------------------------------------

--
-- Table structure for table `rudi_drills`
--

CREATE TABLE `rudi_drills` (
  `drill_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `news` text,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`drill_id`),
  KEY `date` (`date`,`notes`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_drills`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_drills_record`
--

CREATE TABLE `rudi_drills_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `drill_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `performance` int(11) NOT NULL,
  `excusal` tinyint(1) NOT NULL,
  `excusal_reason` text NOT NULL,
  `initiative` int(11) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `member_id` (`member_id`,`performance`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_drills_record`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_platoons`
--

CREATE TABLE `rudi_platoons` (
  `platoon_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `creed` varchar(50) NOT NULL,
  `bio` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`platoon_id`),
  KEY `idx_platoons` (`unit_id`,`name`,`leader_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_platoons`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_ranks`
--

CREATE TABLE `rudi_ranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `shortname` varchar(3) NOT NULL,
  `longname` varchar(255) NOT NULL,
  `image` varchar(30) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`rank_id`),
  KEY `idx_rank` (`class_id`,`shortname`,`longname`,`weight`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `rudi_ranks`
--

INSERT INTO `rudi_ranks` VALUES(1, 1, 1, 'PVT', 'Private', 'PVT.png', 1);
INSERT INTO `rudi_ranks` VALUES(2, 1, 1, 'PV2', 'Private Second Class', 'PV2.png', 2);
INSERT INTO `rudi_ranks` VALUES(3, 1, 1, 'PFC', 'Private First Class', 'PFC.png', 3);
INSERT INTO `rudi_ranks` VALUES(4, 1, 1, 'SPC', 'Specialist', 'SPC.png', 4);
INSERT INTO `rudi_ranks` VALUES(5, 2, 1, 'CPL', 'Corporal', 'CPL.png', 5);
INSERT INTO `rudi_ranks` VALUES(6, 3, 1, 'SGT', 'Sergeant', 'SGT.png', 6);
INSERT INTO `rudi_ranks` VALUES(7, 3, 1, 'SSG', 'Staff Sergeant', 'SSG.png', 7);
INSERT INTO `rudi_ranks` VALUES(8, 4, 0, 'SFC', 'Sergeant First Class', 'SFC.png', 8);
INSERT INTO `rudi_ranks` VALUES(9, 4, 0, 'MSG', 'Master Sergeant', 'MSG.png', 9);
INSERT INTO `rudi_ranks` VALUES(10, 4, 1, '1SG', '1st Sergeant', '1SG.png', 10);
INSERT INTO `rudi_ranks` VALUES(11, 4, 0, 'SGM', 'Sergeant Major', 'SGM.png', 11);
INSERT INTO `rudi_ranks` VALUES(12, 4, 0, 'CSM', 'Command Sergeant Major', 'CSM.png', 12);
INSERT INTO `rudi_ranks` VALUES(13, 4, 0, 'SMA', 'Sergeant Major of the Army', 'SMA.png', 13);
INSERT INTO `rudi_ranks` VALUES(14, 5, 1, '2LT', '2nd Lieutenant', '2LT.png', 14);
INSERT INTO `rudi_ranks` VALUES(15, 5, 1, '1LT', '1st Lieutenant', '1LT.png', 15);
INSERT INTO `rudi_ranks` VALUES(16, 5, 1, 'CPT', 'Captain', 'CPT.png', 16);
INSERT INTO `rudi_ranks` VALUES(17, 5, 0, 'MAJ', 'Major', 'MAJ.png', 17);
INSERT INTO `rudi_ranks` VALUES(18, 6, 0, 'LTC', 'Lieutenant Colonel', 'LTC.png', 18);
INSERT INTO `rudi_ranks` VALUES(19, 6, 0, 'COL', 'Colonel', 'COL.png', 19);
INSERT INTO `rudi_ranks` VALUES(20, 6, 0, 'BG', 'Brigadier General', 'BG.png', 20);
INSERT INTO `rudi_ranks` VALUES(21, 6, 0, 'MJ', 'Major General', 'MJ.png', 21);
INSERT INTO `rudi_ranks` VALUES(22, 6, 0, 'LTG', 'Lieutenant General', 'LTG.png', 22);
INSERT INTO `rudi_ranks` VALUES(23, 6, 0, 'GEN', 'General', 'GEN.png', 23);
INSERT INTO `rudi_ranks` VALUES(24, 1, 1, 'RCT', 'Recruit', 'RCT.png', 0);
INSERT INTO `rudi_ranks` VALUES(26, 5, 1, 'CW2', 'Chief Warrant Officer', 'CW2.png', 13);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_roles`
--

CREATE TABLE `rudi_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `rclass_id` int(10) NOT NULL,
  `weight` int(10) NOT NULL,
  PRIMARY KEY (`role_id`),
  KEY `idx_role_names` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `rudi_roles`
--

INSERT INTO `rudi_roles` VALUES(2, 'Senior Sergeant', 1, 3);
INSERT INTO `rudi_roles` VALUES(3, 'Squad Leader', 2, 1);
INSERT INTO `rudi_roles` VALUES(4, 'Team Leader', 2, 3);
INSERT INTO `rudi_roles` VALUES(6, 'Commanding Officer', 1, 1);
INSERT INTO `rudi_roles` VALUES(7, 'Executive Officer', 1, 2);
INSERT INTO `rudi_roles` VALUES(9, 'Automatic Rifleman', 2, 4);
INSERT INTO `rudi_roles` VALUES(10, 'Grenadier', 2, 5);
INSERT INTO `rudi_roles` VALUES(11, 'Rifleman', 2, 6);
INSERT INTO `rudi_roles` VALUES(12, 'Machine Gunner', 4, 4);
INSERT INTO `rudi_roles` VALUES(13, 'Anti-Armor Gunner', 4, 2);
INSERT INTO `rudi_roles` VALUES(14, 'Marksman', 4, 1);
INSERT INTO `rudi_roles` VALUES(15, 'Combat Medic', 5, 3);
INSERT INTO `rudi_roles` VALUES(16, 'Machine Gun Assistant', 4, 5);
INSERT INTO `rudi_roles` VALUES(17, 'Anti-Armor Assistant', 4, 3);
INSERT INTO `rudi_roles` VALUES(18, 'Senior Medic', 5, 1);
INSERT INTO `rudi_roles` VALUES(19, 'Squad Medic', 5, 2);
INSERT INTO `rudi_roles` VALUES(20, 'Medical Trainee', 5, 4);
INSERT INTO `rudi_roles` VALUES(21, 'Recruit', 2, 7);
INSERT INTO `rudi_roles` VALUES(22, 'Assistant Squad Leader', 2, 2);
INSERT INTO `rudi_roles` VALUES(25, 'Chief Logistics Officer', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_roles_container`
--

CREATE TABLE `rudi_roles_container` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `role_id` (`role_id`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_roles_container`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_role_classes`
--

CREATE TABLE `rudi_role_classes` (
  `rclass_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `weight` int(10) NOT NULL,
  PRIMARY KEY (`rclass_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rudi_role_classes`
--

INSERT INTO `rudi_role_classes` VALUES(1, 'Command Roles', 1);
INSERT INTO `rudi_role_classes` VALUES(2, 'Squad Roles', 2);
INSERT INTO `rudi_role_classes` VALUES(4, 'Specialized', 4);
INSERT INTO `rudi_role_classes` VALUES(5, 'Medical Roles', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_service_record`
--

CREATE TABLE `rudi_service_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `record_note` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `member_id` (`member_id`,`date_added`,`added_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_service_record`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_squads`
--

CREATE TABLE `rudi_squads` (
  `squad_id` int(11) NOT NULL AUTO_INCREMENT,
  `platoon_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `logo` varchar(32) NOT NULL,
  `creed` varchar(32) NOT NULL,
  PRIMARY KEY (`squad_id`),
  UNIQUE KEY `idx_squads` (`name`,`creed`),
  KEY `idx_squads_ids` (`platoon_id`,`leader_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_squads`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_statuses`
--

CREATE TABLE `rudi_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `desc` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `name` (`name`,`desc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `rudi_statuses`
--

INSERT INTO `rudi_statuses` VALUES(1, 1, 'Active', NULL);
INSERT INTO `rudi_statuses` VALUES(2, 2, 'Leave', 'Soldier has been authorized to put down his duties for a short period of time.');
INSERT INTO `rudi_statuses` VALUES(3, 3, 'Extended Leave', 'Soldier has been authorized to put down his duties for a long period of time.');
INSERT INTO `rudi_statuses` VALUES(4, 5, 'General Discharge', 'Soldier''s record does not warrant an Honorable Discharge status.');
INSERT INTO `rudi_statuses` VALUES(5, 4, 'Honorable Discharge', 'Soldier''s records and conduct were outstanding.');
INSERT INTO `rudi_statuses` VALUES(6, 6, 'Dishonorable Discharge', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rudi_units`
--

CREATE TABLE `rudi_units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `leader_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `creed` varchar(50) NOT NULL,
  `bio` text,
  PRIMARY KEY (`unit_id`),
  UNIQUE KEY `idx_units` (`name`),
  KEY `idx_units_leader` (`leader_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_units`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_unit_members`
--

CREATE TABLE `rudi_unit_members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `platoon_id` int(11) NOT NULL,
  `squad_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `weapon_id` int(11) NOT NULL,
  `weapon2_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `a2_id` int(10) NOT NULL,
  `oa_id` int(10) NOT NULL,
  `image` varchar(30) DEFAULT NULL COMMENT 'member profile image',
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(96) DEFAULT NULL,
  `xfire` varchar(30) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `location_city` varchar(32) NOT NULL,
  `location_province` varchar(32) NOT NULL,
  `bio` text NOT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `date_enlisted` datetime NOT NULL,
  `date_discharged` datetime DEFAULT NULL,
  `date_promotion` datetime NOT NULL,
  `points` int(11) NOT NULL DEFAULT '100',
  `drillcount` tinyint(3) NOT NULL,
  `attendcount` tinyint(3) NOT NULL,
  `cunit_id` int(11) NOT NULL,
  `primary_mos` varchar(5) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `idx_unit_member_credentials` (`username`,`email`),
  KEY `idx_unit_member_units` (`unit_id`,`platoon_id`,`squad_id`,`team_id`,`status_id`,`rank_id`,`country_id`),
  KEY `idx_unit_member_dates` (`date_of_birth`,`date_enlisted`,`date_discharged`,`date_promotion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rudi_unit_members`
--

INSERT INTO `rudi_unit_members` VALUES(1, 1, 2, 0, 0, 2, 5, 0, 1, 1, 11, 0, 0, '', '', 'nopassword', 'bayonet@example.com', '', 'Bayonet', 'Soldier', '', '', '', '0000-00-00 00:00:00', '1969-12-31 00:00:00', NULL, '1969-12-31 00:00:00', 100, 0, 0, 1, '11B');

-- --------------------------------------------------------

--
-- Table structure for table `rudi_war_maps`
--

CREATE TABLE `rudi_war_maps` (
  `map_id` int(11) NOT NULL AUTO_INCREMENT,
  `mapname` varchar(100) NOT NULL,
  `mapimage` varchar(100) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  PRIMARY KEY (`map_id`),
  UNIQUE KEY `idx_war_maps` (`mapname`,`mapimage`,`displayname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_war_maps`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_war_stats`
--

CREATE TABLE `rudi_war_stats` (
  `war_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `visit_unit_id` int(11) NOT NULL,
  `map_id` int(11) NOT NULL,
  `home_score` int(10) NOT NULL,
  `visit_score` int(10) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Won','Loss','Draw') NOT NULL,
  `aar_link` varchar(100) NOT NULL,
  PRIMARY KEY (`war_id`),
  KEY `idx_war_stats` (`visit_unit_id`,`map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_war_stats`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_war_units`
--

CREATE TABLE `rudi_war_units` (
  `visitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`visitor_id`),
  KEY `name` (`name`,`website`),
  KEY `creation_date` (`creation_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rudi_war_units`
--


-- --------------------------------------------------------

--
-- Table structure for table `rudi_weapons`
--

CREATE TABLE `rudi_weapons` (
  `weapon_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(32) NOT NULL,
  `model` varchar(32) NOT NULL,
  `role` enum('Assault','Squad Support','Light Support','Heavy Support','Sniper','Anti-Armor','Indirect','Sidearm') NOT NULL,
  `caliber` varchar(25) NOT NULL,
  PRIMARY KEY (`weapon_id`),
  KEY `idx_weapon` (`manufacturer`,`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `rudi_weapons`
--

INSERT INTO `rudi_weapons` VALUES(1, 'Colt', '1911', 'Sidearm', '.45');
INSERT INTO `rudi_weapons` VALUES(2, 'Berretta', 'M9', 'Sidearm', '9 mm');
INSERT INTO `rudi_weapons` VALUES(3, 'Colt', 'M4A1', 'Assault', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(4, 'Heckler & Koch', 'USP', 'Sidearm', '');
INSERT INTO `rudi_weapons` VALUES(5, 'Colt', 'M16A4', 'Assault', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(6, 'Springfield', 'M14', 'Assault', '7.62x51mm NATO');
INSERT INTO `rudi_weapons` VALUES(7, 'Remington Arms', 'M24 SWS', 'Sniper', '7.62x51mm NATO');
INSERT INTO `rudi_weapons` VALUES(8, 'FNH USA', 'M249 SAW', 'Light Support', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(9, 'FNH USA', 'M240', 'Heavy Support', '7.62x51mm NATO');
INSERT INTO `rudi_weapons` VALUES(10, '', 'Mk 12 SPR', 'Sniper', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(11, 'Browning', 'M2', 'Heavy Support', '.50 BMG');
INSERT INTO `rudi_weapons` VALUES(12, 'Saab Bofors Dynamics', 'AT-4', 'Anti-Armor', '84 mm');
INSERT INTO `rudi_weapons` VALUES(13, 'Talley Defense Systems', 'SMAW', 'Anti-Armor', '');
INSERT INTO `rudi_weapons` VALUES(14, 'Colt', 'M16A2', 'Assault', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(15, 'Knight''s Armament Company', 'M110 SASS', 'Sniper', '7.62x51mm NATO');
INSERT INTO `rudi_weapons` VALUES(16, 'FN Manufacturing Inc', 'Mk 48 mod 0', 'Light Support', '7.62x51mm NATO');
INSERT INTO `rudi_weapons` VALUES(17, '', 'M203', 'Indirect', '40mm');
INSERT INTO `rudi_weapons` VALUES(18, '', 'EGLM', 'Indirect', '40mm');
INSERT INTO `rudi_weapons` VALUES(19, '', 'M252 mortar', 'Indirect', '81 mm');
INSERT INTO `rudi_weapons` VALUES(20, 'FNH', 'Mk 16 SCAR-L', 'Assault', '5.56x45mm NATO');
INSERT INTO `rudi_weapons` VALUES(21, 'FNH', 'Mk 17 SCAR-H', 'Assault', '7.62x51mm NATO ');
INSERT INTO `rudi_weapons` VALUES(22, 'Saab Bofors Dynamics', 'M3 MAAWS', 'Anti-Armor', '84 mm');
