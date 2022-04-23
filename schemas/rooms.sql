USE `shadows`;

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adventure` INT UNSIGNED NOT NULL,
  `name` VARCHAR(63) DEFAULT NULL,
  `desc` MEDIUMTEXT DEFAULT NULL,
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
  `desc_shown` TEXT DEFAULT NULL,
  `desc_hidden` TEXT DEFAULT NULL,
  `investigation` TINYINT DEFAULT NULL,
  `perception` TINYINT DEFAULT NULL,
  `is_taken` BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);

CREATE TABLE IF NOT EXISTS `rooms_checks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `room` INT UNSIGNED NOT NULL,
  `skill` VARCHAR(31) NOT NULL,
  `dc` TINYINT NOT NULL DEFAULT 15,
  `critical_failure` TEXT, # Result if roll was 5+ below DC.
  `normal_failure` TEXT, # Result if roll was below DC.
  `normal_success` TEXT, # Result if roll was equal-to-or-above DC.
  `critical_success` TEXT, # Result if roll was 5+ above DC.
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);
