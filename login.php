<?php
include("include/include.php");

$table = TB_NAME;
$err = array();

foreach($_GET as $key => $value) {
  $get[$key] = filter($value); //get variables are filtered.
}

if (isset($_POST['doLogin'])) {

  foreach($_POST as $key => $value) {
    $data[$key] = filter($value); // post variables are filtered
  }

  $user_email = $data['username'];
  $pass = $data['pwd'];
  $user_cond = "user_name='$user_email'";

  $result = mysql_query("SELECT id, pwd, user_name, approved, user_level FROM $table WHERE $user_cond") or die (mysql_error());


  //PDO is commented out
  //$result = $dbc->prepare("SELECT id, pwd, user_name, approved, user_level FROM ? WHERE ?");
  //$result->execute(array($table, $user_cond));
  //$username_match = count($result->fetchAll(PDO::FETCH_ASSOC));

  $username_match = mysql_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated.
  if ($username_match > 0) {

    list($id, $pwd, $user_name, $approved, $user_level) = mysql_fetch_row($result); //replace with $result->fetchAll(PDO::FETCH_ASSOC)[0] for PDO

    if(!$approved) {
      $err[] = "Account not activated. Please contact the administrator to activate.";
    }

    //check against salt
    if ($pwd === PwdHash($pass, substr($pwd, 0, 9))) {
      if(empty($err)) {
        // this sets session and logs user in
        session_start();
        session_regenerate_id(TRUE); //prevent against session fixation attacks.

        // this sets variables in the session
        $_SESSION['user_id']= $id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_level'] = $user_level;
        $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

        //update the timestamp and key for cookie
        $stamp = time();
        $ckey = GenKey();
        mysql_query("UPDATE $table SET ctime = '$stamp', ckey = '$ckey' WHERE id = '$id'") or die(mysql_error());

        header("Location: myaccount.php");
      }
    } else {
      $err[] = "Invalid Login. Please check your password spelling and try again.";
    } //else if the password is bad

  } else {
    $err[] = "Invalid login. Please check your username spelling and try again.";
  } //else if the username wasn't found

} //if the page is logging in
?>
<?php
  $title = "Login";
  //dbc was already got at the top; don't try again
  get_header();
?>
  <?php //spit out all errors
  if(!empty($err))  {
    echo "<p id=\"errors\">";
    foreach ($err as $e) {
      echo $e."<br />";
    }
    echo "</p>";
  } ?>
  <p>Login in here! Don't have an account yet? Register <a href="register.php">here</a>. Forgot your password? Reset it <a href="forgot.php">here</a>. Registered, but haven't activated your account yet? Activate it <a href="activate.php">here</a>.</p>
  <form action="login.php" method="post" name="logForm" id="logForm">
    <label for="uname">Username</label>
    <input name="username" type="text" class="required" id="uname" size="25"><br />
    <label for="password">Password</label>
    <input name="pwd" type="password" class="required password" id="password" size="25"><br />
    <input name="doLogin" type="submit" value="Login">
  </form>
<?php get_footer(); ?>
