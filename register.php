<?php
include("include/include.php");

$table = TB_NAME;

$err = array();

$ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Checks if usernames are free
if ($ajax) {
  if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $query = "SELECT count(*) AS total FROM $table WHERE user_name=?";
    $rs_duplicate = $dbc->prepare($query);
    $rs_duplicate->execute(array($username));
    list($total) = $rs_duplicate->fetchColumn();

    if ($total > 0) {
      exit("error");
    } else {
      exit("success");
    }
  }

  // Checks if emails exist in database
  if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $query = "SELECT count(*) AS total FROM $table WHERE user_email=?";
    $rs_duplicate = $dbc->prepare($query);
    $rs_duplicate->execute(array($email));
    list($total) = $rs_duplicate->fetchColumn();

    if ($total > 0) {
      exit("error");
    } else {
      exit("success");
    }
  }
}

if((isset($_POST['ajax']) && $_POST['ajax'] === "true") && $ajax) {
  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  require_once('recaptchalib.php');

  $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  // Check/validate fields
  if (!$resp->is_valid) {
    exit("recaptcha");
  } elseif (!isUserID($data['user_name'])) {
    exit("username");
  } elseif (!isEmail($data['usr_email'])) {
    exit("email");
  } elseif (!checkPwd($data['pwd'], $data['pwd2'])) {
    exit("password");
  }

} elseif (isset($_POST['doRegister'])) {
  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  require_once('recaptchalib.php');

  $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    $err[] = "Image verification failed! Go back and try again.";
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
}

if (!empty($_POST)) {
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $sha1pass = PwdHash($data['pwd']);
  $host = $_SERVER['HTTP_HOST'];
  $activ_code = rand(1000, 9999);
  $usr_email = $data['usr_email'];
  $user_name = $data['user_name'];

  $query = "SELECT count(*) AS total FROM $table WHERE user_email=? OR user_name=?";
  $rs_duplicate = $dbc->prepare($query);
  $rs_duplicate->execute(array($usr_email, $user_name));
  list($total) = $rs_duplicate->fetchColumn();

  if ($total > 0) {
    if ($ajax) {
      exit("username or email exists");
    } else {
      $err[] = "The username/email already exists. Please try again with different username and email." ;
    }
  }

  if (empty($err)) {
    $sql_insert = $dbc->prepare("INSERT INTO $table (user_email, pwd, date, users_ip, activation_code, user_name) VALUES (?,?,NOW(),?,?,?)");
    $sql_insert->execute(array($usr_email,$sha1pass,$user_ip,$activ_code,$user_name));
    $user_id = $dbc->lastInsertId();
    $md5_id = md5($user_id);
    $dbc->prepare("UPDATE $table SET md5_id=? WHERE id=?")->execute(array($md5_id,$user_id));

    $a_link = "You can activate your account at this link:\nhttp://$host/activate.php?user=$md5_id&activ_code=$activ_code";

    $message = <<<EOT
Hello,

Thank you for registering with us. Here are your login details:

User ID: $user_name
Activation Code: $activ_code

$a_link

Administrator @ Everything Dojo
__________________________________________________________
This is an automated response. Do not reply to this email.

EOT;

    mail($usr_email, "Thank you for registering with Everything Dojo", $message, "From: \"Everything Dojo Registration\" <no-reply@$host>\r\n");

    if (!$ajax) {
      header("Location: register.php?done=yes");
    }
    exit("success");
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
<section id="content">
  <?php
  if (isset($_GET['done'])) { ?>
  <p>Thank you; your registration is now complete. After activation, you can login <a href="login.php">here</a>.</p>
  <?php
  } else { ?>

  <p id="errors">
    <?php //spit out all errors
    if (!empty($err)) {
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
      <input name="user_name" type="text" class="required username">
      <img class="wait" src="images/loading.gif" alt="Please wait...">
    </div>
    <label>Email</label>
    <label class="small i">Must be valid. We'll use it to send you confirmation information and other important things like that. We'll keep it completely hush-hush, promise.</label>
    <div class="field">
      <input name="usr_email" type="text" class="required email">
      <img class="wait" src="images/loading.gif" alt="Please wait...">
    </div>
    <label>Password</label>
    <label class="small i">Must be at least 6 characters long.</label>
    <div class="field">
      <input name="pwd" type="password" class="required password">
    </div>
    <label>Retype Password</label>
    <div class="field">
      <input name="pwd2" type="password" class="required password">
    </div>
    <label>Image Verification</label>
    <div class="field">
      <?php
        require_once('recaptchalib.php');
        echo recaptcha_get_html($publickey);
      ?>
      <div id="message"></div>
    </div>
    <input type="hidden" name="ajax" value="false">
    <div class="field">
      <input name="doRegister" type="submit" id="doRegister" value="Register" disabled>
      <img class="wait" src="images/loading.gif" alt="Please wait...">
    </div>
  </form>
  <?php } //end not done ?>
</section>
<?php get_footer(); ?>
