<?php
  $title = "Themizer Index";
  include("include/include.php");
  session_start();
  $extra_style = "<link href=\"css/themizerindex.css\" rel=\"stylesheet\">";;
  get_header();
?>
<section id="themizer-bar">
  <section id="themizer-inner-wrap">
    <section id="left-wrap">
      <p class="heading">Style your blog, the easy way.</p>
      <a href="themizer.php" class="linkbutton uppercase" target="_blank">Get Started</a>
      <p class="note">Are you a developer? <a href="themizer.php?mode=development" target="_blank">Click Here</a> to go to development mode.</p>
    </section>
    <section id="right-wrap">
      <img src="images/themizer-open.png" />
    </section>
  </section>
</section>
<section id="content">
  <section id="features"> <!-- this severely needs to be filled with good stuff. @nmk not exactly sure what you intended to be serious here; you should describe. -->
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
    <article class="release" data-version="2.0.0">
      <h2>2.0.0</h2>
      <ul>
        <li>Completely redesigned interface</li>
        <li>No more annoying floting jQuery UI boxes--introducing a fully collapsible sidebar</li>
        <li>Introducing spectrum.js, for an amazing, lightweight color picker</li>
        <li>Random color generator</li>
        <li>Copy code to clipboard with one click</li>
        <li>prettify.js and CodeMirror are in use for beautiful code</li>
      </ul>
    </article>
  </section>
  <!-- I understand a #roadmap should be added. Good idea, and um, it needs to be added. -->
</section>
<?php get_footer(); ?>
