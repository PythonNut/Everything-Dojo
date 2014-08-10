<?php 
//get topics
  if (empty($_GET['f'])){
    exit("Topic not found: we couldn't find your topic because it doesn't exist. Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!");
  }
  else{
    //check if special
    if ($_GET['f'] == 1){
      $topic = $discuss->get_topic(intval($_GET['t']), 1);
      $posts = $discuss->get_posts(intval($_GET['t']), 'all', 1);
    }
    else{
      $topic = $discuss->get_topic(intval($_GET['t']))[0];
      $posts = $discuss->get_posts(intval($_GET['t']), 'all', 0);
    }

  }
?>

<?php if (!empty($topic)){ ?>

<section id="topic">
  <div id="topic-main">
    <div id="topic-main-text">
      <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $topic['title'];?></h2>
      <div style="display:inline-block; opacity: 0.6;">Posted by <?php echo $user;?> on <?php echo date('D M d, Y g:i a', $topic['time']);?></div>
      <p><?php echo $topic['description'];?></p>
    </div>
  </div>
  <?php if (!empty($posts)){ var_export($posts); ?>
    <?php foreach ($posts as $post){?>
      <div class="topic-reply">
        <div class="topic-reply-text">
          <?php $user = $discuss->get_user($post['user_id']);?>
          <div class="topic-reply-top">
            <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $post['title'];?></h2>
            <div style="display:inline-block; opacity: 0.6;">
              Posted by <?php echo $user['user_name'];?> on <?php echo date('m/d/Y, H:i:s', $post['time']);?></div>
            <?php if ($_SESSION['user_id'] > 0){ ?>
            <div class="topic-reply-thanks">&uarr; &nbsp;&nbsp;3 Thanks</div>
            <?php }?>
            
          </div>
          <p><?php echo $post['text'];?></p>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
</section>

<?php } ?>