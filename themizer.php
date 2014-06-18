<?php
  $title = "Themizer";
  include("include/include.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/blog-style.css\" />
  <link rel=\"stylesheet\" href=\"css/themizer.css\" />";
  $extra_js = "<script>$(function(){
    sliderSidebar('themizer-inner');
    themizer();
  });</script>";
  get_header();
?>
<div id="sidebar">
  <div id="sidebar-inner">
    <div class="option" id="option-view">
      <h5 class="option-title">Blog View</h5>
      <p><input type="radio" name="view" value="index" /><label for="view" class="inline">Index</label></p>
      <p><input type="radio" name="view" value="blog" /><label for="view" class="inline">Blog Post</label></p>
      <p><input type="radio" name="view" value="post" /><label for="view" class="inline">Post New Entry</label></p>
      <p><input type="radio" name="view" value="comment" /><label for="view" class="inline">Post New Comment</label></p>
    </div>
  </div>
</div>
<div id="blog-body"></div>
<?php //no footer here ?>