USE `shadows`;

CREATE TABLE IF NOT EXISTS `meta_checks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(63) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

INSERT INTO `meta_checks`
  (`name`)
  VALUES
  ('Strength check'),
  ('Strength saving throw'),
  ('Dexterity check'),
  ('Dexterity saving throw'),
  ('Constitution check'),
  ('Constitution saving throw'),
  ('Intelligence check'),
  ('Intelligence saving throw'),
  ('Wisdom check'),
  ('Wisdom saving throw'),
  ('Charisma check'),
  ('Charisma saving throw'),
  ('Acrobatics (Dex)'),
  ('Animal Handling (Wis)'),
  ('Arcana (Int)'),
  ('Athletics (Str)'),
  ('Deception (Cha)'),
  ('History (Int)'),
  ('Insight (Wis)'),
  ('Intimidation (Cha)'),
  ('Investigation (Int)'),
  ('Medicina (Wis)'),
  ('Nature (Int)'),
  ('Perception (Wis)'),
  ('Performance (Cha)'),
  ('Persuasion (Cha)'),
  ('Religion (Int)'),
  ('Sleight of Hand (Dex)'),
  ('Stealth (Dex)'),
  ('Survival (Wis)'),
  ('Thieves\' Tools (Dex)');

CREATE TABLE IF NOT EXISTS `meta_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(63),
  `name` VARCHAR(63) NOT NULL,
  `desc` TEXT NOT NULL,
  `source` VARCHAR(255),
  `page` TINYINT UNSIGNED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
);

CREATE
  DEFINER='shadows'@'localhost'
  TRIGGER `set_item_code`
  BEFORE INSERT ON `meta_items` FOR EACH ROW
  SET NEW.`code` = CONCAT('IID', UNIX_TIMESTAMP());
