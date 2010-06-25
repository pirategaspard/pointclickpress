CREATE TABLE IF NOT EXISTS `scene_action_cells` (
  `id` bigint(20) unsigned NOT NULL,
  `action_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `key` (`id`,`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
