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
    #right-wrap { float: right; top: 0; }
    #right-wrap img {height: 50vh; }

    #themizer-bar .note {
      text-align: center;
      font-size: 1.1em;
      margin-top: 4vh;
      margin-left: 2em;
    }

    #themizer-bar .note a {
      color: #5dc350;
    }

    .linkbutton {
      color: #40902a;
      border-color: #5dc350;
      font-family: 'Lato Light';
      padding: 4px 8px;
      font-size: 1.5em;
      margin-top: 7vh;
      transition: 0.5s ease;
    }
    .linkbutton:hover { background-color: #40902a; border-color: #40902a; color: #ccc; }
  </style>";
  get_header();
?>
<section id="themizer-bar">
  <section id="themizer-inner-wrap">
    <section id="left-wrap">
      <p class="heading">Style your blog, the easy way.</p>
      <a href="themizer.php" class="linkbutton uppercase">Get Started</a>
      <p class="note">Are you a developer? <a href="themizer.php?mode=development">Click Here</a> to go to development mode.</p>
    </section>
    <section id="right-wrap">
      <img src="images/themizer-open.png"/>
    </section>
  </section>
</section>
<section id="content">
</section>
<?php get_footer(); ?>
