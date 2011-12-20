-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2011 at 04:32 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.4

SET FOREIGN_KEY_CHECKS=0;
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
  `inbox_approve` tinyint(1) NOT NULL DEFAULT '1',
  `inbox_feature` tinyint(1) NOT NULL DEFAULT '1',
  `inbox_delete` tinyint(1) NOT NULL DEFAULT '1',
  `inbox_fastforward` tinyint(1) NOT NULL DEFAULT '1',
  `inbox_flag` tinyint(1) NOT NULL DEFAULT '1',
  `feedsetup_approve` tinyint(1) NOT NULL DEFAULT '1',
  `contact_approve` tinyint(1) NOT NULL DEFAULT '1',
  `setting_approve` tinyint(1) NOT NULL DEFAULT '1',
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `BadWords`
--

CREATE TABLE IF NOT EXISTS `BadWords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(125) NOT NULL,
  `replacement` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=458 ;

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
  KEY `Category_Company_companyId` (`companyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

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
  `alias1` varchar(150) NOT NULL,
  `alias2` varchar(150) NOT NULL,
  `alias3` varchar(150) NOT NULL,
  `defaultSiteId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`companyId`),
  KEY `Company_Plan_planId` (`planId`),
  KEY `Company_Site_defaultSiteId` (`defaultSiteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
  KEY `Contact_Site_siteId` (`siteId`),
  KEY `Contact_Email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `iso1_code` char(2) COLLATE utf8_bin NOT NULL,
  `name_caps` varchar(80) COLLATE utf8_bin NOT NULL,
  `name` varchar(80) COLLATE utf8_bin NOT NULL,
  `iso3_code` char(3) COLLATE utf8_bin DEFAULT NULL,
  `num_code` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`iso1_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `countryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` char(2) NOT NULL,
  `seq` int(10) NOT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=895 ;

-- --------------------------------------------------------

--
-- Table structure for table `Effects`
--

