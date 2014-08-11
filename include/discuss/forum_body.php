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
    <table class="discuss-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td class="small-col">Topic</td>
          <td class="med-col">Author</td>
          <td class="small-col">Comments</td>
          <td class="small-col">Views</td>
          <td class="med-col">Last Comment</td> 
        <tr>
      </thead>
      <tbody>
      <?php if(count($topics) == 0){ ?>
      	<tr style="cursor:pointer;">
          <td>No topics</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
        </tr>
      <?php } else{ 
		foreach($topics as $topic){ 
		  $username = get_user($topic['user_id']);
		  $comments = $topic['comment_count'];
		  if($type == 1){
		    $comments = $comments - 1;
		  }
      ?>
        <tr style="cursor:pointer;" onclick="window.location.href='<?php echo URL_DISCUSS; ?>?view=topic&f=<?php echo intval($id); ?>&t=<?php echo $topic['topic_id']; ?>'">
          <td><?php echo htmlspecialchars($topic['title']); ?></td>
          <td><?php echo $username; ?></td>
          <td><?php echo $comments; ?></td>
          <td><?php echo $topic['views']; ?></td>
          <td><?php $lastpost = $discuss->get_posts(intval($topic['topic_id']), 'all', $typearg); if (empty($lastpost)){ echo "-";} else{ echo 
"<b>".$discuss->get_user($lastpost[count($lastpost)-1]['user_id'])['user_name'].":</b> ".substr($discuss->parse_code($lastpost[count($lastpost)-1]['text']),0,100)." (...)";} ?></td>
        </tr>
      <?php }} ?>
      </tbody>
    </table>
</section>
