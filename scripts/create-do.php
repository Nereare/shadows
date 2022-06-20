<?php
use Nereare\Shadows\Adventure;
require "../vendor/autoload.php";
require "../scripts/meta.php";
require "../scripts/config.php";
session_start();

if ( isset($_GET["do"]) ) { $action = $_GET["do"]; }
else { $action = null; }

// Start DB
try {
  $db = new \PDO(
    "mysql:dbname=shadows;host=localhost;charset=utf8mb4",
    "shadows",
    "shadows"
  );
} catch (\PDOException $e) { die("500"); }

// Get user data
$auth = new \Delight\Auth\Auth($db);
$uid = $auth->getUserID();

// Select which process is to be run:
switch ( $action ) {
  case "adventure":
    // Check sent data
    if ( !isset( $_GET["name"] ) ) { die("424"); }
    if ( !isset( $_GET["cover"] ) ) { die("424"); }
    if ( !isset( $_GET["setting"] ) ) { die("424"); }
    if ( !isset( $_GET["level_start"] ) ) { die("424"); }
    if ( !isset( $_GET["level_end"] ) ) { die("424"); }
    if ( !isset( $_GET["pcs"] ) ) { die("424"); }
    if ( !isset( $_GET["version"] ) ) { die("424"); }
    if ( !isset( $_GET["advancement"] ) ) { die("424"); }
    if ( !isset( $_GET["is_public"] ) ) { die("424"); }
    if ( !isset( $_GET["dev_status"] ) ) { die("424"); }
    if ( !isset( $_GET["tw"] ) ) { die("424"); }
    if ( !isset( $_GET["description"] ) ) { die("424"); }

    // Transpose needed data to adventure array
    $adv["name"] = $_GET["name"];
    $adv["cover"] = $_GET["cover"];
    $adv["setting"] = $_GET["setting"];
    $adv["level_init"] = $_GET["level_start"];
    $adv["level_end"] = $_GET["level_end"];
    $adv["pcs"] = $_GET["pcs"];
    $adv["version"] = $_GET["version"];
    $adv["advancement"] = $_GET["advancement"];
    $adv["is_public"] = $_GET["is_public"];
    $adv["status"] = $_GET["dev_status"];
    $adv["triggers"] = $_GET["tw"];
    $adv["desc"] = $_GET["description"];
    // Set Author
    $adv["author"] = $auth->getUserId();

    // Try and create the Adventure
    try { $adventure = new Nereare\Shadows\Adventure($db, null, $adv); }
    catch (\Exception $e) { die("500"); }
    finally { exit("0"); }
    break;
  default:
    echo "404";
    break;
}
