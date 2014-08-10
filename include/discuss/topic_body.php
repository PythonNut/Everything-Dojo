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

<?php if (!empty($topic) and (!empty($topic['title']))){ ?>
<a href="<?php echo URL_DISCUSS; ?>?view=forum&f=<?php echo intval($topic['forum_id']);?>">&laquo; Back to <?php echo $discuss->get_fora(intval($topic['forum_id']))['name'];?></a>
<section id="topic">
  <h1 style="text-align:center;"><?php echo $topic['title'];?></h1>
  <div id="topic-main">
    <div id="topic-main-text">
      <?php $user = $discuss->get_user(intval($topic['user_id']))['user_name'];?>
      <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $topic['title'];?></h2>
      <div style="display:inline-block; opacity: 0.6;">Posted by <?php echo $user;?> on <?php echo date('D M d, Y g:i a', $topic['time']);?></div>
      <p><?php echo $topic['text'];?></p>
    </div>
  </div>
  <?php var_export($topic);?>
  <?php if (!empty($posts)){ ?>
  <?php var_export($posts);?>
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

<?php } else{
  echo "<h1 style='text-align:center;'>Topic Not Found</h1>";
  echo "<p style='text-align:center;'>The topic you were looking for is not found. Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!</p>";
}?>