/*
 Navicat Premium Data Transfer

 Source Server         : LocalHost
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : algopay

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 23/10/2020 19:32:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tblproduct
-- ----------------------------
DROP TABLE IF EXISTS `tblproduct`;
CREATE TABLE `tblproduct` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tblproduct
-- ----------------------------
BEGIN;
INSERT INTO `tblproduct` VALUES (1, 'FinePix Pro2 3D Camera', '3DcAM01', 'product-images/camera.jpg', 15.00);
INSERT INTO `tblproduct` VALUES (2, 'EXP Portable Hard Drive', 'USB02', 'product-images/external-hard-drive.jpg', 8.00);
INSERT INTO `tblproduct` VALUES (3, 'Luxury Ultra thin Wrist Watch', 'wristWear03', 'product-images/watch.jpg', 3.00);
INSERT INTO `tblproduct` VALUES (4, 'XP 1155 Intel Core Laptop', 'LPN45', 'product-images/laptop.jpg', 8.00);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
