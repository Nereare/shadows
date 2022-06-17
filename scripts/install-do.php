<?php
require "../vendor/autoload.php";
require "../scripts/meta.php";
session_start();

function runExec($query, $msg, $db) {
  try {
    $result = $db->exec($query);
  } catch (\PDOException $e) {
    // Database Error
    return [
      "title" => "Database Error",
      "msg" => $e->getMessage(),
      "state" => "danger",
      "fail" => true
    ];
  }
  if ( $result === false ) {
    // Query Error
    return [
      "title" => "Query Error",
      "msg" => "The query affected no rows.",
      "state" => "danger",
      "fail" => true
    ];
  } else {
    // Success
    return [
      "title" => "Query Success",
      "msg" => $msg,
      "state" => "success",
      "fail" => false
    ];
  }
}

$user_data["mysql_username"]   = $_GET["mysql_username"];
$user_data["mysql_password"]   = $_GET["mysql_password"];
$user_data["email_host"]       = $_GET["email_host"];
$user_data["email_port"]       = $_GET["email_port"];
$user_data["email_username"]   = $_GET["email_username"];
$user_data["email_password"]   = $_GET["email_password"];
$user_data["site_baseuri"]     = $_GET["site_baseuri"];
$user_data["user_username"]    = $_GET["user_username"];
$user_data["user_email"]       = $_GET["user_email"];
$user_data["user_password"]    = $_GET["user_password"];
$user_data["user_firstname"]   = $_GET["user_firstname"];
$user_data["user_lastname"]    = $_GET["user_lastname"];
$user_data["user_location"]    = $_GET["user_location"];
$user_data["user_birth"]       = $_GET["user_birth"];
$user_data["user_about"]       = $_GET["user_about"];

$install = [];
$step = 1;

