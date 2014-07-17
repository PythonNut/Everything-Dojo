<?php
  $title = "Home";
  include("include/include.php");
  session_start();
  get_header();
?>
<div id="content">
  <?php if(!empty($_GET['msg']))  {
    echo "<div class=\"msg\">" . $_GET['msg'] . "</div>";
  } ?>
  <div id="index-inner">
    <div class="index-row">

      <a href=<?php echo '"' . URL_DATABASE . '"'; ?> class="index-link">
        <div class="index-item database" id="index-database">
          <div class="index-text-container">
            <h4 class="index-title">Database</h4>
            <p class="index-text">A collection of AoPS Blog CSS themes for your perusal.</p>
          </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_THEMIZER . '"'; ?> class="index-link">
        <div class="index-item themizer" id="index-themizer">
          <div class="index-text-container">
            <h4 class="index-title">Themizer</h4>
            <p class="index-text">Want to customize a theme for yourself? Then themizer is the tool for you!</p>
          </div>
        </div>
      </a>
      
    </div>

    <div class="clear"></div>
    
    <div class="index-row">

      <a href=<?php echo '"' . URL_TRYIT . '"'; ?> class="index-link">
        <div class="index-item tryit" id="index-tryit">
          <div class="index-text-container">
            <h4 class="index-title">Try-It</h4>
            <p class="index-text">Want to try out a theme before you actually use it on your blog? Give it a try with this tool!</p>
          </div>
        </div>
      </a>

      <a href=<?php echo '"' . URL_DISCUSS . '"'; ?> class="index-link">
        <div class="index-item discuss" id="index-discuss">
          <div class="index-text-container">
            <h4 class="index-title">Discuss</h4>
            <p class="index-text">Come join our community of fellow AoPS bloggers and stylists!</p>
          </div>
        </div>
      </a>

    </div>
  </div>
</div>
<?php get_footer(); ?>
