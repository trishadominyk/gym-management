-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.26-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_gym
CREATE DATABASE IF NOT EXISTS `db_gym` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_gym`;

-- Dumping structure for table db_gym.tbl_activity
CREATE TABLE IF NOT EXISTS `tbl_activity` (
  `act_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `act_name` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`act_id`)
) ENGINE=MyISAM AUTO_INCREMENT=200026 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_activity: 24 rows
/*!40000 ALTER TABLE `tbl_activity` DISABLE KEYS */;
INSERT INTO `tbl_activity` (`act_id`, `act_name`) VALUES
	(200001, 'Squats'),
	(200002, 'Sparring'),
	(200003, 'Speedball'),
	(200004, 'Jumprope'),
	(200005, 'Cycling'),
	(200006, 'Push ups'),
	(200007, 'Sit ups'),
	(200008, 'Punching Bag - Uppercuts'),
	(200009, 'Burpees'),
	(200010, 'Mountain Climbers'),
	(200011, 'Jump Squats'),
	(200012, 'Warm Up - Stretching'),
	(200013, 'Warm Up - Punching Bag'),
	(200014, 'Cool Down'),
	(200015, 'One on One Mitts'),
	(200016, 'Shadow Boxing'),
	(200017, 'Punching Bag - Jabs/Straight'),
	(200018, 'Ladder'),
	(200019, 'Circuit Training'),
	(200020, 'Jumping Jacks'),
	(200021, 'Punching Bag - Knee'),
	(200022, 'Punching Bag - Kick'),
	(200023, 'Punching Bag - Elbow'),
	(200025, 'Punching Bag - Speed');
/*!40000 ALTER TABLE `tbl_activity` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_actprogress
CREATE TABLE IF NOT EXISTS `tbl_actprogress` (
  `acp_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wra_id` int(7) NOT NULL DEFAULT '0',
  `pro_id` bigint(20) NOT NULL DEFAULT '0',
  `acp_status` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`acp_id`),
  KEY `wra_id` (`wra_id`),
  KEY `pro_id` (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_actprogress: 61 rows
/*!40000 ALTER TABLE `tbl_actprogress` DISABLE KEYS */;
INSERT INTO `tbl_actprogress` (`acp_id`, `wra_id`, `pro_id`, `acp_status`) VALUES
	(1, 45, 1, 'COMPLETE'),
	(2, 46, 1, 'COMPLETE'),
	(3, 48, 1, 'COMPLETE'),
	(4, 32, 2, 'COMPLETE'),
	(5, 33, 2, 'INCOMPLETE'),
	(6, 34, 2, 'INCOMPLETE'),
	(7, 35, 2, 'INCOMPLETE'),
	(8, 6, 3, ''),
	(9, 6, 4, ''),
	(10, 45, 5, 'COMPLETE'),
	(11, 46, 5, 'COMPLETE'),
	(12, 48, 5, 'COMPLETE'),
	(13, 36, 6, 'INCOMPLETE'),
	(14, 37, 6, 'COMPLETE'),
	(15, 38, 6, ''),
	(16, 39, 6, ''),
	(17, 40, 6, ''),
	(18, 45, 7, 'COMPLETE'),
	(19, 46, 7, 'COMPLETE'),
	(20, 48, 7, 'COMPLETE'),
	(21, 10, 8, 'COMPLETE'),
	(22, 13, 8, 'COMPLETE'),
	(23, 14, 8, ''),
	(24, 15, 8, ''),
	(25, 16, 8, ''),
	(26, 6, 9, 'INCOMPLETE'),
	(27, 45, 10, 'COMPLETE'),
	(28, 46, 10, 'COMPLETE'),
	(29, 48, 10, 'SKIPPED'),
	(30, 45, 11, 'COMPLETE'),
	(31, 46, 11, 'COMPLETE'),
	(32, 48, 11, 'COMPLETE'),
	(33, 49, 11, 'COMPLETE'),
	(34, 45, 12, ''),
	(35, 46, 12, ''),
	(36, 48, 12, ''),
	(37, 49, 12, ''),
	(38, 45, 13, 'COMPLETE'),
	(39, 46, 13, 'COMPLETE'),
	(40, 48, 13, 'SKIPPED'),
	(41, 49, 13, 'COMPLETE'),
	(42, 45, 16, ''),
	(43, 46, 16, ''),
	(44, 48, 16, ''),
	(45, 49, 16, ''),
	(46, 45, 17, ''),
	(47, 46, 17, ''),
	(48, 48, 17, ''),
	(49, 49, 17, ''),
	(50, 45, 18, ''),
	(51, 46, 18, ''),
	(52, 48, 18, ''),
	(53, 49, 18, ''),
	(54, 45, 19, ''),
	(55, 46, 19, ''),
	(56, 48, 19, ''),
	(57, 49, 19, ''),
	(58, 45, 20, 'COMPLETE'),
	(59, 46, 20, 'INCOMPLETE'),
	(60, 48, 20, 'COMPLETE'),
	(61, 49, 20, 'COMPLETE');
/*!40000 ALTER TABLE `tbl_actprogress` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_announcement
CREATE TABLE IF NOT EXISTS `tbl_announcement` (
  `ann_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ann_title` varchar(150) NOT NULL DEFAULT '',
  `ann_content` varchar(1000) NOT NULL DEFAULT '',
  `ann_date` date NOT NULL DEFAULT '0000-00-00',
  `ann_status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_announcement: ~3 rows (approximately)
/*!40000 ALTER TABLE `tbl_announcement` DISABLE KEYS */;
INSERT INTO `tbl_announcement` (`ann_id`, `ann_title`, `ann_content`, `ann_date`, `ann_status`) VALUES
	(1, 'BER Months are here. Let\'s hustle!', 'GOOD NEWS! We are OPEN tomorrow, September 1st (Friday) and on Monday next week! (regular training hours) No holiday off this time.', '2017-08-31', ''),
	(2, 'Important Announcement', 'To all 6100 Gym clients, we regret to inform you that we will have facility closure tomorrow, August 29, 2017 (Tuesday).', '2017-08-28', ''),
	(3, 'IMPORTANT ANNOUNCEMENT', 'Facility closure tomorrow, October 7, 2017 (Saturday). The gym will be occupied privately.\r\nClasses will resume on Tuesday, October 9, 2017.\r\nSorry for the inconvenience.', '2017-10-04', '');
