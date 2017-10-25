/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : projects_db

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-08-31 11:32:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES ('1', 'Surabaya 1', null, 'Surabaya', null);
INSERT INTO `branch` VALUES ('2', 'Kelapa Gading 1', null, 'Jakarta', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '2', '10', '2016-08-12 16:53:43', 'Oke Terima gaji');
INSERT INTO `comments` VALUES ('3', '3', '10', '2016-08-12 19:14:46', 'Test...!!');
INSERT INTO `comments` VALUES ('4', '3', '10', '2016-08-12 19:15:46', 'Test Lagi');
INSERT INTO `comments` VALUES ('5', '2', '10', '2016-08-12 19:16:12', 'Test');
INSERT INTO `comments` VALUES ('6', '9', '10', '2016-08-12 19:17:02', 'Oke');
INSERT INTO `comments` VALUES ('7', '41', '10', '2016-08-15 12:46:54', 'Siapp..');

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
INSERT INTO `divisi` VALUES ('4', 'fb', 'FB');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of hour_meter_genset
-- ----------------------------
INSERT INTO `hour_meter_genset` VALUES ('1', '2016-08-30', '300', '320', '1', '73', '9', '2016-08-30 16:50:55');
INSERT INTO `hour_meter_genset` VALUES ('2', '2016-08-30', '300', '320', '1', '73', '9', '2016-08-30 16:51:29');
INSERT INTO `hour_meter_genset` VALUES ('3', '2016-08-30', '200', '220', '1', '73', '9', '2016-08-30 16:52:29');
INSERT INTO `hour_meter_genset` VALUES ('4', '2016-08-30', '320', '350', '1', '73', '9', '2016-08-30 16:52:54');
INSERT INTO `hour_meter_genset` VALUES ('5', '2016-08-31', '300', '358', '1', '73', '9', '2016-08-30 16:53:30');
INSERT INTO `hour_meter_genset` VALUES ('7', '2016-08-31', '300', '320', '1', '73', '9', '2016-08-31 10:40:30');

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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', 'Komputer Server', 'KS', null, '1', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('2', 'Monitor Server', 'MS', '', '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('3', 'System Server', 'SS', '', '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('4', 'Keyboard + Mouse', 'KM', '', '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('5', 'UPS / Stabilizer', 'UP', '', '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('6', 'Modem Internet', 'MI', '', '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('7', 'Telephone Telkom', 'TK', null, '1', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('8', 'Komputer Kasir', 'KS', null, '2', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('9', 'Monitor Kasir', 'MK', null, '2', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('10', 'System Kasir', 'SS', null, '2', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('11', 'Komputer Member', 'KM', null, '2', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('12', 'System Member', 'SM', null, '2', '1', '1', '2016-07-27 11:18:34', null);
INSERT INTO `item` VALUES ('13', 'Printer Kasir', 'PK', null, '2', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('14', 'Printer Member', 'PM', null, '2', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('15', 'Alat Scan Finger', 'ACF', null, '2', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('16', 'Monitor Bar Pool', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('17', 'System Bar Pool', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('18', 'Printer Bar Pool', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('19', 'UPS / Stabilizer', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('20', 'Telephone Ext', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('21', 'LCD Promo 29/42 Inch', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('22', 'Keyboard + Mouse', null, null, '3', '1', '1', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('23', 'Komputer Bar Pool', null, null, '3', '1', '1', '2016-07-27 11:22:52', null);
INSERT INTO `item` VALUES ('40', 'Telephone Telkom', 'TK', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('41', 'Modem Internet', 'MI', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('42', 'UPS / Stabilizer', 'UP', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('43', 'Keyboard + Mouse', 'KM', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('44', 'System Server', 'SS', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('45', 'Monitor Server', 'MS', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('46', 'Komputer Server', 'KS', '', '4', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('47', null, null, null, null, null, null, null, null);
INSERT INTO `item` VALUES ('48', null, null, null, null, null, null, null, null);
INSERT INTO `item` VALUES ('49', 'Monitor Bar Pool', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('50', 'System Bar Pool', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('51', 'Printer Bar Pool', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('52', 'UPS / Stabilizer', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('53', 'Telephone Ext', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('54', 'LCD Promo 29/42 Inch', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('55', 'Keyboard + Mouse', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('56', 'Komputer Bar Pool', null, null, '6', '1', '2', '2016-07-27 11:21:44', null);
INSERT INTO `item` VALUES ('57', 'Komputer Kasir', 'KS', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('58', 'Monitor Kasir', 'MK', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('59', 'System Kasir', 'SS', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('60', 'Komputer Member', 'KM', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('61', 'System Member', 'SM', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('62', 'Printer Kasir', 'PK', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('63', 'Printer Member', 'PM', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('64', 'Alat Scan Finger', 'ACF', null, '5', '1', '2', null, null);
INSERT INTO `item` VALUES ('65', 'Kebersihan & Kerapihan Area Locker', null, null, '7', '3', '1', '2016-08-04 10:39:06', null);
INSERT INTO `item` VALUES ('66', 'Ruang Ganti & Cermin', null, null, '7', '3', '1', '2016-08-04 10:39:06', null);
INSERT INTO `item` VALUES ('67', 'Kelengkapan Locker', null, null, '7', '3', '1', '2016-08-04 10:39:06', null);
INSERT INTO `item` VALUES ('68', 'Linen', null, null, '7', '3', '1', '2016-08-04 10:40:52', null);
INSERT INTO `item` VALUES ('69', 'Guest Amenities', null, null, '7', '3', '1', '2016-08-04 10:40:52', null);
INSERT INTO `item` VALUES ('70', 'Dressing Table', null, null, '7', '3', '1', '2016-08-04 10:40:52', null);
INSERT INTO `item` VALUES ('71', 'AC', null, null, '7', '3', '1', '2016-08-04 10:40:52', null);
INSERT INTO `item` VALUES ('72', 'Lampu/Penerangan', null, null, '7', '3', '1', '2016-08-04 10:40:52', null);
INSERT INTO `item` VALUES ('73', 'Pompa Pengisian Torn Air Panas (2 Bar - 3,8 Bar)', 'pptap', null, '11', '2', '1', '2016-08-09 16:56:04', null);
INSERT INTO `item` VALUES ('74', 'Pompa Pengisian Torn Air Dingin (2 Bar-3,8 Bar)', 'pptad', null, '11', '2', '1', '2016-08-09 16:56:04', null);
INSERT INTO `item` VALUES ('75', 'Pompa Sirkulasi Air Panas (2 Bar - 3,8 Bar)', 'psap', null, '11', '2', '1', '2016-08-09 16:56:04', null);
INSERT INTO `item` VALUES ('76', 'Panel Induk/MDP', 'mdp', null, '12', '2', '1', '2016-08-09 17:35:51', null);
INSERT INTO `item` VALUES ('77', 'Office', 'office', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('78', 'Ruang Server', 'svr', null, '13', '2', '1', '2016-08-09 17:37:41', null);
INSERT INTO `item` VALUES ('79', 'Kebersihan & Kerapihan Area Room', null, null, '8', '3', '1', '2016-08-11 10:26:59', null);
INSERT INTO `item` VALUES ('80', 'Display Room Message', null, null, '8', '3', '1', '2016-08-11 10:26:59', null);
INSERT INTO `item` VALUES ('81', 'Equipment Treatment', null, null, '8', '3', '1', '2016-08-11 10:26:59', null);
INSERT INTO `item` VALUES ('82', 'Guest Amenities', null, null, '8', '3', '1', '2016-08-11 10:26:59', null);
INSERT INTO `item` VALUES ('83', 'Panel Kapasitor Bank', 'pkb', null, '12', '2', '1', '2016-08-25 19:56:59', null);
INSERT INTO `item` VALUES ('84', 'Panel AMF/Genset', 'pag', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('85', 'Panel Pompa Transfer', 'ppt', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('86', 'Panel Pompa Dorong', 'ppd', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('87', 'Panel PP Lantai 1', 'pp1', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('88', 'Panel PP Lantai 2', 'pp2', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('89', 'Panel PP Lantai 3', 'pp3', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('90', 'Panel PP Lantai 4', 'pp4', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('91', 'Panel AC Lantai 1', 'pac1', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('92', 'Panel AC Lantai 2', 'pac2', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('93', 'Panel AC Lantai 3', 'pac3', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('94', 'Panel Telfon', 'pac4', null, '12', '2', '1', '2016-08-25 19:57:36', null);
INSERT INTO `item` VALUES ('95', 'Lobby', 'lobby', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('96', 'Kasir', 'kasir', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('97', 'Locker', 'locker', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('98', 'Cafe', 'cafe', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('99', 'Ruang Mesin (Outdoor Chiller)', 'rmc', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('100', 'Bar', 'bar', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('101', 'Gudang', 'gd', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('102', 'Coridor Room Messagae', 'crm', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('103', 'Counter Handuk', 'ch', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('104', 'Ruang Tunggu Therapist', 'rth', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('105', 'Mess', 'mess', null, '13', '2', '1', '2016-08-25 20:05:14', null);
INSERT INTO `item` VALUES ('106', 'Linen', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('107', 'Sanitary Room', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('108', 'Toilet Tamu dan Kelengkapannya', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('109', 'Washtafel', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('110', 'AC', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('111', 'Exhaaust Fan', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('112', 'Lampu / Penerangan', null, null, '8', '3', '1', '2016-08-26 11:04:14', null);
INSERT INTO `item` VALUES ('113', 'Kebersihan & Kerapihan Area Counter', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('114', 'Linen', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('115', 'Product Treatment', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('116', 'Equipment Treatment', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('117', 'Guest Amenities', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('118', 'Peralatan Kerja', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('119', 'AC/Kipas Angin', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('120', 'Lampu/Penerangan', null, null, '9', '3', '1', '2016-08-26 11:07:40', null);
INSERT INTO `item` VALUES ('121', 'Kebersihan & Kerapihan Area Laundry', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('122', 'Linen', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('123', 'Mesin Cuci', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('124', 'Detergent', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('125', 'Setrika', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('126', 'Kran Air & Drainage', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('127', 'Lampu/Penerangan', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('128', 'Toilet Karyawan', null, null, '10', '3', '1', '2016-08-26 11:09:53', null);
INSERT INTO `item` VALUES ('129', 'Pompa Sirkulasi Air Dingin (2 Bar-3,8 bar)', null, null, '11', '2', '1', '2016-08-26 11:20:09', null);
INSERT INTO `item` VALUES ('130', 'Tangki Tekan (2 Bar-3,8 Bar)', null, null, '11', '2', '1', '2016-08-26 11:20:09', null);
INSERT INTO `item` VALUES ('131', 'Valve Return/Selenoid Air Panas', null, null, '11', '2', '1', '2016-08-26 11:20:09', null);
INSERT INTO `item` VALUES ('132', 'Valve Return/Selenoid Air Dingin', null, null, '11', '2', '1', '2016-08-26 11:20:09', null);
INSERT INTO `item` VALUES ('133', 'Heater Rinnai', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('134', 'Heater Hayward', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('135', 'Valve - valve Header Vichy Shower', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('136', 'Nozel Header Vichy Shower', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('137', 'panel Room', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('138', 'Panel Control Vichy Shower', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('139', 'Tekanan Air Panas Panas  Vichy Shower Room', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('140', 'Tekanan Air Panas Dingin Vichy Shower Room', null, null, '11', '2', '1', '2016-08-26 11:23:49', null);
INSERT INTO `item` VALUES ('141', 'Pemeriksaan level oil', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('142', 'Pergantian Oli', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('143', 'Pembersihan Oli Filter', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('144', 'Pembersihan Filter Solar', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('145', 'Pergantian Filter Solar', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('146', 'Pemeriksaan Radiator / Air Radiator', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('147', 'Periksaan kecukupan bahan Bakar / Solar', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('148', 'Pemeriksaan Kondisi Accu', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('149', 'Pemeriksaan kabel-kabel Instrument', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('150', 'Pengecekan Kebersihan Genset & Area Genset', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('151', 'Test Running Genset', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);
INSERT INTO `item` VALUES ('152', 'Test Beban Genset', null, null, '14', '2', '1', '2016-08-30 14:06:19', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
INSERT INTO `item_area` VALUES ('14', 'Genset (mingguan)', '1', '2');

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
  `tegangan` varchar(50) DEFAULT NULL,
  `arus` varchar(50) DEFAULT NULL,
  `koneksi` varchar(50) DEFAULT NULL,
  `wiring` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_checklist
-- ----------------------------
INSERT INTO `item_checklist` VALUES ('5', '73', '3', null, '1', '2016-08-30 11:11:35', '1', '2', '1', 'okoke', '1', null, '2016-08-30 11:20:17', '300', null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('6', '76', '3', null, '1', '2016-08-30 11:55:10', '9', '2', '1', 'okook', '1', null, '2016-08-30 12:00:08', null, null, null, null, null, null, 'R', 'R', 'ok', 'okb');
INSERT INTO `item_checklist` VALUES ('11', '141', null, null, null, '2016-08-30 17:00:27', '9', '2', '1', 'daasasas', '0', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('12', '142', null, null, null, '2016-08-30 17:05:36', '9', '2', '1', '1233\n\n', '0', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('13', '141', null, null, null, '2016-08-31 10:40:46', '9', '2', '1', 'okokok', '0', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('14', '145', null, null, null, '2016-08-31 10:41:46', '9', '2', '1', 'saasssa', '0', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('15', '146', null, null, null, '2016-08-31 10:41:56', '9', '2', '1', 'sffddfd', '0', null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('16', '73', '3', null, '1', '2016-08-31 10:53:14', '9', '2', '1', 'okkkk', '0', null, null, '300', null, null, null, null, null, null, null, null, null);
INSERT INTO `item_checklist` VALUES ('17', '76', '3', null, '1', '2016-08-31 10:55:13', '9', '2', '1', 'sss', '0', null, null, null, null, null, null, null, null, 'R', 'R', 'ok', 'okb');
INSERT INTO `item_checklist` VALUES ('18', '139', '3', null, '1', '2016-08-31 10:55:34', '9', '2', '1', 'ssss', '0', null, null, '300', null, null, null, null, null, null, null, null, null);

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
  `item_id` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_image
-- ----------------------------
INSERT INTO `item_image` VALUES ('5', '/upload/surabaya 1/house keeping/2016/agustus/laravel-cod.jpg', '65', '2016-08-25 14:16:28');
INSERT INTO `item_image` VALUES ('6', '/upload/surabaya 1/it/2016/agustus/HD-Wallpapers1_FOSmVKg.jpeg', '1', '2016-08-25 14:18:31');
INSERT INTO `item_image` VALUES ('7', '/upload/surabaya 1/it/2016/agustus/adel.JPG', '1', '2016-08-25 16:18:13');
INSERT INTO `item_image` VALUES ('8', '/upload/surabaya 1/it/2016/agustus/laravel-cod.jpg', '7', '2016-08-25 16:24:05');
INSERT INTO `item_image` VALUES ('9', '/upload/surabaya 1/it/2016/agustus/Clipboard02.jpg', '1', '2016-08-25 16:42:25');
INSERT INTO `item_image` VALUES ('10', '/upload/surabaya 1/house keeping/2016/agustus/Chrysanthemum.jpg', '128', '2016-08-26 11:10:23');
INSERT INTO `item_image` VALUES ('11', '/upload/surabaya 1/house keeping/2016/agustus/sherina1.jpg', '79', '2016-08-26 13:49:57');
INSERT INTO `item_image` VALUES ('12', '/upload/surabaya 1/house keeping/2016/agustus/IMAGES.jpg', '80', '2016-08-26 13:53:36');
INSERT INTO `item_image` VALUES ('13', '/upload/surabaya 1/house keeping/2016/agustus/two.png', '66', '2016-08-26 13:54:22');
INSERT INTO `item_image` VALUES ('14', '/upload/surabaya 1/house keeping/2016/agustus/two.png', '113', '2016-08-26 13:55:14');
INSERT INTO `item_image` VALUES ('15', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '77', '2016-08-26 14:55:16');
INSERT INTO `item_image` VALUES ('16', '/upload/surabaya 1/me/2016/agustus/Koala.jpg', '95', '2016-08-26 14:57:08');
INSERT INTO `item_image` VALUES ('17', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '95', '2016-08-26 14:57:39');
INSERT INTO `item_image` VALUES ('18', '/upload/surabaya 1/me/2016/agustus/Tulips.jpg', '77', '2016-08-26 15:04:46');
INSERT INTO `item_image` VALUES ('19', '/upload/surabaya 1/me/2016/agustus/Tulips.jpg', '77', '2016-08-26 15:57:12');
INSERT INTO `item_image` VALUES ('20', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '95', '2016-08-26 15:58:09');
INSERT INTO `item_image` VALUES ('21', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '99', '2016-08-26 16:13:37');
INSERT INTO `item_image` VALUES ('22', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '73', '2016-08-26 18:58:54');
INSERT INTO `item_image` VALUES ('23', '/upload/surabaya 1/me/2016/agustus/Desert.jpg', '73', '2016-08-26 19:00:39');
INSERT INTO `item_image` VALUES ('24', '/upload/surabaya 1/me/2016/agustus/Tulips.jpg', '85', '2016-08-26 19:00:49');
INSERT INTO `item_image` VALUES ('25', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '73', '2016-08-26 19:01:51');
INSERT INTO `item_image` VALUES ('26', '/upload/surabaya 1/me/2016/agustus/Desert.jpg', '77', '2016-08-26 19:02:38');
INSERT INTO `item_image` VALUES ('27', '/upload/surabaya 1/me/2016/agustus/Lighthouse.jpg', '86', '2016-08-29 16:51:16');
INSERT INTO `item_image` VALUES ('28', '/upload/surabaya 1/me/2016/agustus/Tulips.jpg', '73', '2016-08-30 11:50:35');
INSERT INTO `item_image` VALUES ('29', '/upload/surabaya 1/me/2016/agustus/Penguins.jpg', '76', '2016-08-30 11:55:06');

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
  `user_type` enum('administrator','manager','leader','operator','manager pengganti') DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'Super', 'Admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 'administrator', '1', '0', '085710011524', '1', '2016-08-16 17:18:11', '2016-08-16 17:18:11', '2016-08-31', '2016-09-01', '2016-08-31 11:31:24');
INSERT INTO `users` VALUES ('2', 'manager', 'Manager', 'Budi', '1d0258c2440a8d19e716292b231e3190', 'manager@manager.com', 'manager', '1', '0', '', '1', '2016-08-16 17:21:38', '2016-08-16 17:21:38', '2016-08-31', '2016-09-06', '2016-08-31 11:18:44');
INSERT INTO `users` VALUES ('3', 'staff', 'Staff', 'IT', 'de9bf5643eabf80f4a56fda3bbb84483', 'staffit@gmail.com', 'operator', '1', '1', '0878785225', '1', '2016-08-15 18:18:55', '2016-08-15 18:18:55', '2016-08-31', '2016-09-06', '2016-08-31 11:27:00');
INSERT INTO `users` VALUES ('4', 'managerjkt', 'Manajaer JKT', '', '1d0258c2440a8d19e716292b231e3190', 'manager@manager.com', 'manager', '2', '0', null, '1', '2016-08-15 14:07:38', '2016-08-15 14:07:38', '2016-08-23', '2016-08-29', '2016-08-23 13:08:05');
INSERT INTO `users` VALUES ('5', 'test', 'User', 'Ajah', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', 'operator', '2', '0', '0878785225', '1', '2016-08-15 14:07:39', '2016-08-15 14:07:39', null, null, null);
INSERT INTO `users` VALUES ('7', 'divme', 'Divisi', 'ME', '21232f297a57a5a743894a0e4a801fc3', 'test@test.com', 'operator', '1', '2', null, '1', '2016-08-15 14:07:40', '2016-08-15 14:07:40', null, null, null);
INSERT INTO `users` VALUES ('8', 'userhk', 'House', 'Keeping', '307dd33a0509cf87498084485de7cf08', 'house@keeping.com', 'operator', '1', '3', '0878785225', '1', '2016-08-15 14:07:40', null, '2016-08-31', '2016-09-06', '2016-08-31 10:27:09');
INSERT INTO `users` VALUES ('9', 'userme', 'Userme', 'Userme', '21232f297a57a5a743894a0e4a801fc3', 'userme@me.com', 'operator', '1', '2', '0878785225', '1', '2016-08-10 16:32:05', null, '2016-08-31', '2016-09-06', '2016-08-31 10:38:46');
INSERT INTO `users` VALUES ('10', 'leaderhk', 'Budi', 'Doremi', '223b0924ca495b695c2fae40c4e32f77', 'budi@budi.com', 'leader', '1', '3', '', '1', '2016-08-15 14:07:44', '2016-08-15 14:07:44', null, null, null);
INSERT INTO `users` VALUES ('11', 'manager2', 'Manager', 'Cadangan', '1d0258c2440a8d19e716292b231e3190', 'manager@manager.com', 'manager pengganti', '0', '0', null, '0', '2016-08-24 10:53:10', null, '2016-08-29', '2016-08-31', '2016-08-24 17:46:33');
INSERT INTO `users` VALUES ('34', 'manager3', 'Manajer', 'Pengganti 3', '21232f297a57a5a743894a0e4a801fc3', 'manager3@manager.com', 'manager pengganti', '0', '0', '0878785225', '1', '2016-08-29 13:58:11', null, null, null, null);
