
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
            Repositories
          </p>
          <div class="panel-block">
            <p class="control has-icons-left">
              <input class="input" type="text" placeholder="Search">
              <span class="icon is-left">
                <i class="mdi mdi-search" aria-hidden="true"></i>
              </span>
            </p>
          </div>
          <p class="panel-tabs">
            <a class="is-active">All</a>
            <a>Public</a>
            <a>Private</a>
          </p>
          <a class="panel-block is-active">
            <span class="panel-icon">
              <i class="mdi mdi-source-repository" aria-hidden="true"></i>
            </span>
            bulma
          </a>
          <a class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-source-repository" aria-hidden="true"></i>
            </span>
            marksheet
          </a>
          <a class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-source-repository" aria-hidden="true"></i>
            </span>
            minireset.css
          </a>
          <a class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-source-repository" aria-hidden="true"></i>
            </span>
            jgthms.github.io
          </a>
          <a class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-source-branch" aria-hidden="true"></i>
            </span>
            daniellowtw/infboard
          </a>
          <a class="panel-block">
            <span class="panel-icon">
              <i class="mdi mdi-source-branch" aria-hidden="true"></i>
            </span>
            mojs
          </a>
          <label class="panel-block">
            <input type="checkbox">
            remember me
          </label>
          <div class="panel-block">
            <button class="button is-link is-outlined is-fullwidth">
              Reset all filters
            </button>
          </div>
        </nav>
      </div>
      <!-- /Panel -->

      <!-- Main -->
      <div class="column">
        <div class="box">
          <div class="content">
            <p>Foo</p>
            <?php
            $prof = new \Nereare\Profile\Profile($db, 1);
            var_dump( $prof->get("birth") );
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
