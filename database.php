<?php
  $title = "Database";
  $extra_style = '<link href="css/database.css" type="text/css" rel="stylesheet">';
  include("include/include.php");
  include("include/themedb.php");
  session_start();
  get_header();

  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'index';
  }

  if(!isset($_SESSION['user_id'])) {
?>
<div id="content">
  <a href="index.php">Back Home</a>
  <?php
      include('include/themedb/view_body.php');
    // end guest case
    } else {
      switch($mode) {
        case 'index':

          include('include/themedb/index_body.php');
          break;
        case 'submit':
  ?>
          <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
  <?php
          include('include/themedb/submit_body.php');
          break;
        case 'request':
  ?>
          <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
  <?php
          break;
        case 'view':
  ?>
          <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
  <?php
          include('include/themedb/view_body.php');
          break;
      // end user mode
      }
    }
  ?>
</div>
<?php get_footer(); ?>
