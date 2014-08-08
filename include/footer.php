      <div class="push"></div>

    </main><?php //end wrap ?>

    <footer>
      <p><a href="/">Home</a> &bull; <a href="/about.php">About</a> <?php
              // will not work if dbc is not included on page
              if (checkAdmin()) {
              ?>
              &bull; <a href="/admin.php" id="menu-admin">Admin CP</a>
              <?php } //end admin ?></p>
      <p>&copy;2014 Everything Dojo</p>
      <p>Server Time: <?php echo date("m/d/y G:i T"); ?></p>
    </footer>

  </body>

</html>

