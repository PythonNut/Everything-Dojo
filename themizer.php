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
