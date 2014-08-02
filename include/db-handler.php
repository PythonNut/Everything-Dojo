<?php
include('include.php');
include('themedb.php');
session_start();

  $mode = $_POST['mode'];
  switch($mode){
    case 'submit-theme':
      $data = $_POST;
      $data['submitted_by'] = $_SESSION['user_name'];
      $data['submitted_by_id'] = $_SESSION['user_id'];
      $id = $themedb->submit_theme($data);

      header('Location: http://' . URL_DATABASE . '?mode=view&view=style&id=' . $id);
      break;
  }
?>
