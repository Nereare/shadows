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
  `room` INT UNSIGNED NOT NULL, # Unfinished
  PRIMARY KEY (`id`),
  KEY `room` (`room`)
);
