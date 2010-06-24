SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pointclickpress`
--

-- --------------------------------------------------------
--
-- Table structure for table `scene_action_cells`
--

CREATE TABLE IF NOT EXISTS `scene_action_cells` (
  `id` bigint(20) unsigned NOT NULL,
  `action_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `key` (`id`,`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
