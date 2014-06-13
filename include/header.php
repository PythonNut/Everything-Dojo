<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php global $extra_style; print $extra_style; ?>

    <?php
    // we don't need jQuery on some pages
    if ($title != "Home" || $title != "About") { ?>
    <script src="js/jquery-2.1.1.min.js"></script>
    <?php } ?>

    <?php global $extra_js; print $extra_js; ?>

    <noscript>
      <link rel="alternate stylesheet" type="text/css" href="css/noscript.css">
    </noscript>
    
  </head>

  <body>

    <?php include("noscript.php"); ?>

    <div id="wrap">

      <header>

        <div id="headerwrap">

          <?php if ($title == "Database") { ?>

          <script>$("header").addClass("database");</script>
          <h1>Database</h1>

          <?php } elseif ($title == "Themizer") { ?>

          <script>$("header").addClass("themizer");</script>
          <h1>Themizer</h1>

          <?php } elseif ($title == "Try-It") { ?>

          <script>$("header").addClass("tryit");</script>
          <h1>Try-It</h1>

          <?php } elseif ($title == "Discuss") { ?>

          <script>$("header").addClass("discuss");</script>
          <h1>Discuss</h1>

          <?php } else { ?>

          <div id="logo">
            <a href="/"><img src="/images/logo.png"/></a>
          </div>

          <nav>
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="mysettings.php" id="menu-mysettings">My Settings</a></li>
              <?php 
              // will not work if dbc is not included on page
              if (checkAdmin()) {
              ?>
              <li><a href="admin.php" id="menu-admin">Admin CP</a></li>
              <?php } //end admin ?>
              <li><a href="logout.php" id="menu-logout">Logout</a></li>
            <?php } ?>
            <?php if(!isset($_SESSION['user_id'])) { ?>
              <li><a href="login.php" id="menu-login">Login</a></li>
              <li><a href="register.php" id="menu-register">Register</a></li>
            <?php } ?>
            </ul>
          </nav>

          <?php } ?>

        </div>

      </header>
  
      <div id="content">

