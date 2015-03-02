-- MySQL dump 10.10
--
-- Host: localhost    Database: wassail
-- ------------------------------------------------------
-- Server version	5.0.26-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `right_read` tinyint(1) NOT NULL,
  `right_write` tinyint(1) NOT NULL,
  `right_write_unconditional` tinyint(1) NOT NULL,
  `right_report` tinyint(1) NOT NULL,
  `right_help` tinyint(1) NOT NULL,
  `right_account` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `instance_id` (`instance_id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `position` smallint(6) NOT NULL default '1',
  `asked` tinyint(1) default '0',
  `date_added` int(11) NOT NULL default '0',
  `correct` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `instance_id` (`instance_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9264 DEFAULT CHARSET=latin1;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `text` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `number` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `instructor` varchar(255) default NULL,
  `date_added` int(11) default NULL,
  `asked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`),
  KEY `instance_id` (`instance_id`),
  KEY `number` (`number`),
  KEY `name` (`name`),
  KEY `asked` (`asked`)
) ENGINE=MyISAM AUTO_INCREMENT=500 DEFAULT CHARSET=latin1;

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
CREATE TABLE `help` (
  `page` varchar(255) NOT NULL,
  `content` longtext,
  PRIMARY KEY  (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `instance`
--

DROP TABLE IF EXISTS `instance`;
CREATE TABLE `instance` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `plaintext` text NOT NULL,
  `tags` text,
  `type` enum('multiple','single','qualitative') NOT NULL default 'single',
  `qualitative_type` enum('long','short') default 'long',
  `date_added` int(11) NOT NULL default '0',
  `asked` tinyint(1) NOT NULL default '0',
  `opt_out` varchar(255) NOT NULL default 'I prefer not to answer/not applicable',
  PRIMARY KEY  (`id`),
  KEY `instance_id` (`instance_id`),
  KEY `date_added` (`date_added`),
  FULLTEXT KEY `plaintext` (`plaintext`)
) ENGINE=MyISAM AUTO_INCREMENT=2333 DEFAULT CHARSET=latin1;

--
-- Table structure for table `question_category`
--

DROP TABLE IF EXISTS `question_category`;
CREATE TABLE `question_category` (
  `question_id` int(11) default NULL,
  `category_id` int(11) default NULL,
  KEY `ids` (`question_id`,`category_id`),
  KEY `category_id` (`category_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `question_template`
--

DROP TABLE IF EXISTS `question_template`;
CREATE TABLE `question_template` (
  `question_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`question_id`,`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE `response` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `response_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `questionnaire_type` int(11) default NULL,
  `school_year` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `response_id` (`response_id`),
  KEY `number` (`number`),
  KEY `template_id` (`template_id`),
  KEY `course_id` (`course_id`),
  KEY `term` (`term`),
  KEY `questionnaire_type` (`questionnaire_type`),
  KEY `school_year` (`school_year`)
) ENGINE=MyISAM AUTO_INCREMENT=540016 DEFAULT CHARSET=latin1;

--
-- Table structure for table `response_id`
--

DROP TABLE IF EXISTS `response_id`;
CREATE TABLE `response_id` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=177166 DEFAULT CHARSET=latin1;

--
-- Table structure for table `response_qualitative`
--

DROP TABLE IF EXISTS `response_qualitative`;
CREATE TABLE `response_qualitative` (
  `question_response_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`question_response_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `sid` varchar(128) default NULL,
  `time` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
CREATE TABLE `template` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_added` int(11) NOT NULL,
  `asked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `instance_id` (`instance_id`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1535 DEFAULT CHARSET=latin1;

--
-- Table structure for table `web_form`
--

DROP TABLE IF EXISTS `web_form`;
CREATE TABLE `web_form` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) default NULL,
  `template_id` int(11) default NULL,
  `course_id` int(11) default NULL,
  `term` int(11) default NULL,
  `questionnaire_type` int(11) default NULL,
  `school_year` varchar(255) default NULL,
  `expiry_date` int(11) default NULL,
  `number` int(11) default '0',
  `public` tinyint(1) default '0',
  `intro` text,
  `file_request` text,
  `name` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=609 DEFAULT CHARSET=latin1;

--
-- Table structure for table `web_form_account`
--

DROP TABLE IF EXISTS `web_form_account`;
CREATE TABLE `web_form_account` (
  `form_id` int(11) default NULL,
  `password` varchar(128) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-08-12 19:04:31
