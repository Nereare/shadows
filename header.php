<?php
require "scripts/meta.php";
session_start();
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
    <script src="node_modules/clipboard/dist/clipboard.min.js"></script>
    <script src="js/main.js"></script>
  </head>

  <body>
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
