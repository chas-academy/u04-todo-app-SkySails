SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lists
-- ----------------------------
DROP TABLE IF EXISTS `lists`;
CREATE TABLE `lists`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A users email should be unique',
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'A users email should be unique',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time at which the list was created',
  `created_by` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'The id of the user that submitted the list',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `UserID_list`(`created_by`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for todos
-- ----------------------------
DROP TABLE IF EXISTS `todos`;
CREATE TABLE `todos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique id of the todo',
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The title of the todo',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'The content of the todo',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'The status of the todo',
  `created_by` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The id of the user that submitted the todo',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Then date/time at which the todo was created',
  `list_id` int(11) NULL DEFAULT NULL COMMENT 'The id for the list in which the dodo is listed',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `UserID`(`created_by`) USING BTREE,
  INDEX `ListId`(`list_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The unique id of the user',
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The name of the user',
  `email` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The email of the user',
  `pw_hash` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'The password hash and salt separated concatenated',
  `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time at which the user was created',
  `modified_at` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'The time at which the user was updated',
  PRIMARY KEY (`id`, `email`) USING BTREE,
  UNIQUE INDEX `UserEmail`(`email`) USING BTREE COMMENT 'A users email should be unique',
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

ALTER TABLE `lists`
  ADD CONSTRAINT `UserID_list` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
--
ALTER TABLE `todos`
  ADD CONSTRAINT `UserID` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ListId` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;