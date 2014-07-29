<?php
  $data = $themedb->get_themes();
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
    <tr>
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
    <tr>
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
