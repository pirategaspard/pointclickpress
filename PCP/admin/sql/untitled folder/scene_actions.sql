SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pointclickpress`
--

-- --------------------------------------------------------
--
-- Table structure for table `scene_actions`
--

CREATE TABLE IF NOT EXISTS `scene_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `scene_id` bigint(20) unsigned NOT NULL,
  `container_id` bigint(20) unsigned NOT NULL,
  `event` varchar(255) NOT NULL,
  `event_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;;
