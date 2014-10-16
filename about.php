<?php
  $title = "About";
  include("include/include.php");
  session_start();
  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
  get_header();
?>
<section id="content">
  <h1>What is this?</h1>
  <p>Everything Dojo is a website that is aimed at assisting AoPS users in writing and choosing CSS styles. It consists of four main sections: the Theme Database, the Themizer, the Try-It, and the discussion area.</p>
  <h2>Theme Database</h2>
  <p>The Theme Database (henceforth referred to as the Theme DB) is a collection of styles written for AoPS blogs. All of them have been approved by a team of AoPS users like you, and are guaranteed to follow the following guidelines:
    <ul>
      <li>They don't contain any content which your parents wouldn't want you to see.</li>
      <li>They don't make the blog impossible to use.</li>
      <li>They aren't simple alterations of already existing themes (e. g. only background is changed or only the colour of the links is different).</li>
    </ul>
    There are no limitations on the style of the theme, so you can probably find one that is just right for you and your blog.
  </p>

  <h2>Themizer</h2>
  <p>The Themizer is a tool for creating your own simple themes. You can choose one of several base themes from which to start, then choose your background colour, the colour of the border around the entries, and the font. You can also add some of your own rules to the stylesheet for even more customization.</p>
  <br />
  <p>If you are experienced with CSS, you can also use the Themizer in developer mode to test your style as you write it.</p>

  <h2>Try-It</h2>
  <p>The Try-It lets you test any theme in the Theme DB without having to actually put it on your blog. You choose from a list of themes, and it is automatically applied to a test blog with several entries so that you can easily see what it would look like when applied to your blog.</p>

  <h2>Discuss</h2>
  <p>If you have found a problem with a theme, or just want to tell the author that you like it, Discuss is the place for you. Every time a theme is approved, a topic is automatically created in the discussion area for conversation about that theme. There is also a section in the discussion area for feedback, bug reports, and questions about the site itself.</p>

  <h1>How did this start?</h1>
  <p>The original version of this site was written by an AoPS user named Dojo. It contained all the same main sections as the current website, but looked a lot different. On May 27, 2014, Dojo announced that he was looking for help rebuilding the site. That rebuild resulted in the site you are looking at now.</p>

  <h1>Who are we?</h1>
  <p>This website was written and is maintained by a collection of volunteer AoPS users. Everything Dojo was originally created by <strong>Dojo</strong>, and since has multiplied staff. There are two teams of people who work on this project, The Staff and The Team.</p>
  <p>The Staff helps maintain the site and provide user support. If you need styles approved, posts moderated, or questions answered, let these guys know:</p>
  <ul>
    <li>csmath</li>
    <li>El_Ectric</li>
    <li>RTG</li>
  </ul>
  <br />
  <p>The Team contributes to EvDo by coding the website, fixing bugs, and adding more features. Those who have worked long hours on bringing you 2.0 include:</p>
  <ul>
    <li>Dojo</li>
    <li>knittingfrenzy18</li>
    <li>NeoMathematicalKid</li>
    <li>Tungsten</li>
    <li>thatmathgeek</li>
    <li>nxt</li>
    <li>PythonNut</li>
  </ul>
  <br />
  <p>If you'd like to help contribute to Everything Dojo by joining one of the two teams, please contact us through our contact form, or private message knittingfrenzy18 on AoPS.</p>
</section>

<?php get_footer(); ?>
