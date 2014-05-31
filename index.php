<?php 
include('include/include.php');
include('include/header.php'); 
?>
<body>

<?php include('include/login-bar.php'); ?>
<div id="index-content">
	<div id="index-content-inner">
    	<div class="index-row">
        	<a href="<?php echo URL_DATABASE; ?>" class="index-item"><div class="index-item" id="index-database"><img class="index-img" src="images/index-database.png" /></div></a>
        	<a href="<?php echo URL_THEMIZER; ?>" class="index-item"><div class="index-item" id="index-themizer"><img class="index-img" src="images/index-themizer.png" /></div></a>
        </div>
        <div class="clear-40"></div>
        <div class="index-row">
        	<a href="<?php echo URL_TRYIT; ?>" class="index-item"><div class="index-item" id="index-tryit"><img class="index-img" src="images/index-tryit.png" /></div></a>
        	<a href="<?php echo URL_DISCUSS; ?>" class="index-item"><div class="index-item" id="index-discuss"><img class="index-img" src="images/index-discuss.png" /></div></a>
    	</div>
    </div>
</div>

<div id="index-footer"><?php echo COPYRIGHT; ?></div>

</body>
</html>