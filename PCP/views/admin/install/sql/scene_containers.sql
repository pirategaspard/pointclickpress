CREATE TABLE IF NOT EXISTS scene_containers (
  story_id bigint(20) unsigned NOT NULL,
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;
