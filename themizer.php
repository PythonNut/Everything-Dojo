<?php
  $title = "Themizer";
  $index = TRUE;

  if ($_GET["mode"] == "regular") {
    $title = "Themizer (Regular Mode)";
    $index = FALSE;
  } elseif ($_GET["mode"] == "development") {
    $title = "Themizer (Development Mode)";
    $index = FALSE;
  }

  include("include/include.php");
  session_start();

  $extra_style = $index ? "" : "<link rel=\"stylesheet\" href=\"css/blog-style.css\">
  <link rel=\"stylesheet\" href=\"css/themizer.css\">
  <link rel=\"stylesheet\" href=\"css/spectrum.css\">";
  $extra_js = $index ? "<script>
  $(function() {
    tabs('home');
  });</script>" : "<script src=\"js/blog-fn.js\"></script>
  <script src=\"js/spectrum.js\" onload=\"$.fn.spectrum.load = false;\"></script>
  <script>
  $(function(){
    sliderSidebar('themizer-inner');
    themizer();
  });</script>";
  get_header();
?>

<?php
  if ($_GET["mode"] == "regular") {
?>
<aside id="sidebar">
  <section id="sidebar-inner">
    <h2 id="sideheadbar" class="themizer">Themizer</h2>

    <section class="option" id="option-view">
      <section class="option-title">
        <h5>Blog View</h5>
        <span class="collapsebutton"></span>
      </section>
      <section class="option-wrap">
        <p><input type="radio" name="view" value="index"><label for="view" class="radio">Index</label></p>
        <p><input type="radio" name="view" value="blog"><label for="view" class="radio">Blog Post</label></p>
        <p><input type="radio" name="view" value="post"><label for="view" class="radio">Post New Entry</label></p>
        <p><input type="radio" name="view" value="comment"><label for="view" class="radio">Post New Comment</label></p>
      </section>
    </section>

    <section class="option" id="option-base">
      <section class="option-title">
        <h5>Base Theme</h5>
        <span class="collapsebutton"></span>
      </section>
      <section class="option-wrap">
        <p><input type="radio" name="base" value="original"><label for="base" class="radio">Core by Dojo</label></p>
        <p><input type="radio" name="base" value="blog"><label for="base" class="radio">Calm by Red</label></p>
      </section>
    </section>

  </section>
</aside>

<div id="blog-body"></div>

<?php } else { ?>

<?php get_footer();
} ?>
