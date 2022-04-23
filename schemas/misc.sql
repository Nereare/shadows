USE `shadows`;

CREATE TABLE IF NOT EXISTS `meta_checks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(63) NOT NULL UNIQUE,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

INSERT INTO `shadows`.`meta_checks`
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
  ('Thieves' Tools (Dex)');
