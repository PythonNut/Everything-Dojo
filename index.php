<?php 
  include('include/include.php');
  generateHeader('Index');
  include('include/login-bar.php');
?>
<div id="index-content">
  <div id="index-content-inner">
    <div class="index-row">

      <a href=<?php echo '"' . URL_DATABASE . '"'; ?> class="index-link">
        <div class="index-item" id="index-database">
        	<div class="index-text-container">
				<img src="images/index-database.png" />
            </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_THEMIZER . '"'; ?> class="index-link">
        <div class="index-item" id="index-themizer">
        	<div class="index-text-container">
				<img src="images/index-themizer.png" />
            </div>
        </div>
      </a>
      
    </div>

    <div class="index clear-row"></div> <!-- may change .index later on -->

    <div class="index-row">

      <a href=<?php echo '"' . URL_TRYIT . '"'; ?> class="index-link">
        <div class="index-item" id="index-tryit">
        	<div class="index-text-container">
				<img src="images/index-tryit.png" />
            </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_DISCUSS . '"'; ?> class="index-link">
        <div class="index-item" id="index-discuss">
        	<div class="index-text-container">
				<img src="images/index-discuss.png" />
            </div>
        </div>
      </a>

    </div>

  </div>
</div>

<?php
  include('include/footer.php');
?>

