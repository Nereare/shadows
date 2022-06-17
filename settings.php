<?php
/**
 * This string, if set, will be used to include a custom Javascript file to the
 * page.
 * @var string  The Javascript filename without the ".js" extension.
 */
$script = "settings";
/**
 * The name of the current page, if any, for checking which is the active nav
 * menu link.
 * @var string  The slug of the current page.
 */
$page = "settings";
require_once "header.php";

if ( $auth->isLoggedIn() ) {
  $profile  = new Nereare\Shadows\Profile($db, $auth->getUserId());
  $data     = $profile->fetch();
?>

<main class="section">
  <div class="container">
    <div class="box">
      <div class="notification is-light is-hidden" id="notification">
        <button class="delete"></button>
        <p>
          Primar lorem ipsum dolor sit amet, consectetur
          adipiscing elit lorem ipsum dolor. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur.
        </p>
      </div>

      <h2 class="title is-3">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-cog"></i>
          </span>
          <span>Settings</span>
        </span>
      </h2>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-numeric mdi-18px"></i>
            </span>
            <span>User ID</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" type="text" id="user-uid" value="<?php echo $profile->getUid(); ?>" readonly>
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-at mdi-18px"></i>
            </span>
            <span>Username</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" type="text" value="<?php echo $profile->getUsername(); ?>" readonly>
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-email mdi-18px"></i>
            </span>
            <span>Email</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" type="text" value="<?php echo $profile->getEmail(); ?>" readonly>
        </div>
      </div>

      <div class="divider">
        <div class="">
          &bull;&nbsp;&bull;&nbsp;&bull;
        </div>
      </div>

      <h3 class="title is-4">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-lock"></i>
          </span>
          <span>Change Password</span>
        </span>
      </h3>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-lock-clock mdi-18px"></i>
            </span>
            <span>Old Password</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="password-old" type="password" placeholder="Old password">
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-lock-plus mdi-18px"></i>
            </span>
            <span>New Password</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="password-new1" type="password" placeholder="New password">
        </div>
        <div class="control is-expanded">
          <input class="input" id="password-new2" type="password" placeholder="Repeat new password">
        </div>
      </div>

      <div class="field">
        <div class="control is-expanded">
          <button class="button is-primary is-fullwidth" id="password-button">
            Change password
          </button>
        </div>
      </div>

      <div class="divider">
        <div class="">
          &bull;&nbsp;&bull;&nbsp;&bull;
        </div>
      </div>

      <h3 class="title is-4">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-face-woman-profile"></i>
          </span>
          <span>Profile</span>
        </span>
      </h3>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-account mdi-18px"></i>
            </span>
            <span>Name</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="profile-firstname" type="text" value="<?php echo $profile->get("first_name"); ?>" placeholder="First name">
        </div>
        <div class="control is-expanded">
          <input class="input" id="profile-lastname" type="text" value="<?php echo $profile->get("last_name"); ?>" placeholder="Middle and Last names">
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-map mdi-18px"></i>
            </span>
            <span>Location</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="profile-location" type="text" value="<?php echo $profile->get("location"); ?>" placeholder="Location">
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabindex="-1">
            <span class="icon">
              <i class="mdi mdi-cake-variant mdi-18px"></i>
            </span>
            <span>Date of Birth</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="profile-birth" type="date" value="<?php echo $profile->get("birth"); ?>">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <textarea class="textarea has-fixed-size" id="profile-about" placeholder="Tell us something about you"></textarea>
          <script>
          var simplemde = new SimpleMDE({
            element: $("#profile-about")[0],
            spellChecker: false
          });
          simplemde.value("<?php echo str_replace("\"", "\\\"", $profile->get("about")); ?>");
          </script>
        </div>
      </div>

      <div class="field">
        <div class="control is-expanded">
          <button class="button is-primary is-fullwidth" id="update-button">
            Update Profile
          </button>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
}
require_once "footer.php";
?>
