-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2010 at 10:28 AM
-- Server version: 5.0.27
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pointclickpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `cells`
--

CREATE TABLE IF NOT EXISTS `cells` (
  `id` int(20) unsigned NOT NULL,
  `scene_id` bigint(20) unsigned NOT NULL,
  `grid_event_id` bigint(20) unsigned NOT NULL,
  KEY `id_storyid` (`id`,`scene_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cells`
--

INSERT INTO `cells` (`id`, `scene_id`, `grid_event_id`) VALUES
(90, 23, 16),
(91, 23, 16),
(92, 23, 16),
(93, 23, 16),
(94, 23, 16),
(95, 23, 16),
(96, 23, 16),
(97, 23, 16),
(98, 23, 16),
(99, 23, 16),
(90, 26, 24),
(91, 26, 24),
(92, 26, 24),
(93, 26, 24),
(94, 26, 24),
(95, 26, 24),
(96, 26, 24),
(97, 26, 24),
(98, 26, 24),
(99, 26, 24),
(99, 25, 43),
(98, 25, 43),
(97, 25, 43),
(96, 25, 43),
(95, 25, 43),
(94, 25, 43),
(93, 25, 43),
(92, 25, 43),
(91, 25, 43),
(90, 25, 43),
(0, 25, 43),
(0, 25, 43),
(92, 45, 50),
(93, 45, 50),
(94, 45, 50),
(95, 45, 50),
(96, 45, 50),
(89, 45, 51),
(79, 45, 51),
(69, 45, 51),
(59, 45, 51),
(49, 45, 51),
(32, 45, 52),
(42, 45, 52),
(52, 45, 52),
(62, 45, 52),
(63, 45, 52),
(64, 45, 52),
(54, 45, 52),
(44, 45, 52),
(34, 45, 52),
(33, 45, 52),
(43, 45, 52),
(53, 45, 52),
(23, 45, 52),
(22, 45, 52),
(24, 45, 52),
(80, 45, 53),
(70, 45, 53),
(60, 45, 53),
(50, 45, 53),
(40, 45, 53),
(30, 45, 53),
(20, 45, 53),
(80, 47, 54),
(70, 47, 54),
(60, 47, 54),
(50, 47, 54),
(40, 47, 54),
(30, 47, 54),
(20, 47, 54),
(69, 47, 55),
(59, 47, 55),
(49, 47, 55),
(39, 47, 55),
(38, 47, 55),
(48, 47, 55),
(58, 47, 55),
(68, 47, 55),
(93, 46, 56),
(94, 46, 56),
(95, 46, 56),
(96, 46, 56),
(98, 46, 56),
(97, 46, 56),
(99, 46, 56),
(92, 46, 56),
(30, 46, 57),
(40, 46, 57),
(50, 46, 57),
(60, 46, 57),
(80, 46, 57),
(70, 46, 57),
(81, 46, 57),
(71, 46, 57),
(61, 46, 57),
(51, 46, 57),
(41, 46, 57),
(31, 46, 57),
(14, 46, 58),
(24, 46, 58),
(34, 46, 58),
(44, 46, 58),
(45, 46, 58),
(35, 46, 58),
(25, 46, 58),
(15, 46, 58),
(16, 46, 58),
(26, 46, 58),
(36, 46, 58),
(46, 46, 58),
(47, 46, 58),
(37, 46, 58),
(27, 46, 58),
(17, 46, 58),
(91, 48, 59),
(92, 48, 59),
(93, 48, 59),
(94, 48, 59),
(95, 48, 59),
(96, 48, 59),
(97, 48, 59),
(98, 48, 59),
(24, 48, 60),
(34, 48, 60),
(35, 48, 60),
(25, 48, 60),
(25, 50, 61),
(35, 50, 61),
(45, 50, 61),
(55, 50, 61),
(56, 50, 61),
(46, 50, 61),
(36, 50, 61),
(26, 50, 61),
(23, 50, 61),
(33, 50, 61),
(43, 50, 61),
(53, 50, 61),
(52, 50, 61),
(42, 50, 61),
(32, 50, 61),
(22, 50, 61),
(91, 50, 62),
(92, 50, 62),
(93, 50, 62),
(94, 50, 62),
(95, 50, 62),
(96, 50, 62),
(97, 50, 62),
(98, 50, 62),
(91, 48, 63),
(92, 48, 63),
(94, 48, 63),
(93, 48, 63),
(95, 48, 63),
(96, 48, 63),
(97, 48, 63),
(98, 48, 63),
(93, 51, 64),
(92, 51, 64),
(94, 51, 64),
(95, 51, 64),
(96, 51, 64),
(97, 51, 64),
(98, 51, 64),
(99, 51, 64),
(89, 51, 64),
(79, 51, 64),
(69, 51, 64),
(70, 51, 65),
(60, 51, 65),
(50, 51, 65),
(40, 51, 65),
(30, 51, 65),
(20, 51, 65),
(34, 51, 66),
(35, 51, 66),
(25, 51, 66),
(24, 51, 66),
(26, 51, 66),
(16, 51, 66),
(36, 51, 66),
(45, 51, 66),
(44, 51, 66),
(54, 51, 66),
(55, 51, 66),
(56, 51, 66),
(46, 51, 66),
(57, 51, 66),
(47, 51, 66),
(37, 51, 66),
(27, 51, 66),
(28, 51, 66),
(38, 51, 66),
(48, 51, 66),
(58, 51, 66),
(91, 61, 67),
(92, 61, 67),
(93, 61, 67),
(94, 61, 67),
(95, 61, 67),
(96, 61, 67),
(97, 61, 67),
(90, 61, 67),
(80, 61, 67),
(70, 61, 67),
(60, 61, 67),
(35, 61, 68),
(45, 61, 68),
(55, 61, 68),
(65, 61, 68),
(66, 61, 68),
(67, 61, 68),
(57, 61, 68),
(47, 61, 68),
(37, 61, 68),
(36, 61, 68),
(46, 61, 68),
(56, 61, 68),
(65, 52, 69),
(75, 52, 69),
(76, 52, 69),
(66, 52, 69),
(67, 52, 69),
(77, 52, 69),
(78, 52, 69),
(68, 52, 69),
(64, 52, 69),
(74, 52, 69),
(90, 53, 70),
(91, 53, 70),
(92, 53, 70),
(93, 53, 70),
(94, 53, 70),
(95, 53, 70),
(96, 53, 70),
(97, 53, 70),
(98, 53, 70),
(99, 53, 70),
(89, 53, 70),
(88, 53, 70),
(87, 53, 70),
(86, 53, 70),
(85, 53, 70),
(84, 53, 70),
(83, 53, 70),
(82, 53, 70),
(81, 53, 70),
(80, 53, 70),
(0, 53, 71),
(1, 53, 71),
(2, 53, 71),
(3, 53, 71),
(13, 53, 71),
(12, 53, 71),
(11, 53, 71),
(10, 53, 71),
(20, 53, 71),
(21, 53, 71),
(22, 53, 71),
(23, 53, 71),
(4, 53, 71),
(14, 53, 71),
(24, 53, 71),
(5, 53, 71),
(15, 53, 71),
(25, 53, 71),
(4, 52, 72),
(14, 52, 72),
(34, 52, 72),
(44, 52, 72),
(43, 52, 72),
(45, 52, 72),
(35, 52, 72),
(33, 52, 72),
(36, 52, 72),
(46, 52, 72),
(24, 52, 72),
(23, 52, 72),
(26, 52, 72),
(25, 52, 72),
(41, 52, 73),
(42, 52, 73),
(32, 52, 73),
(22, 52, 73),
(20, 52, 73),
(30, 52, 73),
(31, 52, 73),
(21, 52, 73),
(90, 52, 74),
(91, 52, 74),
(92, 52, 74),
(93, 52, 74),
(94, 52, 74),
(95, 52, 74),
(96, 52, 74),
(97, 52, 74),
(98, 52, 74),
(99, 52, 74),
(22, 55, 75),
(32, 55, 75),
(42, 55, 75),
(23, 55, 75),
(33, 55, 75),
(43, 55, 75),
(24, 55, 75),
(34, 55, 75),
(44, 55, 75),
(25, 55, 75),
(35, 55, 75),
(45, 55, 75),
(26, 55, 75),
(36, 55, 75),
(46, 55, 75),
(56, 55, 75),
(55, 55, 75),
(54, 55, 75),
(53, 55, 75),
(52, 55, 75),
(62, 55, 75),
(63, 55, 75),
(64, 55, 75),
(65, 55, 75),
(66, 55, 75),
(76, 55, 75),
(75, 55, 75),
(74, 55, 75),
(73, 55, 75),
(72, 55, 75),
(82, 55, 75),
(83, 55, 75),
(84, 55, 75),
(86, 55, 75),
(85, 55, 75),
(90, 55, 76),
(91, 55, 76),
(92, 55, 76),
(93, 55, 76),
(94, 55, 76),
(95, 55, 76),
(96, 55, 76),
(97, 55, 76),
(98, 55, 76),
(80, 55, 76),
(70, 55, 76),
(60, 55, 76),
(50, 55, 76),
(40, 55, 76),
(30, 55, 76),
(20, 55, 76),
(89, 55, 77),
(69, 55, 77),
(59, 55, 77),
(49, 55, 77),
(79, 55, 77),
(39, 55, 77),
(29, 55, 77),
(19, 55, 77),
(90, 56, 78),
(91, 56, 78),
(92, 56, 78),
(93, 56, 78),
(94, 56, 78),
(95, 56, 78),
(96, 56, 78),
(97, 56, 78),
(98, 56, 78),
(99, 56, 78),
(89, 56, 79),
(79, 56, 79),
(69, 56, 79),
(59, 56, 79),
(49, 56, 79),
(39, 56, 79),
(29, 56, 79),
(10, 56, 80),
(11, 56, 80),
(12, 56, 80),
(22, 56, 80),
(21, 56, 80),
(20, 56, 80),
(30, 56, 80),
(31, 56, 80),
(32, 56, 80),
(42, 56, 80),
(41, 56, 80),
(40, 56, 80),
(50, 56, 80),
(51, 56, 80),
(52, 56, 80),
(62, 56, 80),
(61, 56, 80),
(60, 56, 80),
(70, 56, 80),
(71, 56, 80),
(72, 56, 80),
(82, 56, 80),
(81, 56, 80),
(80, 56, 80),
(80, 54, 81),
(70, 54, 81),
(60, 54, 81),
(50, 54, 81),
(40, 54, 81),
(30, 54, 81),
(27, 54, 82),
(37, 54, 82),
(47, 54, 82),
(48, 54, 82),
(38, 54, 82),
(28, 54, 82),
(57, 54, 82),
(58, 54, 82),
(90, 54, 83),
(91, 54, 83),
(92, 54, 83),
(93, 54, 83),
(94, 54, 83),
(95, 54, 83),
(96, 54, 83),
(97, 54, 83),
(98, 54, 83),
(99, 54, 83),
(90, 57, 84),
(91, 57, 84),
(92, 57, 84),
(93, 57, 84),
(94, 57, 84),
(95, 57, 84),
(96, 57, 84),
(97, 57, 84),
(98, 57, 84),
(80, 57, 84),
(70, 57, 84),
(81, 57, 84),
(82, 57, 84),
(83, 57, 84),
(84, 57, 84),
(85, 57, 84),
(86, 57, 84),
(87, 57, 84),
(88, 57, 84),
(11, 57, 85),
(21, 57, 85),
(31, 57, 85),
(41, 57, 85),
(51, 57, 85),
(61, 57, 85),
(71, 57, 85),
(72, 57, 85),
(62, 57, 85),
(52, 57, 85),
(42, 57, 85),
(32, 57, 85),
(22, 57, 85),
(12, 57, 85),
(13, 57, 85),
(23, 57, 85),
(33, 57, 85),
(43, 57, 85),
(53, 57, 85),
(63, 57, 85),
(50, 57, 85),
(40, 57, 85),
(30, 57, 85),
(13, 58, 86),
(23, 58, 86),
(33, 58, 86),
(43, 58, 86),
(53, 58, 86),
(63, 58, 86),
(73, 58, 86),
(83, 58, 86),
(84, 58, 86),
(74, 58, 86),
(64, 58, 86),
(54, 58, 86),
(44, 58, 86),
(90, 58, 87),
(91, 58, 87),
(93, 58, 87),
(94, 58, 87),
(92, 58, 87),
(95, 58, 87),
(96, 58, 87),
(97, 58, 87),
(98, 58, 87),
(90, 59, 88),
(91, 59, 88),
(92, 59, 88),
(93, 59, 88),
(94, 59, 88),
(95, 59, 88),
(96, 59, 88),
(97, 59, 88),
(98, 59, 88),
(99, 59, 88),
(89, 59, 88),
(88, 59, 88),
(87, 59, 88),
(86, 59, 88),
(85, 59, 88),
(84, 59, 88),
(83, 59, 88),
(82, 59, 88),
(81, 59, 88),
(80, 59, 88),
(90, 60, 89),
(91, 60, 89),
(92, 60, 89),
(93, 60, 89),
(94, 60, 89),
(95, 60, 89),
(96, 60, 89),
(97, 60, 89),
(98, 60, 89),
(99, 60, 89),
(35, 60, 90),
(45, 60, 90),
(55, 60, 90),
(65, 60, 90),
(66, 60, 90),
(67, 60, 90),
(57, 60, 90),
(47, 60, 90),
(37, 60, 90),
(36, 60, 90),
(46, 60, 90),
(56, 60, 90),
(25, 60, 90),
(24, 60, 90),
(34, 60, 90),
(13, 60, 90),
(23, 60, 90),
(90, 44, 91),
(80, 44, 91),
(70, 44, 91),
(50, 44, 91),
(60, 44, 91),
(40, 44, 91),
(30, 44, 91),
(20, 44, 91),
(10, 44, 91),
(91, 44, 92),
(90, 44, 92),
(92, 44, 92),
(93, 44, 92),
(94, 44, 92),
(95, 44, 92),
(96, 44, 92),
(97, 44, 92),
(98, 44, 92),
(90, 49, 93),
(91, 49, 93),
(92, 49, 93),
(93, 49, 93),
(94, 49, 93),
(95, 49, 93),
(96, 49, 93),
(97, 49, 93),
(98, 49, 93),
(90, 67, 94),
(80, 67, 94),
(70, 67, 94),
(60, 67, 94),
(50, 67, 94),
(40, 67, 94),
(30, 67, 94),
(90, 67, 95),
(91, 67, 95),
(92, 67, 95),
(93, 67, 95),
(94, 67, 95),
(95, 67, 95),
(96, 67, 95),
(97, 67, 95),
(98, 67, 95),
(99, 67, 96),
(89, 67, 96),
(79, 67, 96),
(69, 67, 96),
(59, 67, 96),
(30, 45, 97),
(40, 45, 97),
(50, 45, 97),
(60, 45, 97),
(70, 45, 97),
(80, 45, 97),
(20, 45, 97),
(89, 44, 98),
(79, 44, 98),
(69, 44, 98),
(59, 44, 98),
(49, 44, 98),
(39, 44, 98),
(29, 44, 98),
(90, 52, 99),
(80, 52, 99),
(70, 52, 99),
(60, 52, 99),
(50, 52, 99),
(99, 52, 100),
(89, 52, 100),
(79, 52, 100),
(69, 52, 100),
(59, 52, 100),
(49, 52, 100),
(99, 52, 101),
(89, 52, 101),
(79, 52, 101),
(69, 52, 101),
(59, 52, 101),
(49, 52, 101),
(90, 52, 102),
(80, 52, 102),
(70, 52, 102),
(60, 52, 102),
(50, 52, 102),
(24, 68, 103),
(34, 68, 103),
(35, 68, 103),
(36, 68, 103),
(26, 68, 103),
(25, 68, 103),
(14, 68, 103),
(15, 68, 103),
(16, 68, 103),
(90, 68, 104),
(91, 68, 104),
(92, 68, 104),
(93, 68, 104),
(94, 68, 104),
(95, 68, 104),
(80, 68, 104),
(81, 68, 104),
(82, 68, 104),
(83, 68, 104),
(84, 68, 104),
(73, 68, 104),
(72, 68, 104),
(71, 68, 104),
(70, 68, 104),
(60, 68, 104),
(61, 68, 104),
(62, 68, 104),
(51, 68, 104),
(50, 68, 104),
(40, 68, 104),
(90, 62, 105),
(91, 62, 105),
(92, 62, 105),
(93, 62, 105),
(94, 62, 105),
(95, 62, 105),
(80, 62, 105),
(81, 62, 105),
(82, 62, 105),
(72, 62, 105),
(71, 62, 105),
(70, 62, 105),
(60, 62, 105),
(61, 62, 105),
(50, 62, 105),
(84, 62, 105),
(83, 62, 105),
(73, 62, 105),
(62, 62, 105),
(51, 62, 105),
(40, 62, 105),
(96, 62, 105),
(97, 62, 105),
(98, 62, 105),
(86, 62, 105),
(85, 62, 105),
(74, 62, 105),
(63, 62, 105),
(98, 62, 106),
(97, 62, 106),
(96, 62, 106),
(95, 62, 106),
(94, 62, 106),
(93, 62, 106),
(92, 62, 106),
(91, 62, 106),
(90, 62, 106),
(86, 62, 106),
(85, 62, 106),
(84, 62, 106),
(83, 62, 106),
(82, 62, 106),
(81, 62, 106),
(80, 62, 106),
(74, 62, 106),
(73, 62, 106),
(72, 62, 106),
(71, 62, 106),
(70, 62, 106),
(63, 62, 106),
(62, 62, 106),
(61, 62, 106),
(60, 62, 106),
(51, 62, 106),
(50, 62, 106),
(40, 62, 106),
(7, 62, 107),
(8, 62, 107),
(9, 62, 107),
(19, 62, 107),
(18, 62, 107),
(17, 62, 107),
(5, 62, 107),
(6, 62, 107),
(16, 62, 107),
(27, 62, 107),
(28, 62, 107),
(29, 62, 107),
(39, 62, 107),
(38, 62, 107),
(4, 62, 107),
(15, 62, 107),
(26, 62, 107),
(37, 62, 107),
(48, 62, 107),
(49, 62, 107),
(59, 62, 107),
(26, 67, 108),
(27, 67, 108),
(28, 67, 108),
(29, 67, 108),
(39, 67, 108),
(38, 67, 108),
(37, 67, 108),
(36, 67, 108),
(46, 67, 108),
(47, 67, 108),
(48, 67, 108),
(49, 67, 108),
(59, 67, 108),
(58, 67, 108),
(57, 67, 108),
(56, 67, 108),
(35, 67, 108),
(45, 67, 108),
(25, 67, 108),
(19, 67, 108),
(18, 67, 108),
(17, 67, 108),
(16, 67, 108),
(15, 67, 108),
(68, 67, 108),
(69, 67, 108),
(0, 66, 109),
(1, 66, 109),
(2, 66, 109),
(3, 66, 109),
(4, 66, 109),
(5, 66, 109),
(6, 66, 109),
(7, 66, 109),
(8, 66, 109),
(9, 66, 109),
(10, 66, 109),
(19, 66, 109),
(20, 66, 109),
(30, 66, 109),
(40, 66, 109),
(50, 66, 109),
(60, 66, 109),
(70, 66, 109),
(80, 66, 109),
(90, 66, 109),
(91, 66, 109),
(92, 66, 109),
(94, 66, 109),
(93, 66, 109),
(96, 66, 109),
(95, 66, 109),
(97, 66, 109),
(98, 66, 109),
(99, 66, 109),
(89, 66, 109),
(79, 66, 109),
(69, 66, 109),
(59, 66, 109),
(49, 66, 109),
(39, 66, 109),
(29, 66, 109),
(14, 65, 110),
(15, 65, 110),
(16, 65, 110),
(27, 65, 110),
(26, 65, 110),
(25, 65, 110),
(24, 65, 110),
(23, 65, 110),
(33, 65, 110),
(34, 65, 110),
(35, 65, 110),
(36, 65, 110),
(37, 65, 110),
(47, 65, 110),
(46, 65, 110),
(45, 65, 110),
(44, 65, 110),
(43, 65, 110),
(53, 65, 110),
(54, 65, 110),
(55, 65, 110),
(56, 65, 110),
(57, 65, 110),
(67, 65, 110),
(65, 65, 110),
(64, 65, 110),
(63, 65, 110),
(73, 65, 110),
(74, 65, 110),
(75, 65, 110),
(76, 65, 110),
(90, 65, 111),
(91, 65, 111),
(92, 65, 111),
(93, 65, 111),
(94, 65, 111),
(95, 65, 111),
(96, 65, 111),
(97, 65, 111),
(98, 65, 111),
(99, 65, 111),
(82, 65, 111),
(81, 65, 111),
(80, 65, 111),
(70, 65, 111),
(71, 65, 111),
(60, 65, 111),
(50, 65, 111),
(61, 65, 111),
(40, 65, 111),
(51, 65, 111),
(72, 65, 111),
(41, 68, 112),
(51, 68, 112),
(61, 68, 112),
(62, 68, 112),
(52, 68, 112),
(42, 68, 112),
(43, 68, 112),
(53, 68, 112),
(63, 68, 112),
(34, 66, 113),
(44, 66, 113),
(54, 66, 113),
(64, 66, 113),
(74, 66, 113),
(75, 66, 113),
(65, 66, 113),
(55, 66, 113),
(45, 66, 113),
(35, 66, 113),
(36, 66, 113),
(46, 66, 113),
(56, 66, 113),
(66, 66, 113),
(76, 66, 113),
(73, 66, 113),
(63, 66, 113),
(53, 66, 113),
(43, 66, 113),
(33, 66, 113),
(0, 59, 114),
(10, 59, 114),
(20, 59, 114),
(30, 59, 114),
(40, 59, 114),
(50, 59, 114),
(60, 59, 114),
(70, 59, 114),
(9, 73, 115),
(19, 73, 115),
(29, 73, 115),
(39, 73, 115),
(49, 73, 115),
(59, 73, 115),
(69, 73, 115),
(79, 73, 115),
(89, 73, 115),
(99, 73, 115),
(0, 73, 116),
(10, 73, 116),
(20, 73, 116),
(30, 73, 116),
(40, 73, 116),
(50, 73, 116),
(60, 73, 116),
(70, 73, 116),
(80, 73, 116),
(90, 73, 116),
(93, 74, 117),
(94, 74, 117),
(95, 74, 117),
(92, 74, 117),
(91, 74, 117),
(90, 74, 117),
(96, 74, 117),
(97, 74, 117),
(98, 74, 117),
(99, 74, 117),
(42, 74, 118),
(32, 74, 118),
(33, 74, 118),
(34, 74, 118),
(44, 74, 118),
(43, 74, 118),
(52, 74, 118),
(53, 74, 118),
(54, 74, 118),
(64, 74, 118),
(63, 74, 118),
(62, 74, 118),
(72, 74, 118),
(73, 74, 118),
(74, 74, 118),
(84, 74, 118),
(83, 74, 118),
(82, 74, 118),
(9, 74, 119),
(19, 74, 119),
(29, 74, 119),
(39, 74, 119),
(49, 74, 119),
(59, 74, 119),
(69, 74, 119),
(79, 74, 119),
(89, 74, 119),
(91, 73, 120),
(92, 73, 120),
(93, 73, 120),
(94, 73, 120),
(95, 73, 120),
(96, 73, 120),
(97, 73, 120),
(98, 73, 120),
(0, 60, 121),
(90, 60, 121),
(80, 60, 121),
(70, 60, 121),
(60, 60, 121),
(50, 60, 121),
(40, 60, 121),
(30, 60, 121),
(20, 60, 121),
(10, 60, 121),
(9, 60, 122),
(19, 60, 122),
(29, 60, 122),
(39, 60, 122),
(49, 60, 122),
(59, 60, 122),
(69, 60, 122),
(79, 60, 122),
(89, 60, 122),
(99, 60, 122),
(9, 59, 123),
(19, 59, 123),
(29, 59, 123),
(39, 59, 123),
(49, 59, 123),
(59, 59, 123),
(69, 59, 123),
(79, 59, 123),
(89, 59, 123),
(99, 59, 123),
(73, 62, 124),
(0, 62, 125),
(73, 62, 126),
(74, 62, 126),
(75, 62, 126),
(83, 62, 126),
(84, 62, 126),
(85, 62, 126),
(93, 62, 126),
(94, 62, 126),
(95, 62, 126),
(73, 62, 127),
(74, 62, 127),
(75, 62, 127),
(83, 62, 127),
(84, 62, 127),
(85, 62, 127),
(93, 62, 127),
(94, 62, 127),
(95, 62, 127),
(20, 62, 128),
(30, 62, 128),
(40, 62, 128),
(50, 62, 128),
(60, 62, 128),
(70, 62, 128),
(80, 62, 128),
(90, 62, 128),
(41, 62, 128),
(51, 62, 128),
(61, 62, 128),
(71, 62, 128),
(81, 62, 128),
(91, 62, 128),
(62, 62, 128),
(72, 62, 128),
(82, 62, 128),
(92, 62, 128),
(23, 42, 0),
(22, 42, 0),
(24, 42, 0),
(25, 42, 0),
(26, 42, 0),
(32, 42, 0),
(33, 42, 0),
(34, 42, 0),
(35, 42, 0),
(36, 42, 0),
(42, 42, 0),
(43, 42, 0),
(44, 42, 0),
(45, 42, 0),
(46, 42, 0),
(52, 42, 0),
(53, 42, 0),
(54, 42, 0),
(55, 42, 0),
(56, 42, 0),
(62, 42, 0),
(63, 42, 0),
(64, 42, 0),
(65, 42, 0),
(66, 42, 0),
(72, 42, 0),
(73, 42, 0),
(74, 42, 0),
(75, 42, 0),
(76, 42, 0),
(76, 42, 49),
(75, 42, 49),
(74, 42, 49),
(73, 42, 49),
(72, 42, 49),
(66, 42, 49),
(65, 42, 49),
(64, 42, 49),
(63, 42, 49),
(62, 42, 49),
(56, 42, 49),
(55, 42, 49),
(54, 42, 49),
(53, 42, 49),
(52, 42, 49),
(46, 42, 49),
(45, 42, 49),
(44, 42, 49),
(43, 42, 49),
(42, 42, 49),
(36, 42, 49),
(35, 42, 49),
(34, 42, 49),
(33, 42, 49),
(32, 42, 49),
(26, 42, 49),
(25, 42, 49),
(24, 42, 49),
(23, 42, 49),
(22, 42, 49);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `event` varchar(255) character set latin1 NOT NULL,
  `event_label` varchar(255) character set latin1 NOT NULL,
  `event_value` varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event`, `event_label`, `event_value`) VALUES
(22, 'event_link', 'link', '21'),
(24, 'event_link', 'link', '22'),
(50, 'event_link', 'link', '31'),
(51, 'event_assign', 'Assign value', '$direction = ''east'';\n$bucket = ''on_ground'';'),
(53, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''WEST'';'),
(54, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH_EAST'';'),
(55, 'event_link', 'link', '34'),
(57, 'event_assign', 'Assign value', '$path1 = $direction; '),
(58, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''EAST'';'),
(59, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH'';'),
(60, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''NORTH'';'),
(61, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH_EAST'';'),
(62, 'event_link', 'link', '33'),
(64, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''DETAIL'';'),
(65, 'event_link', 'link', '31'),
(66, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH'';'),
(67, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''NORTH'';'),
(68, 'event_assign', 'Assign value', '$building1 = $direction'),
(69, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''WEST'';'),
(70, 'event_link', 'link', '36'),
(71, 'event_link', 'link', '35'),
(72, 'event_assign', 'Assign value', '$path2 = $direction;'),
(73, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''EAST'';'),
(74, 'event_link', 'link', '31'),
(75, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_DOWN'';'),
(76, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = '''';'),
(77, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_MID'';'),
(78, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_MID'';'),
(79, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX1_CLOSED'';'),
(80, 'event_link', 'link', '34'),
(81, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX1_OPEN'';'),
(82, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = '''';'),
(83, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_MID'';'),
(84, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = '''';'),
(85, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_MID'';'),
(86, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX1_CLOSED'';'),
(87, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX1_CLOSED'';'),
(88, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX2_CLOSED'';'),
(89, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = '''';'),
(90, 'event_assign', 'Assign value', '$building2 = ''DETAIL_MID'';'),
(91, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX2_CLOSED'';'),
(92, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_BOX2_OPEN'';'),
(93, 'event_assignrefresh', 'Assign value and scene refresh', '$building2 = ''DETAIL_MID'';'),
(94, 'event_assign', 'Assign value', '$path3 = $direction;'),
(95, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''west'';'),
(96, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''east'';'),
(97, 'event_link', 'link', '34'),
(98, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH'';'),
(99, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''EAST'';'),
(100, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''NORTH'';'),
(102, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''WEST'';'),
(103, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''SOUTH'';'),
(104, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''EAST'';'),
(105, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''NORTH'';'),
(106, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''NORTH'';'),
(107, 'event_link', 'link', '36'),
(108, 'event_link', 'link', '31'),
(109, 'event_assign', 'Assign value', '$direction = ''WEST'';'),
(110, 'event_assign', 'Assign value', '$direction = ''EAST'';'),
(111, 'event_link', 'link', '40'),
(112, 'event_link', 'link', '37'),
(114, 'event_assign', 'Assign value', '$direction = ''NORTH'';'),
(115, 'event_link', 'link', '41'),
(116, 'event_link', 'link', '37'),
(117, 'event_assignrefresh', 'Assign value and scene refresh', '$well = '''';'),
(118, 'event_assignrefresh', 'Assign value and scene refresh', '$well = ''DETAIL'';'),
(119, 'event_link', 'link', '41'),
(120, 'event_message', 'User Message', 'I don''t think so Mario. '),
(121, 'event_assign', 'Assign value', '$direction = ''north'';'),
(122, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''east'';'),
(124, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''north'';'),
(125, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''east'';'),
(126, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''west'';'),
(127, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''south'';'),
(128, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''south'';'),
(129, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''north'';'),
(130, 'event_assignrefresh', 'Assign value and scene refresh', '$direction = ''south'';'),
(133, 'event_message', 'User Message', 'You picked up the bucket!'),
(134, 'event_assignrefreshitems', 'Assign value and item refresh', '$bucket = ''picked_up'';'),
(135, 'event_link', 'link', '31');

-- --------------------------------------------------------

--
-- Table structure for table `grids_events`
--

CREATE TABLE IF NOT EXISTS `grids_events` (
  `grid_event_id` bigint(20) unsigned NOT NULL auto_increment,
  `scene_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`grid_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=129 ;

--
-- Dumping data for table `grids_events`
--

INSERT INTO `grids_events` (`grid_event_id`, `scene_id`, `event_id`) VALUES
(1, 22, 1),
(2, 23, 2),
(3, 23, 3),
(4, 24, 4),
(5, 24, 5),
(6, 24, 6),
(7, 24, 7),
(8, 24, 8),
(9, 22, 9),
(10, 22, 10),
(11, 23, 11),
(12, 23, 12),
(13, 25, 13),
(15, 26, 15),
(16, 23, 16),
(24, 26, 24),
(43, 25, 44),
(49, 42, 50),
(50, 45, 53),
(51, 45, 54),
(52, 45, 55),
(53, 45, 56),
(54, 47, 58),
(55, 47, 59),
(56, 46, 60),
(57, 46, 61),
(58, 46, 62),
(59, 48, 63),
(60, 48, 64),
(61, 50, 65),
(62, 50, 66),
(63, 48, 67),
(64, 51, 69),
(65, 51, 70),
(66, 51, 71),
(67, 61, 73),
(68, 61, 74),
(69, 52, 75),
(70, 53, 76),
(71, 53, 77),
(72, 52, 78),
(73, 52, 79),
(74, 52, 80),
(75, 55, 81),
(76, 55, 82),
(77, 55, 83),
(78, 56, 84),
(79, 56, 85),
(80, 56, 86),
(81, 54, 87),
(82, 54, 88),
(83, 54, 89),
(84, 57, 90),
(85, 57, 91),
(86, 58, 92),
(87, 58, 93),
(88, 59, 95),
(89, 60, 96),
(90, 60, 97),
(91, 44, 98),
(92, 44, 99),
(93, 49, 100),
(94, 67, 102),
(95, 67, 103),
(96, 67, 104),
(97, 45, 105),
(98, 44, 106),
(99, 52, 107),
(100, 52, 108),
(101, 52, 109),
(102, 52, 110),
(103, 68, 111),
(104, 68, 112),
(105, 62, 113),
(106, 62, 114),
(107, 62, 115),
(108, 67, 116),
(109, 66, 117),
(110, 65, 118),
(111, 65, 119),
(112, 68, 122),
(113, 66, 120),
(114, 59, 121),
(115, 73, 122),
(116, 73, 123),
(117, 74, 124),
(118, 74, 125),
(119, 74, 126),
(120, 73, 127),
(121, 60, 128),
(122, 60, 129),
(123, 59, 130),
(124, 62, 131),
(125, 62, 132),
(126, 62, 133),
(127, 62, 134),
(128, 62, 135);

-- --------------------------------------------------------

--
-- Table structure for table `grids_items`
--

CREATE TABLE IF NOT EXISTS `grids_items` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `itemdef_id` bigint(20) unsigned NOT NULL,
  `scene_id` bigint(20) unsigned NOT NULL,
  `cell_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) character set latin1 NOT NULL,
  `slug` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_id` (`itemdef_id`),
  KEY `scene_id` (`scene_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `grids_items`
--

INSERT INTO `grids_items` (`id`, `itemdef_id`, `scene_id`, `cell_id`, `title`, `slug`) VALUES
(1, 2, 71, 74, 'item 2', 'item_2'),
(3, 2, 62, 73, 'bucket', 'bucket');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL auto_increment,
  `story_id` bigint(20) NOT NULL,
  `type_id` int(11) unsigned NOT NULL,
  `filename` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `story_id`, `type_id`, `filename`) VALUES
