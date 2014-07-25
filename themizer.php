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
  <h2 id="sideheadbar" class="themizer">Themizer</h2>
  <section id="sidebar-inner">

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

    <section class="option" id="option-body">
      <section class="option-title">
        <h5>Body</h5>
        <span class="collapsebutton"></span>
      </section>
      <section class="option-wrap">
        <section data-name="backgroundColor">
          <span class="label">Background Color</span>
          <p>
            <input type="text" class="spectrum text" data-id="spectrum-body-backgroundColor" value="white" spellcheck="false">
            <input type="color" class="spectrum color-picker" id="spectrum-body-backgroundColor" value="#FFFFFF" data-el="body" data-prop="background-color">
          </p>
        </section>
        <section data-name="backgroundImage">
          <span class="label optional">Background Image URL</span>
          <input type="text" class="text" id="body-backgroundImage">
        </section>
        <section data-name="backgroundRepeat">
          <span class="label">Background Repeat</span>
          <p>
            <label class="label" for="body-backgroundRepeat-repeatAll">repeat-all</label>
            <input type="radio" class="radio" id="body-backgroundRepeat-repeatAll" name="body-backgroundRepeat" value="repeat-all" checked>
            <span class="input-button"></span>
          </p>
          <p>
            <label class="label" for="body-backgroundRepeat-repeatY">repeat-y</label>
            <input type="radio" class="radio" id="body-backgroundRepeat-repeatY" name="body-backgroundRepeat" value="repeat-y">
            <span class="input-button"></span>
          </p>
          <p>
            <label class="label" for="body-backgroundRepeat-repeatX">repeat-x</label>
            <input type="radio" class="radio" id="body-backgroundRepeat-repeatX" name="body-backgroundRepeat" value="repeat-x">
            <span class="input-button"></span>
          </p>
          <p>
            <label class="label" for="body-backgroundRepeat-noRepeat">no-repeat</label>
            <input type="radio" class="radio" id="body-backgroundRepeat-noRepeat" name="body-backgroundRepeat" value="no-repeat">
            <span class="input-button"></span>
          </p>
        </section>
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
