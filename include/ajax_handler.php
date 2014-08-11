<?php
include('include.php');
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'mark_read':
          $notification->mark_read($_POST['notification_id']);
          break;
        case 'mark_all_read':
          $notification->mark_all_read($_POST['user_id']);
          break;
    }
}
?>