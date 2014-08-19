      <div class="push"></div>

    </main><?php //end wrap ?>

    <div id="credits">
      <h1>Thanks</h1><h2>to all the following AoPS users who worked on Everything Dojo:</h2>
      <ul>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=109994_1383427115.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=109994">csmath</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=37836_1350341434.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=37836">Dojo</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=90713_1404236316.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=90713">El_Ectric</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=133393_1407631509.gif"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=133393">EpicSkills32</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=176092_1407293461.gif"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=176092">gamjawon</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=117906_1376938637.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=117906">knittingfrenzy18</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=156828_1395017370.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=156828">NeoMathematicalKid</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=178792_1397856965.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=178792">nxt</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=81377_1393652565.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=81377">PythonNut</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=183270_1400039956.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=183270">thatmathgeek</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=114458_1377658805.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=114458">thkim1011</a></li>
        <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=156833_1381259342.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=156833">Tungsten</a></li>
      </ul>
    </div>

    <footer>
      <p><a href="/">Home</a> &bull; <a href="/about.php">About</a> &bull; <a href="javascript:;" onclick="popUp('credits')">Credits</a> <?php
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

