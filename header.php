<?php
require "vendor/autoload.php";
require "scripts/meta.php";
session_start();

try {
  $db = new \PDO(
    'mysql:dbname=shadows;host=localhost;charset=utf8mb4',
    'shadows',
    'shadows'
  );
} catch (\PDOException $e) { die("500"); }
$auth = new \Delight\Auth\Auth($db);
$md   = new Parsedown();
$md->setSafeMode(true);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo constant("APP_NAME"); ?></title>

    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#632626">
    <link rel="shortcut icon" href="favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#632626">
    <meta name="msapplication-config" content="favicon/browserconfig.xml">
    <meta name="theme-color" content="#632626">

    <link href="node_modules/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
    <link href="node_modules/typeface-montserrat/index.css" rel="stylesheet" type="text/css">
    <link href="node_modules/typeface-roboto-mono/index.css" rel="stylesheet" type="text/css">
    <link href="node_modules/normalize.css/normalize.css" rel="stylesheet" type="text/css">
    <link href="styles/main.css" rel="stylesheet" type="text/css">

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body>

    <?php
    if ( !$auth->isLoggedIn() ) {
    ?>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns is-centered">
            <div class="column is-6">
              <div class="box">
                <div class="has-text-centered">
                  <figure class="image is-128x128 is-inline-block">
                    <img src="assets/Logo.svg">
                  </figure>
                </div>

                <?php
                if ( isset( $_GET["reply"] ) && $_GET["reply"] != "0" ) {
                  $reply = [
                    "401" => "Wrong username and/or password.",
                    "429" => "What are you trying? To brute-force me into opening up to you? Such an abuser...",
                    "418" => "But I am but a humble teapot...",
                    "500" => "The server seems to be a little bit sleepy. Try again."
                  ];
                ?>
                <div class="notification is-danger is-light">
                  <button class="delete"></button>
                  <p><?php echo $reply[ $_GET["reply"] ]; ?></p>
                </div>
                <?php
                }
                ?>

                <div class="field">
                  <label for="login-user" class="label">Email</label>
                  <div class="control has-icons-left">
                    <input type="text" class="input" id="login-user" placeholder="Username">
                    <span class="icon is-small is-left">
                      <i class="mdi mdi-account"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label for="login-pw" class="label">Password</label>
                  <div class="control has-icons-left">
                    <input type="password" class="input" id="login-pw" placeholder="Password">
                    <span class="icon is-small is-left">
                      <i class="mdi mdi-lock"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <input type="checkbox" class="is-checkradio" id="login-remember">
                  <label for="login-remember">Remember Me</label>
                </div>

                <div class="field is-expanded">
                  <button class="button is-success is-fullwidth" id="login-do">
                    Login
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="js/login.js"></script>
    </section>
    <?php
    } else {
    ?>
    <nav class="navbar is-primary has-shadow" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a class="navbar-item" href=".">
          <img class="mr-2" src="assets/Logo-White.svg">
          <?php echo constant("APP_NAME"); ?>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="main-nav">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="main-nav" class="navbar-menu">
        <div class="navbar-end">
          <a class="navbar-item">
            <span class="icon">
              <i class="mdi mdi-gamepad-variant"></i>
            </span>
            <span>Play</span>
          </a>
          <a class="navbar-item">
            <span class="icon">
              <i class="mdi mdi-pencil"></i>
            </span>
            <span>Write</span>
          </a>
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
              <span class="icon">
                <i class="mdi mdi-account"></i>
              </span>
              <span><?php echo $auth->getUsername(); ?></span>
            </a>

            <div class="navbar-dropdown">
              <a class="navbar-item" href="profile.php">
                <span class="icon">
                  <i class="mdi mdi-face-woman-profile"></i>
                </span>
                <span>Profile</span>
              </a>
              <a class="navbar-item">
                <span class="icon">
                  <i class="mdi mdi-cog"></i>
                </span>
                <span>Settings</span>
              </a>
              <a class="navbar-item">
                <span class="icon">
                  <i class="mdi mdi-library"></i>
                </span>
                <span>My Tales</span>
              </a>
              <hr class="navbar-divider">
              <a id="logout-button" class="navbar-item">
                <span class="icon">
                  <i class="mdi mdi-logout-variant"></i>
                </span>
                <span>Logout</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <?php
    }
