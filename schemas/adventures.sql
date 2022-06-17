USE `shadows`;

CREATE TABLE IF NOT EXISTS `adventures` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` CHAR(36) NOT NULL,
  `author` INT UNSIGNED NOT NULL,
  `name` VARCHAR(127) NOT NULL,
  `cover` VARCHAR(255) DEFAULT NULL,
  `desc` TEXT NOT NULL,
  `setting` VARCHAR(63) DEFAULT NULL,
  `triggers` VARCHAR(1023) DEFAULT NULL,
  `level_init` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `level_end` TINYINT UNSIGNED NOT NULL DEFAULT 12,
  `pcs` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `is_public` BOOLEAN NOT NULL DEFAULT TRUE,
  `status` ENUM('development', 'alpha', 'beta', 'stable') NOT NULL DEFAULT 'development',
  `entry` CHAR(36),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `entry` (`entry`),
  KEY `author` (`author`)
);

CREATE TABLE IF NOT EXISTS `adventures_variables` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adventure` INT UNSIGNED NOT NULL,
  `name` VARCHAR(31) NOT NULL,
  `type` ENUM('string', 'integer', 'float', 'boolean', 'json') NOT NULL DEFAULT 'string',
  `value` VARCHAR(1023) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adventure` (`adventure`),
  KEY `name` (`name`)
);

CREATE TABLE IF NOT EXISTS `adventures_plays` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adventure` INT UNSIGNED NOT NULL,
  `player` INT UNSIGNED NOT NULL,
  `start` DATE NOT NULL,
  `active` BOOLEAN NOT NULL DEFAULT TRUE,
  `darkvision` BOOLEAN NOT NULL DEFAULT FALSE,
  `level` TINYINT UNSIGNED NOT NULL,
  `xp` MEDIUMINT UNSIGNED DEFAULT NULL,
  `last_saved` DATE NOT NULL,
  `last_room` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adventure` (`adventure`),
  KEY `player` (`player`)
);
