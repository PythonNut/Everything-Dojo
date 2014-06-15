<?php
  $title = "Database";
  include("include/include.php");
  include("include/themedb.php");
  session_start();
  get_header();

	if(!isset($_SESSION['user_id'])){
		$level = "guest";
	}
	elseif(isset($_SESSION['user_id']) && $_SESSION['user_level'] == 1){
		$level = "user";
	}
	elseif(isset($_SESSION['user_id']) && $_SESSION['user_level'] == 3){
		$level = "mod";
	}
	elseif(isset($_SESSION['user_id']) && $_SESSION['user_level'] == 5){
		$level = "admin";
	}
?>

<?php
switch($level){
	case 'guest':
?>
<?php	
		// end guest case
		break;
		
	case 'user':
?>

<?php		
		// end user case
		break;
		
	case 'mod':
?>
<?php		
		// end mod case
		break;
		
	case 'admin':
?>
	<div id="tile-container">
    <div class="db-tile" id="submit"></div>
    <div class="db-tile" id="request"></div>
    <div class="db-tile" id="view"></div>
  </div>
<?php		
		// end admin case
		break;
}
?>

<?php get_footer(); ?>