/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : checklist_system_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-04-17 08:27:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attachment_internal_memo
-- ----------------------------
DROP TABLE IF EXISTS `attachment_internal_memo`;
CREATE TABLE `attachment_internal_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `internal_memo_id` int(11) NOT NULL,
  `file` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of attachment_internal_memo
-- ----------------------------
INSERT INTO `attachment_internal_memo` VALUES ('31', '62', 'upload/internal_memo/2017/kantor pusat_2017020262.jpg');

-- ----------------------------
-- Table structure for body_checking
-- ----------------------------
DROP TABLE IF EXISTS `body_checking`;
CREATE TABLE `body_checking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `item_area_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of body_checking
-- ----------------------------
INSERT INTO `body_checking` VALUES ('1', 'Johan', 'IT', '09:00:00', '18:00:00', '123', 'OKE', '4', '30', '48', '2016-10-19 08:33:28');
INSERT INTO `body_checking` VALUES ('2', '', '', '00:00:00', '00:00:00', '', '', '4', '30', '48', '2016-10-20 15:26:39');
INSERT INTO `body_checking` VALUES ('3', '', '', '00:00:00', '00:00:00', '', '', '4', '30', '48', '2016-10-20 16:18:41');
INSERT INTO `body_checking` VALUES ('4', 'ASDF', '', '00:00:00', '00:00:00', '', '', '4', '30', '48', '2016-10-21 09:23:57');
INSERT INTO `body_checking` VALUES ('5', 'asdf', 'asdf', '08:09:00', '17:06:00', '514', '32132', '4', '30', '48', '2016-10-21 16:00:51');

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES ('1', 'Delta Surabaya 1', 'dsby1', null, 'Surabaya', null);
INSERT INTO `branch` VALUES ('2', 'Delta Gading 1', 'dgd1', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('3', 'Delta Gading 2', 'dgd2', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('4', 'Delta Gunung Sahari', 'dgns', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('5', 'Delta Grand Wijaya', 'dgw', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('6', 'Delta Pondok Indah', 'dpi', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('7', 'Delta Gatot Subroto', 'dgs', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('8', 'Delta Bekasi', 'dbks', null, 'Bekasi', null);
INSERT INTO `branch` VALUES ('9', 'Delta Makassar', 'dmks', null, 'Makassar', null);
INSERT INTO `branch` VALUES ('10', 'Delta Kebon Jeruk', 'dbjr', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('11', 'Delta Medan', 'dmdn', null, 'Medan', null);
INSERT INTO `branch` VALUES ('12', 'Delta Harmoni', 'dhrm', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('13', 'Delta Pekanbaru', 'dpkb', null, 'Pekanbaru', null);
INSERT INTO `branch` VALUES ('14', 'Delta Balikpapan', 'dbpp', null, 'Balikpapan', null);
INSERT INTO `branch` VALUES ('15', 'Delta Batam', 'dbtm', null, 'Batam', null);
INSERT INTO `branch` VALUES ('16', 'Delta Dewi Sri Bali', 'dds', null, 'Kuta', null);
INSERT INTO `branch` VALUES ('17', 'Delta BSD', 'dbsb1', null, 'Tangsel', null);
INSERT INTO `branch` VALUES ('18', 'Delta Surabaya 2', 'dsby2', null, 'Surabaya', null);
INSERT INTO `branch` VALUES ('19', 'Delta Kendari', 'dknd', null, 'Kendari', null);
INSERT INTO `branch` VALUES ('20', 'Delta Pontianak', 'dpnt', null, 'Pontianak', null);
INSERT INTO `branch` VALUES ('21', 'Delta BSD 2', 'dbsb1', null, 'Tangsel', null);
INSERT INTO `branch` VALUES ('22', 'Delta Pejaten', 'dpjt', null, 'Jakarta', null);
INSERT INTO `branch` VALUES ('23', 'Kantor Pusat', 'pst', null, 'Jakarta', null);

-- ----------------------------
-- Table structure for checklist_ac
-- ----------------------------
DROP TABLE IF EXISTS `checklist_ac`;
CREATE TABLE `checklist_ac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `ampere_before` varchar(5) DEFAULT NULL,
  `ampere_after` varchar(5) DEFAULT NULL,
  `psi_before` varchar(5) DEFAULT NULL,
  `psi_after` varchar(5) DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `description` text,
  `checked_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of checklist_ac
-- ----------------------------
INSERT INTO `checklist_ac` VALUES ('1', 'ac-0001', '20', '22', '30', '32', '77', '', '2016-10-20 16:23:18');
INSERT INTO `checklist_ac` VALUES ('2', '321', '321', '321', '654', '654', '77', '321654987', '2016-11-21 15:44:28');

-- ----------------------------
-- Table structure for checklist_buffet
-- ----------------------------
DROP TABLE IF EXISTS `checklist_buffet`;
CREATE TABLE `checklist_buffet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checktime_buffet_id` bigint(20) DEFAULT NULL,
  `ready` tinyint(2) DEFAULT NULL,
  `presentasi` tinyint(2) DEFAULT NULL,
  `taste` tinyint(2) DEFAULT NULL,
  `description` text,
  `item_id` bigint(20) DEFAULT NULL,
  `checked_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of checklist_buffet
-- ----------------------------
INSERT INTO `checklist_buffet` VALUES ('13', '1', '1', '1', '1', 'Enak', '431', '2016-10-04 14:39:04');
INSERT INTO `checklist_buffet` VALUES ('14', '1', '1', '1', '1', 'ssss', '431', '2016-10-04 14:42:37');
INSERT INTO `checklist_buffet` VALUES ('15', '2', '1', '1', '1', 'Enak', '431', '2016-10-04 14:42:49');
INSERT INTO `checklist_buffet` VALUES ('16', '3', '0', '0', '0', 'Kosong', '431', '2016-10-04 14:43:00');
INSERT INTO `checklist_buffet` VALUES ('17', '1', '1', '1', '1', 'okoe', '446', '2016-10-04 15:37:41');
INSERT INTO `checklist_buffet` VALUES ('18', '1', '1', '1', '1', 'Testing', '444', '2016-10-04 16:57:08');
INSERT INTO `checklist_buffet` VALUES ('19', '1', '1', '1', '0', 'Enak', '431', '2016-10-05 11:23:43');
INSERT INTO `checklist_buffet` VALUES ('20', '1', '1', '1', '1', 'Enak', '431', '2016-10-06 13:19:36');
INSERT INTO `checklist_buffet` VALUES ('21', '1', '1', '1', '1', 'dadadadfffff', '431', '2016-11-28 11:27:21');
INSERT INTO `checklist_buffet` VALUES ('22', '2', '1', '1', '1', 'okokok', '431', '2016-11-28 11:28:02');

-- ----------------------------
-- Table structure for checklist_buffet_wasteges
-- ----------------------------
DROP TABLE IF EXISTS `checklist_buffet_wasteges`;
CREATE TABLE `checklist_buffet_wasteges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_wasteges_id` bigint(20) DEFAULT NULL,
  `description` text,
  `branch_id` bigint(20) DEFAULT NULL,
  `comment` text,
  `user_id` bigint(20) DEFAULT NULL,
  `checked_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of checklist_buffet_wasteges
-- ----------------------------
INSERT INTO `checklist_buffet_wasteges` VALUES ('2', '1', null, '2', 'Test Comment', '46', '2016-10-04 17:58:29');
INSERT INTO `checklist_buffet_wasteges` VALUES ('3', '2', 'Okeoko', '2', 'Test', '46', '2016-10-04 18:01:10');
INSERT INTO `checklist_buffet_wasteges` VALUES ('4', '7', 'Description', '2', 'Comment', '46', '2016-10-05 11:04:57');
INSERT INTO `checklist_buffet_wasteges` VALUES ('5', '1', 'des', '2', 'com', '46', '2016-10-05 11:08:07');
INSERT INTO `checklist_buffet_wasteges` VALUES ('6', '1', 'Oke', '2', 'Komentar', '46', '2016-10-06 10:38:52');
INSERT INTO `checklist_buffet_wasteges` VALUES ('7', '2', '', '4', '', '48', '2016-10-19 04:15:46');
INSERT INTO `checklist_buffet_wasteges` VALUES ('8', '1', 'Test', '2', 'ddada', '46', '2016-11-28 11:27:11');

-- ----------------------------
-- Table structure for checklist_me_fas
-- ----------------------------
DROP TABLE IF EXISTS `checklist_me_fas`;
CREATE TABLE `checklist_me_fas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `check_hour_id` bigint(50) DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `description` varchar(10) DEFAULT NULL,
  `ph` varchar(10) DEFAULT NULL,
  `cl` varchar(10) DEFAULT NULL,
  `checked_at` datetime DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of checklist_me_fas
-- ----------------------------
INSERT INTO `checklist_me_fas` VALUES ('1', '1', '307', '321', null, null, '2016-11-21 18:50:56', '48', '2', '4', null);
INSERT INTO `checklist_me_fas` VALUES ('2', '8', '322', 'jernih', '321', '654987', '2016-11-21 18:51:36', '48', '2', '4', null);
INSERT INTO `checklist_me_fas` VALUES ('3', '1', '307', '11', null, null, '2016-11-22 16:18:14', '48', '2', '4', null);
INSERT INTO `checklist_me_fas` VALUES ('4', '2', '307', 'asd', null, null, '2016-11-22 16:23:22', '48', '2', '4', null);

