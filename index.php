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
            <h3 class="index-title">DATABASE</h3>
            <p class="index-text">A collection of AoPS Blog CSS themes for your perusal.</p>
          </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_THEMIZER . '"'; ?> class="index-link">
        <div class="index-item" id="index-themizer">
          <div class="index-text-container">
            <h3 class="index-title">THEMIZER</h3>
            <p class="index-text">Want to customize a theme for yourself? Then themizer is the tool for you!</p>
          </div>
        </div>
      </a>
      
    </div>

    <div class="index clear-row"></div> <!-- may change .index later on -->

    <div class="index-row">

      <a href=<?php echo '"' . URL_TRYIT . '"'; ?> class="index-link">
        <div class="index-item" id="index-tryit">
          <div class="index-text-container">
            <h3 class="index-title">TRY-IT</h3>
            <p class="index-text">Want to try out a theme before you actually use it on your blog? Give it a try with this tool!</p>
          </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_DISCUSS . '"'; ?> class="index-link">
        <div class="index-item" id="index-discuss">
          <div class="index-text-container">
            <h3 class="index-title">DISCUSS</h3>
            <p class="index-text">Come join our community of fellow AoPS bloggers and stylists!</p>
          </div>
        </div>
      </a>

    </div>

  </div>
</div>

<?php
  include('include/footer.php');
?>

