<?php 
$q = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"';
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE cells (
  id bigint(20) unsigned NOT NULL,
  scene_id bigint(20) unsigned NOT NULL,
  grid_event_id bigint(20) unsigned NOT NULL,
  KEY id_storyid (id,scene_id)
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
(90, 25, 22),
(91, 25, 22),
(92, 25, 22),
(93, 25, 22),
(94, 25, 22),
(95, 25, 22),
(96, 25, 22),
(97, 25, 22),
(98, 25, 22),
(99, 25, 22),
(34, 25, 23),
(44, 25, 23),
(45, 25, 23),
(35, 25, 23),
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
(99, 23, 0),
(98, 23, 0),
(97, 23, 0),
(96, 23, 0),
(95, 23, 0),
(94, 23, 0),
(93, 23, 0),
(92, 23, 0),
(91, 23, 0),
(90, 23, 0),
(0, 23, 0)';
$results = DB::Query(NULL,$q,FALSE)->execute();


$q = 'CREATE TABLE containers (
  story_id bigint(20) unsigned NOT NULL,
  id bigint(20) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `containers` (`story_id`, `id`, `title`) VALUES
(2, 18, 'Start'),
(2, 20, 'Scene 2'),
(2, 21, 'Scene 3'),
(2, 22, 'Scene 4'),
(2, 23, 'Sewer Grate')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE containers_events (
  container_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY containerid (container_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
/* $q = "";
$results = DB::Query(NULL,$q,FALSE)->execute(); */

$q = 'CREATE TABLE `events` (
  id bigint(20) unsigned NOT NULL auto_increment,
  event varchar(255) character set latin1 NOT NULL,
  event_label varchar(255) character set latin1 NOT NULL,
  event_value varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `events` (`id`, `event`, `event_label`, `event_value`) VALUES
(17, 'event_link', 'link', '20'),
(18, 'event_link', 'link', '21'),
(19, 'event_link', 'link', '18'),
(20, 'event_link', 'link', '22'),
(21, 'event_link', 'link', '20'),
(22, 'event_link', 'link', '21'),
(23, 'event_link', 'link', '23'),
(24, 'event_link', 'link', '22')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE grids_events (
  grid_event_id bigint(20) unsigned NOT NULL auto_increment,
  scene_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (grid_event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5';
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
(14, 25, 14),
(15, 26, 15),
(16, 23, 16),
(17, 22, 17),
(18, 23, 18),
(19, 23, 19),
(20, 24, 20),
(21, 24, 21),
(22, 25, 22),
(23, 25, 23),
(24, 26, 24)";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE scenes (
  id bigint(20) unsigned NOT NULL auto_increment,
  story_id bigint(20) unsigned NOT NULL,
  container_id bigint(20) unsigned NOT NULL,
  title varchar(255) default NULL,
  description text,
  filename varchar(255) default NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY scene_value (`value`,container_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = '';
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE scenes_events (
  scene_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY sceneid (scene_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `scenes` (`id`, `story_id`, `container_id`, `title`, `description`, `filename`, `value`) VALUES
(22, 2, 18, 'Start', 'You are at the start of the trail', 'Image000.jpg', ''),
(23, 2, 20, 'Scene 2', 'I wonder where the path goes?', 'Image001.jpg', ''),
(24, 2, 21, 'Scene 3', 'There is a turn ahead', 'Image002.jpg', ''),
(25, 2, 22, 'Scene 4', '', 'Image004.jpg', ''),
(26, 2, 23, 'Sewer Grate', '', 'Image003.jpg', '')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE stories (
  id bigint(20) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  author varchar(255) NOT NULL,
  description text NOT NULL,
  first_scene_container_id bigint(20) unsigned default NULL,
  grid_x smallint(5) unsigned NOT NULL,
  grid_y smallint(5) unsigned NOT NULL,
  create_date timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = "INSERT INTO `stories` (`id`, `title`, `author`, `description`, `first_scene_container_id`, `grid_x`, `grid_y`, `create_date`) VALUES
(2, 'A Walk Down The Cobble Stone Path', 'Dan', 'A Walk through the forest on the mysterious cobblestone path', 18, 10, 10, '2010-07-02 08:36:56')";
$results = DB::Query(NULL,$q,FALSE)->execute();

$q = 'CREATE TABLE stories_events (
  story_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY storyid (story_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$results = DB::Query(NULL,$q,FALSE)->execute();

/*data*/
$q = '';
$results = DB::Query(NULL,$q,FALSE)->execute();

?>