/*!40000 ALTER TABLE `tbl_announcement` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_bmi
CREATE TABLE IF NOT EXISTS `tbl_bmi` (
  `bmi_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `bmi_height` double NOT NULL DEFAULT '0',
  `bmi_weight` double NOT NULL DEFAULT '0',
  `bmi_date` date NOT NULL DEFAULT '0000-00-00',
  `cust_id` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bmi_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_bmi: 1 rows
/*!40000 ALTER TABLE `tbl_bmi` DISABLE KEYS */;
INSERT INTO `tbl_bmi` (`bmi_id`, `bmi_height`, `bmi_weight`, `bmi_date`, `cust_id`) VALUES
	(1, 71, 210, '2017-10-02', 2147483647);
/*!40000 ALTER TABLE `tbl_bmi` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_category
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=203 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_category: 2 rows
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` (`cat_id`, `cat_name`) VALUES
	(201, 'HEAVY WEIGHT'),
	(202, 'Free weight');
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_class
CREATE TABLE IF NOT EXISTS `tbl_class` (
  `cls_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `cls_name` varchar(180) NOT NULL DEFAULT '',
  `cls_desc` varchar(500) NOT NULL DEFAULT '',
  `cls_status` varchar(12) NOT NULL DEFAULT 'ACTIVE',
  `cls_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cls_sessions` int(3) NOT NULL DEFAULT '0',
  `clc_id` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cls_id`),
  KEY `clc_id` (`clc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4022 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_class: 15 rows
/*!40000 ALTER TABLE `tbl_class` DISABLE KEYS */;
INSERT INTO `tbl_class` (`cls_id`, `cls_name`, `cls_desc`, `cls_status`, `cls_rate`, `cls_sessions`, `clc_id`) VALUES
	(4001, 'Boxing (Unli Sessions) - Regular', '', 'ACTIVE', 1500.00, 30, 501),
	(4002, 'Boxing (12 Sessions) - Regular', '', 'ACTIVE', 1200.00, 12, 501),
	(4008, 'Muay Thai (Unli Sessions) - Regular', '', 'ACTIVE', 1800.00, 30, 502),
	(4009, 'Muay Thai (12 Sessions) - Regular', '', 'ACTIVE', 1500.00, 12, 502),
	(4010, 'Boxing (Session) - Regular', '', 'ACTIVE', 150.00, 1, 501),
	(4011, 'Muay Thai (Session) - Regular', '', 'ACTIVE', 150.00, 1, 502),
	(4020, 'Boxing (Session) - Student', '', 'ACTIVE', 100.00, 1, 501),
	(4013, 'Jiu Jitsu (12 Sessions)', '', 'ACTIVE', 1200.00, 12, 503),
	(4021, 'Muay Thai (Session) - Student', '', 'ACTIVE', 150.00, 1, 502),
	(4014, 'Boxing (Unli Sessions) - Student/Group', '', 'ACTIVE', 1300.00, 30, 501),
	(4015, 'Boxing (12 Sessions) - Student/Group', '', 'ACTIVE', 1000.00, 12, 501),
	(4016, 'Muay Thai (Unli Sessions) - Student/Group', '', 'ACTIVE', 1500.00, 30, 502),
	(4017, 'Muay Thai (12 Sessions) - Student/Group', '', 'ACTIVE', 1300.00, 12, 502),
	(4018, 'Jiu Jitsu (Session) - Student', '', 'ACTIVE', 200.00, 1, 503),
	(4019, 'Jiu Jitsu (Session) - Regular', '', 'ACTIVE', 250.00, 1, 503);
/*!40000 ALTER TABLE `tbl_class` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_classcategory
CREATE TABLE IF NOT EXISTS `tbl_classcategory` (
  `clc_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `clc_name` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`clc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=504 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_classcategory: 3 rows
/*!40000 ALTER TABLE `tbl_classcategory` DISABLE KEYS */;
INSERT INTO `tbl_classcategory` (`clc_id`, `clc_name`) VALUES
	(501, 'BOXING'),
	(502, 'MUAY THAI'),
	(503, 'JIU JITSU');