(14, 3, 1, 'DSC_0528.JPG'),
(16, 3, 1, 'DSC_0557.JPG'),
(17, 3, 1, 'DSC_0527.JPG'),
(18, 3, 1, 'DSC_0551.JPG'),
(19, 3, 1, 'DSC_0541.JPG'),
(20, 3, 1, 'DSC_0552.JPG'),
(21, 3, 1, 'DSC_0553.JPG'),
(22, 3, 1, 'DSC_0554.JPG'),
(23, 3, 1, 'DSC_0559.JPG'),
(24, 3, 1, 'DSC_0560.JPG'),
(25, 3, 1, 'DSC_0561.JPG'),
(26, 3, 1, 'DSC_0565.JPG'),
(27, 3, 1, 'DSC_0574.JPG'),
(28, 3, 1, 'DSC_0578.JPG'),
(29, 3, 1, 'DSC_0586.JPG'),
(30, 3, 1, 'DSC_0583.JPG'),
(31, 3, 1, 'DSC_0604.JPG'),
(32, 3, 1, 'DSC_0605.JPG'),
(33, 3, 1, 'DSC_0608.JPG'),
(34, 3, 1, 'DSC_0612.JPG'),
(35, 3, 1, 'DSC_0614.JPG'),
(36, 3, 1, 'DSC_0615.JPG'),
(37, 3, 1, 'DSC_0616.JPG'),
(38, 3, 1, 'DSC_0621.JPG'),
(39, 3, 1, 'DSC_0249.JPG'),
(40, 3, 1, 'DSC_0244b.jpg'),
(42, 3, 2, 'bucket.png');

