<?php
if (empty($_GET['c'])){
  echo "Can't create anything because you didn't tell me to do anything! Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
}
else{
  switch($_GET['c']){
    case "post":
      if (empty($discuss->get_topic(intval($_GET['t']),1))){
        echo "Topic does not exist! Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
        break;
      }
      if (trim(strlen($_POST['title'])) < 5){
        echo "Your title needs to have at least 5 characters (excluding spaces)!"; ?>
        <fieldset id="topic-create-comment">
        <legend>Add new comment</legend>
        <form action="<?php echo URL_DISCUSS?>?view=create&c=post&t=<?php echo intval($_GET['t']);?>" method="post">
          Title: <input type="text" name="title" value="<?php echo $_POST['title']?>"/><br/>
          Comment: <textarea name="desc" placeholder="Write your comment here..." style="vertical-align:top; height:200px;"><?php echo $_POST['desc']?></textarea><br/>
          <input name="forum" value="<?php echo intval($_POST['forum']);?>" hidden="hidden"/>
          <input type="submit" value="Comment"/>
        </form>
        </fieldset>
  <?php 
      }
      else if (trim(strlen($_POST['desc'])) < 10){
        echo "Your description needs to have at least 10 characters (excluding spaces)!"; ?>
        <fieldset id="topic-create-comment">
        <legend>Add new comment</legend>
        <form action="<?php echo URL_DISCUSS?>?view=create&c=post&t=<?php echo intval($_GET['t']);?>" method="post">
          Title: <input type="text" name="title" value="<?php echo $_POST['title']?>"/><br/>
          Comment: <textarea name="desc" placeholder="Write your comment here..." style="vertical-align:top; height:200px;"><?php echo $_POST['desc']?></textarea><br/>
          <input name="forum" value="<?php echo intval($_POST['forum']);?>" hidden="hidden"/>
          <input type="submit" value="Comment"/>
        </form>
        </fieldset>
  <?php
      }
      else{ 
        if (intval($_POST['forum']) == 1){
          $query = "INSERT INTO ".DISCUSS_POSTS_SPECIAL_TABLE." (user_id, style_id, time, title, text) VALUES (:user, :topic, :time, :title, :text)";
          $sth = $dbc->prepare($query);
          $result = $sth->execute(array(
            ':user' => intval($_SESSION['user_id']),
            ':topic' => intval($_GET['t']),
            ':time' => time(),
            ':title' => htmlspecialchars($_POST['title']),
            ':text' => htmlspecialchars($_POST['desc'])
          ));
          if ($result){
            echo "Topic created! Redirecting...";
            echo "<meta http-equiv=\"refresh\" content=\"1;URL='".URL_DISCUSS."?view=topic&f=".intval($_POST['forum'])."&t=".intval($_GET['t'])."'\" />";
          }
          else{
            echo "Something wrong happened while posting your comment! Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
          }
        }
        else{
          $query = "INSERT INTO `cyneerco_evdo`.`discuss_posts` (`post_id`, `user_id`, `topic_id`, `time`, `title`, `text`, `thanks`) VALUES (NULL, '7', '2', '100', 'wat', 'wat', '1|2|3|4|5|6|7|8');";
        }
      }
      break;
    case "topic":
      echo "Topics can't be created as of yet.";
      break;
    default:
      echo "Can't create a '".htmlspecialchars($_GET['c'])."' because it is an unknown type. Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
  }
}
?>