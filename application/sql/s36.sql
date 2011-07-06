-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2011 at 06:54 AM
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
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `categoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `intName` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `changeable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`categoryId`),
  KEY `fk_Category_Company1` (`companyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryId`, `companyId`, `intName`, `name`, `changeable`) VALUES
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
  PRIMARY KEY (`companyId`),
  KEY `fk_Company_Plan` (`planId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`companyId`, `name`, `planId`, `billTo`, `tagInactive`, `tagInactiveDays`, `deleteIgnored`, `replyTo`, `digestPeriod`, `ffEmail1`, `ffEmail2`, `ffEmail3`) VALUES
(1, 'Razer', 3, 'Razer, LLC', 1, 25, 1, 'feedback@razer.com', 1, 'feedback+ryan@razer.com', NULL, NULL);

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
  PRIMARY KEY (`contactId`),
  KEY `fk_Contact_Country1` (`countryId`),
  KEY `fk_Contact_Site1` (`siteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Contact`
--

INSERT INTO `Contact` (`contactId`, `siteId`, `firstName`, `lastName`, `email`, `countryId`, `position`, `city`, `companyName`, `website`) VALUES
(1, 1, 'Sergei', 'Chernienko', 'sergei@chernienko.com', 4, 'HR manager', 'Lviv', 'Global Logic', 'http://www.globallogic.com.ua/'),
(2, 1, 'Stephany', 'Stalone', 'stephany@stalone.com', 2, 'Network administrator', 'Amsterdam', 'Hostopia, inc', 'http://www.hostopia.com/'),
(3, 1, 'Thomas', 'Anderson', 'thomas@anderson.com', 1, 'Software engineer', 'Sidney', 'Spax systems', 'http://www.sparxsystems.com.au/'),
(4, 1, 'Sarah', 'Konnor', 'sarah@konnor.com', 5, 'Temporary part-time libraries North-West inter-library loan business unit administration assistant', 'London', 'UK State Library', 'http://library.co.uk/');

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
  `statusId` tinyint(2) unsigned NOT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `text` text NOT NULL,
  `dtAdded` datetime NOT NULL,
  `isFeatured` tinyint(1) NOT NULL,
  `priority` tinyint(2) unsigned NOT NULL DEFAULT '99',
  `license` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`feedbackId`),
  KEY `fk_Feedback_Status1` (`statusId`),
  KEY `fk_Feedback_Contact1` (`contactId`),
  KEY `fk_Feedback_Form1` (`formId`),
  KEY `fk_Feedback_Category1` (`categoryId`),
  KEY `fk_Feedback_Site1` (`siteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`feedbackId`, `siteId`, `contactId`, `categoryId`, `formId`, `statusId`, `rating`, `text`, `dtAdded`, `isFeatured`, `priority`, `license`) VALUES
