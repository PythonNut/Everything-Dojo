<?php
	$id = $_GET['id'];
	if($id == ''){
		redirect(URL_DISCUSS);
	}
	else{
		$topics = $discuss->get_topics($id);
	}
?>