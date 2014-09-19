<?php
  $title = "Home";
  include("include/include.php");
  $extra_js = "<script src=\"js/index.js\"></script>";
  session_start();

  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  get_header(0);
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
      <div id="notification-0" class="notification-item read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">No notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach ($notification_data as $notif) {
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

  <?php if (!empty($_GET['msg']))  {
    echo "<p class=\"msg\">" . filter($_GET['msg']) . "</p>";
  } ?>

  <section id="index-inner">
    <section class="index-row">

      <a href=<?php echo '"' . URL_DATABASE . '"'; ?> class="index-link">
        <section class="index-item database" id="index-database">
          <article class="index-text-container">
            <h4 class="index-title">Database</h4>
            <p class="index-text">A collection of AoPS Blog CSS themes for your perusal.</p>
          </article>
        </section>
      </a>

      <a href=<?php echo '"' . URL_THEMIZER . '"'; ?> class="index-link">
        <section class="index-item themizer" id="index-themizer">
          <article class="index-text-container">
            <h4 class="index-title">Themizer</h4>
            <p class="index-text">Want to customize a theme for yourself? Then themizer is the tool for you!</p>
          </article>
        </section>
      </a>
    </section>

    <div class="clear"></div>
    <section class="index-row">

      <a href=<?php echo '"' . URL_TRYIT . '"'; ?> class="index-link" target="_blank">
        <section class="index-item tryit" id="index-tryit">
          <article class="index-text-container">
            <h4 class="index-title">Try-It</h4>
            <p class="index-text">Want to try out a theme before you actually use it on your blog? Give it a try with this tool!</p>
          </article>
        </section>
      </a>

      <a href=<?php echo '"' . URL_DISCUSS . '"'; ?> class="index-link">
        <section class="index-item discuss" id="index-discuss">
          <article class="index-text-container">
            <h4 class="index-title">Discuss</h4>
            <p class="index-text">Come join our community of fellow AoPS bloggers and stylists!</p>
          </article>
        </section>
      </a>

    </section>
  </section>
</section>

<?php get_footer(); ?>
