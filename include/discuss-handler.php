<?php
include('include.php');
include('discuss.php');
session_start();

  $mode = $_POST['mode'];
  $_SESSION['mode'] = $mode;
  switch($mode){
    case 'post':
      $data = $_POST;
			$data['t'] = $_POST['t'];
      $result = $discuss->insert_post($_POST['forum'], $_SESSION['user_id'], $data);
			$_SESSION['t'] = $result['t'];
			$_SESSION['f'] = $result['f'];
			$_SESSION['err'] = $result['err'];

      header('Location: ' . SITE_ROOT . 'include/discuss-success.php');
      break;
		case 'topic':
			$data = $_POST;
      $result = $discuss->insert_topic($_POST['forum'], $_SESSION['user_id'], $data);
			$_SESSION['t'] = $result['t'];
			$_SESSION['f'] = $result['f'];
			$_SESSION['err'] = $result['err'];		
			
			header('Location: ' . SITE_ROOT . 'include/discuss-success.php');	
			break;
  }
?>
