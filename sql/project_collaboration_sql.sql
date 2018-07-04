/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100116
 Source Host           : localhost:3306
 Source Schema         : project_collaboration

 Target Server Type    : MySQL
 Target Server Version : 100116
 File Encoding         : 65001

 Date: 05/07/2018 00:07:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comment
-- ----------------------------
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`  (
  `comment_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `job_id` int(20) NOT NULL,
  `created_at` datetime(6) NULL DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_private` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`comment_id`) USING BTREE,
  INDEX `FK_COMMENT_USER_ID`(`user_id`) USING BTREE,
  INDEX `FK_COMMENT_JOB_ID`(`job_id`) USING BTREE,
  CONSTRAINT `FK_COMMENT_JOB_ID` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_COMMENT_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of comment
-- ----------------------------
INSERT INTO `comment` VALUES (1, 13, 10, '2018-07-01 00:20:23.000000', 'prvi komentar', 0);
INSERT INTO `comment` VALUES (2, 13, 10, '2018-07-01 00:21:53.000000', 'drugi komentar', 1);
INSERT INTO `comment` VALUES (3, 13, 9, '2018-07-04 23:34:27.000000', 'f', 0);
INSERT INTO `comment` VALUES (4, 13, 9, '2018-07-04 23:36:26.000000', 'y', 0);
INSERT INTO `comment` VALUES (5, 13, 9, '2018-07-04 23:39:10.000000', 'vddddd', 0);

-- ----------------------------
-- Table structure for invitation
-- ----------------------------
DROP TABLE IF EXISTS `invitation`;
CREATE TABLE `invitation`  (
  `invitation_id` int(20) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `is_accepted` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`invitation_id`) USING BTREE,
  INDEX `FK_invitations_projects`(`project_id`) USING BTREE,
  INDEX `FK_invitations_users`(`user_id`) USING BTREE,
  CONSTRAINT `FK_INVITATION_PROJECT_ID` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_INVITATION_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of invitation
-- ----------------------------
INSERT INTO `invitation` VALUES (1, 13, 11, 0);
INSERT INTO `invitation` VALUES (2, 13, 11, 0);
INSERT INTO `invitation` VALUES (3, 13, 13, 0);
INSERT INTO `invitation` VALUES (4, 13, 13, 0);
INSERT INTO `invitation` VALUES (5, 13, 11, 0);
INSERT INTO `invitation` VALUES (6, 13, 11, 0);
INSERT INTO `invitation` VALUES (7, 13, 13, 0);
INSERT INTO `invitation` VALUES (8, 13, 11, 0);

-- ----------------------------
-- Table structure for job
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job`  (
  `job_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(20) NOT NULL,
  `deadline` date NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `progress` int(3) NOT NULL,
  `project_id` int(20) NOT NULL,
  PRIMARY KEY (`job_id`) USING BTREE,
  INDEX `FK_jobs_users`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of job
-- ----------------------------
INSERT INTO `job` VALUES (9, 'Prvi posao', 13, '2018-06-22', 'Kreiranje pocetne strane', 0, 13);
INSERT INTO `job` VALUES (10, 'Login strana', 13, '2018-07-19', 'Kreiranje login strane', 0, 13);

-- ----------------------------
-- Table structure for job_user
-- ----------------------------
DROP TABLE IF EXISTS `job_user`;
CREATE TABLE `job_user`  (
  `job_user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NULL DEFAULT NULL,
  `job_id` int(20) NULL DEFAULT NULL,
  `progress` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `deadline` datetime(6) NULL DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`job_user_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `FK_JOB_USER_JOB_ID`(`job_id`) USING BTREE,
  CONSTRAINT `FK_JOB_USER_JOB_ID` FOREIGN KEY (`job_id`) REFERENCES `job` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JOB_USER_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of job_user
-- ----------------------------
INSERT INTO `job_user` VALUES (2, 13, 10, NULL, '2018-06-30 00:00:00.000000', 'nije tezak posao');
INSERT INTO `job_user` VALUES (3, 13, 9, NULL, '2018-07-13 00:00:00.000000', 'komentar');

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `project_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `progress` int(3) NOT NULL,
  PRIMARY KEY (`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES (13, 13, 'prvi', '2018-06-30 22:10:43.000000', 0);
INSERT INTO `project` VALUES (14, 17, '666', '2018-06-30 22:24:47.000000', 0);
INSERT INTO `project` VALUES (15, 13, 'treci', '2018-07-04 23:06:10.000000', 0);
INSERT INTO `project` VALUES (16, 13, 'a666', '2018-07-04 23:06:38.000000', 0);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (11, 'pera@gmail.com', 'Pera', 'Peric', '$2y$10$xg4GYw9poLCID1nKuiT5gOmImjg2NS42oR/wJIKIRC9Rjb9f04z06', 0);
INSERT INTO `user` VALUES (12, 'marija@gmail.com', 'Marija', 'Maric', '$2y$10$IByzyBGJbhQHlMfK89LuGuhzp3SyO6f46TCjXO7/AD/OOD1nnu9LC', 0);
INSERT INTO `user` VALUES (13, 'stosic@mejl.com', 'Andjelka', 'Stosic', '$2y$10$YPhnxp2/jenPuNm6UGIzJeBjPKT8ShUIPEj6fCJT6ke.t4QOe492C', 0);
INSERT INTO `user` VALUES (17, 'andjelkastosic@gmail.com', 'Andja', 'Stosic', '$2y$10$9L7LBbRrd0OMEix5IyQn..0Sb6kfy67LmKTpvgMMzbpvIoeu2EyOC', 0);
INSERT INTO `user` VALUES (18, 'andjelkastosic@gmail.comdd', 'Andjelka', 'Stosic', '$2y$10$5Iwl.ggLKieQ9NM2SXhnsOmuU2wnWE0FkNwkLPZOn6/VNk832oBPG', 0);

SET FOREIGN_KEY_CHECKS = 1;
