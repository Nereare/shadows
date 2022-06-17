<?php
require_once "header.php";

if ( $auth->isLoggedIn() ) {
?>

<section class="section">
  <div class="container">
    <div class="columns mb-0">

      <!-- Panel -->
      <div class="column is-3">
        <nav class="panel">
          <p class="panel-heading">
            My Stories
          </p>
          <!-- TODO: List stories from this user. -->
          <?php if (true) { ?>
          <div class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-dots-horizontal" aria-hidden="true"></i>
            </span>
            No story found
          </div>
          <?php } else { ?>
          <a class="panel-block" href="#">
            <span class="panel-icon">
              <i class="mdi mdi-clipboard-text" aria-hidden="true"></i>
            </span>
            bulma
          </a>
          <?php } ?>
        </nav>
      </div>
      <!-- /Panel -->

      <!-- Main -->
      <div class="column">
        <div class="box">
          <div class="content">
            <h2 class="title is-4">Foo</h2>
            <?php
            $adv = new Nereare\Shadows\Adventure($db, 4);
            var_dump( $adv );
            ?>

            <div class="field">
            	<label class="label">Tags</label>
            	<div class="control">
            		<input class="input" id="tags" type="text" data-type="tags" placeholder="Choose Tags" value="One,Two">
            	</div>
            </div>
            <div class="field">
              <div class="control is-expanded">
                <button class="button is-fullwidth" id="tags-show">Foo</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Main -->
    </div>
  </div>
</section>

<?php
}
require_once "footer.php";
?>
