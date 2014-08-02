<?php
include("include/include.php");

$table = TB_NAME;

foreach ($_GET as $key => $value) {
  $get[$key] = filter($value);
}

/******** EMAIL ACTIVATION LINK**********************/
if(isset($get['user']) && !empty($get['activ_code']) && !empty($get['user']) && is_numeric($get['activ_code']) ) {
  $err = array();
  $msg = array();
  $user = $get['user'];
  $activ = $get['activ_code'];
  $rs_check = $dbc->prepare("SELECT id FROM ".$table." WHERE md5_id=? AND activation_code=?");
  $rs_check->execute(array($user, $activ));
  $rs_check->fetchAll(PDO::FETCH_ASSOC);
  $num = $rs_check->rowCount();
  // Match row found with more than 1 results  - the user is authenticated.
  if ($num <= 0) {
    $err[] = "Sorry, no such account exists or the activation code is invalid.";
  }

  if(empty($err)) {
  // set the approved field to 1 to activate the account
    $rs_activ = $dbc->prepare("UPDATE ".$table." SET approved='1' WHERE md5_id=? AND activation_code = ? ");
    $rs_activ->execute(array($user, $activ));

    $msg[] = "Thank you. Your account has been activated. You can now <a href=\"login.php\">login</a>.";
  }
}

/******************* ACTIVATION BY FORM**************************/
if (isset($_POST['doActivate'])) {
  $err = array();
  $msg = array();
  $user_email = $_POST['user_email'];
  $activ = $_POST['activ_code'];
  $rs_check = $dbc->prepare("SELECT id FROM ".$table." WHERE user_email=? AND activation_code=?");
  $rs_check->execute(array($user_email, $activ));
  $rs_check->fetchAll(PDO::FETCH_ASSOC);
  $num = $rs_check->rowCount();


  // Match row found with more than 1 results  - the user is authenticated.
  if ($num <= 0) {
    $err[] = "Sorry, no such account exists or the activation code is invalid.";
  }
  //set approved field to 1 to activate the user
  if(empty($err)) {
    $rs_activ = $dbc->prepare("UPDATE ".$table." SET approved='1' WHERE user_email=? AND activation_code = ?");
    $rs_activ->execute(array($user_email,$activ));

    $msg[] = "Thank you. Your account has been activated. You can now <a href=\"login.php\">login</a>.";
  }
}

if(isset($_POST['doResend'])) {
  $err = array();
  $msg = array();



  $user_email = $_POST['user_email']; //no escaping needed because of PDO
  $rs_check = $dbc->prepare("SELECT md5_id, approved, activation_code FROM ".$table." WHERE user_email = ?");
  $rs_check->execute(array($user_email));
  $row = $rs_check->fetchAll(PDO::FETCH_ASSOC);
  $num = $rs_check->rowCount();
  // Match row found with more than 1 results  - the user is authenticated.
  if ($num <= 0) {
    $err[] = "Sorry, that email isn't registered.";
  } elseif ($row[0]['approved'] == 1) {
    $err[] = "That account has already been activated! No need to get the activation code again!";
  }

  if (empty($err)) {
    $host = $_SERVER['HTTP_HOST'];
$message = "Hello,

You have recently requested for your activation code to be resent to you. Here it is:

Activation Code: ".$row[0]['activation_code']."

You can now visit http://$host/activate.php to activate your account, or, alternately, http://$host/activate.php?user=" . $row[0]['md5_id'] . "&activ_code=" . $row[0]['activation_code'] . ".

Administrator @Login Site
______________________________________________________
This is an automated response. Do not reply to this email.";

    mail($user_email, "Login Site Activation Code", $message, "From: \"Login Site Forgotbot\" <auto-reply@$host>\r\n");

    header("Location: activate.php?done=yes");
    exit();
  }
}
?>
<?php
  $title = "Account Activation";
  //dbc has been included already
  session_start();
  get_header();
?>
  <?php //spit out all errors
  if(!empty($err))  {
    echo "<p id=\"errors\">";
    foreach ($err as $e) {
      echo "ERROR - ".$e."<br />";
    }
    echo "</p>";
  }

  if(isset($_GET['done']))  {
    echo "<div class=\"msg\">" . "Your activation code has been sent to your email address again. Instructions are included for activation." . "</div>";
  } elseif (!empty($msg)) {
    echo "<div class=\"msg\">".$msg[0]."</div>";
  } else { ?>

  <p>Please enter your email and activation code sent to you to your email address to activate your account. Once your account is activated you can <a href="login.php">login here</a>.</p>
  <form action="activate.php" method="post" name="actForm" id="actForm">
    <label>Email</label>
    <input name="user_email" type="text" size="25" />
    <label>Activation Code</label>
    <input name="activ_code" type="password" size="25" />
    <input name="doActivate" type="submit" value="Activate" />
  </form>

  <p>Can't find the email with the activation code? Get it resent to you:</p>
  <form action="activate.php" method="post" name="resend" id="resendForm">
    <label>Email</label>
    <input name="user_email" type="text" size="25" />
    <input name="doResend" type="submit" value="Resend" />
  </form>
  <?php } //end no messages ?>
<?php get_footer(); ?>
