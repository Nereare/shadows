<?php
require "../vendor/autoload.php";
require "../scripts/meta.php";
require "../scripts/config.php";
session_start();

if ( isset($_GET["do"]) ) { $action = $_GET["do"]; }
else { $action = null; }

try {
  $db = new \PDO(
    "mysql:dbname=shadows;host=localhost;charset=utf8mb4",
    "shadows",
    "shadows"
  );
} catch (\PDOException $e) { die("500"); }

$auth = new \Delight\Auth\Auth($db);
$mail = new \PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host       = constant("APP_MAIL_HOST");
$mail->SMTPAuth   = true;
$mail->Username   = constant("APP_MAIL_USERNAME");
$mail->Password   = constant("APP_MAIL_PASSWORD");
$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = constant("APP_MAIL_PORT");
$mail->setFrom(constant("APP_MAIL_USERNAME"), constant("APP_NAME"));
$mail->isHTML(true);

// Select which process is to be run:
switch ( $action ) {
  case "create":
    if ( isset($_GET["username"]) && isset($_GET["email"]) ) {
      try {
        $password = \Delight\Auth\Auth::createRandomString(12);
        $uid = $auth->admin()->createUserWithUniqueUsername(
          $_GET["email"],
          $password,
          $_GET["username"],
        );
        $profile = new Nereare\Shadows\Profile($db, $uid);
        $profile->create("", "", "", "", "");
        $mail->addAddress($_GET["email"], "New User");
        $mail->Subject = "User created";
        $mail->Body    = "<div>
          <h2 style='font-family: monospace; font-size: 1.25rem; text-align: center; margin: 0 0 1rem 0;'>
            Welcome to " . constant("APP_NAME") . "!
          </h2>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            The site administrator added you to it, with the username <strong>" . $_GET["username"] . "</strong>.
          </p>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            The script created a random password for your first login: <strong>" . $password . "</strong>.
          </p>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            Upon your first login, we <em>strongly</em> suggest you change your password.
            The randomly generated one was not shared with the Admin, but it still should be updated.
          </p>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            Happy adventures!
          </p>
          <p style='font-family: monospace; font-size: 0.5rem; margin: 0; width: 100%; text-align: center;'>
            " . constant("APP_NAME") . " &mdash; version " . constant("APP_VERSION") . "
            <br>
            <a href='" . constant("APP_REPO") . "'>Source</a> available under the <a href='" . constant("APP_LICENSE_URI") . "'>" . constant("APP_LICENSE_NAME") . "</a>
          </p>
        </div>";
        $mail->AltBody = "Welcome to " . constant("APP_NAME") . "!
        ---
        The site administrator added you to it, with the username &lt;" . $_GET["username"] . "&gt;.
        The script created a random password for your first login: &lt;" . $password . "&gt;.
        Upon your first login, we strongly suggest you change your password. The randomly generated one was not shared with the Admin, but it still should be updated.
        Happy adventures!
        ---
        " . constant("APP_NAME") . " - version " . constant("APP_VERSION") . "
        Source available under the " . constant("APP_LICENSE_NAME");
        $mail->send();

        echo "0";
      }
      catch (\Delight\Auth\InvalidEmailException $e) { die("401"); }
      catch (\Delight\Auth\InvalidPasswordException $e) { die("401"); }
      catch (\Delight\Auth\UserAlreadyExistsException $e) { die("401"); }
      catch (\Delight\Auth\DuplicateUsernameException $e) { die("401"); }
      catch (\Delight\Auth\ConfirmationRequestNotFound $e) { die("500"); }
      catch (\Delight\Auth\TooManyRequestsException $e) { die("429"); }
      catch (Exception $e) { echo $e->getMessage(); die("418"); }
    } else { die("401"); }
    break;
  case "upgrade":
    if ( isset($_GET["uid"]) ) {
      try {
        $auth->admin()->addRoleForUserById($_GET["uid"], \Delight\Auth\Role::MANAGER);
        echo "0";
      }
      catch (\Delight\Auth\UnknownIdException $e) { die("401"); }
    } else { die("401"); }
    break;
  case "downgrade":
    if ( isset($_GET["uid"]) ) {
      try {
        $auth->admin()->removeRoleForUserById($_GET["uid"], \Delight\Auth\Role::MANAGER);
        echo "0";
      }
      catch (\Delight\Auth\UnknownIdException $e) { die("401"); }
    } else { die("401"); }
    break;
  case "upgrade":
    if ( isset($_GET["uid"]) ) {
      try {
        $auth->admin()->addRoleForUserById($_GET["uid"], \Delight\Auth\Role::MANAGER);
        echo "0";
      }
      catch (\Delight\Auth\UnknownIdException $e) { die("401"); }
    } else { die("401"); }
    break;
  case "reset":
    if ( isset($_GET["uid"]) ) {
      try {
        $password = \Delight\Auth\Auth::createRandomString(12);
        $profile = new Nereare\Shadows\Profile($db, $_GET["uid"]);
        $email = $profile->getEmail();
        $auth->admin()->changePasswordForUserById($_GET["uid"], $password);

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host       = constant("APP_MAIL_HOST");
        $mail->SMTPAuth   = true;
        $mail->Username   = constant("APP_MAIL_USERNAME");
        $mail->Password   = constant("APP_MAIL_PASSWORD");
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = constant("APP_MAIL_PORT");
        $mail->setFrom(constant("APP_MAIL_USERNAME"), constant("APP_NAME"));
        $mail->addAddress($email, "Oblivious User");
        $mail->isHTML(true);
        $mail->Subject = "Password Reset";
        $mail->Body    = "<div>
          <h2 style='font-family: monospace; font-size: 1.25rem; text-align: center; margin: 0 0 1rem 0;'>
            Have we forgotten our password, have we?
          </h2>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            Here is a new password for you: <strong>" . $password . "</strong>
          </p>
          <p style='font-family: monospace; margin: 0 0 1rem 0;'>
            When you first login with this password, change it. And try not to forget your new one, yes?
          </p>
          <p style='font-family: monospace; font-size: 0.5rem; margin: 0; width: 100%; text-align: center;'>
            " . constant("APP_NAME") . " &mdash; version " . constant("APP_VERSION") . "
            <br>
            <a href='" . constant("APP_REPO") . "'>Source</a> available under the <a href='" . constant("APP_LICENSE_URI") . "'>" . constant("APP_LICENSE_NAME") . "</a>
          </p>
        </div>";
        $mail->AltBody = "Have we forgotten our password, have we?
        ---
        Here is a new password for you: " . $password . "
        When you first login with this password, change it. And try not to forget your new one, yes?
        ---
        " . constant("APP_NAME") . " - version " . constant("APP_VERSION") . "
        Source available under the " . constant("APP_LICENSE_NAME");
        $mail->send();

        echo "0";
      }
      catch (\Delight\Auth\UnknownIdException $e) { die("401"); }
      catch (\Delight\Auth\InvalidPasswordException $e) { die("401"); }
    } else { die("401"); }
    break;
  default:
    echo "404";
    break;
}
