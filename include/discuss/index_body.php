<?php
  $fora = $discuss->get_fora('all', 0);
?>
<h2 style="text-align: center;">EverythingDojo Discussion Forum</h2>
<section id="fora">
  <?php
  foreach($fora as $forum){
  ?>
  <a href="<?php echo URL_DISCUSS; ?>?view=forum&f=<?php echo $forum['id']; ?>">
	<section class="discuss-fora">
  	<div class="discuss-arrow-up"></div>
		<div class="discuss-fora-text">
    	<div class="discuss-fora-text-inner">
        <h3><?php echo $forum['name']; ?></h3>
        <p><?php echo $forum['description']; ?></p>
    </div>
    </div>
	</section>
  </a>
  <?php
  }
	?>