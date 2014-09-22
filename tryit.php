<?php
  $title = "Try-It";
  include("include/include.php");
  include("themedb.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/blog-style.css\">
  <link rel=\"stylesheet\" href=\"css/slidersidebar.css\">";
  $extra_js = "<script>
  $(function () {
    tryit();
  });</script>";

  get_header();

  if (!empty($_GET['select'])) {
    $themedb = new themedb($dbc);
    $style = $themedb->get_themes(intval($_GET['select']), TRUE);
    echo "<style>";
    echo htmlspecialchars_decode($style['code']);
    echo "</style>";
  }
?>

<aside id="sidebar">
  <h2 id="sideheadbar" class="tryit">Try-It</h2>
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
          <span class="title">Base theme</span>
          <p>
            <form method="get" id="select-theme" name="select-theme">
              <select id="select" name="select" onchange="this.form.submit()">
                <option value="" selected>======= SELECT ONE =======</option>
                <?php
                  $data = $themedb->get_themes('all', true);
                  //cache the theme id
                  if ($_GET['dev'] == "dev") {
                    $selected = $_GET['select'];
                    $allthemes = array(
                      'dev' => array(),
                      'alpha' => array(),
                      'beta' => array(),
                      'rel' => array(),
                      'other' => array()
                    );

                    //get validated
                    foreach ($data['validated']['name'] as $key => $theme) {
                      $tmp_theme = array(
                        'name' => $data['validated']['name'][$key],
                        'id' => $data['validated']['id'][$key],
                        'stage' => $data['validated']['stage'][$key]
                      );
                      switch ($tmp_theme['stage']) {
                        case "[RELEASE]":
                          $allthemes['rel'][] = $tmp_theme;
                          break;
                        default:
                          $allthemes['other'][] = $tmp_theme;
                      }
                    }

                    //get unvalidated
                    foreach ($data['unvalidated']['name'] as $key => $theme) {
                      $tmp_theme = array(
                        'name' => $data['unvalidated']['name'][$key],
                        'id' => $data['unvalidated']['id'][$key],
                        'stage' => $data['unvalidated']['stage'][$key]
                      );
                      switch ($tmp_theme['stage']) {
                        case "[DEV]":
                          $allthemes['dev'][] = $tmp_theme;
                          break;
                        case "[ALPHA]":
                          $allthemes['alpha'][] = $tmp_theme;
                          break;
                        case "[BETA]":
                          $allthemes['beta'][] = $tmp_theme;
                          break;
                        default:
                          $allthemes['other'][] = $tmp_theme;
                      }
                    }

                    //echo out all themes in form of optgroup
                    if (!empty($allthemes['rel'])) {
                      echo "<optgroup label='[RELEASE] stage (safe and working)'>";
                      foreach ($allthemes['rel'] as $key=>$theme) {
                        if ($selected == $theme['id']) {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'" selected>'.$theme['name'].'</option>';
                        } else {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'">'.$theme['name'].'</option>';
                        }
                      }
                      echo "</optgroup>";
                    }

                    if (!empty($allthemes['beta'])) {
                      echo "<optgroup label='[BETA] stage (almost finished)'>";
                      foreach($allthemes['beta'] as $key=>$theme) {
                        if ($selected == $theme['id']) {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'" selected>'.$theme['name'].'</option>';
                        } else {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'">'.$theme['name'].'</option>';
                        }
                      }
                      echo "</optgroup>";
                    }

                    if (!empty($allthemes['alpha'])) {
                      echo "<optgroup label='[ALPHA] stage (buggy/glitchy)'>";
                      foreach ($allthemes['alpha'] as $key => $theme) {
                        if ($selected == $theme['id']) {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'" selected>'.$theme['name'].'</option>';
                        } else {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'">'.$theme['name'].'</option>';
                        }
                      }
                      echo "</optgroup>";
                    }

                    if (!empty($allthemes['dev'])) {
                      echo "<optgroup label='[DEV] stage (NOT RECOMMENDED)'>";
                      foreach ($allthemes['dev'] as $key => $theme) {
                        if ($selected == $theme['id']) {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'" selected>'.$theme['name'].'</option>';
                        } else {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'">'.$theme['name'].'</option>';
                        }
                      }
                      echo "</optgroup>";
                    }

                    if (!empty($allthemes['other'])) {
                      echo "<optgroup label='[OTHER] stage (unknown, try at your own risk)'>";
                      foreach ($allthemes['other'] as $key => $theme) {
                        if ($selected == $theme['id']) {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'" selected>'.$theme['name'].'</option>';
                        } else {
                          echo '<option id="'.$theme['id'].'" name="'.$theme['id'].'" value="'.$theme['id'].'">'.$theme['name'].'</option>';
                        }
                      }
                      echo "</optgroup>";
                    }

                  } else {
                    $ids = $data['validated']['id'];
                    $names = $data['validated']['name'];
                    $selected = $_GET['select'];
                    foreach ($names as $key => $theme) {
                      if ($selected == $ids[$key]) {
                        echo '<option id="'.$ids[$key].'" name="'.$ids[$key].'" value="'.$ids[$key].'" selected>'.$theme.'</option>';
                      } else {
                        echo '<option id="'.$ids[$key].'" name="'.$ids[$key].'" value="'.$ids[$key].'">'.$theme.'</option>';
                      }
                    }
                  }

                ?>
                </select>
              </section>
            </form>
          </p>
          <span class="title">Enable Development Themes</span>
          <p>
            <form method="get" id="select-theme" name="dev-mode">
              <?php if ($_GET['dev'] == "dev") {
                echo '<input type="checkbox" value="dev" name="dev" onChange="this.form.submit();" style="display:inline-block;" checked/>';
              } else {
                echo '<input type="checkbox" value="dev" name="dev" onChange="var confirm=window.confirm(\'Warning: Development mode means that you can try ALL the styles, including incomplete, in-development and/or buggy CSS. These styles are not recommended for your blog.\n\nDo you really wish to continue?\');if(confirm)this.form.submit();else this.checked=false;" style="display:inline-block;"/>';
              } ?>
            </form>
          </p>
        </section>
      </section>

      <?php if (!empty($_GET['select'])) {
        echo '<a style="display:inline-block;font-size:15px;height:15px;margin-left:15px;" href="database.php?mode=view&view=style&id='.intval($_GET['select']).'">View style in Database</a>';
      } ?>

    </section>

  </section>
  <div id="side-resizer"></div>

</aside>

<div id="blog-body"></div>

</body>
</html>
