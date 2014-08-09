<?php
/*
* Discuss Version 1.0
* Methods
*/
class discuss {

  function __construct($dbc){
    $this->dbc = $dbc;
  }
	
	function get_fora($forum_id = 'all', $parent_id = 'all'){
      if ($forum_id != 'all'){
        $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE;
      }
      else{
		$query = "SELECT * FROM " . DISCUSS_FORUM_TABLE;
		$sth = $this->dbc->prepare($query);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
      }
	}

	function get_topics($id, $user_id){
		// make sure the type is not special
		$query = "SELECT `type` FROM " . DISCUSS_FORUM_TABLE . " WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
		
		$type = $sth->fetch(PDO::FETCH_ASSOC);
		$type = $type['type'];
		
		// special fora
		if($type == 0){
			if($id == 1){
					$query = "SELECT `name` AS `title`, `description` FROM `" . THEMEDB_TABLE . "`";
					$sth = $this->dbc->prepare($query);
					$sth->execute();			
					$result = $sth->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row){
						$query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id AND `user_id` = :user_id";
						$sth = $this->dbc->prepare($query);
						$sth->execute(array(
							':id' 			=> $row['id'],
							':user_id'	=> $user_id
						));						
						$count = $sth->fetchColumn();
						if($count == 0){
							$row['read'] = 0;
						}
						else{
							$row['read'] = 1;
						}
					}
			}
			else{
			}
		}
		else{
		}
		
		return $result;
	}

}
$discuss = new discuss($dbc);
?>
