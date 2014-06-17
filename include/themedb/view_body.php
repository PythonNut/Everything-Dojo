<?php
	$data = $themedb->get_themes();
?>
<h2>Validated Themes</h2>

<table class="database-table">
	<thead>
  	<tr>
      <td>Theme</td>
      <td>Author</td>
      <td>Version</td>
      <td>Stage</td>
    <tr>
  </thead>
  <tbody>
  <?php
	for($i=0;$i<$data['validated']['count'];$i++){
	?>
  	<tr>
    	<td><?php echo $data['validated']['name'][$i]."<br />".$data['validated']['description'][$i]; ?></td>
      <td><?php echo $data['validated']['author'][$i]; ?></td>
      <td><?php echo $data['validated']['version'][$i]; ?></td>
      <td><?php echo $data['validated']['stage'][$i]; ?></td>
    </tr>
  <?php
	}
	?>
  </tbody>
</table>

<h2>Unvalidated Themes</h2>