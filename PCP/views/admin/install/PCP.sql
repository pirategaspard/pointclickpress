-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 12, 2010 at 07:56 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

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

INSERT INTO `event_types` (`id`, `label`, `description`, `event`) VALUES
(1, 'Link', 'Create a link to another scene container', 'link'),
(2, 'Trigger', 'Session variable state change', 'trigger');

-- --------------------------------------------------------

--
-- Table structure for table `scenes`
--

CREATE TABLE IF NOT EXISTS `scenes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` bigint(20) unsigned NOT NULL,
  `container_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `filename` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scene_value` (`value`,`container_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `scenes`
--

INSERT INTO `scenes` (`id`, `story_id`, `container_id`, `title`, `description`, `filename`, `value`) VALUES
(7, 2, 10, 'Office 1', 'This is office one', '31138-500-376.jpg', ''),
(8, 2, 11, 'Office 2', 'this is Office Two', '57197-500-375.jpg', ''),
(9, 2, 12, 'Office 3', 'This is office 3', '1327.jpg', ''),
(10, 2, 12, 'FAT MONKEY', 'YOU FOUND THE FAT MONKEY!!! YOU WIN!!!', 'FatMonkey.JPG', 'found');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `scene_actions`
--

INSERT INTO `scene_actions` (`id`, `scene_id`, `container_id`, `event`, `event_value`) VALUES
(11, 9, 12, 'link', '10'),
(10, 9, 12, 'trigger', 'found=true;'),
(12, 9, 12, 'link', '11'),
(13, 10, 12, 'link', '10'),
(14, 10, 12, 'link', '11'),
(15, 7, 10, 'link', '11'),
(16, 8, 11, 'link', '12');

-- --------------------------------------------------------

--
-- Table structure for table `scene_action_cells`
--

CREATE TABLE IF NOT EXISTS `scene_action_cells` (
  `id` bigint(20) unsigned NOT NULL,
  `action_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `key` (`id`,`action_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scene_action_cells`
--

INSERT INTO `scene_action_cells` (`id`, `action_id`) VALUES
(0, 10),
(0, 11),
(0, 13),
(0, 15),
(9, 12),
(9, 14),
(9, 16),
(10, 11),
(10, 13),
(10, 15),
(19, 12),
(19, 14),
(19, 16),
(20, 11),
(20, 13),
(20, 15),
(29, 12),
(29, 14),
(29, 16),
(30, 11),
(30, 13),
(30, 15),
(39, 12),
(39, 14),
(39, 16),
(40, 11),
(40, 13),
(40, 15),
(49, 12),
(49, 14),
(49, 16),
(50, 11),
(50, 13),
(50, 15),
(59, 12),
(59, 14),
(59, 16),
(60, 11),
(60, 13),
(60, 15),
(63, 10),
(69, 12),
(69, 14),
(69, 16),
(70, 11),
(70, 13),
(70, 15),
(79, 12),
(79, 14),
(79, 16),
(80, 11),
(80, 13),
(80, 15),
(89, 12),
(89, 14),
(89, 16),
(90, 11),
(90, 13),
(90, 15),
(99, 12),
(99, 14),
(99, 16);

-- --------------------------------------------------------

--
-- Table structure for table `scene_containers`
--

CREATE TABLE IF NOT EXISTS `scene_containers` (
  `story_id` bigint(20) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `scene_containers`
--

INSERT INTO `scene_containers` (`story_id`, `id`, `title`) VALUES
(2, 10, 'Office 1'),
(2, 11, 'Office 2'),
(2, 12, 'Office 3');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `author`, `description`, `init_vars`, `first_scene_container_id`, `grid_x`, `grid_y`, `create_date`) VALUES
(2, 'Office of Doom', 'Dan', 'Dare to Enter The Office of Doom!', 'found=false', 10, 10, 10, '0000-00-00 00:00:00');
