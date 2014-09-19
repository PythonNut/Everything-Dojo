<?php
  $title = "Notifications";
  include("include/include.php");
  $extra_js = "<script src=\"js/index.js\"></script>
  <script>$(function(){\$('.notification-link').hide()})</script>";
  session_start();

  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id'], 1000);
  }

  get_header(0, $notification_unread_count);
?>
<section id="content">
  <div id="notifications-test">
    <div id="notification-body" style="width:95%;margin:auto">
      <div id="notification-header" style="width:100%">
        <b>notifications:</b>
        <a href="javascript:;" style="float: right; margin-right: 2vw;" onclick="mark_all_read(<?php echo $_session['user_id']; ?>)">mark all read</a>
      </div>
      <?php if (count($notification_data) == 0) { ?>
      <a href="javascript:;">
      <div id="notification-0" class="notification-item read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">no notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach ($notification_data as $notif) {
          $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
      ?>
      <a href="<?php echo $notif_data['url']; ?>" class="notification-item-link" onclick="mark_read(<?php echo $notif['id']; ?>)">
        <div id="notification-<?php echo $notif['id']; ?>" class="notification-item <?php if ($notif['read'] == 0) { echo 'unread'; } else { echo 'read'; } ?>" style="border-bottom:none">
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
    </div>
  </div>

</section>

<?php get_footer(0); ?>
