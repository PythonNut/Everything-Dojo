<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">

    <link href="images/favicon.ico" rel="shortcut icon">
    <?php if ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)") { ?>
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
          <h1>' . $title . '</h1>
        </section>
      </header>';
      } elseif ($title == "Try-it") {
      ?>

      <header class="tryit">
        <section id="headerwrap">
          <h1>Try-It</h1>
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

          <figure id="logo">
            <a href="/"><img src="/images/logo.svg"/></a>
          </figure>

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
