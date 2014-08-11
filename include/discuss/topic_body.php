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
  if (!empty($_SESSION['user_id'])){
    $type = 0;
    if ($_GET['f'] == 1){
      $type = 1;
    }
    $discuss->view_topic(intval($_GET['t']), $type, intval($_SESSION['user_id']));
  }
?>

<?php if (!empty($topic) and (!empty($topic['title']))){ ?>
<a href="<?php echo URL_DISCUSS; ?>?view=forum&f=<?php echo intval($topic['forum_id']);?>">&laquo; Back to <?php echo $discuss->get_fora(intval($topic['forum_id']))['name'];?></a>
<section id="topic" style="margin-top: 1em;">
  <div id="discuss-topic-header" <?php if ($_GET['f'] == 1){echo 'style="background-image: url('.$topic['photo_attach'].');"';}?> >
    <h1 style="text-align:center;"><?php echo $topic['title'];?></h1>
  </div>
  <div id="topic-main">
    <div id="topic-main-text">
      <?php $user = $discuss->get_user(intval($topic['user_id']))['user_name'];?>
      <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $topic['title'];?></h2>
      <div style="display:inline-block; opacity: 0.6;">Posted by <?php echo $user;?> on <?php echo date('D M d, Y g:i a', $topic['time']);?></div>
      <p><?php echo $topic['text'];?></p>
    </div>
  </div>
  <?php if (!empty($posts)){ ?>
    <?php $thankedposts = []; foreach ($posts as $post){?>
      <div class="topic-reply">
        <div class="topic-reply-text">
          <?php $user = $discuss->get_user($post['user_id']);?>
          <div class="topic-reply-top">
            <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $discuss->parse_code($post['title']);?></h2>
            <div style="display:inline-block; opacity: 0.6;">
              Posted by <?php echo $user['user_name'];?> on <?php echo date('D M d, Y g:i a', $post['time']);?></div>
            <?php if ($_SESSION['user_id'] > 0){ ?>
            <?php $thanks = $discuss->thanks($post['post_id'], $mode = 1, $user_id = $_SESSION['user_id']); ?>
            <div class="topic-reply-thanks<?php if (in_array($_SESSION['user_id'],$thanks)){ echo " topic-reply-thanked"; $thankedposts[] = $post['post_id'];}?>" id="topic-reply-thanks-<?php echo $post['post_id'];?>" onclick="thankpost(<?php echo $post['post_id']?>)">&uArr; &nbsp;&nbsp;<?php echo count($thanks);?> Thank<?php if (count($thanks) != 1){echo "s";}?></div>
            <?php }?>
          </div>
          <p><?php echo $discuss->parse_code($post['text']);?></p>
        </div>
      </div>
    <?php } ?>
    <?php if ($_SESSION['user_id']){ ?>
    <script>
      var thankedPosts = [<?php echo implode(",", $thankedposts);?>];
      function thankpost(post_id){
        if ($.inArray(post_id, thankedPosts) >= 0){
          $.post("include/discuss/topic_ajax.php", {action: "thank", mode: <?php if (intval($_GET['f']) == 1){echo "3";} else{echo "2";}?>, id: post_id}, function(data) {
            if (data == "success"){
              $('#topic-reply-thanks-'+post_id).html("&uArr; &nbsp;&nbsp;Thank");
              $('#topic-reply-thanks-'+post_id).removeClass('topic-reply-thanked');
              thankedPosts.pop($.inArray(post_id, thankedPosts));
            }
            else{
              alert("We can't un-thank the post for some reason. Check your internet connection.");
            }
          });
        }
        else{
          $.post("include/discuss/topic_ajax.php", {action: "thank", mode: <?php if (intval($_GET['f']) == 1){echo "3";} else{echo "2";}?>, id: post_id}, function(data) {
            if (data == "success"){
              $('#topic-reply-thanks-'+post_id).html("&uArr; &nbsp;&nbsp;Thanked!");
              $('#topic-reply-thanks-'+post_id).addClass('topic-reply-thanked');
              thankedPosts.push(post_id);
            }
            else{
              alert("We can't thank the post for some reason. Check your internet connection.");
            }
          });
        }
      }
    </script>
    <?php } ?>
  <?php } ?>
</section>
<br/>
<?php if ($_SESSION['user_id'] > 0){ ?>
<a href="#topic-create-comment" id="topic-a-comment">+ Add a comment</a>
<fieldset id="topic-create-comment">
<legend>Add new comment</legend>
<form action="<?php echo URL_DISCUSS?>?view=create&c=post&t=<?php echo $topic['topic_id'];?>" method="post">
  Title: <input type="text" name="title" value="RE: <?php echo $topic['title'];?>"/><br/>
  Comment: <textarea name="desc" placeholder="Write your comment here..." style="vertical-align:top; height:200px;"></textarea><br/>
  <input name="forum" value="<?php echo $topic['forum_id'];?>" hidden="hidden"/>
  <input type="submit" value="Comment"/>
</form>
</fieldset>

<script>
  $("#topic-create-comment").hide();
  $("#topic-a-comment").click(function(){
    $("#topic-a-comment").hide();
    $("#topic-create-comment").slideToggle(300);
  });
</script>
<?php } ?>
<?php } else{
  echo "<h1 style='text-align:center;'>Topic Not Found</h1>";
  echo "<p style='text-align:center;'>The topic you were looking for is not found. Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!</p>";
}?>