(1, 1, 1, 1, 1, 1, 5, 'It''s comfortable, the audio quality is great, the mic. folds out of the way nicely, It has a mic. mute button and volume control with a clip so I can clip it to my shirt and i can always find it. And best of all the lights!', '2011-02-07 12:35:02', 1, 50, 1),
(2, 1, 2, 1, 1, 1, 5, 'I like the non-slip ruber texture on the keys and the backlight, I also like that all the keys are programable', '2011-01-15 13:02:48', 0, 30, 1),
(3, 1, 3, 2, 1, 1, 4, 'I like the Backlight and the profile management. The "keys" are soft and I like its revestiment', '2011-01-31 18:12:27', 1, 20, 2);

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
  PRIMARY KEY (`formId`),
  KEY `fk_Form_Theme1` (`themeId`),
  KEY `fk_Form_Scale1` (`scaleId`),
  KEY `fk_Form_Site1` (`siteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Form`
--

INSERT INTO `Form` (`formId`, `siteId`, `themeId`, `title`, `help`, `scaleId`, `displayData`) VALUES
(1, 1, 3, 'Leave your feedback for Razer LLC', 'Don''t know what to write?', 2, '{"firstName": "true","lastName": "true","position": "false","location": "true","company": "false","date": "true","picture": "true"}');

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
(1, 'Gradient', 'gradient'),
(2, 'Buttons', 'buttons');

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
('tNgfek2oeQQpO4mFToiVPmkxCNRgt2rRp1S5Ilj4', 1309992593, 'a:3:{s:10:"csrf_token";s:16:"ESqLM48F5flPDpr2";s:11:"s36_user_id";s:1:"2";s:22:":old:laravel_old_input";a:0:{}}');

-- --------------------------------------------------------

--
-- Table structure for table `Site`
--

CREATE TABLE IF NOT EXISTS `Site` (
  `siteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `domain` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`siteId`),
  KEY `fk_Site_Company1` (`companyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Site`
--

INSERT INTO `Site` (`siteId`, `companyId`, `domain`, `name`) VALUES
(1, 1, 'razerzone.com', 'Razer');

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
  PRIMARY KEY (`themeId`),
  KEY `fk_Theme_Company1` (`companyId`),
  KEY `fk_Theme_Scale1` (`defaultScaleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Theme`
--

INSERT INTO `Theme` (`themeId`, `companyId`, `name`, `defaultScaleId`) VALUES
(1, NULL, 'Light', 1),
(2, NULL, 'Dark', 2),
(3, 1, 'Razer-Dark', 2);

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
  PRIMARY KEY (`userId`),
  UNIQUE KEY `company_user` (`companyId`,`username`),
  KEY `fk_User_Company1` (`companyId`),
  KEY `fk_User_IM1` (`imId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userId`, `companyId`, `username`, `password`, `email`, `fullName`, `title`, `phone`, `ext`, `mobile`, `fax`, `home`, `im`, `imId`) VALUES
(1, 1, 'ryan', '$1$ZDqglzw9$g2PtSzj44VMu/bpjsK86K/', 'ryan@chua.com', 'Ryan Chua', 'CEO', '', '', '', '', '', 'ryanchua6', 3),
(2, 1, 'budi', '$1$X9ea2OkU$iq92MAnb3jdGg6P89QiCp1', 'budi@salim.com', 'Budiyono Salim', 'CTO', '', '', '', '', '', 'byonosalim@gmail.com', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Category`
--
ALTER TABLE `Category`
  ADD CONSTRAINT `fk_Category_Company1` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Company`
--
ALTER TABLE `Company`
  ADD CONSTRAINT `fk_Company_Plan` FOREIGN KEY (`planId`) REFERENCES `Plan` (`planId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Contact`
--
ALTER TABLE `Contact`
  ADD CONSTRAINT `fk_Contact_Country1` FOREIGN KEY (`countryId`) REFERENCES `Country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Contact_Site1` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Feedback`
--
ALTER TABLE `Feedback`
  ADD CONSTRAINT `fk_Feedback_Category1` FOREIGN KEY (`categoryId`) REFERENCES `Category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_Contact1` FOREIGN KEY (`contactId`) REFERENCES `Contact` (`contactId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_Form1` FOREIGN KEY (`formId`) REFERENCES `Form` (`formId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_Site1` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Feedback_Status1` FOREIGN KEY (`statusId`) REFERENCES `Status` (`statusId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Form`
--
ALTER TABLE `Form`
  ADD CONSTRAINT `fk_Form_Scale1` FOREIGN KEY (`scaleId`) REFERENCES `Scale` (`scaleId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Form_Site1` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Form_Theme1` FOREIGN KEY (`themeId`) REFERENCES `Theme` (`themeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Site`
--
ALTER TABLE `Site`
  ADD CONSTRAINT `fk_Site_Company1` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Theme`
--
ALTER TABLE `Theme`
  ADD CONSTRAINT `fk_Theme_Company1` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Theme_Scale1` FOREIGN KEY (`defaultScaleId`) REFERENCES `Scale` (`scaleId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `fk_User_Company1` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_IM1` FOREIGN KEY (`imId`) REFERENCES `IM` (`imId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
