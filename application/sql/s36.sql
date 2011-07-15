-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2011 at 02:09 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `s36`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('categoryManager', '1', NULL, NULL),
('feedbackManager', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('addAdmin', 0, 'viewAdmin', NULL, 'N;'),
('addCategory', 0, 'addCategory', NULL, 'N;'),
('adminManager', 2, '', NULL, 'N;'),
('archiveFeedback', 0, 'archiveFeedback', NULL, 'N;'),
('baseEditAdmin', 0, 'viewAdmin', NULL, 'N;'),
('baseEditCategory', 0, 'baseEditCategory', NULL, 'N;'),
('baseEditFeedback', 0, 'baseEditFeedback', NULL, 'N;'),
('categoryManager', 2, '', NULL, 'N;'),
('changePriorityFeedback', 0, 'changePriorityFeedback', NULL, 'N;'),
('changeStatusFeedback', 0, 'changeStatusFeedback', NULL, 'N;'),
('deleteAdmin', 0, 'viewAdmin', NULL, 'N;'),
('deleteCategory', 0, 'deleteCategory', NULL, 'N;'),
('deleteFeedback', 0, 'deleteFeedback', NULL, 'N;'),
('editAdmin', 1, 'editAdmin', NULL, 'N;'),
('editCategory', 1, 'editCategory', NULL, 'N;'),
('editFeedback', 1, 'editFeedback', NULL, 'N;'),
('feedbackManager', 2, '', NULL, 'N;'),
('formManager', 2, '', NULL, 'N;'),
('moveFeedback', 0, 'moveFeedback', NULL, 'N;'),
('publishFeedback', 0, 'publishFeedback', NULL, 'N;'),
('setFlaggedFeedback', 0, 'setFlaggedFeedback', NULL, 'N;'),
('setStickyFeedback', 0, 'setStickyFeedback', NULL, 'N;'),
('siteManager', 2, '', NULL, 'N;'),
('viewAdmin', 0, 'viewAdmin', NULL, 'N;'),
('viewCategory', 0, 'viewCategory', NULL, 'N;'),
('viewFeedback', 0, 'viewFeedback', NULL, 'N;'),
('viewForm', 0, 'viewForm', NULL, 'N;'),
('viewSite', 0, 'viewSite', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthItemChild`
--

INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
('editAdmin', 'addAdmin'),
('editCategory', 'addCategory'),
('editFeedback', 'archiveFeedback'),
('editAdmin', 'baseEditAdmin'),
('editCategory', 'baseEditCategory'),
('editFeedback', 'baseEditFeedback'),
('editFeedback', 'changePriorityFeedback'),
('editFeedback', 'changeStatusFeedback'),
('editAdmin', 'deleteAdmin'),
('editCategory', 'deleteCategory'),
('editFeedback', 'deleteFeedback'),
('adminManager', 'editAdmin'),
('categoryManager', 'editCategory'),
('feedbackManager', 'editFeedback'),
('editFeedback', 'moveFeedback'),
('editFeedback', 'publishFeedback'),
('editFeedback', 'setFlaggedFeedback'),
('editFeedback', 'setStickyFeedback'),
('adminManager', 'viewAdmin'),
('categoryManager', 'viewCategory'),
('feedbackManager', 'viewFeedback'),
('formManager', 'viewForm'),
('siteManager', 'viewSite');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `categoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `intName` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `changeable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`categoryId`),
  KEY `Category_Site_siteId` (`siteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryId`, `siteId`, `intName`, `name`, `changeable`) VALUES
(1, 1, 'default', 'General', 0),
(2, 1, 'suggestions', 'Suggestions', 1),
(3, 1, 'bugs', 'Problems/Bugs', 1),
(4, 1, 'pricing', 'Pricing', 1),
(5, 1, 'misc', 'Misc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Company`
--

CREATE TABLE IF NOT EXISTS `Company` (
  `companyId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `planId` int(10) unsigned NOT NULL,
  `billTo` varchar(100) NOT NULL,
  `tagInactive` tinyint(1) NOT NULL DEFAULT '1',
  `tagInactiveDays` tinyint(2) NOT NULL DEFAULT '25',
  `deleteIgnored` tinyint(1) NOT NULL DEFAULT '1',
  `replyTo` varchar(100) DEFAULT NULL,
  `digestPeriod` tinyint(1) NOT NULL DEFAULT '1',
  `ffEmail1` varchar(150) DEFAULT NULL,
  `ffEmail2` varchar(150) DEFAULT NULL,
  `ffEmail3` varchar(150) DEFAULT NULL,
  `defaultSiteId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`companyId`),
  KEY `Company_Plan_planId` (`planId`),
  KEY `Company_Site_defaultSiteId` (`defaultSiteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`companyId`, `name`, `planId`, `billTo`, `tagInactive`, `tagInactiveDays`, `deleteIgnored`, `replyTo`, `digestPeriod`, `ffEmail1`, `ffEmail2`, `ffEmail3`, `defaultSiteId`) VALUES
(1, 'Razer', 3, 'Razer, LLC', 1, 25, 1, 'feedback@razer.com', 1, 'feedback+ryan@razer.com', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Contact`
--

CREATE TABLE IF NOT EXISTS `Contact` (
  `contactId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `email` varchar(80) NOT NULL,
  `countryId` int(10) unsigned NOT NULL,
  `position` varchar(100) NOT NULL,
  `city` varchar(45) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contactId`),
  KEY `Contact_Country_countryId` (`countryId`),
  KEY `Contact_Site_siteId` (`siteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `Contact`
--

INSERT INTO `Contact` (`contactId`, `siteId`, `firstName`, `lastName`, `email`, `countryId`, `position`, `city`, `companyName`, `website`, `avatar`) VALUES
(1, 1, 'Sergei', 'Chernienko', 'sergei@chernienko.com', 4, 'HR manager', 'Lviv', 'Global Logic', 'http://www.globallogic.com.ua/', NULL),
(2, 1, 'Stephany', 'Stalone', 'stephany@stalone.com', 2, 'Network administrator', 'Amsterdam', 'Hostopia, inc', 'http://www.hostopia.com/', NULL),
(3, 1, 'Thomas', 'Anderson', 'thomas@anderson.com', 1, 'Software engineer', 'Sidney', 'Spax systems', 'http://www.sparxsystems.com.au/', NULL),
(4, 1, 'Sarah', 'Konnor', 'sarah@konnor.com', 5, 'Temporary part-time libraries North-West inter-library loan business unit administration assistant', 'London', 'UK State Library', 'http://library.co.uk/', NULL),
(5, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(6, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(7, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(8, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(9, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(10, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(11, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(12, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(13, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(14, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(15, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(16, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(17, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(18, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(19, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(20, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(21, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(22, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(23, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(27, 1, 'Konstantin', 'Mirin', 'konstantin.mirin@gmail.com', 1, '', '', '', '', NULL),
(28, 1, 'Konstantin', 'Mirin', 'konstantin.mirin@gmail.com', 1, 'Owner', 'Mykolayiv', 'Takeforce', '', NULL),
(29, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(30, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(31, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(32, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(33, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(34, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(35, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(36, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(37, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(38, 1, 'Konstantin', 'Mirin', 'k@kk.com', 1, 'Owner', 'Nikolayev', 'Takeforce', '', NULL),
(39, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(40, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(41, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(42, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(43, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(44, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 4, 'Manager', 'New York', 'NBA', '', NULL),
(45, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(46, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(47, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(48, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(49, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(50, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(51, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(52, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(53, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(54, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(55, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(56, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(57, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(58, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(59, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(60, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(61, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(62, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 1, 'Manager', 'New York', 'NBA', '', NULL),
(63, 1, 'Konstantin', 'Mirin', 'k@ko.co', 1, '', '', '', '', NULL),
(64, 1, 'dfsdf', '', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(65, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(66, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(67, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(68, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(69, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(70, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(71, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(72, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(73, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(74, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(75, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(76, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(77, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(78, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(79, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 1, '', '', '', '', NULL),
(80, 1, 'abc', 'cde', 'abc@cde.com', 1, '', '', '', '', NULL),
(81, 1, 'abc', 'cde', 'abc@cde.com', 1, '', '', '', '', NULL),
(82, 1, 'Konst', 'M', 'ko@mi.com', 1, '', '', '', '', NULL),
(83, 1, 'Konst', 'M', 'ko@mi.com', 1, '', '', '', '', NULL),
(84, 1, 'Konst', '', 'konst@ko.com', 1, '', '', '', '', NULL),
(85, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(86, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(87, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(88, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(89, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(90, 1, 'QWE', '', 'rty@uio.pas', 1, '', '', '', '', NULL),
(91, 1, 'ewre', '', 'ere@sdfsd.cdf', 1, '', '', '', '', NULL),
(92, 1, 'Konstant', '', 'kokkk@tf.com', 1, '', '', '', '', NULL),
(93, 1, 'somebody', 'someone', 'some@body.one', 3, 'CEO', 'One', 'CoolSoft', '', NULL),
(94, 1, 'Konstantin', 'Mirin', 'some@qwe.com', 1, '', 'Nikolayev', 'Takeforce', '', NULL),
(95, 1, 'hfghgfh', '', 'jghj@fgfdgf.gfhh', 1, 'ghj', 'fjg', 'jgj', '', NULL),
(96, 1, 'hgjhj', '', 'hjhj@fgf.gfgf', 1, 'hjghk', 'hfgj', 'jghk', '', ''),
(97, 1, 'sdf', '', 'rrer@fdf.fdf', 1, '', '', '', '', ''),
(98, 1, 'sdgdfg', '', 'sdfsdf@fdf.ff', 1, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `countryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` char(2) NOT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Country`
--

INSERT INTO `Country` (`countryId`, `name`, `code`) VALUES
(1, 'Australia', 'au'),
(2, 'Netherlands', 'nl'),
(3, 'Singapore', 'sg'),
(4, 'Ukraine', 'ua'),
(5, 'UK', 'uk');

-- --------------------------------------------------------

--
-- Table structure for table `Feedback`
--

CREATE TABLE IF NOT EXISTS `Feedback` (
  `feedbackId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `contactId` bigint(20) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  `formId` bigint(20) unsigned NOT NULL,
  `status` enum('new','inprogress','closed') DEFAULT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `text` varchar(1500) DEFAULT NULL,
  `dtAdded` datetime NOT NULL,
  `isFeatured` tinyint(1) NOT NULL,
  `priority` tinyint(2) unsigned NOT NULL DEFAULT '99',
  `license` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `textLength` smallint(4) unsigned NOT NULL DEFAULT '0',
  `isFlagged` tinyint(1) DEFAULT '0',
  `isPublished` tinyint(1) DEFAULT '0',
  `isArchived` tinyint(1) DEFAULT '0',
  `isSticked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`feedbackId`),
  KEY `Feedback_Contact_contactId` (`contactId`),
  KEY `Feedback_Form_formId` (`formId`),
  KEY `Feedback_Category_categoryId` (`categoryId`),
  KEY `Feedback_Site_siteId` (`siteId`),
  KEY `text` (`text`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`feedbackId`, `siteId`, `contactId`, `categoryId`, `formId`, `status`, `rating`, `text`, `dtAdded`, `isFeatured`, `priority`, `license`, `textLength`, `isFlagged`, `isPublished`, `isArchived`, `isSticked`) VALUES
(1, 1, 1, 1, 1, 'inprogress', 5, 'sodkoskgos odkgo skdogk skdogksod giw egureo gjerip gpejrgj ipergp kerogk[ kw[ekgo kweiogkj iwekgi jigji sdgok sodkgo skdogks odkgosdk gosjdigjiwje wepkg dijg weirgj ergoijerg erpiojg eprjg oerog rgjr ijieji eij gjdgj djgdklj dgsd ;gs;dg sdijgspdgjspdgjsdipgjspdgjisodpfjivjsdv ckdsmcosdk', '2011-02-07 12:35:02', 1, 20, 2, 253, 0, 0, 0, 0),
(3, 1, 3, 2, 1, 'new', 4, 'I like the Backlight and the profile management. The "keys" are soft and I like its revestiment', '2011-01-31 18:12:27', 1, 20, 2, 95, 0, 0, 0, 0),
(4, 1, 4, 1, 1, 'new', 5, 'The keyboard is cool for hacking terminators :)', '2011-02-15 18:12:27', 1, 60, 3, 47, 0, 0, 0, 0),
(5, 1, 21, 1, 1, 'new', 5, 'qwrerewrwe', '2011-04-22 19:22:48', 1, 0, 2, 10, 0, 0, 0, 0),
(6, 1, 23, 1, 1, 'new', 5, 'fggdfgdfg', '2011-04-22 20:20:49', 0, 0, 1, 9, 0, 0, 0, 0),
(9, 1, 27, 1, 1, 'new', 4, 'review', '2011-04-25 15:26:14', 1, 0, 3, 6, 0, 0, 0, 0),
(10, 1, 28, 1, 1, 'new', 4, 'another review', '2011-04-25 15:29:01', 1, 0, 2, 14, 0, 0, 0, 0),
(11, 1, 34, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:14:26', 0, 0, 1, 25, 0, 0, 0, 0),
(12, 1, 35, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:18:45', 0, 0, 1, 25, 0, 0, 0, 0),
(13, 1, 36, 1, 1, 'new', 5, 'gfdgdfgfd', '2011-04-27 12:30:57', 0, 0, 1, 9, 0, 0, 0, 0),
(14, 1, 37, 1, 1, 'new', 5, 'qwerty', '2011-04-27 12:32:11', 0, 0, 1, 6, 0, 0, 0, 0),
(15, 1, 38, 1, 1, 'new', 5, 'qwe', '2011-04-27 13:46:55', 1, 0, 2, 3, 0, 0, 0, 0),
(16, 1, 43, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf', '2011-04-27 16:58:12', 0, 0, 3, 15, 0, 0, 0, 0),
(17, 1, 44, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf\r\n\r\nfdsfsdfsdf', '2011-04-27 16:58:40', 1, 0, 3, 29, 0, 0, 0, 0),
(18, 1, 52, 1, 1, 'new', 5, 'fdgdfgdfg', '2011-04-27 18:44:32', 1, 0, 1, 9, 0, 0, 0, 0),
(19, 1, 53, 1, 1, 'new', 5, 'mega new', '2011-04-27 18:59:35', 1, 0, 3, 8, 0, 0, 0, 0),
(20, 1, 54, 1, 1, 'new', 5, 'qwewqeqw\r\newq\r\neq\r\ne\r\nwqeqwewqeqwe', '2011-04-28 17:18:26', 1, 20, 2, 34, 0, 0, 0, 0),
(21, 1, 55, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:19:38', 0, 0, 2, 3, 0, 0, 0, 0),
(22, 1, 56, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:21:32', 0, 0, 2, 3, 0, 0, 0, 0),
(23, 1, 57, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs', '2011-04-28 23:25:38', 0, 0, 3, 14, 0, 0, 0, 0),
(24, 1, 58, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs', '2011-04-28 23:26:31', 0, 0, 3, 14, 0, 0, 0, 0),
(25, 1, 59, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:15', 0, 0, 1, 22, 0, 0, 0, 0),
(26, 1, 60, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:23', 0, 0, 1, 22, 0, 0, 0, 0),
(27, 1, 61, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:29:08', 0, 0, 1, 7, 0, 0, 0, 0),
(28, 1, 62, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:30:39', 0, 0, 1, 7, 0, 0, 0, 0),
(29, 1, 76, 1, 1, 'new', 5, NULL, '2011-04-29 18:24:57', 0, 0, 1, 37, 0, 0, 0, 0),
(30, 1, 77, 1, 1, 'new', 5, NULL, '2011-04-29 18:29:16', 0, 0, 1, 37, 0, 0, 0, 0),
(31, 1, 82, 1, 1, 'new', 5, '', '2011-04-29 18:41:30', 0, 0, 1, 0, 0, 0, 0, 0),
(32, 1, 83, 1, 1, 'new', 5, '', '2011-04-29 19:25:41', 0, 0, 1, 0, 0, 0, 0, 0),
(33, 1, 84, 1, 1, 'new', 5, 'sfdfsdfdfsdfdsfdsfsdfsd\nfsdfsdfsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '2011-04-29 19:31:01', 0, 0, 1, 193, 0, 0, 0, 0),
(34, 1, 85, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:37', 0, 0, 1, 6, 0, 0, 0, 0),
(35, 1, 86, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:39', 0, 0, 1, 6, 0, 0, 0, 0),
(36, 1, 87, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:41', 0, 0, 1, 6, 0, 0, 0, 0),
(37, 1, 88, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:42', 0, 0, 1, 6, 0, 0, 0, 0),
(38, 1, 89, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:43', 0, 0, 1, 6, 0, 0, 0, 0),
(39, 1, 90, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:44', 0, 0, 1, 6, 0, 0, 0, 0),
(40, 1, 91, 1, 1, 'new', 5, 'gdfgdfg', '2011-04-29 19:38:06', 0, 0, 1, 7, 0, 0, 0, 0),
(41, 1, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:17', 0, 0, 1, 25, 0, 0, 0, 0),
(42, 1, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:28', 0, 0, 1, 25, 0, 0, 0, 0),
(43, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 19:56:21', 0, 0, 3, 20, 0, 0, 0, 0),
(44, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:23', 0, 0, 3, 20, 0, 0, 0, 0),
(45, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:40', 0, 0, 3, 20, 0, 0, 0, 0),
(46, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:42', 0, 0, 3, 20, 0, 0, 0, 0),
(47, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:43', 0, 0, 3, 20, 0, 0, 0, 0),
(48, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:43', 0, 0, 3, 20, 0, 0, 0, 0),
(49, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 0, 3, 20, 0, 0, 0, 0),
(50, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 0, 3, 20, 0, 0, 0, 0),
(51, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0),
(52, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0),
(53, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0),
(54, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0),
(55, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0),
(56, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0),
(57, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0),
(58, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:14:08', 0, 0, 3, 20, 0, 0, 0, 0),
(59, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:16:16', 0, 0, 3, 20, 0, 0, 0, 0),
(60, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:17:07', 0, 0, 3, 20, 0, 0, 0, 0),
(61, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:17:43', 0, 0, 3, 20, 0, 0, 0, 0),
(62, 1, 94, 1, 1, 'new', 5, 'qwerty', '2011-06-07 15:35:40', 0, 0, 1, 6, 0, 0, 0, 0),
(63, 1, 95, 1, 1, 'new', 4, 'gh', '2011-06-15 19:28:16', 0, 0, 1, 2, 0, 0, 0, 0),
(64, 1, 1, 1, 1, 'new', 1, 'BAD!!!!!!', '2011-06-17 15:04:31', 0, 99, 1, 9, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Form`
--

CREATE TABLE IF NOT EXISTS `Form` (
  `formId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `themeId` int(10) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `help` text NOT NULL,
  `scaleId` smallint(5) unsigned NOT NULL,
  `displayData` text NOT NULL,
  `defaultCategoryId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`formId`),
  KEY `Form_Theme_themeId` (`themeId`),
  KEY `Form_Scale_scaleId` (`scaleId`),
  KEY `Form_Site_siteId` (`siteId`),
  KEY `Form_Category_defaultCategoryId` (`defaultCategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Form`
--

INSERT INTO `Form` (`formId`, `siteId`, `themeId`, `title`, `help`, `scaleId`, `displayData`, `defaultCategoryId`) VALUES
(1, 1, 3, 'Leave your feedback for Razer LLC', 'Don''t know what to write?', 1, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}', 1),
(2, 1, 1, 'Give your feedback for Takeforce', 'Please provide your feedback', 2, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}', 1),
(3, 2, 1, 'Give your feedback for Takeforce', 'Please provide your feedback', 2, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}', 1),
(4, 2, 1, 'Give your feedback for Takeforce', 'Please provide your feedback', 2, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}', 1),
(5, 2, 1, 'Give your feedback for Takeforce', 'Please provide your feedback', 2, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `IM`
--

CREATE TABLE IF NOT EXISTS `IM` (
  `imId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`imId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `IM`
--

INSERT INTO `IM` (`imId`, `name`) VALUES
(1, 'Yahoo IM'),
(2, 'XMPP / google talk'),
(3, 'Skype'),
(4, 'ICQ'),
(5, 'AIM');

-- --------------------------------------------------------

--
-- Table structure for table `Plan`
--

CREATE TABLE IF NOT EXISTS `Plan` (
  `planId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `profileNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `adminNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `monthlyFeedback` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `contactNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned NOT NULL DEFAULT '0',
  `hasModeration` tinyint(1) NOT NULL DEFAULT '0',
  `hasSsl` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`planId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Plan`
--

INSERT INTO `Plan` (`planId`, `name`, `profileNum`, `adminNum`, `monthlyFeedback`, `contactNum`, `price`, `hasModeration`, `hasSsl`) VALUES
(1, 'Free', 1, 1, 15, 15, 0, 0, 0),
(2, 'Basic', 1, 1, 50, 50, 9, 0, 1),
(3, 'Enhanced', 3, 3, 0, 0, 39, 0, 1),
(4, 'Premium', 5, 5, 0, 0, 79, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Scale`
--

CREATE TABLE IF NOT EXISTS `Scale` (
  `scaleId` smallint(5) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `intName` varchar(45) NOT NULL,
  PRIMARY KEY (`scaleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Scale`
--

INSERT INTO `Scale` (`scaleId`, `name`, `intName`) VALUES
(1, 'Gradient', 'Ribbon'),
(2, 'Button', 'Button');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(40) NOT NULL,
  `last_activity` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `last_activity`, `data`) VALUES
('vqnew89v3Tu6HLgiWOs5sMLlx6vxhvkM8s0v1l3d', 1310577597, 'a:3:{s:10:"csrf_token";s:16:"88tU4JWtrnqEx5Jl";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}'),
('QXb9e5cKsoGbZxbYvkfPfMU1pk380RVsdmZJ5qVF', 1310623383, 'a:3:{s:10:"csrf_token";s:16:"BqUjMRinlweR8oOI";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}'),
('puSQkDuUu8rzZexyV7JJwpg2SxHK8Tr23mI0EHP0', 1310573510, 'a:3:{s:10:"csrf_token";s:16:"8GlqX5LUI1XZvT9d";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}');

-- --------------------------------------------------------

--
-- Table structure for table `Site`
--

CREATE TABLE IF NOT EXISTS `Site` (
  `siteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `domain` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `defaultFormId` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`siteId`),
  KEY `Site_Company_companyId` (`companyId`),
  KEY `Site_Form_defaultFormId` (`defaultFormId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Site`
--

INSERT INTO `Site` (`siteId`, `companyId`, `domain`, `name`, `defaultFormId`) VALUES
(1, 1, 'razerzone.com', 'Razer', 1),
(2, 1, 'google.com', 'google', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE IF NOT EXISTS `Status` (
  `statusId` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`statusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`statusId`, `name`) VALUES
(1, 'New'),
(2, 'In Progress'),
(3, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `Theme`
--

CREATE TABLE IF NOT EXISTS `Theme` (
  `themeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned DEFAULT NULL COMMENT 'themes may be custom, company-specific',
  `name` varchar(45) NOT NULL,
  `defaultScaleId` smallint(5) unsigned NOT NULL,
  `interfaceSettings` text,
  `blockPageSize` int(11) DEFAULT NULL,
  `formPageSize` int(11) DEFAULT NULL,
  PRIMARY KEY (`themeId`),
  KEY `Theme_Company_companyId` (`companyId`),
  KEY `Theme_Scale_defaultScaleId` (`defaultScaleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Theme`
--

INSERT INTO `Theme` (`themeId`, `companyId`, `name`, `defaultScaleId`, `interfaceSettings`, `blockPageSize`, `formPageSize`) VALUES
(1, NULL, 'Light', 1, '{"scaleCfg":{"scaleIntValue":"Button","delimLabel":{"leftOffset":20},"blockSize":120}}', NULL, NULL),
(2, NULL, 'Dark', 2, NULL, NULL, NULL),
(3, 1, 'Razer-Dark', 2, '{"scaleCfg":{"scaleIntValue":"Ribbon","delimLabel":{"leftOffset":20},"blockSize":120},\r\n"pageSize":3}', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `fullName` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `ext` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `fax` varchar(45) NOT NULL,
  `home` varchar(45) NOT NULL,
  `im` varchar(45) NOT NULL,
  `imId` int(10) unsigned NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `company_user` (`companyId`,`username`),
  KEY `User_Company_companyId` (`companyId`),
  KEY `User_IM_imId` (`imId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userId`, `companyId`, `username`, `password`, `email`, `fullName`, `title`, `phone`, `ext`, `mobile`, `fax`, `home`, `im`, `imId`, `avatar`) VALUES
(1, 1, 'ryan', '$1$K/rY2dS7$9jBqbcveghrsbS6eMlpWc0', 'ryan@chua.com', 'Ryan Chua', 'CEO', '', '', '', '', '', 'ryanchua6', 3, NULL),
(2, 1, 'budi', '$1$vKHia0ZE$FyNbOT8wNDGvTGV3IpkO01', 'budi@salim.com', 'Budiyono Salim', 'CTO', '', '', '', '', '', 'byonosalim@gmail.com', 2, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Category`
--
ALTER TABLE `Category`
  ADD CONSTRAINT `Category_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Company`
--
ALTER TABLE `Company`
  ADD CONSTRAINT `Company_Plan_planId` FOREIGN KEY (`planId`) REFERENCES `Plan` (`planId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Company_Site_defaultSiteId` FOREIGN KEY (`defaultSiteId`) REFERENCES `Site` (`siteId`);

--
-- Constraints for table `Contact`
--
ALTER TABLE `Contact`
  ADD CONSTRAINT `Contact_Country_countryId` FOREIGN KEY (`countryId`) REFERENCES `Country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Contact_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Feedback`
--
ALTER TABLE `Feedback`
  ADD CONSTRAINT `Feedback_Category_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `Category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Feedback_Contact_contactId` FOREIGN KEY (`contactId`) REFERENCES `Contact` (`contactId`),
  ADD CONSTRAINT `Feedback_Form_formId` FOREIGN KEY (`formId`) REFERENCES `Form` (`formId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Feedback_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Form`
--
ALTER TABLE `Form`
  ADD CONSTRAINT `Form_Category_defaultCategoryId` FOREIGN KEY (`defaultCategoryId`) REFERENCES `Category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Scale_scaleId` FOREIGN KEY (`scaleId`) REFERENCES `Scale` (`scaleId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Theme_themeId` FOREIGN KEY (`themeId`) REFERENCES `Theme` (`themeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Site`
--
ALTER TABLE `Site`
  ADD CONSTRAINT `Site_Company_companyId` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Site_Form_defaultFormId` FOREIGN KEY (`defaultFormId`) REFERENCES `Form` (`formId`);

--
-- Constraints for table `Theme`
--
ALTER TABLE `Theme`
  ADD CONSTRAINT `Theme_Company_companyId` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Theme_Scale_defaultScaleId` FOREIGN KEY (`defaultScaleId`) REFERENCES `Scale` (`scaleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_Company_companyId` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `User_IM_imId` FOREIGN KEY (`imId`) REFERENCES `IM` (`imId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
