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
  <link rel=\"stylesheet\" href=\"css/spectrum.min.css\">
  <link href=\"css/prettify-desert.css\" rel=\"stylesheet\" />";
  $extra_js = "<script src=\"js/blog-fn.js\"></script>
  <script src=\"js/spectrum-1.3.4.min.js\" onload=\"$.fn.spectrum.load = false;\"></script>
  <script src=\"js/prettify.js\"></script>
  <script src=\"js/ZeroClipboard.js\"></script>
  <script>
  $(function(){
    /* Lightbox Utility */
    $('#lightbox').click(function(){
      $(this).hide();
    });
    $('#lightbox-wrap').click(function(e){
        e.stopPropagation();
    });

    $().sliderSidebar();
    themizer();
  });</script>";

  get_header();
?>
<aside id="sidebar">
  <h2 id="sideheadbar" class="themizer">Themizer</h2>
  <section id="sidebar-inner">
    <section id="sidebar-inner-scrollable">

      <section class="option" id="option-view">
        <section class="option-title">
          <h5>Blog Page</h5>
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

      <?php if ($_GET["mode"] == "regular"): ?>

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
        <section class="option-title expanded">
          <h5>Body</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <section data-name="backgroundColor">
            <span class="title">Background Color</span>
            <p>
              <input type="text" class="spectrum text" id="text-body-backgroundColor" value="white" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-body-backgroundColor" value="#FFFFFF">
            </p>
          </section>
          <section data-name="backgroundImage">
            <span class="title optional">Background Image URL</span>
            <p>
              <input type="url" class="text" id="body-backgroundImage" spellcheck="false">
            </p>
          </section>
          <section data-name="backgroundRepeat">
            <span class="title">Background Repeat</span>
            <p>
              <label class="label">repeat-all
                <input type="radio" class="radio" id="body-backgroundRepeat-repeatAll" name="body-backgroundRepeat" value="repeat" checked>
                <span class="input-button"></span>
              </label>
            </p>
            <p>
              <label class="label">repeat-y
                <input type="radio" class="radio" id="body-backgroundRepeat-repeatY" name="body-backgroundRepeat" value="repeat-y">
                <span class="input-button"></span>
              </label>
            </p>
            <p>
              <label class="label">repeat-x
                <input type="radio" class="radio" id="body-backgroundRepeat-repeatX" name="body-backgroundRepeat" value="repeat-x">
                <span class="input-button"></span>
              </label>
            </p>
            <p>
              <label class="label">no-repeat
                <input type="radio" class="radio" id="body-backgroundRepeat-noRepeat" name="body-backgroundRepeat" value="no-repeat">
                <span class="input-button"></span>
              </label>
            </p>
          </section>
          <section data-name="fontFamily">
            <span class="title">Font Family</span>
            <input type="text" class="text" id="body-fontFamily" value="Calibri" spellcheck="false">
          </section>
        </section>
      </section>

      <section class="option" id="option-wrapper">
        <section class="option-title">
          <h5>Wrapper</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <section data-name="backgroundColor">
            <span class="title">Background Color</span>
            <p>
              <input type="text" class="spectrum text" id="text-id_wrapper-backgroundColor" value="#EDEDEA" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-id_wrapper-backgroundColor" value="#EDEDEA">
            </p>
          </section>
        </section>
      </section>

      <section class="option" id="option-entries">
        <section class="option-title">
          <h5>Entries</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <section data-name="backgroundColor">
            <span class="title">Background Color <span class="small">(Entries)</span></span>
            <p>
              <input type="text" class="spectrum text" id="text-class_entry-backgroundColor" value="#EDEDEA" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-class_entry-backgroundColor" value="#EDEDEA">
            </p>
            <span class="title">Background Color <span class="small">(Entrywrap)</span></span>
            <p>
              <input type="text" class="spectrum text" id="text-class_entrywrap-backgroundColor" value="#EDEDEA" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-class_entrywrap-backgroundColor" value="#EDEDEA">
            </p>
          </section>
        </section>
      </section>

      <section class="option" id="option-shouts">
        <section class="option-title">
          <h5>Shouts</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <section data-name="backgroundColor">
            <span class="title">Background Color <span class="small">(Odd-numbered)</span></span>
            <p>
              <input type="text" class="spectrum text" id="text-class_row1-backgroundColor" value="#EDEDEA" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-class_row1-backgroundColor" value="#EDEDEA">
            </p>
            <span class="title">Background Color <span class="small">(Even-numbered)</span></span>
            <p>
              <input type="text" class="spectrum text" id="text-class_row2-backgroundColor" value="#EDEDEA" spellcheck="false">
              <input type="color" class="spectrum color-picker" id="spectrum-class_row2-backgroundColor" value="#EDEDEA">
            </p>
          </section>
        </section>
      </section>

      <?php elseif ($_GET["mode"] == "development"): ?>

      <section class="option" id="option-editor">
        <section class="option-title expanded">
          <h5>Editor</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <!-- add codemirror -->
          <!--------------------!
           ! ADD-ONS:           !
           ! active-line.js     !
           ! closebrackets.js   !
           ! css-hint.js        !
           ! lint.js            !
           ! matchbrackets.js   !
           ! runmode.js         !
           !--------------------!-->
        </section>
      </section>

      <?php endif; ?>

    </section>

    <!-- `span` and not `a` to avoid accidental styling in Firefox  -->
    <span href="#" class="linkbutton" id="submit">Get Code</span>

  </section>
  <div id="side-resizer"></div>

  <div id="lightbox">
    <div id="lightbox-wrap">
      <pre id="generatedcode" style="display:none"></pre>
      <pre id="generatedcode-shown" class="prettyprint linenums"></pre>
      <span class="linkbutton" id="copycode" data-clipboard-target="generatedcode">Copy Code to Clipboard</span>
    </div>
  </div>

</aside>

<div id="blog-body"></div>

</body>
</html>
