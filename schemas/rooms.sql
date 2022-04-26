USE `shadows`;

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adventure` INT UNSIGNED NOT NULL,
  `name` VARCHAR(63) DEFAULT NULL,
  `desc` TEXT DEFAULT NULL,
  `has_items` BOOLEAN DEFAULT FALSE,
  `has_checks` BOOLEAN DEFAULT FALSE,
  `has_combats` BOOLEAN DEFAULT FALSE,
  `has_exits` BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`id`),
  KEY `adventure` (`adventure`),
  KEY `name` (`name`)
);

CREATE TABLE IF NOT EXISTS `rooms_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room` INT UNSIGNED NOT NULL,
  `is_hidden` BOOLEAN NOT NULL DEFAULT FALSE,
  `desc_shown` TINYTEXT DEFAULT NULL,
  `desc_hidden` TINYTEXT DEFAULT NULL,
  `investigation` TINYINT UNSIGNED DEFAULT NULL,
  `perception` TINYINT UNSIGNED DEFAULT NULL,
  `is_taken` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);

CREATE TABLE IF NOT EXISTS `rooms_checks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room` INT UNSIGNED NOT NULL,
  `skill` VARCHAR(31) NOT NULL,
  `dc` TINYINT UNSIGNED NOT NULL DEFAULT 15,
  `critical_failure` TEXT, # Result if roll was 5+ below DC.
  `normal_failure` TEXT, # Result if roll was below DC.
  `normal_success` TEXT, # Result if roll was equal-to-or-above DC.
  `critical_success` TEXT, # Result if roll was 5+ above DC.
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);

CREATE TABLE IF NOT EXISTS `rooms_combats` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room` INT UNSIGNED NOT NULL,
  `desc` TINYTEXT NOT NULL,
  `enemies` JSON NOT NULL,
  `is_runnable` BOOLEAN NOT NULL DEFAULT FALSE,
  `is_hideable` BOOLEAN NOT NULL DEFAULT FALSE,
  `stealth_dc` TINYINT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);

CREATE TABLE IF NOT EXISTS `rooms_exits` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room` INT UNSIGNED NOT NULL,
  `desc` TINYTEXT NOT NULL,
  `exit` INT UNSIGNED NOT NULL,
  `is_hidden` BOOLEAN NOT NULL DEFAULT FALSE,
  `investigation_dc` TINYINT UNSIGNED DEFAULT NULL,
  `is_locked` BOOLEAN NOT NULL DEFAULT FALSE,
  `thievestools_dc` TINYINT UNSIGNED DEFAULT NULL,
  `is_breakable` BOOLEAN NOT NULL DEFAULT FALSE,
  `strength_dc` TINYINT UNSIGNED DEFAULT NULL,
  `has_sounds` BOOLEAN NOT NULL DEFAULT FALSE,
  `perception_dc` TINYINT UNSIGNED DEFAULT NULL,
  `sounds_desc` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);
