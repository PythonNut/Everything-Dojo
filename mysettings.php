<?php 
include ("dbc.php");

$table = TB_NAME;
page_protect();

$err = array();
$msg = array();

if(isset($_POST['doUpdate'])) {

  $rs_pwd = mysql_query("SELECT pwd FROM $table WHERE id=\"".$_SESSION['user_id']."\"");
  list($old) = mysql_fetch_row($rs_pwd);
  $old_salt = substr($old, 0, 9);

  //check for old password in md5 format
  if($old === PwdHash($_POST['pwd_old'], $old_salt)) {
    if(checkPwd($_POST['pwd_new'], $_POST['pwd_again'])) {
      $newsha1 = PwdHash($_POST['pwd_new']);
      mysql_query("UPDATE $table SET pwd=\"".$newsha1."\" WHERE id=\"".$_SESSION['user_id']."\"");
      $msg[] = "Your password has been updated!";
    } else {
      $err[] = "Passwords must be at least 4 characters long, or your new passwords don't match.";
    }
  } else {
    $err[] = "Your old password is incorrect. Please check your spelling and try again.";
  }

}

/* if you decide to add profile settings (address, name, telephone, dumb things like that i never need)
if(isset($_POST['doSave'])) {

  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  mysql_query("UPDATE ".$table." SET user_email = \"".$data['user_email']."\" WHERE id=\"".$_SESSION['user_id']."\"") or die(mysql_error());

  $msg[] = "Profile sucessfully updated!";
}

then loop
while ($row_settings = mysql_fetch_array($rs_settings)) {}
and output a bunch of forms
*/
 
$rs_settings = mysql_query("SELECT * FROM $table WHERE id=\"".$_SESSION['user_id']."\""); 
?>
<?php
  $title = "My Settings";
  //dbc already included
  page_protect();
  get_header($title);
?>
  <?php
  if(!empty($err))  {
    echo "<p id=\"errors\">";
    foreach ($err as $e) {
      echo $e."<br />";
    }
    echo "</p>";
  }

  if(!empty($msg))  {
    echo "<div class=\"msg\">".$msg[0]."</div>";
  } else { ?>
  <h2>My Settings</h2>
  <p>Here you can make changes to your profile. Right now, the only thing you can change is your password.</p>
  <form name="pform" id="pform" method="post" action="mysettings.php">
    <label>Old Password</label>
    <input type="password" name="pwd_old" />
    <label>New Password</label>
    <input type="password" name="pwd_new" />
    <label>Retype Password</label>
    <input type="password" name="pwd_again" />
    <input type="submit" name="doUpdate" />
  </form>
  <?php } //end no msg ?>
<?php get_footer(); ?>