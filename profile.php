<?php
require_once "header.php";

if ( $auth->isLoggedIn() ) {
  if ( isset( $_GET["uid"] ) ) { $uid = $_GET["uid"]; }
  else { $uid = $auth->getUserId(); }

  $profile  = new Nereare\Profile\Profile($db, $uid);
  $data     = $profile->fetch();
  $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $data["email"] ) ) ) . "?d=retro&s=128";
?>

<main class="section">
  <div class="container">

    <div class="card">
      <div class="card-image">
        <figure class="image is-4by1">
          <img src="https://random.imagecdn.app/2200/900" alt="Placeholder image">
        </figure>
      </div>
      <div class="card-content">
        <div class="media">
          <div class="level">
            <div class="media-left">
              <figure class="image is-128x128">
                <img class="is-rounded" src="<?php echo $grav_url; ?>" alt="Placeholder image">
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-3">
                <?php echo ( $data["first_name"] ) ? $data["first_name"] : "&mdash;"; ?>
                <?php echo ( $data["last_name"] ) ? $data["last_name"] : ""; ?>
              </p>
              <p class="subtitle is-5">@<?php echo $data["username"]; ?></p>
            </div>
          </div>
        </div>

        <div class="columns">
          <div class="column has-text-centered">
            <p class="title is-6">
              <span class="icon-text has-text-primary">
                <span class="icon">
                  <i class="mdi mdi-map-marker mdi-24px"></i>
                </span>
                <span>
                  <?php echo ( $data["location"] ) ? $data["location"] : "&mdash;"; ?>
                </span>
              </span>
            </p>
          </div>
          <div class="column has-text-centered">
            <p class="title is-6">
              <span class="icon-text has-text-primary">
                <span class="icon">
                  <i class="mdi mdi-cake-variant mdi-24px"></i>
                </span>
                <span>
                  <?php
                  if ( $data["birth"] ) {
                    $dob = new \DateTime( $data["birth"] );
                  }
                  echo $dob->format("D, d M Y");
                  ?>
                </span>
              </span>
            </p>
          </div>
        </div>

        <div class="content">
          <?php echo ( $data["about"] ) ? $md->text( $data["about"] ) : "<p>&mdash;</p>"; ?>
        </div>
      </div>
    </div>

  </div>
</main>

<?php
}
require_once "footer.php";
?>
