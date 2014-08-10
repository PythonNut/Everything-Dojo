<?php
	$id = $_GET['id'];
	if($id == ''){
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
  ?>

<?php if (!empty($topics)){?>
<section id="discuss-topics" style="clear:left;">
  <h3 style="text-align: center;">Topics</h3>
    <table class="discuss-table">
      <thead style="border-bottom: 1px black solid;">
        <tr>
          <td class="small-col">Title</td>
          <td class="med-col">Description</td>
          <td class="small-col">View Count</td>
          <td class="small-col">Posts</td>
        <tr>
      </thead>
      <tbody>
      <?php foreach($topics as $topic){ ?>
        <tr style="cursor:pointer;" onclick="window.location.href='<?php echo URL_DISCUSS; ?>?view=topic&f=<?php echo $id; ?>&t=<?php echo $topic['topic_id']; ?>'">
          <td><?php echo $topic['title'];?></td>
          <td><?php echo shorten_desc($topic['description'],0,100);?></td>
          <td><?php echo $topic['views'];?></td>
          <td></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
</section>
<?php } ?>