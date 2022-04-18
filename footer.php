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
              <span>Cookies Notice</span>
            </span>
          </p>
        </div>
        <div class="message-body">
          <p>This site uses cookies to offer the best experience to its users.</p>
          <p>By continuing to use this site, you express your acceptance to these cookies.</p>
          <p class="has-text-centered mt-2">
            <button class="button is-warning" id="cookie-accept">Agree</button>
          </p>
        </div>
      </article>
    </div>
  </div>
<?php } ?>
</body>
</html>
