CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email`         VARCHAR(249) NOT NULL,
  `password`      VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username`      VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `status`        TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `verified`      TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `resettable`    TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `roles_mask`    INT UNSIGNED NOT NULL DEFAULT '0',
  `registered`    INT UNSIGNED NOT NULL,
  `last_login`    INT UNSIGNED DEFAULT NULL,
  `force_logout`  MEDIUMINT UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE IF NOT EXISTS `users_confirmations` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`   INT UNSIGNED NOT NULL,
  `email`     VARCHAR(249) NOT NULL,
  `selector`  VARCHAR(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token`     VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires`   INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `email_expires` (`email`,`expires`),
  KEY `user_id` (`user_id`)
);

CREATE TABLE IF NOT EXISTS `users_remembered` (
  `id`        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user`      INT UNSIGNED NOT NULL,
  `selector`  VARCHAR(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token`     VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires`   INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user` (`user`)
);

CREATE TABLE IF NOT EXISTS `users_resets` (
  `id`        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user`      INT UNSIGNED NOT NULL,
  `selector`  VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token`     VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires`   INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`),
  KEY `user_expires` (`user`,`expires`)
);

CREATE TABLE IF NOT EXISTS `users_throttling` (
  `bucket`          VARCHAR(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens`          FLOAT NOT NULL,
  `replenished_at`  INT UNSIGNED NOT NULL,
  `expires_at`      INT UNSIGNED NOT NULL,
  PRIMARY KEY (`bucket`),
  KEY `expires_at` (`expires_at`)
);

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` INT UNSIGNED NOT NULL,
  `name_title` VARCHAR(16),
  `name_first` VARCHAR(64),
  `name_last` VARCHAR(128),
  `name_suffix` VARCHAR(16),
  PRIMARY KEY (`id`)
);