try {
  // Step 1: Connect to MySQL
  $db = new \PDO(
    "mysql:host=localhost;charset=utf8mb4",
    $user_data["mysql_username"],
    $user_data["mysql_password"]
  );
} catch (\PDOException $e) {
  // Step 1 - Error
  $install[$step] = [
    "title" => "Connection Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 1 - Success
$install[$step] = [
  "title" => "Connection Successful",
  "msg" => "Connection with given MySQL user established successfully.",
  "state" => "success"
];

// Step 2: Create database
$step++;
$install[$step] = runExec(
  "CREATE DATABASE IF NOT EXISTS `shadows`
    CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci",
  "Database created successfully.",
  $db
);
if ( $install[$step]["fail"] ) { die( $install ); }

// Step 3: Create user
$step++;
$install[$step] = runExec(
  "CREATE USER IF NOT EXISTS
    'shadows'@'localhost'
    IDENTIFIED BY 'shadows'
    FAILED_LOGIN_ATTEMPTS 3
    PASSWORD_LOCK_TIME 7",
  "User created successfully.",
  $db
);
if ( $install[$step]["fail"] ) { die( $install ); }

// Step 4: Grant user its privileges
$step++;
$install[$step] = runExec(
  "GRANT ALL ON `shadows`.* TO 'shadows'@'localhost'",
  "Privileges granted successfully.",
  $db
);
if ( $install[$step]["fail"] ) { die( $install ); }

// Step 5: Select database
$step++;
$install[$step] = runExec(
  "USE `shadows`",
  "Database selected successfully.",
  $db
);
if ( $install[$step]["fail"] ) { die( $install ); }

// Step 6a: Create Auth tables
$tables = [
  [
    "users",
    "CREATE TABLE IF NOT EXISTS `users` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `email` VARCHAR(249) NOT NULL,
      `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `username` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
      `status` TINYINT UNSIGNED NOT NULL DEFAULT '0',
      `verified` TINYINT UNSIGNED NOT NULL DEFAULT '0',
      `resettable` TINYINT UNSIGNED NOT NULL DEFAULT '1',
      `roles_mask` INT UNSIGNED NOT NULL DEFAULT '0',
      `registered` INT UNSIGNED NOT NULL,
      `last_login` INT UNSIGNED DEFAULT NULL,
      `force_logout` MEDIUMINT UNSIGNED NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    )"
  ],
  [
    "users_confirmations",
    "CREATE TABLE IF NOT EXISTS `users_confirmations` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user_id` INT UNSIGNED NOT NULL,
      `email` VARCHAR(249) NOT NULL,
      `selector` VARCHAR(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `token` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `expires` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `selector` (`selector`),
      KEY `email_expires` (`email`,`expires`),
      KEY `user_id` (`user_id`)
    )"
  ],
  [
    "users_remembered",
    "CREATE TABLE IF NOT EXISTS `users_remembered` (
      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user` INT UNSIGNED NOT NULL,
      `selector` VARCHAR(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `token` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `expires` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `selector` (`selector`),
      KEY `user` (`user`)
    )"
  ],
  [
    "users_resets",
    "CREATE TABLE IF NOT EXISTS `users_resets` (
      `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
      `user` INT UNSIGNED NOT NULL,
      `selector` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `token` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `expires` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `selector` (`selector`),
      KEY `user_expires` (`user`,`expires`)
    )"
  ],
  [
    "users_throttling",
    "CREATE TABLE IF NOT EXISTS `users_throttling` (
      `bucket` VARCHAR(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
      `tokens` FLOAT NOT NULL,
      `replenished_at` INT UNSIGNED NOT NULL,
      `expires_at` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`bucket`),
      KEY `expires_at` (`expires_at`)
    )"
  ],
  [
    "users_profiles",
    "CREATE TABLE IF NOT EXISTS `users_profiles` (
      `id` INT UNSIGNED NOT NULL,
      `first_name` VARCHAR(127) DEFAULT NULL,
      `last_name` VARCHAR(255) DEFAULT NULL,
      `location` VARCHAR(255) DEFAULT NULL,
      `birth` DATE DEFAULT NULL,
      `about` TINYTEXT DEFAULT NULL,
      PRIMARY KEY (`id`)
    )"
  ],
  [
    "adventures",
    "CREATE TABLE IF NOT EXISTS `adventures` (
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
    )"
  ],
  [
    "adventures_variables",
    "CREATE TABLE IF NOT EXISTS `adventures_variables` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `adventure` INT UNSIGNED NOT NULL,
      `name` VARCHAR(31) NOT NULL,
      `type` ENUM('string', 'integer', 'float', 'boolean', 'json') NOT NULL DEFAULT 'string',
      `value` VARCHAR(1023) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `adventure` (`adventure`),
      KEY `name` (`name`)
    )"
  ],
  [
    "adventures_plays",
    "CREATE TABLE IF NOT EXISTS `adventures_plays` (
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
    )"
  ],
  [
    "rooms",
    "CREATE TABLE IF NOT EXISTS `rooms` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
      `adventure` INT UNSIGNED NOT NULL,
      `name` VARCHAR(63) DEFAULT NULL,
      `desc` TEXT DEFAULT NULL,
      `is_lit` BOOLEAN NOT NULL DEFAULT TRUE,
      `has_items` BOOLEAN NOT NULL DEFAULT FALSE,
      `has_checks` BOOLEAN NOT NULL DEFAULT FALSE,
      `has_combats` BOOLEAN NOT NULL DEFAULT FALSE,
      `has_npcs` BOOLEAN NOT NULL DEFAULT FALSE,
      `has_exits` BOOLEAN NOT NULL DEFAULT FALSE,
      PRIMARY KEY (`id`),
      KEY `adventure` (`adventure`),
      KEY `name` (`name`)
    )"
  ],
  [
    "rooms_items",
    "CREATE TABLE IF NOT EXISTS `rooms_items` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
      `room` INT UNSIGNED NOT NULL,
      `is_hidden` BOOLEAN NOT NULL DEFAULT FALSE,
      `desc_shown` TINYTEXT DEFAULT NULL,
      `desc_hidden` TINYTEXT DEFAULT NULL,
      `investigation` TINYINT UNSIGNED DEFAULT NULL,
      `perception` TINYINT UNSIGNED DEFAULT NULL,
      `is_takable` BOOLEAN NOT NULL DEFAULT FALSE,
      PRIMARY KEY (`id`),
      KEY `room` (`room`)
    )"
  ],
  [
    "rooms_checks",
    "CREATE TABLE IF NOT EXISTS `rooms_checks` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
      `room` INT UNSIGNED NOT NULL,
      `skill` VARCHAR(31) NOT NULL,
      `dc` TINYINT UNSIGNED NOT NULL DEFAULT 15,
      `critical_failure` TEXT, # Result if roll was 5+ below DC.
      `normal_failure` TEXT, # Result if roll was below DC.
      `normal_success` TEXT, # Result if roll was equal-to-or-above DC.
      `critical_success` TEXT, # Result if roll was 5+ above DC.
      PRIMARY KEY (`id`),
      KEY `room` (`room`)
    )"
  ],
  [
    "rooms_combats",
    "CREATE TABLE IF NOT EXISTS `rooms_combats` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
      `room` INT UNSIGNED NOT NULL,
      `desc` TINYTEXT NOT NULL,
      `enemies` JSON NOT NULL,
      `is_runnable` BOOLEAN NOT NULL DEFAULT FALSE,
      `is_hideable` BOOLEAN NOT NULL DEFAULT FALSE,
      `stealth_dc` TINYINT UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `room` (`room`)
    )"
  ],
  [
    "rooms_npcs",
    "CREATE TABLE IF NOT EXISTS `rooms_npcs` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
      `npc` INT UNSIGNED NOT NULL,
      `desc` TINYTEXT NOT NULL,
      `gender` VARCHAR(24) NOT NULL,
      `race` VARCHAR(24) NOT NULL,
      `creature` INT UNSIGNED,
      PRIMARY KEY (`id`),
      KEY `npc` (`npc`)
    )"
  ],
  [
    "rooms_exits",
    "CREATE TABLE IF NOT EXISTS `rooms_exits` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `uuid` CHAR(36) NOT NULL,
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
    )"
  ],
  [
    "meta_checks",
    "CREATE TABLE IF NOT EXISTS `meta_checks` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(63) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `name` (`name`)
    )"
  ],
  [
    "meta_items",
    "CREATE TABLE IF NOT EXISTS `meta_items` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `code` VARCHAR(63),
      `name` VARCHAR(63) NOT NULL,
      `desc` TEXT NOT NULL,
      `source` VARCHAR(255),
      `page` TINYINT UNSIGNED,
      PRIMARY KEY (`id`),
      UNIQUE KEY `code` (`code`)
    )"
  ],
  [
    "meta_items TRIGGER",
    "CREATE
      DEFINER='shadows'@'localhost'
      TRIGGER `set_item_code`
      BEFORE INSERT ON `meta_items` FOR EACH ROW
      SET NEW.`code` = CONCAT('IID', UNIX_TIMESTAMP())"
  ]
];

