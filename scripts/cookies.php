<?php
require "../vendor/autoload.php";
require "../scripts/meta.php";
session_start();

setcookie("accept_cookies", $_GET["accept"], time() + 30*24*60*60 );
$_SESSION["accept_cookies"] = true;
