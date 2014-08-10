<?php 
session_start();
switch($_POST['action']){
  case "thank":
    $discuss->thank(intval($_POST['id']), intval($_POST['type']), intval($_SESSION['user_id']));
  default:
    return "No action exists or defined. Try again.";
}
?>