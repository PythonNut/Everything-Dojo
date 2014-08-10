<?php 
//get topics
  if (empty($_GET['id'])){
    exit("404 topic not found: we couldn't find your topic because it doesn't exist. Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!");
  }
  else{
    $topic = $discuss->get_topic(intval($_GET['id']))[0];
    $posts = $discuss->get_posts(intval($_GET['id']));
    $discuss->view_topic(intval($_GET['id']));
  }
?>

<?php if (!empty($topic)){ ?>

<section id="topic">
  <div id="topic-main">
    <div id="topic-main-text">
      <?php $user = $discuss->get_user($topic['user_id']);?>
      <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $topic['title'];?></h2>
      <div style="display:inline-block; opacity: 0.6;">Posted by <?php echo $user['user_name'];?> on <?php echo date('m/d/Y, H:i:s', $topic['time']);?></div>
      <p><?php echo $topic['description'];?></p>
    </div>
  </div>
  
</section>

<?php } ?>