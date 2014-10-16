<?php
  /* FUNCTIONS */
  //Generally linked to the login system.

  /* Page Protect: Redirects to index.php if visiting a page while not logged in that is protected by this function.*/
  function page_protect() {
    session_start();

    global $db;

    /* Secure against session hijacking by checking user agent & user ip */
    if (isset($_SESSION['HTTP_USER_AGENT']) && (isset($_SESSION['HTTP_X_FORWARDED_FOR']) || isset($_SESSION['REMOTE_ADDR']))) {
      if ($_SESSION['HTTP_USER_AGENT'] != sha1($_SERVER['HTTP_USER_AGENT']) && ($_SESSION['HTTP_X_FORWARDED_FOR'] != sha1($_SERVER['HTTP_X_FORWARDED_FOR']) || $_SESSION['REMOTE_ADDR'] != sha1($_SERVER['REMOTE_ADDR']))) {
        logout();
        exit();
      }
    }

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) {
      header("Location: index.php");
      exit();
    }
  }

  function get_user($user_id) {
    global $dbc;

      $sth = $dbc->prepare("SELECT * FROM `users` WHERE `id` = :id");
      $sth->execute(array(
        ':id' => intval($user_id)
      ));
      $name = $sth->fetch(PDO::FETCH_ASSOC);
      $name = $name['user_name'];
      return $name;
  }

  function get_all_user($user_id) {
      global $dbc;

      $sth = $dbc->prepare("SELECT * FROM `users` WHERE `id` = :id");
      $sth->execute(array(
        ':id' => intval($user_id)
      ));
      $user = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $user[0];
  }


  function filter($data) {
    $data = trim(addslashes(htmlentities(strip_tags($data))));

    if (get_magic_quotes_gpc())
      $data = stripslashes($data);

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
    return preg_match('/^\S+@[\w\d.-]{2,}\.[a-z]{2,6}$/iU', $email) ? TRUE : FALSE;
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
    if (strlen($x) < 6 || strlen($y) < 6) { return false; }

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

    //delete the session information
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();

    header("Location: index.php?msg=You have been successfully logged out.");
  }

  // Password and salt generation
  function PwdHash($pwd, $salt = NULL) {
    if ($salt === NULL) {
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

  function shorten_desc($description){
    $description = br2nl($description);
    $count = str_word_count($description);
    $description = implode(' ', array_slice(explode(' ', $description), 0, 10));
    if(strlen($description) > 80) {
      $description = substr($description, 0, 80);
    }
    if($count > 10){
      $description .= ' (...)';
    }

    return $description;
  }

  function redirect($url) {
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
  }

  /****************************END OF LOGIN SCRIPT FUNCTIONS*********************************/
  /*regular site functions*/

  function get_header($n = 0) {
    include(str_repeat('../', $n) . "include/header.php");
  }

  function get_footer($n = 0) {
    include(str_repeat('../', $n) . "include/footer.php");
  }

  /**
  * Send a POST requst using cURL
  * @param string $url to request
  * @param array $post values to send
  * @param array $options for cURL
  * @return string
  */
  function curl_post($url, array $post = NULL, array $options = array()) {
    $defaults = array(
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_URL => $url,
      CURLOPT_FRESH_CONNECT => 1,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_FORBID_REUSE => 1,
      CURLOPT_TIMEOUT => 4,
      CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
      trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
  }
?>
