<?php
class notification{
	function __construct($dbc){
		$this->dbc = $dbc;
	}
	
	function get_type_data($id){
		$query = "SELECT `name` FROM `notification_types` WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
		
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$name = $result['name'];
		
		$file = 'notification/' . $name . '.php';
		include($file);
		
		$obj = new $name();
		$data = $obj->get_data();
		
		return $data;
	}
	
	function insert_notification($type_id, $item_id, $user_id){
		$query = "INSERT INTO `notifications` (`notification_type`, `item_id`, `user_id`, `timestamp`) VALUES (:type, :item, :user, :time)";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':type' => $type_id,
			':item' => $item_id,
			':user' => $user_id,
			':time' => time()
		));
	}
}
$notification = new notification($dbc);
?>