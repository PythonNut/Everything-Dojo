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
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);			
			break;
		case 'edit-theme':
			$data = $_POST;
			$id = $themedb->edit_theme($data);
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);
			break;
		case 'settings':
			$data = $_POST;
			$id = $themedb->edit_settings($data);
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=view&view=style&id=' . $id);
			break;
		case 'approve':
			$data = $_POST;
			$owner = $themedb->get_owner($data['id']);
			$notification->insert_notification(1, $data['id'], $owner);
			$themedb->approve_theme($data['id']);
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=mcp');
			break;
		case 'validate':
			$data = $_POST;
			$owner = $themedb->get_owner($_POST['id']);
			$notification->insert_notification(2, $_POST['id'], $owner);
			$themedb->validate_theme($_POST['id']);
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=mcp');
			break;
		case 'delete':
			$data = $_POST;
			$themedb->delete_theme($data['id']);
			
			header('Location: ' . SITE_ROOT . URL_DATABASE . '?mode=manage');
			break;
	}
?>