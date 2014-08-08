<?php
$id = $_GET['id'];
$edit = $themedb->check_owner($id, $_SESSION['user_id']);
if($edit == false){
  redirect(URL_DATABASE);
}
else{
  $style = $themedb->get_themes($id, false, $_SESSION['user_id']);
  $development_stages = array('[DEV]', '[ALPHA]', '[BETA]');
?>
 >> <?php if($style['validated'] == 1){?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete">Completed Themes</a><?php }else{?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=development">Development Themes</a> <?php } ?> >> <a href="<?php echo URL_DATABASE;?>?mode=view&view=style&id=<?php echo $id; ?>">View Theme</a>
<h2>Edit Theme</h2>
<form method="post" action="include/db-handler.php">
  <div class="col" id="col1">
    Theme name:<br />
    <input type="text" name="name" value="<?php echo $style['name']; ?>" /><br />
    Theme author:<br />
    <input type="text" name="author" value="<?php echo $style['author']; ?>" />
  </div>
  <div class="col" id="col2">
    Theme screenshot (url):<br />
    <input type="text" name="screenshot" value="<?php echo $style['screenshot']; ?>" /><br />
    Theme version (e.g. 1.2):<br />
    <input type="text" name="version" value="<?php echo $style['version']; ?>" />
  </div>
  <div class="col" id="col3">
    Theme stage:<br />
    <?php
      if(in_array($style['stage'], $development_stages) == true){
    ?>
    <input type="radio" name="stage" value="[DEV]" id="[DEV]" <?php if($style['stage'] == '[DEV]'){ ?>checked="yes"<?php } ?> /><label for="[DEV]">[DEV]</label><br />
    <input type="radio" name="stage" value="[ALPHA]" id="[ALPHA]" <?php if($style['stage'] == '[ALPHA]'){ ?>checked="yes"<?php } ?> /><label for="[ALPHA]">[ALPHA]</label><br />
    <input type="radio" name="stage" value="[BETA]" id="[BETA]" <?php if($style['stage'] == '[BETA]'){ ?>checked="yes"<?php } ?> /><label for="[BETA]">[BETA] </label>
    <?php
      }
      else{
    ?>
    <input type="radio" name="stage" value="[RELEASE]" id="[RELEASE]" checked="yes" /><label for="[RELEASE]">[RELEASE] </label>
    <?php
      }
    ?>
  </div>
  <div id="fields">
    Theme Description (optional):<br />
    <textarea id="description" name="description"><?php echo $style['description']; ?></textarea><br />
    Theme CSS:<br />
    <textarea id="css" name="code"><?php echo $style['code']; ?></textarea>
    <input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="mode" value="edit-theme" />
  </div>
</form>
<?php
}
?>
