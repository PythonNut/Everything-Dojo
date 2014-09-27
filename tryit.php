<?php
  $title = "Try-It";
  include("include/include.php");
  include("include/themedb.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/blog-style.css\">\n";
  if (!empty($_GET['select'])) {
    $themedb = new themedb($dbc);
    $style = $themedb->get_themes(intval($_GET['select']), TRUE);
    $extra_style .= "<style>";
    $extra_style .= htmlspecialchars_decode($style['code']);
    $extra_style .= "</style>\n";
  }
  $extra_style .= "<link rel=\"stylesheet\" href=\"css/slidersidebar.css\">";
  $extra_js = "<script>
  $(function () {
    tryit();
  });</script>";

  get_header();
  
  echo '<div id="blog-body">';
  include("blog-blog.html");
  
  if (!empty($_GET['select'])) {
    $themedb = new themedb($dbc);
    $style = $themedb->get_themes(intval($_GET['select']), TRUE);
    echo "<style>";
    echo htmlspecialchars_decode($style['code']);
    echo "</style>";
  }
  echo '</div>';
?>

<aside id="sidebar">
  <h2 id="sideheadbar" class="tryit">Try-It</h2>
  <section id="sidebar-inner">
    <section id="sidebar-inner-scrollable">

      <section class="option" id="option-view">
        <section class="option-title">
          <h5>View</h5>
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
        </section>
      </section>
      <section class="option" id="option-theme">
        <section class="option-title expanded">
          <h5>Theme</h5>
          <span class="collapsebutton"></span>
        </section>
        <section class="option-wrap">
          <span class="title">Select theme</span>
          <p>
            <form method="get" id="select-theme" name="select-theme">
              <select id="select" name="select" onChange="this.form.submit()">
                <option value="" selected>NONE SELECTED</option>
                <?php
                  $data = $themedb->get_themes('all', true);
                  //cache the theme id
                  if (isset($_GET['dev'])) {
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
                      echo "<optgroup label='[RELEASE] stage'>";
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
                      echo "<optgroup label='[BETA] stage'>";
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
                      echo "<optgroup label='[ALPHA] stage'>";
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
                      echo "<optgroup label='[DEV] stage'>";
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
                      echo "<optgroup label='Other stage'>";
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
              <!--form element extended-->
          </p>
          <span class="title">Enable Development Themes</span>
          <p>
            <!--form element extended-->
              <input type="checkbox" name="dev" value="true" onChange="this.form.submit();" class="inline" <?php if (isset($_GET['dev'])) { echo "checked"; } ?>><label class="inline small">Try all styles, including possibly incomplete and buggy skins under development</label>
            </form>
          </p>
        </section>
      </section>

    </section>

    <span <?php if(isset($_GET['select'])) { ?>onClick="window.location.href='database.php?mode=view&view=style&id=<?php echo intval($_GET['select']); ?>'"<?php } ?> class="long linkbutton<?php if (!$_GET['select']) { echo ' disabled'; } ?>" id="view">View style in Database</span>

  </section>
  <div id="side-resizer"></div>

</aside>

<div id="blog-body"></div>

</body>
</html>
>>>>>>> master
