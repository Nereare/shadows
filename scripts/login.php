<?php
require "../vendor/autoload.php";
require "../scripts/meta.php";
session_start();

$db = new \PDO(
  'mysql:dbname=shadows;host=localhost;charset=utf8mb4',
  'shadows',
  'shadows'
);
$auth = new \Delight\Auth\Auth($db);

// Select which process is to be run:
switch ( $_GET["do"] ) {
  case "login":
    try {
      $remember = null;
      if ( $_GET["remember"] ) {
        $remember = (int) (60 * 60 * 24 * 365.25);
      }
      $auth->loginWithUsername(
        $_GET['username'],
        $_GET['password'],
        $remember
      );
      echo "0";
    }
    catch (\Delight\Auth\UnknownUsernameException $e) { die("401"); }
    catch (\Delight\Auth\AmbiguousUsernameException $e) { die("401"); }
    catch (\Delight\Auth\InvalidPasswordException $e) { die("401"); }
    catch (\Delight\Auth\EmailNotVerifiedException $e) { die("401"); }
    catch (\Delight\Auth\TooManyRequestsException $e) { die("418"); }
    break;
  default:
    echo "400";
    break;
}