CREATE TABLE IF NOT EXISTS `Effects` (
  `effectsId` int(11) NOT NULL,
  `effectsName` varchar(50) NOT NULL,
  `jqueryName` varchar(125) NOT NULL,
  PRIMARY KEY (`effectsId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmbeddedBlockOptions`
--

CREATE TABLE IF NOT EXISTS `EmbeddedBlockOptions` (
  `embeddedBlockId` int(11) NOT NULL AUTO_INCREMENT,
  `userThemeId` int(10) NOT NULL,
  `widgetId` int(11) DEFAULT '3',
  `type` varchar(20) NOT NULL,
  `units` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `effectId` int(10) NOT NULL,
  PRIMARY KEY (`embeddedBlockId`),
  KEY `EmbeddedBlockOptions_effect_id` (`effectId`),
  KEY `EmbeddedBlockOptions_widget_id` (`widgetId`),
  KEY `EmbeddedBlockOptions_UserThemes_theme_id` (`userThemeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `Feedback`
--

CREATE TABLE IF NOT EXISTS `Feedback` (
  `feedbackId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siteId` int(10) unsigned NOT NULL,
  `contactId` bigint(20) unsigned NOT NULL,
  `categoryId` int(10) unsigned NOT NULL DEFAULT '1',
  `formId` bigint(20) unsigned NOT NULL,
  `status` enum('new','inprogress','closed') DEFAULT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `text` varchar(1500) DEFAULT NULL,
  `dtAdded` datetime NOT NULL,
  `priority` tinyint(2) unsigned NOT NULL DEFAULT '99',
  `permission` tinyint(1) NOT NULL,
  `textLength` smallint(4) unsigned NOT NULL DEFAULT '0',
  `indLock` tinyint(1) NOT NULL DEFAULT '1',
  `isFeatured` tinyint(1) NOT NULL,
  `isFlagged` tinyint(1) DEFAULT '0',
  `isPublished` tinyint(1) DEFAULT '0',
  `isArchived` tinyint(1) DEFAULT '0',
  `isSticked` tinyint(1) DEFAULT '0',
  `isDeleted` tinyint(1) DEFAULT '0',
  `hasProfanity` tinyint(1) DEFAULT '0',
  `displayName` tinyint(1) DEFAULT '1',
  `displayImg` tinyint(1) DEFAULT '1',
  `displayCompany` tinyint(1) DEFAULT '1',
  `displayPosition` tinyint(1) DEFAULT '1',
  `displayURL` tinyint(1) DEFAULT '1',
  `displayCountry` tinyint(1) DEFAULT '1',
  `displaySbmtDate` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`feedbackId`),
  KEY `Feedback_Contact_contactId` (`contactId`),
  KEY `Feedback_Form_formId` (`formId`),
  KEY `Feedback_Category_categoryId` (`categoryId`),
  KEY `Feedback_Site_siteId` (`siteId`),
  KEY `text` (`text`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci' AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `FeedbackActivity`
--

CREATE TABLE IF NOT EXISTS `FeedbackActivity` (
  `userId` int(10) unsigned NOT NULL,
  `feedbackId` bigint(20) unsigned NOT NULL,
  `feedbackStatus` varchar(125) NOT NULL,
  `dtAdded` datetime NOT NULL,
  KEY `Feedback_FeedbackActivity_feedbackId` (`feedbackId`),
  KEY `Feedback_FeedbackActivity_userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `FeedbackBlock`
--

CREATE TABLE IF NOT EXISTS `FeedbackBlock` (
  `feedbackblockId` bigint(20) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL,
  `themeId` int(11) NOT NULL,
  `formId` int(11) NOT NULL,
  `displayName` tinyint(1) NOT NULL DEFAULT '1',
  `displayImg` tinyint(1) NOT NULL DEFAULT '1',
  `displayCompany` tinyint(1) NOT NULL DEFAULT '1',
  `displayPosition` tinyint(1) NOT NULL DEFAULT '1',
  `displayURL` tinyint(1) NOT NULL DEFAULT '1',
  `displayCountry` tinyint(1) NOT NULL DEFAULT '1',
  `displaySbmtDate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`feedbackblockId`),
  KEY `siteId` (`siteId`,`themeId`,`formId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `FullPageOptions`
--

CREATE TABLE IF NOT EXISTS `FullPageOptions` (
  `fullPageId` int(11) NOT NULL AUTO_INCREMENT,
  `userThemeId` int(10) NOT NULL,
  `widgetId` int(11) DEFAULT '1',
  `units` int(10) NOT NULL,
  PRIMARY KEY (`fullPageId`),
  KEY `FullPageOptions_widget_id` (`widgetId`),
  KEY `FullPageOptions_UserThemes_theme_id` (`userThemeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `IM`
--

CREATE TABLE IF NOT EXISTS `IM` (
  `imId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`imId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `Metric`
--

CREATE TABLE IF NOT EXISTS `Metric` (
  `metricId` int(10) NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `totalRequest` int(10) NOT NULL,
  `totalResponse` int(10) NOT NULL,
  PRIMARY KEY (`metricId`),
  KEY `Metric_Company_companyId` (`companyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModalWindowOptions`
--

CREATE TABLE IF NOT EXISTS `ModalWindowOptions` (
  `modalId` int(11) NOT NULL AUTO_INCREMENT,
  `userThemeId` int(10) NOT NULL,
  `widgetId` int(11) DEFAULT '2',
  `effectId` int(10) NOT NULL,
  PRIMARY KEY (`modalId`),
  KEY `ModalWindowOption_effect_id` (`effectId`),
  KEY `ModalWindowOptions_widget_id` (`widgetId`),
  KEY `ModalWindowOptions_UserThemes_theme_id` (`userThemeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE IF NOT EXISTS `Status` (
  `statusId` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`statusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `Theme`
--

CREATE TABLE IF NOT EXISTS `Theme` (
  `themeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned DEFAULT NULL COMMENT 'themes may be custom, company-specific',
  `name` varchar(45) NOT NULL,
  `defaultScaleId` smallint(5) unsigned NOT NULL,
  `embeddedCSS` blob,
  `modalCSS` blob,
  `blockPageSize` int(11) DEFAULT NULL,
  `formPageSize` int(11) DEFAULT NULL,
  PRIMARY KEY (`themeId`),
  KEY `Theme_Company_companyId` (`companyId`),
  KEY `Theme_Scale_defaultScaleId` (`defaultScaleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(45) NOT NULL,
  `encryptString` varchar(100) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `UserThemes`
--

CREATE TABLE IF NOT EXISTS `UserThemes` (
  `userThemeId` int(11) NOT NULL AUTO_INCREMENT,
  `companyId` int(10) unsigned DEFAULT NULL,
  `siteId` int(10) unsigned NOT NULL,
  `widgetId` int(11) NOT NULL,
  `themeId` int(10) unsigned NOT NULL,
  `themeName` varchar(125) NOT NULL,
  `templatePath` varchar(125) NOT NULL,
  PRIMARY KEY (`userThemeId`),
  KEY `UserThemes_Site_site_id` (`siteId`),
  KEY `UserThemes_Theme_theme_id` (`themeId`),
  KEY `UserThemes_Widget_widget_id` (`widgetId`),
  KEY `CompanyIdIndex` (`companyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `Widget`
--

CREATE TABLE IF NOT EXISTS `Widget` (
  `widgetId` int(11) NOT NULL AUTO_INCREMENT,
  `widgetName` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`widgetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
  ADD CONSTRAINT `Category_Company_companyId` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Constraints for table `EmbeddedBlockOptions`
--
ALTER TABLE `EmbeddedBlockOptions`
  ADD CONSTRAINT `EmbeddedBlockOptions_UserThemes_theme_id` FOREIGN KEY (`userThemeId`) REFERENCES `UserThemes` (`userThemeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `EmbeddedBlockOptions_widget_id` FOREIGN KEY (`widgetId`) REFERENCES `Widget` (`widgetId`);

--
-- Constraints for table `Feedback`
--
ALTER TABLE `Feedback`
  ADD CONSTRAINT `Feedback_Category_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `Category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Feedback_Form_formId` FOREIGN KEY (`formId`) REFERENCES `Form` (`formId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Feedback_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `FeedbackActivity`
--
ALTER TABLE `FeedbackActivity`
  ADD CONSTRAINT `Feedback_FeedbackActivity_feedbackId` FOREIGN KEY (`feedbackId`) REFERENCES `Feedback` (`feedbackId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Feedback_FeedbackActivity_userId` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Form`
--
ALTER TABLE `Form`
  ADD CONSTRAINT `Form_Category_defaultCategoryId` FOREIGN KEY (`defaultCategoryId`) REFERENCES `Category` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Scale_scaleId` FOREIGN KEY (`scaleId`) REFERENCES `Scale` (`scaleId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Site_siteId` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Form_Theme_themeId` FOREIGN KEY (`themeId`) REFERENCES `Theme` (`themeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `FullPageOptions`
--
ALTER TABLE `FullPageOptions`
  ADD CONSTRAINT `FullPageOptions_UserThemes_theme_id` FOREIGN KEY (`userThemeId`) REFERENCES `UserThemes` (`userThemeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `FullPageOptions_widget_id` FOREIGN KEY (`widgetId`) REFERENCES `Widget` (`widgetId`);

--
-- Constraints for table `Metric`
--
ALTER TABLE `Metric`
  ADD CONSTRAINT `Metric_Company_companyId` FOREIGN KEY (`companyId`) REFERENCES `Company` (`companyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ModalWindowOptions`
--
ALTER TABLE `ModalWindowOptions`
  ADD CONSTRAINT `ModalWindowOptions_UserThemes_theme_id` FOREIGN KEY (`userThemeId`) REFERENCES `UserThemes` (`userThemeId`) ON DELETE CASCADE,
  ADD CONSTRAINT `ModalWindowOptions_widget_id` FOREIGN KEY (`widgetId`) REFERENCES `Widget` (`widgetId`);

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

--
-- Constraints for table `UserThemes`
--
ALTER TABLE `UserThemes`
  ADD CONSTRAINT `UserThemes_Site_site_id` FOREIGN KEY (`siteId`) REFERENCES `Site` (`siteId`),
  ADD CONSTRAINT `UserThemes_Theme_theme_id` FOREIGN KEY (`themeId`) REFERENCES `Theme` (`themeId`),
  ADD CONSTRAINT `UserThemes_Widget_widget_id` FOREIGN KEY (`widgetId`) REFERENCES `Widget` (`widgetId`);
SET FOREIGN_KEY_CHECKS=1;
