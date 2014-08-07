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

	if($_SESSION['user_id'] != NULL){
		$unread_count = $notification->count_unread($_SESSION['user_id']);
		$notification_data = $notification->get_notifications($_SESSION['user_id']);
	}
	
  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'index';
  }
?>
<section id="content">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> FETCH_HEAD
	<div id="notifications">
  	<div class="notification-arrow-up"></div>
    <div id="notification-body">
      <div id="notification-header">
        <b>Notifications:</b>
        	<a href="javascript:;" style="float: right; margin-right: 2vw;" onClick="mark_all_read(<?php echo $_SESSION['user_id']; ?>)">Mark all read</a>
      </div>
      <?php
			if(count($notification_data) == 0){
			?>
      <a href="javascript:;">
      <div id="notification-0" class="notification read">
      	<div class="notification-color" style="background-color: #ccc"></div>
      	<div class="notification-text">No notifications</div>
      </div>
      </a>
      <?php
			}
			else{
				foreach($notification_data as $notif){
					$notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
			?>
      <a href="<?php echo $notif_data['url']; ?>" onClick="mark_read(<?php echo $notif['id']; ?>)">	
        <div id="notification-<?php echo $notif['id']; ?>" class="notification <?php if($notif['read'] == 0){ echo 'unread'; }else{ echo 'read'; } ?> ">
      		<div class="notification-color" style="background-color: #<?php echo $notif_data['data']['color']; ?>"><?php echo substr($notif_data['data']['location'], 0, 1); ?></div>
					<div class="notification-text">
						<?php echo $notif_data['data']['subject']; ?>
          </div>
          <p class="time">
           	<?php echo date('D M d, Y g:i a', $notif['timestamp']); ?>
          </p>
      	</div>
      </a>
      <?php
				}
			}
			?>
      <div id="notification-footer">
      	<a href="">See All</a>
      </div>
    </div>
  </div>
  			<div id="navigation">
<<<<<<< HEAD
=======
=======
>>>>>>> FETCH_HEAD
>>>>>>> FETCH_HEAD
					<nav class="db-nav">
            <ul>
            	<li><a href="/" id="nav-home">EvDo Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
            	<li><a href="javascript:;" class="notification-link" onClick="show_notifications()">Notifications (<?php echo $unread_count; ?>)</a></li>
            <?php } ?>
            </ul>
          </nav>
        </div>
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
?>
        <a href="<?php echo URL_DATABASE; ?>">Back to Database Index</a>
<?php
					include('include/themedb/mcp_body.php');
				}
				else{
?>
        <?php if($_GET['view'] != ''){ ?><a href="<?php echo URL_DATABASE; ?>">Database Index</a> >> <a href="<?php echo URL_DATABASE; ?>?mode=view">View Options</a><?php } ?>
<?php		
					include('include/themedb/view_body.php');
				}
				break;
			case 'edit':
?>
				<a href="<?php echo URL_DATABASE; ?>">Database Index</a> >> <a href="<?php echo URL_DATABASE; ?>?mode=view">View Options</a>
<?php			
				include('include/themedb/edit_body.php');
				break;
			case 'settings':
?>
				<a href="<?php echo URL_DATABASE; ?>">Database Index</a> >> <a href="<?php echo URL_DATABASE; ?>?mode=view">View Options</a>
<?php			
				include('include/themedb/settings_body.php');
				break;
    // end user mode
    }
	}
  ?>
</section>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======


>>>>>>> FETCH_HEAD
>>>>>>> FETCH_HEAD
<?php get_footer(); ?>
