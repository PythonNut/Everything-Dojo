<?php
  if (!isset($_GET['mode'])) {
    $_GET['mode'] = "index";
  }

  if ($_GET["mode"] == "index") {
    $title = "Themizer Index";
  } elseif ($_GET["mode"] == "regular") {
    $title = "Themizer (Regular Mode)";
  } elseif ($_GET["mode"] == "development") {
    $title = "Themizer (Development Mode)";
  }

  include("include/include.php");
  session_start();

  if ($_GET["mode"] == "index") {
    $extra_style = "<link href=\"css/themizerindex.css\" rel=\"stylesheet\">";;
    get_header();
  }
?>
<?php if ($_GET["mode"] == "index"): ?>
<section id="themizer-bar">
  <section id="themizer-inner-wrap">
    <section id="left-wrap">
      <p class="heading">Style your blog, the easy way.</p>
      <a href="themizer.php?mode=regular" class="linkbutton uppercase" target="_blank">Get Started</a>
      <p class="note">Are you a developer? <a href="themizer.php?mode=development" target="_blank">Click Here</a> to go to development mode.</p>
    </section>
    <section id="right-wrap">
      <img src="images/themizer.png" />
    </section>
  </section>
</section>
<section id="content">
  <section id="features">
    <h1>Features</h1>
    <section class="index-row">
      <article class="tile">
        <h2>Easy-to-use Interface</h2>
        <p>Our designers have worked carefully over tens of hours to give you a streamlined, intuitive interface that does exactly what you want it to do.</p>
      </article>
      <article class="tile">
        <h2>Customization at your fingertips</h2>
        <p>By including options to change your base theme and what page you're on, we've made the new Themizer more powerful than ever.</p>
      </article>
    </section>
    <section class="index-row">
      <article class="tile">
        <h2>Click-to-copy</h2>
        <p>We've taken convenience to the next level with click-to-copy on both regular and development mode.</p>
      </article>
      <article class="tile">
        <h2>Developer Mode</h2>
        <p>With the excellent CodeMirror and linting planned to be added, it's made by developers, for developers.</p>
      </article>
    </section>
  </section>
  <section id="changelog">
    <h1>Changelog</h1>
    <article class="release" data-version="2.0.0">
      <h2>2.0.0</h2>
      <ul>
        <li>Completely redesigned interface</li>
        <li>No more annoying floating jQuery UI boxes &mdash; introducing a fully collapsible sidebar</li>
        <li>Introducing spectrum.js, for an amazing, lightweight color picker</li>
        <li>Random color generator</li>
        <li>Copy code to clipboard with one click</li>
        <li>(Development mode only) CodeMirror has been added as the default text editor</li>
      </ul>
    </article>
  </section>
  <section id="roadmap">
    <h1>Roadmap</h1>
    <article class="release" data-version="2.0.0">
      <h2>2.1.0</h2>
      <ul>
        <li>Add the capability to save themes</li>
      </ul>
    </article>
  </section>
</section>

<?php get_footer(); ?>

<?php else: // Regular/Development mode ?>
<!DOCTYPE html>
<html>
<head>

  <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

  <meta charset="utf-8">
  <link href="images/favicon.ico" rel="shortcut icon">
  <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">

  <link rel="stylesheet" href="css/blog-style.css">
  <link rel="stylesheet" href="css/slidersidebar.css">
  <?php if ($_GET["mode"] == "regular") { ?>
  <link rel="stylesheet" href="css/spectrum.min.css">
  <link rel="stylesheet" href="css/prism.min.css">
  <?php } else { ?>
  <link rel="stylesheet" href="css/codemirror.min.css">
  <?php } ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <script src="js/themizer.js"></script>
  <script src="js/blog-fn.js"></script>
  <script src="js/ZeroClipboard.min.js"></script>
  <?php if ($_GET["mode"] == "regular") { ?>
  <script src="js/spectrum-1.3.4.min.js" onload="$.fn.spectrum.load = false;"></script>
  <script src="js/randomColor.min.js"></script>
  <script src="js/prism.min.js"></script>
  <script>
    $(function () {
      $('#lightbox, #close-button').click(function () {
        $('#lightbox').hide();
      });
      $('#lightbox-wrap').click(function (e) {
        e.stopPropagation();
      });
      themizerRegular();
    });
  </script>
  <?php } else { ?>
  <script src="js/codemirror-4.4.min.js"></script>
  <script>$(function () { themizerDev(); });</script>
  <?php } ?>

  <noscript>
    <link href="css/noscript.css" rel="stylesheet">
  </noscript>

