-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 31, 2012 at 03:58 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ai_kiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(30) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`) VALUES
(1, 'Design'),
(2, 'Media Arts'),
(3, 'Fashion'),
(4, 'Culinary');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_filename` varchar(250) NOT NULL,
  `image_alt` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `image`
--


-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `prog_id` int(11) NOT NULL AUTO_INCREMENT,
  `prog_name` varchar(80) NOT NULL,
  `prog_imagefile` varchar(150) NOT NULL,
  `area_id` int(11) NOT NULL,
  PRIMARY KEY (`prog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`prog_id`, `prog_name`, `prog_imagefile`, `area_id`) VALUES
(1, 'Advertising', 'program_advertising.png', 1),
(2, 'Graphic Design', 'program_graphic.png', 1),
(3, 'Industrial Design', 'program_industrial.png', 1),
(4, 'Interior Design', 'program_interior.png', 1),
(5, 'Web Design & Interactive Media', 'program_web.png', 2),
(6, 'Animation & Special Effects', 'program_animation.png', 2),
(7, 'Photography', 'program_photography.png', 2),
(8, 'Game Design & Programming', 'program_game.png', 2),
(9, 'Audio, Video & Film Production', 'program_audio.png', 2),
(10, 'Fashion Design', 'program_fashion.png', 3),
(11, 'Fashion Management', 'program_fashionman.png', 3),
(12, 'Culinary Arts', 'program_culinaryarts.png', 4),
(13, 'Baking & Pastry Arts', 'program_baking.png', 4),
(14, 'Culinary Management', 'program_culinaryman.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_title` varchar(34) DEFAULT 'Untitled',
  `project_author` varchar(34) NOT NULL,
  `project_description` text,
  `prog_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `project`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `salt` int(10) unsigned NOT NULL,
  `user_password` char(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `salt`, `user_password`, `email`) VALUES
(1, 'harrypotter', 1345237270, '6546d7b2903b80655e944f60eeb573714a1eefeb', 'jaypatrickm@gmail.com'),
(2, 'hermionegranger', 1346363296, '12004051c69fc722072c7bb0e478b823475b0ef2', 'jay@gmail.com'),
(4, 'remuslupin', 1346365581, 'ee94c6438baf04c6ea1d923cfd0b5044248220b9', 'rlupin@gmail.com'),
(5, 'rubeushagrid', 1346365614, '7e995bde94135a699bb0261d08e58bfafd787458', 'rhagrid@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_filename` varchar(250) NOT NULL,
  `video_alt` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `video`
--

