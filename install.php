<?php
require "vendor/autoload.php";
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
    <link href="node_modules/simplemde/dist/simplemde.min.css" rel="stylesheet" type="text/css">
    <link href="styles/main.css" rel="stylesheet" type="text/css">

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/simplemde/dist/simplemde.min.js"></script>
    <script src="js/install.js"></script>
  </head>

  <body>
    <header class="hero is-primary has-text-centered">
      <div class="hero-body">
        <p class="title">
          <?php echo constant("APP_NAME"); ?>
        </p>
        <p class="subtitle">
          v.<?php echo constant("APP_VERSION"); ?>
        </p>
      </div>
    </header>

    <section class="section">
      <div class="container">
        <div class="box is-info">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-download"></i>
              </span>
              <span>Installation</span>
            </span>
          </h2>

          <div class="content">
            <p>
              Welcome to the <strong><?php echo constant("APP_NAME"); ?></strong> installer.
            </p>
            <p>
              This wizard will guide you through the installation process. We
              advise you to take this moment to fetch your database login
              information, which will be needed for a successful setup.
            </p>
            <p>
              Note that this project is available under the
              <a href="<?php echo constant("APP_LICENSE_URI"); ?>"><?php echo constant("APP_LICENSE_NAME"); ?></a>,
              which means that you must not use this project in violation of any
              <a href="https://www.un.org/en/about-us/universal-declaration-of-human-rights">Human Right</a>.
            </p>
            <p>
              You can read further about this project, as well as ask questions
              and make requests, at our
              <a href="<?php echo constant("APP_REPO"); ?>">repository</a>.
            </p>
          </div>

          <div class="notification is-warning is-light">
            <p>
              All fields whose label has an asterisk (<code>*</code>) are
              required!
              Failing to fill these will stop the installation logic short.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="box">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-database-lock"></i>
              </span>
              <span>Database Connection</span>
            </span>
          </h2>
          <p class="subtitle">Setting up the database for the project</p>

          <div class="notification is-info is-light">
            <p>
              Take this time to retrieve <code>username</code> and
              <code>password</code> for the database. The database user must have
              <code>CREATE</code>, <code>CREATE USER</code>, <code>INSERT</code>,
              <code>SELECT</code>, and <code>UPDATE</code> privileges on a
              <code>*</code> scale, in order for the installation wizard to
              succeed its queries.
            </p>
            <p>
              Please note that this project uses <a href="https://www.mysql.com/">MySQL</a>
              as its database system.
            </p>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">MySQL Username*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="mysql-username" type="text" placeholder="MySQL User username">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">MySQL Password*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="mysql-password" type="password" placeholder="MySQL User password">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="box">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-email"></i>
              </span>
              <span>Email Settings</span>
            </span>
          </h2>
          <p class="subtitle">Settings for the email server, to be used by the <code>PHPMailer</code> package.</p>

          <div class="notification is-info is-light">
            <p>
              The mail-handling package will use SMTP as the email protocol.
              Please note this.
            </p>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Email Server*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="email-host" type="text" placeholder="mail.site.com">
            </div>
            <div class="control">
              <button class="button is-static" tabindex="-1">Server Port*</button>
            </div>
            <div class="control">
              <input class="input required" id="email-port" type="number" placeholder="465">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Email Username*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="email-username" type="text" placeholder="user@site.com">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Email Password*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="email-password" type="password" placeholder="The password to the user above">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="box">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-web"></i>
              </span>
              <span>Site Settings</span>
            </span>
          </h2>
          <p class="subtitle">Settings about the site itself and its hosting.</p>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Base URI*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="site-baseuri" type="text" placeholder="https://site.com/">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="box">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-account"></i>
              </span>
              <span>User Data</span>
            </span>
          </h2>
          <p class="subtitle">
            The information below regards your user in the app itself.
            This user will have the <code>ADMIN</code> privilege.
          </p>

          <div class="divider">
            <div>
              &bull;&nbsp;&bull;&nbsp;&bull;
            </div>
          </div>

          <h3 class="title is-4">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-lock"></i>
              </span>
              <span>User Login</span>
            </span>
          </h3>

          <p class="help">The username, once set, cannot be changed!</p>
          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Admin Username*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="user-username" type="text" placeholder="Admin User username">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Admin Email*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="user-email" type="email" placeholder="Admin Email">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Admin Password*</button>
            </div>
            <div class="control is-expanded">
              <input class="input required" id="user-password" type="password" placeholder="Admin User password">
            </div>
          </div>

          <div class="divider">
            <div>
              &bull;&nbsp;&bull;&nbsp;&bull;
            </div>
          </div>

          <h3 class="title is-4">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-face-woman-profile"></i>
              </span>
              <span>User Profile</span>
            </span>
          </h3>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Name</button>
            </div>
            <div class="control is-expanded">
              <input class="input" id="user-firstname" type="text" placeholder="First name">
            </div>
            <div class="control is-expanded">
              <input class="input" id="user-lastname" type="text" placeholder="Middle and last names">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Location</button>
            </div>
            <div class="control is-expanded">
              <input class="input" id="user-location" type="text" placeholder="Your location">
            </div>
          </div>

          <div class="field has-addons">
            <div class="control">
              <button class="button is-static" tabindex="-1">Date of Birth</button>
            </div>
            <div class="control is-expanded">
              <input class="input" id="user-birth" type="date">
            </div>
          </div>

          <div class="field">
            <div class="control">
              <textarea class="textarea has-fixed-size" id="profile-about" placeholder="Tell us something about you"></textarea>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="box">
          <h2 class="title is-3">
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-content-save"></i>
              </span>
              <span>Finish</span>
            </span>
          </h2>
          <p class="subtitle">
            Once you fill all the required data, as well as any optional data
            you see fit, click the button bellow to install the app.
          </p>

          <div class="field">
            <div class="control is-expanded">
              <button class="button is-success is-fullwidth" id="install">Install</button>
            </div>
          </div>

          <div id="result"></div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="content has-text-centered">
        <p>
          <strong><?php echo constant("APP_NAME"); ?></strong>
          (<code>v.<?php echo constant("APP_VERSION"); ?></code>)
          by
          <a href="https://nereare.com"><?php echo constant("APP_AUTHOR"); ?></a>.
        </p>
        <p>
          The <a href="<?php echo constant("APP_REPO"); ?>">source code</a> is available under the
          <a href="<?php echo constant("APP_LICENSE_URI"); ?>">
            <?php echo constant("APP_LICENSE_NAME"); ?>
          </a>
          .
        </p>
      </div>
    </footer>
  </body>
</html>
