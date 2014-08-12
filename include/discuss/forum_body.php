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
    echo "<a href='".URL_DISCUSS."?view=create&c=topic&f=".intval($id)."'>+ Create New Topic</a>";
  }
  ?>
    <table class="discuss-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td colspan="2">Topic</td>
          <td class="med-col center">Author</td>
          <td class="small-col center">Comments</td>
          <td class="small-col center">Views</td>
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
		  $comments = $discuss->get_comment_count($topic['topic_id'], 0);
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
</section>
