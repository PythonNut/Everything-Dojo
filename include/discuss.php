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
			if($id == 1){
					$query = "SELECT `id` AS `topic_id`, `name` AS `title`, `description` FROM `" . THEMEDB_TABLE . "`";
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
		}
		else{
          
		}
		
		return $result;
	}
    //get specific topic
    function get_topic($topic_id, $type = 0){
      if ($type == 1){
        //get style alone
        $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `id` = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => $topic_id
        ));
        $style = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
        //get patch
        $query = "SELECT * FROM " . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . " WHERE `style_id` = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => $topic_id
        ));
        $style_fix = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
        
        //check if patch is empty, if not then replace with tmp
        if (empty($style_fix)){
          $style_fix = array(
            'user_id' => intval($style['submitted_by_id']),
            'time' => 1388534400,
            'style_id' => intval($topic_id)
          );
        }
        //export result
        $result = array(
          'forum_id' => 1,
          'user_id' => intval($style_fix['user_id']),
          'title' => $style['name'],
          'time' => intval($style_fix['time']),
          'last_timestamp' => intval($style_fix['time']),
          'text' => $style['description'],
          'topic_id' => intval($topic_id)
        );
        return $result;
      }
      else{
        $query = "SELECT * FROM " . DISCUSS_TOPIC_TABLE . " WHERE `id` = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => $topic_id
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }
    }
    //get posts from topic with id ($topic_id) [optional: also gets posts from user with id ($user_id)]
    function get_posts($topic_id = 'all', $user_id = 'all'){
      if ($topic_id != 'all'){
        if ($topic_id == 1){    //special table
          $query = "SELECT * FROM " . DISCUSS_POSTS_SPECIAL_TABLE . " WHERE `topic_id` = :id";
        }
        else{
          $query = "SELECT * FROM " . DISCUSS_POSTS_TABLE . " WHERE `topic_id` = :id";
        }
      }
      else{
        $query = "SELECT * FROM " . DISCUSS_POSTS_SPECIAL_TABLE;
      }
      if ($user_id != 'all'){
        $query = $query." AND user_id = :user";
        $result = $this->dbc->prepare($query);
        $result->execute(array(
          ':id' => intval($topic_id),
          ':user' => intval($user_id)
        ));
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }
      else{
        $result = $this->dbc->prepare($query);
        $result->execute(array(
          ':id' => intval($topic_id)
        ));
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }
    }
    function get_user($user_id){
      $query ="SELECT * FROM users WHERE id = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(':id' => intval($user_id)));
      
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result[0];
    }

}
$discuss = new discuss($dbc);
?>
