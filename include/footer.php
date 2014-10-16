      <div class="push"></div>

    </main><?php //end wrap ?>

    <article class="overlay-wrapper">
      <section id="credits" class="overlay">
        <h1>Thanks</h1><h2>to all the following AoPS users who contributed to Everything Dojo:</h2>
        <ul>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=109994_1383427115.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=109994">csmath</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=37836_1350341434.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=37836">Dojo</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=90713_1404236316.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=90713">El_Ectric</a></li>
          <!--<li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=133393_1408318701.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=133393">EpicSkills32</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=176092_1407293461.gif"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=176092">gamjawon</a></li>
          need to make sure these two are still on board; haven't actually contributed yet-->
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=117906_1376938637.jpg"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=117906">knittingfrenzy18</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=156828_1395017370.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=156828">NeoMathematicalKid</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=178792_1397856965.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=178792">nxt</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=81377_1393652565.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=81377">PythonNut</a></li>
          <!--insert RTG here-->
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=183270_1400039956.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=183270">thatmathgeek</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=114458_1377658805.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=114458">thkim1011</a></li>
          <li><img src="http://www.artofproblemsolving.com/Forum/download/file.php?avatar=156833_1381259342.png"><a target="_blank" href="http://www.artofproblemsolving.com/Forum/memberlist.php?mode=viewprofile&u=156833">Tungsten</a></li>
        </ul>
      </section>
    </article>

    <footer>
      <p><a href="/">Home</a> &bull; <a href="/about.php">About</a> &bull; <a href="javascript:;" onclick="$('#credits').popUp('1%')">Credits</a> &bull; <a href="https://github.com/Deeg-Kim/Everything-Dojo">GitHub</a> <?php
              // will not work if dbc is not included on page
              if (isset($_SESSION['user_level']) && checkAdmin()) {
              ?>
              &bull; <a href="/admin.php" id="menu-admin">Admin CP</a> 
              <?php } //end admin ?>
              &bull; <a href="/contact.php">Contact Us</a></p>
      <p>&copy;2014 Everything Dojo. Individual styles are copyright their creators.</p>
      <p>Made with <span class="heart">&hearts;</span><?php if (isset($_GET['unicorns'])) { echo " and unicorns"; } ?>.</p>
      <p>Server Time: <?php echo date("m/d/y G:i T"); ?></p>
      <p></p>
    </footer>

    <!-- Unicorns should be sticky -->
    <script class="js-unicorns">
      // Function to get search parameters as an associative array. Written by Stack Overflow user weltraumpirat at http://stackoverflow.com/questions/5448545/how-to-retrieve-get-parameters-from-javascript/5448635#5448635
      function getSearchParameters() {
        var prmstr = window.location.search.substr(1);
        return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
      }

      function transformToAssocArray( prmstr ) {
        var params = {};
        var prmarr = prmstr.split("&");
        for ( var i = 0; i < prmarr.length; i++) {
            var tmparr = prmarr[i].split("=");
            params[tmparr[0]] = tmparr[1];
        }
        return params;
      }

      var params = getSearchParameters();

      if (params["unicorns"] !== undefined) {
        $(document).ready(function () {
          $("a").each(function () {
            if ($(this).attr("href").indexOf(".php") > -1) {
              $(this).attr("href", $(this).attr("href") + ($(this).attr("href").indexOf("?") > -1 ? "&unicorns" : "?unicorns"));
            }

            else {
              $(this).attr("href", $(this).attr("href") + ($(this).attr("href").indexOf("everythingdojo.com") > -1 ? "?unicorns" : "?unicorns"));
            }
          });
        });
      }
    </script>

  </body>

</html>
