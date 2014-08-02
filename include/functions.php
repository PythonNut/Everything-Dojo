<?php
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

    // No need for this with PDO
    // $data = mysql_real_escape_string($data);
    // Please replace with mysqli and setup a fake link
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
    return preg_match('/^\S+@([\w\d.-]{2,}\.[\w]{2,6}|localhost)$/iU', $email) ? TRUE : FALSE;
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
    global $dbc;
    session_start();

    $table = TB_NAME;
    if(isset($_SESSION['user_id'])) {
      $result = $dbc->prepare("UPDATE $table SET ckey = '', ctime = '' WHERE id = ?");
      $result->execute(array($_SESSION['user_id']));
    }

    /************ Delete the sessions****************/
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();

    header("Location: index.php?msg=You have been successfully logged out.");
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

  function br2nl($string) {
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
  }

  /****************************END OF LOGIN SCRIPT FUNCTIONS*********************************/
  /*regular site functions*/

  function get_header() {
    include("include/header.php");
  }

  function get_footer() {
    include("include/footer.php");
  }
?>
