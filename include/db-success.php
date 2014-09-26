<?php
  include('include.php');
  include('themedb.php');
  session_start();

  $mode = $_SESSION['mode'];
  $id = $_SESSION['id'];
  unset($_SESSION['mode']);
  unset($_SESSION['id']);

  switch ($mode) {
    case 'submit-theme':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);
      break;
    case 'edit-theme':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);
      break;
    case 'settings':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);
      break;
    case 'approve':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=mcp');
      break;
    case 'validate':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=mcp');
      break;
    case 'delete':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=manage');
      break;
		case 'reject':
      header('Refresh: 3; URL = ' . SITE_ROOT . URL_DATABASE . '?mode=mcp');
      break;
  }

  $title = "Database";
  $extra_style = "<link rel=\"stylesheet\" href=\"../../css/prism.css\" />
  <link rel=\"stylesheet\" href=\"../../css/database.css\" />";
  $extra_js = "<script src=\"../../js/prism.js\"></script>
  <script src=\"../../js/database.js\"></script>";
  if ($_SESSION['user_id'] != NULL) {
    $unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  include('header.php');
?>
<section id="content">
  <div id="notifications">
    <div class="notification-arrow-up"></div>
    <div id="notification-body">
      <div id="notification-header">
        <b>Notifications:</b>
          <a href="javascript:;" style="float: right; margin-right: 2vw;" onClick="mark_all_read(<?php echo $_SESSION['user_id']; ?>)">Mark all read</a>
      </div>
      <?php if (count($notification_data) == 0) { ?>
      <a href="javascript:;">
      <div id="notification-0" class="notification read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">No notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach ($notification_data as $notif) {
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
      <?php } //end foreach
      } //end else ?>
      <div id="notification-footer">
        <a href="notifications.php">See All</a>
      </div>
    </div>
  </div>
  <div id="navigation">
    <nav class="db-nav">
      <ul>
        <li><a href="/" id="nav-home">EvDo Home</a></li>
      <?php if(isset($_SESSION['user_id'])) { ?>
        <li><a href="javascript:;" class="notification-link" onClick="show_notifications()">Notifications (<?php echo $unread_count; ?>)</a></li>
      <?php } ?>
      </ul>
    </nav>
  </div>
  <p>Your action has been completed successfully.</p>
  <p>You will be redirected in <span id="counter">3</span> second(s).</p>
  <script>
  function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML) > 0) {
      i.innerHTML = parseInt(i.innerHTML)-1;
    }
  }
  setInterval(function(){ countdown(); },1000);
  </script>
</section>
<?php get_footer(); ?>
