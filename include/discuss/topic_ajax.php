<?php 
error_reporting(E_ALL);
session_start();
include('../include.php');
include('../discuss.php');

function edit_post($text, $mode, $pid){
    global $dbc, $_SESSION;
    if ($_SESSION['user_id'] <= 0){
      return false;
    }
    else if ($mode == 1){
      $update_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_SPECIAL_TABLE." SET text = :text, edit_id = :eid, last_timestamp = :time WHERE post_id = :pid");
      $update_post = $update_post->execute(array(
        ':text' => $text,
        ':pid' => intval($pid),
        ':eid' => intval($_SESSION['user_id']),
        ':time' => time()
      ));
      return $update_post;
    }
    else{
      $update_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_TABLE." SET text = :text, edit_id = :eid, last_timestamp = :time WHERE post_id = :pid");
      $update_post = $update_post->execute(array(
        ':text' => $text,
        ':pid' => intval($pid),
        ':eid' => intval($_SESSION['user_id']),
        ':time' => time()
      ));
      return $update_post;
    }
}

switch ($_POST['action']) {
  case "thank":
    $discuss = new discuss($dbc);
    $result = $discuss->thanks(intval($_POST['id']), intval($_POST['mode']), intval($_SESSION['user_id']));
    if ($result >= 0){
      echo "success|".$result;
    }
    break;
  case "edit":
    if ($_SESSION['user_id'] > 0){
      if ($_POST['mode'] == 1){
        $selected_post = $dbc->prepare("SELECT * FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :pid");
        $selected_post->execute(array(
          ':pid' => intval($_POST['id'])
        ));
        $selected_post = $selected_post->fetchAll(PDO::FETCH_ASSOC);
        $selected_post = $selected_post[0];
      }
      else{
        $selected_post = $dbc->prepare("SELECT * FROM ".DISCUSS_POSTS_TABLE." WHERE post_id = :pid");
        $selected_post->execute(array(
          ':pid' => intval($_POST['id'])
        ));
        $selected_post = $selected_post->fetchAll(PDO::FETCH_ASSOC);
        $selected_post = $selected_post[0];
      }
      if (strlen(trim($_POST['text'])) < 10){
        echo "textov";
      }
      else if ($_SESSION['user_id'] == $selected_post['user_id']){
        if (edit_post($discuss->filter_swear_words(htmlspecialchars($_POST['text'])), intval($_POST['mode']), intval($_POST['id'])) == true){
          echo "samusr|".$discuss->filter_swear_words(htmlspecialchars($_POST['text']));
        }
        else{
          echo "deaddb";
        }
      }
      else if ($_SESSION['user_level'] >= 3){
        if (edit_post($discuss->filter_swear_words(htmlspecialchars($_POST['text'])), intval($_POST['mode']), intval($_POST['id'])) == true){
          echo "op_mod|".$discuss->filter_swear_words(htmlspecialchars($_POST['text']));
        }
        else{
          echo "deaddb";
        }
      }
      else{
        echo "unauth";
      }
    }
    break;
  case "delete":
    if ($_SESSION['user_level'] >= 3){
      if (intval($_POST['mode']) == 1){
        $selected_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_SPECIAL_TABLE." SET type = '1', edit_id = :usr_id, last_timestamp = :tme WHERE post_id = :pid");
        $selected_post->execute(array(
          ':usr_id' => intval($_SESSION['user_id']),
          ':tme' => time(),
          ':pid' => intval($_POST['id'])
        ));
        echo "good";
      }
      else{
        $selected_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_TABLE." SET type = '1', edit_id = :usr_id, last_timestamp = :tme WHERE post_id = :pid");
        $selected_post->execute(array(
          ':usr_id' => intval($_SESSION['user_id']),
          ':tme' => time(),
          ':pid' => intval($_POST['id'])
        ));
        echo "good";
      }
    }
    else{
      echo "fail";
    }
    break;
  case "clear_thanks":
    if ($_SESSION['user_level'] >= 3){
      if (intval($_POST['mode']) == 1){
        $selected_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_SPECIAL_TABLE." SET thanks = '' WHERE post_id = :pid");
        $selected_post->execute(array(
          ':pid' => intval($_POST['id'])
        ));
        echo "good";
      }
      else{
        $selected_post = $dbc->prepare("UPDATE ".DISCUSS_POSTS_TABLE." SET thanks = '' WHERE post_id = :pid");
        $selected_post->execute(array(
          ':pid' => intval($_POST['id'])
        ));
        echo "good";
      }
    }
    else{
      echo "fail";
    }
    break;
  case "move":
    if ($_SESSION['user_level'] >= 3){
      if (intval($_POST['mode']) == 1){
        echo "bad_noThemeDBExport";
      }
      else{
        if (in_array(intval($_POST['location']), array(2,3,4))){
          $selected_post = $dbc->prepare("UPDATE ".DISCUSS_TOPIC_TABLE." SET forum_id = :fid WHERE topic_id = :tid");
          $selected_post->execute(array(
            ':fid' => intval($_POST['location']),
            ':tid' => intval($_POST['id'])
          ));
          echo "good";
        }
        else{
          echo intval($_POST['location'])."bad_notInRange";
        }
      }
    }
    else{
      echo "fail";
    }
    break;
  default:
    echo "No action exists or defined. Try again.";
}
?>