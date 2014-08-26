<?php
  $title = "Try-It";
  include("include/include.php");
  session_start();
  $extra_js = "<script>
  $(function () {
    tryit();
  });</script>";

  get_header();

  echo '<div id="blog-body">';
  include("blog-blog.html");

  if (!empty($_GET['select'])) {
    $themedb = new themedb($dbc);
    $style = $themedb->get_themes(intval($_GET['select']), TRUE);
    echo "<style>";
    echo htmlspecialchars_decode($style['code']);
    echo "</style>";
  }
  echo '</div>';
?>

</body>
</html>
