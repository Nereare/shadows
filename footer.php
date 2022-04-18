<?php if ( $auth->isLoggedIn() ) { ?>
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
<?php } ?>

<?php if ( !isset($_COOKIES["accept_cookies"]) && !isset($_SESSION["cookies"]) ){ ?>
  <div class="modal is-active" id="cookie-consent">
    <div class="modal-background"></div>
    <div class="modal-content">
      <article class="message is-warning">
        <div class="message-header">
          <p>
            <span class="icon-text">
              <span class="icon">
                <i class="mdi mdi-cookie-alert mdi-24px"></i>
              </span>
              <span>Alerta de Cookies</span>
            </span>
          </p>
        </div>
        <div class="message-body">
          <p>Este site usa <em>cookies</em> para oferecer a melhor experiência possível a seus usuários.</p>
          <p>Ao continuar o uso deste site, você concorda com o uso destes.</p>
          <p>Para mais informações, leia nossa <a href="cookies.php">Política de Cookies</a>.</p>
          <p class="has-text-centered">
            <button class="button is-success" id="cookie-accept">Condordo</button>
            <button class="button" id="cookie-reject">Não concordo</button>
          </p>
        </div>
      </article>
    </div>
  </div>
<?php } ?>
</body>
</html>