-- ----------------------------
-- Table structure for checktime_buffet
-- ----------------------------
DROP TABLE IF EXISTS `checktime_buffet`;
CREATE TABLE `checktime_buffet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of checktime_buffet
-- ----------------------------
INSERT INTO `checktime_buffet` VALUES ('1', 'Control 1', '12.00 - 15.00');
INSERT INTO `checktime_buffet` VALUES ('2', 'Control 2', '15.00 - 18.00');
INSERT INTO `checktime_buffet` VALUES ('3', 'Control 3', '18.00 - 21.00');
INSERT INTO `checktime_buffet` VALUES ('4', 'Control 4', '21.00 - 23.00');

-- ----------------------------
-- Table structure for check_hour
-- ----------------------------
DROP TABLE IF EXISTS `check_hour`;
CREATE TABLE `check_hour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of check_hour
-- ----------------------------
INSERT INTO `check_hour` VALUES ('1', '11.00');
INSERT INTO `check_hour` VALUES ('2', '12.00');
INSERT INTO `check_hour` VALUES ('3', '14.00');
INSERT INTO `check_hour` VALUES ('4', '16.00');
INSERT INTO `check_hour` VALUES ('5', '18.00');
INSERT INTO `check_hour` VALUES ('6', '20.00');
INSERT INTO `check_hour` VALUES ('7', '22.00');
INSERT INTO `check_hour` VALUES ('8', '23.00');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_checklist_id` bigint(20) DEFAULT NULL,
  `users_id` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '11', '46', '2016-10-05 11:19:24', 'ok');
INSERT INTO `comments` VALUES ('2', '12', '46', '2016-10-05 12:12:08', 'oke');
INSERT INTO `comments` VALUES ('3', '13', '46', '2016-10-06 12:01:21', 'test');
INSERT INTO `comments` VALUES ('4', '18', '46', '2016-10-12 12:45:39', 'Test');
INSERT INTO `comments` VALUES ('5', '18', '4', '2016-10-12 12:48:23', 'Mohon di cek kembali');
INSERT INTO `comments` VALUES ('6', '22', '48', '2016-10-18 10:14:45', '132\n\n123');
INSERT INTO `comments` VALUES ('7', '27', '48', '2016-10-18 11:41:55', 'asdf\n');
INSERT INTO `comments` VALUES ('8', '27', '48', '2016-10-18 11:42:08', 'ewr');
INSERT INTO `comments` VALUES ('9', '27', '48', '2016-10-18 11:42:47', 'adscw');
INSERT INTO `comments` VALUES ('10', '26', '48', '2016-10-18 11:51:10', 'rere');
INSERT INTO `comments` VALUES ('11', '23', '48', '2016-10-18 11:57:15', '4212');

-- ----------------------------
-- Table structure for divisi
-- ----------------------------
DROP TABLE IF EXISTS `divisi`;
CREATE TABLE `divisi` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of divisi
-- ----------------------------
INSERT INTO `divisi` VALUES ('1', 'it', 'IT');
INSERT INTO `divisi` VALUES ('2', 'me', 'ME');
INSERT INTO `divisi` VALUES ('3', 'hk', 'House Keeping');
INSERT INTO `divisi` VALUES ('4', 'fb', 'F&B');
INSERT INTO `divisi` VALUES ('5', 'sc', 'Security');

-- ----------------------------
-- Table structure for hour_meter_genset
-- ----------------------------
DROP TABLE IF EXISTS `hour_meter_genset`;
CREATE TABLE `hour_meter_genset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_hour` date DEFAULT NULL,
  `start_hour_meter` varchar(100) DEFAULT NULL,
  `after_hour_meter` varchar(100) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `item_area_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of hour_meter_genset
-- ----------------------------
INSERT INTO `hour_meter_genset` VALUES ('1', '1970-01-01', '', '', '4', '14', '48', '2016-10-18 08:07:46');
INSERT INTO `hour_meter_genset` VALUES ('2', '2016-10-25', '600', '502', '4', '14', '48', '2016-10-18 08:16:08');
INSERT INTO `hour_meter_genset` VALUES ('3', '2016-10-27', 'sdfg', 'sdfg', '4', '14', '48', '2016-10-18 08:57:14');
INSERT INTO `hour_meter_genset` VALUES ('4', '2016-11-01', '456', '123', '4', '14', '48', '2016-11-21 16:39:13');
INSERT INTO `hour_meter_genset` VALUES ('5', '2016-11-01', '456', '123', '4', '14', '48', '2016-11-21 16:40:06');

