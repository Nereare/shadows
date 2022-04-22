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
      </div>
    </div>
  </div>
</main>

<?php
}
require_once "footer.php";
?>
