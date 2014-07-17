<?php
  $title = "Themizer Index";
  include("include/include.php");
  session_start();
  $extra_style = "<style>
    body {
      overflow-x: hidden;
    }
    
    #themizer-bar {
      background: #212121;
      height: 30vh;
      box-shadow: inset 0 0 2em 0 #000;
      color: white;
      margin: 10px auto;
      width: 125%;
      position: relative;
      left: -12.5%;
      padding: 2em;
      font-family: Lato;
    }
    
    .heading {
      font-size: 3.5em;
      margin: 0.2em;
    }
    
    #themizer-inner-wrap {
      margin-left: 12.5%;
      list-style: none;
      position: relative;
    }
    
    #left-wrap { float: left; width: auto; }
  </style>";
  get_header();
?>
<div id="themizer-bar">
  <div id="themizer-inner-wrap">
    <div id="left-wrap">
      <p class="heading">Style your blog, the easy way.</p>
      <a href="themizer.php" class="linkbutton uppercase">Get Started</a>
    </div>
  </div>
</div>
<div id="content">
</div>
<?php get_footer(); ?>