-- ----------------------------
-- Table structure for internal_memo
-- ----------------------------
DROP TABLE IF EXISTS `internal_memo`;
CREATE TABLE `internal_memo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `divisi_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of internal_memo
-- ----------------------------
INSERT INTO `internal_memo` VALUES ('62', 'Internal Memo baru', 'Description Here', '46', '0', '2017-02-02 15:50:11');

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT NULL,
  `item_code` varchar(15) DEFAULT NULL,
  `item_description` varchar(180) DEFAULT NULL,
  `item_area_id` bigint(11) DEFAULT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=463 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', 'Komputer Server', 'KS', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('2', 'Monitor Server', 'MS', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('3', 'System Server', 'SS', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('4', 'Keyboard + Mouse', 'KM', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('5', 'UPS / Stabilizer', 'UP', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('6', 'Modem Internet', 'MI', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('7', 'Telephone Telkom', 'TK', '', '1', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('8', 'Komputer Kasir', 'KS', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('9', 'Monitor Kasir', 'MK', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('10', 'System Kasir', 'SS', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('11', 'Komputer Member', 'KM', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('12', 'System Member', 'SM', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('13', 'Printer Kasir', 'PK', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('14', 'Printer Member', 'PM', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('15', 'Alat Scan Finger', 'ACF', '', '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('16', 'Komputer Bar Pool', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('17', 'Monitor Bar Pool', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('18', 'System Bar Pool', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('19', 'Printer Bar Pool', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('20', 'UPS / Stabilizer', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('21', 'Telephone Ext', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('22', 'LCD Promo 29/42 Inch', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('23', 'Keyboard + Mouse', '', '', '3', '1', '1', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('40', 'Telephone Telkom', 'TK', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('41', 'Modem Internet', 'MI', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('42', 'UPS / Stabilizer', 'UP', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('43', 'Keyboard + Mouse', 'KM', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('44', 'System Server', 'SS', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('45', 'Monitor Server', 'MS', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('46', 'Komputer Server', 'KS', '', '4', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('49', 'Monitor Bar Pool', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('50', 'System Bar Pool', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('51', 'Printer Bar Pool', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('52', 'UPS / Stabilizer', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('53', 'Telephone Ext', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('54', 'LCD Promo 29/42 Inch', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('55', 'Keyboard + Mouse', '', '', '6', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('57', 'Komputer Kasir', 'KS', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('58', 'Monitor Kasir', 'MK', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('59', 'System Kasir', 'SS', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('60', 'Komputer Member', 'KM', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('61', 'System Member', 'SM', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('62', 'Printer Kasir', 'PK', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('63', 'Printer Member', 'PM', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('64', 'Alat Scan Finger', 'ACF', '', '5', '1', '2', '2016-09-09 16:18:50', '2016-09-09 16:18:50');
INSERT INTO `item` VALUES ('65', 'Kebersihan & Kerapihan Area Locker', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('66', 'Ruang Ganti & Cermin', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('67', 'Kelengkapan Locker', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('68', 'Linen', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('69', 'Guest Amenities', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('70', 'Dressing Table', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('71', 'AC', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('72', 'Lampu/Penerangan', '', '', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('73', 'Pompa Pengisian Torn Air Panas (2 Bar - 3,8 Bar)', 'pptap', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('74', 'Pompa Pengisian Torn Air Dingin (2 Bar-3,8 Bar)', 'pptad', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('75', 'Pompa Sirkulasi Air Panas (2 Bar - 3,8 Bar)', 'psap', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('76', 'Panel Induk/MDP', 'mdp', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('77', 'Office', 'office', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('78', 'Ruang Server', 'svr', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('79', 'Kebersihan & Kerapihan Area Room', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('80', 'Display Room Message', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('81', 'Equipment Treatment', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('82', 'Guest Amenities', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('83', 'Panel Kapasitor Bank', 'pkb', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('84', 'Panel AMF/Genset', 'pag', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('85', 'Panel Pompa Transfer', 'ppt', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('86', 'Panel Pompa Dorong', 'ppd', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('87', 'Panel PP Lantai 1', 'pp1', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('88', 'Panel PP Lantai 2', 'pp2', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('89', 'Panel PP Lantai 3', 'pp3', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('90', 'Panel PP Lantai 4', 'pp4', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('91', 'Panel AC Lantai 1', 'pac1', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('92', 'Panel AC Lantai 2', 'pac2', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('93', 'Panel AC Lantai 3', 'pac3', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('94', 'Panel AC Lantai 4', null, null, '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('95', 'Lobby', 'lobby', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('96', 'Kasir', 'kasir', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('97', 'Locker', 'locker', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('98', 'Cafe', 'cafe', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('99', 'Ruang Mesin (Outdoor Chiller)', 'rmc', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('100', 'Bar', 'bar', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('101', 'Gudang', 'gd', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('102', 'Coridor Room Messagae', 'crm', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('103', 'Counter Handuk', 'ch', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('104', 'Ruang Tunggu Therapist', 'rth', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('105', 'Mess', 'mess', '', '13', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('106', 'Linen', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('107', 'Sanitary Room dan Kelengkapannya', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('108', 'Toilet Tamu dan Kelengkapannya', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('109', 'Washtafel', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('110', 'AC', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('111', 'Exhaaust Fan', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('112', 'Lampu / Penerangan', '', '', '8', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('113', 'Kebersihan & Kerapihan Area Counter', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('114', 'Linen', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('115', 'Product Treatment', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('116', 'Equipment Treatment', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('117', 'Guest Amenities', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('118', 'Peralatan Kerja', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('119', 'AC/Kipas Angin', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('120', 'Lampu/Penerangan', '', '', '9', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('121', 'Kebersihan & Kerapihan Area Laundry', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('122', 'Linen', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('123', 'Mesin Cuci', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('124', 'Detergent', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('125', 'Setrika', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('126', 'Kran Air & Drainage', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('127', 'Lampu/Penerangan', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('128', 'Toilet Karyawan', '', '', '10', '3', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('129', 'Pompa Sirkulasi Air Dingin (2 Bar-3,8 bar)', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('130', 'Tangki Tekan (2 Bar-3,8 Bar)', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('131', 'Valve Return/Selenoid Air Panas', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('132', 'Valve Return/Selenoid Air Dingin', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('133', 'Heater Rinnai', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('134', 'Heater Hayward', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('135', 'Valve - valve Header Vichy Shower', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('136', 'Nozel Header Vichy Shower', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('137', 'Panel Room', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('138', 'Panel Control Vichy Shower', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('139', 'Tekanan Air Panas Panas  Vichy Shower Room', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('140', 'Tekanan Air Panas Dingin Vichy Shower Room', '', '', '11', '2', '1', '2016-09-30 14:36:58', '2016-09-30 14:36:58');
INSERT INTO `item` VALUES ('141', 'Pemeriksaan level oil', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('142', 'Pergantian Oli', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('143', 'Pembersihan Oli Filter', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('144', 'Pembersihan Filter Solar', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('145', 'Pergantian Filter Solar', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('146', 'Pemeriksaan Radiator / Air Radiator', null, null, '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('147', 'Periksaan kecukupan bahan Bakar / Solar', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('148', 'Pemeriksaan Kondisi Accu', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('149', 'Pemeriksaan kabel-kabel Instrument', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('150', 'Pengecekan Kebersihan Genset & Area Genset', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('151', 'Test Running Genset', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('152', 'Test Beban Genset', '', '', '14', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('153', 'Office', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('154', 'Lobby', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('155', 'Kasir', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('156', 'Locker', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('157', 'Fasilitas', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('158', 'Toliet (All Toilet)', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('159', 'Cafe', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('160', 'Kitchen', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('161', 'Bar', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('162', 'Gudang', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('163', 'Room Message', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('164', 'Counter Handuk', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('165', 'Ruang Mesin', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('166', 'Ruang T. Therapist', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('167', 'Mess Therapist', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('168', 'Ruang Genset', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('169', 'Ruang Pompa', '', '', '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('170', 'Ruang Panel', null, null, '15', '2', '1', '2016-09-30 14:47:54', '2016-09-30 14:47:54');
INSERT INTO `item` VALUES ('307', 'Suhu Ruang Steam (47<sup>o</sup>C - 49<sup>o</sup>C)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('308', 'Suhu Ruang Sauna (97<sup>o</sup>C - 99<sup>o</sup>C)', '', '', '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('309', 'Suhu Kolam Panas (39<sup>o</sup>C - 41<sup>o</sup>C)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('310', 'Suhu Kolam Dingin (10<sup>o</sup>C - 8<sup>o</sup>C)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('311', 'Cuci Air Filter Kolam Panas', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('312', 'Cuci Air Filter kolam Dingin', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('313', 'Persediaan LPG', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('314', 'Mesin Heater \"Hayward\"', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('315', 'Mesin Rinai/Rheem', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('316', 'Rinnai/Rheem 1', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('317', 'Rinnai/Rheem 2', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('318', 'Rinnai/Rheem 3', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('319', 'Rinnai/Rheem 4', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('320', 'Rinnai/Rheem 5', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('321', 'Rinnai/Rheem 6', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('322', 'Air Kolam Panas (7,2-7,6) (1,0-1,5)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('323', 'Air Kolam Dingin (7,2-7,6) (1,0-1,5)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('324', 'Air Kolam Renang (7,2-7,6) (1,0-1,5)', null, null, '16', '2', '1', null, null);
INSERT INTO `item` VALUES ('325', 'Monitor Guest Comment', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('326', 'UPS / Stabilizer', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('327', 'Master Telephone Ext', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('328', 'Mesin Marchent 1', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('329', 'Mesin Marchent 2', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('330', 'Mesin Marchent 3', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('331', 'LCD Promo 29/32/42/ Inchi', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('332', 'Keyboard + Mouse', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('333', 'Komputer Operator', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('334', 'Monitor Operator', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('335', 'System Operator', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('336', 'UPS / Stabilizer', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('337', 'IP Phone Room', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('338', 'Telephone Ext', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('339', 'Keyboard + Mouse', null, null, '17', '1', '1', '2016-09-09 15:18:52', null);
INSERT INTO `item` VALUES ('340', 'Komputer TV Coin', '', '', '18', '1', '1', '2016-09-09 16:03:48', null);
INSERT INTO `item` VALUES ('341', 'LCD 29/32/42/ Inchi', '', '', '18', '1', '1', '2016-09-09 16:03:48', null);
INSERT INTO `item` VALUES ('342', 'System TV Coin', '', '', '18', '1', '1', '2016-09-09 16:03:48', null);
INSERT INTO `item` VALUES ('343', 'UPS / Stabilizer', '', '', '18', '1', '1', '2016-09-09 16:03:48', null);
INSERT INTO `item` VALUES ('344', 'Keyboard + Mouse', '', '', '18', '1', '1', '2016-09-09 16:03:48', null);
INSERT INTO `item` VALUES ('345', 'UPS / Stabilizer', '', '', '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('346', 'Komputer GRO', '', '', '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('347', 'Monitor GRO', '', '', '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('348', 'System GRO', '', '', '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('349', 'Telephone Ext', '', '', '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('350', 'Keyboard', null, null, '19', '1', '1', '2016-09-09 16:22:53', null);
INSERT INTO `item` VALUES ('351', 'UPS / Stabilizer', '', '', '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('352', 'Komputer Waiter', '', '', '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('353', 'Monitor Waiter', '', '', '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('354', 'System Waiter', '', '', '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('355', 'Telephone Ext', '', '', '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('356', 'Keyboard + Mouse', null, null, '20', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('357', 'Telephone Ext', '', '', '21', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('358', 'Printer Kitchen', '', '', '21', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('361', 'Printer Bar cafe', '', '', '21', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('362', 'LCD Promo 29/32/42', '', '', '21', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('363', 'UPS / Stabilizer', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('364', 'Komputer Manager', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('365', 'Monitor Manager', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('366', 'System Manager', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('367', 'Printer Manager', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('368', 'Telephone Ext', '', '', '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('369', 'Keyboard + Mouse', null, null, '22', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('370', 'Komputer ADM', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('371', 'Monitor ADM', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('372', 'System ADM', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('373', 'Komputer Gudang', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('374', 'Monitor Gudang', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('375', 'System Gudang', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('376', 'UPS / Stabilizer', '', '', '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('377', 'Telephone Ext', null, null, '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('378', 'Keyboard + Mouse', null, null, '23', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('379', 'Komputer CCTV', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('380', 'Monitor CCTV', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('381', 'System CCTV', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('382', 'Keyboard', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('383', 'Camera CCTV', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('384', 'UPS / Stabilizer', '', '', '24', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('385', 'Hub Switch 8/16/24/32', '', '', '25', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('386', 'Koneksi Internet', '', '', '25', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('387', 'Wifi / Hotspot', '', '', '25', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('388', 'Penguat Signal Semua Area', '', '', '25', '1', '1', '2016-09-09 16:23:07', null);
INSERT INTO `item` VALUES ('389', 'Telephone Ext', null, null, '2', '1', '1', '2016-09-09 15:14:00', '2016-09-09 15:14:00');
INSERT INTO `item` VALUES ('390', 'Panel Telfon', 'pac4', '', '12', '2', '1', '2016-09-30 14:41:53', '2016-09-30 14:41:53');
INSERT INTO `item` VALUES ('391', 'Kebersihan dan Kerapihan Area Bar ( Floor & Display )', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('392', 'Kelengkapan Peralatan Kerja', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('393', 'Kelengkapan glass Ware', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('394', 'Sistem FiFo', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('395', 'Fungsi Show Case', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('396', 'Penerangan', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('397', 'Show Case', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('398', 'Bar Counter', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('399', 'Bar Stools', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('400', 'Menu', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('401', 'Sink', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('402', 'Loog Book', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('403', 'Grooming Staff', '', '', '26', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('404', 'Kebersihan dan Kerapihan Area Bar ( Floor & Display )', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('405', 'Kelengkapan Peralatan Kerja', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('406', 'Kelengkapan glass Ware', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('407', 'Sistem FiFo', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('408', 'Fungsi Show Case', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('409', 'Penerangan', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('410', 'Show Case', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('411', 'Computer', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('412', 'CPU', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('413', 'Bar Counter', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('414', 'Bar Stools', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('415', 'Menu', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('416', 'Tent Card', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('417', 'Sink', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('418', 'Loog Book', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('419', 'Grooming Staff', '', '', '27', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('420', 'Kebersihan dan Kerapihan Area Bar ( Floor & Display )', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('421', 'Kelengkapan Peralatan Kerja', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('422', 'Kelengkapan glass Ware', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('423', 'Sistem FiFo', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('424', 'Fungsi Show Case', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('425', 'Fungsi Frezzer', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('426', 'Penerangan', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('427', 'Menu', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('428', 'Sink', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('429', 'Loog Book', '', '', '28', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('430', 'Grooming Staff', '', '', '28', '4', '1', '2016-10-03 14:42:53', null);
INSERT INTO `item` VALUES ('431', 'Asinan Buah', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('432', 'HOT Starter / Snack Mini', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('433', 'Soto Bandung', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('434', 'Bubur Ayam', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('435', 'Salad Bar', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('436', 'Nasi Goreng Butter', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('437', 'Nasi Putih', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('438', 'Ayam Goreng Mentega', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('439', 'Dory Goreng Tepung Saos Mangga', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('440', 'Tumis Kailan Sauce Garlic', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('441', 'Spaghety Spacy Sauce Concasse', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('442', 'Chips / Crackers', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('443', 'Pudding', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('444', 'Kacang Hijau', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('445', 'Cake', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('446', 'Buah-buahan', '', '', '29', '4', '1', '2016-10-03 17:48:31', null);
INSERT INTO `item` VALUES ('447', 'Pengecekan Lampu Penerangan', 'plp', null, '36', '5', '1', '2016-10-18 11:08:00', '2016-10-18 11:08:00');
INSERT INTO `item` VALUES ('448', 'Pengecekan AC', 'pac', null, '36', '5', '1', '2016-10-18 11:11:00', '2016-10-18 11:11:00');
INSERT INTO `item` VALUES ('449', 'Alat Yang Berhubungan Dengan Listrik', 'abl', null, '36', '5', '1', '2016-10-18 11:11:00', '2016-10-18 11:11:00');
INSERT INTO `item` VALUES ('450', 'Alat Yang Berhubungan Dengan Air', 'aba', null, '36', '5', '1', '2016-10-18 11:12:00', '2016-10-18 11:12:00');
INSERT INTO `item` VALUES ('451', 'Alat Yang Berhubungan Dengan Gas', 'abg', null, '36', '5', '1', '2016-10-18 11:13:00', '2016-10-18 11:13:00');
INSERT INTO `item` VALUES ('452', 'Pintu Utama', 'pu', null, '36', '5', '1', '2016-10-18 11:13:00', '2016-10-18 11:13:00');
INSERT INTO `item` VALUES ('453', 'Seluruh Pintu di Outlet Lt 1 s/d 5', 'spo', null, '36', '5', '1', '2016-10-18 11:13:00', '2016-10-18 11:13:00');
INSERT INTO `item` VALUES ('454', 'Exaust Fan', ' ', ' ', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('455', 'Towel', ' ', ' ', '7', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('456', 'Exaust Fan', null, null, '8', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('457', 'Towel', null, null, '8', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('458', 'Exaust Fan', null, null, '9', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('459', 'Towel', null, null, '9', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('460', 'Exaust Fan', null, null, '10', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('461', 'Towel', null, null, '10', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');
INSERT INTO `item` VALUES ('462', 'Mesin Pengering', null, null, '10', '3', '1', '2016-09-30 14:35:56', '2016-09-30 14:35:56');

-- ----------------------------
-- Table structure for item_area
-- ----------------------------
DROP TABLE IF EXISTS `item_area`;
CREATE TABLE `item_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_area
-- ----------------------------
INSERT INTO `item_area` VALUES ('1', 'Server', '1', '1');
INSERT INTO `item_area` VALUES ('2', 'Kasir', '1', '1');
INSERT INTO `item_area` VALUES ('3', 'Bar Pool', '1', '1');
INSERT INTO `item_area` VALUES ('4', 'Server', '2', '1');
INSERT INTO `item_area` VALUES ('5', 'Kasir', '2', '1');
INSERT INTO `item_area` VALUES ('6', 'Bar Pool', '2', '1');
INSERT INTO `item_area` VALUES ('7', 'sub. seksi loker', '1', '3');
INSERT INTO `item_area` VALUES ('8', 'sub. seksi room', '1', '3');
INSERT INTO `item_area` VALUES ('9', 'sub. seksi counter handuk', '1', '3');
INSERT INTO `item_area` VALUES ('10', 'sub. seksi laundry', '1', '3');
INSERT INTO `item_area` VALUES ('11', 'Vichy Shower (Harian)', '1', '2');
INSERT INTO `item_area` VALUES ('12', 'Panel (Bulanan)', '1', '2');
INSERT INTO `item_area` VALUES ('13', 'Service AC', '1', '2');
INSERT INTO `item_area` VALUES ('14', 'Genset (Mingguan)', '1', '2');
INSERT INTO `item_area` VALUES ('15', 'Pelaksanaan Pest Control (Mingguan)', '1', '2');
INSERT INTO `item_area` VALUES ('16', 'Fasilitas', '1', '2');
INSERT INTO `item_area` VALUES ('17', 'Operator', '1', '1');
INSERT INTO `item_area` VALUES ('18', 'TV Coin Theraphist', '1', '1');
INSERT INTO `item_area` VALUES ('19', 'GRO', '1', '1');
INSERT INTO `item_area` VALUES ('20', 'Waiter', '1', '1');
INSERT INTO `item_area` VALUES ('21', 'Bar Cafe & Kitchen', '1', '1');
INSERT INTO `item_area` VALUES ('22', 'Manager', '1', '1');
INSERT INTO `item_area` VALUES ('23', 'ADM & Gudang', '1', '1');
INSERT INTO `item_area` VALUES ('24', 'CCTV', '1', '1');
INSERT INTO `item_area` VALUES ('25', 'Lain-Lain', '1', '1');
INSERT INTO `item_area` VALUES ('26', 'Bar Cafe', '1', '4');
INSERT INTO `item_area` VALUES ('27', 'Bar Pool', '1', '4');
INSERT INTO `item_area` VALUES ('28', 'Pantry Kitchen', '1', '4');
INSERT INTO `item_area` VALUES ('29', 'Buffet', '1', '4');
INSERT INTO `item_area` VALUES ('30', 'Body Checking', '1', '5');
INSERT INTO `item_area` VALUES ('34', 'Kendaraan', '1', '5');
INSERT INTO `item_area` VALUES ('35', 'Laporan Situasi', '1', '5');
INSERT INTO `item_area` VALUES ('36', 'Kegiatan Security (Harian)', '1', '5');

-- ----------------------------
-- Table structure for item_checklist
-- ----------------------------
DROP TABLE IF EXISTS `item_checklist`;
CREATE TABLE `item_checklist` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) DEFAULT NULL,
  `item_status_id` bigint(20) DEFAULT NULL,
  `item_kondisi_id` bigint(20) DEFAULT NULL,
  `item_fungsi_id` bigint(20) DEFAULT NULL,
  `checked_at` datetime DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `description` text,
  `status_approve` enum('0','1') DEFAULT '0',
  `user_approve` bigint(20) DEFAULT NULL,
  `time_approve` timestamp NULL DEFAULT NULL,
  `pressure` varchar(10) DEFAULT NULL,
  `ampere_before` varchar(50) DEFAULT NULL,
  `psi_before` varchar(50) DEFAULT NULL,
  `ampere_after` varchar(50) DEFAULT NULL,
  `psi_after` varchar(50) DEFAULT NULL,
  `total_unit` varchar(50) DEFAULT NULL,
  `tegangan_r` varchar(10) DEFAULT NULL,
  `tegangan_s` varchar(10) DEFAULT NULL,
  `tegangan_t` varchar(10) DEFAULT NULL,
  `arus_r` varchar(10) DEFAULT NULL,
  `arus_s` varchar(10) DEFAULT NULL,
  `arus_t` varchar(10) DEFAULT NULL,
  `koneksi` tinyint(4) DEFAULT NULL,
  `wiring` tinyint(4) DEFAULT NULL,
  `spraying` tinyint(4) DEFAULT NULL,
  `batting` tinyint(4) DEFAULT NULL,
  `dusting` tinyint(4) DEFAULT NULL,
  `controling` tinyint(4) DEFAULT NULL,
  `fas_11` varchar(10) DEFAULT NULL,
  `fas_12` varchar(10) DEFAULT NULL,
  `fas_14` varchar(10) DEFAULT NULL,
  `fas_16` varchar(10) DEFAULT NULL,
  `fas_18` varchar(10) DEFAULT NULL,
  `fas_20` varchar(10) DEFAULT NULL,
  `fas_22` varchar(10) DEFAULT NULL,
  `fas_23` varchar(10) DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT NULL,
  `ampr` varchar(10) DEFAULT NULL,
  `volt` varchar(10) DEFAULT NULL,
  `bc_opening_status` int(1) NOT NULL,
  `bc_opening_keterangan` varchar(100) NOT NULL,
  `bc_closing_status` int(1) NOT NULL,
  `bc_closing_keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_checklist
-- ----------------------------
INSERT INTO `item_checklist` VALUES ('1', '431', null, null, null, '2016-10-04 13:12:59', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('3', '432', null, null, null, '2016-10-04 13:41:42', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('4', '433', null, null, null, '2016-10-04 13:44:03', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('5', '434', null, null, null, '2016-10-04 13:47:28', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('6', '435', null, null, null, '2016-10-04 13:54:33', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('7', '446', null, null, null, '2016-10-04 15:37:41', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('8', '391', '3', '1', '1', '2016-10-04 15:50:43', '46', '4', '2', 'Bagus', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('9', '444', null, null, null, '2016-10-04 16:57:08', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('11', '391', '3', '1', '1', '2016-10-05 11:10:51', '46', '4', '2', 'okok', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('12', '431', null, null, null, '2016-10-05 11:23:43', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('13', '391', '3', '1', '1', '2016-10-06 10:38:10', '46', '4', '2', 'Oke', '1', '46', '2016-10-06 12:01:37', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('14', '431', null, null, null, '2016-10-06 13:19:36', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('15', '153', null, null, null, '2016-10-06 18:42:35', '46', '2', '2', '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('16', '2', '2', null, null, '2016-10-12 12:34:12', '46', '1', '2', '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('17', '391', '3', '1', '1', '2016-10-12 12:43:50', '46', '4', '2', 'Bagus', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('18', '65', '3', null, '1', '2016-10-12 12:44:20', '46', '3', '2', 'Oke', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('19', '65', '3', '1', '1', '2016-10-17 11:00:17', '46', '3', '2', '', '1', '46', '2016-10-17 17:13:04', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('20', '73', '3', null, '1', '2016-10-17 11:20:23', '46', '2', '2', 'Oke', '1', '46', '2016-10-17 11:20:55', '3', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('21', '1', '2', null, null, '2016-10-17 18:42:42', '46', '1', '2', 'test', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('22', '73', '3', null, '1', '2016-10-18 10:14:01', '48', '2', '4', 'OKE', '1', '48', '2016-10-18 10:14:30', 'test press', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('23', '447', null, null, null, '2016-10-18 07:39:00', '48', '2', '4', '', '1', '48', '2016-10-18 10:10:32', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('24', '74', '4', null, '1', '2016-10-18 07:51:15', '48', '2', '4', 'ewrf', '0', null, null, 'rew', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('25', '448', null, null, null, '2016-10-18 07:51:29', '48', '2', '4', 'ewrf', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('26', '453', null, null, null, '2016-10-18 11:20:28', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('27', '452', null, null, null, '2016-10-18 11:23:22', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'on', '1', 'off');
INSERT INTO `item_checklist` VALUES ('28', '73', null, null, null, '2016-10-19 04:13:42', '48', '2', '4', '', '0', null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('29', '76', '3', null, '1', '2016-10-19 04:13:51', '48', '2', '4', '', '0', null, null, null, null, null, null, null, null, '', '', '', '', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('30', '132', null, null, null, '2016-10-19 04:13:59', '48', '2', '4', '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('31', '154', null, null, null, '2016-10-19 04:14:43', '48', '2', '4', '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', '1', '1', '1', null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('32', '65', null, null, null, '2016-10-19 04:15:06', '48', '3', '4', '', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('35', '447', null, null, null, '2016-10-19 13:49:43', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'nyala', '1', 'mati');
INSERT INTO `item_checklist` VALUES ('36', '73', null, null, null, '2016-10-20 16:20:12', '48', '2', '4', '', '0', null, null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('37', '77', null, null, null, '2016-10-20 16:23:18', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('38', '73', '3', null, '2', '2016-10-21 15:40:36', '48', '2', '4', 'ewrtert', '0', null, null, 'ewrt', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('39', '76', '3', null, '1', '2016-10-21 15:41:12', '48', '2', '4', 'rdgd', '0', null, null, null, null, null, null, null, null, '56', '', '5', '51', '51', '321', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('40', '87', '3', null, '1', '2016-10-21 16:01:44', '48', '2', '4', '', '0', null, null, null, null, null, null, null, null, '', '', '', '', '', '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('41', '65', '3', '1', '1', '2016-11-14 16:28:47', '46', '3', '2', 'Ok', '1', '46', '2016-11-14 16:31:03', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('42', '447', null, null, null, '2016-11-15 11:10:14', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke1', '1', 'oke1');
INSERT INTO `item_checklist` VALUES ('43', '448', null, null, null, '2016-11-15 11:10:23', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke2', '1', 'oke2');
INSERT INTO `item_checklist` VALUES ('44', '449', null, null, null, '2016-11-15 11:10:31', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke3', '1', 'oke3');
INSERT INTO `item_checklist` VALUES ('45', '450', null, null, null, '2016-11-15 11:10:40', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke4', '1', 'oke4');
INSERT INTO `item_checklist` VALUES ('46', '451', null, null, null, '2016-11-15 11:10:51', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke5', '1', 'oke5');
INSERT INTO `item_checklist` VALUES ('47', '452', null, null, null, '2016-11-15 11:11:00', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke6', '1', 'oke6');
INSERT INTO `item_checklist` VALUES ('48', '453', null, null, null, '2016-11-15 11:11:08', '48', '5', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', 'oke7', '1', 'oke7');
INSERT INTO `item_checklist` VALUES ('49', '131', '3', null, '1', '2016-11-15 16:08:51', '46', '2', '2', 'ok', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('50', '133', '3', null, '1', '2016-11-15 16:34:54', '46', '2', '2', 'fsfss', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('51', '76', '3', null, '1', '2016-11-16 11:59:14', '48', '2', '4', 'OKE', '1', '48', '2016-11-16 12:21:08', null, null, null, null, null, null, '10', '20', '30', '40', '50', '60', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('52', '83', '3', null, '1', '2016-11-16 12:16:31', '48', '2', '4', 'RUSAK', '0', null, null, null, null, null, null, null, null, '100', '90', '80', '70', '60', '50', null, '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('53', '84', '3', null, '1', '2016-11-16 12:19:20', '46', '2', '2', 'OKOK', '0', null, null, null, null, null, null, null, null, '20', '25', '30', '30', '35', '40', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('55', '65', '3', '1', '1', '2016-11-16 17:44:49', '48', '3', '4', 'asd', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('56', '76', '3', null, '1', '2016-11-16 18:00:59', '46', '2', '2', 'ssa', '0', null, null, null, null, null, null, null, null, '23', '24', '26', '54', '54', '6', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('57', '73', '3', null, '1', '2016-11-21 11:25:55', '48', '2', '4', 'oke', '0', null, null, 'test', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('58', '76', '3', null, '1', '2016-11-21 11:26:11', '48', '2', '4', 'ok', '0', null, null, null, null, null, null, null, null, '10', '20', '30', '40', '50', '60', '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('59', '77', null, null, null, '2016-11-21 15:44:28', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('60', '141', null, null, null, '2016-11-21 16:48:14', '48', '2', '4', 'test', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('61', '150', null, null, null, '2016-11-21 18:38:49', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '32165', '64987', '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('62', '307', null, null, null, '2016-11-21 18:50:56', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('63', '322', null, null, null, '2016-11-21 18:51:36', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('64', '307', null, null, null, '2016-11-22 16:18:14', '48', '2', '4', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('65', '391', '3', '1', '1', '2016-11-23 17:06:30', '48', '4', '4', 'kebersihan dan kerapihan area bar (floor dan display) bersih lengkap baik', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('66', '431', null, null, null, '2016-11-28 11:27:21', '46', '4', '2', null, '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('67', '420', '3', '1', '1', '2016-11-28 11:28:38', '46', '4', '2', 'cczzxzzc', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('68', '421', '3', '1', '1', '2016-11-28 11:29:23', '46', '4', '2', 'zczcz', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');
INSERT INTO `item_checklist` VALUES ('69', '73', '3', null, '1', '2017-02-03 15:46:44', '46', '2', '0', 'sadad', '0', null, null, 'sasa', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '', '0', '');

-- ----------------------------
-- Table structure for item_fungsi
-- ----------------------------
DROP TABLE IF EXISTS `item_fungsi`;
CREATE TABLE `item_fungsi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_fungsi
-- ----------------------------
INSERT INTO `item_fungsi` VALUES ('1', 'baik');
INSERT INTO `item_fungsi` VALUES ('2', 'rusak');

-- ----------------------------
-- Table structure for item_image
-- ----------------------------
DROP TABLE IF EXISTS `item_image`;
CREATE TABLE `item_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_source` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `control` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_image
-- ----------------------------
INSERT INTO `item_image` VALUES ('1', '/upload/delta gading 1/me/2016/september/20160920321.jpg', '2', '321', null, '2016-09-20 12:30:52');
INSERT INTO `item_image` VALUES ('2', '/upload/delta gading 1/me/2016/september/20160920322.png', '2', '322', null, '2016-09-20 15:59:59');
INSERT INTO `item_image` VALUES ('3', '/upload/delta gading 1/me/2016/september/2016092076.jpg', '2', '76', null, '2016-09-20 17:18:18');
INSERT INTO `item_image` VALUES ('4', '/upload/delta gading 1/me/2016/september/20160921141.jpg', '2', '141', null, '2016-09-21 12:26:03');
INSERT INTO `item_image` VALUES ('5', '/upload/delta gading 1/me/2016/september/2016092177.jpg', '2', '77', null, '2016-09-21 14:36:47');
INSERT INTO `item_image` VALUES ('6', '/upload/delta gading 1/me/2016/september/20160927130.jpg', '2', '130', null, '2016-09-27 19:02:02');
INSERT INTO `item_image` VALUES ('7', '/upload/delta gading 1/f&b/2016/oktober/20161004431.jpg', '2', '431', null, '2016-10-04 14:45:16');
INSERT INTO `item_image` VALUES ('8', '/upload/delta gading 1/f&b/2016/oktober/20161004446.jpg', '2', '446', '1', '2016-10-04 15:37:55');
INSERT INTO `item_image` VALUES ('9', '/upload/delta gading 1/f&b/2016/oktober/20161004391.jpg', '2', '391', null, '2016-10-04 15:51:01');
INSERT INTO `item_image` VALUES ('10', '/upload/delta gading 1/f&b/2016/oktober/20161005391.jpg', '2', '391', null, '2016-10-05 11:10:46');
INSERT INTO `item_image` VALUES ('11', '/upload/delta gading 1/f&b/2016/oktober/20161006391.jpg', '2', '391', null, '2016-10-06 10:38:21');
INSERT INTO `item_image` VALUES ('12', '/upload/delta gading 1/it/2016/oktober/201610122.jpg', '2', '2', null, '2016-10-12 12:34:08');
INSERT INTO `item_image` VALUES ('13', '/upload/delta gading 1/f&b/2016/oktober/20161012391.jpg', '2', '391', null, '2016-10-12 12:43:45');
INSERT INTO `item_image` VALUES ('14', '/upload/delta gading 1/house keeping/2016/oktober/2016101265.png', '2', '65', null, '2016-10-12 12:44:16');
INSERT INTO `item_image` VALUES ('15', '/upload/delta gading 1/house keeping/2016/oktober/2016101765.png', '2', '65', null, '2016-10-17 11:01:33');
INSERT INTO `item_image` VALUES ('16', '/upload/delta gading 1/me/2016/oktober/2016101773.jpg', '2', '73', null, '2016-10-17 16:36:09');
INSERT INTO `item_image` VALUES ('17', '/upload/delta gading 1/me/2016/oktober/2016101773.jpg', '2', '73', null, '2016-10-17 16:36:09');
INSERT INTO `item_image` VALUES ('18', '/upload/delta gading 1/me/2016/oktober/2016101773.jpg', '2', '73', null, '2016-10-17 16:36:09');
INSERT INTO `item_image` VALUES ('19', '/upload/delta gading 1/me/2016/oktober/2016101773.jpg', '2', '73', null, '2016-10-17 16:36:09');
INSERT INTO `item_image` VALUES ('20', '/upload/delta gunung sahari/me/2016/november/2016111676.jpg', '4', '76', null, '2016-11-16 15:51:46');
INSERT INTO `item_image` VALUES ('21', '/upload/delta gunung sahari/house keeping/2016/november/2016111665.jpg', '4', '65', null, '2016-11-16 17:44:20');
INSERT INTO `item_image` VALUES ('22', '/upload/delta gunung sahari/house keeping/2016/november/2016111665.jpg', '4', '65', null, '2016-11-16 17:44:20');
INSERT INTO `item_image` VALUES ('23', '/upload/delta gading 1/me/2016/november/2016111676.jpg', '2', '76', null, '2016-11-16 17:45:01');
INSERT INTO `item_image` VALUES ('24', '/upload/delta gading 1/me/2016/november/2016111676.jpg', '2', '76', null, '2016-11-16 18:04:14');
INSERT INTO `item_image` VALUES ('25', '/upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 15:48:05');
INSERT INTO `item_image` VALUES ('26', 'upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 15:54:37');
INSERT INTO `item_image` VALUES ('27', 'upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 16:00:24');
INSERT INTO `item_image` VALUES ('28', 'upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 16:13:50');
INSERT INTO `item_image` VALUES ('29', 'upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 16:15:06');
INSERT INTO `item_image` VALUES ('30', 'upload/kantor pusat/it/2017/februari/201702031.jpg', '0', '1', null, '2017-02-03 16:18:18');

-- ----------------------------
-- Table structure for item_kondisi
-- ----------------------------
DROP TABLE IF EXISTS `item_kondisi`;
CREATE TABLE `item_kondisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_kondisi
-- ----------------------------
INSERT INTO `item_kondisi` VALUES ('1', 'lengkap');
INSERT INTO `item_kondisi` VALUES ('2', 'tidak lengkap');

-- ----------------------------
-- Table structure for item_status
-- ----------------------------
DROP TABLE IF EXISTS `item_status`;
CREATE TABLE `item_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  `group_status` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_status
-- ----------------------------
INSERT INTO `item_status` VALUES ('1', 'Bagus', '1', '1');
INSERT INTO `item_status` VALUES ('2', 'Rusak', '1', '1');
INSERT INTO `item_status` VALUES ('3', 'bersih', '3', '2');
INSERT INTO `item_status` VALUES ('4', 'kotor', '3', '2');
INSERT INTO `item_status` VALUES ('5', 'lengkap', '3', '2');
INSERT INTO `item_status` VALUES ('6', 'tidak lengkap', '3', '2');
INSERT INTO `item_status` VALUES ('7', 'baik', '3', '3');
INSERT INTO `item_status` VALUES ('8', 'rusak', '3', '3');

-- ----------------------------
-- Table structure for item_wasteges
-- ----------------------------
DROP TABLE IF EXISTS `item_wasteges`;
CREATE TABLE `item_wasteges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_wasteges
-- ----------------------------
INSERT INTO `item_wasteges` VALUES ('1', 'Soto Bandung');
INSERT INTO `item_wasteges` VALUES ('2', 'Nasi Goreng Butter');
INSERT INTO `item_wasteges` VALUES ('3', 'Nasi Putih');
INSERT INTO `item_wasteges` VALUES ('4', 'Ayam Goreng Mentega');
INSERT INTO `item_wasteges` VALUES ('5', 'Dory Goreng Tepung Saos Mangga');
INSERT INTO `item_wasteges` VALUES ('6', 'Tumis Kailan Sauce Garlic');
INSERT INTO `item_wasteges` VALUES ('7', 'Spaghety Spacy Sauce Concasse');

-- ----------------------------
-- Table structure for kegiatan_security
-- ----------------------------
DROP TABLE IF EXISTS `kegiatan_security`;
CREATE TABLE `kegiatan_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ambil_jam` time NOT NULL,
  `ambil_oleh` varchar(30) NOT NULL,
  `ambil_saksi1` varchar(30) NOT NULL,
  `ambil_saksi2` varchar(30) NOT NULL,
  `simpan_jam` time NOT NULL,
  `simpan_oleh` varchar(30) NOT NULL,
  `simpan_saksi1` varchar(30) NOT NULL,
  `simpan_saksi2` varchar(30) NOT NULL,
  `laporan_situasi1` varchar(100) NOT NULL,
  `laporan_situasi2` varchar(100) NOT NULL,
  `laporan_situasi3` varchar(100) NOT NULL,
  `laporan_situasi4` varchar(100) NOT NULL,
  `laporan_situasi5` varchar(100) NOT NULL,
  `laporan_situasi6` varchar(100) NOT NULL,
  `laporan_situasi7` varchar(100) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `item_area_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kegiatan_security
-- ----------------------------

-- ----------------------------
-- Table structure for request
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noreq` varchar(17) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `unit` varchar(20) NOT NULL,
  `kebutuhan` int(11) NOT NULL,
  `saldo_gudang` int(11) NOT NULL,
  `purchase_request` varchar(20) NOT NULL,
  `remark` text,
  `due_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `status` enum('Assigned','On Process','Done','Cancel') NOT NULL DEFAULT 'Assigned',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `nopobtb` varchar(255) DEFAULT NULL,
  `pobtb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request
-- ----------------------------
INSERT INTO `request` VALUES ('35', 'IRSDSBY117020001', 'Penggantian CPU Baru1 ', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:39:52', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('36', 'IRSDSBY117020002', 'Penggantian CPU Baru 2', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:39:58', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('37', 'IRSDSBY117020003', 'Penggantian CPU Baru 3', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:40:01', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('38', 'IRSDSBY117020004', 'Penggantian CPU Baru 4', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:40:04', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('39', 'IRSDSBY117020005', 'Penggantian CPU Baru 5', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:40:08', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('40', 'IRSDSBY117020006', 'Penggantian CPU Baru 6', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:40:10', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('41', 'IRSDSBY117020007', 'Penggantian CPU Baru 7', 'Paket', '1', '0', '0', 'Cpu nya minta ganti baru', '2017-02-13 10:40:13', '1', '1', '56', 'On Process', '2017-02-10 10:26:34', 'upload/delta surabaya 1/request/veng_pro_red_hero_b_5_1.png', 'upload/delta surabaya 1/request/Logo_PuriGroup.png', null, null);
INSERT INTO `request` VALUES ('42', 'IRSDSBY1170320008', 'Permintaan AC', 'Pcs', '500', '100', '400', 'Description Here....', '2017-03-08 00:00:00', '1', '2', '56', 'Assigned', '2017-03-03 13:37:21', 'upload/delta surabaya 1/request/GALAXY-Tab3-10-inci-GT-P5200-1024x682.jpg', null, null, null);
INSERT INTO `request` VALUES ('43', 'IRSDSBY1170320009', 'Permintaan Kompor', 'Pcs', '25', '5', '20', 'Blablabla....', '2017-03-03 15:35:08', '1', '1', '2', 'Done', '2017-03-03 15:21:43', 'upload/delta surabaya 1/request/lenovo-tablet-yoga-10-hd-plus-tilt-mode-6.jpg', 'upload/delta surabaya 1/request/', null, null);

-- ----------------------------
-- Table structure for request_approval
-- ----------------------------
DROP TABLE IF EXISTS `request_approval`;
CREATE TABLE `request_approval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `status` enum('Approve','Reject','Pending') DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request_approval
-- ----------------------------
INSERT INTO `request_approval` VALUES ('180', '21', '52', 'Approve', 'ok', '2017-02-08 17:41:51');
INSERT INTO `request_approval` VALUES ('181', '21', '55', 'Approve', 'OKe Lanjutkan', '2017-02-08 17:43:11');
INSERT INTO `request_approval` VALUES ('182', '21', '54', 'Approve', 'sfsfsf', '2017-02-08 17:49:09');
INSERT INTO `request_approval` VALUES ('183', '35', '2', 'Approve', 'Oke', '2017-02-10 10:27:26');
INSERT INTO `request_approval` VALUES ('184', '35', '52', 'Approve', 'Okokok', '2017-02-10 10:27:55');
INSERT INTO `request_approval` VALUES ('187', '35', '55', 'Approve', 'okok', '2017-02-10 10:36:40');
INSERT INTO `request_approval` VALUES ('188', '35', '54', 'Approve', 'fdgdfdf', '2017-02-10 10:37:21');
INSERT INTO `request_approval` VALUES ('189', '43', '2', 'Approve', 'Oke. Saya Setuju', '2017-03-03 15:26:52');
INSERT INTO `request_approval` VALUES ('190', '43', '52', 'Approve', 'oke\n', '2017-03-03 15:29:07');
INSERT INTO `request_approval` VALUES ('191', '43', '55', 'Approve', 'Sip', '2017-03-03 15:30:30');
INSERT INTO `request_approval` VALUES ('192', '43', '54', 'Approve', 'Ok', '2017-03-03 15:31:37');
INSERT INTO `request_approval` VALUES ('193', '43', '54', 'Approve', 'Ok', '2017-03-03 15:31:37');

-- ----------------------------
-- Table structure for request_image
-- ----------------------------
DROP TABLE IF EXISTS `request_image`;
CREATE TABLE `request_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `image_source` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request_image
-- ----------------------------
INSERT INTO `request_image` VALUES ('1', '4', '161125161233Jellyfish.jpg');
INSERT INTO `request_image` VALUES ('2', '4', '161125161233Tulips.jpg');
INSERT INTO `request_image` VALUES ('3', '5', '2016111665.jpg');
INSERT INTO `request_image` VALUES ('5', '6', '2016111665.jpg');

-- ----------------------------
-- Table structure for request_message
-- ----------------------------
DROP TABLE IF EXISTS `request_message`;
CREATE TABLE `request_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` bigint(20) DEFAULT NULL,
  `users_id` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request_message
-- ----------------------------

-- ----------------------------
-- Table structure for request_received
-- ----------------------------
DROP TABLE IF EXISTS `request_received`;
CREATE TABLE `request_received` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `btb_number` varchar(30) DEFAULT NULL,
  `date_received` datetime DEFAULT NULL,
  `description` text,
  `sent_by` varchar(255) DEFAULT NULL,
  `no_supplier` varchar(255) DEFAULT NULL,
  `no_kendara` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of request_received
-- ----------------------------
INSERT INTO `request_received` VALUES ('127', '21', '56', 'BTBDSBY117020001', '2017-02-08 00:00:00', 'Okokook', null, null, null, '2017-02-08 17:50:12');
INSERT INTO `request_received` VALUES ('128', '43', '56', 'BTBDSBY1170320002', '2017-03-01 00:00:00', 'blabla', null, null, null, '2017-03-03 15:35:08');

-- ----------------------------
-- Table structure for sc_kendaraan
-- ----------------------------
DROP TABLE IF EXISTS `sc_kendaraan`;
CREATE TABLE `sc_kendaraan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `roda_kendaraan` int(1) NOT NULL,
  `merk_kendaraan` varchar(50) NOT NULL,
  `warna_kendaraan` varchar(20) NOT NULL,
  `nopol_kendaraan` varchar(20) NOT NULL,
  `kaca_samping` varchar(50) NOT NULL,
  `kaca_depan` varchar(50) NOT NULL,
  `kaca_belakang` varchar(50) NOT NULL,
  `lampu_samping` varchar(50) NOT NULL,
  `lampu_depan` varchar(50) NOT NULL,
  `lampu_belakang` varchar(50) NOT NULL,
  `pintu_samping` varchar(50) NOT NULL,
  `pintu_depan` varchar(50) NOT NULL,
  `pintu_belakang` varchar(50) NOT NULL,
  `bagasi` varchar(50) NOT NULL,
  `body` varchar(50) NOT NULL,
  `bumper_depan` varchar(50) NOT NULL,
  `bumper_belakang` varchar(50) NOT NULL,
  `ban_dop` varchar(50) NOT NULL,
  `ban_depan` varchar(50) NOT NULL,
  `ban_belakang` varchar(50) NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `item_area_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sc_kendaraan
-- ----------------------------
INSERT INTO `sc_kendaraan` VALUES ('7', '08:00:00', '17:00:00', '4', 'Honda Revo', 'Hitam', 'B 3401 BFG', '', '', '', '', 'agak redup', 'oke', '', '', '', '', 'bagian kanan agak rusak', '', '', '', 'oke', 'oke', 'oke', '4', '34', '48', '2016-10-21 10:22:54');

-- ----------------------------
-- Table structure for sc_laporan_situasi
-- ----------------------------
DROP TABLE IF EXISTS `sc_laporan_situasi`;
CREATE TABLE `sc_laporan_situasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keadaan` varchar(100) NOT NULL,
  `pagi_jumlah` int(3) NOT NULL,
  `pagi_hadir` int(3) NOT NULL,
  `pagi_tidak_hadir` int(3) NOT NULL,
  `pagi_backup` int(3) NOT NULL,
  `pagi_nama1` varchar(50) NOT NULL,
  `pagi_nama2` varchar(50) NOT NULL,
  `pagi_nama3` varchar(50) NOT NULL,
  `pagi_nama4` varchar(50) NOT NULL,
  `pagi_nama5` varchar(50) NOT NULL,
  `pagi_keterangan1` int(1) NOT NULL,
  `pagi_keterangan2` int(1) NOT NULL,
  `pagi_keterangan3` int(1) NOT NULL,
  `pagi_keterangan4` int(1) NOT NULL,
  `pagi_keterangan5` int(1) NOT NULL,
  `siang_jumlah` int(3) NOT NULL,
  `siang_hadir` int(3) NOT NULL,
  `siang_tidak_hadir` int(3) NOT NULL,
  `siang_backup` int(3) NOT NULL,
  `siang_nama1` varchar(50) NOT NULL,
  `siang_nama2` varchar(50) NOT NULL,
  `siang_nama3` varchar(50) NOT NULL,
  `siang_nama4` varchar(50) NOT NULL,
  `siang_nama5` varchar(50) NOT NULL,
  `siang_keterangan1` int(1) NOT NULL,
  `siang_keterangan2` int(1) NOT NULL,
  `siang_keterangan3` int(1) NOT NULL,
  `siang_keterangan4` int(1) NOT NULL,
  `siang_keterangan5` int(1) NOT NULL,
  `malam_jumlah` int(3) NOT NULL,
  `malam_hadir` int(3) NOT NULL,
  `malam_tidak_hadir` int(3) NOT NULL,
  `malam_backup` int(3) NOT NULL,
  `malam_nama1` varchar(50) NOT NULL,
  `malam_nama2` varchar(50) NOT NULL,
  `malam_nama3` varchar(50) NOT NULL,
  `malam_nama4` varchar(50) NOT NULL,
  `malam_nama5` varchar(50) NOT NULL,
  `malam_keterangan1` int(1) NOT NULL,
  `malam_keterangan2` int(1) NOT NULL,
  `malam_keterangan3` int(1) NOT NULL,
  `malam_keterangan4` int(1) NOT NULL,
  `malam_keterangan5` int(1) NOT NULL,
  `lembur_jumlah` int(3) NOT NULL,
  `lembur_keterangan` varchar(300) NOT NULL,
  `materiil_kondisi1` varchar(200) NOT NULL,
  `materiil_kondisi2` varchar(200) NOT NULL,
  `materiil_kondisi3` varchar(200) NOT NULL,
  `materiil_kondisi4` varchar(200) NOT NULL,
  `materiil_kondisi5` varchar(200) NOT NULL,
  `materiil_keterangan` varchar(300) NOT NULL,
  `aktivitas1` varchar(200) NOT NULL,
  `aktivitas2` varchar(200) NOT NULL,
  `aktivitas3` varchar(200) NOT NULL,
  `aktivitas4` varchar(200) NOT NULL,
  `aktivitas5` varchar(200) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `item_area_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sc_laporan_situasi
-- ----------------------------
INSERT INTO `sc_laporan_situasi` VALUES ('7', 'ret', '0', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '4', '35', '48', '2016-10-21 14:29:35');
INSERT INTO `sc_laporan_situasi` VALUES ('9', 'Aman', '5', '0', '0', '0', 'Dede', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '2', '35', '46', '2016-11-14 16:38:59');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_type` enum('administrator','manager','leader','operator','manager pengganti','freez','manager divisi','purchasing','staff adm','direksi','markom','kasir') DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `divisi_id` bigint(20) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_start` date DEFAULT NULL,
  `active_end` date DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'ian', 'Ian', 'Nasution', '0192023a7bbd73250516f069df18b500', 'ian@purigroup.com', 'manager', '2', '0', '085710011524', '1', '2016-08-16 17:18:11', '2016-09-14 10:56:38', '2017-04-17', '2017-04-23', '2016-09-27 20:13:29');
INSERT INTO `users` VALUES ('2', 'manager', 'Manager', 'Budi', '1d0258c2440a8d19e716292b231e3190', 'manager@manager.com', 'manager', '1', '0', '', '1', '2016-08-16 17:21:38', '2017-03-03 15:24:31', '2017-03-03', '2017-03-09', '2017-03-03 15:24:43');
INSERT INTO `users` VALUES ('3', 'staff', 'Staff', 'IT', 'de9bf5643eabf80f4a56fda3bbb84483', 'staffit@gmail.com', 'operator', '1', '1', '0878785225', '1', '2016-08-15 18:18:55', '2016-08-15 18:18:55', '2016-08-31', '2016-09-06', '2016-08-31 11:27:00');
INSERT INTO `users` VALUES ('4', 'managerjkt', 'Martono', 'Gading 1', '1d0258c2440a8d19e716292b231e3190', 'manager@manager.com', 'manager', '2', '0', '', '1', '2016-08-15 14:07:38', '2016-11-02 17:28:55', '2016-11-02', '2016-11-08', '2016-10-12 12:47:48');
INSERT INTO `users` VALUES ('8', 'userhk', 'House', 'Keeping', '307dd33a0509cf87498084485de7cf08', 'house@keeping.com', 'operator', '2', '3', '0878785225', '1', '2016-08-15 14:07:40', null, '2016-12-01', '2016-12-07', '2016-09-13 19:42:21');
INSERT INTO `users` VALUES ('9', 'userme', 'Userme', 'Userme', '96aa87a962aeb70235b6db6aa2e94336', 'userme@me.com', 'operator', '2', '2', '0878785225', '1', '2016-08-10 16:32:05', '2016-10-17 11:18:51', '2016-10-17', '2016-10-23', '2016-10-17 11:18:59');
INSERT INTO `users` VALUES ('11', 'manager2', 'Manager', 'Cadangan', 'd41d8cd98f00b204e9800998ecf8427e', 'manager@manager.com', 'manager pengganti', '0', '0', '', '0', '2016-08-24 10:53:10', null, '2016-09-14', '2016-09-17', '2016-08-24 17:46:33');
INSERT INTO `users` VALUES ('34', 'manager3', 'Manajer', 'Pengganti 3', 'd41d8cd98f00b204e9800998ecf8427e', 'manager3@manager.com', 'freez', '1', '0', '0878785225', '1', '2016-08-29 13:58:11', '2016-08-29 13:58:11', '2016-09-05', '2016-09-11', null);
INSERT INTO `users` VALUES ('35', 'deltagading1', 'Manager Gading 1', '', 'd412165b902610444f531d8d88c4be40', '', 'manager', '2', '0', '081219991411 ', '1', '2016-09-05 14:19:11', '2016-09-14 10:59:33', '2017-01-25', '2017-01-31', '2016-12-15 14:31:18');
INSERT INTO `users` VALUES ('36', 'bagus', 'Bagus', '', '17b38fc02fd7e92f3edeb6318e3066d8', '', 'operator', '2', '3', '', '1', '2016-09-05 14:20:23', '2016-09-14 18:04:19', '2016-12-13', '2016-12-19', '2016-09-14 18:04:27');
INSERT INTO `users` VALUES ('37', 'topan', 'Topan', 'Ajj', '2b165d92e828c00b5b83f9dc3eb7cc20', 'topan@topan.com', 'operator', '2', '1', '', '1', '2016-09-05 14:21:40', null, '2016-09-05', '2016-09-11', '2016-09-05 15:11:11');
INSERT INTO `users` VALUES ('38', 'arif', 'Arif', '', '0ff6c3ace16359e41e37d40b8301d67f', '', 'operator', '2', '1', '', '1', '2016-09-05 14:22:18', '2016-09-14 11:00:45', '2016-09-14', '2016-09-20', '2016-09-14 11:38:07');
INSERT INTO `users` VALUES ('39', 'deden', 'Deden', '', 'd4e044830cfc2124c4c20a2d4e656bc2', '', 'operator', '2', '0', '', '1', '2016-09-05 14:22:55', null, '2016-09-05', '2016-09-11', null);
INSERT INTO `users` VALUES ('40', 'dadang', 'Dadang', 'Ajj', '0037bb978d51e84d1ad5478e85430f26', 'dadang2016@gmail.com', 'operator', '2', '2', '', '1', '2016-09-14 14:10:34', null, '2016-09-21', '2016-09-27', '2016-09-21 19:38:47');
INSERT INTO `users` VALUES ('41', 'pram', 'Pramuda', '', '328b6047c62d4de24eb547db647094df', '', 'manager', '6', '0', '', '1', '2016-09-15 18:19:20', '2016-09-27 13:06:48', '2016-09-27', '2016-10-03', '2016-09-27 13:08:34');
INSERT INTO `users` VALUES ('42', 'iros', 'Iros', '', 'fabdc95e591a97188ace64744f1dd6fe', '', 'operator', '6', '3', '', '1', '2016-09-19 10:46:28', '2016-09-27 13:06:28', '2016-09-27', '2016-10-03', null);
INSERT INTO `users` VALUES ('43', 'akur', 'Akur', '', '63bcb1eec657c8ad2e1a0f15710d2125', '', 'operator', '6', '3', '', '1', '2016-09-19 10:47:18', '2016-09-27 13:06:35', '2016-09-27', '2016-10-03', null);
INSERT INTO `users` VALUES ('44', 'ryan', 'Ryan', '', '10c7ccc7a4f0aff03c915c485565b9da', '', 'operator', '6', '2', '', '1', '2016-09-19 10:48:19', '2016-09-27 13:06:58', '2016-09-27', '2016-10-03', null);
INSERT INTO `users` VALUES ('45', 'nanan', 'Nanan', '', '1897a0d46ccbe02284117a400b6c8bd4', '', 'operator', '6', '2', '', '1', '2016-09-19 10:48:50', '2016-11-02 17:29:35', '2016-11-02', '2016-11-08', '2016-09-27 21:46:39');
INSERT INTO `users` VALUES ('46', 'admin', 'Admin', 'Checklist', '293184ea2f5cb24c7b44c228ffc4e73b', 'deryrosandy@gmail.com', 'administrator', '0', '0', '085710011524', '1', '2016-09-27 17:18:11', '2016-11-18 00:00:00', '2017-04-17', '2017-04-23', '2017-04-17 07:36:55');
INSERT INTO `users` VALUES ('47', 'staff', 'Staff', 'Operator', '098f6bcd4621d373cade4e832627b4f6', '', 'operator', '2', '2', '', '1', '2016-09-28 13:17:19', '2016-09-28 15:08:14', '2016-09-29', '2016-10-05', '2016-09-28 15:09:39');
INSERT INTO `users` VALUES ('52', 'chandra', 'Chandra', '', 'ad845a24a47deecbfa8396e90db75c6a', '', 'manager divisi', '0', '0', '', '1', '2016-11-08 12:12:53', '2017-01-25 11:10:28', '2017-03-03', '2017-03-09', '2017-03-03 15:28:11');
INSERT INTO `users` VALUES ('54', 'purchasing', 'Puchasing', null, '74ba4e8291e8b2e40a31a50505f8b72e', null, 'purchasing', '0', '0', null, '1', '2016-09-27 17:18:11', '2016-11-18 00:00:00', '2017-03-03', '2017-03-09', '2017-03-03 15:30:49');
INSERT INTO `users` VALUES ('55', 'dirut', 'Dirut', null, '69e4ded79578b26fd56874f078d9a90b', null, 'direksi', '0', '0', null, '1', '2016-09-27 17:18:11', '2016-11-18 00:00:00', '2017-03-03', '2017-03-09', '2017-03-03 15:30:07');
INSERT INTO `users` VALUES ('56', 'staffadm', 'Staff Adm', 'ADM', 'd743e97ffa813d73fca950c05b9f3bee', '', 'staff adm', '1', '0', '', '1', '2016-09-27 17:18:11', '2017-01-25 11:02:03', '2017-03-03', '2017-03-09', '2017-03-03 15:31:48');
INSERT INTO `users` VALUES ('57', 'markom', 'Marketing', 'Komunikasi', '3eb1ab4690fc1bf384b5bf9c26a7ec94', 'markom@email.com', 'markom', '0', '0', '', '1', '2017-04-17 05:52:30', null, '2017-04-17', '2017-04-23', '2017-04-17 05:52:50');
INSERT INTO `users` VALUES ('58', 'operator', 'Operator', null, '3eb1ab4690fc1bf384b5bf9c26a7ec94', 'operator@operator', 'operator', '1', '0', null, '1', '2017-04-17 05:52:30', null, null, null, null);
INSERT INTO `users` VALUES ('59', 'kasir', 'Kasir', 'Gading 1', 'c7911af3adbd12a035b289556d96470a', 'kasir@email.com', 'kasir', '1', '0', '', '1', '2017-04-17 07:23:41', null, '2017-04-17', '2017-04-23', '2017-04-17 07:38:08');

-- ----------------------------
-- Table structure for voucher
-- ----------------------------
DROP TABLE IF EXISTS `voucher`;
CREATE TABLE `voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `voucher_category_id` bigint(20) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `active_date` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of voucher
-- ----------------------------
INSERT INTO `voucher` VALUES ('1', 'BR689980909', 'VCR000001', '0', '1', '500000', '2017-04-17', '2017-05-31', '1', '2017-04-17 07:02:26', '57');

-- ----------------------------
-- Table structure for voucher_category
-- ----------------------------
DROP TABLE IF EXISTS `voucher_category`;
CREATE TABLE `voucher_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of voucher_category
-- ----------------------------
INSERT INTO `voucher_category` VALUES ('1', 'Reguler', 'Voucher Reguler');
