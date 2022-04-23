<?php
require_once "header.php";

if ( $auth->isLoggedIn() ) {
?>

<main class="section">
  <div class="container">
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
</main>

<?php
}
require_once "footer.php";
?>
