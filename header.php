<?php
require "vendor/autoload.php";
require "scripts/meta.php";
session_start();

$db = new \PDO(
  'mysql:dbname=shadows;host=localhost;charset=utf8mb4',
  'shadows',
  'shadows'
);
$auth = new \Delight\Auth\Auth($db);

/* Login info
Email: baka.off@gmail.com
Pw: 080690
User: Nereare
 */
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
                    <img src="assets/Favicon.svg">
                  </figure>
                </div>

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
    <header class="hero is-primary">
      <div class="hero-body">
        <div class="container has-text-centered">
          <p class="title">
            <?php echo constant("APP_NAME"); ?>
          </p>
          <p class="subtitle">
            Version <?php echo constant("APP_VERSION"); ?>
          </p>
        </div>
      </div>

      <div class="hero-foot">
        <nav class="tabs is-boxed is-centered">
          <div class="container">
            <ul>
              <li class="is-active">
                <a>Play</a>
              </li>
              <li>
                <a>Write</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </header>
    <?php
    }
