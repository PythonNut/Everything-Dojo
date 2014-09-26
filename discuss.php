<?php
  $title = "Discuss";
  include("include/include.php");
  include("include/discuss.php");
  session_start();
<<<<<<< HEAD
  $extra_style = "<link rel=\"stylesheet\" href=\"css/discuss.css\" />
  <link rel=\"stylesheet\" href=\"css/prism.css\" />";
  $extra_js = "<script src=\"js/discuss.js\"></script>
  <script src=\"js/prism.js\"></script>
  <script src=\"js/marked.min.js\"></script>
  <script>$(function(){\$('pre code').each(function(){var h=$(this).html();h=h.replace(/&amp;quot;/g,'\"').replace(/&amp;#039;/g,'\'');$(this).html(h)})})</script>";
  get_header();

  if ($_SESSION['user_id'] != NULL) {
=======
  $extra_style = "<link rel=\"stylesheet\" href=\"css/discuss.css\" />";
	$extra_js = "<script src=\"js/discuss.js\"></script>";
  get_header();

  if(!empty($_SESSION['user_id'])){
>>>>>>> FETCH_HEAD
    $unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  if (empty($_GET['view'])) {
    $view = '';
  } else {
    $view = $_GET['view'];
  }
<<<<<<< HEAD

  $mode = $_POST['mode'];
  $_SESSION['mode'] = $mode;
  switch ($mode) {
    case 'post':
      $data = $_POST;
      $data['t'] = $_POST['t'];
      $result = $discuss->insert_post($_POST['forum'], $_SESSION['user_id'], $data);
      $f = $result['f'];
      $t = $result['t'];

      if (empty($result['err'])) {
        header('Location: ' . SITE_ROOT . URL_DISCUSS . '?view=topic&f=' . $f . '&t=' . $t . '#last');
      } else {
        header('Location: ' . SITE_ROOT . URL_DISCUSS . '?view=topic&f=' . $f . '&t=' . $t . '#form');
      }
      break;
    case 'topic':
      $data = $_POST;
      $result = $discuss->insert_topic($_POST['forum'], $_SESSION['user_id'], $data);
      $f = $result['f'];
      $t = $result['t'];
      $_SESSION['err'] = $result['err'];

      if (empty($result['err'])) {
        header('Location: ' . SITE_ROOT . URL_DISCUSS . '?view=topic&f=' . $f . '&t=' . $t);
      } else {
        header('Location: ' . SITE_ROOT . URL_DISCUSS . '?view=topic&f=' . $f . '#form');
      }
      break;
  }
=======
>>>>>>> FETCH_HEAD
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
      if (count($notification_data) == 0) {
      ?>
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
      <?php if (isset($_SESSION['user_id'])) { ?>
        <li><a href="javascript:;" class="notification-link" onClick="show_notifications()">Notifications (<?php echo $unread_count; ?>)</a></li>
      <?php } ?>
      </ul>
    </nav>
  </div>
  <?php if (!empty($_SESSION['user_id'])) { ?>
  <h3>Welcome, <?php echo get_user($_SESSION['user_id']);?>!</h3>
  <br/>
  <?php } else { ?>
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
      foreach ($announcements as $announce) {
        echo "<div class=\"discuss-announcement\" id=\"discuss-announcement-".$key."\" style=\"display: block;\">".$announce."</div>";
        $key += 1;
      }
    ?>
    </div>
    <div class="discuss-round" id="discuss-round-right"><span class="discuss-round"></span></div>
      <script>
        var interval,
            announcementOptions = {
          num: <?php echo count($announcements);?>,
          start: 1,
          now: 1,
          aidPrefix: "discuss-announcement-",
          updateView: function () {
            for (ji = announcementOptions.start; ji <= announcementOptions.num; ji++) {
              $("#"+announcementOptions.aidPrefix+ji).fadeOut(300);
            }
            $("#"+announcementOptions.aidPrefix+announcementOptions.now).delay(500).fadeIn(400);
          }
        };

        $(document).ready(function () {
          //start up
          for (ji = announcementOptions.start; ji <= announcementOptions.num; ji++) {
            $("#"+announcementOptions.aidPrefix+ji).hide();
          }
          announcementOptions.now = announcementOptions.start;
          $("#"+announcementOptions.aidPrefix+announcementOptions.now).show();
          // check if there are multiple announcements
          if (announcementOptions.num < 2) {
            $(".discuss-round").remove();
          }

          interval = setInterval(function () {
            if (announcementOptions.now == announcementOptions.num) {
              announcementOptions.now = announcementOptions.start;
            } else {
              announcementOptions.now += 1;
            }
            announcementOptions.updateView();
          }, 5000);
        });

        $("#discuss-announcements").hover(function () {
          clearInterval(interval);
        });

        $("#announcements").mouseout(function () {
          clearInterval(interval);
          interval = setInterval(function () {
            if (announcementOptions.now == announcementOptions.num) {
              announcementOptions.now = announcementOptions.start;
            } else {
              announcementOptions.now += 1;
            }
            announcementOptions.updateView();
          }, 5000);
        });

        $("#discuss-round-left").click(function () {
          clearInterval(interval);
          if (announcementOptions.now == announcementOptions.start) {
            announcementOptions.now = announcementOptions.num;
          } else {
            announcementOptions.now -= 1;
          }
          announcementOptions.updateView();
        });

        $("#discuss-round-right").click(function () {
          clearInterval(interval);
          if (announcementOptions.now == announcementOptions.num) {
            announcementOptions.now = announcementOptions.start;
          } else {
            announcementOptions.now += 1;
          }
          announcementOptions.updateView();
        });
      </script>
    </section>
    <?php } ?>
    <br/>
    <?php
    switch ($view) {
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
    } ?>
</section>

<?php get_footer(); ?>
