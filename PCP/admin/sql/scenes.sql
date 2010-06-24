CREATE TABLE IF NOT EXISTS `scenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` bigint(20) unsigned NOT NULL,
  `container_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `filename` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `init_vars` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scene_value` (`value`,`container_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;
