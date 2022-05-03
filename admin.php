<?php
/**
 * This string, if set, will be used to include a custom Javascript file to the
 * page.
 * @var string  The Javascript filename without the ".js" extension.
 */
$script = "admin";
/**
 * The name of the current page, if any, for checking which is the active nav
 * menu link.
 * @var string  The slug of the current page.
 */
if ( !isset( $_GET["func"] ) ) { $_GET["func"] = null; }
switch ( $_GET["func"] ) {
  case "adduser":
    $page = "adduser";
    break;
  default:
    $page = "listusers";
    break;
}
require_once "header.php";

if (
  $auth->isLoggedIn() &&
  $auth->hasRole(\Delight\Auth\Role::MANAGER)
) {
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

      <?php
      switch ($page) {
        case "adduser":
      ?>
      <!-- Add User -->
      <h2 class="title is-3">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-account-plus"></i>
          </span>
          <span>Add User</span>
        </span>
      </h2>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabIndex="-1">
            <span class="icon">
              <i class="mdi mdi-at"></i>
            </span>
            <span>Username</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="username" type="text" placeholder="Enter a username">
        </div>
      </div>

      <div class="field has-addons">
        <div class="control">
          <button class="button is-static" tabIndex="-1">
            <span class="icon">
              <i class="mdi mdi-email"></i>
            </span>
            <span>Email</span>
          </button>
        </div>
        <div class="control is-expanded">
          <input class="input" id="email" type="text" placeholder="Enter a valid email">
        </div>
      </div>

      <div class="field">
        <div class="control is-expanded">
          <button class="button is-primary is-fullwidth" id="create-button">
            Create User
          </button>
        </div>
      </div>
      <?php
          break;
        default:
      ?>
      <!-- List Users -->
      <h2 class="title is-3">
        <span class="icon-text">
          <span class="icon">
            <i class="mdi mdi-account-group"></i>
          </span>
          <span>Users</span>
        </span>
      </h2>

      <div class="content has-text-centered">
        <p>
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-face-woman-profile"></i>
            </span>
            <span>Visit user's profile</span>
          </span>
          <?php if ($auth->hasRole(\Delight\Auth\Role::ADMIN)) { ?>
          &bull;
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-account-cog"></i>
            </span>
            <span>User is <code>ADMIN</code> and can't have privileges changed</span>
          </span>
          &bull;
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-account-arrow-up"></i>
            </span>
            <span>Upgrade user to <code>MANAGER</code></span>
          </span>
          &bull;
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-account-arrow-down"></i>
            </span>
            <span>Downgrade user from <code>MANAGER</code></span>
          </span>
          <?php } ?>
          &bull;
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-lock-clock"></i>
            </span>
            <span>Reset this user's password</span>
          </span>
          &bull;
          <span class="icon-text">
            <span class="icon">
              <i class="mdi mdi-account-off"></i>
            </span>
            <span>Remove user</span>
          </span>
        </p>
      </div>

      <table class="table is-striped is-hoverable is-fullwidth">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $stmt = $db->prepare(
            "SELECT
              `users`.`id`, `username`, `email`, `first_name`, `last_name`
              FROM `users`, `users_profiles`
              WHERE `users`.`id` = `users_profiles`.`id`
              ORDER BY `users`.`id`"
          );
          $stmt->execute();
          $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
          foreach ($users as $key => $user) {
          ?>
          <tr class="user-row">
            <th><?php echo $user["id"]; ?></th>
            <td>
              <span class="icon-text">
                <span class="icon">
              <?php
              try {
                if ($auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::ADMIN)) {
              ?>
                  <i class="mdi mdi-account-group"></i>
              <?php
            } elseif ($auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::MANAGER)) {
              ?>
                  <i class="mdi mdi-account-supervisor"></i>
              <?php
                } else {
              ?>
                  <i class="mdi mdi-account"></i>
              <?php
                }
              ?>
              <?php
              } catch (\Exception $e) {
              ?>
                  <i class="mdi mdi-account-alert"></i>
              <?php
              }
              ?>
                </span>
                <span><?php echo $user["username"]; ?></span>
              </span>
            </td>
            <td><a href="mailto:<?php echo $user["email"]; ?>"><?php echo $user["email"]; ?></a></td>
            <td><?php echo $user["first_name"]; ?> <?php echo $user["last_name"]; ?></td>
            <td>
              <div class="field has-addons">
                <div class="control">
                  <a class="button is-small is-link" href="profile.php?uid=<?php echo $user["id"]; ?>">
                    <span class="icon">
                      <i class="mdi mdi-account-eye mdi-24px"></i>
                    </span>
                  </a>
                </div>
                <div class="control">
                  <?php if ( $auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::ADMIN) ) { ?>
                  <button class="button is-small" disabled>
                    <span class="icon">
                      <i class="mdi mdi-lock-clock mdi-24px"></i>
                    </span>
                  </button>
                  <?php } else { ?>
                  <button class="button is-small is-primary password-reset" data-id="<?php echo $user["id"]; ?>">
                    <span class="icon">
                      <i class="mdi mdi-lock-clock mdi-24px"></i>
                    </span>
                  </button>
                  <?php } ?>
                </div>
                <?php if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) { ?>
                <div class="control">
                  <?php if ( $auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::ADMIN) ) { ?>
                  <button class="button is-small" disabled>
                    <span class="icon">
                      <i class="mdi mdi-account-cog mdi-24px"></i>
                    </span>
                  </button>
                  <?php } elseif ( $auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::MANAGER) ) { ?>
                  <button class="button is-small is-warning downgrade" data-id="<?php echo $user["id"]; ?>">
                    <span class="icon">
                      <i class="mdi mdi-account-arrow-down mdi-24px"></i>
                    </span>
                  </button>
                  <?php } else { ?>
                  <button class="button is-small is-success upgrade" data-id="<?php echo $user["id"]; ?>">
                    <span class="icon">
                      <i class="mdi mdi-account-arrow-up mdi-24px"></i>
                    </span>
                  </button>
                  <?php } ?>
                </div>
                <?php } ?>
                <div class="control">
                  <?php if ( $auth->admin()->doesUserHaveRole($user["id"], \Delight\Auth\Role::ADMIN) ) { ?>
                  <button class="button is-small" disabled>
                    <span class="icon">
                      <i class="mdi mdi-account-off mdi-24px"></i>
                    </span>
                  </button>
                  <?php } else { ?>
                  <button class="button is-small is-danger remove" data-id="<?php echo $user["id"]; ?>">
                    <span class="icon">
                      <i class="mdi mdi-account-off mdi-24px"></i>
                    </span>
                  </button>
                  <?php } ?>
                </div>
              </div>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php
          break;
      }
      ?>
    </div>
  </div>
</main>

<?php
}
require_once "footer.php";
?>
