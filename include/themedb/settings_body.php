<?php
$id = $_GET['id'];
$edit = $themedb->check_owner($id, $_SESSION['user_id']);
if($edit == false){
	redirect(URL_DATABASE);
}
else{
	$style = $themedb->get_themes($id, $_SESSION['user_id']);
	$development_stages = array('[DEV]', '[ALPHA]', '[BETA]');
	$users = $themedb->get_popup_users();
?>
<h2>Manage Theme Settings</h2>
<form method="post" action="include/db-handler.php">
		<?php
			if(in_array($style['stage'], $development_stages) == true){
		?>
    <input type="checkbox" name="request" /> Request Validation<br />
    <?php	
			}
		?>
    <div id="popup-users">
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
					for($i=0;$i<count($users);$i++){
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
    Transfer Ownership To: <a href="javascript:;" onclick="popup_users()" class="view">Click to View Users</a><br />
    User ID: <input type="text" style="width: 30px" name="user_id" id="user_id" />
  	<input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="mode" value="settings" />
  </div>
</form>
<?php
}
?>