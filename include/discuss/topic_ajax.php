<?php 
error_reporting(E_ALL);
session_start();
include('../include.php');
include('../discuss.php');
switch ($_POST['action']) {
  case "thank":
    $discuss = new discuss($dbc);
    $result = $discuss->thanks(intval($_POST['id']), intval($_POST['mode']), intval($_SESSION['user_id']));
    if ($result >= 0){
      echo "success|".$result;
    }
    break;
  case "edit":
    
    if ($_SESSION['user_id']){
    
    }
    break;
  default:
    echo "No action exists or defined. Try again.";
}
?>