USE `shadows`;

CREATE TABLE IF NOT EXISTS `adventures` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author` INT UNSIGNED NOT NULL,
  `name` VARCHAR(127) NOT NULL,
  `cover` VARCHAR(255) DEFAULT NULL,
  `desc` MEDIUMTEXT NOT NULL,
  `setting` VARCHAR(63) DEFAULT NULL,
  `entry` INT UNSIGNED NOT NULL,
  `level_init` TINYINT UNSIGNED DEFAULT 1,
  `level_end` TINYINT UNSIGNED DEFAULT 12,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entry` (`entry`),
  KEY `author` (`author`)
);

CREATE TABLE IF NOT EXISTS `adventure_plays` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `adventure` INT UNSIGNED NOT NULL,
  `player` INT UNSIGNED NOT NULL,
  `start` DATE NOT NULL,
  `level` TINYINT NOT NULL,
  `last_saved` DATE NOT NULL,
  `last_room` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adventure` (`adventure`),
  KEY `player` (`player`)
);
