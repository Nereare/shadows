<?php
require "vendor/autoload.php";
require "scripts/meta.php";
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
    $install[5] = [
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

$user_data["mysql_username"]  = $_GET["mysql_username"];
$user_data["mysql_password"]  = $_GET["mysql_password"];
$user_data["user_username"]   = $_GET["user_username"];
$user_data["user_email"]      = $_GET["user_email"];
$user_data["user_password"]   = $_GET["user_password"];
$user_data["user_firstname"]  = $_GET["user_firstname"];
$user_data["user_lastname"]   = $_GET["user_lastname"];
$user_data["user_location"]   = $_GET["user_location"];
$user_data["user_birth"]      = $_GET["user_birth"];
$user_data["user_about"]      = $_GET["user_about"];

$install = [];

try {
  // Step 1: Connect to MySQL
  $db = new \PDO(
    "mysql:host=localhost;charset=utf8mb4",
    $user_data["mysql_username"],
    $user_data["mysql_password"]
  );
} catch (\PDOException $e) {
  // Step 1 - Error
  $install[1] = [
    "title" => "Connection Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 1 - Success
$install[1] = [
  "title" => "Connection Successful",
  "msg" => "Connection with given MySQL user established successfully.",
  "state" => "success"
];

// Step 2: Create database
$install[2] = runExec(
  "CREATE DATABASE IF NOT EXISTS `shadows`
    CHARACTER SET = utf8mb4
    COLLATE = utf8mb4_0900_ai_ci",
  "Database created successfully.",
  $db
);
if ( $install[2]["fail"] ) { die( $install ); }

// Step 3: Create user
$install[3] = runExec(
  "CREATE USER IF NOT EXISTS
    'shadows'@'localhost'
    IDENTIFIED BY 'shadows'
    FAILED_LOGIN_ATTEMPTS 3
    PASSWORD_LOCK_TIME 7",
  "User created successfully.",
  $db
);
if ( $install[3]["fail"] ) { die( $install ); }

// Step 4: Grant user its privileges
$install[4] = runExec(
  "GRANT ALL ON `shadows`.* TO 'shadows'@'localhost'",
  "Privileges granted successfully.",
  $db
);
if ( $install[4]["fail"] ) { die( $install ); }

// Step 5: Select database
$install[5] = runExec(
  "USE `shadows`",
  "Database selected successfully.",
  $db
);
if ( $install[5]["fail"] ) { die( $install ); }

// Steps 6-11: Create Auth tables
$tables = [
  6 => [
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
  7 => [
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
  8 => [
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
  9 => [
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
  10 => [
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
  11 => [
    "users_profiles",
    "CREATE TABLE IF NOT EXISTS `users_profiles` (
      `id` INT UNSIGNED NOT NULL,
      `first_name` VARCHAR(127) DEFAULT NULL,
      `last_name` VARCHAR(255) DEFAULT NULL,
      `location` VARCHAR(255) DEFAULT NULL,
      `birth` DATE DEFAULT NULL,
      `about` TEXT DEFAULT NULL,
      PRIMARY KEY (`id`)
    )"
  ]
];

foreach($tables as $i => $v) {
  $install[$i] = runExec(
    $v[1],
    "Table <code>{$v[0]}</code> created successfully.",
    $db
  );
  if ( $install[$i]["fail"] ) { die( $install ); }
}

$auth = new \Delight\Auth\Auth($db);

try {
  // Step 12: Register Admin user
  $uid = $auth->registerWithUniqueUsername(
    $user_data["user_email"],
    $user_data["user_password"],
    $user_data["user_username"]
  );
}
catch (\Delight\Auth\InvalidEmailException $e) {
  // Step 12 - Invalid Email Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "The email was invalid.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\InvalidPasswordException $e) {
  // Step 12 - Invalid Password Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "Password is invalid.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\UserAlreadyExistsException $e) {
  // Step 12 - User Exists Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "The user already exists.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\TooManyRequestsException $e) {
  // Step 12 - Too Many Requests Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "Too many requests, dear. Take a rest...",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Delight\Auth\DuplicateUsernameException $e) {
  // Step 12 - Duplicate Username Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "Username already exists.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
catch (\Exception $e) {
  // Step 12 - Misc Error
  $install[12] = [
    "title" => "Auth Error",
    "msg" => "Unknow error.",
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 12 - Success
$install[12] = [
  "title" => "Auth Successful",
  "msg" => "Admin user (ID $uid) created successfully.",
  "state" => "success"
];

try {
  // Step 13: Set user as Admin
  $auth->admin()->addRoleForUserById(
    $uid,
    \Delight\Auth\Role::ADMIN
  );
} catch (\Exception $e) {
  // Step 13 - Error
  $install[13] = [
    "title" => "Auth Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 13 - Success
$install[13] = [
  "title" => "Auth Successful",
  "msg" => "User with ID $uid set as admin successfully.",
  "state" => "success"
];

try {
  // Step 14: Start admin's profile
  $profile = new \Nereare\Profile\Profile($db, $uid);
} catch (\Exception $e) {
  // Step 14 - Error
  $install[14] = [
    "title" => "Profile Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 14 - Success
$install[14] = [
  "title" => "Profile Successful",
  "msg" => "Profile for user with ID $uid opened successfully.",
  "state" => "success"
];

try {
  // Step 15: Create admin's profile
  $profile->create(
    $user_data["user_firstname"],
    $user_data["user_lastname"],
    $user_data["user_location"],
    $user_data["user_birth"],
    $user_data["user_about"]
  );
} catch (\Exception $e) {
  // Step 15 - Error
  $install[15] = [
    "title" => "Profile Error",
    "msg" => $e->getMessage(),
    "state" => "danger"
  ];
  die( json_encode($install) );
}
// Step 15 - Success
$install[15] = [
  "title" => "Profile Successful",
  "msg" => "Profile for user with ID $uid created successfully.",
  "state" => "success"
];

// Step 15 - Success
$install[16] = [
  "title" => "Done",
  "msg" => "App installed. Now you may go to <a href=\".\">the main page</a> to start.",
  "state" => "info"
];

echo json_encode($install);
