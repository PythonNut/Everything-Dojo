<?php
  $title = "Database";
  $extra_style = '<link href="css/database.css" type="text/css" rel="stylesheet">';
  include("include/include.php");
  include("include/themedb.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/prism.css\" />
  <link rel=\"stylesheet\" href=\"css/database.css\" />";
  $extra_js = "<script src=\"js/prism.js\"></script>";
  get_header();

  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'index';
  }
?>
          <nav class="db-nav">
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="mysettings.php" id="menu-mysettings">My Settings</a></li>
              <?php
              // will not work if dbc is not included on page
              if (checkAdmin()) {
              ?>
              <li><a href="admin.php" id="menu-admin">Admin CP</a></li>
              <?php } //end admin ?>
              <li><a href="logout.php" id="menu-logout">Logout</a></li>
            <?php } ?>
            <?php if(!isset($_SESSION['user_id'])) { ?>
              <li><a href="login.php" id="menu-login">Login</a></li>
              <li><a href="register.php" id="menu-register">Register</a></li>
            <?php } ?>
            </ul>
          </nav>
<?php
  if(!isset($_SESSION['user_id'])) {
?>
    <a href="index.php">Back Home</a>
<?php
    include('include/themedb/view_body.php');
  // end guest case
  } else {
    switch($mode) {
      case 'index':
        if($_SESSION['user_level'] == 5) {
        ?>
          <a href="<?php echo URL_DATABASE; ?>?mode=mcp">Moderator Control Panel</a>
        <?php
        }
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
        <?php if($_GET['view'] != '') { ?> | <a href="<?php echo URL_DATABASE; ?>?mode=view">Back to View Options</a><?php } ?>
<?php
        include('include/themedb/view_body.php');
        break;
      case 'mcp':
        if($_SESSION['user_level'] == 5) {
          include('include/themedb/mcp_body.php');
        }
        else {
          include('include/themedb/view_body.php');
        }
        break;
    // end user mode
    }
  }
?>


<?php get_footer(); ?>
