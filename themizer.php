<?php
  $title = "Themizer";
  include("include/include.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/blog-style.css\" />
  <link rel=\"stylesheet\" href=\"css/themizer.css\" />";
  $extra_js = "<script src=\"js/blog-fn.js\"></script>
  <script>
  $(function(){
    sliderSidebar('themizer-inner');
    themizer();
  });</script>";
  get_header();
?>
<div id="sidebar">
  <div id="sidebar-inner">
    <h2 id="sideheadbar" class="themizer">Themizer</h2>

    <div class="option" id="option-view">
      <div class="option-title">
        <h5>Blog View</h5>
        <span class="collapsebutton"></span>
      </div>
      <div class="option-wrap">
        <p><input type="radio" name="view" value="index"><label for="view" class="radio">Index</label></p>
        <p><input type="radio" name="view" value="blog"><label for="view" class="radio">Blog Post</label></p>
        <p><input type="radio" name="view" value="post"><label for="view" class="radio">Post New Entry</label></p>
        <p><input type="radio" name="view" value="comment"><label for="view" class="radio">Post New Comment</label></p>
      </div>
    </div>

    <div class="option" id="option-base">
      <div class="option-title">
        <h5>Base Theme</h5>
        <span class="collapsebutton"></span>
      </div>
      <div class="option-wrap">
        <p><input type="radio" name="base" value="original"><label for="base" class="radio">Core by Dojo</label></p>
        <p><input type="radio" name="base" value="blog"><label for="base" class="radio">Calm by Red</label></p>
      </div>
    </div>

  </div>
</div>
<div id="blog-body"></div>
<?php //no footer here ?>

