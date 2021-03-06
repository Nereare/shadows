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

CREATE TABLE IF NOT EXISTS `meta_licenses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `abbr` VARCHAR(16),
  `fullname` VARCHAR(128) NOT NULL,
  `link` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbr` (`abbr`)
);

INSERT INTO `meta_licenses`
  (`fullname`, `abbr`, `link`)
  VALUES
  ("Academic Free License v1.1", "AFL-1.1", "https://spdx.org/licenses/AFL-1.1.html"),
  ("Academic Free License v1.2", "AFL-1.2", "https://spdx.org/licenses/AFL-1.2.html"),
  ("Academic Free License v2.0", "AFL-2.0", "https://spdx.org/licenses/AFL-2.0.html"),
  ("Academic Free License v2.1", "AFL-2.1", "https://spdx.org/licenses/AFL-2.1.html"),
  ("Academic Free License v3.0", "AFL-3.0", "https://spdx.org/licenses/AFL-3.0.html"),
  ("Artistic License 1.0", "Artistic-1.0", "https://spdx.org/licenses/Artistic-1.0.html"),
  ("Artistic License 1.0 w/clause 8", "Artistic-1.0-cl8", "https://spdx.org/licenses/Artistic-1.0-cl8.html"),
  ("Artistic License 2.0", "Artistic-2.0", "https://spdx.org/licenses/Artistic-2.0.html"),
  ("Creative Commons Attribution 1.0 Generic", "CC-BY-1.0", "https://spdx.org/licenses/CC-BY-1.0.html"),
  ("Creative Commons Attribution 2.0 Generic", "CC-BY-2.0", "https://spdx.org/licenses/CC-BY-2.0.html"),
  ("Creative Commons Attribution 2.5 Generic", "CC-BY-2.5", "https://spdx.org/licenses/CC-BY-2.5.html"),
  ("Creative Commons Attribution 3.0 Unported", "CC-BY-3.0", "https://spdx.org/licenses/CC-BY-3.0.html"),
  ("Creative Commons Attribution 4.0 International", "CC-BY-4.0", "https://spdx.org/licenses/CC-BY-4.0.html"),
  ("Creative Commons Attribution Non Commercial 1.0 Generic", "CC-BY-NC-1.0", "https://spdx.org/licenses/CC-BY-NC-1.0.html"),
  ("Creative Commons Attribution Non Commercial 2.0 Generic", "CC-BY-NC-2.0", "https://spdx.org/licenses/CC-BY-NC-2.0.html"),
  ("Creative Commons Attribution Non Commercial 2.5 Generic", "CC-BY-NC-2.5", "https://spdx.org/licenses/CC-BY-NC-2.5.html"),
  ("Creative Commons Attribution Non Commercial 3.0 Unported", "CC-BY-NC-3.0", "https://spdx.org/licenses/CC-BY-NC-3.0.html"),
  ("Creative Commons Attribution Non Commercial 4.0 International", "CC-BY-NC-4.0", "https://spdx.org/licenses/CC-BY-NC-4.0.html"),
  ("Creative Commons Attribution Non Commercial No Derivatives 1.0 Generic", "CC-BY-NC-ND-1.0", "https://spdx.org/licenses/CC-BY-NC-ND-1.0.html"),
  ("Creative Commons Attribution Non Commercial No Derivatives 2.0 Generic", "CC-BY-NC-ND-2.0", "https://spdx.org/licenses/CC-BY-NC-ND-2.0.html"),
  ("Creative Commons Attribution Non Commercial No Derivatives 2.5 Generic", "CC-BY-NC-ND-2.5", "https://spdx.org/licenses/CC-BY-NC-ND-2.5.html"),
  ("Creative Commons Attribution Non Commercial No Derivatives 3.0 Unported", "CC-BY-NC-ND-3.0", "https://spdx.org/licenses/CC-BY-NC-ND-3.0.html"),
  ("Creative Commons Attribution Non Commercial No Derivatives 4.0 International", "CC-BY-NC-ND-4.0", "https://spdx.org/licenses/CC-BY-NC-ND-4.0.html"),
  ("Creative Commons Attribution Non Commercial Share Alike 1.0 Generic", "CC-BY-NC-SA-1.0", "https://spdx.org/licenses/CC-BY-NC-SA-1.0.html"),
  ("Creative Commons Attribution Non Commercial Share Alike 2.0 Generic", "CC-BY-NC-SA-2.0", "https://spdx.org/licenses/CC-BY-NC-SA-2.0.html"),
  ("Creative Commons Attribution Non Commercial Share Alike 2.5 Generic", "CC-BY-NC-SA-2.5", "https://spdx.org/licenses/CC-BY-NC-SA-2.5.html"),
  ("Creative Commons Attribution Non Commercial Share Alike 3.0 Unported", "CC-BY-NC-SA-3.0", "https://spdx.org/licenses/CC-BY-NC-SA-3.0.html"),
  ("Creative Commons Attribution Non Commercial Share Alike 4.0 International", "CC-BY-NC-SA-4.0", "https://spdx.org/licenses/CC-BY-NC-SA-4.0.html"),
  ("Creative Commons Attribution No Derivatives 1.0 Generic", "CC-BY-ND-1.0", "https://spdx.org/licenses/CC-BY-ND-1.0.html"),
  ("Creative Commons Attribution No Derivatives 2.0 Generic", "CC-BY-ND-2.0", "https://spdx.org/licenses/CC-BY-ND-2.0.html"),
  ("Creative Commons Attribution No Derivatives 2.5 Generic", "CC-BY-ND-2.5", "https://spdx.org/licenses/CC-BY-ND-2.5.html"),
  ("Creative Commons Attribution No Derivatives 3.0 Unported", "CC-BY-ND-3.0", "https://spdx.org/licenses/CC-BY-ND-3.0.html"),
  ("Creative Commons Attribution No Derivatives 4.0 International", "CC-BY-ND-4.0", "https://spdx.org/licenses/CC-BY-ND-4.0.html"),
  ("Creative Commons Attribution Share Alike 1.0 Generic", "CC-BY-SA-1.0", "https://spdx.org/licenses/CC-BY-SA-1.0.html"),
  ("Creative Commons Attribution Share Alike 2.0 Generic", "CC-BY-SA-2.0", "https://spdx.org/licenses/CC-BY-SA-2.0.html"),
  ("Creative Commons Attribution Share Alike 2.5 Generic", "CC-BY-SA-2.5", "https://spdx.org/licenses/CC-BY-SA-2.5.html"),
  ("Creative Commons Attribution Share Alike 3.0 Unported", "CC-BY-SA-3.0", "https://spdx.org/licenses/CC-BY-SA-3.0.html"),
  ("Creative Commons Attribution Share Alike 4.0 International", "CC-BY-SA-4.0", "https://spdx.org/licenses/CC-BY-SA-4.0.html"),
  ("Creative Commons Zero v1.0 Universal", "CC0-1.0", "https://spdx.org/licenses/CC0-1.0.html"),
  ("Common Public Attribution License 1.0", "CPAL-1.0", "https://spdx.org/licenses/CPAL-1.0.html"),
  ("Common Public License 1.0", "CPL-1.0", "https://spdx.org/licenses/CPL-1.0.html"),
  ("Crossword License", "Crossword", "https://spdx.org/licenses/Crossword.html"),
  ("Educational Community License v1.0", "ECL-1.0", "https://spdx.org/licenses/ECL-1.0.html"),
  ("Educational Community License v2.0", "ECL-2.0", "https://spdx.org/licenses/ECL-2.0.html"),
  ("Glulxe License", "Glulxe", "https://spdx.org/licenses/Glulxe.html"),
  ("Good Luck With That Public License", "GLWTPL", "https://github.com/me-shaon/GLWTPL"),
  ("Hippocratic License", "HL3", "https://firstdonoharm.dev/"),
  ("Historical Permission Notice and Disclaimer", "HPND", "https://spdx.org/licenses/HPND.html"),
  ("Licence Art Libre 1.2", "LAL-1.2", "https://spdx.org/licenses/LAL-1.2.html"),
  ("Licence Art Libre 1.3", "LAL-1.3", "https://spdx.org/licenses/LAL-1.3.html"),
  ("MIT License", "MIT", "https://spdx.org/licenses/MIT.html"),
  ("MIT No Attribution", "MIT-0", "https://spdx.org/licenses/MIT-0.html"),
  ("No Limit Public License", "NLPL", "https://spdx.org/licenses/NLPL.html"),
  ("The Unlicense", "Unlicense", "https://unlicense.org/"),
  ("Universal Permissive License v1.0", "UPL-1.0", "https://spdx.org/licenses/UPL-1.0.html"),
  ("Do What The F*ck You Want To Public License", "WTFPL", "http://www.wtfpl.net/");

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
