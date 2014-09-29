<?php
  if (empty($_GET['id'])) {
    $fora = $discuss->get_fora('all', '0', $_SESSION['user_id']);
  } else {
    $fora = $discuss->get_fora('all', intval($_GET['id']), $_SESSION['user_id']);
  }
?>
<h2 style="text-align: center;">EverythingDojo Discussion Forum</h2>
<section id="fora">
  <?php foreach ($fora as $forum) { ?>
  <a href="<?php echo URL_DISCUSS; ?>?view=forum&f=<?php echo $forum['id']; ?>">
	<section class="discuss-fora <?php if ($forum['read'] == 1) {echo 'read-forum'; } else { echo 'unread-forum'; }; ?>">
  	<div class="discuss-arrow-up"></div>
		<div class="discuss-fora-text">
    	<div class="discuss-fora-text-inner">
        <h3><?php echo $discuss->parse_code($forum['name']); ?></h3>
        <p><?php echo $discuss->parse_code($forum['description']); ?></p>
    </div>
    </div>
	</section>
  </a>
  <?php } ?>
  