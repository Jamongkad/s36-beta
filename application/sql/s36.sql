-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2011 at 12:51 PM
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
-- Table structure for table `BadWords`
--

CREATE TABLE IF NOT EXISTS `BadWords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(125) NOT NULL,
  `replacement` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=458 ;

--
-- Dumping data for table `BadWords`
--

INSERT INTO `BadWords` (`id`, `word`, `replacement`) VALUES
(0, 'ahole ', '[censored]'),
(1, 'anus ', '[censored]'),
(2, 'ash0le ', '[censored]'),
(3, 'ash0les ', '[censored]'),
(4, 'asholes ', '[censored]'),
(5, 'ass ', '[censored]'),
(6, 'Ass Monkey ', '[censored]'),
(7, 'Assface ', '[censored]'),
(8, 'assh0le ', '[censored]'),
(9, 'assh0lez ', '[censored]'),
(10, 'asshole ', '[censored]'),
(11, 'assholes ', '[censored]'),
(12, 'assholz ', '[censored]'),
(13, 'asswipe ', '[censored]'),
(14, 'azzhole ', '[censored]'),
(15, 'bassterds ', '[censored]'),
(16, 'bastard ', '[censored]'),
(17, 'bastards ', '[censored]'),
(18, 'bastardz ', '[censored]'),
(19, 'basterds ', '[censored]'),
(20, 'basterdz ', '[censored]'),
(21, 'Biatch ', '[censored]'),
(22, 'bitch ', '[censored]'),
(23, 'bitches ', '[censored]'),
(24, 'Blow Job ', '[censored]'),
(25, 'boffing ', '[censored]'),
(26, 'butthole ', '[censored]'),
(27, 'buttwipe ', '[censored]'),
(28, 'c0ck ', '[censored]'),
(29, 'c0cks ', '[censored]'),
(30, 'c0k ', '[censored]'),
(31, 'Carpet Muncher ', '[censored]'),
(32, 'cawk ', '[censored]'),
(33, 'cawks ', '[censored]'),
(34, 'Clit ', '[censored]'),
(35, 'cnts ', '[censored]'),
(36, 'cntz ', '[censored]'),
(37, 'cock ', '[censored]'),
(38, 'cockhead ', '[censored]'),
(39, 'cock-head ', '[censored]'),
(40, 'cocks ', '[censored]'),
(41, 'CockSucker ', '[censored]'),
(42, 'cock-sucker ', '[censored]'),
(43, 'crap ', '[censored]'),
(44, 'cum ', '[censored]'),
(45, 'cunt ', '[censored]'),
(46, 'cunts ', '[censored]'),
(47, 'cuntz ', '[censored]'),
(48, 'dick ', '[censored]'),
(49, 'dild0 ', '[censored]'),
(50, 'dild0s ', '[censored]'),
(51, 'dildo ', '[censored]'),
(52, 'dildos ', '[censored]'),
(53, 'dilld0 ', '[censored]'),
(54, 'dilld0s ', '[censored]'),
(55, 'dominatricks ', '[censored]'),
(56, 'dominatrics ', '[censored]'),
(57, 'dominatrix ', '[censored]'),
(58, 'dyke ', '[censored]'),
(59, 'enema ', '[censored]'),
(60, 'f u c k ', '[censored]'),
(61, 'f u c k e r ', '[censored]'),
(62, 'fag ', '[censored]'),
(63, 'fag1t ', '[censored]'),
(64, 'faget ', '[censored]'),
(65, 'fagg1t ', '[censored]'),
(66, 'faggit ', '[censored]'),
(67, 'faggot ', '[censored]'),
(68, 'fagit ', '[censored]'),
(69, 'fags ', '[censored]'),
(70, 'fagz ', '[censored]'),
(71, 'faig ', '[censored]'),
(72, 'faigs ', '[censored]'),
(73, 'fart ', '[censored]'),
(74, 'flipping the bird ', '[censored]'),
(75, 'fuck ', '[censored]'),
(76, 'fucker ', '[censored]'),
(77, 'fuckin ', '[censored]'),
(78, 'fucking ', '[censored]'),
(79, 'fucks ', '[censored]'),
(80, 'Fudge Packer ', '[censored]'),
(81, 'fuk ', '[censored]'),
(82, 'Fukah ', '[censored]'),
(83, 'Fuken ', '[censored]'),
(84, 'fuker ', '[censored]'),
(85, 'Fukin ', '[censored]'),
(86, 'Fukk ', '[censored]'),
(87, 'Fukkah ', '[censored]'),
(88, 'Fukken ', '[censored]'),
(89, 'Fukker ', '[censored]'),
(90, 'Fukkin ', '[censored]'),
(91, 'g00k ', '[censored]'),
(92, 'gay ', '[censored]'),
(93, 'gayboy ', '[censored]'),
(94, 'gaygirl ', '[censored]'),
(95, 'gays ', '[censored]'),
(96, 'gayz ', '[censored]'),
(97, 'God-damned ', '[censored]'),
(98, 'h00r ', '[censored]'),
(99, 'h0ar ', '[censored]'),
(100, 'h0re ', '[censored]'),
(101, 'hells ', '[censored]'),
(102, 'hoar ', '[censored]'),
(103, 'hoor ', '[censored]'),
(104, 'hoore ', '[censored]'),
(105, 'jackoff ', '[censored]'),
(106, 'jap ', '[censored]'),
(107, 'japs ', '[censored]'),
(108, 'jerk-off ', '[censored]'),
(109, 'jisim ', '[censored]'),
(110, 'jiss ', '[censored]'),
(111, 'jizm ', '[censored]'),
(112, 'jizz ', '[censored]'),
(113, 'knob ', '[censored]'),
(114, 'knobs ', '[censored]'),
(115, 'knobz ', '[censored]'),
(116, 'kunt ', '[censored]'),
(117, 'kunts ', '[censored]'),
(118, 'kuntz ', '[censored]'),
(119, 'Lesbian ', '[censored]'),
(120, 'Lezzian ', '[censored]'),
(121, 'Lipshits ', '[censored]'),
(122, 'Lipshitz ', '[censored]'),
(123, 'masochist ', '[censored]'),
(124, 'masokist ', '[censored]'),
(125, 'massterbait ', '[censored]'),
(126, 'masstrbait ', '[censored]'),
(127, 'masstrbate ', '[censored]'),
(128, 'masterbaiter ', '[censored]'),
(129, 'masterbate ', '[censored]'),
(130, 'masterbates ', '[censored]'),
(131, 'Motha Fucker ', '[censored]'),
(132, 'Motha Fuker ', '[censored]'),
(133, 'Motha Fukkah ', '[censored]'),
(134, 'Motha Fukker ', '[censored]'),
(135, 'Mother Fucker ', '[censored]'),
(136, 'Mother Fukah ', '[censored]'),
(137, 'Mother Fuker ', '[censored]'),
(138, 'Mother Fukkah ', '[censored]'),
(139, 'Mother Fukker ', '[censored]'),
(140, 'mother-fucker ', '[censored]'),
(141, 'Mutha Fucker ', '[censored]'),
(142, 'Mutha Fukah ', '[censored]'),
(143, 'Mutha Fuker ', '[censored]'),
(144, 'Mutha Fukkah ', '[censored]'),
(145, 'Mutha Fukker ', '[censored]'),
(146, 'n1gr ', '[censored]'),
(147, 'nastt ', '[censored]'),
(148, 'nigger; ', '[censored]'),
(149, 'nigur; ', '[censored]'),
(150, 'niiger; ', '[censored]'),
(151, 'niigr; ', '[censored]'),
(152, 'orafis ', '[censored]'),
(153, 'orgasim; ', '[censored]'),
(154, 'orgasm ', '[censored]'),
(155, 'orgasum ', '[censored]'),
(156, 'oriface ', '[censored]'),
(157, 'orifice ', '[censored]'),
(158, 'orifiss ', '[censored]'),
(159, 'packi ', '[censored]'),
(160, 'packie ', '[censored]'),
(161, 'packy ', '[censored]'),
(162, 'paki ', '[censored]'),
(163, 'pakie ', '[censored]'),
(164, 'paky ', '[censored]'),
(165, 'pecker ', '[censored]'),
(166, 'peeenus ', '[censored]'),
(167, 'peeenusss ', '[censored]'),
(168, 'peenus ', '[censored]'),
(169, 'peinus ', '[censored]'),
(170, 'pen1s ', '[censored]'),
(171, 'penas ', '[censored]'),
(172, 'penis ', '[censored]'),
(173, 'penis-breath ', '[censored]'),
(174, 'penus ', '[censored]'),
(175, 'penuus ', '[censored]'),
(176, 'Phuc ', '[censored]'),
(177, 'Phuck ', '[censored]'),
(178, 'Phuk ', '[censored]'),
(179, 'Phuker ', '[censored]'),
(180, 'Phukker ', '[censored]'),
(181, 'polac ', '[censored]'),
(182, 'polack ', '[censored]'),
(183, 'polak ', '[censored]'),
(184, 'Poonani ', '[censored]'),
(185, 'pr1c ', '[censored]'),
(186, 'pr1ck ', '[censored]'),
(187, 'pr1k ', '[censored]'),
(188, 'pusse ', '[censored]'),
(189, 'pussee ', '[censored]'),
(190, 'pussy ', '[censored]'),
(191, 'puuke ', '[censored]'),
(192, 'puuker ', '[censored]'),
(193, 'queer ', '[censored]'),
(194, 'queers ', '[censored]'),
(195, 'queerz ', '[censored]'),
(196, 'qweers ', '[censored]'),
(197, 'qweerz ', '[censored]'),
(198, 'qweir ', '[censored]'),
(199, 'recktum ', '[censored]'),
(200, 'rectum ', '[censored]'),
(201, 'retard ', '[censored]'),
(202, 'sadist ', '[censored]'),
(203, 'scank ', '[censored]'),
(204, 'schlong ', '[censored]'),
(205, 'screwing ', '[censored]'),
(206, 'semen ', '[censored]'),
(207, 'sex ', '[censored]'),
(208, 'sexy ', '[censored]'),
(209, 'Sh!t ', '[censored]'),
(210, 'sh1t ', '[censored]'),
(211, 'sh1ter ', '[censored]'),
(212, 'sh1ts ', '[censored]'),
(213, 'sh1tter ', '[censored]'),
(214, 'sh1tz ', '[censored]'),
(215, 'shit ', '[censored]'),
(216, 'shits ', '[censored]'),
(217, 'shitter ', '[censored]'),
(218, 'Shitty ', '[censored]'),
(219, 'Shity ', '[censored]'),
(220, 'shitz ', '[censored]'),
(221, 'Shyt ', '[censored]'),
(222, 'Shyte ', '[censored]'),
(223, 'Shytty ', '[censored]'),
(224, 'Shyty ', '[censored]'),
(225, 'skanck ', '[censored]'),
(226, 'skank ', '[censored]'),
(227, 'skankee ', '[censored]'),
(228, 'skankey ', '[censored]'),
(229, 'skanks ', '[censored]'),
(230, 'Skanky ', '[censored]'),
(231, 'slut ', '[censored]'),
(232, 'sluts ', '[censored]'),
(233, 'Slutty ', '[censored]'),
(234, 'slutz ', '[censored]'),
(235, 'son-of-a-bitch ', '[censored]'),
(236, 'tit ', '[censored]'),
(237, 'turd ', '[censored]'),
(238, 'va1jina ', '[censored]'),
(239, 'vag1na ', '[censored]'),
(240, 'vagiina ', '[censored]'),
(241, 'vagina ', '[censored]'),
(242, 'vaj1na ', '[censored]'),
(243, 'vajina ', '[censored]'),
(244, 'vullva ', '[censored]'),
(245, 'vulva ', '[censored]'),
(246, 'w0p ', '[censored]'),
(247, 'wh00r ', '[censored]'),
(248, 'wh0re ', '[censored]'),
(249, 'whore ', '[censored]'),
(250, 'xrated ', '[censored]'),
(251, 'xxx', '[censored]'),
(252, 'b!+ch', '[censored]'),
(253, 'bitch', '[censored]'),
(254, 'blowjob', '[censored]'),
(255, 'clit', '[censored]'),
(256, 'arschloch', '[censored]'),
(257, 'fuck', '[censored]'),
(258, 'shit', '[censored]'),
(259, 'ass', '[censored]'),
(260, 'asshole', '[censored]'),
(261, 'b!tch', '[censored]'),
(262, 'b17ch', '[censored]'),
(263, 'b1tch', '[censored]'),
(264, 'bastard', '[censored]'),
(265, 'bi+ch', '[censored]'),
(266, 'boiolas', '[censored]'),
(267, 'buceta', '[censored]'),
(268, 'c0ck', '[censored]'),
(269, 'cawk', '[censored]'),
(270, 'chink', '[censored]'),
(271, 'cipa', '[censored]'),
(272, 'clits', '[censored]'),
(273, 'cock', '[censored]'),
(274, 'cum', '[censored]'),
(275, 'cunt', '[censored]'),
(276, 'dildo', '[censored]'),
(277, 'dirsa', '[censored]'),
(278, 'ejakulate', '[censored]'),
(279, 'fatass', '[censored]'),
(280, 'fcuk', '[censored]'),
(281, 'fuk', '[censored]'),
(282, 'fux0r', '[censored]'),
(283, 'hoer', '[censored]'),
(284, 'hore', '[censored]'),
(285, 'jism', '[censored]'),
(286, 'kawk', '[censored]'),
(287, 'l3itch', '[censored]'),
(288, 'l3i+ch', '[censored]'),
(289, 'lesbian', '[censored]'),
(290, 'masturbate', '[censored]'),
(291, 'masterbat*', '[censored]'),
(292, 'masterbat3', '[censored]'),
(293, 'motherfucker', '[censored]'),
(294, 's.o.b.', '[censored]'),
(295, 'mofo', '[censored]'),
(296, 'nazi', '[censored]'),
(297, 'nigga', '[censored]'),
(298, 'nigger', '[censored]'),
(299, 'nutsack', '[censored]'),
(300, 'phuck', '[censored]'),
(301, 'pimpis', '[censored]'),
(302, 'pusse', '[censored]'),
(303, 'pussy', '[censored]'),
(304, 'scrotum', '[censored]'),
(305, 'sh!t', '[censored]'),
(306, 'shemale', '[censored]'),
(307, 'shi+', '[censored]'),
(308, 'sh!+', '[censored]'),
(309, 'slut', '[censored]'),
(310, 'smut', '[censored]'),
(311, 'teets', '[censored]'),
(312, 'tits', '[censored]'),
(313, 'boobs', '[censored]'),
(314, 'b00bs', '[censored]'),
(315, 'teez', '[censored]'),
(316, 'testical', '[censored]'),
(317, 'testicle', '[censored]'),
(318, 'titt', '[censored]'),
(319, 'w00se', '[censored]'),
(320, 'jackoff', '[censored]'),
(321, 'wank', '[censored]'),
(322, 'whoar', '[censored]'),
(323, 'whore', '[censored]'),
(324, '*damn', '[censored]'),
(325, '*dyke', '[censored]'),
(326, '*fuck*', '[censored]'),
(327, '*shit*', '[censored]'),
(328, '@$$', '[censored]'),
(329, 'amcik', '[censored]'),
(330, 'andskota', '[censored]'),
(331, 'arse*', '[censored]'),
(332, 'assrammer', '[censored]'),
(333, 'ayir', '[censored]'),
(334, 'bi7ch', '[censored]'),
(335, 'bitch*', '[censored]'),
(336, 'bollock*', '[censored]'),
(337, 'breasts', '[censored]'),
(338, 'butt-pirate', '[censored]'),
(339, 'cabron', '[censored]'),
(340, 'cazzo', '[censored]'),
(341, 'chraa', '[censored]'),
(342, 'chuj', '[censored]'),
(343, 'Cock*', '[censored]'),
(344, 'cunt*', '[censored]'),
(345, 'd4mn', '[censored]'),
(346, 'daygo', '[censored]'),
(347, 'dego', '[censored]'),
(348, 'dick*', '[censored]'),
(349, 'dike*', '[censored]'),
(350, 'dupa', '[censored]'),
(351, 'dziwka', '[censored]'),
(352, 'ejackulate', '[censored]'),
(353, 'Ekrem*', '[censored]'),
(354, 'Ekto', '[censored]'),
(355, 'enculer', '[censored]'),
(356, 'faen', '[censored]'),
(357, 'fag*', '[censored]'),
(358, 'fanculo', '[censored]'),
(359, 'fanny', '[censored]'),
(360, 'feces', '[censored]'),
(361, 'feg', '[censored]'),
(362, 'Felcher', '[censored]'),
(363, 'ficken', '[censored]'),
(364, 'fitt*', '[censored]'),
(365, 'Flikker', '[censored]'),
(366, 'foreskin', '[censored]'),
(367, 'Fotze', '[censored]'),
(368, 'Fu(*', '[censored]'),
(369, 'fuk*', '[censored]'),
(370, 'futkretzn', '[censored]'),
(371, 'gay', '[censored]'),
(372, 'gook', '[censored]'),
(373, 'guiena', '[censored]'),
(374, 'h0r', '[censored]'),
(375, 'h4x0r', '[censored]'),
(376, 'hell', '[censored]'),
(377, 'helvete', '[censored]'),
(378, 'hoer*', '[censored]'),
(379, 'honkey', '[censored]'),
(380, 'Huevon', '[censored]'),
(381, 'hui', '[censored]'),
(382, 'injun', '[censored]'),
(383, 'jizz', '[censored]'),
(384, 'kanker*', '[censored]'),
(385, 'kike', '[censored]'),
(386, 'klootzak', '[censored]'),
(387, 'kraut', '[censored]'),
(388, 'knulle', '[censored]'),
(389, 'kuk', '[censored]'),
(390, 'kuksuger', '[censored]'),
(391, 'Kurac', '[censored]'),
(392, 'kurwa', '[censored]'),
(393, 'kusi*', '[censored]'),
(394, 'kyrpa*', '[censored]'),
(395, 'lesbo', '[censored]'),
(396, 'mamhoon', '[censored]'),
(397, 'masturbat*', '[censored]'),
(398, 'merd*', '[censored]'),
(399, 'mibun', '[censored]'),
(400, 'monkleigh', '[censored]'),
(401, 'mouliewop', '[censored]'),
(402, 'muie', '[censored]'),
(403, 'mulkku', '[censored]'),
(404, 'muschi', '[censored]'),
(405, 'nazis', '[censored]'),
(406, 'nepesaurio', '[censored]'),
(407, 'nigger*', '[censored]'),
(408, 'orospu', '[censored]'),
(409, 'paska*', '[censored]'),
(410, 'perse', '[censored]'),
(411, 'picka', '[censored]'),
(412, 'pierdol*', '[censored]'),
(413, 'pillu*', '[censored]'),
(414, 'pimmel', '[censored]'),
(415, 'piss*', '[censored]'),
(416, 'pizda', '[censored]'),
(417, 'poontsee', '[censored]'),
(418, 'poop', '[censored]'),
(419, 'porn', '[censored]'),
(420, 'p0rn', '[censored]'),
(421, 'pr0n', '[censored]'),
(422, 'preteen', '[censored]'),
(423, 'pula', '[censored]'),
(424, 'pule', '[censored]'),
(425, 'puta', '[censored]'),
(426, 'puto', '[censored]'),
(427, 'qahbeh', '[censored]'),
(428, 'queef*', '[censored]'),
(429, 'rautenberg', '[censored]'),
(430, 'schaffer', '[censored]'),
(431, 'scheiss*', '[censored]'),
(432, 'schlampe', '[censored]'),
(433, 'schmuck', '[censored]'),
(434, 'screw', '[censored]'),
(435, 'sh!t*', '[censored]'),
(436, 'sharmuta', '[censored]'),
(437, 'sharmute', '[censored]'),
(438, 'shipal', '[censored]'),
(439, 'shiz', '[censored]'),
(440, 'skribz', '[censored]'),
(441, 'skurwysyn', '[censored]'),
(442, 'sphencter', '[censored]'),
(443, 'spic', '[censored]'),
(444, 'spierdalaj', '[censored]'),
(445, 'splooge', '[censored]'),
(446, 'suka', '[censored]'),
(447, 'b00b*', '[censored]'),
(448, 'testicle*', '[censored]'),
(449, 'titt*', '[censored]'),
(450, 'twat', '[censored]'),
(451, 'vittu', '[censored]'),
(452, 'wank*', '[censored]'),
(453, 'wetback*', '[censored]'),
(454, 'wichser', '[censored]'),
(455, 'wop*', '[censored]'),
(456, 'yed', '[censored]'),
(457, 'zabourah', '[censored]');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Company`
--

