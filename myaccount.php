<?php
  $title = "My Account";
  include("include/include.php");
  $extra_js = "<script src=\"js/index.js\"></script>";
  session_start();
  page_protect();

  if($_SESSION['user_id'] != NULL) {
    $unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  get_header(0, $unread_count);
?>
<section id="content">
  <div id="notifications">
    <div class="notification-arrow-up"></div>
    <div id="notification-body">
      <div id="notification-header">
        <b>Notifications:</b>
        <a href="javascript:;" style="float: right; margin-right: 2vw;" onClick="mark_all_read(<?php echo $_SESSION['user_id']; ?>)">Mark all read</a>
      </div>
      <?php
      if(count($notification_data) == 0) {
      ?>
      <a href="javascript:;">
      <div id="notification-0" class="notification-item read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">No notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach($notification_data as $notif) {
          $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
      ?>
      <a href="<?php echo $notif_data['url']; ?>" class="notification-item-link" onClick="mark_read(<?php echo $notif['id']; ?>)">
        <div id="notification-<?php echo $notif['id']; ?>" class="notification-item <?php if($notif['read'] == 0){ echo 'unread'; }else{ echo 'read'; } ?> ">
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
        <a href="notifications.php">See All</a>
      </div>
    </div>
  </div>

  <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
  <p>This is the my account page. There is basically nothing here right now, but more is always to be added sometime.</p>
  <p>Your User ID: <?php echo $_SESSION['user_id']; ?></p>
  <div id="announcements">
    <?php
    $result = $dbc->prepare("SELECT data FROM data WHERE fetchname = 'announcements'");
    $result->execute();
    $result = $result->fetchAll(PDO::FETCH_ASSOC);

    $announcements = explode("~", $result[0]['data']);
    if (empty($announcements[0])) {
      $title = "Announcements for Users from Admins: There are currently no announcements.";
      unset($announcements[0]);
    } elseif (count($announcements) == 1) {
      $title = "Announcement for Users from Admins";
    } else {
      $title = "Announcements for Users from Admins";
    }
    ?>
    <h4><?php echo $title; ?></h4>
    <?php
    if (count($announcements) > 0) {
      echo "<ul>";
      foreach ($announcements as $value) {
        echo "<li>".$value."</li>";
      }
      echo "</ul>";
    } ?>
  </div>
</section>

<?php get_footer(); ?>