foreach($tables as $v) {
  $step++;
  $install[$step] = runExec(
    $v[1],
    "Table <code>{$v[0]}</code> created successfully.",
    $db
  );
  if ( $install[$step]["fail"] ) { die( $install ); }
}

// Step 6b: Populate `meta_checks` table
$inserts = [
  "Strength check",
  "Strength saving throw",
  "Dexterity check",
  "Dexterity saving throw",
  "Constitution check",
  "Constitution saving throw",
  "Intelligence check",
  "Intelligence saving throw",
  "Wisdom check",
  "Wisdom saving throw",
  "Charisma check",
  "Charisma saving throw",
  "Acrobatics (Dex)",
  "Animal Handling (Wis)",
  "Arcana (Int)",
  "Athletics (Str)",
  "Deception (Cha)",
  "History (Int)",
  "Insight (Wis)",
  "Intimidation (Cha)",
  "Investigation (Int)",
  "Medicina (Wis)",
  "Nature (Int)",
  "Perception (Wis)",
  "Performance (Cha)",
  "Persuasion (Cha)",
  "Religion (Int)",
  "Sleight of Hand (Dex)",
  "Stealth (Dex)",
  "Survival (Wis)",
  "Thieves' Tools (Dex)"
];

$step++;
$count = 0;
try {
  $stmt = $db->prepare( "INSERT INTO `meta_checks` (`name`) VALUES (:value)" );
  foreach($inserts as $v) {
    $count++;
    $stmt->bindParam(":value", $v);
    if ( !$stmt->execute() ) {
      // Step 6b - Query Error
      $install[$step] = [
        "title" => "Query Error",
        "msg" => "The query affected no rows.",
        "state" => "danger"
      ];
      die( json_encode($install) );
    }
  }
} catch (\PDOException $e) {
  // Step 6b - Database Error
  $install[$step] = [
    "title" => "Database Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
}
// Step 6b - Query Error
$install[$step] = [
  "title" => "Table Populated",
  "msg" => "The query affected {$count} row(s).",
  "state" => "success"
];

$auth = new \Delight\Auth\Auth($db);

try {
  // Step 7: Register Admin user
  $step++;
  $uid = $auth->registerWithUniqueUsername(
    $user_data["user_email"],
    $user_data["user_password"],
    $user_data["user_username"]
  );
}
catch (\Delight\Auth\InvalidEmailException $e) {
  // Step 7 - Invalid Email Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "The email was invalid.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\InvalidPasswordException $e) {
  // Step 7 - Invalid Password Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "Password is invalid.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\UserAlreadyExistsException $e) {
  // Step 7 - User Exists Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "The user already exists.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\TooManyRequestsException $e) {
  // Step 7 - Too Many Requests Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "Too many requests, dear. Take a rest...",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\DuplicateUsernameException $e) {
  // Step 7 - Duplicate Username Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "Username already exists.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Exception $e) {
  // Step 7 - Misc Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => "Unknow error.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 7 - Success
$install[$step] = [
  "title" => "Auth Successful",
  "msg" => "Admin user (ID $uid) created successfully.",
  "state" => "success"
];

try {
  // Step 8: Set user as Admin
  $step++;
  $auth->admin()->addRoleForUserById(
    $uid,
    \Delight\Auth\Role::ADMIN
  );
  $auth->admin()->addRoleForUserById(
    $uid,
    \Delight\Auth\Role::MANAGER
  );
} catch (\Exception $e) {
  // Step 8 - Error
  $install[$step] = [
    "title" => "Auth Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 8 - Success
$install[$step] = [
  "title" => "Auth Successful",
  "msg" => "User with ID $uid set as admin successfully.",
  "state" => "success"
];

try {
  // Step 9: Start admin's profile
  $step++;
  $profile = new Nereare\Shadows\Profile($db, $uid);
} catch (\Exception $e) {
  // Step 9 - Error
  $install[$step] = [
    "title" => "Profile Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 9 - Success
$install[$step] = [
  "title" => "Profile Successful",
  "msg" => "Profile for user with ID $uid opened successfully.",
  "state" => "success"
];

try {
  // Step 10: Create admin's profile
  $step++;
  $profile->create(
    $user_data["user_firstname"],
    $user_data["user_lastname"],
    $user_data["user_location"],
    $user_data["user_birth"],
    $user_data["user_about"]
  );
} catch (\Exception $e) {
  // Step 10 - Error
  $install[$step] = [
    "title" => "Profile Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 10 - Success
$install[$step] = [
  "title" => "Profile Successful",
  "msg" => "Profile for user with ID $uid created successfully.",
  "state" => "success"
];

// Step 11 - Set PHPMailer data
$step++;
$admin_code = \Delight\Auth\Auth::createRandomString(64);
$config_file = fopen( "../scripts/config.php", "w" );
$config = "<?php
define(\"APP_MAIL_HOST\", \"{$user_data["email_host"]}\");
define(\"APP_MAIL_PORT\", \"{$user_data["email_port"]}\");
define(\"APP_MAIL_USERNAME\", \"{$user_data["email_username"]}\");
define(\"APP_MAIL_PASSWORD\", \"{$user_data["email_password"]}\");
define(\"SU_VALIDATION\", \"" . hash("sha3-512", $admin_code) . "\");
define(\"SITE_BASEURI\", \"" . $user_data["site_baseuri"] . "\");";
fwrite( $config_file, $config );
fclose( $config_file );
// Step 11 - Success
$install[$step] = [
  "title" => "Config File Created",
  "msg" => "The installation script created the mailing configuration file successfully.",
  "state" => "success"
];

// Step 12 - Send welcome email
$step++;
if ( is_readable( "../scripts/config.php" ) ) {
  include( "../scripts/config.php" );
  $mail = new \PHPMailer\PHPMailer\PHPMailer();
  $mail->isSMTP();
  $mail->Host       = constant("APP_MAIL_HOST");
  $mail->SMTPAuth   = true;
  $mail->Username   = constant("APP_MAIL_USERNAME");
  $mail->Password   = constant("APP_MAIL_PASSWORD");
  $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port       = constant("APP_MAIL_PORT");
  $mail->setFrom(constant("APP_MAIL_USERNAME"), constant("APP_NAME"));
  $mail->addAddress($user_data["user_email"], "Admin");
  $mail->isHTML(true);
  $mail->Subject = "Installation Successful";
  $mail->Body    = "<div>
    <h2 style='font-family: monospace; font-size: 1.25rem; text-align: center; margin: 0 0 1rem 0;'>
      The installation script for your distribution of " . constant("APP_NAME") . " (v" . constant("APP_VERSION") . ") finished successfully!
    </h2>
    <p style='font-family: monospace; margin: 0 0 1rem 0;'>
      The installation of your own distribution of " . constant("APP_NAME") . " went on without problems.
    </p>
    <p style='font-family: monospace; margin: 0 0 1rem 0;'>
      You are the <em>ADMIN</em> of this installation under the username <em>" . $user_data["user_username"] . "</em>.
    </p>
    <p style='font-family: monospace; margin: 0 0 1rem 0;'>
      We hope you keep your password under secure storage. Should you forget it and/or loose it, you may <a href='" . constant("SITE_BASEURI") . "reset.php?code=" . urlencode($admin_code) . "'>reset it here</a>.
      Keep this email secure and do <strong>not</strong> share this link with anyone.
    </p>
    <p style='font-family: monospace; font-size: 0.5rem; margin: 0; width: 100%; text-align: center;'>
      " . constant("APP_NAME") . " &mdash; version " . constant("APP_VERSION") . "
      <br>
      <a href='" . constant("APP_REPO") . "'>Source</a> available under the <a href='" . constant("APP_LICENSE_URI") . "'>" . constant("APP_LICENSE_NAME") . "</a>
    </p>
  </div>";
  $mail->AltBody = "The installation script for your distribution of " . constant("APP_NAME") . " (v" . constant("APP_VERSION") . ") finished successfully!
  ---
  The installation of your own distribution of " . constant("APP_NAME") . " went on without problems.
  You are the &lt;ADMIN&gt; of this installation under the username &lt;" . $user_data["user_username"] . "&gt;.
  We hope you keep your password under secure storage. Should you forget it and/or loose it, you may reset through this link: &lt;" . constant("SITE_BASEURI") . "reset.php?code=" . urlencode($admin_code) . "&gt;. Keep this email secure and do not share this link with anyone.
  ---
  " . constant("APP_NAME") . " - version " . constant("APP_VERSION") . "
  Source available under the " . constant("APP_LICENSE_NAME");
  $mail->send();
  // Step 12 - Success
  $install[$step] = [
    "title" => "Installation Email Sent",
    "msg" => "The installation script emailed the admin successfully.",
    "state" => "success"
  ];
} else {
  // Step 12 - Failure
  $install[$step] = [
    "title" => "Config File Error",
    "msg" => "The mailing configuration file was unreachable.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}

// Step 13 - Success
$step++;
$install[$step] = [
  "title" => "Done",
  "msg" => "App installed. Now you may go to <a href=\".\">the main page</a> to start.",
  "state" => "info"
];

echo json_encode($install);
