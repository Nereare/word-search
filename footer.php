    <?php if (!isset($notInstalled) && $auth->isLoggedIn()) { ?>
    <footer class="footer pt-3 pb-4">
      <div class="content has-text-centered">
        <p class="mb-2">
          <strong><?php echo $title; ?></strong>
        </p>
        <p class="is-size-7">
          <a href="<?php echo constant("APP_REPO"); ?>">
            <?php echo constant("APP_NAME"); ?>
          </a>
          &copy;
          <?php echo constant("APP_YEAR"); ?>
          <?php echo constant("APP_AUTHOR"); ?>
          &bull;
          Available under the
          <a href="<?php echo constant("APP_LICENSE_URI"); ?>">
            <?php echo constant("APP_LICENSE_NAME"); ?>
          </a>
        </p>
      </div>
    </footer>
    <?php } ?>

    <div class="notification is-hidden" id="notification">
      <button class="delete"></button>
      <p>Foo</p>
    </div>
  </body>

</html>
