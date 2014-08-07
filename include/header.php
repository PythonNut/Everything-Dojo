<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">
    <link href="/images/favicon.ico" rel="shortcut icon">
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

      <?php
      if (in_array($title, array("Database", "Discuss"))) {
        echo '<header class="' . strtolower($title) . '">
        <section id="headerwrap">
          <h1><a href="' . strtolower($title) . '.php">' . $title . '</a></h1>
        </section>
      </header>';
      } elseif ($title == "Try-It") {
      ?>

      <header class="tryit">
        <section id="headerwrap">

          <h1 style="text-align: left !important;"><a href="tryit.php">Try-It</a></h1>

          <form method="get" id="select-theme" name="select-theme" style="margin-left:4em;">
            <section class="option-wrap">
              <select id="select" name="select">
              <?php
                include("db.php");
                include("themedb.php");
                $data = $themedb->get_themes();
                //cache the theme id
                $ids = $data['validated']['id'];
                $names = $data['validated']['name'];
                $selected = $_GET['select'];
                foreach ($names as $key => $theme) {
                  if ($selected == $ids[$key]){
                    echo '<option id="'.$ids[$key].'" name="'.$ids[$key].'" value="'.$ids[$key].'" selected>'.$theme.'</option>';
                  }
                  else{
                    echo '<option id="'.$ids[$key].'" name="'.$ids[$key].'" value="'.$ids[$key].'">'.$theme.'</option>';
                  }

                }
              ?>
              </select>
            </section>
            <input type="submit" id="select-submit" name="select-submit" value="Go!" class="tryit-button"/>
          </form>
        </section>
      </header>

      <?php } elseif ($title == "Themizer Index") { ?>

      <header id="top">
        <section id="headerwrap">
          <nav class="breadcrumbs">
            <div id="logo">
              <a href="/"><img src="/images/logo.svg" alt="Logo" /></a>
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

      <header>
        <section id="headerwrap">

          <div id="logo">
            <a href="/"><img src="/images/logo.svg" alt="Logo" /></a>
          </div>

          <nav>
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="/myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="/mysettings.php" id="menu-mysettings">My Settings</a></li>
              <?php
              // will not work if dbc is not included on page
              if (checkAdmin()) {
              ?>
              <li><a href="/admin.php" id="menu-admin">Admin CP</a></li>
              <?php } //end admin ?>
              <li><a href="/logout.php" id="menu-logout">Logout</a></li>
            <?php } ?>
            <?php if(!isset($_SESSION['user_id'])) { ?>
              <li><a href="/login.php" id="menu-login">Login</a></li>
              <li><a href="/register.php" id="menu-register">Register</a></li>
            <?php } ?>
            </ul>
          </nav>
        </section>
      </header>

      <?php } ?>
