-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2016 at 09:30 AM
-- Server version: 5.6.32-78.1
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ibubbuwf_call4peon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `iAdminId` int(11) NOT NULL,
  `vName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'NAME',
  `vEmail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'EMAIL',
  `vUserName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'USERNAME',
  `vPassword` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'PASSWORD',
  `vImage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vAddress1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vAddress2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `iCountryId` int(11) DEFAULT NULL COMMENT 'DATE',
  `vCity` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vZipcode` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `vContactNo` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dtCreated` datetime DEFAULT NULL,
  `iCreatedBy` int(11) DEFAULT NULL,
  `dtModify` datetime DEFAULT NULL,
  `iModifyBy` int(11) DEFAULT NULL,
  `dLastAccess` datetime DEFAULT NULL,
  `eResetPwd` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `iRoleId` int(11) DEFAULT NULL,
  `eStatus` enum('Active','Inactive') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Active' COMMENT 'STATUS',
  `IsDelete` tinyint(1) DEFAULT '0',
  `iDeleteBy` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`iAdminId`, `vName`, `vEmail`, `vUserName`, `vPassword`, `vImage`, `vAddress1`, `vAddress2`, `iCountryId`, `vCity`, `vZipcode`, `vContactNo`, `dtCreated`, `iCreatedBy`, `dtModify`, `iModifyBy`, `dLastAccess`, `eResetPwd`, `iRoleId`, `eStatus`, `IsDelete`, `iDeleteBy`) VALUES
