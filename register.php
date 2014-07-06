<?php
include("include/include.php");

$table = TB_NAME;

$err = array();

/**
 * Checks if usernames are free, used in conjunction with AJAX
 */

// if (isset($_GET['username'])) { // && isset($_GET['email'])) {
//   $username = $_GET['username'];
//   $email = $_GET['email'];
//   $rs_duplicate = mysql_query("SELECT count(*) AS total FROM $table WHERE user_name='$username'") or die(mysql_error()); // TODO: add user email
//   list($total) = mysql_fetch_row($rs_duplicate);
//
//   if ($total > 0) {
//     http_response_code(400);
//   } else {
//     http_response_code(200);
//   }
// }

if(isset($_POST['doRegister']))  {
  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  require_once('recaptchalib.php');

  $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    $err[] = "Image Verification failed! Go back and try again.";
  }

  // Validate User Name
  if (!isUserID($data['user_name'])) {
    $err[] = "Invalid user name! It must be 3-20 characters long, and can only contain alphanumeric characters and underscores.";
  }

  // Validate Email
  if(!isEmail($data['usr_email'])) {
    $err[] = "Invalid email address! Well, it just wasn't an email address.";
  }
  // Check User Passwords
  if (!checkPwd($data['pwd'], $data['pwd2'])) {
    $err[] = "Invalid password or mismatch! Passwords must be at least 4 characters long and both fields must match.";
  }

  $user_ip = $_SERVER['REMOTE_ADDR'];
  $sha1pass = PwdHash($data['pwd']);
  $host = $_SERVER['HTTP_HOST'];
  $activ_code = rand(1000, 9999);
  $usr_email = $data['usr_email'];
  $user_name = $data['user_name'];

  //$rs_duplicate = $dbc->prepare("SELECT count(*) AS total FROM $table WHERE user_email=? OR user_name=?");
  //$rs_duplicate->execute(array($usr_email,$user_name));
  //$list($total) = $rs_duplicate->fetchAll(PDO::FETCH_ASSOC)[0];
  $rs_duplicate = mysql_query("SELECT count(*) AS total FROM $table WHERE user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
  list($total) = mysql_fetch_row($rs_duplicate);

  if ($total > 0) {
    $err[] = "The username/email already exists. Please try again with different username and email.";
    //header("Location: register.php?msg=$err");
    //exit();
  }

  if(empty($err)) {

    //$sql_insert = "INSERT INTO $table (user_email, pwd, date, users_ip, activation_code, user_name) VALUES ('$usr_email', '$sha1pass', now(), '$user_ip', '$activ_code', '$user_name')";
    $sql_insert = $dbc->prepare("INSERT INTO $table (user_email, pwd, date, users_ip, activation_code, user_name) VALUES (?,?,now(),?,?,?)");
    $sql_insert->execute(array($usr_email,$sha1pass,$user_ip,$activ_code,$user_name));
    //mysql_query($sql_insert,$link) or die("Insertion Failed: ".mysql_error());
    //$user_id = mysql_insert_id($link);
    $user_id = $dbc->lastInsertId();
    $md5_id = md5($user_id);
    //mysql_query("UPDATE $table SET md5_id='$md5_id' WHERE id='$user_id'");
    $dbc->prepare("UPDATE $table SET md5=? WHERE id=?")->execute(array($md5_id,$user_id));
    $pwdcensored = substr($data['pwd'], 0, 3).str_repeat("*", strlen($data['pwd']) - 3);

    $a_link = "You can activate your account at this link:\nhttp://$host/activate.php?user=$md5_id&activ_code=$activ_code";

    $message =
"Hello,

Thank you for registering with us. Here are your login details:

User ID: $user_name
Password: $pwdcensored
Activation Code: $activ_code

$a_link

Administrator @Everything Dojo
______________________________________________________
This is an automated response. Do not reply to this email.";

    mail($usr_email, "Thank you for registering with Everything Dojo", $message, "From: \"Everything Dojo Registration\" <auto-reply@$host>\r\n");

    header("Location: register.php?done=yes");
    exit();
  }
}

?>
<?php
  $title = "Register";
  $extra_js = "<script src='js/register.js'></script>";
  //dbc already included
  session_start();
  get_header();
?>
  <?php
  if (isset($_GET['done'])) { ?>
  <p>Thank you; your registration is now complete. After activation, you can login <a href="login.php">here</a>.</p>
  <?php
  } else { ?>

  <p id="errors">
    <?php //spit out all errors
    if(!empty($err))  {
      foreach ($err as $e) {
        echo "ERROR - ".$e."<br />";
      }
    } ?>
  </p>

  <p>Register here. Please fill out all fields.</p>
  <form action="register.php" method="post" name="regForm">
    <label>Username</label>
    <label class="small i">Only letters, numbers, and underscores, from 3-20 characters long.</label>
    <div class="field">
      <input name="user_name" type="text" class="required username" onkeyup="validate(this.name)" onblur="err(this.name, 'remove')">
    </div>
    <label>Email</label>
    <label class="small i">Must be valid. We'll use it to send you confirmation information and other important things like that. We'll keep it completely hush-hush, promise.</label>
    <div class="field">
      <input name="usr_email" type="text" class="required email" onkeyup="validate(this.name)" onblur="err(this.name, 'remove')">
    </div>
    <label>Password</label>
    <label class="small i">Must be at least 6 characters long.</label>
    <div class="field">
      <input name="pwd" type="password" class="required password" onkeyup="validate(this.name)" onblur="err(this.name, 'remove')">
    </div>
    <label>Retype Password</label>
    <div class="field">
      <input name="pwd2" type="password" class="required password" id="pwd2" onkeyup="validate(this.name)" onblur="err(this.name, 'remove')">
    </div>
    <label>Image Verification</label>
    <div class="field">
    <?php
      require_once('recaptchalib.php');
      echo recaptcha_get_html($publickey);
    ?>
    </div>
    <input name="doRegister" type="submit" id="doRegister" value="Register">
  </form>
  <?php } //end not done ?>
<?php get_footer(); ?>