INSERT INTO `Company` (`companyId`, `name`, `planId`, `billTo`, `tagInactive`, `tagInactiveDays`, `deleteIgnored`, `replyTo`, `digestPeriod`, `ffEmail1`, `ffEmail2`, `ffEmail3`, `defaultSiteId`) VALUES
(1, 'Razer', 3, 'Razer, LLC', 1, 25, 1, 'feedback@razer.com', 1, 'feedback+ryan@razer.com', NULL, NULL, 1),
(2, 'YGiraffe', 1, 'YGiraffe, LLC', 1, 25, 1, 'feedback@ygiraffec.com', 1, 'feedback+mathew@ygiraffe.com', NULL, NULL, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `Contact`
--

INSERT INTO `Contact` (`contactId`, `siteId`, `firstName`, `lastName`, `email`, `countryId`, `position`, `city`, `companyName`, `website`, `avatar`) VALUES
(1, 1, 'Sergei', 'Chernienko', 'sergei@chernienko.com', 300, 'HR manager', 'Lviv', 'Global Logic', 'http://www.globallogic.com.ua/', NULL),
(2, 1, 'Stephany', 'Stalone', 'stephany@stalone.com', 2, 'Network administrator', 'Amsterdam', 'Hostopia, inc', 'http://www.hostopia.com/', NULL),
(3, 1, 'Thomas', 'Anderson', 'thomas@anderson.com', 840, 'Software engineer', 'Sidney', 'Spax systems', 'http://www.sparxsystems.com.au/', NULL),
(4, 1, 'Sarah', 'Konnor', 'sarah@konnor.com', 4, 'Temporary part-time libraries North-West inter-library loan business unit administration assistant', 'London', 'UK State Library', 'http://library.co.uk/', NULL),
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
(27, 1, 'Konstantin', 'Mirin', 'konstantin.mirin@gmail.com', 840, '', '', '', '', NULL),
(28, 1, 'Konstantin', 'Mirin', 'konstantin.mirin@gmail.com', 840, 'Owner', 'Mykolayiv', 'Takeforce', '', NULL),
(29, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(30, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(31, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(32, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(33, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(34, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(35, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(36, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(37, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 2, 'Manager', 'New York', 'NBA', '', NULL),
(38, 1, 'Konstantin', 'Mirin', 'k@kk.com', 840, 'Owner', 'Nikolayev', 'Takeforce', '', NULL),
(39, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(40, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(41, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(42, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(43, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(44, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 300, 'Manager', 'New York', 'NBA', '', NULL),
(45, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(46, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(47, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(48, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(49, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(50, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(51, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(52, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(53, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(54, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(55, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(56, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(57, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(58, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(59, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(60, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(61, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(62, 1, 'James', 'Black', 'tf.fb.tester.1@gmail.com', 840, 'Manager', 'New York', 'NBA', '', NULL),
(63, 1, 'Konstantin', 'Mirin', 'k@ko.co', 840, '', '', '', '', NULL),
(64, 1, 'dfsdf', '', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(65, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(66, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(67, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(68, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(69, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(70, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(71, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(72, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(73, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(74, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(75, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(76, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(77, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(78, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(79, 1, 'dfsdf', 'gfhh', 'dfds@dfgsd.vp', 840, '', '', '', '', NULL),
(80, 1, 'abc', 'cde', 'abc@cde.com', 840, '', '', '', '', NULL),
(81, 1, 'abc', 'cde', 'abc@cde.com', 840, '', '', '', '', NULL),
(82, 1, 'Konst', 'M', 'ko@mi.com', 840, '', '', '', '', NULL),
(83, 1, 'Konst', 'M', 'ko@mi.com', 840, '', '', '', '', NULL),
(84, 1, 'Konst', '', 'konst@ko.com', 840, '', '', '', '', NULL),
(85, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(86, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(87, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(88, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(89, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(90, 1, 'QWE', '', 'rty@uio.pas', 840, '', '', '', '', NULL),
(91, 1, 'ewre', '', 'ere@sdfsd.cdf', 840, '', '', '', '', NULL),
(92, 1, 'Konstant', '', 'kokkk@tf.com', 840, '', '', '', '', NULL),
(93, 1, 'somebody', 'someone', 'some@body.one', 578, 'CEO', 'One', 'CoolSoft', '', NULL),
(94, 1, 'Konstantin', 'Mirin', 'some@qwe.com', 840, '', 'Nikolayev', 'Takeforce', '', NULL),
(95, 1, 'hfghgfh', '', 'jghj@fgfdgf.gfhh', 840, 'ghj', 'fjg', 'jgj', '', NULL),
(96, 1, 'hgjhj', '', 'hjhj@fgf.gfgf', 840, 'hjghk', 'hfgj', 'jghk', '', ''),
(97, 1, 'sdf', '', 'rrer@fdf.fdf', 840, '', '', '', '', ''),
(98, 1, 'sdgdfg', '', 'sdfsdf@fdf.ff', 840, '', '', '', '', ''),
(99, 1, 'Mathew', 'Wong', 'wrm932@gmail.com', 608, 'CTO', 'Manila', 'Zenith Labs', 'http://www.mathew.com', 'penguin.png'),
(100, 1, 'Mathew', 'Wong', 'wrm932@gmail.com', 608, 'CTO', 'Manila', 'Zenith Labs', 'http://www.mathew.com', 'penguin.png'),
(101, 1, 'Mathew', 'Wong', 'wrm932@gmail.com', 608, 'CTO', 'Manila', 'Zenith Labs', 'http://www.mathew.com', 'penguin.png'),
(102, 1, 'Mathew', 'Wong', 'wrm932@gmail.com', 608, 'CTO', 'Manila', 'Zenith Labs', 'http://www.mathew.com', 'penguin.png');

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

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`iso1_code`, `name_caps`, `name`, `iso3_code`, `num_code`) VALUES
('AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4),
('AL', 'ALBANIA', 'Albania', 'ALB', 8),
('DZ', 'ALGERIA', 'Algeria', 'DZA', 12),
('AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16),
('AD', 'ANDORRA', 'Andorra', 'AND', 20),
('AO', 'ANGOLA', 'Angola', 'AGO', 24),
('AI', 'ANGUILLA', 'Anguilla', 'AIA', 660),
('AQ', 'ANTARCTICA', 'Antarctica', NULL, 0),
('AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28),
('AR', 'ARGENTINA', 'Argentina', 'ARG', 32),
('AM', 'ARMENIA', 'Armenia', 'ARM', 51),
('AW', 'ARUBA', 'Aruba', 'ABW', 533),
('AU', 'AUSTRALIA', 'Australia', 'AUS', 36),
('AT', 'AUSTRIA', 'Austria', 'AUT', 40),
('AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31),
('BS', 'BAHAMAS', 'Bahamas', 'BHS', 44),
('BH', 'BAHRAIN', 'Bahrain', 'BHR', 48),
('BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50),
('BB', 'BARBADOS', 'Barbados', 'BRB', 52),
('BY', 'BELARUS', 'Belarus', 'BLR', 112),
('BE', 'BELGIUM', 'Belgium', 'BEL', 56),
('BZ', 'BELIZE', 'Belize', 'BLZ', 84),
('BJ', 'BENIN', 'Benin', 'BEN', 204),
('BM', 'BERMUDA', 'Bermuda', 'BMU', 60),
('BT', 'BHUTAN', 'Bhutan', 'BTN', 64),
('BO', 'BOLIVIA', 'Bolivia', 'BOL', 68),
('BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70),
('BW', 'BOTSWANA', 'Botswana', 'BWA', 72),
('BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, 0),
('BR', 'BRAZIL', 'Brazil', 'BRA', 76),
('IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, 0),
('BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96),
('BG', 'BULGARIA', 'Bulgaria', 'BGR', 100),
('BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854),
('BI', 'BURUNDI', 'Burundi', 'BDI', 108),
('KH', 'CAMBODIA', 'Cambodia', 'KHM', 116),
('CM', 'CAMEROON', 'Cameroon', 'CMR', 120),
('CA', 'CANADA', 'Canada', 'CAN', 124),
('CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132),
('KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136),
('CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140),
('TD', 'CHAD', 'Chad', 'TCD', 148),
('CL', 'CHILE', 'Chile', 'CHL', 152),
('CN', 'CHINA', 'China', 'CHN', 156),
('CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, 0),
('CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, 0),
('CO', 'COLOMBIA', 'Colombia', 'COL', 170),
('KM', 'COMOROS', 'Comoros', 'COM', 174),
('CG', 'CONGO', 'Congo', 'COG', 178),
('CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180),
('CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184),
('CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188),
('CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384),
('HR', 'CROATIA', 'Croatia', 'HRV', 191),
('CU', 'CUBA', 'Cuba', 'CUB', 192),
('CY', 'CYPRUS', 'Cyprus', 'CYP', 196),
('CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203),
('DK', 'DENMARK', 'Denmark', 'DNK', 208),
('DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262),
('DM', 'DOMINICA', 'Dominica', 'DMA', 212),
('DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214),
('EC', 'ECUADOR', 'Ecuador', 'ECU', 218),
('EG', 'EGYPT', 'Egypt', 'EGY', 818),
('SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222),
('GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226),
('ER', 'ERITREA', 'Eritrea', 'ERI', 232),
('EE', 'ESTONIA', 'Estonia', 'EST', 233),
('ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231),
('FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238),
('FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234),
('FJ', 'FIJI', 'Fiji', 'FJI', 242),
('FI', 'FINLAND', 'Finland', 'FIN', 246),
('FR', 'FRANCE', 'France', 'FRA', 250),
('GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254),
('PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258),
('TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, 0),
('GA', 'GABON', 'Gabon', 'GAB', 266),
('GM', 'GAMBIA', 'Gambia', 'GMB', 270),
('GE', 'GEORGIA', 'Georgia', 'GEO', 268),
('DE', 'GERMANY', 'Germany', 'DEU', 276),
('GH', 'GHANA', 'Ghana', 'GHA', 288),
('GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292),
('GR', 'GREECE', 'Greece', 'GRC', 300),
('GL', 'GREENLAND', 'Greenland', 'GRL', 304),
('GD', 'GRENADA', 'Grenada', 'GRD', 308),
('GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312),
('GU', 'GUAM', 'Guam', 'GUM', 316),
('GT', 'GUATEMALA', 'Guatemala', 'GTM', 320),
('GN', 'GUINEA', 'Guinea', 'GIN', 324),
('GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624),
('GY', 'GUYANA', 'Guyana', 'GUY', 328),
('HT', 'HAITI', 'Haiti', 'HTI', 332),
('HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, 0),
('VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336),
('HN', 'HONDURAS', 'Honduras', 'HND', 340),
('HK', 'HONG KONG', 'Hong Kong', 'HKG', 344),
('HU', 'HUNGARY', 'Hungary', 'HUN', 348),
('IS', 'ICELAND', 'Iceland', 'ISL', 352),
('IN', 'INDIA', 'India', 'IND', 356),
('ID', 'INDONESIA', 'Indonesia', 'IDN', 360),
('IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364),
('IQ', 'IRAQ', 'Iraq', 'IRQ', 368),
('IE', 'IRELAND', 'Ireland', 'IRL', 372),
('IL', 'ISRAEL', 'Israel', 'ISR', 376),
('IT', 'ITALY', 'Italy', 'ITA', 380),
('JM', 'JAMAICA', 'Jamaica', 'JAM', 388),
('JP', 'JAPAN', 'Japan', 'JPN', 392),
('JO', 'JORDAN', 'Jordan', 'JOR', 400),
('KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398),
('KE', 'KENYA', 'Kenya', 'KEN', 404),
('KI', 'KIRIBATI', 'Kiribati', 'KIR', 296),
('KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408),
('KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410),
('KW', 'KUWAIT', 'Kuwait', 'KWT', 414),
('KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417),
('LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418),
('LV', 'LATVIA', 'Latvia', 'LVA', 428),
('LB', 'LEBANON', 'Lebanon', 'LBN', 422),
('LS', 'LESOTHO', 'Lesotho', 'LSO', 426),
('LR', 'LIBERIA', 'Liberia', 'LBR', 430),
('LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434),
('LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438),
('LT', 'LITHUANIA', 'Lithuania', 'LTU', 440),
('LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442),
('MO', 'MACAO', 'Macao', 'MAC', 446),
('MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807),
('MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450),
('MW', 'MALAWI', 'Malawi', 'MWI', 454),
('MY', 'MALAYSIA', 'Malaysia', 'MYS', 458),
('MV', 'MALDIVES', 'Maldives', 'MDV', 462),
('ML', 'MALI', 'Mali', 'MLI', 466),
('MT', 'MALTA', 'Malta', 'MLT', 470),
('MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584),
('MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474),
('MR', 'MAURITANIA', 'Mauritania', 'MRT', 478),
('MU', 'MAURITIUS', 'Mauritius', 'MUS', 480),
('YT', 'MAYOTTE', 'Mayotte', NULL, 0),
('MX', 'MEXICO', 'Mexico', 'MEX', 484),
('FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583),
('MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498),
('MC', 'MONACO', 'Monaco', 'MCO', 492),
('MN', 'MONGOLIA', 'Mongolia', 'MNG', 496),
('MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500),
('MA', 'MOROCCO', 'Morocco', 'MAR', 504),
('MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508),
('MM', 'MYANMAR', 'Myanmar', 'MMR', 104),
('NA', 'NAMIBIA', 'Namibia', 'NAM', 516),
('NR', 'NAURU', 'Nauru', 'NRU', 520),
('NP', 'NEPAL', 'Nepal', 'NPL', 524),
('NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528),
('AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530),
('NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540),
('NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554),
('NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558),
('NE', 'NIGER', 'Niger', 'NER', 562),
('NG', 'NIGERIA', 'Nigeria', 'NGA', 566),
('NU', 'NIUE', 'Niue', 'NIU', 570),
('NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574),
('MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580),
('NO', 'NORWAY', 'Norway', 'NOR', 578),
('OM', 'OMAN', 'Oman', 'OMN', 512),
('PK', 'PAKISTAN', 'Pakistan', 'PAK', 586),
('PW', 'PALAU', 'Palau', 'PLW', 585),
('PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, 0),
('PA', 'PANAMA', 'Panama', 'PAN', 591),
('PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598),
('PY', 'PARAGUAY', 'Paraguay', 'PRY', 600),
('PE', 'PERU', 'Peru', 'PER', 604),
('PH', 'PHILIPPINES', 'Philippines', 'PHL', 608),
('PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612),
('PL', 'POLAND', 'Poland', 'POL', 616),
('PT', 'PORTUGAL', 'Portugal', 'PRT', 620),
('PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630),
('QA', 'QATAR', 'Qatar', 'QAT', 634),
('RE', 'REUNION', 'Reunion', 'REU', 638),
('RO', 'ROMANIA', 'Romania', 'ROM', 642),
('RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643),
('RW', 'RWANDA', 'Rwanda', 'RWA', 646),
('SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654),
('KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659),
('LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662),
('PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666),
('VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670),
('WS', 'SAMOA', 'Samoa', 'WSM', 882),
('SM', 'SAN MARINO', 'San Marino', 'SMR', 674),
('ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678),
('SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682),
('SN', 'SENEGAL', 'Senegal', 'SEN', 686),
('CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, 0),
('SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690),
('SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694),
('SG', 'SINGAPORE', 'Singapore', 'SGP', 702),
('SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703),
('SI', 'SLOVENIA', 'Slovenia', 'SVN', 705),
('SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90),
('SO', 'SOMALIA', 'Somalia', 'SOM', 706),
('ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710),
('GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, 0),
('ES', 'SPAIN', 'Spain', 'ESP', 724),
('LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144),
('SD', 'SUDAN', 'Sudan', 'SDN', 736),
('SR', 'SURINAME', 'Suriname', 'SUR', 740),
('SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744),
('SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748),
('SE', 'SWEDEN', 'Sweden', 'SWE', 752),
('CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756),
('SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760),
('TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158),
('TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762),
('TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834),
('TH', 'THAILAND', 'Thailand', 'THA', 764),
('TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, 0),
('TG', 'TOGO', 'Togo', 'TGO', 768),
('TK', 'TOKELAU', 'Tokelau', 'TKL', 772),
('TO', 'TONGA', 'Tonga', 'TON', 776),
('TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780),
('TN', 'TUNISIA', 'Tunisia', 'TUN', 788),
('TR', 'TURKEY', 'Turkey', 'TUR', 792),
('TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795),
('TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796),
('TV', 'TUVALU', 'Tuvalu', 'TUV', 798),
('UG', 'UGANDA', 'Uganda', 'UGA', 800),
('UA', 'UKRAINE', 'Ukraine', 'UKR', 804),
('AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784),
('GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826),
('US', 'UNITED STATES', 'United States', 'USA', 840),
('UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, 0),
('UY', 'URUGUAY', 'Uruguay', 'URY', 858),
('UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860),
('VU', 'VANUATU', 'Vanuatu', 'VUT', 548),
('VE', 'VENEZUELA', 'Venezuela', 'VEN', 862),
('VN', 'VIET NAM', 'Viet Nam', 'VNM', 704),
('VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92),
('VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850),
('WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876),
('EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732),
('YE', 'YEMEN', 'Yemen', 'YEM', 887),
('ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894),
('ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716);

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

--
-- Dumping data for table `Country`
--

INSERT INTO `Country` (`countryId`, `name`, `code`, `seq`) VALUES
(4, 'Afghanistan', 'AF', 0),
(8, 'Albania', 'AL', 0),
(12, 'Algeria', 'DZ', 0),
(16, 'American Samoa', 'AS', 0),
(20, 'Andorra', 'AD', 0),
(24, 'Angola', 'AO', 0),
(28, 'Antigua and Barbuda', 'AG', 0),
(31, 'Azerbaijan', 'AZ', 0),
(32, 'Argentina', 'AR', 0),
(36, 'Australia', 'AU', 0),
(40, 'Austria', 'AT', 0),
(44, 'Bahamas', 'BS', 0),
(48, 'Bahrain', 'BH', 0),
(50, 'Bangladesh', 'BD', 0),
(51, 'Armenia', 'AM', 0),
(52, 'Barbados', 'BB', 0),
(56, 'Belgium', 'BE', 0),
(60, 'Bermuda', 'BM', 0),
(64, 'Bhutan', 'BT', 0),
(68, 'Bolivia', 'BO', 0),
(70, 'Bosnia and Herzegovina', 'BA', 0),
(72, 'Botswana', 'BW', 0),
(76, 'Brazil', 'BR', 0),
(84, 'Belize', 'BZ', 0),
(90, 'Solomon Islands', 'SB', 0),
(92, 'Virgin Islands, British', 'VG', 0),
(96, 'Brunei Darussalam', 'BN', 0),
(100, 'Bulgaria', 'BG', 0),
(104, 'Myanmar', 'MM', 0),
(108, 'Burundi', 'BI', 0),
(112, 'Belarus', 'BY', 0),
(116, 'Cambodia', 'KH', 0),
(120, 'Cameroon', 'CM', 0),
(124, 'Canada', 'CA', 0),
(132, 'Cape Verde', 'CV', 0),
(136, 'Cayman Islands', 'KY', 0),
(140, 'Central African Republic', 'CF', 0),
(144, 'Sri Lanka', 'LK', 0),
(148, 'Chad', 'TD', 0),
(152, 'Chile', 'CL', 0),
(156, 'China', 'CN', 0),
(158, 'Taiwan, Province of China', 'TW', 0),
(170, 'Colombia', 'CO', 0),
(174, 'Comoros', 'KM', 0),
(178, 'Congo', 'CG', 0),
(180, 'Congo, the Democratic Republic of the', 'CD', 0),
(184, 'Cook Islands', 'CK', 0),
(188, 'Costa Rica', 'CR', 0),
(191, 'Croatia', 'HR', 0),
(192, 'Cuba', 'CU', 0),
(196, 'Cyprus', 'CY', 0),
(203, 'Czech Republic', 'CZ', 0),
(204, 'Benin', 'BJ', 0),
(208, 'Denmark', 'DK', 0),
(212, 'Dominica', 'DM', 0),
(214, 'Dominican Republic', 'DO', 0),
(218, 'Ecuador', 'EC', 0),
(222, 'El Salvador', 'SV', 0),
(226, 'Equatorial Guinea', 'GQ', 0),
(231, 'Ethiopia', 'ET', 0),
(232, 'Eritrea', 'ER', 0),
(233, 'Estonia', 'EE', 0),
(234, 'Faroe Islands', 'FO', 0),
(238, 'Falkland Islands (Malvinas)', 'FK', 0),
(242, 'Fiji', 'FJ', 0),
(246, 'Finland', 'FI', 0),
(250, 'France', 'FR', 0),
(254, 'French Guiana', 'GF', 0),
(258, 'French Polynesia', 'PF', 0),
(262, 'Djibouti', 'DJ', 0),
(266, 'Gabon', 'GA', 0),
(268, 'Georgia', 'GE', 0),
(270, 'Gambia', 'GM', 0),
(276, 'Germany', 'DE', 0),
(288, 'Ghana', 'GH', 0),
(292, 'Gibraltar', 'GI', 0),
(296, 'Kiribati', 'KI', 0),
(300, 'Greece', 'GR', 0),
(304, 'Greenland', 'GL', 0),
(308, 'Grenada', 'GD', 0),
(312, 'Guadeloupe', 'GP', 0),
(316, 'Guam', 'GU', 0),
(320, 'Guatemala', 'GT', 0),
(324, 'Guinea', 'GN', 0),
(328, 'Guyana', 'GY', 0),
(332, 'Haiti', 'HT', 0),
(336, 'Holy See (Vatican City State)', 'VA', 0),
(340, 'Honduras', 'HN', 0),
(344, 'Hong Kong', 'HK', 0),
(348, 'Hungary', 'HU', 0),
(352, 'Iceland', 'IS', 0),
(356, 'India', 'IN', 0),
(360, 'Indonesia', 'ID', 0),
(364, 'Iran, Islamic Republic of', 'IR', 0),
(368, 'Iraq', 'IQ', 0),
(372, 'Ireland', 'IE', 0),
(376, 'Israel', 'IL', 0),
(380, 'Italy', 'IT', 0),
(384, 'Cote D''Ivoire', 'CI', 0),
(388, 'Jamaica', 'JM', 0),
(392, 'Japan', 'JP', 0),
(398, 'Kazakhstan', 'KZ', 0),
(400, 'Jordan', 'JO', 0),
(404, 'Kenya', 'KE', 0),
(408, 'Korea, Democratic People''s Republic of', 'KP', 0),
(410, 'Korea, Republic of', 'KR', 0),
(414, 'Kuwait', 'KW', 0),
(417, 'Kyrgyzstan', 'KG', 0),
(418, 'Lao People''s Democratic Republic', 'LA', 0),
(422, 'Lebanon', 'LB', 0),
(426, 'Lesotho', 'LS', 0),
(428, 'Latvia', 'LV', 0),
(430, 'Liberia', 'LR', 0),
(434, 'Libyan Arab Jamahiriya', 'LY', 0),
(438, 'Liechtenstein', 'LI', 0),
(440, 'Lithuania', 'LT', 0),
(442, 'Luxembourg', 'LU', 0),
(446, 'Macao', 'MO', 0),
(450, 'Madagascar', 'MG', 0),
(454, 'Malawi', 'MW', 0),
(458, 'Malaysia', 'MY', 0),
(462, 'Maldives', 'MV', 0),
(466, 'Mali', 'ML', 0),
(470, 'Malta', 'MT', 0),
(474, 'Martinique', 'MQ', 0),
(478, 'Mauritania', 'MR', 0),
(480, 'Mauritius', 'MU', 0),
(484, 'Mexico', 'MX', 0),
(492, 'Monaco', 'MC', 0),
(496, 'Mongolia', 'MN', 0),
(498, 'Moldova, Republic of', 'MD', 0),
(500, 'Montserrat', 'MS', 0),
(504, 'Morocco', 'MA', 0),
(508, 'Mozambique', 'MZ', 0),
(512, 'Oman', 'OM', 0),
(516, 'Namibia', 'NA', 0),
(520, 'Nauru', 'NR', 0),
(524, 'Nepal', 'NP', 0),
(528, 'Netherlands', 'NL', 0),
(530, 'Netherlands Antilles', 'AN', 0),
(533, 'Aruba', 'AW', 0),
(540, 'New Caledonia', 'NC', 0),
(548, 'Vanuatu', 'VU', 0),
(554, 'New Zealand', 'NZ', 0),
(558, 'Nicaragua', 'NI', 0),
(562, 'Niger', 'NE', 0),
(566, 'Nigeria', 'NG', 0),
(570, 'Niue', 'NU', 0),
(574, 'Norfolk Island', 'NF', 0),
(578, 'Norway', 'NO', 0),
(580, 'Northern Mariana Islands', 'MP', 0),
(583, 'Micronesia, Federated States of', 'FM', 0),
(584, 'Marshall Islands', 'MH', 0),
(585, 'Palau', 'PW', 0),
(586, 'Pakistan', 'PK', 0),
(591, 'Panama', 'PA', 0),
(598, 'Papua New Guinea', 'PG', 0),
(600, 'Paraguay', 'PY', 0),
(604, 'Peru', 'PE', 0),
(608, 'Philippines', 'PH', 0),
(612, 'Pitcairn', 'PN', 0),
(616, 'Poland', 'PL', 0),
(620, 'Portugal', 'PT', 0),
(624, 'Guinea-Bissau', 'GW', 0),
(630, 'Puerto Rico', 'PR', 0),
(634, 'Qatar', 'QA', 0),
(638, 'Reunion', 'RE', 0),
(642, 'Romania', 'RO', 0),
(643, 'Russian Federation', 'RU', 0),
(646, 'Rwanda', 'RW', 0),
(654, 'Saint Helena', 'SH', 0),
(659, 'Saint Kitts and Nevis', 'KN', 0),
(660, 'Anguilla', 'AI', 0),
(662, 'Saint Lucia', 'LC', 0),
(666, 'Saint Pierre and Miquelon', 'PM', 0),
(670, 'Saint Vincent and the Grenadines', 'VC', 0),
(674, 'San Marino', 'SM', 0),
(678, 'Sao Tome and Principe', 'ST', 0),
(682, 'Saudi Arabia', 'SA', 0),
(686, 'Senegal', 'SN', 0),
(690, 'Seychelles', 'SC', 0),
(694, 'Sierra Leone', 'SL', 0),
(702, 'Singapore', 'SG', 0),
(703, 'Slovakia', 'SK', 0),
(704, 'Viet Nam', 'VN', 0),
(705, 'Slovenia', 'SI', 0),
(706, 'Somalia', 'SO', 0),
(710, 'South Africa', 'ZA', 0),
(716, 'Zimbabwe', 'ZW', 0),
(724, 'Spain', 'ES', 0),
(732, 'Western Sahara', 'EH', 0),
(736, 'Sudan', 'SD', 0),
(740, 'Suriname', 'SR', 0),
(744, 'Svalbard and Jan Mayen', 'SJ', 0),
(748, 'Swaziland', 'SZ', 0),
(752, 'Sweden', 'SE', 0),
(756, 'Switzerland', 'CH', 0),
(760, 'Syrian Arab Republic', 'SY', 0),
(762, 'Tajikistan', 'TJ', 0),
(764, 'Thailand', 'TH', 0),
(768, 'Togo', 'TG', 0),
(772, 'Tokelau', 'TK', 0),
(776, 'Tonga', 'TO', 0),
(780, 'Trinidad and Tobago', 'TT', 0),
(784, 'United Arab Emirates', 'AE', 0),
(788, 'Tunisia', 'TN', 0),
(792, 'Turkey', 'TR', 0),
(795, 'Turkmenistan', 'TM', 0),
(796, 'Turks and Caicos Islands', 'TC', 0),
(798, 'Tuvalu', 'TV', 0),
(800, 'Uganda', 'UG', 0),
(804, 'Ukraine', 'UA', 0),
(807, 'Macedonia, the Former Yugoslav Republic of', 'MK', 0),
(818, 'Egypt', 'EG', 0),
(826, 'United Kingdom', 'GB', 0),
(834, 'Tanzania, United Republic of', 'TZ', 0),
(840, 'United States', 'US', 0),
(850, 'Virgin Islands, U.s.', 'VI', 0),
(854, 'Burkina Faso', 'BF', 0),
(858, 'Uruguay', 'UY', 0),
(860, 'Uzbekistan', 'UZ', 0),
(862, 'Venezuela', 'VE', 0),
(876, 'Wallis and Futuna', 'WF', 0),
(882, 'Samoa', 'WS', 0),
(887, 'Yemen', 'YE', 0),
(894, 'Zambia', 'ZM', 0);

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

--
-- Dumping data for table `Effects`
--

INSERT INTO `Effects` (`effectsId`, `effectsName`, `jqueryName`) VALUES
(1, 'Fade', 'fade'),
(2, 'Uncover', 'uncover'),
(3, 'Scroll Horizontal', 'scrollHorz'),
(4, 'Scroll Vertical', 'scrollVert');

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
  `license` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `textLength` smallint(4) unsigned NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci' AUTO_INCREMENT=65 ;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`feedbackId`, `siteId`, `contactId`, `categoryId`, `formId`, `status`, `rating`, `text`, `dtAdded`, `priority`, `license`, `textLength`, `isFeatured`, `isFlagged`, `isPublished`, `isArchived`, `isSticked`, `isDeleted`, `hasProfanity`, `displayName`, `displayImg`, `displayCompany`, `displayPosition`, `displayURL`, `displayCountry`, `displaySbmtDate`) VALUES
(1, 1, 1, 1, 1, 'inprogress', 5, 'sodkoskgos odkgo skdogk skdogksod giw egureo gjerip gpejrgj ipergp kerogk[ kw[ekgo kweiogkj iwekgi jigji sdgok sodkgo skdogks odkgosdk gosjdigjiwje wepkg dijg weirgj ergoijerg erpiojg eprjg oerog rgjr ijieji eij gjdgj djgdklj dgsd ;gs;dg sdijgspdgjspdgjsdipgjspdgjisodpfjivjsdv ckdsmcosdk', '2011-02-07 12:35:02', 20, 2, 253, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(3, 1, 3, 1, 1, 'new', 4, 'I like the Backlight and the profile management. The "keys" are soft and I like its revestiment', '2011-01-31 18:12:27', 20, 2, 95, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 'new', 5, 'The keyboard is cool for hacking terminators :)', '2011-02-15 18:12:27', 60, 3, 47, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(5, 1, 21, 1, 1, 'new', 5, 'qwrerewrwe', '2011-04-22 19:22:48', 0, 2, 10, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(6, 1, 23, 1, 1, 'new', 5, 'fggdfgdfg', '2011-04-22 20:20:49', 0, 1, 9, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(9, 1, 27, 1, 1, 'new', 4, 'review', '2011-04-25 15:26:14', 0, 3, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(10, 1, 28, 1, 1, 'new', 4, 'another review', '2011-04-25 15:29:01', 0, 2, 14, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(11, 1, 34, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:14:26', 0, 1, 25, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(12, 1, 35, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:18:45', 0, 1, 25, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(13, 1, 36, 1, 1, 'new', 5, 'gfdgdfgfd', '2011-04-27 12:30:57', 0, 1, 9, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(14, 1, 37, 1, 1, 'new', 5, 'qwerty', '2011-04-27 12:32:11', 0, 1, 6, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(15, 1, 38, 1, 1, 'new', 5, 'qwe', '2011-04-27 13:46:55', 0, 2, 3, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(16, 1, 43, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf', '2011-04-27 16:58:12', 0, 3, 15, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(17, 1, 44, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf\r\n\r\nfdsfsdfsdf', '2011-04-27 16:58:40', 0, 3, 29, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(18, 1, 52, 1, 1, 'new', 5, 'fdgdfgdfg', '2011-04-27 18:44:32', 0, 1, 9, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(19, 1, 53, 1, 1, 'new', 5, 'mega new', '2011-04-27 18:59:35', 0, 3, 8, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(20, 1, 54, 1, 1, 'new', 5, 'qwewqeqw\r\newq\r\neq\r\ne\r\nwqeqwewqeqwe', '2011-04-28 17:18:26', 20, 2, 34, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(21, 1, 55, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:19:38', 0, 2, 3, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(22, 1, 56, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:21:32', 0, 2, 3, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(23, 1, 57, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs', '2011-04-28 23:25:38', 0, 3, 14, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(24, 1, 58, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs fuck this shit', '2011-04-28 23:26:31', 0, 3, 14, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(25, 1, 59, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:15', 0, 1, 22, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(26, 1, 60, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:23', 0, 1, 22, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(27, 1, 61, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:29:08', 0, 1, 7, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(28, 1, 62, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:30:39', 0, 1, 7, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(29, 1, 76, 1, 1, 'new', 5, NULL, '2011-04-29 18:24:57', 0, 1, 37, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(30, 1, 77, 1, 1, 'new', 5, 'cock suckers', '2011-04-29 18:29:16', 0, 1, 37, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(31, 1, 82, 1, 1, 'new', 5, 'niggers', '2011-04-29 18:41:30', 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(32, 1, 83, 1, 1, 'new', 5, '', '2011-04-29 19:25:41', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(33, 1, 84, 1, 1, 'new', 5, 'sfdfsdfdfsdfdsfdsfsdfsd\nfsdfsdfsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '2011-04-29 19:31:01', 0, 1, 193, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(34, 1, 85, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:37', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(35, 1, 86, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:39', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(36, 1, 87, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:41', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(37, 1, 88, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:42', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(38, 1, 89, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:43', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(39, 2, 90, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:44', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(40, 2, 91, 1, 1, 'new', 5, 'gdfgdfg', '2011-04-29 19:38:06', 0, 1, 7, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(41, 2, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:17', 0, 1, 25, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(42, 2, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:28', 0, 1, 25, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1),
(44, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:23', 0, 3, 20, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(48, 1, 93, 2, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:43', 0, 3, 20, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(49, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(50, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 3, 20, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(51, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 3, 20, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(52, 1, 93, 3, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 3, 20, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(53, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(54, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(55, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 3, 20, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(56, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 3, 20, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(57, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(59, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:16:16', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(60, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:17:07', 0, 3, 20, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(62, 1, 94, 1, 1, 'closed', 5, 'qwerty', '2011-06-07 15:35:40', 0, 1, 6, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(64, 1, 1, 1, 1, 'closed', 1, 'BAD!!!!!!', '2011-06-17 15:04:31', 100, 1, 9, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `FeedbackBlock`
--

INSERT INTO `FeedbackBlock` (`feedbackblockId`, `siteId`, `themeId`, `formId`, `displayName`, `displayImg`, `displayCompany`, `displayPosition`, `displayURL`, `displayCountry`, `displaySbmtDate`) VALUES
(1, 1, 3, 1, 1, 1, 0, 0, 1, 1, 1);

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
('6FcPzytXRlpjyVV8Tc3Ct3cLZLAC1b1IzCWjig0x', 1315928469, 'a:2:{s:10:"csrf_token";s:16:"p6PPrwJT18BNy00O";s:22:":old:laravel_old_input";a:0:{}}'),
('5B9YtWqI7svn6MY8oCKRoJUzSlzwwqqBPtB8mX7q', 1315900857, 'a:2:{s:10:"csrf_token";s:16:"EihAVcTL2MvQeqRW";s:22:":old:laravel_old_input";a:0:{}}'),
('36wnUOWQw9DpFTiMvPMRrj17brVsKUJdU5aQ6SJt', 1315885002, 'a:3:{s:10:"csrf_token";s:16:"n4x1bqIzKcBNBkyE";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}'),
('CPAliWDkLrrJbYKDnA8W63N1p8KgLdUmJryo934i', 1315801446, 'a:3:{s:10:"csrf_token";s:16:"xyQLclDYlTyY25n6";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}'),
('RnD4PiC0ZjVCWI8OHZlomMEJcdjkGnxk3XE41kjL', 1315809304, 'a:3:{s:10:"csrf_token";s:16:"x9AJeBUYIw8V1W6e";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}'),
('71zOCHfvKCzZxFfMdWOJCkWGUpekcgZSiMOOpYbG', 1315820018, 'a:3:{s:10:"csrf_token";s:16:"T6NO17iCwjslSVGz";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:0:{}}');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Site`
--

INSERT INTO `Site` (`siteId`, `companyId`, `domain`, `name`, `defaultFormId`) VALUES
(1, 1, 'razerzone.com', 'Razer', 1),
(2, 1, 'google.com', 'google', 1),
(3, 2, 'www.yidgetsoft.com', 'yidgetsoft', 1),
(4, 2, 'www.minesoft.com', 'minesoft', 1);

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
  `interfaceSettings` blob,
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
(1, NULL, 'Light', 1, 0x7b227363616c65436667223a7b227363616c65496e7456616c7565223a22427574746f6e222c2264656c696d4c6162656c223a7b226c6566744f6666736574223a32307d2c22626c6f636b53697a65223a3132307d7d, NULL, NULL),
(2, NULL, 'Dark', 2, NULL, NULL, NULL),
(3, 1, 'Razer-Dark', 2, 0x406368617273657420227574662d38223b0a2f2a2043535320446f63756d656e74202a2f0a0a237333365f726f6f747b646973706c61793a626c6f636b3b706f736974696f6e3a72656c61746976653b70616464696e673a3230707820333070783b77696474683a39373070783b6d617267696e3a30206175746f3b7d0a237333365f726f6f74206469767b706f736974696f6e3a72656c61746976653b7d0a237333365f726f6f7420756c2c0a237333365f726f6f74206f6c7b6c6973742d7374796c653a6e6f6e653b6d617267696e3a303b70616464696e673a303b7d0a237333365f726f6f74206c692c0a237333365f726f6f742068312c0a237333365f726f6f742068322c0a237333365f726f6f742068332c0a237333365f726f6f742068342c0a237333365f726f6f742068352c0a237333365f726f6f742068362c0a237333365f726f6f7420707b0a0970616464696e673a303b6d617267696e3a303b0a7d0a0a237333365f726f6f7420237333365f666565646261636b737b70616464696e673a3230707820313070783b7d0a237333365f726f6f74202e7333365f616c6c5f666565646261636b737b646973706c61793a626c6f636b3b77696474683a313030253b7d0a237333365f726f6f74202e666565646261636b5f7365747b77696474683a313030253b646973706c61793a626c6f636b3b7d0a237333365f726f6f74202e7333365f7469746c657b636f6c6f723a233231346537373b666f6e742d73697a653a323370783b7d0a237333365f726f6f74202e6176617461727b646973706c61793a626c6f636b3b70616464696e673a35707820307078203570783b7d0a237333365f726f6f74202e666565646261636b5f746578747b6261636b67726f756e643a233331356438363b646973706c61793a626c6f636b3b6d617267696e3a313070783b70616464696e673a313570783b636f6c6f723a234646463b666f6e742d73697a653a313470783b6c696e652d6865696768743a313870783b2d7765626b69742d626f726465722d7261646975733a3670783b2d6d6f7a2d626f726465722d7261646975733a3670783b626f726465722d7261646975733a3570783b7d0a237333365f726f6f74202e666565646261636b5f626c6f636b7b706f736974696f6e3a72656c61746976653b7d0a237333365f726f6f74202e627562626c655f7461696c7b6261636b67726f756e643a75726c282e2e2f696d616765732f627562626c652d7461696c2e706e67293b77696474683a313770783b6865696768743a313770783b706f736974696f6e3a6162736f6c7574653b6c6566743a333070783b746f703a2d313770783b7d0a237333365f726f6f74202e666565646261636b5f696e666f7b70616464696e673a32707820313070783b7d0a237333365f726f6f74202e666565646261636b5f6e616d657b636f6c6f723a233164396663663b666f6e742d73697a653a313870783b7d0a237333365f726f6f74202e666565646261636b5f64657461696c737b636f6c6f723a236230623062303b666f6e742d73697a653a313270783b7d0a237333365f726f6f74202e666565646261636b5f646174657b636f6c6f723a236230623062303b666f6e742d73697a653a313070783b666f6e742d7765696768743a6e6f726d616c3b7d0a0a2f2a206d69736320636c6173736573202a2f0a237333365f726f6f74202e6d6574612d646174617b666f6e742d73697a653a313270783b636f6c6f723a233663376138353b666f6e742d66616d696c793a417269616c2c2048656c7665746963612c2073616e732d73657269663b7d0a237333365f726f6f74202e6461736865647b626f726465722d746f703a3170782023633763376337206461736865643b646973706c61793a626c6f636b3b6d617267696e3a31307078203070783b7d0a237333365f726f6f74202e616c69676e2d72696768747b746578742d616c69676e3a72696768743b7d0a237333365f726f6f74202e616c69676e2d63656e7465727b746578742d616c69676e3a63656e7465723b7d0a237333365f726f6f74202e666565646261636b5f62746e7b6261636b67726f756e643a236463646364633b636f6c6f723a236163616361633b666f6e742d7765696768743a626f6c643b746578742d736861646f773a2365386538653820307078203170783b626f726465723a6e6f6e653b637572736f723a706f696e7465723b70616464696e673a36707820313070783b2d7765626b69742d626f726465722d7261646975733a3670783b2d6d6f7a2d626f726465722d7261646975733a3670783b626f726465722d7261646975733a3570783b7d0a237333365f726f6f74202e666565646261636b5f62746e3a686f7665727b6261636b67726f756e643a234545453b7d0a237333365f726f6f7420237333365f70616765727b666f6e742d66616d696c793a417269616c3b666f6e742d73697a653a313270783b70616464696e673a30707820313070783b7d0a237333365f726f6f7420237333365f706167657220617b70616464696e673a3270783b636f6c6f723a236235633063393b746578742d6465636f726174696f6e3a6e6f6e653b7d0a237333365f726f6f7420237333365f706167657220612e616374697665536c6964657b666f6e742d7765696768743a626f6c643b746578742d6465636f726174696f6e3a756e6465726c696e653b7d0a2f2a206772696473206672616d65776f726b202a2f0a2e6772696473207b206f766572666c6f773a2068696464656e3b207d0a0a2e67316f66312c0a2e67316f66322c202e67316f66332c202e67316f66342c202e67316f66352c202e67316f66362c0a2e67326f66332c202e67326f66352c202e67326f66362c0a2e67336f66342c202e67336f66352c202e67336f66362c0a2e67346f66352c202e67346f66362c090a2e67356f6636097b20666c6f61743a206c6566743b207d0a0a2e67316f6631097b2077696474683a313030253b207d0a0a2e67316f6632097b2077696474683a203530253b207d0a2e67316f6633097b2077696474683a2033332e333333333333333333253b207d0a2e67316f6634097b2077696474683a203235253b207d0a2e67316f6635097b2077696474683a203230253b207d0a2e67316f663620207b2077696474683a2031362e363636363636363636253b207d0a0a2e67326f6633097b2077696474683a2036362e363636363636363636253b207d0a2e67326f6635097b2077696474683a203430253b207d0a2e67326f663620207b2077696474683a2033332e333333333333333333253b207d0a0a2e67336f6634097b2077696474683a203735253b207d0a2e67336f6635097b2077696474683a203630253b207d0a2e67336f663620207b2077696474683a203530253b7d0a0a2e67346f6635097b2077696474683a203830253b207d0a2e67346f663620207b2077696474683a2036362e363636363636363636253b207d0a0a2e67356f663620207b2077696474683a2038332e333333333333333333253b7d, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userId`, `companyId`, `username`, `password`, `email`, `fullName`, `title`, `phone`, `ext`, `mobile`, `fax`, `home`, `im`, `imId`, `avatar`) VALUES
(1, 1, 'ryan', '$1$K/rY2dS7$9jBqbcveghrsbS6eMlpWc0', 'ryan@chua.com', 'Ryan Chua', 'CEO', '', '', '', '', '', 'ryanchua6', 3, NULL),
(2, 1, 'budi', '$1$vKHia0ZE$FyNbOT8wNDGvTGV3IpkO01', 'budi@salim.com', 'Budiyono Salim', 'CTO', '', '', '', '', '', 'byonosalim@gmail.com', 2, NULL),
(3, 2, 'mathew', '$1$K/rY2dS7$9jBqbcveghrsbS6eMlpWc0', 'mathew@ygiraffe.com', 'Mathew Wong', 'CEO', '', '', '', '', '', '', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `UserThemes`
--

CREATE TABLE IF NOT EXISTS `UserThemes` (
  `userThemeId` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL,
  `widgetId` int(11) NOT NULL,
  `themeId` int(11) NOT NULL,
  `templatePath` varchar(250) NOT NULL,
  PRIMARY KEY (`userThemeId`),
  KEY `UserThemes_Site_siteId` (`siteId`),
  KEY `UserThemes_Widget_widgetId` (`widgetId`),
  KEY `UserThemes_Theme_themeId` (`themeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `UserThemes`
--


-- --------------------------------------------------------

--
-- Table structure for table `Widget`
--

CREATE TABLE IF NOT EXISTS `Widget` (
  `widgetId` int(11) NOT NULL,
  `widgetName` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`widgetId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Widget`
--

INSERT INTO `Widget` (`widgetId`, `widgetName`) VALUES
(1, 'Full Page'),
(2, 'Embedded Block'),
(3, 'Modal / Pop-Up');

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
