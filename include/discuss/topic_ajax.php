<?php 
session_start();
switch($_POST['action']){
  case "thank":
    $result = $discuss->thank(intval($_POST['id']), intval($_POST['type']), intval($_SESSION['user_id']));
    if ($result){
      echo "";
    }
  default:
    return "No action exists or defined. Try again.";
}
?>