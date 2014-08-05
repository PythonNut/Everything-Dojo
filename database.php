<?php
  $title = "Database";
  $extra_style = '<link href="css/database.css" type="text/css" rel="stylesheet">';
  include("include/include.php");
  include("include/themedb.php");
  session_start();
	$extra_style = "<link rel=\"stylesheet\" href=\"css/prism.css\" />
  <link rel=\"stylesheet\" href=\"css/database.css\" />";
  $extra_js = "<script src=\"js/prism.js\"></script>
	<script src=\"js/database.js\"></script>";
  get_header();
	
  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'index';
  }
?>
<section id="content">
					<nav class="db-nav">
            <ul>
              <li><a href="/" id="nav-home">EvDo Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="mysettings.php" id="menu-mysettings">My Settings</a></li>
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
    include('include/themedb/view_body.php');
		// end guest case
	}
	else {
	  switch($mode) {
      case 'index':
        include('include/themedb/index_body.php');
  if($_SESSION['user_level'] == 5){
?>
	<div class="mcp-link"><a href="<?php echo URL_DATABASE; ?>?mode=mcp" class="mcp-link">ThemeDB Moderator CP</a></div>
<?php	
	}					
        break;
      case 'submit':
?>
        <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
<?php
        include('include/themedb/submit_body.php');
        break;
      case 'manage':
?>
        <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
<?php
				include('include/themedb/manage_body.php');
        break;
      case 'view':
?>
        <?php if($_GET['view'] != ''){ ?><a href="<?php echo URL_DATABASE; ?>">Database Index</a> >> <a href="<?php echo URL_DATABASE; ?>?mode=view">View Options</a><?php } ?>
<?php				
				include('include/themedb/view_body.php');
        break;
			case 'mcp':
				if($_SESSION['user_level'] == 5){
					include('include/themedb/mcp_body.php');
				}
				else{
					include('include/themedb/view_body.php');
				}
				break;
			case 'edit':
?>
				<a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
<?php			
				include('include/themedb/edit_body.php');
				break;
			case 'settings':
?>
				<a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
<?php			
				include('include/themedb/settings_body.php');
				break;
    // end user mode
    }
	}
  ?>
</section>
<?php get_footer(); ?>
