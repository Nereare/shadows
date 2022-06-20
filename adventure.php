<?php
use Nereare\Shadows\Adventure;
require_once "header.php";

if ( $auth->isLoggedIn() ) {
  // Get User ID
  $uid = $auth->getUserId();

  // Store Adventure ID
  $aid = isset( $_GET["aid"] ) ? (int) $_GET["aid"] : null;
  // Retrieve adventures from the user
  try { $adv = new Nereare\Shadows\Adventure($db, $aid); }
  catch (\Exception $e) { $adv = []; }

  if ( $aid == null || $adv == [] ) {
?>

<div class="section">
  <div class="container">
    <div class="box has-text-centered">
      <figure class="image is-404">
        <img src="assets/404.svg">
      </figure>

      <h2 class="title is-2">Oops!</h2>

      <div class="content">
        <p class="is-size-3">This Adventure could not be found, sorry &#128577;</p>
        <p class="is-size-4">
          <a href=".">
            Return home
          </a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php
  } else {
?>

<section class="section">
  <div class="container">

    <div class="card">
      <?php if ( $adv->getCoverURI() ) { ?>
      <div class="card-image">
        <figure class="image">
          <img src="<?php echo $adv->getCoverURI(); ?>" alt="Banner image for this adventure">
        </figure>
      </div>
      <?php } ?>
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <span class="icon is-large">
              <i class="mdi mdi-shield-sword mdi-48px"></i>
            </span>
          </div>
          <div class="media-content">
            <p class="title is-4"><?php echo $adv->getName(); ?></p>
            <p class="subtitle is-6">By <?php echo $adv->getAuthorName(); ?></p>
          </div>
        </div>

        <div class="breadcrumb is-centered has-bullet-separator" aria-label="breadcrumbs">
          <ul>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-account-group" aria-hidden="true"></i>
                </span>
                <span>For <?php echo $adv->getPCs(); ?> PC<?php echo ( (int)$adv->getPCs() > 1 ) ? "s" : ""; ?></span>
              </a>
            </li>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-ray-start-arrow" aria-hidden="true"></i>
                </span>
                <span>Levels <?php echo $adv->getInitLevel(); ?>&mdash;<?php echo $adv->getEndLevel(); ?></span>
              </a>
            </li>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-thermometer-plus" aria-hidden="true"></i>
                </span>
                <span><?php echo ( $adv->getAdvancement() == "xp" ) ? strtoupper( $adv->getAdvancement() ) : ucfirst( $adv->getAdvancement() ); ?></span>
              </a>
            </li>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-<?php echo ( (bool)$adv->getPublicStatus() ) ? "eye" : "eye-off"; ?>" aria-hidden="true"></i>
                </span>
                <span><?php echo ( (bool)$adv->getPublicStatus() ) ? "Public" : "Private"; ?></span>
              </a>
            </li>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-ab-testing" aria-hidden="true"></i>
                </span>
                <span><?php echo ucfirst( $adv->getDevStatus() ); ?></span>
              </a>
            </li>
            <?php if ( $adv->getSetting() ) { ?>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-earth" aria-hidden="true"></i>
                </span>
                <span><?php echo $adv->getSetting(); ?></span>
              </a>
            </li>
            <?php } ?>
            <?php if ( $adv->getVersion() ) { ?>
            <li class="is-active">
              <a>
                <span class="icon is-small">
                  <i class="mdi mdi-counter" aria-hidden="true"></i>
                </span>
                <span>v<?php echo $adv->getVersion(); ?></span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>

        <?php if ( $adv->getTriggers() ) { ?>
        <div class="breadcrumb is-centered has-bullet-separator" aria-label="breadcrumbs">
          <ul>
            <?php foreach (explode( ",", $adv->getTriggers() ) as $trigger) {?>
            <li class="is-active">
              <a class="has-text-danger-dark">
                <?php echo $trigger; ?>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>

        <div class="content">
          <?php echo ( $adv->getDesc() ) ? $md->text( $adv->getDesc() ) : "<p>&mdash;</p>"; ?>
        </div>
      </div>

      <footer class="card-footer">
        <a href="#" class="card-footer-item">Play</a>
        <?php if ( $adv->getAuthorID() == $uid ) { ?>
        <a href="#" class="card-footer-item">Edit</a>
        <?php } ?>
      </footer>
    </div>

    </div>
  </div>
</section>

<?php
  }
}
require_once "footer.php";
?>