-- --------------------------------------------------------

--
-- Table structure for table `image_types`
--

CREATE TABLE IF NOT EXISTS `image_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `image_types`
--

INSERT INTO `image_types` (`id`, `title`) VALUES
(1, 'scene'),
(2, 'item');

-- --------------------------------------------------------

--
-- Table structure for table `itemdefs`
--

CREATE TABLE IF NOT EXISTS `itemdefs` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `story_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `itemdefs`
--

INSERT INTO `itemdefs` (`id`, `title`, `story_id`) VALUES
(2, 'bucket', 3);

-- --------------------------------------------------------

--
-- Table structure for table `items_states`
--

CREATE TABLE IF NOT EXISTS `items_states` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `item_id` bigint(20) unsigned NOT NULL,
  `image_id` bigint(20) unsigned NOT NULL,
  `value` varchar(255) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `items_states`
--

INSERT INTO `items_states` (`id`, `item_id`, `image_id`, `value`) VALUES
(1, 1, 41, 'on_ground'),
(2, 1, 0, 'taken'),
(3, 2, 42, 'on_ground'),
(4, 2, 0, 'picked_up');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `story_id` bigint(20) unsigned NOT NULL,
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`story_id`, `id`, `title`) VALUES
(3, 30, 'Stairs'),
(3, 31, 'Path1'),
(3, 33, 'Building1'),
(3, 34, 'Path2'),
(3, 35, 'Building2'),
(3, 36, 'Path3'),
(3, 37, 'Poison Ivy Field'),
(3, 40, 'Well'),
(3, 41, 'Poison Ivy Field2');