/*!40000 ALTER TABLE `tbl_classcategory` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_customer
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `cust_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `cust_code` varchar(15) NOT NULL DEFAULT '',
  `cust_firstname` varchar(100) NOT NULL DEFAULT '',
  `cust_lastname` varchar(100) NOT NULL DEFAULT '',
  `cust_email` varchar(150) NOT NULL DEFAULT '',
  `cust_birthday` date NOT NULL DEFAULT '0000-00-00',
  `cust_password` varchar(150) NOT NULL DEFAULT '',
  `cust_contact` varchar(12) NOT NULL DEFAULT '',
  `cust_emergency` varchar(12) NOT NULL DEFAULT '',
  `cust_date_added` date NOT NULL DEFAULT '0000-00-00',
  `cust_status` varchar(12) NOT NULL DEFAULT 'ACTIVE',
  `mem_id` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cust_id`),
  KEY `mem_id` (`mem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10000000020 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_customer: 21 rows
/*!40000 ALTER TABLE `tbl_customer` DISABLE KEYS */;
INSERT INTO `tbl_customer` (`cust_id`, `cust_code`, `cust_firstname`, `cust_lastname`, `cust_email`, `cust_birthday`, `cust_password`, `cust_contact`, `cust_emergency`, `cust_date_added`, `cust_status`, `mem_id`) VALUES
	(2147483647, 'omvHYo7I4271109', 'Emily Marie', 'Adams', 'emzadamz@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000001),
	(4294967295, 'omvHYo7I4271ek0', 'Juan', 'Bieber', 'jbieber@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000006),
	(10000000001, 'omvHYo123271ekp', 'Gian', 'Valero', 'gian@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000015),
	(10000000002, 'omvIQo7I4271ekp', 'Joe', 'Jonas', 'joejonas@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000003, 'omvHYo144271ekp', 'Benka', 'Ermac', 'ermacbianca@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000004, '13vHYo7I4271ekp', 'Bingo', 'Salangsang', 'bingo@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000005, 'omvHYo7I427112p', 'Dominyk', 'Alvarez', 'dom@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000008),
	(10000000006, 'omvHYo7I4271e11', 'Jake', 'Zyrus', 'zyrusjake@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000007, 'omvHYo7I1071ekp', 'Robyn', 'Fenty', 'rihrih@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000008, 'omvHYo7I4271eko', 'Drake', 'Aubrey', 'drake@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000009),
	(10000000009, 'oatHYo7I4271ekp', 'Kim', 'Chi', 'kimchi@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000010),
	(10000000010, 'omvHY77I4271ekp', 'John', 'Doe', 'johndoe@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000011, '6mvHYo7I4271ekp', 'Khalid', 'Robinson', 'thegr8khalid@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000012, 'omvHYo7I4271ek5', 'Pharell', 'Williams', 'pharell@example', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 0),
	(10000000013, 'omvHYo7I4271ek4', 'Ay-Ayron', 'Aaron', 'ayayron@gmail.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '0000-00-00', 'ACTIVE', 100000007),
	(10000000014, 'omvHYo7I4271ek3', 'Jane', 'Doe', 'jane_doe@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '2017-07-17', 'ACTIVE', 0),
	(10000000015, 'omvHYo7I4271ek2', 'AAA', 'BBB', 'aaabbb@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '2017-07-29', 'ACTIVE', 0),
	(10000000016, 'omvHYo454271ekp', 'CCC', 'DDD', 'ccc@example.com', '0000-00-00', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '2017-09-15', 'ACTIVE', 0),
	(10000000017, '1ivHYo7I4271ekp', 'Felix', 'Pewdiepie', 'pewdiepie@gmail.com', '1980-07-10', '5f4dcc3b5aa765d61d8327deb882cf99', '09335604939', '411', '2017-10-15', 'ACTIVE', 0),
	(10000000018, 'omvHYo7I4271ek1', 'Xander', 'Ford', 'xander@gmail.com', '1995-02-27', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '2017-10-16', 'ACTIVE', 0),
	(10000000019, 'omvHYo7I4271ekp', 'Ansel', 'Elgort', 'anselelgort@gmail.com', '1986-01-13', '5f4dcc3b5aa765d61d8327deb882cf99', '', '', '2017-10-16', 'ACTIVE', 100000016);
/*!40000 ALTER TABLE `tbl_customer` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_equipment
CREATE TABLE IF NOT EXISTS `tbl_equipment` (
  `eqp_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `eqp_serial` varchar(100) NOT NULL DEFAULT '',
  `eqp_name` varchar(150) NOT NULL DEFAULT '',
  `eqp_date_added` date NOT NULL DEFAULT '0000-00-00',
  `eqp_date_update` date NOT NULL DEFAULT '0000-00-00',
  `cat_id` int(3) NOT NULL DEFAULT '0',
  `eqp_status` varchar(20) NOT NULL DEFAULT 'AVAILABLE',
  PRIMARY KEY (`eqp_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40024 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_equipment: 20 rows
/*!40000 ALTER TABLE `tbl_equipment` DISABLE KEYS */;
INSERT INTO `tbl_equipment` (`eqp_id`, `eqp_serial`, `eqp_name`, `eqp_date_added`, `eqp_date_update`, `cat_id`, `eqp_status`) VALUES
	(40004, 'X8SZO-FAT9V-PEX82-JXZ7L', '18 Lbs Barbell', '2017-09-10', '2017-09-15', 202, 'DISPOSED'),
	(40005, 'VE4K7-TR1LN-55D5Q-HKPYD', '18 Lbs Barbell', '2017-09-10', '2017-10-06', 202, 'DISPOSED'),
	(40006, 'JFKPE-FPULE-BV0TO-PA8PP', '18 Lbs Barbell', '2017-09-10', '2017-10-06', 202, 'REPAIR'),
	(40007, 'NYWOL-GAZGQ-83K70-8LY7L', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40008, 'HAI00-29IT9-KD4VP-7KLFU', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40009, 'F1VYT-SRW4A-QO0UF-SMMM6', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40010, 'XQCNR-8BYYZ-BKFUI-VJ9MV', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40011, 'IQWYJ-KD4YY-274ES-9KF61', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40012, 'LJLHH-RJNBZ-2TXQ9-ZYHTA', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40013, 'CKFDK-R06Z2-2BXZ0-TX9U7', '18 Lbs Barbell', '2017-09-10', '0000-00-00', 202, 'AVAILABLE'),
	(40014, 'PXIRK-QLB7B-EP1J6-5NHLS', 'barbell', '2017-09-15', '2017-09-15', 201, 'DISPOSED'),
	(40015, 'GWNJV-MLVC5-9INBG-7IU5X', 'barbell', '2017-09-15', '2017-09-15', 201, 'OKAY'),
	(40016, 'LZNJM-7UN6Z-D58XW-1RC50', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40017, 'RTTWH-EN8UK-636AA-LHATE', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40018, 'A81US-NRV8F-D9YLQ-BEUIJ', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40019, 'BZNWY-IY1A7-HSJCY-NA7D8', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40020, 'B39JS-3DIID-GHF67-HBV3K', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40021, 'Y14ZK-60BY5-JCYTE-1SER7', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40022, 'XHU0E-059KB-2BJCE-4B2BO', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY'),
	(40023, '0M967-AX18Z-0W1TH-E1CZ7', 'barbell', '2017-09-15', '0000-00-00', 201, 'OKAY');
/*!40000 ALTER TABLE `tbl_equipment` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_event
CREATE TABLE IF NOT EXISTS `tbl_event` (
  `evn_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `evn_name` varchar(180) NOT NULL DEFAULT '',
  `evn_desc` varchar(250) NOT NULL DEFAULT '',
  `evn_status` varchar(10) NOT NULL DEFAULT 'APPROVED',
  `evn_image` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`evn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_event: 10 rows
/*!40000 ALTER TABLE `tbl_event` DISABLE KEYS */;
INSERT INTO `tbl_event` (`evn_id`, `evn_name`, `evn_desc`, `evn_status`, `evn_image`) VALUES
	(1, '6100 Fight Fest 2017', 'MMA Main Event: Mark Nimanand VS Fritz Estrella, MMA Co Event Dave Gonzales vs Art Mandal', 'APPROVED', '../../../../img/events/6100fightfest.jpg'),
	(2, 'Sample Event 1 ', 'Sample Description 1', 'CANCELED', '../../../../img/events/16864614_502189946618294_2594476719425535510_n.jpg'),
	(3, 'Sample Booking 2 ', 'Sample Booking Description 2', 'APPROVED', '../../../../img/events/'),
	(4, 'Sample Booking 3', 'Sample Description 3', 'APPROVED', '../../../../img/events/'),
	(5, 'Sample Booking 4 ', 'Sample Description 4', 'APPROVED', '../../../../img/events/'),
	(6, 'Sample Booking 5', 'Sample Description 5', 'APPROVED', '../../../../img/events/'),
	(7, 'Sample Booking 6', 'Sample Description 5', 'APPROVED', '../../../../img/events/'),
	(8, 'Sample Booking 7', 'Sample Description 7', 'APPROVED', '../../../../img/events/'),
	(9, 'Sample Booking 8', 'Sample Description 8', 'APPROVED', '../../../../img/events/'),
	(10, '6100 fight fest', '', 'APPROVED', '../../../../img/events/796271_18620419_1537871696232355_4853457683856252988_n.jpg');
/*!40000 ALTER TABLE `tbl_event` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_eventdetail
CREATE TABLE IF NOT EXISTS `tbl_eventdetail` (
  `evn_det_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `evn_det_date` date NOT NULL DEFAULT '0000-00-00',
  `evn_det_venue` varchar(100) NOT NULL DEFAULT '',
  `evn_det_time_start` time NOT NULL DEFAULT '00:00:00',
  `evn_det_time_end` time NOT NULL DEFAULT '00:00:00',
  `evn_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`evn_det_id`),
  KEY `evn_id` (`evn_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_eventdetail: 10 rows
/*!40000 ALTER TABLE `tbl_eventdetail` DISABLE KEYS */;
INSERT INTO `tbl_eventdetail` (`evn_det_id`, `evn_det_date`, `evn_det_venue`, `evn_det_time_start`, `evn_det_time_end`, `evn_id`) VALUES
	(12, '2017-10-01', 'asdasd', '15:00:00', '20:00:00', 4),
	(7, '2017-09-29', 'BABABABA', '15:00:00', '20:00:00', 2),
	(9, '2017-09-25', 'Nompac Multipurpose Gym', '15:00:00', '20:00:00', 1),
	(11, '2017-09-30', 'Sample venue2', '15:00:00', '20:00:00', 3),
	(13, '2017-10-03', 'Sadasdasd', '15:00:00', '20:00:00', 5),
	(14, '2017-10-14', 'dasdsa', '15:00:00', '20:00:00', 6),
	(15, '2017-11-04', 'dsadsad', '15:00:00', '20:00:00', 7),
	(16, '2017-11-01', 'deqweqwe', '10:00:00', '14:00:00', 8),
	(17, '2017-11-25', 'dwerewr', '15:00:00', '21:00:00', 9),
	(18, '2017-10-06', 'nompac gym', '17:00:00', '20:00:00', 10);
/*!40000 ALTER TABLE `tbl_eventdetail` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_level
CREATE TABLE IF NOT EXISTS `tbl_level` (
  `lvl_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `lvl_name` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`lvl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_level: 3 rows
/*!40000 ALTER TABLE `tbl_level` DISABLE KEYS */;
INSERT INTO `tbl_level` (`lvl_id`, `lvl_name`) VALUES
	(101, 'ADMIN'),
	(102, 'CASHIER'),
	(103, 'COACH');
/*!40000 ALTER TABLE `tbl_level` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_logbook
CREATE TABLE IF NOT EXISTS `tbl_logbook` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `log_code` varchar(12) NOT NULL DEFAULT '',
  `log_date` date NOT NULL DEFAULT '0000-00-00',
  `log_timein` time NOT NULL DEFAULT '00:00:00',
  `log_timeout` time DEFAULT NULL,
  `cust_id` bigint(11) NOT NULL DEFAULT '0',
  `rec_id` bigint(20) NOT NULL DEFAULT '0',
  `stf_id` int(4) NOT NULL DEFAULT '0',
  `wrk_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `cust_id` (`cust_id`),
  KEY `rec_id` (`rec_id`),
  KEY `stf_id` (`stf_id`),
  KEY `wrk_id` (`wrk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_logbook: 25 rows
/*!40000 ALTER TABLE `tbl_logbook` DISABLE KEYS */;
INSERT INTO `tbl_logbook` (`log_id`, `log_code`, `log_date`, `log_timein`, `log_timeout`, `cust_id`, `rec_id`, `stf_id`, `wrk_id`) VALUES
	(1, '0925-1', '2017-09-25', '09:51:17', '16:52:11', 10000000013, 1, 1007, 2011),
	(2, '0925-2', '2017-09-25', '09:53:34', '16:52:09', 2147483647, 2, 1007, 2008),
	(3, '0925-3', '2017-09-25', '11:59:59', NULL, 4294967295, 3, 1007, 2002),
	(4, '1002-1', '2017-10-02', '19:56:31', '21:31:48', 10000000013, 1, 1007, 0),
	(5, '1003-1', '2017-10-03', '07:43:44', '21:31:58', 10000000013, 1, 1007, 2002),
	(6, '1004-1', '2017-10-04', '08:08:42', '09:28:22', 10000000013, 1, 1006, 2009),
	(7, '1004-2', '2017-10-04', '21:32:44', NULL, 2147483647, 2, 1006, 2011),
	(8, '1005-1', '2017-10-05', '10:02:58', '17:05:12', 10000000013, 1, 1006, 2011),
	(9, '1005-2', '2017-10-05', '11:51:34', '17:05:24', 2147483647, 2, 1006, 2004),
	(10, '1005-3', '2017-10-05', '16:49:57', '17:05:16', 10000000008, 7, 1006, 2002),
	(11, '1005-4', '2017-10-05', '17:19:49', '08:44:42', 10000000015, 4, 1007, 0),
	(12, '1005-5', '2017-10-05', '17:26:25', '17:36:50', 10000000008, 7, 1007, 2011),
	(13, '1005-6', '2017-10-05', '20:46:30', NULL, 2147483647, 5, 1006, 0),
	(14, '1006-1', '2017-10-06', '07:11:08', '09:28:58', 10000000013, 1, 1006, 2011),
	(15, '1006-2', '2017-10-06', '08:09:11', NULL, 2147483647, 5, 1006, 2011),
	(16, '1006-3', '2017-10-06', '08:12:36', '08:54:08', 10000000008, 7, 1006, 0),
	(17, '1006-4', '2017-10-06', '08:14:11', '09:16:59', 10000000015, 4, 1006, 2011),
	(18, '1006-5', '2017-10-06', '08:15:01', '22:55:43', 10000000005, 9, 1006, 2011),
	(19, '1006-6', '2017-10-06', '08:16:33', '08:49:53', 4294967295, 10, 1006, 2011),
	(20, '1006-7', '2017-10-06', '09:24:27', '22:54:14', 10000000015, 4, 1006, 2011),
	(21, '1006-8', '2017-10-06', '09:25:37', NULL, 10000000008, 7, 1007, 0),
	(22, '1006-9', '2017-10-06', '13:40:56', NULL, 4294967295, 12, 1006, 0),
	(23, '1006-10', '2017-10-06', '22:53:24', NULL, 2147483647, 2, 1007, 0),
	(24, '1007-1', '2017-10-07', '05:18:39', NULL, 10000000013, 1, 1006, 2011),
	(25, '1017-1', '2017-10-17', '01:54:28', NULL, 10000000013, 1, 1006, 2011);
/*!40000 ALTER TABLE `tbl_logbook` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_membership
CREATE TABLE IF NOT EXISTS `tbl_membership` (
  `mem_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `mem_date_added` date NOT NULL DEFAULT '0000-00-00',
  `mem_date_expire` date NOT NULL DEFAULT '0000-00-00',
  `met_id` int(4) NOT NULL DEFAULT '0',
  `mem_status` varchar(15) NOT NULL DEFAULT '',
  `cust_id` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mem_id`),
  KEY `met_id` (`met_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100000017 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_membership: 8 rows
/*!40000 ALTER TABLE `tbl_membership` DISABLE KEYS */;
INSERT INTO `tbl_membership` (`mem_id`, `mem_date_added`, `mem_date_expire`, `met_id`, `mem_status`, `cust_id`) VALUES
	(100000001, '2017-07-06', '2018-07-06', 3001, 'ACTIVE', 2147483647),
	(100000006, '2017-07-19', '2017-08-19', 3001, 'ACTIVE', 4294967295),
	(100000007, '2017-08-18', '2017-08-18', 3003, 'ACTIVE', 10000000013),
	(100000008, '2017-08-19', '2018-08-19', 3001, 'ACTIVE', 10000000005),
	(100000009, '2017-09-12', '2018-09-12', 3001, 'ACTIVE', 10000000008),
	(100000010, '2017-09-14', '2018-09-14', 3001, 'ACTIVE', 10000000009),
	(100000015, '2017-10-06', '2018-10-06', 3001, 'ACTIVE', 10000000001),
	(100000016, '2017-10-16', '2018-04-17', 3002, 'ACTIVE', 10000000019);
/*!40000 ALTER TABLE `tbl_membership` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_membershiptype
CREATE TABLE IF NOT EXISTS `tbl_membershiptype` (
  `met_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `met_name` varchar(180) NOT NULL DEFAULT '',
  `met_duration` int(10) NOT NULL DEFAULT '0',
  `met_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `met_status` varchar(12) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`met_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3004 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_membershiptype: 3 rows
/*!40000 ALTER TABLE `tbl_membershiptype` DISABLE KEYS */;
INSERT INTO `tbl_membershiptype` (`met_id`, `met_name`, `met_duration`, `met_rate`, `met_status`) VALUES
	(3001, '1 Year Membership', 365, 300.00, 'ACTIVE'),
	(3002, '6 Months Membership', 183, 200.00, 'ACTIVE'),
	(3003, 'Lifetime Membership', 0, 2500.00, 'ACTIVE');
/*!40000 ALTER TABLE `tbl_membershiptype` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_progress
CREATE TABLE IF NOT EXISTS `tbl_progress` (
  `pro_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pro_percentage` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pro_status` varchar(10) NOT NULL DEFAULT 'ONGOING',
  `pro_start` time NOT NULL DEFAULT '00:00:00',
  `pro_end` time NOT NULL DEFAULT '00:00:00',
  `log_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pro_id`),
  KEY `wrk_id` (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_progress: 18 rows
/*!40000 ALTER TABLE `tbl_progress` DISABLE KEYS */;
INSERT INTO `tbl_progress` (`pro_id`, `pro_percentage`, `pro_status`, `pro_start`, `pro_end`, `log_id`) VALUES
	(1, 100.00, 'FINISHED', '00:00:00', '00:00:00', 1),
	(2, 62.50, 'FINISHED', '00:00:00', '00:00:00', 2),
	(3, 0.00, 'ONGOING', '00:00:00', '00:00:00', 3),
	(4, 100.00, 'ONGOING', '00:00:00', '00:00:00', 5),
	(5, 83.33, 'FINISHED', '00:00:00', '00:00:00', 7),
	(6, 30.00, 'ONGOING', '00:00:00', '00:00:00', 6),
	(7, 100.00, 'FINISHED', '00:00:00', '00:00:00', 8),
	(8, 40.00, 'ONGOING', '00:00:00', '00:00:00', 9),
	(9, 50.00, 'ONGOING', '00:00:00', '00:00:00', 10),
	(10, 66.67, 'FINISHED', '00:00:00', '00:00:00', 12),
	(11, 100.00, 'FINISHED', '00:00:00', '00:00:00', 14),
	(12, 0.00, 'FINISHED', '00:00:00', '00:00:00', 15),
	(13, 75.00, 'FINISHED', '00:00:00', '00:00:00', 19),
	(17, 0.00, 'ONGOING', '00:00:00', '00:00:00', 18),
	(16, 0.00, 'ONGOING', '00:00:00', '00:00:00', 20),
	(18, 0.00, 'ONGOING', '00:00:00', '00:00:00', 17),
	(19, 0.00, 'ONGOING', '00:00:00', '00:00:00', 24),
	(20, 87.50, 'FINISHED', '01:54:54', '11:39:26', 25);
/*!40000 ALTER TABLE `tbl_progress` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_promo
CREATE TABLE IF NOT EXISTS `tbl_promo` (
  `prm_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `prm_code` varchar(10) NOT NULL DEFAULT '',
  `prm_desc` varchar(200) NOT NULL DEFAULT '',
  `prm_date_start` date NOT NULL DEFAULT '0000-00-00',
  `prm_date_end` date NOT NULL DEFAULT '0000-00-00',
  `prm_discount` double(10,2) NOT NULL DEFAULT '0.00',
  `prm_avail` int(5) NOT NULL DEFAULT '0',
  `prm_max` int(5) NOT NULL DEFAULT '0',
  `prm_status` varchar(20) NOT NULL DEFAULT 'OPEN',
  PRIMARY KEY (`prm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50005 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_promo: 4 rows
/*!40000 ALTER TABLE `tbl_promo` DISABLE KEYS */;
INSERT INTO `tbl_promo` (`prm_id`, `prm_code`, `prm_desc`, `prm_date_start`, `prm_date_end`, `prm_discount`, `prm_avail`, `prm_max`, `prm_status`) VALUES
	(50001, 'BCDBOX100', 'MAY DISCOUNT NA DN PKMO?', '0000-00-00', '0000-00-00', 300.00, 0, 0, 'OPEN'),
	(50002, 'BAGSIKBOXI', 'PILA KADA?', '0000-00-00', '0000-00-00', 500.00, 0, 0, '0'),
	(50003, 'GROUP5', 'Avail a discount if you enroll as a group of 5!', '0000-00-00', '0000-00-00', 200.00, 0, 0, '0'),
	(50004, 'grabboxing', 'sa,ple description ', '2017-11-01', '2017-11-30', 200.00, 0, 100, 'CLOSE');
/*!40000 ALTER TABLE `tbl_promo` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_promoclass
CREATE TABLE IF NOT EXISTS `tbl_promoclass` (
  `cls_prm_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `cls_id` int(4) NOT NULL DEFAULT '0',
  `prm_id` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cls_prm_id`),
  KEY `cls_id` (`cls_id`),
  KEY `prm_id` (`prm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100000003 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_promoclass: 2 rows
/*!40000 ALTER TABLE `tbl_promoclass` DISABLE KEYS */;
INSERT INTO `tbl_promoclass` (`cls_prm_id`, `cls_id`, `prm_id`) VALUES
	(100000001, 4002, 50001),
	(100000002, 4002, 50004);
/*!40000 ALTER TABLE `tbl_promoclass` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_promomembershiptype
CREATE TABLE IF NOT EXISTS `tbl_promomembershiptype` (
  `met_prm_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `met_id` int(4) unsigned NOT NULL DEFAULT '0',
  `prm_id` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`met_prm_id`),
  KEY `met_id` (`met_id`),
  KEY `prm_id` (`prm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_promomembershiptype: 1 rows
/*!40000 ALTER TABLE `tbl_promomembershiptype` DISABLE KEYS */;
INSERT INTO `tbl_promomembershiptype` (`met_prm_id`, `met_id`, `prm_id`) VALUES
	(1, 3001, 50004);
/*!40000 ALTER TABLE `tbl_promomembershiptype` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_record
CREATE TABLE IF NOT EXISTS `tbl_record` (
  `rec_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rec_session_remain` int(3) NOT NULL DEFAULT '0',
  `rec_enroll` date NOT NULL DEFAULT '0000-00-00',
  `rec_expire` date NOT NULL DEFAULT '0000-00-00',
  `trns_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rec_id`),
  KEY `trns_id` (`trns_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_record: 12 rows
/*!40000 ALTER TABLE `tbl_record` DISABLE KEYS */;
INSERT INTO `tbl_record` (`rec_id`, `rec_session_remain`, `rec_enroll`, `rec_expire`, `trns_id`) VALUES
	(1, 4, '2017-09-25', '2017-10-25', 1),
	(2, 8, '2017-09-25', '2017-10-25', 2),
	(3, 0, '2017-09-25', '2017-10-25', 3),
	(4, 9, '2017-09-26', '2017-10-26', 4),
	(5, 10, '2017-10-03', '2017-11-02', 5),
	(6, 1, '2017-10-03', '2017-11-02', 5),
	(7, 8, '2017-10-05', '2017-11-04', 6),
	(8, 30, '2017-10-05', '2017-11-04', 7),
	(9, 29, '2017-10-06', '2017-11-05', 8),
	(10, 0, '2017-10-06', '2017-11-05', 9),
	(11, 1, '2017-10-06', '2017-11-05', 10),
	(12, 29, '2017-10-06', '2017-11-05', 11);
/*!40000 ALTER TABLE `tbl_record` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_staff
CREATE TABLE IF NOT EXISTS `tbl_staff` (
  `stf_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `stf_email` varchar(150) NOT NULL DEFAULT '',
  `stf_password` varchar(80) NOT NULL DEFAULT '',
  `stf_firstname` varchar(100) NOT NULL DEFAULT '',
  `stf_lastname` varchar(100) NOT NULL DEFAULT '',
  `stf_contact` varchar(50) NOT NULL DEFAULT '',
  `lvl_id` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_staff: 7 rows
/*!40000 ALTER TABLE `tbl_staff` DISABLE KEYS */;
INSERT INTO `tbl_staff` (`stf_id`, `stf_email`, `stf_password`, `stf_firstname`, `stf_lastname`, `stf_contact`, `lvl_id`) VALUES
	(1001, 'rigellago2013@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Rigel', 'Lago', '09426454688', 101),
	(1004, 'trishadominyk@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Trisha', 'Alvarez', '09335604939', 101),
	(1005, 'migan@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Meagan', 'Hofilena', '09335629090', 102),
	(1006, 'adrianhillana@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Adrian', 'Hillana', '09338932474', 103),
	(1007, 'coachmark@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mark', 'Peronce', '09209481921', 103),
	(1008, 'coachjohn@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'John', 'Doe', '09481538959', 103),
	(1009, 'coachjane@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jane', 'Doe', '09243857924', 103);
/*!40000 ALTER TABLE `tbl_staff` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_staffclass
CREATE TABLE IF NOT EXISTS `tbl_staffclass` (
  `stc_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `clc_id` int(3) NOT NULL DEFAULT '0',
  `stf_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stc_id`),
  KEY `cls_id` (`clc_id`),
  KEY `stf_id` (`stf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30010 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_staffclass: 7 rows
/*!40000 ALTER TABLE `tbl_staffclass` DISABLE KEYS */;
INSERT INTO `tbl_staffclass` (`stc_id`, `clc_id`, `stf_id`) VALUES
	(30001, 501, 1006),
	(30005, 502, 1007),
	(30004, 502, 1006),
	(30006, 503, 1008),
	(30007, 501, 1009),
	(30008, 501, 1007),
	(30009, 503, 1006);
/*!40000 ALTER TABLE `tbl_staffclass` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_stafflogbook
CREATE TABLE IF NOT EXISTS `tbl_stafflogbook` (
  `stf_log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `stf_log_date` date NOT NULL DEFAULT '0000-00-00',
  `stf_log_in` time NOT NULL DEFAULT '00:00:00',
  `stf_log_out` time DEFAULT NULL,
  `stf_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stf_log_id`),
  KEY `stf_id` (`stf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_stafflogbook: 2 rows
/*!40000 ALTER TABLE `tbl_stafflogbook` DISABLE KEYS */;
INSERT INTO `tbl_stafflogbook` (`stf_log_id`, `stf_log_date`, `stf_log_in`, `stf_log_out`, `stf_id`) VALUES
	(1, '2017-09-25', '09:50:39', NULL, 1007),
	(2, '2017-10-03', '07:45:08', NULL, 1006);
/*!40000 ALTER TABLE `tbl_stafflogbook` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_transaction
CREATE TABLE IF NOT EXISTS `tbl_transaction` (
  `trns_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trns_code` varchar(12) NOT NULL DEFAULT '',
  `trns_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `trns_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stf_id` int(4) NOT NULL DEFAULT '0',
  `cust_id` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trns_id`),
  KEY `stf_id` (`stf_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_transaction: 15 rows
/*!40000 ALTER TABLE `tbl_transaction` DISABLE KEYS */;
INSERT INTO `tbl_transaction` (`trns_id`, `trns_code`, `trns_date`, `trns_total`, `stf_id`, `cust_id`) VALUES
	(1, '092517-1', '2017-09-25 09:51:08', 1200.00, 1005, 10000000013),
	(2, '092517-2', '2017-09-25 09:53:27', 1500.00, 1005, 2147483647),
	(3, '092517-3', '2017-09-25 11:59:47', 150.00, 1005, 4294967295),
	(4, '092617-1', '2017-09-26 20:34:41', 900.00, 1005, 10000000015),
	(5, '100317-1', '2017-10-03 07:49:42', 1400.00, 1005, 2147483647),
	(6, '100517-1', '2017-10-05 16:48:24', 1000.00, 1005, 10000000008),
	(7, '100517-2', '2017-10-05 20:39:52', 1300.00, 1005, 10000000006),
	(8, '100617-1', '2017-10-06 08:14:51', 1500.00, 1005, 10000000005),
	(9, '100617-2', '2017-10-06 08:16:23', 150.00, 1005, 4294967295),
	(10, '100617-3', '2017-10-06 08:33:39', 100.00, 1005, 10000000009),
	(11, '100617-4', '2017-10-06 13:40:29', 1500.00, 1005, 4294967295),
	(12, '100717-1', '2017-10-07 00:00:00', 300.00, 0, 10000000001),
	(13, '100917-1', '2017-10-09 20:54:43', 0.00, 0, 0),
	(17, '101617-2', '2017-10-16 22:36:05', 200.00, 0, 10000000019),
	(16, '101617-1', '2017-10-16 00:48:49', 200.00, 0, 10000000018);
/*!40000 ALTER TABLE `tbl_transaction` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_transitems
CREATE TABLE IF NOT EXISTS `tbl_transitems` (
  `trni_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `trni_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `trns_id` bigint(20) NOT NULL DEFAULT '0',
  `met_id` int(4) NOT NULL DEFAULT '0',
  `cls_id` int(4) NOT NULL DEFAULT '0',
  `trni_remarks` varchar(50) NOT NULL DEFAULT '',
  `prm_id` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trni_id`),
  KEY `met_id` (`met_id`),
  KEY `cls_id` (`cls_id`),
  KEY `prm_id` (`prm_id`),
  KEY `trns_id` (`trns_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_transitems: 15 rows
/*!40000 ALTER TABLE `tbl_transitems` DISABLE KEYS */;
INSERT INTO `tbl_transitems` (`trni_id`, `trni_amount`, `trns_id`, `met_id`, `cls_id`, `trni_remarks`, `prm_id`) VALUES
	(1, 1200.00, 1, 0, 4002, 'PAID', 0),
	(2, 1500.00, 2, 0, 4009, 'PAID', 0),
	(3, 150.00, 3, 0, 4010, 'PAID', 0),
	(4, 900.00, 4, 0, 4002, 'PAID', 50001),
	(5, 1200.00, 5, 0, 4002, 'PAID', 0),
	(6, 200.00, 5, 0, 4018, 'PAID', 0),
	(7, 1000.00, 6, 0, 4015, 'PAID', 0),
	(8, 1300.00, 7, 0, 4014, 'PAID', 0),
	(9, 1500.00, 8, 0, 4001, 'PAID', 0),
	(10, 150.00, 9, 0, 4010, 'PAID', 0),
	(11, 100.00, 10, 0, 4020, 'PAID', 0),
	(12, 1500.00, 11, 0, 4016, 'PAID', 0),
	(13, 300.00, 12, 3001, 0, 'PAID', 0),
	(17, 200.00, 17, 3002, 0, 'PAID', 0),
	(16, 200.00, 16, 3002, 0, 'PENDING', 0);
/*!40000 ALTER TABLE `tbl_transitems` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_transtemp
CREATE TABLE IF NOT EXISTS `tbl_transtemp` (
  `trtp_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `met_id` int(4) NOT NULL DEFAULT '0',
  `cls_id` int(4) NOT NULL DEFAULT '0',
  `prm_id` int(5) NOT NULL DEFAULT '0',
  `cust_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trtp_id`),
  KEY `met_id` (`met_id`),
  KEY `cls_id` (`cls_id`),
  KEY `prm_id` (`prm_id`),
  KEY `cust_id` (`cust_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_transtemp: 0 rows
/*!40000 ALTER TABLE `tbl_transtemp` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_transtemp` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_workoutact
CREATE TABLE IF NOT EXISTS `tbl_workoutact` (
  `wra_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `wrk_id` int(4) NOT NULL DEFAULT '0',
  `act_id` int(6) NOT NULL DEFAULT '0',
  `wra_sets` int(5) NOT NULL DEFAULT '1',
  `wra_status` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`wra_id`),
  KEY `wrk_id` (`wrk_id`),
  KEY `act_id` (`act_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_workoutact: 50 rows
/*!40000 ALTER TABLE `tbl_workoutact` DISABLE KEYS */;
INSERT INTO `tbl_workoutact` (`wra_id`, `wrk_id`, `act_id`, `wra_sets`, `wra_status`) VALUES
	(1, 2001, 200001, 1, 'ACTIVE'),
	(2, 2001, 200002, 1, 'ACTIVE'),
	(3, 2001, 200003, 3, 'ACTIVE'),
	(4, 2001, 200006, 1, 'ACTIVE'),
	(5, 2001, 200010, 1, 'ACTIVE'),
	(6, 2002, 200010, 1, 'ACTIVE'),
	(7, 2003, 200011, 1, 'ACTIVE'),
	(8, 2003, 200012, 1, 'ACTIVE'),
	(9, 2003, 200001, 1, 'ACTIVE'),
	(10, 2004, 200001, 1, 'ACTIVE'),
	(11, 2003, 200004, 1, 'ACTIVE'),
	(12, 2003, 200015, 1, 'ACTIVE'),
	(13, 2004, 200010, 1, 'ACTIVE'),
	(14, 2004, 200025, 1, 'ACTIVE'),
	(15, 2004, 200003, 1, 'ACTIVE'),
	(16, 2004, 200007, 1, 'ACTIVE'),
	(17, 2005, 200009, 1, 'ACTIVE'),
	(18, 2005, 200005, 5, 'ACTIVE'),
	(19, 2005, 200009, 2, 'ACTIVE'),
	(20, 2005, 200001, 5, 'ACTIVE'),
	(21, 2006, 200001, 2, 'ACTIVE'),
	(22, 2006, 200020, 5, 'ACTIVE'),
	(23, 2006, 200018, 3, 'ACTIVE'),
	(24, 2006, 200006, 3, 'ACTIVE'),
	(25, 2006, 200019, 2, 'ACTIVE'),
	(26, 2006, 200015, 2, 'ACTIVE'),
	(27, 2007, 200004, 3, 'ACTIVE'),
	(28, 2007, 200010, 3, 'ACTIVE'),
	(29, 2007, 200015, 2, 'ACTIVE'),
	(30, 2007, 200001, 5, 'ACTIVE'),
	(31, 2007, 200015, 1, 'ACTIVE'),
	(32, 2008, 200004, 3, 'ACTIVE'),
	(33, 2008, 200009, 2, 'ACTIVE'),
	(34, 2008, 200011, 3, 'ACTIVE'),
	(35, 2008, 200015, 2, 'ACTIVE'),
	(36, 2009, 200007, 3, 'ACTIVE'),
	(37, 2009, 200002, 2, 'ACTIVE'),
	(38, 2009, 200001, 3, 'ACTIVE'),
	(39, 2009, 200015, 5, 'ACTIVE'),
	(40, 2009, 200014, 2, 'ACTIVE'),
	(41, 2010, 200001, 3, 'ACTIVE'),
	(42, 2010, 200005, 3, 'ACTIVE'),
	(43, 2010, 200010, 3, 'ACTIVE'),
	(44, 2010, 200011, 2, 'ACTIVE'),
	(45, 2011, 200012, 2, 'ACTIVE'),
	(46, 2011, 200017, 2, 'ACTIVE'),
	(47, 2001, 200020, 1, 'ACTIVE'),
	(48, 2011, 200025, 3, 'ACTIVE'),
	(49, 2011, 200001, 6, 'ACTIVE'),
	(50, 2013, 200001, 10, 'REMOVED');
/*!40000 ALTER TABLE `tbl_workoutact` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_workoutclass
CREATE TABLE IF NOT EXISTS `tbl_workoutclass` (
  `wrk_cls_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `wrk_id` int(4) NOT NULL DEFAULT '0',
  `clc_id` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wrk_cls_id`),
  KEY `wrk_id` (`wrk_id`),
  KEY `clc_id` (`clc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_workoutclass: 19 rows
/*!40000 ALTER TABLE `tbl_workoutclass` DISABLE KEYS */;
INSERT INTO `tbl_workoutclass` (`wrk_cls_id`, `wrk_id`, `clc_id`) VALUES
	(1, 2001, 502),
	(2, 2001, 501),
	(3, 2002, 501),
	(4, 2003, 502),
	(5, 2004, 501),
	(6, 2004, 502),
	(7, 2005, 501),
	(8, 2006, 502),
	(9, 2007, 502),
	(10, 2008, 502),
	(11, 2009, 501),
	(12, 2009, 502),
	(13, 2010, 501),
	(14, 2010, 502),
	(15, 2010, 503),
	(16, 2011, 501),
	(17, 2011, 502),
	(19, 2013, 501),
	(20, 2013, 503);
/*!40000 ALTER TABLE `tbl_workoutclass` ENABLE KEYS */;

-- Dumping structure for table db_gym.tbl_workoutplan
CREATE TABLE IF NOT EXISTS `tbl_workoutplan` (
  `wrk_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `wrk_name` varchar(150) NOT NULL DEFAULT '',
  `wrk_desc` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`wrk_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2014 DEFAULT CHARSET=latin1;

-- Dumping data for table db_gym.tbl_workoutplan: 12 rows
/*!40000 ALTER TABLE `tbl_workoutplan` DISABLE KEYS */;
INSERT INTO `tbl_workoutplan` (`wrk_id`, `wrk_name`, `wrk_desc`) VALUES
	(2001, 'Beginner\'s Muay Thai Training', 'A routine suitable for those who just newly begun Muay Thai training.'),
	(2002, 'Beginner\'s Boxing Training', 'A routine suitable for those who just newly begun Boxing training.'),
	(2003, 'Level 2 Muay Thai Training Routine', 'Kick it up a notch, this routine is all about further developing your Muay Thai skills beginner level.'),
	(2004, 'Medium Level Boxing Routine', 'Routine for those who aren\'t quite advanced nor casual. Best for those who have taken up Boxing for some time but not serious training.'),
	(2005, 'Casual Boxing Routine', 'Whether you\'re at the gym just to burn off carbs or take it out on the punching bag, this routine is perfect a quick boxing session.'),
	(2006, 'Level 3 Muay Thai Training Routine', 'Kick it up a notch, this routine is all about further developing your Muay Thai skills medium level.'),
	(2007, 'Medium Level Muay Thai Routine', 'Routine for those who aren\'t quite advanced nor casual. Best for those who have taken up Muay Thai for some time but not serious training.'),
	(2008, 'Advanced Muay Thai Training Routine', 'Push yourself to the limits and perfect your Muay Thai skills! Routine best for advanced Muay Thai trainees.'),
	(2009, 'All About Abs Routine', 'This routine is focused on abs. Get ready to work for that six pack.'),
	(2010, 'Cardio Routine', 'Improve your cardio with this routine. You\'ll have better breathing in no time.'),
	(2011, 'Advanced Boxing Training Routine', 'Push yourself to the limits and perfect your Muay Thai skills! Routine best for advanced boxers.'),
	(2013, 'Muscle Gains Workout', 'sample description 1');
/*!40000 ALTER TABLE `tbl_workoutplan` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
