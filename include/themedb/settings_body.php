<?php
$id = $_GET['id'];
$edit = $themedb->check_owner($id, $_SESSION['user_id']);
if($edit == false && checkAdmin() == 0){
  redirect(URL_DATABASE);
}
else{
  if(checkAdmin() == 0){
    $style = $themedb->get_themes($id, false, $_SESSION['user_id']);
  }
  else{
    $style = $themedb->get_themes($id, false, $_SESSION['user_id'], 1);
  }
  $style = $themedb->get_themes($id, $_SESSION['user_id']);
  $development_stages = array('[DEV]', '[ALPHA]', '[BETA]');
  $users = $themedb->get_popup_users();
?>

 >>
<?php if ($style['validated'] == 1) {?>
<a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete">Completed Themes</a>
<?php } else {?>
<a href="<?php echo URL_DATABASE; ?>?mode=view&view=development">Development Themes</a>
<?php } ?>
 >> <a href="<?php echo URL_DATABASE;?>?mode=view&view=style&id=<?php echo $id; ?>">View Theme</a>

<h2>Manage Theme Settings</h2>
<form method="post" action="include/db-handler.php">
  <div>
    <?php
      if (in_array($style['stage'], $development_stages) == true) {
        if ($style['validate_request'] == 0) {
    ?>
    <input type="checkbox" name="request" value="1" /> Request Validation<br />
    <?php
        } else {
    ?>
    Validation already requested<br />
    <?php
        }
      } else {
    ?>
    <input type="hidden" name="request" value="1" />
    <?php
      }
    ?>
    <div id="popup-box">
      <h2>View Users</h2>
      <span style="color: white; ">Click a username to fill the user id box.</span>
      <div id="popup-wrapper">
        <table id="popup-inner">
          <thead style="border-bottom: 1px black solid;">
            <tr>
              <td>ID</td>
               <td>Username</td>
            </tr>
          </thead>
          <tbody>
          <?php
          for ($i=0;$i<count($users);$i++) {
          ?>
          <tr class="style" onclick="idFill(<?php echo $users[$i]['id']; ?>)">
            <td><?php echo $users[$i]['id']; ?></td>
            <td><?php echo $users[$i]['user_name']; ?></td>
          </tr>
          <?php
          }
          ?>
          </tbody>
        </table>
       </div>
    </div>
    Transfer Ownership To:<br /> 
    <a href="javascript:;" onclick="popup_box()" class="view">Click to View Users</a><br />
    User ID: <input type="text" style="width: 30px" name="user_id" id="user_id" />
    <input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="mode" value="settings" />
  </div>
</form>
<?php
}
?>
