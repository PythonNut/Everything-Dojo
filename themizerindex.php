<?php
  $title = "Themizer Index";
  include("include/include.php");
  session_start();
  $extra_style = "<style>
    body {
      overflow-x: hidden;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Lato', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
      font-weight: 400;
      padding-bottom: 0.2em;
    }

    .linkbutton {
      color: #48a730;
      border-color: #5dc350;
      font-family: 'Lato', sans-serif;
      font-weight: 400;
      padding: 0.25em 0.4em 0.2em;
      font-size: 1.5em;
      margin-top: 7vh;
      -webkit-transition: 0.5s ease;
      transition: 0.5s ease;
    }
    .linkbutton:hover {
      background-color: #41962c;
      border-color: #40902a;
      color: #ccc;
    }

    .heading {
      font-size: 3em;
      margin: 0.2em;
      text-align: left;
    }

    .tile {
      height: 20vh;
      width: 46%;
      padding: 2%;
    }
    .tile:first-child {
      float: left;
      border-right: 1px solid #bbb;
      margin-right: -1px;
    }
    .tile:last-child {
      float: right;
    }

    .index-row:first-of-type .tile {
      border-bottom: 1px solid #bbb;
    }

    #headerwrap {
      width: 93%;
    }
    #headerwrap a {
      cursor: pointer;
    }

    #themizer-bar {
      background: #212121;
      height: 50vh;
      box-shadow: inset 0 0 2em 0 #000;
      color: white;
      margin: .5em auto;
      width: 125%;
      position: relative;
      left: -12.5%;
      padding: 2em;
      font-family: 'Lato Hairline', 'Lato', 'Lucida Grande', 'Lucida Sans Unicode', sans-serif;
      font-weight: 100; /* epiphany aka safari for linux doesn't do it right without this */
    }
    #themizer-bar .note {
      text-align: center;
      font-size: 1.1em;
      margin-top: 4vh;
      margin-left: 2em;
    }
    #themizer-bar .note a {
      color: #5dc350;
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
    #left-wrap .heading {
      width: 7em;
    }

    #right-wrap {
      float: right;
      top: 0;
    }
    #right-wrap img {
      height: 50vh;
    }

    #content h1 {
      border-bottom: 1px solid #bbb;
    }

    #features {
      height: 60vh;
    }
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
  <section id="features">
    <h1>Features</h1>
    <section class="index-row">
      <article class="tile">
        <h2>Easy-to-use Interface</h2>
        <p>Useful for stuff. Lots of stuff.</p>
      </article>
      <article class="tile">
        <h2>Spankin' New</h2>
        <p>AKA will destroy your machine with dangerous bugs.</p>
      </article>
    </section>
    <section class="index-row">
      <article class="tile">
        <h2>Developer Mode</h2>
        <p>Not recommended for people who know less than 2 programming languages.</p>
      </article>
      <article class="tile">
        <h2>Click-and-Style (coming soon)</h2>
        <p>We hope to get this out before the next presidential election.</p>
      </article>
    </section>
  </section>
  <section id="changelog">
    <h1>Changelog</h1>
    <article class="release" data-version="0.0.1a">
      <h2>0.0.1a</h2>
      <ul>
        <li>did nothing</li>
        <li>what did you expect?</li>
        <li>it's summer</li>
        <li>we're all on vacation</li>
        <li>coding is fun</li>
      </ul>
    </article>
  </section>
</section>
<?php get_footer(); ?>
