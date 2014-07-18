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
      height: 50vh;
      box-shadow: inset 0 0 2em 0 #000;
      color: white;
      margin: 10px auto;
      width: 125%;
      position: relative;
      left: -12.5%;
      padding: 2em;
      font-family: 'Lato Hairline', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
    }

    .heading {
      font-size: 3em;
      margin: 0.2em;
      text-align: left;
    }

    #themizer-inner-wrap {
      margin-left: 12.5%;
      list-style: none;
      position: relative;
    }

    #left-wrap {
      float: left;
      width: 50%;
      position: absolute;
      left: -10vw;
      top: 5vh;
    }
    #left-wrap .heading { width: 7em; }
    #right-wrap { float: right; top: 0;}
    #right-wrap img {height: 50vh;}

    .linkbutton {
      color: #40902a;
      border-color: #5dc350;
      font-family: 'Lato Light';
      padding: 5px 7px;
      font-size: 1.5em;
      margin-top: 7vh;
    }
  </style>";
  get_header();
?>
<div id="themizer-bar">
  <div id="themizer-inner-wrap">
    <div id="left-wrap">
      <p class="heading">Style your blog, the easy way.</p>
      <a href="themizer.php" class="linkbutton uppercase">Get Started</a>
    </div>
    <div id="right-wrap">
      <img src="images/themizer-open.png"/>
    </div>
  </div>
</div>
<div id="content">
</div>
<?php get_footer(); ?>
