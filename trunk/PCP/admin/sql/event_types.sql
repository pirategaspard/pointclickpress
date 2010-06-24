CREATE TABLE IF NOT EXISTS `event_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event` (`event`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

