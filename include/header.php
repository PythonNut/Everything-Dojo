<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">
    <link href="/images/favicon.ico" rel="shortcut icon">
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">
    <?php if ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title != "Try-It") { ?>
    <link href="/css/normalize.css" type="text/css" rel="stylesheet">
    <link href="/css/style.css" type="text/css" rel="stylesheet">
    <?php } ?>
    <?php global $extra_style; print $extra_style; ?>

    <?php
    // we don't need jQuery on some pages
    if ($title != "Home" || $title != "About") { ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/script.js"></script>
    <?php } ?>
    <?php
    if ($title == "Try-It") { ?>
    <link href='css/blog-style.css' rel='stylesheet' type='text/css'>
    <link href='css/tryit.css' rel='stylesheet' type='text/css'>
    <?php } ?>

    <?php global $extra_js; print $extra_js; ?>

    <noscript>
      <link href="/css/noscript.css" type="text/css" rel="stylesheet">
    </noscript>

  </head>

  <body>

    <?php if (!in_array($title, array(
        "Home",
        "About",
        "Account Activation",
        "Forgot Password",
        "Logout Successful",
        "403",
        "404",
        "410",
        "418",
        "500"
      ))) {
      include("error/noscript.php");
    } ?>

    <main id="wrap">

      <?php if ($title == "Database") { ?>

      <header class="database">
        <section id="headerwrap">
          <a href="<?php echo URL_DATABASE; ?>"><h1><?php echo $title ?></h1></a>
          <?php
          global $mode;

          if ($mode == "view") { ?>
            <div class="search-container">
              <script src="/js/db-search.js"></script>
              <input class="search" type="text" placeholder="Search...">
              <div class="icon-box">
                <span class="search-icon"></span>
              </div>
          <?php } ?>

        </section>
      </header>

      <?php } elseif ($title == "Discuss") { ?>

      <header class="discuss">
        <section id="headerwrap">
          <a href="<?php echo URL_DISCUSS; ?>"><h1>Discuss</h1></a>
        </section>
      </header>

      <?php } elseif ($title == "Try-It") { ?>

      <header class="tryit">
        <section id="headerwrap">

          <h1 style="text-align:left !important"><a href="tryit.php">Try-It</a></h1>

          <form method="get" id="select-theme" name="select-theme" style="margin-left:4em;font-family:Amble,sans-serif">
            <section class="option-wrap" style="display:inline-block">
              <select id="select" name="select" onchange="this.form.submit()" style="color:black;font-family:Amble,sans-serif">
              <option value="" selected>======= SELECT ONE =======</option>
              <?php
                include("db.php");
                include("themedb.php");
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
            <section style="display:inline-block;">
              <label style="margin:0px;padding:0px;height:15px;color:black;font-size:15px;font-family:Amble,sans-serif;display:inline-block">Development Mode:
              <?php if ($_GET['dev'] == "dev") {
                echo '<input type="checkbox" value="dev" name="dev" onChange="this.form.submit();" style="display:inline-block;" checked/>';
              } else {
                echo '<input type="checkbox" value="dev" name="dev" onChange="var confirm=window.confirm(\'Warning: Development mode means that you can try ALL the styles, including incomplete, in-development and/or buggy CSS. These styles are not recommended for your blog.\n\nDo you really wish to continue?\');if(confirm)this.form.submit();else this.checked=false;" style="display:inline-block;"/>';
              } ?>
              </label>
            </section>
            <?php if (!empty($_GET['select'])) {
              echo '<a style="display:inline-block;font-size:15px;height:15px;margin-left:15px;" href="database.php?mode=view&view=style&id='.intval($_GET['select']).'">View style in Database</a>';
            } ?>
          </form>

        </section>
      </header>

      <?php } elseif ($title == "Themizer Index") { ?>

      <header id="top">
        <section id="headerwrap">
          <nav class="breadcrumbs">
            <div id="logo">
              <a href="/"><?php print isset($_GET['unicorns']) ? '<img src="/images/unicorns.png" alt="Unicorns" style="margin-top:1rem" />' : '<img src="/images/logo.svg" alt="Logo" />'; ?></a>
            </div>
            <h1 class="big">
              > <a class="uppercase" href="">Themizer</a>
            </h1>
          </nav>

          <nav>
            <ul>
              <li><a onclick="$('#top').scrollTo()">Home</a></li>
              <li><a onclick="$('#features').scrollTo()">Features</a></li>
              <li><a onclick="$('#changelog').scrollTo()">Changelog</a></li>
              <li><a onclick="$('#roadmap').scrollTo()">Roadmap</a></li>
            </ul>
          </nav>

        </section>
      </header>

      <?php } elseif ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)") { ?>

        <?php
          global $notification_unread_count;
        ?>

      <header>
        <section id="headerwrap">

          <div id="logo">
            <a href="/"><?php print isset($_GET['unicorns']) ? '<img src="/images/unicorns.png" alt="Unicorns" style="max-width:10rem;max-height:5rem;margin-top:.5rem" />' : '<img src="/images/logo.svg" alt="Logo" />'; ?></a>
          </div>

          <nav>
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="/myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="/mysettings.php" id="menu-mysettings">My Settings</a></li>
              <li><a href="javascript:;" onClick="show_notifications()" class="notification-link">Notifications <?php if (isset($notification_unread_count)) { echo "(".$notification_unread_count.")"; } ?>)</a></li>
              <li><a href="/logout.php" id="menu-logout">Logout</a></li>
            <?php } else { ?>
              <li><a href="/login.php" id="menu-login">Login</a></li>
              <li><a href="/register.php" id="menu-register">Register</a></li>
            <?php } ?>
            </ul>
          </nav>
        </section>
      </header>

      <?php } ?>
