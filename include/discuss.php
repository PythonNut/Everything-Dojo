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
        $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE `id` = :id";
        $sth = $this->dbc->prepare($query);
				$sth->execute(array(
					':id' => $forum_id
				));
		
				$result = $sth->fetch(PDO::FETCH_ASSOC);
		
				return $result;
      }
      else if ($parent_id != 'all'){
        $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE `parent` = :id";
        $sth = $this->dbc->prepare($query);
				$sth->execute(array(
					':id' => $forum_id
				));
		
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

	// get count of all posts in topic
	function get_comment_count($topic_id, $type){
		if($type == 0){
			$query = "SELECT COUNT(*) FROM `" . DISCUSS_POSTS_SPECIAL_TABLE . "` WHERE `style_id` = :topic_id";
			$sth = $this->dbc->prepare($query);
			$sth->execute(array(
				':topic_id' => $topic_id
			));

			$count = $sth->fetchColumn();
		}
		else{
			$query = "SELECT COUNT(*) FROM `" . DISCUSS_POSTS_TABLE . "` WHERE `topic_id` = :topic_id";
			$sth = $this->dbc->prepare($query);
			$sth->execute(array(
				':topic_id' => $topic_id
			));			
			
			$count = $sth->fetchColumn();
		}
		
		return $count;
	}

	// get views
	function get_views($id, $type){
		if($type == 0){
			$query = "SELECT `user_id` FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id";
		}
		else{
			$query = "SELECT `user_id` FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `topic_id` = :id";
		}
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$view_array = array();
        foreach($result as $user){
          if (in_array($user,$view_array)){
            continue;
          }
          else{
            $view_array[] = $user;
            continue;
          }
        }
		return count($view_array);
	}
    function view_topic($id, $type, $user_id){
        if (empty($user_id)){
          return false;
        }
		if($type == 1){
			$query = "INSERT INTO ".DISCUSS_TOPICS_TRACK_SPECIAL_TABLE." (`user_id`, `style_id`, `timestamp`) VALUES (:user, :id, :time);";
		}
		else{
			$query = "INSERT INTO ".DISCUSS_TOPICS_TRACK_TABLE." (`user_id`, `style_id`, `timestamp`) VALUES (:user, :id, :time);";
		}
		$sth = $this->dbc->prepare($query);
		$result = $sth->execute(array(
			':id' => intval($id),
            ':user' => intval($user_id),
            ':time' => intval(time())
		));
		return $result;
	}

	// get topics for view page
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
					$query = "SELECT `id` AS `topic_id`, `submitted_by_id` AS `user_id`, `name` AS `title` FROM `" . THEMEDB_TABLE . "`";
					$sth = $this->dbc->prepare($query);
					$sth->execute();			
					$result = $sth->fetchAll(PDO::FETCH_ASSOC);
					for($i=0;$i<count($result);$i++){
						// check if user viewed
						$query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id AND `user_id` = :user_id";
						$sth = $this->dbc->prepare($query);
						$sth->execute(array(
							':id' 			=> $row['id'],
							':user_id'	=> $user_id
						));						
						$count = $sth->fetchColumn();
						if($count == 0){
							$result[$i]['read'] = 0;
						}
						else{
							$result[$i]['read'] = 1;
						}
						
						// find views
						$result[$i]['views'] = $this->get_views($result[$i]['topic_id'], $type);
						
						// find comment count
						$result[$i]['comment_count'] = $this->get_comment_count($result[$i]['topic_id'], $type);
					}
			}
			else{
				// other ids here
			}
		}
		else{
    	$query = "SELECT * FROM `" . DISCUSS_TOPIC_TABLE . "` WHERE `forum_id` = :id";
			$sth = $this->dbc->prepare($query);
			$sth->execute(array(
				':id' => $id
			));      
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			for($i=0;$i<count($result);$i++){
				// check if user viewed
				$query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `style_id` = :id AND `user_id` = :user_id";
				$sth = $this->dbc->prepare($query);
				$sth->execute(array(
					':id' 			=> $row['id'],
					':user_id'	=> $user_id
				));						
				$count = $sth->fetchColumn();
				if($count == 0){
					$result[$i]['read'] = 0;
				}
				else{
					$result[$i]['read'] = 1;
				}				
				
				// find views
				$result[$i]['views'] = $this->get_views($result[$i]['topic_id'], $type);
				
				// find comment count
				$result[$i]['comment_count'] = $this->get_comment_count($result[$i]['topic_id'], $type);
			}
		}
		
		return $result;
	}
  
    //this is used heavily in Discuss, so just keep this.
    function get_user($user_id){
      $query ="SELECT * FROM users WHERE id = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(':id' => intval($user_id)));   
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result[0];
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
        //export result
        $result = array(
          'forum_id' => 1,
          'user_id' => intval($style['submitted_by_id']),
          'title' => $style['name'],
          'time' => 1388534400,
          'last_timestamp' => 1388534400,       //dojo what is this
          'text' => $style['description'],
          'topic_id' => intval($topic_id),
          'photo_attach' => $style['screenshot']
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
    function get_posts($topic_id = 'all', $user_id = 'all', $type = 0){
      if ($topic_id != 'all'){
        if ($type == 1){    //special table
          $query = "SELECT * FROM " . DISCUSS_POSTS_SPECIAL_TABLE . " WHERE style_id = :id";
        }
        else{
          $query = "SELECT * FROM " . DISCUSS_POSTS_TABLE . " WHERE topic_id = :id";
        }
      }
      else{
        $query = "SELECT * FROM " . DISCUSS_POSTS_TABLE . ", " . DISCUSS_POSTS_SPECIAL_TABLE;
      }
      if ($user_id != 'all'){
        if ($topic_id != 'all'){
          $query = $query." AND user_id = :user";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => intval($topic_id),
            ':user' => intval($user_id)
          ));
        }
        else{
          $query = $query." WHERE user_id = :user";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':user' => intval($user_id)
          ));
        }
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }
      else{
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($topic_id)
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }
    }
    //0 - get thanks from regular, 1 - get thanks from special, 2 - thank regular, 3 - thank special
    function thanks($post_id, $mode = 0, $user_id = null){
      if (empty($post_id)){
        return false;
      }
      else{
        if ($mode == 0){
          $query = "SELECT thanks FROM ".DISCUSS_POSTS_TABLE." WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => intval($post_id)
          ));
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          $result = explode("|",trim($result[0]['thanks']));
          if (empty($result[0])){
            return array();
          }
          else{
            return $result;
          }
        }
        else if ($mode == 1){
          $query = "SELECT thanks FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => intval($post_id)
          ));
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          $result = explode("|",trim($result[0]['thanks']));
          if (empty($result[0])){
            return array();
          }
          else{
            return $result;
          }
        }
        else if ($mode == 2){
          $query = "SELECT thanks FROM ".DISCUSS_POSTS_TABLE." WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => intval($post_id)
          ));
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          $result = explode("|",$result[0]['thanks']);
          if (!empty($user_id)){
            return false;
          }
          else{
            $username = $this->get_user($user_id)['user_name'];
            $found = false;
            foreach($result as $thank){
              if ($thank == $username){
                $found = true;
                break;
              }
            }
            if ($found){
              return true;
            }
            else{
              $result[] = intval($user_id);
              $result = implode("|",$result);
              $query = "UPDATE ".DISCUSS_POSTS_TABLE." SET thanks = :result WHERE post_id = :id";
              $sth = $this->dbc->prepare($query);
              $result = $sth->execute(array(
                ':result' => $result,
                ':id' => intval($post_id)
              ));
              return $result;
            }
          }
        }
        else if ($mode == 3){
          $query = "SELECT thanks FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => intval($post_id)
          ));
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
          $result = explode("|",$result[0]['thanks']);
          if (!empty($user_id)){
            return false;
          }
          else{
            $username = $this->get_user($user_id)['user_name'];
            $found = false;
            foreach($result as $thank){
              if ($thank == $username){
                $found = true;
                break;
              }
            }
            if ($found){
              return true;
            }
            else{
              $result[] = intval($user_id);
              $result = implode("|",$result);
              $query = "UPDATE ".DISCUSS_POSTS_SPECIAL_TABLE." SET thanks = :result WHERE post_id = :id";
              $sth = $this->dbc->prepare($query);
              $result = $sth->execute(array(
                ':result' => $result,
                ':id' => intval($post_id)
              ));
              return $result;
            }
          }
        }
        else{
          return false;
        }
      }
    }
  }

$discuss = new discuss($dbc);
?>