-- --------------------------------------------------------

--
-- Table structure for table `locations_events`
--

CREATE TABLE IF NOT EXISTS `locations_events` (
  `location_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `locationid` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations_events`
--

INSERT INTO `locations_events` (`location_id`, `event_id`) VALUES
(25, 39),
(31, 57),
(33, 68),
(34, 72),
(36, 94),
(31, 101),
(41, 121),
(31, 123),
(43, 122);

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `label` varchar(255) character set latin1 NOT NULL,
  `description` text character set latin1 NOT NULL,
  `class` varchar(255) character set latin1 NOT NULL,
  `hooks` text character set latin1 NOT NULL,
  `status` char(1) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `label`, `description`, `class`, `hooks`, `status`) VALUES
(9, 'Debug', 'Debug Plugin for PCP', 'plugin_debug', 'display_post_scene,error', '1'),
(10, 'helloworld', 'This is the helloworld demonstration plugin', 'plugin_helloworld', 'post_start_story,display_pre_scene,display_post_scene', '0');

-- --------------------------------------------------------

--
-- Table structure for table `scenes`
--

CREATE TABLE IF NOT EXISTS `scenes` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `story_id` bigint(20) unsigned NOT NULL,
  `location_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `image_id` bigint(20) default NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `scene_value` (`value`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `scenes`
--

INSERT INTO `scenes` (`id`, `story_id`, `location_id`, `title`, `description`, `image_id`, `value`) VALUES
(42, 3, 30, 'Stairs', 'You see some old stairs. Dare you go down them?', 14, ''),
(44, 3, 31, 'Bottom of Stairs', 'You are on a wooded pathway covered in a thick layer of pine needles. These are the stairs you came down. ', 17, 'west'),
(45, 3, 31, 'Bottom of Stairs', 'You are on a wooded pathway covered in a thick layer of pine needles. There is a river here with old equipment. ', 16, 'east'),
(46, 3, 31, 'Bottom of Stairs', 'You are on a wooded pathway covered in a thick layer of pine needles. There is ruined equipment by the river. ', 18, 'south'),
(47, 3, 31, 'Bottom of Stairs', 'You are on a wooded pathway covered in a thick layer of pine needles. You can see the river through the trees. ', 19, 'south_east'),
(48, 3, 33, 'Building1', 'This appears to the the ruins of an old pumping station.', 20, 'south'),
(49, 3, 33, 'Building1', 'Nothing interesting inside.', 21, 'detail'),
(50, 3, 33, 'Building1', 'This path leads back to the bottom of the stairs. ', 22, 'north'),
(51, 3, 34, 'Path2', 'You are on a wooded pathway covered in thick pine needles. There is a large piece of old metal equipment rusting beside the river.', 23, 'east'),
(52, 3, 35, 'Building2', 'There is a large piece of old metal equipment rusting beside the river.', 24, ''),
(53, 3, 35, 'Building2', 'Thick stagnant water lies below the rusting equipment. It is covered in an oily film. ', 25, 'detail_down'),
(54, 3, 35, 'Building2', 'The river flows lazily behind the rusting equipment. ', 26, 'detail_mid'),
(55, 3, 35, 'Building2', 'There is a rusting box here. ', 27, 'detail_box1_closed'),
(56, 3, 35, 'Building2', 'The rusting box is full of pine needles.', 28, 'detail_box1_open'),
(57, 3, 35, 'Building2', 'The river runs lazily behind the rusting equipment. The rusting electrical box is open.', 29, 'detail_box2_open'),
(58, 3, 35, 'Building2', 'The river runs lazily behind the rusting equipment. There is a partially open rusting electrical box here. ', 30, 'detail_box2_closed'),
(59, 3, 36, 'Path3', 'The path east is blocked by a fallen tree. ', 31, 'east'),
(60, 3, 36, 'Path3', 'You are on a wooden path that follows the river. Ahead is rusting equipment and some stairs. ', 32, 'west'),
(61, 3, 34, 'Path2', 'You are on a wooded pathway covered in thick pine needles. Behind you is a large piece of old metal equipment rusting beside the river.', 33, 'west'),
(62, 3, 37, 'Poison Ivy Field', 'You are in a field full of poison ivy!', 35, ''),
(65, 3, 40, 'Well', 'You are standing above an unmarked well that is protruding from the forest floor. How dangerous! Someone could fall in!', 37, ''),
(66, 3, 40, 'Well', 'You peer into the well and see the bottom is filled with mud and sticks. ', 38, 'detail'),
(67, 3, 31, 'Bottom of Stairs', 'You are on a wooded pathway covered in a thick layer of pine needles. In front of you the woods are overgrown with poison ivy.', 34, 'north'),
(68, 3, 41, 'Poison Ivy Field2', 'You are in a field full of poison ivy! There is a cement pipe protruding from the ground. ', 36, ''),
(73, 3, 36, 'Path3', '', 39, 'north'),
(74, 3, 36, 'Path3', 'The river flows lazily beyond the trees', 40, 'south');

-- --------------------------------------------------------

--
-- Table structure for table `scenes_events`
--

CREATE TABLE IF NOT EXISTS `scenes_events` (
  `scene_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `sceneid` (`scene_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scenes_events`
--

INSERT INTO `scenes_events` (`scene_id`, `event_id`) VALUES
(45, 52),
(68, 120),
(71, 121);

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE IF NOT EXISTS `stories` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `first_location_id` bigint(20) unsigned default NULL,
  `image_id` bigint(20) default NULL,
  `status` char(1) NOT NULL,
  `grid_x` smallint(5) unsigned NOT NULL,
  `grid_y` smallint(5) unsigned NOT NULL,
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `author`, `description`, `first_location_id`, `image_id`, `status`, `grid_x`, `grid_y`, `create_date`) VALUES
(3, 'River Path', 'Dan', 'Explore the old equipment by the river', 30, 24, 'p', 10, 10, '2010-10-07 18:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `stories_events`
--

CREATE TABLE IF NOT EXISTS `stories_events` (
  `story_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  KEY `storyid` (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stories_events`
--

INSERT INTO `stories_events` (`story_id`, `event_id`) VALUES
(2, 36),
(3, 51),
(5, 120);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL default '',
  `password` char(50) NOT NULL,
  `active` tinyint(4) default '1',
  `logins` int(10) unsigned NOT NULL default '0',
  `last_ip_address` varchar(15) default NULL,
  `last_login` datetime default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `active`, `logins`, `last_ip_address`, `last_login`, `created`) VALUES
(36, 'admin@localhost', 'admin', '2e80e939646125be46ab1da1b93e2c8745332648', 1, 0, '127.0.0.1', NULL, '2010-10-09 00:12:25');
