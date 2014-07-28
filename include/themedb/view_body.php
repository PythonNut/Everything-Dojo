<?php
  $data = $themedb->get_themes();
?>
<h2>Completed Themes</h2>

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
  for($i=0; $i<count($data['validated']['id']); $i++) {
  ?>
    <tr>
      <td><?php echo "<b>".$data['validated']['name'][$i]."</b><br />".$data['validated']['description'][$i]; ?></td>
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
  for($i=0; $i<count($data['unvalidated']['id']); $i++) {
  ?>
    <tr>
      <td><?php echo "<b>".$data['unvalidated']['name'][$i]."</b><br />".$data['unvalidated']['description'][$i]; ?></td>
      <td><?php echo $data['unvalidated']['author'][$i]; ?></td>
      <td><?php echo $data['unvalidated']['version'][$i]; ?></td>
      <td><?php echo $data['unvalidated']['stage'][$i]; ?></td>
    </tr>
  <?php
  }
  ?>
  </tbody>
</table>
