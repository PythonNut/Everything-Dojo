<?php
include('include.php');
include('themedb.php');
session_start();

	$mode = $_POST['mode'];
	$_SESSION['mode'] = $mode;
	switch($mode){
		case 'submit-theme':
			$data = $_POST;
			$data['submitted_by'] = $_SESSION['user_name'];
			$data['submitted_by_id'] = $_SESSION['user_id'];
			$_SESSION['id'] = $themedb->submit_theme($data);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');	
			break;
		case 'edit-theme':
			$data = $_POST;
			$_SESSION['id'] = $themedb->edit_theme($data);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');
			break;
		case 'settings':
			$data = $_POST;
			$_SESSION['id'] = $themedb->edit_settings($data);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');
			break;
		case 'approve':
			$data = $_POST;
			$owner = $themedb->get_owner($data['id']);
			$notification->insert_notification(1, $data['id'], $owner);
			$themedb->approve_theme($data['id']);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');
			break;
		case 'validate':
			$data = $_POST;
			$owner = $themedb->get_owner($_POST['id']);
			$notification->insert_notification(2, $_POST['id'], $owner);
			$themedb->validate_theme($_POST['id']);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');
			break;
		case 'delete':
			$data = $_POST;
			$themedb->delete_theme($data['id']);
			
			header('Location: ' . SITE_ROOT . 'include/db-success.php');
			break;
	}
?>