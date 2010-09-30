<?php 
$q = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"';
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `cells` (
  `id` bigint(20) unsigned NOT NULL,
  `scene_id` bigint(20) unsigned NOT NULL,
  `grid_event_id` bigint(20) unsigned NOT NULL,
  KEY `id_storyid` (`id`,`scene_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = '
INSERT INTO `cells` (`id`, `scene_id`, `grid_event_id`) VALUES
(90, 23, 16),
(91, 23, 16),
(92, 23, 16),
(93, 23, 16),
(94, 23, 16),
(95, 23, 16),
(96, 23, 16),
(97, 23, 16),
(98, 23, 16),
(99, 23, 16),
(14, 22, 17),
(24, 22, 17),
(25, 22, 17),
(15, 22, 17),
(4, 23, 18),
(14, 23, 18),
(5, 23, 18),
(15, 23, 18),
(90, 23, 19),
(91, 23, 19),
(92, 23, 19),
(93, 23, 19),
(94, 23, 19),
(95, 23, 19),
(96, 23, 19),
(97, 23, 19),
(98, 23, 19),
(99, 23, 19),
(40, 24, 20),
(30, 24, 20),
(20, 24, 20),
(10, 24, 20),
(90, 24, 21),
(91, 24, 21),
(92, 24, 21),
(93, 24, 21),
(94, 24, 21),
(95, 24, 21),
(96, 24, 21),
(97, 24, 21),
(98, 24, 21),
(99, 24, 21),
(90, 26, 24),
(91, 26, 24),
(92, 26, 24),
(93, 26, 24),
(94, 26, 24),
(95, 26, 24),
(96, 26, 24),
(97, 26, 24),
(98, 26, 24),
(99, 26, 24),
(90, 28, 25),
(91, 28, 25),
(92, 28, 25),
(93, 28, 25),
(94, 28, 25),
(95, 28, 25),
(96, 28, 25),
(97, 28, 25),
(98, 28, 25),
(99, 28, 25),
(3, 28, 26),
(13, 28, 26),
(23, 28, 26),
(33, 28, 26),
(4, 28, 26),
(14, 28, 26),
(24, 28, 26),
(34, 28, 26),
(44, 28, 26),
(43, 28, 26),
(90, 36, 27),
(91, 36, 27),
(92, 36, 27),
(93, 36, 27),
(94, 36, 27),
(95, 36, 27),
(96, 36, 27),
(97, 36, 27),
(98, 36, 27),
(99, 36, 27),
(35, 36, 28),
(45, 36, 28),
(55, 36, 28),
(46, 36, 28),
(44, 36, 28),
(54, 36, 28),
(56, 36, 28),
(3, 29, 29),
(13, 29, 29),
(23, 29, 29),
(33, 29, 29),
(4, 29, 29),
(14, 29, 29),
(24, 29, 29),
(34, 29, 29),
(15, 29, 29),
(25, 29, 29),
(35, 29, 29),
(44, 29, 29),
(43, 29, 29),
(54, 29, 29),
(90, 29, 30),
(91, 29, 30),
(92, 29, 30),
(93, 29, 30),
(94, 29, 30),
(95, 29, 30),
(96, 29, 30),
(97, 29, 30),
(98, 29, 30),
(99, 29, 30),
(90, 37, 31),
(91, 37, 31),
(92, 37, 31),
(93, 37, 31),
(94, 37, 31),
(95, 37, 31),
(96, 37, 31),
(97, 37, 31),
(98, 37, 31),
(99, 37, 31),
(24, 37, 32),
(25, 37, 32),
(26, 37, 32),
(14, 37, 32),
(15, 37, 32),
(16, 37, 32),
(37, 37, 32),
(47, 37, 32),
(57, 37, 32),
(67, 37, 32),
(77, 37, 32),
(76, 37, 32),
(66, 37, 32),
(56, 37, 32),
(46, 37, 32),
(36, 37, 32),
(35, 37, 32),
(34, 37, 32),
(33, 37, 32),
(43, 37, 32),
(53, 37, 32),
(63, 37, 32),
(73, 37, 32),
(74, 37, 32),
(64, 37, 32),
(54, 37, 32),
(44, 37, 32),
(45, 37, 32),
(55, 37, 32),
(65, 37, 32),
(75, 37, 32),
(33, 39, 33),
(43, 39, 33),
(53, 39, 33),
(54, 39, 33),
(44, 39, 33),
(63, 39, 33),
(64, 39, 33),
(33, 40, 34),
(53, 40, 34),
(43, 40, 34),
(63, 40, 34),
(64, 40, 34),
(54, 40, 34),
(44, 40, 34),
(71, 40, 35),
(72, 40, 35),
(90, 41, 36),
(91, 41, 36),
(92, 41, 36),
(93, 41, 36),
(94, 41, 36),
(95, 41, 36),
(96, 41, 36),
(97, 41, 36),
(98, 41, 36),
(99, 41, 36),
(90, 22, 37),
(91, 22, 37),
(92, 22, 37),
(93, 22, 37),
(94, 22, 37),
(95, 22, 37),
(96, 22, 37),
(97, 22, 37),
(98, 22, 37),
(99, 22, 37),
(45, 25, 0),
(44, 25, 0),
(35, 25, 0),
(34, 25, 0),
(0, 25, 0),
(46, 25, 0),
(36, 25, 0),
(33, 25, 0),
(43, 25, 0),
(46, 25, 42),
(45, 25, 42),
(44, 25, 42),
(43, 25, 42),
(36, 25, 42),
(35, 25, 42),
(34, 25, 42),
(33, 25, 42),
(99, 25, 43),
(98, 25, 43),
(97, 25, 43),
(96, 25, 43),
(95, 25, 43),
(94, 25, 43),
(93, 25, 43),
(92, 25, 43),
(91, 25, 43),
(90, 25, 43),
(0, 25, 43),
(0, 25, 43),
(90, 25, 44),
(91, 25, 44),
(92, 25, 44),
(93, 25, 44),
(94, 25, 44),
(95, 25, 44),
(96, 25, 44),
(97, 25, 44),
(98, 25, 44),
(99, 25, 44),
(2, 22, 46),
(12, 22, 46),
(22, 22, 46),
(32, 22, 46),
(71, 40, 47),
(72, 40, 47),
(37, 24, 48),
(36, 24, 48),
(27, 24, 48),
(26, 24, 48),
(16, 22, 45),
(6, 22, 45)';
$results = DB::Query(NULL,$q,FALSE)->execute();


$q = 'CREATE TABLE IF NOT EXISTS `locations` (
  `story_id` bigint(20) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `locations` (`story_id`, `id`, `title`) VALUES
(2, 18, 'Start'),
(2, 20, 'Scene 2'),
(2, 21, 'Scene 3'),
(2, 22, 'Scene 4'),
(2, 25, 'Grate'),
(2, 26, 'tunnel'),
(2, 27, 'tunnel2'),
(2, 28, 'Ocean'),
(2, 29, 'Forest')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `locations_events` (
  `location_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `locationid` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `locations_events` (`location_id`, `event_id`) VALUES
(25, 39);";
$results = DB::Query(NULL,$q,FALSE)->execute(); 

$q = 'CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `event` varchar(255) character set latin1 NOT NULL,
  `event_label` varchar(255) character set latin1 NOT NULL,
  `event_value` varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=50';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `events` (`id`, `event`, `event_label`, `event_value`) VALUES
(17, 'event_link', 'link', '20'),
(18, 'event_link', 'link', '21'),
(19, 'event_link', 'link', '18'),
(20, 'event_link', 'link', '22'),
(21, 'event_link', 'link', '20'),
(22, 'event_link', 'link', '21'),
(24, 'event_link', 'link', '22'),
(25, 'event_link', 'link', '22'),
(26, 'event_assign', 'Assign value', '\$grate = ''open'';'),
(27, 'event_link', 'link', '25'),
(28, 'event_link', 'link', '27'),
(29, 'event_link', 'link', '26'),
(30, 'event_link', 'link', '22'),
(31, 'event_link', 'link', '26'),
(32, 'event_link', 'link', '28'),
(33, 'event_link', 'link', '18'),
(34, 'event_link', 'link', '18'),
(35, 'event_assign', 'Assign value', '\$forest = ''no_hammer'';\n\$grate = ''hammer'';'),
(36, 'event_assign', 'Assign value', '\$forest = ''hammer'';\n\$grate = ''no_hammer'';'),
(37, 'event_link', 'link', '22'),
(38, 'event_link', 'link', '29'),
(43, 'event_link', 'link', '25'),
(45, 'event_link', 'link', '21'),
(46, 'event_message', 'User Message', 'You found a tree!!!'),
(47, 'event_message', 'User Alert Message', 'You clicked on the tree!'),
(48, 'event_message', 'User Alert Message', 'You Picked Up the Hammer!'),
(49, 'event_message', 'User Message', 'Sorry this path doesn''t go anywhere!')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `grids_events` (
  `grid_event_id` bigint(20) unsigned NOT NULL auto_increment,
  `scene_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`grid_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=49';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `grids_events` (`grid_event_id`, `scene_id`, `event_id`) VALUES
(1, 22, 1),
(2, 23, 2),
(3, 23, 3),
(4, 24, 4),
(5, 24, 5),
(6, 24, 6),
(7, 24, 7),
(8, 24, 8),
(9, 22, 9),
(10, 22, 10),
(11, 23, 11),
(12, 23, 12),
(13, 25, 13),
(15, 26, 15),
(16, 23, 16),
(17, 22, 17),
(18, 23, 18),
(19, 23, 19),
(20, 24, 20),
(21, 24, 21),
(24, 26, 24),
(25, 28, 25),
(26, 28, 26),
(27, 36, 27),
(28, 36, 28),
(29, 29, 29),
(30, 29, 30),
(31, 37, 31),
(32, 37, 32),
(33, 39, 33),
(34, 40, 34),
(35, 40, 35),
(36, 41, 37),
(37, 22, 38),
(42, 25, 43),
(43, 25, 44),
(44, 25, 45),
(45, 22, 46),
(46, 22, 47),
(47, 40, 48),
(48, 24, 49)";
$results = DB::Query(NULL,$q,FALSE)->execute();


$q = 'CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL auto_increment,
  `story_id` bigint(20) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=14';
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = "INSERT INTO `images` (`id`, `story_id`, `filename`) VALUES
(1, 2, 'forest.JPG'),
(2, 2, 'forest2.JPG'),
(3, 2, 'Image000.jpg'),
(5, 2, 'Image002.jpg'),
(6, 2, 'Image003.jpg'),
(7, 2, 'Image004.jpg'),
(8, 2, 'pipe1.jpg'),
(9, 2, 'pipe2.jpg'),
(10, 2, 'tunnel.jpg'),
(11, 2, 'tunnel2.jpg'),
(12, 2, 'ocean.JPG'),
(13, 2, 'Image001.jpg')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `scenes` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `story_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `filename` varchar(255) default NULL,
  `image_id` bigint(20) default NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `scene_value` (`value`,`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `scenes` (`id`, `story_id`, `location_id`, `title`, `description`, `filename`, `image_id`, `value`) VALUES
(22, 2, 18, 'Start', 'You are at the start of the trail', 'Image000.jpg', 3, ''),
(23, 2, 20, 'Scene 2', 'I wonder where the path goes?', 'Image001.jpg', 13, ''),
(24, 2, 21, 'Scene 3', 'There is a turn ahead', 'Image002.jpg', 5, ''),
(25, 2, 22, 'Scene 4', 'the path continues', 'Image004.jpg', 7, ''),
(28, 2, 25, 'Grate', 'The Path ends abruptly at a grate. Maybe you can break it open!', 'pipe1.jpg', 8, 'hammer'),
(29, 2, 25, 'Grate', 'A piece of the grate is broken, do you dare climb through?', 'pipe2.jpg', 9, 'open'),
(36, 2, 26, 'tunnel', '', 'tunnel.jpg', 10, ''),
(37, 2, 27, 'tunnel2', '', 'tunnel2.jpg', 11, ''),
(38, 2, 28, 'Ocean - The End!', 'You are at the ocean! \nTHE END', 'ocean.JPG', 12, ''),
(39, 2, 29, 'Forest', 'You are in the forest. There is a path in front of you.', 'forest.JPG', 1, 'no_hammer'),
(40, 2, 29, 'Forest', 'You are in the Forest. There is a path in front of you. Someone has left a poorly-drawn sledge hammer here!', 'forest2.JPG', 2, 'hammer'),
(41, 2, 25, 'Grate', 'The Path ends abruptly at a grate. If only you had something to smash it with...', 'pipe1.jpg', 8, 'no_hammer')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `scenes_events` (
  `scene_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `sceneid` (`scene_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
/*
$q = "";
$results = DB::Query(NULL,$q,FALSE)->execute();
*/

$q = 'CREATE TABLE IF NOT EXISTS `stories` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `first_location_id` bigint(20) unsigned default NULL,
  `image_id` bigint(20) default NULL,
  `grid_x` smallint(5) unsigned NOT NULL,
  `grid_y` smallint(5) unsigned NOT NULL,
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `stories` (`id`, `title`, `author`, `description`, `first_location_id`, `image_id`, `grid_x`, `grid_y`, `create_date`) VALUES
(2, 'A Walk Down The Cobble Stone Path', 'Dan', 'A Walk through the forest on the mysterious cobblestone path', 18, 0, 10, 10, '2010-07-02 08:36:56')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE IF NOT EXISTS `stories_events` (
  `story_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `storyid` (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "
INSERT INTO `stories_events` (`story_id`, `event_id`) VALUES
(2, 36)";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL default '',
  `password` char(50) NOT NULL,
  `active` tinyint(4) default '1',
  `logins` int(10) unsigned NOT NULL default '0',
  `last_ip_address` varchar(15) default NULL,
  `last_login` datetime default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=36";
$results = DB::Query(NULL,$q,FALSE)->execute();

?>