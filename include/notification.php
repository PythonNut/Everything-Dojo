<?php
class notification{
	function __construct($dbc){
		$this->dbc = $dbc;
	}
	
	function count_unread($user_id){
		$query = "SELECT COUNT(*) FROM `notifications` WHERE `user_id` = :user_id AND `read` = 0";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':user_id' => $user_id
		));
		
		$count = $sth->fetchColumn();
		
		return $count;
	}
	
	function get_notifications($user_id){
		$query = "SELECT * FROM `notifications` WHERE `user_id` = :user_id ORDER BY `timestamp` DESC LIMIT 5";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':user_id'	=> $user_id
		));
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	function get_notif_obj($id, $item_id){
		$query = "SELECT `name` FROM `notification_types` WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
		
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$name = $result['name'];
		
		$file = 'notification/' . $name . '.php';
		include_once($file);
		
		$obj = new $name($item_id);

		$data = array(
			'data'	=> $obj->get_data(),
			'url'		=> $obj->get_url()
		);
		
		return $data;
	}
	
	function insert_notification($type_id, $item_id, $user_id){
		echo $type_id . '~' . $item_id . '~' . $user_id;
		$query = "INSERT INTO `notifications` (`notification_type`, `item_id`, `user_id`, `timestamp`) VALUES (:type, :item, :user, :time)";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':type' => $type_id,
			':item' => $item_id,
			':user' => $user_id,
			':time' => time()
		));
	}
	
	function mark_read($id){
		$query = "UPDATE `notifications` SET `read` = 1 WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
	}
	
	function mark_all_read($user_id){
		$query = "UPDATE `notifications` SET `read` = 1 WHERE `user_id` = :user_id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':user_id' => $user_id
		));
	}
}
$notification = new notification($dbc);
?>