</head>
<body>
  <main id="wrap">
    <aside id="sidebar" class="<?php echo $_GET['mode']; ?>">
      <h2 id="sideheadbar" class="themizer">Themizer</h2>
      <section id="sidebar-inner">
        <section id="sidebar-inner-scrollable">

          <section class="option" id="option-options">
            <section class="option-title expanded">
              <h5>Options</h5>
              <span class="collapsebutton"></span>
            </section>
            <section class="option-wrap">
              <span class="title">Blog page</span>
              <p>
                <select name="view">
                  <option value="index">Index</option>
                  <option value="blog">Post</option>
                  <option value="post">Post New Entry</option>
                  <option value="comment">Post New Comment</option>
                </select>
              </p>
              <?php if ($_GET["mode"] == "regular"): ?>
              <span class="title">Base theme</span>
              <p>
                <select name="base">
                  <option value="core">Core by Dojo</option>
                  <option value="warped">Warped by Red</option>
                  <option value="shadows">Shadows by nxt</option>
                </select>
              </p>
              <?php endif; ?>
            </section>
          </section>

          <?php if ($_GET["mode"] == "regular"): ?>

          <section class="option" id="option-body">
            <section class="option-title">
              <h5>Body</h5>
              <span class="collapsebutton"></span>
            </section>
            <section class="option-wrap">
              <section data-name="backgroundColor">
                <span class="title">Background Color</span>
                <p>
                  <input type="text" class="spectrum text" id="text-body-backgroundColor" value="white" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
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
                    <input type="radio" class="radio" id="body-backgroundRepeat-repeatAll" name="body-backgroundRepeat" value="" checked>
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

          <section class="option" id="option-header">
            <section class="option-title">
              <h5>Header</h5>
              <span class="collapsebutton"></span>
            </section>
            <section class="option-wrap">
              <section data-name="backgroundColor">
                <span class="title">Background Color</span>
                <p>
                  <input type="text" class="spectrum text" id="text-id_header-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-id_header-backgroundColor" value="#EDEDEA">
                </p>
              </section>
              <section data-name="Title Color">
                <span class="title">Title Color</span>
                <p>
                  <input type="text" class="spectrum text" id="text-id_headerspaceh1-color" value="#000000" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-id_headerspaceh1-color" value="#000000">
                </p>
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
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-id_wrapper-backgroundColor" value="#EDEDEA">
                </p>
              </section>
            </section>
          </section>

          <section class="option" id="option-posts">
            <section class="option-title">
              <h5>Posts</h5>
              <span class="collapsebutton"></span>
            </section>
            <section class="option-wrap">
              <section data-name="entries-backgroundColor">
                <h3 style="margin-top:0">Entries</h3>
                <span class="title">Background Color <span class="small">(Entries)</span></span>
                <p>
                  <input type="text" class="spectrum text" id="text-class_entry-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-class_entry-backgroundColor" value="#EDEDEA">
                </p>
                <span class="title">Background Color <span class="small">(Entrywrap)</span></span>
                <p>
                  <input type="text" class="spectrum text" id="text-class_entrywrap-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-class_entrywrap-backgroundColor" value="#EDEDEA">
                </p>
              </section>
              <section data-name="comments-backgroundColor">
                <h3>Comments</h3>
                <span class="title">Background Color <span class="small">(Comments)</span></span>
                <p>
                  <input type="text" class="spectrum text" id="text-class_comment-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-class_comment-backgroundColor" value="#EDEDEA">
                </p>
                <span class="title">Background Color <span class="small">(Commentwrap)</span></span>
                <p>
                  <input type="text" class="spectrum text" id="text-class_commentwrap-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-class_commentwrap-backgroundColor" value="#EDEDEA">
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
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
                  <input type="color" class="spectrum color-picker" id="spectrum-class_row1-backgroundColor" value="#EDEDEA">
                </p>
                <span class="title">Background Color <span class="small">(Even-numbered)</span></span>
                <p>
                  <input type="text" class="spectrum text" id="text-class_row2-backgroundColor" value="#EDEDEA" spellcheck="false">
                  <span class="random-color" onclick="$(this).styleRandomColor();" title="Style with random color"></span>
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
              <textarea id="editor" style="font-family:Monaco,Consolas,'Courier New',monospace"></textarea>
              <div id="editor-raw" style="display:none"></div>
            </section>
          </section>

          <script>$(function () {
            // TODO: Add linting
            var codemirror = CodeMirror.fromTextArea(document.getElementById("editor"), {
              mode: "css",
              theme: "ambiance",
              lineNumbers: true,
              matchBrackets: true,
              autoCloseBrackets: true,
              styleActiveLine: true,
            });

            codemirror.on("change", function (codemirror, change) {
              var input = codemirror.getValue();
              $("#editor-raw").html(input); // copy raw code to div for copying
              input = input.replace(/([^\r\n,{}]+)(,(?=[^}\/]*{)|\s*{)/g, "#blog-body $1$2"); // https://stackoverflow.com/a/12578281/3472393
              input = input.replace(/#blog-body\s+(html|body)/g, "$1"); // restore body/html selectors
              input = input.replace(/#blog-body\s+(@(-.+-)?keyframes|to|from)/g, "$1"); // restore @keyframe rules
              $("#dev-style").html(input);
            });
          });
          </script>

          <?php endif; ?>

        </section>

        <?php if ($_GET["mode"] == "regular"): ?>
        <!-- `span` and not `a` to avoid accidental styling in Firefox  -->
        <span href="#" class="reg linkbutton" id="submit">Get Code</span>
        <?php elseif ($_GET["mode"] == "development"): ?>
        <span class="long linkbutton" id="copycode" data-clipboard-target="editor-raw">Copy Code to Clipboard</span>
        <?php endif; ?>

      </section>
      <div id="side-resizer"></div>

      <div id="lightbox">
        <div id="lightbox-wrap">
          <span id="close-button">&#x00d7;</span>
          <pre id="generatedcode" style="display:none"></pre>
          <pre id="generatedcode-shown" class="lang-css"></pre>
          <span class="linkbutton" id="copycode" data-clipboard-target="generatedcode">Copy Code to Clipboard</span>
        </div>
      </div>

    </aside>

    <div id="blog-body"></div>

  </main>
</body>
</html>

<?php endif; ?>
