<?php
  if (!isset($_GET['mode'])) {
    $_GET['mode'] = "regular";
  }
  if ($_GET["mode"] == "regular") {
    $title = "Themizer (Regular Mode)";
  } elseif ($_GET["mode"] == "development") {
    $title = "Themizer (Development Mode)";
  }
  include("include/include.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/blog-style.css\">
  <link rel=\"stylesheet\" href=\"css/themizer.css\">
  <link rel=\"stylesheet\" href=\"css/spectrum.css\">";
  $extra_js = "<script src=\"js/blog-fn.js\"></script>
  <script src=\"js/spectrum.js\" onload=\"$.fn.spectrum.load = false;\"></script>
  <script>
  $(function(){
    sliderSidebar('themizer-inner');
    themizer();
  });</script>";

  get_header();
?>
<?php if ($_GET["mode"] == "regular") { ?>
<aside id="sidebar">
  <section id="sidebar-inner">
    <h2 id="sideheadbar" class="themizer">Themizer</h2>

    <section class="option" id="option-view">
      <section class="option-title">
        <h5>Blog View</h5>
        <span class="collapsebutton"></span>
      </section>
      <section class="option-wrap">
        <select name="view">
          <option value="index">Index</option>
          <option value="blog">Post</option>
          <option value="post">Post New Entry</option>
          <option value="comment">Post New Comment</option>
        </select>
      </section>
    </section>

    <section class="option" id="option-base">
      <section class="option-title">
        <h5>Base Theme</h5>
        <span class="collapsebutton"></span>
      </section>
      <section class="option-wrap">
        <select name="base">
          <option value="core">Core by Dojo</option>
          <option value="calm">Calm by Red</option>
        </select>
      </section>
    </section>

    <!-- `span` and not `a` to avoid accidental styling in Firefox  -->
    <span href="#" class="linkbutton" id="submit">Get Code</span>

  </section>
  <div id="side-resizer"></div>
</aside>

<div id="blog-body"></div>

<?php } elseif ($_GET["mode"] == "development") { ?>

<?php include("unavailable.php"); ?>

<?php } ?>

</body>
</html>
