<?php
  $title = "Database";
  $extra_style = '<link href="css/database.css" type="text/css" rel="stylesheet">';
  include("include/include.php");
  include("include/themedb.php");
  session_start();
  get_header();

  if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
  }
  else{
    $mode = 'index';
  }

  if(!isset($_SESSION['user_id'])){
    $level = "guest";
    // end guest case
  }
  else{
    switch($mode){
      case 'index':
        include('include/themedb/index_body.php');
        break;
      case 'submit':
        include('include/themedb/submit_body.php');
        break;
      case 'view':
        include('include/themedb/view_body.php');
        break;
    }
  }
?>

<?php get_footer(); ?>
