<?php
include("include/include.php");

$table = TB_NAME;

if (isset($_POST['doReset'])) {
  $err = array();
  $msg = array();
  foreach ($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  if (!isEmail($data['user_email'])) {
    $err[] = "Please enter a valid email";
  }

  $user_email = $data['user_email'];
  //check if activ code and user is valid as precaution
  $rs_check = $dbc->prepare("SELECT id FROM $table WHERE user_email=?");
  $rs_check->execute(array($user_email));
  $num = $rs_check->rowCount();
  if ($num <= 0) {
    $err[] = "Sorry, no such account exists.";
  }

  if (empty($err)) {

    $new_pwd = GenPwd();
    $pwd_reset = PwdHash($new_pwd);
    //set update sha1 of new password + salt
    $rs_activ = $dbc->prepare("UPDATE $table SET pwd=? WHERE user_email='?'");
    $rs_activ->execute(array($pwd_reset, $user_email));
    $host = $_SERVER['HTTP_HOST'];

    //send email
    $message =
"Hello,

You are receiving this email since you reset your password recently. Here are your new password details:

Password: $new_pwd

You can now login with this password and change it to something you'll remember, via My Settings.

Administrator @ Everything Dojo
______________________________________________________
This is an automated response. Do not reply to this email.";

    mail($user_email, "EvDo Password Reset", $message, "From: \"Everything Dojo Forgotbot\" <no-reply@$host>\r\n");
    $msg[] = "Your account password has been reset and a new password has been sent to your email address.";
  }
}
?>
<?php
  $title = "Forgot Password";
  //dbc already included
  session_start();
  get_header();
?>
<section id="content">
  <?php //spit out all errors
  if(!empty($err))  {
    echo "<p id=\"errors\">";
    foreach ($err as $e) {
      echo $e."<br />";
    }
    echo "</p>";
  }

  if(!empty($msg))  {
    echo "<div class=\"msg\">" . $msg[0] . "</div>";
  } else {
  ?>
<section id="content">
  <p>If you have forgot your password, you can reset it and a new password will be sent to your email address.</p>

  <form action="forgot.php" method="post" name="actForm" id="actForm">
    <label>Your Email</label>
    <input name="user_email" type="text" class="required email" size="25">
    <input name="doReset" type="submit" value="Reset">
  </form>
  <?php } //end else (that there's no messages) ?>
</section>

<?php get_footer(); ?>
