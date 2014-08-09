<?php
  $title = "Discuss";
  include("include/include.php");
	include("include/discuss.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/discuss.css\" />";
  get_header();
	$view = $_GET['view'];
?>
<section id="content">
	<section id="announcements">
    <h3>Announcements: </h3>
			<div id="discuss-round-left">&larr;</div>
				<div id="discuss-announcements">
					<div class="discuss-announcement" id="discuss-announcement-1">Announcement #1</div> 
          <div class="discuss-announcement" id="discuss-announcement-2">Announcement #2</div>
          <div class="discuss-announcement" id="discuss-announcement-3">Announcement #3</div>
        </div>
        <div id="discuss-round-right">&rarr;</div>
          <script>
            var announcement_options = {
              num: 3,
              start: 1,
              now: 1,
              aidPrefix: "discuss-announcement-",
              updateView: function(){
                for (ji = announcement_options.start; ji <= announcement_options.num; ji++){
                  $("#"+announcement_options.aidPrefix+ji).fadeOut(100);
                }
                $("#"+announcement_options.aidPrefix+announcement_options.now).delay(200).fadeIn(100);
              }
            }
            $(document).ready(function(){
              //start up
              for (ji = announcement_options.start; ji <= announcement_options.num; ji++){
                $("#"+announcement_options.aidPrefix+ji).hide();
              }
              announcement_options.now = announcement_options.start;
              $("#"+announcement_options.aidPrefix+announcement_options.now).show();
            });
            
            $("#discuss-round-left").on('click', function(){
              if (announcement_options.now == announcement_options.start){
                announcement_options.now = announcement_options.num;
              }
              else{
                announcement_options.now -= 1;
              }
              announcement_options.updateView();
            });
            
            $("#discuss-round-right").on('click', function(){
              if (announcement_options.now == announcement_options.num){
                announcement_options.now = announcement_options.start;
              }
              else{
                announcement_options.now += 1;
              }
              announcement_options.updateView();
            });
          </script>        
      </section>
    </section>
      <br/>
    <?php
		switch($view){
			case '':
				include('include/discuss/index_body.php');
				break;
		}
		?>
</section>

<?php get_footer(); ?>
