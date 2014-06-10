<?php
  $title = "Logout Successful";
  include("dbc.php");
  session_start();
  get_header();
?>
  <?php header('Refresh: 3; URL=index.php'); ?>
  <p>Succesful logout! You will now be redirected to the home page...</p>
  <p class="small">If redirection does not work, click <a href="index.php">here</a>.</p>
<?php get_footer(); ?>