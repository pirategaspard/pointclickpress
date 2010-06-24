SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pointclickpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE IF NOT EXISTS `event_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event` (`event`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_types`
--
