/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : knowledgecity

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 29/08/2020 07:10:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for api_users
-- ----------------------------
DROP TABLE IF EXISTS `api_users`;
CREATE TABLE `api_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `students_id` int(11) NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `token` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `last_login` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of api_users
-- ----------------------------
INSERT INTO `api_users` VALUES (1, 1, 'civancorral', '$2y$10$y9Yx5gBWGGM/wFIoCzKxk.Nqb38BugUPW37yXAbz3sJpa1wRH2i0e', NULL, '2020-08-28 17:37:30', '2020-08-28 17:37:30', '2020-08-28 17:37:30');
INSERT INTO `api_users` VALUES (2, 2, 'carlosibarra', '$2y$10$dCA9vXnnwuasyMeoLl3Ww.EaQ4LPouGtn0tfAVKFLAPnnsthEb1ze', NULL, '2020-08-28 17:37:48', '2020-08-28 17:37:48', '2020-08-28 17:37:48');
INSERT INTO `api_users` VALUES (3, 3, 'bettymeza', '$2y$10$Rr8Iys9gPoyUPml9yYqUZe6YPAmxa9C3ZIN0JEGWryrw6ixcLFuBS', NULL, '2020-08-28 17:38:23', '2020-08-28 17:38:23', '2020-08-28 17:38:23');
INSERT INTO `api_users` VALUES (4, 4, 'megarameza', '$2y$10$ynpcecQ82Ptp5Wg9sQYXWuwckLxcmetW73L.chZziShE1hKrKctLO', NULL, '2020-08-28 17:38:47', '2020-08-28 17:38:47', '2020-08-28 17:38:47');
INSERT INTO `api_users` VALUES (5, 5, 'bandymeza', '$2y$10$rinTHDFBg6GX9kG6LnKOTe7Jhbace/eEtE3m6r17O06UbgyFfyC9.', NULL, '2020-08-28 17:39:10', '2020-08-28 17:39:10', '2020-08-28 17:39:10');
INSERT INTO `api_users` VALUES (6, 6, 'erikaibarra', '$2y$10$RwI8FKd/rb4w9V4J0bBvbeL.2OG3hQmy/V16LYI7mAAGqTvKJYT3m', NULL, '2020-08-28 17:40:14', '2020-08-28 17:40:14', '2020-08-28 17:40:14');
INSERT INTO `api_users` VALUES (7, 7, 'brunoibarra', '$2y$10$jOmEtR.4MNGXys9CDhEunOipzW8L8hbbiv3dwMuDjNjv/gSnIAa6S', NULL, '2020-08-28 17:40:44', '2020-08-28 17:40:44', '2020-08-28 17:40:44');
INSERT INTO `api_users` VALUES (8, 8, 'monchoibarra', '$2y$10$AUFqtoQR.8WfT12b81SfQebLVR/vxiNONK.a9BMeBVGt6NsvLYGPC', NULL, '2020-08-28 17:41:35', '2020-08-28 17:41:35', '2020-08-28 17:41:35');
INSERT INTO `api_users` VALUES (9, 9, 'marycorral', '$2y$10$Goy0WZePRuziX4z9wHd2o.5794CHpGD7ZxAYLIJikVJs24MKW.ux2', NULL, '2020-08-28 17:42:16', '2020-08-28 17:42:16', '2020-08-28 17:42:16');
INSERT INTO `api_users` VALUES (10, 10, 'mattycorral', '$2y$10$j3hIQ5ttzjkXH1TGLA/cuOIbCtCY5oocz.L.eKfCGGpY63PZ.OMmi', NULL, '2020-08-28 17:42:37', '2020-08-28 17:42:37', '2020-08-28 17:42:37');

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `lastname` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (1, 'Cesar', 'Ibarra', 'civancorral@gmail.com', '2020-08-28 17:37:30', '2020-08-28 17:37:30');
INSERT INTO `students` VALUES (2, 'Carlos', 'Ibarra', 'carlosibarra@gmail.com', '2020-08-28 17:37:48', '2020-08-28 17:37:48');
INSERT INTO `students` VALUES (3, 'Betty', 'Meza', 'bettymeza@gmail.com', '2020-08-28 17:38:23', '2020-08-28 17:38:23');
INSERT INTO `students` VALUES (4, 'Megara', 'Meza', 'megarameza@gmail.com', '2020-08-28 17:38:46', '2020-08-28 17:38:46');
INSERT INTO `students` VALUES (5, 'bandy', 'bandy', 'bandymeza@gmail.com', '2020-08-28 17:39:09', '2020-08-28 17:39:09');
INSERT INTO `students` VALUES (6, 'Erika', 'Ibarra', 'erikaibarra@gmail.com', '2020-08-28 17:40:14', '2020-08-28 17:40:14');
INSERT INTO `students` VALUES (7, 'Bruno', 'Ibarra', 'brunoibarra@gmail.com', '2020-08-28 17:40:44', '2020-08-28 17:40:44');
INSERT INTO `students` VALUES (8, 'Moncho', 'Meza', 'monchoibarra@gmail.com', '2020-08-28 17:41:34', '2020-08-28 17:41:34');
INSERT INTO `students` VALUES (9, 'Mary', 'Corral', 'marycorral@gmail.com', '2020-08-28 17:42:16', '2020-08-28 17:42:16');
INSERT INTO `students` VALUES (10, 'Matty', 'Corral', 'mattycorral@gmail.com', '2020-08-28 17:42:37', '2020-08-28 17:42:37');

SET FOREIGN_KEY_CHECKS = 1;
