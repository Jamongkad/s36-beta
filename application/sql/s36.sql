-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2011 at 03:27 PM
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
  `seq` int(10) NOT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;

--
-- Dumping data for table `Country`
--

INSERT INTO `Country` (`countryId`, `name`, `code`, `seq`) VALUES
(1, 'United States', 'US', 0),
(2, 'United Kingdom', 'UK', 0),
(3, 'Norway', 'NO', 0),
(4, 'Greece', 'GR', 0),
(5, 'Afghanistan', 'AF', 0),
(6, 'Albania', 'AL', 0),
(7, 'Algeria', 'DZ', 0),
(8, 'American Samoa', 'AS', 0),
(9, 'Andorra', 'AD', 0),
(10, 'Angola', 'AO', 0),
(11, 'Anguilla', 'AI', 0),
(12, 'Antigua &amp; Barbuda', 'AG', 0),
(13, 'Antilles, Netherlands', 'AN', 0),
(15, 'Argentina', 'AR', 0),
(16, 'Armenia', 'AM', 0),
(17, 'Aruba', 'AW', 0),
(18, 'Australia', 'AU', 0),
(19, 'Austria', 'AT', 0),
(20, 'Azerbaijan', 'AZ', 0),
(21, 'Bahamas, The', 'BS', 0),
(22, 'Bahrain', 'BH', 0),
(23, 'Bangladesh', 'BD', 0),
(24, 'Barbados', 'BB', 0),
(25, 'Belarus', 'BY', 0),
(26, 'Belgium', 'BE', 0),
(27, 'Belize', 'BZ', 0),
(28, 'Benin', 'BJ', 0),
(29, 'Bermuda', 'BM', 0),
(30, 'Bhutan', 'BT', 0),
(31, 'Bolivia', 'BO', 0),
(32, 'Bosnia and Herzegovina', 'BA', 0),
(33, 'Botswana', 'BW', 0),
(34, 'Brazil', 'BR', 0),
(35, 'British Virgin Islands', 'VG', 0),
(36, 'Brunei Darussalam', 'BN', 0),
(37, 'Bulgaria', 'BG', 0),
(38, 'Burkina Faso', 'BF', 0),
(39, 'Burundi', 'BI', 0),
(40, 'Cambodia', 'KH', 0),
(41, 'Cameroon', 'CM', 0),
(42, 'Canada', 'CA', 0),
(43, 'Cape Verde', 'CV', 0),
(44, 'Cayman Islands', 'KY', 0),
(45, 'Central African Republic', 'CF', 0),
(46, 'Chad', 'TD', 0),
(47, 'Chile', 'CL', 0),
(48, 'China', 'CN', 0),
(49, 'Colombia', 'CO', 0),
(50, 'Comoros', 'KM', 0),
(51, 'Congo', 'CG', 0),
(52, 'Congo', 'CD', 0),
(53, 'Cook Islands', 'CK', 0),
(54, 'Costa Rica', 'CR', 0),
(55, 'Cote D''Ivoire', 'CI', 0),
(56, 'Croatia', 'HR', 0),
(57, 'Cuba', 'CU', 0),
(58, 'Cyprus', 'CY', 0),
(59, 'Czech Republic', 'CZ', 0),
(60, 'Denmark', 'DK', 0),
(61, 'Djibouti', 'DJ', 0),
(62, 'Dominica', 'DM', 0),
(63, 'Dominican Republic', 'DO', 0),
(64, 'East Timor (Timor-Leste)', 'TP', 0),
(65, 'Ecuador', 'EC', 0),
(66, 'Egypt', 'EG', 0),
(67, 'El Salvador', 'SV', 0),
(68, 'Equatorial Guinea', 'GQ', 0),
(69, 'Eritrea', 'ER', 0),
(70, 'Estonia', 'EE', 0),
(71, 'Ethiopia', 'ET', 0),
(72, 'Falkland Islands', 'FK', 0),
(73, 'Faroe Islands', 'FO', 0),
(74, 'Fiji', 'FJ', 0),
(75, 'Finland', 'FI', 0),
(76, 'France', 'FR', 0),
(77, 'French Guiana', 'GF', 0),
(78, 'French Polynesia', 'PF', 0),
(79, 'Gabon', 'GA', 0),
(80, 'Gambia, the', 'GM', 0),
(81, 'Georgia', 'GE', 0),
(82, 'Germany', 'DE', 0),
(83, 'Ghana', 'GH', 0),
(84, 'Gibraltar', 'GI', 0),
(86, 'Greenland', 'GL', 0),
(87, 'Grenada', 'GD', 0),
(88, 'Guadeloupe', 'GP', 0),
(89, 'Guam', 'GU', 0),
(90, 'Guatemala', 'GT', 0),
(91, 'Guernsey and Alderney', 'GG', 0),
(92, 'Guinea', 'GN', 0),
(93, 'Guinea-Bissau', 'GW', 0),
(94, 'Guinea, Equatorial', 'GP', 0),
(95, 'Guiana, French', 'GF', 0),
(96, 'Guyana', 'GY', 0),
(97, 'Haiti', 'HT', 0),
(99, 'Honduras', 'HN', 0),
(100, 'Hong Kong, (China)', 'HK', 0),
(101, 'Hungary', 'HU', 0),
(102, 'Iceland', 'IS', 0),
(103, 'India', 'IN', 0),
(104, 'Indonesia', 'ID', 0),
(105, 'Iran, Islamic Republic of', 'IR', 0),
(106, 'Iraq', 'IQ', 0),
(107, 'Ireland', 'IE', 0),
(108, 'Israel', 'IL', 0),
(109, 'Ivory Coast (Cote d''Ivoire)', 'CI', 0),
(110, 'Italy', 'IT', 0),
(111, 'Jamaica', 'JM', 0),
(112, 'Japan', 'JP', 0),
(113, 'Jersey', 'JE', 0),
(114, 'Jordan', 'JO', 0),
(115, 'Kazakhstan', 'KZ', 0),
(116, 'Kenya', 'KE', 0),
(117, 'Kiribati', 'KI', 0),
(118, 'Korea, (South) Rep. of', 'KR', 0),
(119, 'Kuwait', 'KW', 0),
(120, 'Kyrgyzstan', 'KG', 0),
(121, 'Lao People''s Dem. Rep.', 'LA', 0),
(122, 'Latvia', 'LV', 0),
(123, 'Lebanon', 'LB', 0),
(124, 'Lesotho', 'LS', 0),
(125, 'Libyan Arab Jamahiriya', 'LY', 0),
(126, 'Liechtenstein', 'LI', 0),
(127, 'Lithuania', 'LT', 0),
(128, 'Luxembourg', 'LU', 0),
(129, 'Macao, (China)', 'MO', 0),
(130, 'Macedonia, TFYR', 'MK', 0),
(131, 'Madagascar', 'MG', 0),
(132, 'Malawi', 'MW', 0),
(133, 'Malaysia', 'MY', 0),
(134, 'Maldives', 'MV', 0),
(135, 'Mali', 'ML', 0),
(136, 'Malta', 'MT', 0),
(137, 'Martinique', 'MQ', 0),
(138, 'Mauritania', 'MR', 0),
(139, 'Mauritius', 'MU', 0),
(140, 'Mexico', 'MX', 0),
(141, 'Micronesia', 'FM', 0),
(142, 'Moldova, Republic of', 'MD', 0),
(143, 'Monaco', 'MC', 0),
(144, 'Mongolia', 'MN', 0),
(145, 'Montenegro', 'CS', 0),
(146, 'Morocco', 'MA', 0),
(147, 'Mozambique', 'MZ', 0),
(148, 'Myanmar (ex-Burma)', 'MM', 0),
(149, 'Namibia', 'NA', 0),
(150, 'Nepal', 'NP', 0),
(151, 'Netherlands', 'NL', 0),
(152, 'New Caledonia', 'NC', 0),
(153, 'New Zealand', 'NZ', 0),
(154, 'Nicaragua', 'NI', 0),
(155, 'Niger', 'NE', 0),
(156, 'Nigeria', 'NG', 0),
(157, 'Northern Mariana Islands', 'MP', 0),
(159, 'Oman', 'OM', 0),
(160, 'Pakistan', 'PK', 0),
(161, 'Palestinian Territory', 'PS', 0),
(162, 'Panama', 'PA', 0),
(163, 'Papua New Guinea', 'PG', 0),
(164, 'Paraguay', 'PY', 0),
(165, 'Peru', 'PE', 0),
(166, 'Philippines', 'PH', 0),
(167, 'Poland', 'PL', 0),
(168, 'Portugal', 'PT', 0),
(170, 'Qatar', 'QA', 0),
(171, 'Reunion', 'RE', 0),
(172, 'Romania', 'RO', 0),
(173, 'Russian Federation', 'RU', 0),
(174, 'Rwanda', 'RW', 0),
(175, 'Saint Kitts and Nevis', 'KN', 0),
(176, 'Saint Lucia', 'LC', 0),
(177, 'St. Vincent &amp; the Grenad.', 'VC', 0),
(178, 'Samoa', 'WS', 0),
(179, 'San Marino', 'SM', 0),
(180, 'Sao Tome and Principe', 'ST', 0),
(181, 'Saudi Arabia', 'SA', 0),
(182, 'Senegal', 'SN', 0),
(183, 'Serbia', 'RS', 0),
(184, 'Seychelles', 'SC', 0),
(185, 'Singapore', 'SG', 0),
(186, 'Slovakia', 'SK', 0),
(187, 'Slovenia', 'SI', 0),
(188, 'Solomon Islands', 'SB', 0),
(189, 'Somalia', 'SO', 0),
(190, 'Spain', 'ES', 0),
(191, 'Sri Lanka (ex-Ceilan)', 'LK', 0),
(192, 'Sudan', 'SD', 0),
(193, 'Suriname', 'SR', 0),
(194, 'Swaziland', 'SZ', 0),
(195, 'Sweden', 'SE', 0),
(196, 'Switzerland', 'CH', 0),
(197, 'Syrian Arab Republic', 'SY', 0),
(198, 'Taiwan', 'TW', 0),
(199, 'Tajikistan', 'TJ', 0),
(200, 'Tanzania, United Rep. of', 'TZ', 0),
(201, 'Thailand', 'TH', 0),
(202, 'Togo', 'TG', 0),
(203, 'Tonga', 'TO', 0),
(204, 'Trinidad &amp; Tobago', 'TT', 0),
(205, 'Tunisia', 'TN', 0),
(206, 'Turkey', 'TR', 0),
(207, 'Turkmenistan', 'TM', 0),
(208, 'Uganda', 'UG', 0),
(209, 'Ukraine', 'UA', 0),
(210, 'United Arab Emirates', 'AE', 0),
(211, 'Uruguay', 'UY', 0),
(212, 'Uzbekistan', 'UZ', 0),
(213, 'Vanuatu', 'VU', 0),
(214, 'Venezuela', 'VE', 0),
(215, 'Viet Nam', 'VN', 0),
(216, 'Virgin Islands, U.S.', 'VI', 0),
(217, 'Yemen', 'YE', 0),
(218, 'Zambia', 'ZM', 0),
(219, 'Zimbabwe', 'ZW', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `Feedback`
--

INSERT INTO `Feedback` (`feedbackId`, `siteId`, `contactId`, `categoryId`, `formId`, `status`, `rating`, `text`, `dtAdded`, `isFeatured`, `priority`, `license`, `textLength`, `isFlagged`, `isPublished`, `isArchived`, `isSticked`, `isDeleted`, `hasProfanity`, `displayName`, `displayImg`, `displayCompany`, `displayPosition`, `displayURL`, `displayCountry`, `displaySbmtDate`) VALUES
(1, 1, 1, 1, 1, 'inprogress', 5, 'sodkoskgos odkgo skdogk skdogksod giw egureo gjerip gpejrgj ipergp kerogk[ kw[ekgo kweiogkj iwekgi jigji sdgok sodkgo skdogks odkgosdk gosjdigjiwje wepkg dijg weirgj ergoijerg erpiojg eprjg oerog rgjr ijieji eij gjdgj djgdklj dgsd ;gs;dg sdijgspdgjspdgjsdipgjspdgjisodpfjivjsdv ckdsmcosdk', '2011-02-07 12:35:02', 0, 20, 2, 253, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(3, 1, 3, 5, 1, 'new', 4, 'I like the Backlight and the profile management. The "keys" are soft and I like its revestiment', '2011-01-31 18:12:27', 0, 20, 2, 95, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(4, 1, 4, 1, 1, 'new', 5, 'The keyboard is cool for hacking terminators :)', '2011-02-15 18:12:27', 0, 60, 3, 47, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(5, 1, 21, 1, 1, 'new', 5, 'qwrerewrwe', '2011-04-22 19:22:48', 0, 0, 2, 10, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(6, 1, 23, 1, 1, 'new', 5, 'fggdfgdfg', '2011-04-22 20:20:49', 0, 0, 1, 9, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(9, 1, 27, 1, 1, 'new', 4, 'review', '2011-04-25 15:26:14', 0, 0, 3, 6, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(10, 1, 28, 1, 1, 'new', 4, 'another review', '2011-04-25 15:29:01', 0, 0, 2, 14, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(11, 1, 34, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:14:26', 0, 0, 1, 25, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(12, 1, 35, 1, 1, 'new', 5, 'werwerwe re wer werewrwer', '2011-04-27 12:18:45', 0, 0, 1, 25, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(13, 1, 36, 1, 1, 'new', 5, 'gfdgdfgfd', '2011-04-27 12:30:57', 0, 0, 1, 9, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(14, 1, 37, 1, 1, 'new', 5, 'qwerty', '2011-04-27 12:32:11', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(15, 1, 38, 1, 1, 'new', 5, 'qwe', '2011-04-27 13:46:55', 0, 0, 2, 3, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(16, 1, 43, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf', '2011-04-27 16:58:12', 0, 0, 3, 15, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(17, 1, 44, 1, 1, 'new', 5, 'dfvdsfdsfdsvsdf\r\n\r\nfdsfsdfsdf', '2011-04-27 16:58:40', 0, 0, 3, 29, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(18, 1, 52, 1, 1, 'new', 5, 'fdgdfgdfg', '2011-04-27 18:44:32', 0, 0, 1, 9, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(19, 1, 53, 1, 1, 'new', 5, 'mega new', '2011-04-27 18:59:35', 0, 0, 3, 8, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(20, 1, 54, 1, 1, 'new', 5, 'qwewqeqw\r\newq\r\neq\r\ne\r\nwqeqwewqeqwe', '2011-04-28 17:18:26', 0, 20, 2, 34, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(21, 1, 55, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:19:38', 0, 0, 2, 3, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(22, 1, 56, 1, 1, 'new', 5, 'qwe', '2011-04-28 23:21:32', 0, 0, 2, 3, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(23, 1, 57, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs', '2011-04-28 23:25:38', 0, 0, 3, 14, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(24, 1, 58, 1, 1, 'new', 5, 'fdsfdsfdsfsdfs fuck this shit', '2011-04-28 23:26:31', 0, 0, 3, 14, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(25, 1, 59, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:15', 0, 0, 1, 22, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(26, 1, 60, 1, 1, 'new', 5, 'fdgfgfdgdfg\r\ngdfgdfgfd', '2011-04-28 23:27:23', 0, 0, 1, 22, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(27, 1, 61, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:29:08', 0, 0, 1, 7, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(28, 1, 62, 1, 1, 'new', 5, 'wqewqeq', '2011-04-28 23:30:39', 0, 0, 1, 7, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(29, 1, 76, 1, 1, 'new', 5, NULL, '2011-04-29 18:24:57', 0, 0, 1, 37, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(30, 1, 77, 1, 1, 'new', 5, 'cock suckers', '2011-04-29 18:29:16', 0, 0, 1, 37, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(31, 1, 82, 3, 1, 'new', 5, 'niggers', '2011-04-29 18:41:30', 1, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(32, 1, 83, 1, 1, 'new', 5, '', '2011-04-29 19:25:41', 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(33, 1, 84, 1, 1, 'new', 5, 'sfdfsdfdfsdfdsfdsfsdfsd\nfsdfsdfsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '2011-04-29 19:31:01', 0, 0, 1, 193, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(34, 1, 85, 4, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:37', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(35, 1, 86, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:39', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(36, 1, 87, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:41', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(37, 1, 88, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:42', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(38, 1, 89, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:43', 0, 0, 1, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(39, 1, 90, 1, 1, 'new', 5, 'qwerty', '2011-04-29 19:31:44', 1, 0, 1, 6, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(40, 1, 91, 1, 1, 'new', 5, 'gdfgdfg', '2011-04-29 19:38:06', 1, 0, 1, 7, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(41, 1, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:17', 0, 0, 1, 25, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(42, 1, 92, 1, 1, 'new', 5, 'qwerer\nrwe\nrw\nerwerwerwer', '2011-04-29 19:52:28', 0, 0, 1, 25, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1),
(43, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 19:56:21', 0, 0, 3, 20, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(44, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:23', 0, 0, 3, 20, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(45, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:40', 0, 0, 3, 20, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(47, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:43', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(48, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:43', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(49, 1, 93, 3, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 0, 3, 20, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(50, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:44', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(51, 1, 93, 3, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(52, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(53, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(54, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:45', 0, 0, 3, 20, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1),
(55, 1, 93, 4, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(56, 1, 93, 4, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(57, 1, 93, 4, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:13:46', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(59, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:16:16', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(60, 1, 93, 1, 1, 'new', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:17:07', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(61, 1, 93, 3, 1, 'inprogress', 3, 'gfgdgdfg\ndfgdfgdfgfd', '2011-04-29 20:17:43', 0, 0, 3, 20, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1),
(62, 1, 94, 2, 1, 'closed', 5, 'qwerty', '2011-06-07 15:35:40', 1, 0, 1, 6, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(63, 1, 95, 1, 1, 'inprogress', 4, 'gh', '2011-06-15 19:28:16', 1, 60, 1, 2, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(64, 1, 1, 3, 1, 'closed', 1, 'BAD!!!!!!', '2011-06-17 15:04:31', 0, 0, 1, 9, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1);

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
('LXWPrSouX7aiqkuwSKUklK3AVSWPLwmxLhYWdc7A', 1313479586, 'a:3:{s:10:"csrf_token";s:16:"Vz9f155HLUUmWYni";s:11:"s36_user_id";s:1:"1";s:22:":old:laravel_old_input";a:6:{s:10:"company_id";s:1:"1";s:7:"site_id";s:1:"1";s:5:"limit";s:2:"40";s:6:"offset";s:1:"0";s:11:"is_featured";s:1:"1";s:12:"is_published";s:1:"1";}}');

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
