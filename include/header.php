<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">
    <link href="/images/favicon.ico" rel="shortcut icon">
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">
    <?php if ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title != "Try-It") { ?>
    <link href="/css/normalize.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <?php } ?>
    <?php global $extra_style; print $extra_style; ?>

    <?php //I've decided to go back to having jQuery on all pages; it is important to have script.js on all bc notifications; and come on, it isn't noticiably more loading time. nmk read this note, remove it. -Red ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/script.js"></script><?php //important notfication js has been moved to script.js ?>
    <?php global $extra_js; print $extra_js; ?>

    <noscript>
      <link href="/css/noscript.css" rel="stylesheet">
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
          <a href="<?php echo URL_DATABASE; ?>"><h1>Database</h1></a>

          <?php
          global $mode;

          if ($mode == "view") { ?>
            <div class="search-container">
              <script src="/js/highlight.js"></script>
              <script src="/js/db-search.js"></script>
              <input class="search" type="text" placeholder="Search...">
              <div class="icon-box">
                <span class="search-icon"></span>
              </div>
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

      <?php } elseif ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title !== "Try-It") { ?>

      <?php global $notification_unread_count; ?>

      <header>
        <section id="headerwrap">

          <nav class="breadcrumbs">
            <div id="logo">
              <a href="/"><?php print isset($_GET['unicorns']) ? '<img src="/images/unicorns.png" alt="Unicorns" style="margin-top:1rem" />' : '<img src="/images/logo.svg" alt="Logo" />'; ?></a>
            </div>
            <h1 class="big">> <?php echo $title; ?></h1>
          </nav>

          <?php if ($title == "Themizer Index") { ?>
          <nav>
            <ul>
              <li><a onclick="$('#features').scrollTo()">Features</a></li>
              <li><a onclick="$('#changelog').scrollTo()">Changelog</a></li>
              <li><a onclick="$('#roadmap').scrollTo()">Roadmap</a></li>
            </ul>
          </nav>
          <?php } else { ?>
          <nav>
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
              <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="/myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="/mysettings.php" id="menu-mysettings">My Settings</a></li>
              <li><a href="javascript:;" onClick="show_notifications()" class="notification-link">Notifications <?php if (isset($notification_unread_count)) { echo "(".$notification_unread_count.")"; } ?></a></li>
              <li><a href="/logout.php" id="menu-logout">Logout</a></li>
              <?php } else { ?>
              <li><a href="/login.php" id="menu-login">Login</a></li>
              <li><a href="/register.php" id="menu-register">Register</a></li>
              <?php } ?>
            </ul>
          </nav>
          <?php } ?>

        </section>
      </header>

      <?php } ?>
