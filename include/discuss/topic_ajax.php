<?php 
switch("thank"){
  case "thank":
    $result = $discuss->thanks(intval($_POST['id']), intval($_POST['type']), intval($_SESSION['user_id']));
    if ($result){
      echo "true";
    }
    else{
      echo "false";
    }
  default:
    echo "No action exists or defined. Try again.";
}
?>