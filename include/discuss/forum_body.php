<?php
  $id = $_GET['f'];
  if (empty($id)){
    $id = 0;
  }
  else if($id == ''){
    redirect(URL_DISCUSS);
  } 
  else{
    if(!isset($_SESSION['user_id'])){
      $user_id = 0;
    }
    else{
      $user_id = $_SESSION['user_id'];
    }
    $topics = $discuss->get_topics(intval($id), $user_id);
  }
  
  if ($id == 1){
    $typearg = 1;
  }
  else{
    $typearg = 0;
  }
  $forum_data = $discuss->get_fora($id);
  $type = $forum_data['type'];
?>

<section id="discuss-topics" style="clear:left;">
  <h3 style="text-align: center;"><?php echo $forum_data['name']; ?></h3>
  <p style="text-align: center;"><?php echo $forum_data['description']; ?></p>
  <?php 
  if ($user_id > 0 and intval($id) != 1){
    echo "<a href=\"#topic-create-topic\" id=\"topic-a-topic\" style=\"left: 5%; position: relative;\">+ Create New Topic</a><br />";
		if(!empty($_SESSION['err'])){
			echo '<div id="errors">';
			foreach($_SESSION['err'] as $error){
				echo '<p class="invalid">' . $error . '</p><br />';
			}
			echo '</div>';
		}
		unset($_SESSION['err']);
	?>  
  <fieldset id="topic-create-topic">
  <legend>Add new topic</legend>
  <form action="include/discuss-handler.php" method="post">
    Title: <input type="text" name="title" value=""/><br/>
    Message: <br /><textarea name="desc" placeholder="Write your post here..." style="vertical-align:top; height:200px;"></textarea><br/>
    <input type="hidden" name="forum" value="<?php echo $id;?>" />
    <input type="hidden" name="mode" value="topic">
    <input type="submit" value="Post"/>
  </form>
  </fieldset>
  
  <script>
    $("#topic-create-topic").hide();
    $("#topic-a-topic").click(function(){
      $("#topic-a-topic").hide();
      $("#topic-create-topic").slideToggle(300);
    });
  </script>
  <?php
  }
	if($_SESSION['user_id'] != 0){
	?>
  <a href="javascript:;" onClick="mark_all_read(<?php echo $id . ', ' . $_SESSION['user_id']; ?>)" style="left: 5%; position: relative;">Mark All Read</a>
  <?php
	}
  ?>
    <table class="discuss-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td colspan="2">Topic</td>
          <td class="med-col center">Author</td>
          <td class="small-col center">Comments</td>
          <td class="small-col center">Viewed By</td>
          <td class="med-col center">Last Post</td> 
        <tr>
      </thead>
      <tbody>
      <?php if(count($topics) == 0){ ?>
      	<tr style="cursor:pointer;">
          <td colspan="2">No topics</td>
          <td class="center">-</td>
          <td class="center">-</td>
          <td class="center">-</td>
          <td class="center">-</td>
        </tr>
      <?php } else{ 
		foreach($topics as $topic){ 
		  $username = get_user($topic['user_id']);
		  $comments = $discuss->get_comment_count($topic['topic_id'], $type);
		  if($type == 1){
		    $comments = $comments - 1;
		  }
      ?>
        <tr style="cursor:pointer;" onclick="window.location.href='<?php echo URL_DISCUSS; ?>?view=topic&f=<?php echo intval($id); ?>&t=<?php echo $topic['topic_id']; ?>'">
					<td class="tiny-col"><p class="topic-icon <?php if($topic['read'] == 1){ echo 'read-icon'; }else{ echo 'unread-icon'; }?>"></p></td>
          <td><?php echo htmlspecialchars($topic['title']); ?></td>
          <td class="center"><?php echo $username; ?></td>
          <td class="center"><?php echo $comments; ?></td>
          <td class="center"><?php echo $discuss->get_views($topic['topic_id'], 1 - $typearg); ?></td>
          <td class="center"><?php $lastpost = $discuss->get_posts(intval($topic['topic_id']), 'all', $typearg); 
					if (empty($lastpost)){ 
						echo date('M d, Y g:i a', $topic['time'])."<br /><b>".get_user($topic['user_id'])."</b>";
					} 
					else{ 
						echo date('M d, Y g:i a', $lastpost[count($lastpost)-1]['time'])."<br /><b>".get_user($lastpost[count($lastpost)-1]['user_id'])."</b> "; 
					} ?></td>
        </tr>
      <?php }
			} ?>
      </tbody>
    </table>
    <?php
			if($_SESSION['user_id'] != 0){
		?>
		<a href="javascript:;" onClick="mark_all_read(<?php echo $id . ', ' . $_SESSION['user_id']; ?>)" style="left: 5%; position: relative;">Mark All Read</a>
		<?php
		}
		?>
</section>
