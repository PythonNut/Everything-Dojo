<?php
  include('include/constants.php');

  //error_reporting("off"); uncomment for unnecessary "warnings" that PHP is smart enough to ignore
  /*************** PHP LOGIN SCRIPT V 1.0*********************
  (c) 2012-2014 Red Sun
  Based heavily off of Balakrishnan's PHP Login Script v2.3
  I now claim it as my own since I have changed so much it cannot be called his anymore.

  /************* MYSQL DATABASE SETTINGS ******************/
  define ("DB_HOST", "localhost"); // set database host
  define ("DB_USER", "cyneerco_evdo"); // set database user
  define ("DB_PASS", "3?x.L@r(5=%K"); // set database password
  define ("DB_NAME", "cyneerco_evdo"); // set database name
  define ("TB_NAME", "xxxxxxxxxxxx"); // set table name for containing users

  $link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
  $db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

  define('SALT_LENGTH', 9); // salt for password

  /* Specify user levels */
  define ("ADMIN_LEVEL", 5);
  define ("USER_LEVEL", 1);
  define ("GUEST_LEVEL", 0);

  date_default_timezone_set("America/New_York");

  /*************** reCAPTCHA KEYS****************/
  //https://www.google.com/recaptcha/admin/site?siteid=xxxxxxxxxxxx
  $publickey = "xxxxxxxxxxxx";
  $privatekey = "xxxxxxxxxxxx";

  //you're done. below is other stuff that you only need to modify if you need to modify it. :P :D

  /**** PAGE PROTECT CODE  ********************************
  This code protects pages to only logged in users. If users have not logged in then it will redirect to login page. Remember this code must be placed on very top of any html or php page.
  ********************************************************/

  function page_protect() {
    session_start();

    global $db;

    /* Secure against Session Hijacking by checking user agent */
    if (isset($_SESSION['HTTP_USER_AGENT'])) {
      if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
        logout();
        exit;
      }
    }

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) {
      header("Location: index.php");
      exit();
    }
  }

  function filter($data) {
    $data = trim(addslashes(htmlentities(strip_tags($data))));
    
    if (get_magic_quotes_gpc())
      $data = stripslashes($data);
    
    $data = mysql_real_escape_string($data);
    
    return $data;
  }

  function EncodeURL($url) {
    $new = strtolower(ereg_replace(' ','_',$url));
    return($new);
  }

  function DecodeURL($url) {
    $new = ucwords(ereg_replace('_',' ',$url));
    return($new);
  }

  function ChopStr($str, $len) {
    if (strlen($str) < $len)
      return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
        $str = substr($str,0,$spc_pos);

    return $str . "...";
  } 

  function isEmail($email) {
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
  }

  function isUserID($username) {
    if (preg_match('/^[a-z\d_]{3,20}$/i', $username)) {
      return true;
    } else {
      return false;
    }
   }  
   
  function isURL($url) {
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
      return true;
    } else {
      return false;
    }
  }

  function checkPwd($x, $y) {
    if(empty($x) || empty($y) ) { return false; }
    if (strlen($x) < 4 || strlen($y) < 4) { return false; }

    if (strcmp($x, $y) != 0) {
      return false;
    } 
    return true;
  }

  function GenPwd($length = 7) {
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
    
    $i = 0; 
    
    while ($i < $length) {
    
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

    }

    return $password;

  }

  function GenKey($length = 7) {
    $password = "";
    $possible = "0123456789abcdefghijkmnopqrstuvwxyz"; 

    $i = 0; 

    while ($i < $length) { 

      $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

      if (!strstr($password, $char)) { 
        $password .= $char;
        $i++;
      }

    }

    return $password;

  }

  function logout() {
    global $db;
    session_start();

    $table = TB_NAME;
    if(isset($_SESSION['user_id'])) {
      mysql_query("UPDATE $table
             SET ckey = '', ctime = ''
             WHERE id = $_SESSION[user_id]") or die(mysql_error());
    }

    /************ Delete the sessions****************/
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();

    header("Location: logoutdone.php");
  }

  // Password and salt generation
  function PwdHash($pwd, $salt = null) {
    if ($salt === null) {
      $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    } else {
      $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
  }

  function checkAdmin() {
    if ($_SESSION['user_level'] == ADMIN_LEVEL) {
      return 1;
    } else {
      return 0;
    }
  }

  function stringtoHTML($string) {
    $striphtml = strip_tags($string, '<a><b><i><u><ul><ol><li>');
    $explodeparagraphs = explode("\r\n\r\n", $string);
    array_filter($explodeparagraphs);
    $numparagraphs = count($explodeparagraphs);
    for ($i = 0; $i < $numparagraphs; $i++) {
      $thisparagraph = $explodeparagraphs[$i];
      $thisparagraph = str_replace( "\n", '<br />', $thisparagraph);
      $explodeparagraphs[$i] = "<p>".$thisparagraph."</p>";
    }
    $implode = addslashes(implode($explodeparagraphs)); //add slashes for PHP escaping
    return $implode;
  }

  function HTMLtostring($html) {
    $explode = explode("</p><p>", $html);
    $numparagraphs = count($explode);
    $explode[0] = substr($explode[0], 3);
    $explode[$numparagraphs - 1] = substr($explode[$numparagraphs - 1], 0, -4);
    for ($i = 0; $i < $numparagraphs; $i++) {
      $explode[$i] = str_replace('<br />', "\n", $explode[$i]);
    }
    $implode = implode("\r\n\r\n", $explode);
    return $implode;
  }

  /****************************END OF LOGIN SCRIPT FUNCTIONS*********************************/
  /*regular site functions*/

  function get_header($title = '', $extraStyle='', $extraJS = '', $html = '') {
    echo '<!DOCTYPE html>
          <html>
            <head>

              <title>Everything Dojo - ' . $title . '</title>

              <link rel="shortcut icon" href="/images/favicon.ico" />
              <link rel="stylesheet" type="text/css" href="/css/style.css" />
              ' .  $extra_style . '

              ' . $title == 'Home' ? '<script src="/js/jquery-2.1.1.min.js"></script>' : '' . '

              ' . $extraJS . '

              ' . NOSCRIPT . '

              ' . $html . '   
            </head>

            <body>

              <div id="wrap">
              ' . $title == 'Home' ? '
                <header>

                  <div id="headerwrap">

                    ' . $title == "Database" ? '

                    <script>$("header").addClass("database");</script>
                    <h1>Database</h1>

                    ' : $title == 'Themizer' ? '

                    <script>$("header").addClass("themizer");</script>
                    <h1>Themizer</h1>

                    ' : $title == 'Try-It' ? '

                    <script>$("header").addClass("tryit");</script>
                    <h1>Try-It</h1>

                    ' : $title == 'Discuss' ? '

                    <script>$("header").addClass("discuss");</script>
                    <h1>Discuss</h1>

                    ' : '

                    <div id="logo">
                      <a href="/"><img src="/images/logo.png"/></a>
                    </div>

                    <nav>
                      <ul>
                        <li><a href="/" id="nav-home">Home</a></li>
                        ' . isset($_SESSION['user_id']) ? '
                        <li><a href="myaccount.php" id="menu-myaccount">My Account</a></li>
                        <li><a href="mysettings.php" id="menu-mysettings">My Settings</a></li>
                        ' .  checkAdmin() ? '
                        <li><a href="admin.php" id="menu-admin">Admin CP</a></li>
                        ' : '' . '
                        <li><a href="logout.php" id="menu-logout">Logout</a></li>
                        ' : '' . '
                        ' . !isset($_SESSION['user_id']) ? '
                        <li><a href="login.php" id="menu-login">Login</a></li>
                        <li><a href="register.php" id="menu-register">Register</a></li>
                        ' : '' . '
                      </ul>
                    </nav>

                    ' . '

                  </div>

                </header>
                ' : '' . '
                <div id="content">';
  }

  function get_footer() {
    include("include/footer.php");
  }

  /*constants*/
  define("URL_DATABASE", "/database.php");
  define("URL_DISCUSS", "/discuss.php");
  define("URL_THEMIZER", "/themizer.php");
  define("URL_TRYIT", "/tryit.php");

  define("VERSION_DATABASE", "1.0");
  define("VERSION_DISCUSS", "1.0");
  define("VERSION_THEMIZER", "1.0");
  define("VERSION_TRYIT", "1.0");
?>