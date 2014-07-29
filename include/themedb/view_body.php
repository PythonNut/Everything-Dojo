<?php
  $data = $themedb->get_themes();
	$view = $_GET['view'];

	switch($view){
		case '';
?>
  <div id="tile-container">
     <a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete" class="database-link">
     <div class="db-tile db-tile-large" id="complete">
       <div class="db-tile-inner">
        <span class="db-tile-title">Completed</span><br />Themes on this page have been validated by a theme moderator. These themes are bug free and can be used in your blog without worry.
      </div>
    </div>
    </a>
    <a href="<?php echo URL_DATABASE; ?>?mode=view&view=development" class="database-link">
    <div class="db-tile db-tile-large" id="development">
      <div class="db-tile-inner">
        <span class="db-tile-title">Development</span><br />Themes on this page have been approved, but not yet validated. They are still in development and may have some bugs that need to be ironed out.
    </div>
    </a>
  </div>	
<?php		
			break;
		case 'complete';
?>
    <h2>Completed Themes</h2>
    
    <table class="database-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td>Author</td>
          <td>Version</td>
          <td>Stage</td>
        <tr>
      </thead>
      <tbody>
      <?php
      for($i=0; $i<count($data['validated']['id']); $i++) {
        $description = br2nl($data['validated']['description'][$i]);
        $count = str_word_count($description);
        $description = implode(' ', array_slice(explode(' ', $description), 0, 10));
        if(strlen($description) > 150){
          $description = substr($description, 0, 150);
        }
        if($count > 10){
          $description .= ' (...)';
        }
      ?>
        <tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated']['id'][$i]; ?>'">
          <td><?php echo "<b>".$data['validated']['name'][$i]."</b><br />" . $description; ?></td>
          <td><?php echo $data['validated']['author'][$i]; ?></td>
          <td><?php echo $data['validated']['version'][$i]; ?></td>
          <td><?php echo $data['validated']['stage'][$i]; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
<?php
			break;
		case 'development':
?>    
    <h2>Themes in Development</h2>
    
    <table class="database-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td>Theme</td>
          <td>Author</td>
          <td>Version</td>
          <td>Stage</td>
        <tr>
      </thead>
      <tbody>
      <?php
      for($i=0; $i<count($data['unvalidated']['id']); $i++) {
        $description = br2nl($data['unvalidated']['description'][$i]);
        $count = str_word_count($description);
        $description = implode(' ', array_slice(explode(' ', $description), 0, 10));
        if(strlen($description) > 150){
          $description = substr($description, 0, 150);
        }
        if($count > 10){
          $description .= ' (...)';
        }
      ?>
        <tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unvalidated']['id'][$i]; ?>'">
          <td><?php echo "<b>".$data['unvalidated']['name'][$i]."</b><br />".$description; ?></td>
          <td><?php echo $data['unvalidated']['author'][$i]; ?></td>
          <td><?php echo $data['unvalidated']['version'][$i]; ?></td>
          <td><?php echo $data['unvalidated']['stage'][$i]; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
<?php
			break;
		case 'style':
?>
			<h2>View Style</h2>
<?php		
			$id = $_GET['id'];
			
			$style = $themedb->get_themes($id);
			if($id == '' || count($style) == 0){
?>
      This style does not exist.
<?php			
			}
			else{
?>
			<h4><?php echo $style['name']; ?> v. <?php echo $style['version']; ?> by <?php echo $style['author']; ?> <?php echo $style['stage']; ?></h4>
      <?php echo $style['description']; ?><br />
      <b>Screenshot:</b><br />
      <img src="<?php echo $style['screenshot']; ?>" /><br />
      <b>Code:</b><br />
      <div class="code">
      <?php echo nl2br($style['code']); ?>
      </div>
<?php			
			}
			break;
	}
?>