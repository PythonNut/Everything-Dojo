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
        $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE id = '".intval($forum_id)."'";
        $sth = $this->dbc->prepare($query);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
      }
      else if ($parent_id != 'all'){
        $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE parent = '".intval($parent_id)."'";
        $sth = $this->dbc->prepare($query);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
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
		  if($id == 1){       //theme db forum
		    $query = "SELECT `name` AS `title`, `description` FROM `" . THEMEDB_TABLE . "`";
		    $sth = $this->dbc->prepare($query);
		    $sth->execute();			
		    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
		    foreach($result as $row){
		      $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id AND `user_id` = :user_id";
		      $sth = $this->dbc->prepare($query);
		      $sth->execute(array(
				':id' 		=> $row['id'],
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
		    $query = "SELECT * FROM " . DISCUSS_TOPIC_TABLE . " WHERE 'forum_id' = :id";
            $sth = $this->dbc->prepare($query);
		    $sth->execute(array(
		      ':id' => $id,
		    ));	
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          }
		}
		else{
          //idk
		}
		
		return $result;
	}
    //get specific topic
    function get_topic($topic_id){
      $query = "SELECT * FROM " . DISCUSS_TOPIC_TABLE . " WHERE `id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
		':id' => $topic_id
      ));
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
    //get posts from topic with id ($topic_id) [optional: also gets posts from user with id ($user_id)]
    function get_posts($topic_id = 'all', $user_id = 'all'){
      if ($topic_id != 'all'){
        if ($topic_id == 1){
          $query = "SELECT * FROM " . DISCUSS_TOPIC_TABLE . " WHERE `id` = 1";
        }
      }
      if ($user_id != 'all'){
        
      }
    }

}
$discuss = new discuss($dbc);
?>
