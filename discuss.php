<?php
  $title = "Discuss";
  include("include/include.php");
  include("include/discuss.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/discuss.css\" />";
  $extra_js = "<script src=\"js/discuss.js\"></script>";
  get_header();

  if($_SESSION['user_id'] != NULL){
    $unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  if (empty($_GET['view'])){
    $view = '';
  }
  else{
    $view = $_GET['view'];
  }
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
        <a href="notifications.php">See All</a>
      </div>
    </div>
  </div>
        <div id="navigation">
          <nav class="discuss-nav">
            <ul>
              <li><a href="/" id="nav-home">EvDo Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="javascript:;" class="notification-link" onClick="show_notifications()">Notifications (<?php echo $unread_count; ?>)</a></li>
            <?php } ?>
            </ul>
          </nav>
        </div>
  <?php if (!empty($_SESSION['user_id'])){ ?>
  <h3>Welcome, <?php echo get_user($_SESSION['user_id']);?>!</h3>
  <br/>
  <?php } else{ ?>
  <h3>Hello Guest. Please <a href="login.php">sign in</a>.</h3>
  <br/>
  <?php } ?>
  <?php
    $result = $dbc->prepare("SELECT data FROM data WHERE fetchname = 'announcements'");
    $result->execute();
    $result = $result->fetchAll(PDO::FETCH_ASSOC);

    $announcements = explode("~", $result[0]['data']);
  ?>
  <?php if (!empty($announcements[0])) {?>
  <section id="announcements">
    <h3>Announcements: </h3>
    <div class="discuss-round" id="discuss-round-left"><span class="discuss-round"></span></div>
    <div id="discuss-announcements">
    <?php
      $key = 1;
      foreach($announcements as $announce) {
        echo "<div class=\"discuss-announcement\" id=\"discuss-announcement-".$key."\" style=\"display: block;\">".$announce."</div>";
        $key += 1;
      }
    ?>
    </div>
    <div class="discuss-round" id="discuss-round-right"><span class="discuss-round"></span></div>
      <script>
        var announcement_options = {
          num: <?php echo count($announcements);?>,
          start: 1,
          now: 1,
          aidPrefix: "discuss-announcement-",
          updateView: function () {
            for (ji = announcement_options.start; ji <= announcement_options.num; ji++) {
              $("#"+announcement_options.aidPrefix+ji).fadeOut(100);
            }
            $("#"+announcement_options.aidPrefix+announcement_options.now).delay(200).fadeIn(100);
          }
        }
        $(document).ready(function () {
          //start up
          for (ji = announcement_options.start; ji <= announcement_options.num; ji++) {
            $("#"+announcement_options.aidPrefix+ji).hide();
          }
          announcement_options.now = announcement_options.start;
          $("#"+announcement_options.aidPrefix+announcement_options.now).show();
          // check if there are multiple announcements
          if (announcement_options.num < 2) {
            $(".discuss-round").remove();
          }
        });

        $("#discuss-round-left").click(function () {
          if (announcement_options.now == announcement_options.start) {
            announcement_options.now = announcement_options.num;
          } else {
            announcement_options.now -= 1;
          }
          announcement_options.updateView();
        });

        $("#discuss-round-right").click(function () {
          if (announcement_options.now == announcement_options.num) {
            announcement_options.now = announcement_options.start;
          } else {
            announcement_options.now += 1;
          }
          announcement_options.updateView();
        });
      </script>
    </section>
    <?php } ?>
    <br/>
    <?php
    switch($view){
      case '':
        include('include/discuss/index_body.php');
        break;
      case 'forum':
        echo '<a href="' . URL_DISCUSS. '">&laquo; Back to Discuss Index</a>';
        include('include/discuss/forum_body.php');
        break;
      case 'topic':
        include('include/discuss/topic_body.php');
        break;
      default:
        echo "<b>Something wrong happened!</b> Discuss can't handle this request because it doesn't know how to do it! Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
        break;
    }
    ?>
</section>

<?php get_footer(); ?>