(1, 'call4peon', 'call4peon@gmail.com', 'call4peon', 'a0d156171e054a1483f8f3ca0d28e8b6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-09 17:21:00', 'No', 1, 'Active', 0, NULL),
(2, 'xx', 'xx@dfsd.com', 'sdfds', '48afe15fe8e40b0a0e94adcb65484a0c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-06-30 21:09:26', 1, '2016-06-30 21:09:26', 1, NULL, 'No', 1, 'Active', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_history`
--

CREATE TABLE IF NOT EXISTS `log_history` (
  `iLogId` int(11) NOT NULL,
  `iUserId` int(11) NOT NULL,
  `vSessionId` varchar(50) CHARACTER SET latin1 NOT NULL,
  `vIP` varchar(50) CHARACTER SET latin1 NOT NULL,
  `eUserType` enum('Admin','Member') CHARACTER SET latin1 NOT NULL DEFAULT 'Member',
  `eLoginType` enum('Web','Mobile') CHARACTER SET latin1 NOT NULL,
  `dLoginDate` datetime NOT NULL,
  `dLogoutDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_history`
--

INSERT INTO `log_history` (`iLogId`, `iUserId`, `vSessionId`, `vIP`, `eUserType`, `eLoginType`, `dLoginDate`, `dLogoutDate`) VALUES
(1, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXdSl3lsmHBsmn', '::1', 'Admin', 'Web', '2016-06-27 09:10:39', NULL),
(2, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXhSl3RsnHBsm3', '::1', 'Admin', 'Web', '2016-06-28 04:50:45', '2016-06-28 05:42:21'),
(3, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXhSl3Vsm3JsmX', '::1', 'Admin', 'Web', '2016-06-28 05:42:24', '2016-06-28 07:17:48'),
(4, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXhSl3dsmHdsnH', '::1', 'Admin', 'Web', '2016-06-28 07:17:53', '2016-06-28 08:44:55'),
(5, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXhSl3hsm3RsnH', '::1', 'Admin', 'Web', '2016-06-28 08:44:58', NULL),
(6, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmXhSmHBsm3dsm3', '::1', 'Admin', 'Web', '2016-06-28 22:47:44', NULL),
(7, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmnBSl3FsmndsmH', '::1', 'Admin', 'Web', '2016-06-30 13:37:18', NULL),
(8, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3ZfmnBSl3lsl3FsmX', '49.213.38.168', 'Admin', 'Web', '2016-06-30 21:01:24', NULL),
(9, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3hfl3ZSmHFsmXlsmn', '103.240.35.228', 'Admin', 'Web', '2016-08-06 11:29:34', NULL),
(10, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3hfmnFSl3NsmHRsl3', '49.213.49.206', 'Admin', 'Web', '2016-08-31 15:14:06', '2016-08-31 15:16:59'),
(11, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3lfl3JSl3dsm3lsmX', '49.213.49.145', 'Admin', 'Web', '2016-09-02 07:49:25', NULL),
(12, 1, 'yqGe03SizK-gp6efyKmelaOh1HJimHZfl3lfmXZSl3NsnHlsm3', '49.213.49.187', 'Admin', 'Web', '2016-09-26 15:59:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `module_master`
--

CREATE TABLE IF NOT EXISTS `module_master` (
  `iModuleId` int(11) NOT NULL,
  `vModule` varchar(255) NOT NULL,
  `iParentId` int(11) NOT NULL DEFAULT '0',
  `iMenuParentId` int(11) NOT NULL,
  `iSequenceOrder` int(11) NOT NULL DEFAULT '1',
  `vMenuDisplay` varchar(255) DEFAULT NULL,
  `vImage` varchar(255) DEFAULT NULL,
  `vURL` varchar(255) DEFAULT NULL,
  `vMainMenuCode` varchar(255) NOT NULL,
  `DisplayAsMenu` tinyint(1) NOT NULL DEFAULT '1',
  `DisplayAsSubMenu` tinyint(1) NOT NULL DEFAULT '0',
  `vSelectedMenu` varchar(500) DEFAULT NULL,
  `eMenuType` enum('Front','Back') DEFAULT 'Back',
  `eRelatedTo` enum('Lead','Contact','Account','Vendor','Potential','Representative','Product','User','Task','Event','Call','Feed','PackageType','Transport','Package','Country','Currency','none') DEFAULT 'none',
  `vRefTable` varchar(100) DEFAULT NULL,
  `iCreatedBy` int(11) DEFAULT NULL,
  `dtCreated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `iModifyBy` int(11) DEFAULT NULL,
  `dtModify` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `isDelete` tinyint(1) DEFAULT '0',
  `iDeleteBy` int(11) DEFAULT NULL,
  `eStatus` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module_master`
--

INSERT INTO `module_master` (`iModuleId`, `vModule`, `iParentId`, `iMenuParentId`, `iSequenceOrder`, `vMenuDisplay`, `vImage`, `vURL`, `vMainMenuCode`, `DisplayAsMenu`, `DisplayAsSubMenu`, `vSelectedMenu`, `eMenuType`, `eRelatedTo`, `vRefTable`, `iCreatedBy`, `dtCreated`, `iModifyBy`, `dtModify`, `isDelete`, `iDeleteBy`, `eStatus`) VALUES
(28, 'Dashboard', 0, 0, 1, 'Dashboard', 'fa-dashboard', 'dashboard', 'Dashboard', 1, 0, 'dashboard', 'Back', 'Lead', '', 1, '2016-02-09 13:03:11', 1, '2016-06-25 14:21:50', 0, NULL, 'Active'),
(29, 'User', 0, 0, 3, 'Peons', 'fa fa-user', 'users', 'Users', 1, 0, 'users,users-list,users-add', 'Back', 'Lead', '', 1, '2016-02-09 13:04:42', 1, '2016-06-26 04:54:12', 0, NULL, 'Active'),
(30, 'User List', 29, 29, 1, 'Users List', 'fa fa-list', 'users', 'Users List', 0, 1, '', 'Back', 'Lead', '', 1, '2016-02-09 13:06:21', 1, '2016-02-10 05:50:20', 0, NULL, 'Inactive'),
(31, 'Create User', 29, 29, 2, 'Create User', 'fa fa-plus', 'user-add', 'Create User', 0, 1, 'user-add', 'Back', 'Lead', '', 1, '2016-02-09 13:07:26', 1, '2016-02-11 10:32:31', 0, NULL, 'Inactive'),
(32, 'Vehicle', 0, 0, 4, 'Vehicle', 'fa fa-truck', 'vehicles', 'Vehicle', 1, 0, 'vehicles,vehicle-add,vehicle-list', 'Back', 'Lead', '', 1, '2016-02-10 04:17:07', 1, '2016-02-11 06:08:05', 0, NULL, 'Inactive'),
(33, 'Vehicle List', 32, 32, 1, 'Vehicles List', 'fa fa-list', 'vehicles', 'Vehicle', 0, 1, 'vehicles', 'Back', 'Lead', '', 1, '2016-02-10 04:18:57', 1, '2016-02-10 06:19:18', 0, NULL, 'Inactive'),
(34, 'Create Vehicle', 32, 32, 2, 'Create Vehicle', 'fa fa-plus', 'vehicle-add', 'Create Vehicle', 0, 1, 'vehicle-add', 'Back', 'Lead', '', 1, '2016-02-10 04:20:05', 1, '2016-02-10 11:02:32', 0, NULL, 'Inactive'),
(35, 'Admin', 0, 0, 2, 'Admin', 'fa fa-user-secret', 'admins', 'Admin', 1, 0, 'admins,admin-add', 'Back', 'Lead', '', 1, '2016-02-10 08:34:44', 1, '2016-02-12 04:16:31', 0, NULL, 'Active'),
(36, 'Admin List', 35, 35, 1, 'Admins List', 'fa fa-list', 'admins', 'Admin List', 0, 1, 'admins', 'Back', 'Lead', '', 1, '2016-02-10 08:35:57', 1, '2016-02-11 10:09:35', 0, NULL, 'Inactive'),
(37, 'Create Admin', 35, 35, 2, 'Create Admin ', 'fa fa-plus', 'admin-add', 'Create Admin', 0, 1, 'admin-add', 'Back', 'Lead', '', 1, '2016-02-10 08:37:17', 1, '2016-02-10 11:11:33', 0, NULL, 'Inactive'),
(38, 'Shipment', 0, 0, 5, 'Shipment', 'fa fa-ship', 'shipments', 'Shipment', 1, 0, 'shipments,shipments-list,shipment-add', 'Back', 'Lead', '', 1, '2016-02-11 06:14:56', 1, '2016-02-12 04:17:00', 0, NULL, 'Active'),
(39, 'Shipment List', 38, 38, 1, 'Shipments List', 'fa fa-list', 'shipments', 'Shipment List', 0, 1, 'shipments', 'Back', 'Lead', '', 1, '2016-02-11 06:15:58', 1, '2016-02-11 10:09:23', 0, NULL, 'Inactive'),
(40, 'Create Shipment', 38, 38, 2, 'Create Shipment', 'fa fa-plus', 'shipment-add', 'Create Shipment', 0, 1, 'shipment-add', 'Back', 'none', '', 1, '2016-02-11 06:17:12', 1, '2016-02-11 06:17:12', 0, NULL, 'Inactive'),
(43, 'Create Location', 41, 41, 2, 'Create Location', 'fa fa-plus', 'location-add', 'Location Add', 0, 1, 'location-add', 'Back', 'Lead', '', 1, '2016-02-11 11:02:18', 1, '2016-02-11 11:20:32', 0, NULL, 'Inactive'),
(44, 'Utility & Settings', 0, 0, 6, 'Utility & Settings', 'fa-gear', 'javascript:void(0)', 'Utility & Settings', 1, 0, 'pages,page_add,system_setting', 'Back', 'none', '', 1, '2016-02-18 23:57:50', 1, '2016-02-19 01:02:32', 0, NULL, 'Active'),
(57, 'Page Settings', 44, 44, 5, 'Page Settings', 'fa-edit', 'pages', 'Page Settings', 0, 1, 'pages,page_add', 'Back', 'none', '', 1, '2016-03-15 23:32:55', 1, '2016-06-25 14:28:01', 0, NULL, 'Active'),
(58, 'System Setting', 44, 44, 6, 'System Setting', 'fa-cog', 'system_setting', 'system_setting', 1, 1, 'system_setting', 'Back', 'none', '', 1, '2016-03-16 01:22:51', 1, '2016-06-25 14:29:31', 0, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `page_settings`
--

CREATE TABLE IF NOT EXISTS `page_settings` (
  `iPageId` int(11) NOT NULL,
  `vPageTitle` varchar(255) NOT NULL,
  `vPageCode` varchar(255) NOT NULL,
  `vUrl` varchar(255) NOT NULL,
  `eType` enum('Guide','Page') NOT NULL DEFAULT 'Page',
  `tContent` text NOT NULL,
  `tMetaTitle` text NOT NULL,
  `tMetaKeyword` text NOT NULL,
  `tMetaDesc` text NOT NULL,
  `iCreatedBy` int(11) DEFAULT NULL,
  `dtCreated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `iModifyBy` int(11) DEFAULT NULL,
  `dtModify` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `isDelete` tinyint(1) DEFAULT '0',
  `iDeleteBy` int(11) DEFAULT NULL,
  `eStatus` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page_settings`
--

INSERT INTO `page_settings` (`iPageId`, `vPageTitle`, `vPageCode`, `vUrl`, `eType`, `tContent`, `tMetaTitle`, `tMetaKeyword`, `tMetaDesc`, `iCreatedBy`, `dtCreated`, `iModifyBy`, `dtModify`, `isDelete`, `iDeleteBy`, `eStatus`) VALUES
(10, 'ABOUT CALL4PEON', 'ABOUT_US', '', 'Guide', 'Call4Peon is a premium quality, professional yet affordable service provider for the day to day chores in ones busy life style.\n </br> </br>\nBe it delivery of a gift to your loved ones, or getting grocery delivered to your door steps, getting a parcel delivered to your personal bill payments. Our Peon will be available at your service while making sure your task gets executed satisfactorily.', '', '', '', NULL, '2016-03-16 04:59:14', NULL, '2016-06-25 07:40:28', 0, NULL, 'Active'),
(11, 'Logistics', 'TRANSPORTERS', '', 'Guide', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '', '', '', NULL, '2016-03-16 04:59:30', NULL, '2016-08-31 21:16:17', 0, NULL, 'Active'),
(12, 'Shipment', 'SHIPMENT', '', 'Page', '<html>\n<head>\n	<title></title>\n</head>\n<body>\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\n\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\n</body>\n</html>\n', '', '', '', NULL, '2016-03-16 04:59:49', NULL, '2016-08-31 21:16:44', 0, NULL, 'Active'),
(13, 'Lorem Ipsum', 'LOREM_LPSUM', '', 'Guide', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '', '', '', NULL, '2016-03-16 05:00:13', NULL, '2016-08-31 21:15:59', 0, NULL, 'Active'),
(14, 'Contacts', 'CONTACT', '', 'Guide', 'Contacts...', '', '', '', NULL, '2016-03-16 05:00:57', NULL, '2016-08-31 21:15:49', 0, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `iPermissionId` int(11) NOT NULL,
  `iRoleId` int(11) NOT NULL,
  `iModuleId` int(11) NOT NULL,
  `isRead` varchar(255) NOT NULL,
  `isWrite` varchar(255) NOT NULL,
  `isDelete` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`iPermissionId`, `iRoleId`, `iModuleId`, `isRead`, `isWrite`, `isDelete`) VALUES
(66, 1, 28, '1', '1', '1'),
(67, 1, 29, '1', '1', '1'),
(68, 1, 30, '1', '1', '1'),
(69, 1, 31, '1', '1', '1'),
(70, 1, 32, '1', '1', '1'),
(71, 1, 33, '1', '1', '1'),
(72, 1, 34, '1', '1', '1'),
(73, 1, 35, '1', '1', '1'),
(74, 1, 36, '1', '1', '1'),
(75, 1, 37, '1', '1', '1'),
(76, 1, 49, '1', '1', '1'),
(77, 1, 50, '1', '1', '1'),
(78, 1, 51, '1', '1', '1'),
(79, 1, 52, '1', '1', '1'),
(80, 1, 53, '1', '1', '1'),
(81, 1, 54, '1', '1', '1'),
(82, 1, 55, '1', '1', '1'),
(83, 1, 56, '1', '1', '1'),
(84, 2, 37, '0', '0', '0'),
(85, 1, 38, '1', '1', '1'),
(86, 1, 39, '1', '1', '1'),
(87, 1, 40, '1', '1', '1'),
(88, 2, 38, '1', '1', '1'),
(89, 2, 39, '1', '1', '1'),
(90, 2, 40, '1', '1', '0'),
(91, 1, 41, '1', '1', '1'),
(92, 1, 42, '1', '1', '1'),
(93, 1, 43, '1', '1', '1'),
(94, 2, 41, '0', '0', '0'),
(95, 2, 42, '0', '0', '0'),
(96, 2, 43, '1', '1', '0'),
(97, 3, 28, '1', '1', '1'),
(98, 3, 29, '1', '1', '1'),
(99, 3, 30, '1', '1', '1'),
(100, 3, 31, '1', '1', '0'),
(101, 3, 35, '0', '0', '0'),
(102, 3, 36, '0', '0', '0'),
(103, 3, 37, '0', '0', '0'),
(104, 3, 38, '0', '0', '0'),
(105, 3, 39, '0', '0', '0'),
(106, 3, 40, '0', '0', '0'),
(107, 3, 41, '0', '0', '0'),
(108, 3, 42, '0', '0', '0'),
(109, 3, 43, '0', '0', '0'),
(110, 1, 44, '1', '1', '1'),
(111, 1, 45, '1', '1', '1'),
(112, 1, 46, '1', '1', '1'),
(113, 1, 47, '1', '1', '1'),
(114, 1, 48, '1', '1', '1'),
(115, 1, 57, '1', '1', '1'),
(116, 1, 58, '1', '1', '1'),
(117, 2, 29, '0', '0', '0'),
(118, 2, 30, '0', '0', '0'),
(119, 2, 31, '0', '0', '0'),
(120, 2, 35, '0', '0', '0'),
(121, 2, 36, '0', '0', '0'),
(122, 2, 44, '0', '0', '0'),
(123, 2, 45, '0', '0', '0'),
(124, 2, 46, '0', '0', '0'),
(125, 2, 47, '0', '0', '0'),
(126, 2, 48, '0', '0', '0'),
(127, 2, 57, '0', '0', '0'),
(128, 2, 58, '0', '0', '0'),
(129, 3, 44, '0', '0', '0'),
(130, 3, 45, '0', '0', '0'),
(131, 3, 46, '0', '0', '0'),
(132, 3, 47, '0', '0', '0'),
(133, 3, 48, '0', '0', '0'),
(134, 3, 57, '0', '0', '0'),
(135, 3, 58, '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pre_launch`
--

CREATE TABLE IF NOT EXISTS `pre_launch` (
  `iRequestId` int(11) NOT NULL,
  `vEmail` varchar(255) DEFAULT NULL,
  `vContactNo` varchar(50) DEFAULT NULL,
  `dtCreatedDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE IF NOT EXISTS `role_master` (
  `iRoleId` int(11) NOT NULL,
  `vRole` varchar(255) NOT NULL,
  `eRoleType` enum('Front','Back') NOT NULL DEFAULT 'Front',
  `vRoleCode` varchar(50) NOT NULL,
  `iCreatedBy` int(11) DEFAULT NULL,
  `dtCreated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `iModifyBy` int(11) DEFAULT NULL,
  `dtModify` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `isDelete` tinyint(1) DEFAULT '0',
  `iDeleteBy` int(11) DEFAULT NULL,
  `eStatus` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_master`
--

INSERT INTO `role_master` (`iRoleId`, `vRole`, `eRoleType`, `vRoleCode`, `iCreatedBy`, `dtCreated`, `iModifyBy`, `dtModify`, `isDelete`, `iDeleteBy`, `eStatus`) VALUES
(1, 'Super Admin', 'Back', 'Admin', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', 0, NULL, 'Active'),
(2, 'Data Operator', 'Back', 'Data Operator', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', 0, NULL, 'Active'),
(3, 'Transporter', 'Front', 'Transporter', 0, '2016-02-12 06:32:05', NULL, '0000-00-00 00:00:00', 0, NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `iSettingId` int(11) NOT NULL,
  `vName` varchar(765) DEFAULT NULL,
  `vDesc` varchar(765) DEFAULT NULL,
  `vValue` blob,
  `iOrderBy` tinyint(1) DEFAULT NULL,
  `eConfigType` varchar(30) DEFAULT NULL,
  `eDisplayType` varchar(27) DEFAULT NULL,
  `vDefValue` varchar(765) DEFAULT NULL,
  `vSourceValue` blob,
  `vValidateCode` blob,
  `vValidateMessage` blob,
  `eStatus` varchar(24) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`iSettingId`, `vName`, `vDesc`, `vValue`, `iOrderBy`, `eConfigType`, `eDisplayType`, `vDefValue`, `vSourceValue`, `vValidateCode`, `vValidateMessage`, `eStatus`) VALUES
(1, 'APPLICATION_NAME', 'Application Name', 0x3a3a3a20596f5472616e73706f7274203a3a3a, 2, 'Company', 'text', 'AHAX_HELP', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942686348427361574e6864476c76626942755957316c49673d3d, 'Active'),
(2, 'COMPANY_ADDRESS', 'Company Address', 0x432f3230332c20506172736877616e6174682041746c616e746973205061726b2c204e722e205461706f76616e20436972636c652c204d6f746572612c2041686d65646162616420333832343234, 2, 'Appearance', 'textarea', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a62323177595735354947466b5a484a6c63334d69, 'Active'),
(3, 'COMPANY_EMAIL', 'Company Email', 0x63616c6c3470656f6e40676d61696c2e636f6d, 3, 'Appearance', 'text', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a623231775957353549474e7064486b69, 'Active'),
(4, 'COMPANY_PHONE', 'Company Phone', 0x282b3931292038313533393838313831, 5, 'Appearance', 'text', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a623231775957353549474e7664573530636e6b69, 'Active'),
(5, 'COMPANY_FAX', 'Company Fax', '', 6, 'Company', 'text', '', NULL, 0x636d567864576c795a57513664484a315a537874615735735a57356e644767364d54417362574634624756755a33526f4f6a4977, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a623231775957353549475a686543497362576c75624756755a33526f4f694a5162475668633255675a5735305a58496762576c7561573131625341784d43426b6157647064484d694c4731686547786c626d643061446f695547786c59584e6c49475675644756794947316865476c74645730674d6a41675a476c6e6158527a49673d3d, 'Active'),
(6, 'COMPANY_NAME', 'Company Name', 0x63616c6c3470656f6e, 1, 'Appearance', 'text', 'Autoviewpoint', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a62323177595735354947356862575569, 'Active'),
(7, 'COMPANY_STATE', 'Company State', 0x4f6469736861, 4, 'Appearance', 'text', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a623231775957353549484e305958526c49673d3d, 'Active'),
(8, 'COMPANY_SUPPORT_EMAIL', 'Support Email Address', '', 2, 'Email', 'text', '', NULL, 0x636d567864576c795a57513664484a315a53786c6257467062447030636e566c, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369427a6458427762334a304947567459576c734947466b5a484a6c63334d694c47567459576c734f694a5162475668633255675a5735305a584967646d46736157516763335677634739796443426c62574670624342685a4752795a584e7a49673d3d, 'Active'),
(9, 'COMPANY_TOLL_FREE', 'Company Toll Free No.', '', 8, 'Company', 'text', '', NULL, '', '', 'Active'),
(10, 'COMPANY_ZIP', 'Company Zip Code', 0x333830303534, 7, 'Company', 'text', '', NULL, 0x636d567864576c795a57513664484a315a537874615735735a57356e644767364e537874595868735a57356e644767364d54413d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a62323177595735354948707063474e765a4755694c473170626d786c626d643061446f695547786c59584e6c494756756447567949473170626d6c74645730674e43426a6147467959574e305a584a7a49697874595868735a57356e64476736496c42735a57467a5a53426c626e526c6369427459586870625856744944457749474e6f59584a685933526c636e4d69, 'Active'),
(11, 'COPYRIGHTED_TEXT', 'Copyright text', 0xc2a92063616c6c3470656f6e2032303135202d2044657369676e65642042792069427562626c65, 9, 'Appearance', 'text', 'Copyright  All Rights Reserved ', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a62334235636d6c6e61485167644756346443493d, 'Active'),
(12, 'CPANEL_TITLE', 'Site Control Panel Title', 0x63616c6c3470656f6e, 9, '', 'text', 'AHAX_HELP', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c6369426a62323530636d397349484268626d5673494852706447786c49673d3d, 'Active'),
(13, 'EMAIL_ADMIN', 'Administrator Email ID', '', 1, 'Email', 'text', '', NULL, 0x636d567864576c795a57513664484a315a53774e436d567459576c734f6e52796457553d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942685a473170626d6c7a64484a68644739794947567459576c7349456c6b4969774e436d567459576c734f694a5162475668633255675a5735305a584967646d467361575167595752746157357063335279595852766369426c62574670624342705a43493d, 'Active'),
(14, 'FACEBOOK_LINK', 'Facebook link', 0x23, 1, 'Social', 'text', 'https://www.facebook.com/', NULL, NULL, NULL, 'Active'),
(15, 'FULLY_ENCRYPTED_TEXT', 'Fully Encrypted Text', '', 9, 'Appearance', 'textarea', NULL, NULL, NULL, NULL, 'Inactive'),
(16, 'IMAGE_EXTENSION', 'Valid Image Extension', '', 9, 'Appearance', 'textarea', '', NULL, '', '', 'Inactive'),
(17, 'IP_BLACKLIST', 'IP Black List (comma seperated)', '', 9, 'Appearance', 'textarea', NULL, NULL, NULL, NULL, 'Inactive'),
(18, 'META_DESCRIPTION', 'Meta Description', '', 3, 'Meta', 'textarea', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942745a5852684947526c63324e79615842306157397549673d3d, 'Active'),
(19, 'META_KEYWORD', 'Meta Keyword', '', 2, 'Meta', 'textarea', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942745a5852684947746c65586476636d5169, 'Active'),
(20, 'META_OTHER', 'Other SEO Related META TAGS', '', 4, 'Meta', 'textarea', '', NULL, '', '', 'Inactive'),
(21, 'META_TITLE', 'Meta Title', '', 1, 'Meta', 'textarea', '', NULL, 0x636d567864576c795a57513664484a315a513d3d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942745a585268494852706447786c49673d3d, 'Active'),
(22, 'NOTIFICATION_EMAIL', 'Notification Email ID', '', 3, 'Email', 'text', '', NULL, 0x636d567864576c795a57513664484a315a53774e436d567459576c734f6e52796457553d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c63694275623352705a6d6c6a59585270623234675a573168615777675957526b636d567a637949734451706c6257467062446f695547786c59584e6c494756756447567949485a6862476c6b4947357664476c6d61574e6864476c766269426c62574670624342685a4752795a584e7a49673d3d, 'Active'),
(23, 'PAGELIMIT', 'Page Limit', 0x35, 9, '', 'selectbox', '10', 0x312c322c332c342c352c362c372c382c392c31302c31312c31322c31332c31342c31352c31362c31372c31382c31392c3230, NULL, NULL, 'Active'),
(24, 'LINKEDIN_LINK', 'Linkedin Link', 0x68747470733a2f2f7777772e6c696e6b6564696e2e636f6d2f, 3, 'Social', 'text', 'https://www.linkedin.com/', NULL, NULL, NULL, 'Inactive'),
(25, 'REC_LIMIT', 'No Of Records Per Page (Admin Side)', 0x3235, 9, '', 'selectbox', '10', 0x31302c32302c32352c35302c37352c3130302c3135302c3230302c3235302c3330302c3530302c3735302c31303030, 0x636d567864576c795a57513664484a315a53786b6157647064484d3664484a315a537874595868735a57356e644767364d54413d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942775957646c4947787062576c304969786b6157647064484d36496c42735a57467a5a53426c626e52795a534232595778705a4342775957646c4947787062576c3049697874595868735a57356e64476736496c42735a57467a5a53426c626e526c63694274595867674d5441675a476c6e6158527a49673d3d, 'Active'),
(26, 'SEO_FRIENDLY_URL', 'SEO Friendly URL', 0x4e, 5, 'Meta', 'checkbox', '', NULL, '', '', 'Inactive'),
(27, 'TWITTER_LINK', 'Twitter link', 0x23, 2, 'Social', 'text', 'https://www.twitter.com/', NULL, NULL, NULL, 'Active'),
(28, 'USER_REC_LIMIT', 'No Of Records Per Page Front Side', 0x3130, 9, '', 'selectbox', '10', 0x31302c32302c32352c35302c37352c3130302c3135302c3230302c3235302c3330302c3530302c3735302c31303030, 0x636d567864576c795a57513664484a315a53786b6157647064484d3664484a315a537874595868735a57356e644767364d54413d, 0x636d567864576c795a575136496c42735a57467a5a53426c626e526c636942775957646c4947787062576c304969786b6157647064484d36496c42735a57467a5a53426c626e52795a534232595778705a4342775957646c4947787062576c3049697874595868735a57356e64476736496c42735a57467a5a53426c626e526c63694274595867674d5441675a476c6e6158527a49673d3d, 'Active'),
(29, 'USE_SMTP_SERVER', 'Send Mail via SMTP', 0x6f6e, 1, 'SMTP', 'checkbox', '', NULL, '', '', 'Active'),
(30, 'USE_SMTP_SERVERHOST', 'SMTP Server Host', 0x736d74702e6d616e6472696c6c6170702e636f6d, 2, 'SMTP', 'text', 'Y', NULL, '', '', 'Active'),
(31, 'USE_SMTP_SERVERPASS', 'SMTP Server Password', 0x4265733377703839464f676233334c7547796f453141, 4, 'SMTP', 'text', 'Y', NULL, '', '', 'Active'),
(32, 'USE_SMTP_SERVERPORT', 'SMTP Server Port', 0x353837, 5, 'SMTP', 'text', 'Y', NULL, '', '', 'Active'),
(33, 'USE_SMTP_SERVERUSERNAME', 'SMTP Server User name', 0x646576313973706c40676d61696c2e636f6d, 3, 'SMTP', 'text', 'Y', NULL, '', '', 'Active'),
(34, 'YOUTUBE_LINK', 'Youtube link', 0x68747470733a2f2f7777772e796f75747562652e636f6d2f, 4, 'Social', 'text', 'https://www.youtube.com/', NULL, NULL, NULL, 'Inactive'),
(35, 'SITE_TITLE', 'Site title for project', '', 9, 'Appearance', 'text', 'AHAX_HELP', NULL, NULL, 0x636d567864576c795a57513664484a315a513d3d, 'Active'),
(36, 'TWITTER_CONSUMER_KEY', 'Twitter consumer key', 0x4d623730397332474f31476a7a484778536d6e6a68636f6232, 10, 'Social', 'text', NULL, NULL, NULL, NULL, 'Inactive'),
(37, 'TWITTER_CONSUMER_SECRET_KEY', 'twitter consumer secret key', 0x6959377432414d6f314174347933436c4b366f36325a4f55334d4c4577485079675954354f69574767546667756d4a393177, 12, 'Social', 'text', NULL, NULL, NULL, NULL, 'Inactive'),
(38, 'LINKEDIN_API_KEY', 'linkedin api key', 0x37356e3836373663346773723336, 13, 'Social', 'text', NULL, NULL, NULL, NULL, 'Inactive'),
(39, 'LINKEDIN_SECRET_KEY', 'linkedin secret key', 0x7867594855714f554d36516d4a64714c, 14, 'Social', 'text', NULL, NULL, NULL, NULL, 'Inactive'),
(40, 'SESSION_TIMEOUT', 'Session Timeout(min)', 0x3330, 9, 'Apperance', 'text', NULL, NULL, NULL, NULL, 'Active'),
(41, 'WS_PAGE_LIMIT', 'Webservice Page LImit', 0x3130, 10, 'Apperance', 'text', NULL, NULL, NULL, NULL, 'Active'),
(42, 'ANDROID_LINK', 'Play Store link (Android)', 0x23, NULL, 'Social', 'text', 'https://play.google.com/store/apps', NULL, NULL, NULL, 'Active'),
(43, 'APPLE_LINK', 'iTunes link (iOS)', 0x23, NULL, 'Social', 'text', NULL, NULL, NULL, NULL, 'Active'),
(44, 'GOOGLE_PLUS', 'Google Link', 0x23, NULL, 'Social', 'text', 'https://plus.google.com', NULL, NULL, NULL, 'Active'),
(45, 'SOCIAL_ICONS', 'This is Social Icons', 0x5b7b226964223a2231222c226e616d65223a2246616365626f6f6b222c2269636f6e223a2266612d66616365626f6f6b222c226c696e6b223a22687474703a2f2f66616365626f6f6b2e636f6d2f63616c6c3470656f6e227d2c7b226964223a2232222c226e616d65223a2254776974746572222c226c696e6b223a22687474703a2f2f747769747465722e636f6d2f63616c6c3470656f6e222c2269636f6e223a2266612d74776974746572227d2c7b226964223a2233222c226e616d65223a22496e7374616772616d222c2269636f6e223a2266612d696e7374616772616d222c226c696e6b223a22687474703a2f2f696e7374616772616d2e636f6d2f63616c6c3470656f6e227d2c7b226964223a2263686f69636534222c226e616d65223a2250696e746572657374222c2269636f6e223a2266612d70696e746572657374222c226c696e6b223a22687474703a2f2f70696e7465726573742e636f6d2f63616c6c3470656f6e227d5d, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_images`
--

CREATE TABLE IF NOT EXISTS `shipment_images` (
  `iImageId` int(11) NOT NULL,
  `iShipmentId` int(11) NOT NULL,
  `vName` varchar(255) DEFAULT NULL,
  `dtCreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipment_images`
--

INSERT INTO `shipment_images` (`iImageId`, `iShipmentId`, `vName`, `dtCreatedDate`) VALUES
(1, 1, '1_20160926160131_0.png', '2016-09-26 16:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_master`
--

CREATE TABLE IF NOT EXISTS `shipment_master` (
  `iShipmentId` int(11) NOT NULL,
  `vTitle` varchar(255) DEFAULT NULL,
  `tDescription` varchar(255) DEFAULT NULL,
  `vContactNo` varchar(50) DEFAULT NULL,
  `vPreferredDate` datetime DEFAULT NULL,
  `iVehicleId` int(11) DEFAULT NULL,
  `vFirstName` varchar(255) DEFAULT NULL,
  `vLastName` varchar(255) DEFAULT NULL,
  `vPickupAddress` varchar(255) DEFAULT NULL,
  `vPickupArea` varchar(255) DEFAULT NULL,
  `vPickupLat` varchar(255) DEFAULT NULL,
  `vPickupLng` varchar(255) DEFAULT NULL,
  `vDropAddress` varchar(255) DEFAULT NULL,
  `vDropArea` varchar(255) DEFAULT NULL,
  `vDropLat` varchar(255) DEFAULT NULL,
  `vDropLng` varchar(255) DEFAULT NULL,
  `iIsShipped` enum('Pending','Shipped') DEFAULT NULL,
  `iIsUrgent` tinyint(1) DEFAULT '0',
  `dtCreatedDate` datetime DEFAULT NULL,
  `dtUpdatedDate` datetime DEFAULT NULL,
  `iIsDeleted` tinyint(1) DEFAULT NULL,
  `eStatus` enum('Active','Inactive','Pending') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipment_master`
--

INSERT INTO `shipment_master` (`iShipmentId`, `vTitle`, `tDescription`, `vContactNo`, `vPreferredDate`, `iVehicleId`, `vFirstName`, `vLastName`, `vPickupAddress`, `vPickupArea`, `vPickupLat`, `vPickupLng`, `vDropAddress`, `vDropArea`, `vDropLat`, `vDropLng`, `iIsShipped`, `iIsUrgent`, `dtCreatedDate`, `dtUpdatedDate`, `iIsDeleted`, `eStatus`) VALUES
(1, 'aa', 'bb', '9439700504', '2016-09-26 00:00:00', 1, 'Biswajit', 'Sahoo', 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'ccc', NULL, NULL, 'ddd', 'eee', NULL, NULL, 'Pending', 0, '2016-09-26 16:01:31', '2016-09-26 16:01:31', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `system_email`
--

CREATE TABLE IF NOT EXISTS `system_email` (
  `iEmailTemplateId` int(11) NOT NULL,
  `vEmailCode` varchar(150) DEFAULT NULL,
  `vEmailTitle` varchar(150) DEFAULT NULL,
  `vFromName` varchar(150) DEFAULT NULL,
  `vFromEmail` varchar(150) DEFAULT NULL,
  `vBccEmail` varchar(150) DEFAULT NULL,
  `eEmailFormat` varchar(150) DEFAULT NULL,
  `vEmailSubject` varchar(765) DEFAULT NULL,
  `tEmailMessage` blob,
  `vEmailFooter` varchar(765) DEFAULT NULL,
  `iCreatedBy` int(11) DEFAULT NULL,
  `dtCreated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `iModifyBy` int(11) DEFAULT NULL,
  `dtModify` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `isDelete` tinyint(1) DEFAULT '0',
  `iDeleteBy` int(11) DEFAULT NULL,
  `eStatus` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_email`
--

INSERT INTO `system_email` (`iEmailTemplateId`, `vEmailCode`, `vEmailTitle`, `vFromName`, `vFromEmail`, `vBccEmail`, `eEmailFormat`, `vEmailSubject`, `tEmailMessage`, `vEmailFooter`, `iCreatedBy`, `dtCreated`, `iModifyBy`, `dtModify`, `isDelete`, `iDeleteBy`, `eStatus`) VALUES
(1, 'USER_REQUEST', 'Request Accepted', 'iLogistics', 'demo@ilogistics.in', NULL, 'HTML', 'iLogistics has accepted your request.', 0x48656c6c6f2c3c62723e3c62723e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b0d0a0d0a2020202020202020596f7572207265717565737420697320616363657074656420627920596f5472616e73706f72742e20596f7520686176652070726f766964656420222023234944454e544954592323202220617320796f7572206964656e7469747920746f2075732e0d0a3c62723e3c62723e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b57652077696c6c207265706c7920796f752073686f72746c792e0d0a0d0a3c62723e3c62723e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b5468616e6b73210d0a3c62723e266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b266e6273703b596f5472616e73706f7274205465616d0d0a0d0a3c68722077696474683d2231303025223e0d0a3c70207374796c65203d2022746578742d616c69676e3a63656e746572223e2323434f505952494748545323233c2f703e, NULL, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0, 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE IF NOT EXISTS `user_master` (
  `iUserId` int(11) NOT NULL,
  `iRoleId` int(11) NOT NULL,
  `eUserType` enum('SELF','ADMIN') NOT NULL DEFAULT 'SELF',
  `vFirstName` varchar(255) NOT NULL,
  `vLastName` varchar(255) DEFAULT NULL,
  `vDl` varchar(255) DEFAULT NULL,
  `vIdimg` varchar(225) NOT NULL,
  `vEmail` varchar(255) DEFAULT NULL,
  `vPassword` varchar(255) DEFAULT NULL,
  `vContactNo` varchar(50) DEFAULT NULL,
  `iVehicleId` int(11) DEFAULT NULL,
  `vNumber` varchar(225) DEFAULT NULL,
  `tStandingPoint` text,
  `vArea` varchar(255) DEFAULT NULL,
  `tAddress` text,
  `eBusinessType` enum('Individual','Business') NOT NULL,
  `vDeviceId` varchar(255) DEFAULT NULL,
  `vSessionId` varchar(255) DEFAULT NULL,
  `dtCreatedDate` datetime DEFAULT NULL,
  `dtUpdatedDate` datetime DEFAULT NULL,
  `iIsDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `eStatus` enum('Active','Inactive','Pending') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`iUserId`, `iRoleId`, `eUserType`, `vFirstName`, `vLastName`, `vDl`, `vIdimg`, `vEmail`, `vPassword`, `vContactNo`, `iVehicleId`, `vNumber`, `tStandingPoint`, `vArea`, `tAddress`, `eBusinessType`, `vDeviceId`, `vSessionId`, `dtCreatedDate`, `dtUpdatedDate`, `iIsDeleted`, `eStatus`) VALUES
(1, 3, 'SELF', 'Biswajit', 'Sahoo', NULL, '', 'biswa4u85@gmail.com', NULL, '9439700504', 1, 'uy54j8976', NULL, 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'Individual', NULL, NULL, '2016-06-30 13:36:50', '2016-06-30 21:07:23', 1, 'Pending'),
(2, 3, 'ADMIN', 'Biswajit', 'Sahoo', '20160630134105_jpg', '20160630134105_jpg', 'biswa4u85@gmail.com', '2c06aca47eb399051fa25d6d56e3f4b7', '9439700504', 1, 'uy54j8976', 'Nayapali', 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'Individual', NULL, NULL, '2016-06-30 13:41:05', '2016-06-30 21:09:52', 1, 'Active'),
(3, 3, 'SELF', 'BiswajitS', 'Sahoo', NULL, '', 'biswa4u85@gmail.com', NULL, '9439700504', 1, 'uy54j8976', NULL, 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'Individual', NULL, NULL, '2016-06-30 13:41:45', '2016-06-30 21:04:12', 1, 'Pending'),
(4, 3, 'SELF', 'Biswajit', 'Sahoo', 'banner.jpg', 'callout-bg.jpg', 'biswa4u85@gmail.com', NULL, '9439700504', 0, '123', NULL, NULL, 'C-104, Sanidhya Greens, Near Vejnatha Mahadev Mandir, Vejalpur', 'Individual', NULL, NULL, '2016-08-31 14:50:03', '2016-08-31 14:50:03', 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE IF NOT EXISTS `vehicle_images` (
  `iImageId` int(11) NOT NULL,
  `iVehicleId` int(11) NOT NULL,
  `vName` varchar(255) NOT NULL,
  `dtCreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`iImageId`, `iVehicleId`, `vName`, `dtCreatedDate`) VALUES
(1, 0, '_20160630134105_0.', '2016-06-30 13:41:05'),
(2, 2, '2_20160630210741_0.', '2016-06-30 21:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type_master`
--

CREATE TABLE IF NOT EXISTS `vehicle_type_master` (
  `iVehicleTypeId` int(11) NOT NULL,
  `vType` varchar(255) NOT NULL,
  `vIcon` varchar(255) DEFAULT NULL,
  `dtCreatedDate` datetime DEFAULT NULL,
  `iCreatedBy` tinyint(1) DEFAULT '0',
  `dtUpdatedDate` datetime DEFAULT NULL,
  `iUpdatedBy` tinyint(1) DEFAULT '0',
  `iIsDeleted` tinyint(1) DEFAULT '0',
  `eStatus` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle_type_master`
--

INSERT INTO `vehicle_type_master` (`iVehicleTypeId`, `vType`, `vIcon`, `dtCreatedDate`, `iCreatedBy`, `dtUpdatedDate`, `iUpdatedBy`, `iIsDeleted`, `eStatus`) VALUES
(1, 'Tata AC', NULL, NULL, 0, NULL, 0, 0, 'Active'),
(2, 'Truck', NULL, NULL, 0, NULL, 0, 0, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`iAdminId`);

--
-- Indexes for table `log_history`
--
ALTER TABLE `log_history`
  ADD PRIMARY KEY (`iLogId`);

--
-- Indexes for table `module_master`
--
ALTER TABLE `module_master`
  ADD PRIMARY KEY (`iModuleId`);

--
-- Indexes for table `page_settings`
--
ALTER TABLE `page_settings`
  ADD PRIMARY KEY (`iPageId`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`iPermissionId`), ADD KEY `i_Module_Id_fk` (`iModuleId`);

--
-- Indexes for table `pre_launch`
--
ALTER TABLE `pre_launch`
  ADD PRIMARY KEY (`iRequestId`);

--
-- Indexes for table `role_master`
--
ALTER TABLE `role_master`
  ADD PRIMARY KEY (`iRoleId`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`iSettingId`);

--
-- Indexes for table `shipment_images`
--
ALTER TABLE `shipment_images`
  ADD PRIMARY KEY (`iImageId`);

--
-- Indexes for table `shipment_master`
--
ALTER TABLE `shipment_master`
  ADD PRIMARY KEY (`iShipmentId`);

--
-- Indexes for table `system_email`
--
ALTER TABLE `system_email`
  ADD PRIMARY KEY (`iEmailTemplateId`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`iUserId`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD PRIMARY KEY (`iImageId`);

--
-- Indexes for table `vehicle_type_master`
--
ALTER TABLE `vehicle_type_master`
  ADD PRIMARY KEY (`iVehicleTypeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `iAdminId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log_history`
--
ALTER TABLE `log_history`
  MODIFY `iLogId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `module_master`
--
ALTER TABLE `module_master`
  MODIFY `iModuleId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `page_settings`
--
ALTER TABLE `page_settings`
  MODIFY `iPageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `iPermissionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `pre_launch`
--
ALTER TABLE `pre_launch`
  MODIFY `iRequestId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role_master`
--
ALTER TABLE `role_master`
  MODIFY `iRoleId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `iSettingId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `shipment_images`
--
ALTER TABLE `shipment_images`
  MODIFY `iImageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shipment_master`
--
ALTER TABLE `shipment_master`
  MODIFY `iShipmentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `system_email`
--
ALTER TABLE `system_email`
  MODIFY `iEmailTemplateId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `iUserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `iImageId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vehicle_type_master`
--
ALTER TABLE `vehicle_type_master`
  MODIFY `iVehicleTypeId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
