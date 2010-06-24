SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pointclickpress`
--

-- --------------------------------------------------------
--
-- Table structure for table `stories`
--

CREATE TABLE IF NOT EXISTS `stories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `init_vars` text,
  `first_scene_container_id` bigint(20) unsigned NOT NULL,
  `grid_x` smallint(5) unsigned NOT NULL,
  `grid_y` smallint(5) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
