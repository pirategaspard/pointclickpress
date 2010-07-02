SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE cells (
  id bigint(20) unsigned NOT NULL,
  scene_id bigint(20) unsigned NOT NULL,
  grid_event_id bigint(20) unsigned NOT NULL,
  KEY id_storyid (id,scene_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE containers (
  story_id bigint(20) unsigned NOT NULL,
  id bigint(20) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

CREATE TABLE containers_events (
  container_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY containerid (container_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `events` (
  id bigint(20) unsigned NOT NULL auto_increment,
  event varchar(255) character set latin1 NOT NULL,
  event_label varchar(255) character set latin1 NOT NULL,
  event_value varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

CREATE TABLE grids_events (
  grid_event_id bigint(20) unsigned NOT NULL auto_increment,
  scene_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (grid_event_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE scenes (
  id bigint(20) unsigned NOT NULL auto_increment,
  story_id bigint(20) unsigned NOT NULL,
  container_id bigint(20) unsigned NOT NULL,
  title varchar(255) default NULL,
  description text,
  filename varchar(255) default NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY scene_value (`value`,container_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

CREATE TABLE scenes_events (
  scene_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY sceneid (scene_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE stories (
  id bigint(20) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  author varchar(255) NOT NULL,
  description text NOT NULL,
  first_scene_container_id bigint(20) unsigned default NULL,
  grid_x smallint(5) unsigned NOT NULL,
  grid_y smallint(5) unsigned NOT NULL,
  create_date timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE stories_events (
  story_id bigint(20) unsigned NOT NULL,
  event_id bigint(20) unsigned NOT NULL,
  KEY storyid (story_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
