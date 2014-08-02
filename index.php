<?php
  $title = "Home";
  include("include/include.php");
  session_start();
  get_header();
?>
<section id="content">
  <?php if(!empty($_GET['msg'])) {
    echo "<p class=\"msg\">" . filter($_GET['msg']) . "</p>";
  } ?>
  <section id="index-inner">
    <section class="index-row">

      <a href=<?php echo '"' . URL_DATABASE . '"'; ?> class="index-link">
        <section class="index-item database" id="index-database">
          <article class="index-text-container">
            <h4 class="index-title">Database</h4>
            <p class="index-text">A collection of AoPS Blog CSS themes for your perusal.</p>
          </article>
        </section>
      </a>

      <a href=<?php echo '"' . URL_THEMIZER . '"'; ?> class="index-link">
        <section class="index-item themizer" id="index-themizer">
          <article class="index-text-container">
            <h4 class="index-title">Themizer</h4>
            <p class="index-text">Want to customize a theme for yourself? Then themizer is the tool for you!</p>
          </article>
        </section>
      </a>
      
    </section>

    <div class="clear"></div>
    
    <section class="index-row">

      <a href=<?php echo '"' . URL_TRYIT . '"'; ?> class="index-link">
        <section class="index-item tryit" id="index-tryit">
          <article class="index-text-container">
            <h4 class="index-title">Try-It</h4>
            <p class="index-text">Want to try out a theme before you actually use it on your blog? Give it a try with this tool!</p>
          </article>
        </section>
      </a>

      <a href=<?php echo '"' . URL_DISCUSS . '"'; ?> class="index-link">
        <section class="index-item discuss" id="index-discuss">
          <article class="index-text-container">
            <h4 class="index-title">Discuss</h4>
            <p class="index-text">Come join our community of fellow AoPS bloggers and stylists!</p>
          </article>
        </section>
      </a>

    </section>
  </section>
</section>

<?php get_footer(); ?>
