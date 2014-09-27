<?php
/*
* Discuss Version 1.0
* Methods
*/

class discuss {

  function __construct($dbc){
    $this->dbc = $dbc;
  }

  function get_fora($forum_id = 'all', $parent_id = 0, $user_id = 0){
    if ($forum_id != 'all') {
      $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE `id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $forum_id
      ));

      $result = $sth->fetch(PDO::FETCH_ASSOC);

      return $result;
    } elseif ($parent_id != 0) {
      $query = "SELECT * FROM " . DISCUSS_FORUM_TABLE . " WHERE `parent` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $forum_id
      ));

      $result = $sth->fetchAll(PDO::FETCH_ASSOC);

      return $result;
    } else {
      $query = "SELECT * FROM `" . DISCUSS_FORUM_TABLE . "`";
      $sth = $this->dbc->prepare($query);
      $sth->execute();

      $result = $sth->fetchAll(PDO::FETCH_ASSOC);

      for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]['id'] == 1) {
          $query = "SELECT `id` FROM `" . THEMEDB_TABLE . "`";
          $sth = $this->dbc->prepare($query);
          $sth->execute();

          $topics = $sth->fetchAll(PDO::FETCH_ASSOC);
          $total = count($topics);

          $read_count = 0;
          foreach ($topics as $topic) {
            $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :topic AND `user_id` = :user";
            $sth = $this->dbc->prepare($query);
            $sth->execute(array(
              ':topic' => $topic['id'],
              ':user' => $user_id
            ));

            $count = $sth->fetchColumn();

            if ($count > 0) {
              $read_count++;
            }
          }

          if ($user_id == 0) {
            $read_count = $total;
          }

          if ($total > $read_count) {
            $result[$i]['read'] = 0;
          } else {
            $result[$i]['read'] = 1;
          }
        } else {
          $query = "SELECT `topic_id` FROM `" . DISCUSS_TOPIC_TABLE . "` WHERE `forum_id` = :id";
          $sth = $this->dbc->prepare($query);
          $sth->execute(array(
            ':id' => $result[$i]['id']
          ));

          $topics = $sth->fetchAll(PDO::FETCH_ASSOC);
          $total = count($topics);

          $read_count = 0;
          foreach ($topics as $topic) {
            $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `user_id` = :user AND `topic_id` = :topic";
            $sth = $this->dbc->prepare($query);
            $sth->execute(array(
              ':user' => $user_id,
              ':topic' => $topic['topic_id']
            ));

            $count = $sth->fetchColumn();

            if ($count > 0) {
              $read_count++;
            }
          }

          if ($user_id == 0) {
            $read_count = $total;
          }

          if ($total > $read_count) {
            $result[$i]['read'] = 0;
          } else {
            $result[$i]['read'] = 1;
          }
        }
      }

      return $result;
    }
  }

  // get count of all posts in topic
  function get_comment_count($topic_id, $type) {
    if ($type == 0) {
      $query = "SELECT COUNT(*) FROM `" . DISCUSS_POSTS_SPECIAL_TABLE . "` WHERE `style_id` = :topic_id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':topic_id' => $topic_id
      ));

      $count = $sth->fetchColumn();
    } else {
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
  function get_views($id, $type) {
    if ($type == 0) {
      $query = "SELECT `user_id` FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id";
    } else {
      $query = "SELECT `user_id` FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `topic_id` = :id";
    }
    $sth = $this->dbc->prepare($query);
    $sth->execute(array(
      ':id' => $id
    ));
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    $view_array = array();
    foreach ($result as $user) {
      if (in_array($user, $view_array)) {
        continue;
      } else {
        $view_array[] = $user;
        continue;
      }
    }

    return count($view_array);
  }

  function delete_views($id, $user, $type) {
    if ($type == 0) {
      $query = "DELETE FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `user_id` <> :user_id AND `style_id` = :id";
    } else {
      $query = "DELETE FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `user_id` <> :user_id AND `topic_id` = :id";
    }
    $sth = $this->dbc->prepare($query);
    $sth->execute(array(
      ':user_id' => $user,
      ':id' => $id
    ));
  }

  function view_topic($id, $type, $user_id) {
    if (empty($user_id)) {
      return false;
    }

    if($type == 0) {
      $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `user_id` = :user_id AND `style_id` = :style";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':user_id' => $user_id,
        ':style' => $id
      ));

      $count = $sth->fetchColumn();

      $query = "INSERT INTO `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` (`user_id`, `style_id`, `timestamp`) VALUES (:user, :id, :time);";
    } else {
      $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `user_id` = :user_id AND `topic_id` = :topic";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':user_id' => $user_id,
        ':topic' => $id
      ));

      $count = $sth->fetchColumn();

      $query = "INSERT INTO `" . DISCUSS_TOPICS_TRACK_TABLE . "` (`user_id`, `topic_id`, `timestamp`) VALUES (:user, :id, :time);";
    }

    if ($count == 0) {
      $sth = $this->dbc->prepare($query);
      $result = $sth->execute(array(
        ':id' => intval($id),
        ':user' => intval($user_id),
        ':time' => intval(time())
      ));
    } else {
      $result = false;
    }

    return $result;
  }

  // mark all read
  function mark_all_read($id, $user_id) {
    $topics = $this->get_topics($id, $user_id);

    $forum = $this->get_fora($id);
    $type = $forum['type'];

    foreach($topics as $topic) {
      $this->view_topic($topic['topic_id'], $type, $user_id);
    }

    return;
  }

  // get topics for view page
  function get_topics($id, $user_id) {
    // make sure the type is not special
    $query = "SELECT `type` FROM " . DISCUSS_FORUM_TABLE . " WHERE `id` = :id";
    $sth = $this->dbc->prepare($query);
    $sth->execute(array(
      ':id' => $id
    ));

    $type = $sth->fetch(PDO::FETCH_ASSOC);
    $type = $type['type'];

    // special fora
    if ($type == 0 && $id == 1) {
      $query = "SELECT `id` AS `topic_id`, `submitted_by_id` AS `user_id`, `name` AS `title`, `timestamp` AS `time` FROM `" . THEMEDB_TABLE . "`";
      $sth = $this->dbc->prepare($query);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);

      for ($i = 0; $i < count($result); $i++) {
        // check if user viewed
        $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_SPECIAL_TABLE . "` WHERE `style_id` = :id AND `user_id` = :user_id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id'       => $result[$i]['topic_id'],
          ':user_id'  => $user_id
        ));
        $count = $sth->fetchColumn();
        if ($count == 0) {
          $result[$i]['read'] = 0;
        } else {
          $result[$i]['read'] = 1;
        }

        // find views
        $result[$i]['views'] = $this->get_views($result[$i]['topic_id'], $type);

        // find comment count
        $result[$i]['comment_count'] = $this->get_comment_count($result[$i]['topic_id'], $type);
      }

      return $result;

    } else {
      $query = "SELECT * FROM `" . DISCUSS_TOPIC_TABLE . "` WHERE `forum_id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $id
      ));
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);

      for ($i = 0; $i < count($result); $i++) {
        // check if user viewed
        $query = "SELECT COUNT(*) FROM `" . DISCUSS_TOPICS_TRACK_TABLE . "` WHERE `topic_id` = :id AND `user_id` = :user_id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id'       => $result[$i]['topic_id'],
          ':user_id'  => $user_id
        ));
        $count = $sth->fetchColumn();
        if($count == 0) {
          $result[$i]['read'] = 0;
        } else {
          $result[$i]['read'] = 1;
        }

        // find views
        $result[$i]['views'] = $this->get_views($result[$i]['topic_id'], $type);

        // find comment count
        $result[$i]['comment_count'] = $this->get_comment_count($result[$i]['topic_id'], $type);
      }

      return $result;
    }
  }
  //get specific topic
  function get_topic($topic_id, $type = 0) {
    if ($type == 1) {
      //get style alone
      $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $topic_id
      ));
      $style = $sth->fetch(PDO::FETCH_ASSOC);

      //export result
      $result = array(
        'forum_id' => 1,
        'user_id' => intval($style['submitted_by_id']),
        'title' => $style['name'],
        'time' => $style['timestamp'],
        'edit_id' => $style['edit_id'],
        'last_time' => $style['last_timestamp'],
        'text' => $style['description'],
        'topic_id' => intval($topic_id)
      );

      return $result;
    } else {
      $query = "SELECT * FROM `" . DISCUSS_POSTS_TABLE . "` WHERE `topic_id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $topic_id
      ));

      $result = $sth->fetch(PDO::FETCH_ASSOC);

      $query = "SELECT `forum_id` FROM `" . DISCUSS_TOPIC_TABLE . "` WHERE `topic_id` = :id";
      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => $topic_id
      ));

      $forum = $sth->fetch(PDO::FETCH_ASSOC);

      $result['forum_id'] = $forum['forum_id'];

      return $result;
    }
  }

  // insert post
  function insert_post($forum, $user_id, $data) {
    if ($forum == 1) {
      $query = "INSERT INTO ".DISCUSS_POSTS_SPECIAL_TABLE." (user_id, style_id, time, title, text) VALUES (:user, :topic, :time, :title, :text)";
    } else {
      $query = "INSERT INTO ".DISCUSS_POSTS_TABLE." (user_id, topic_id, time, title, text, source) VALUES (:user, :topic, :time, :title, :text, :source)";
    }

    $error = array();
    if (strlen(trim($data['title'])) < 5) {
      $error[] = 'Your title needs to have at least 5 characters (excluding spaces)!';
    }
    if (strlen(trim($data['desc'])) < 5) {
      $error[] = 'Your message needs to have at least 10 characters (excluding spaces)!';
    }

    if (empty($error)) {
      $sth = $this->dbc->prepare($query);
      $result = $sth->execute(array(
        ':user' => intval($user_id),
        ':topic' => intval($data['t']),
        ':time' => time(),
        ':title' => htmlspecialchars($data['title']),
        ':text' => $this->filter_swear_words($data['desc']),
        ':source' => $this->filter_swear_words($data['desc-source'])
      ));
      $this->delete_views($data['t'], $user_id, 0);
    }

    unset($result);
    $result = array(
      'f' => $forum,
      't' => $data['t'],
      'err' => $error
    );

    return $result;
  }

  // insert topic
  function insert_topic($forum, $user_id, $data) {
    if (strlen(trim($data['title'])) < 5) {
      $error[] = 'Your title needs to have at least 5 characters (excluding spaces)!';
    }
    if (strlen(trim($data['desc'])) < 5) {
      $error[] = 'Your message needs to have at least 10 characters (excluding spaces)!';
    }

    if (empty($error)) {
      $query = "INSERT INTO `" . DISCUSS_TOPIC_TABLE . "` (`topic_id`, `forum_id`, `user_id`, `title`, `time`) VALUES (NULL, :forum, :user, :title, :time) ";

      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':forum' => $forum,
        ':user' => $user_id,
        ':title' => htmlspecialchars($data['title']) ,
        ':time' => time()
      ));

      $topic_id = $this->dbc->lastInsertId();

      $query = "INSERT INTO `" . DISCUSS_POSTS_TABLE . "` (user_id, topic_id, time, title, text, source) VALUES (:user, :topic, :time, :title, :text, :source)";
      $sth = $this->dbc->prepare($query);

      $result = $sth->execute(array(
        ':user' => intval($user_id),
        ':topic' => intval($topic_id),
        ':time' => time(),
        ':title' => htmlspecialchars($data['title']),
        ':text' => $this->filter_swear_words($data['desc']),
        ':source' => $this->filter_swear_words($data['desc-source'])
      ));
    }

    $result = array(
      'f' => $forum,
      't' => $topic_id,
      'err' => $error
    );

    return $result;
  }

  //get posts from topic with id ($topic_id) [optional: also gets posts from user with id ($user_id)]
  function get_posts($topic_id = 'all', $user_id = 'all', $type = 0) {
    if ($topic_id != 'all') {
      if ($type == 1) {    //special table
        $query = "SELECT * FROM " . DISCUSS_POSTS_SPECIAL_TABLE . " WHERE style_id = :id";
      } else {
        $query = "SELECT * FROM " . DISCUSS_POSTS_TABLE . " WHERE topic_id = :id";
      }
    } else {
      $query = "SELECT * FROM " . DISCUSS_POSTS_TABLE . ", " . DISCUSS_POSTS_SPECIAL_TABLE;
    }

    if ($user_id != 'all') {

      if ($topic_id != 'all') {
        $query = $query." AND user_id = :user";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($topic_id),
          ':user' => intval($user_id)
        ));
      } else {
        $query = $query." WHERE user_id = :user";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':user' => intval($user_id)
        ));
      }

      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;

    } else {

      $sth = $this->dbc->prepare($query);
      $sth->execute(array(
        ':id' => intval($topic_id)
      ));
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);

      if ($type != 1) {
        unset($result[0]);
      }
      return $result;

    }
  }
  function parse_code($string) {
    // $search = array('\n', '\\n');
    // $replace = array('<br/>', '<br/>');
    return htmlspecialchars($string);
  }

  //0 - get thanks from regular, 1 - get thanks from special, 2 - thank regular, 3 - thank special
  function thanks($post_id, $mode = 0, $user_id = null) {
    if (empty($post_id)) {
      return false;
    } else {

      if ($mode == 0) {

        $query = "SELECT thanks FROM ".DISCUSS_POSTS_TABLE." WHERE post_id = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($post_id)
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $result = explode("|", trim($result[0]['thanks']));
        if (empty($result[0])){
          return array();
        } else {
          return $result;
        }

      } elseif ($mode == 1) {

        $query = "SELECT thanks FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($post_id)
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        $result = explode("|", trim($result[0]['thanks']));
        if (empty($result[0])) {
          return array();
        } else {
          return $result;
        }

      } elseif ($mode == 2) {
        $query = "SELECT thanks FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($post_id)
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result[0]['thanks'])) {
          $result = array();
        } else {
          $result = explode("|", $result[0]['thanks']);
        }

        if (empty($user_id)) {
          return false;
        } else {

          $found = false;
          foreach ($result as $key => $thank) {
            if ($thank == $user_id) {
              $found = true;
              unset($result[$key]);
              array_values($result);
              break;
            }
          }

          if (!$found) {
            $result[] = intval($user_id);
          }
          $finalstring = implode("|", $result);
          $query = "UPDATE ".DISCUSS_POSTS_TABLE." SET thanks = :result WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $bresult = $sth->execute(array(
            ':result' => $finalstring,
            ':id' => intval($post_id)
          ));
          return count($result);

        }

      } elseif ($mode == 3) {

        $query = "SELECT thanks FROM ".DISCUSS_POSTS_SPECIAL_TABLE." WHERE post_id = :id";
        $sth = $this->dbc->prepare($query);
        $sth->execute(array(
          ':id' => intval($post_id)
        ));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result[0]['thanks'])) {
          $result = array();
        } else {
          $result = explode("|", $result[0]['thanks']);
        }
        if (empty($user_id)) {
          return false;
        } else {
          $found = false;
          foreach($result as $key => $thank) {
            if ($thank == $user_id) {
              $found = true;
              unset($result[$key]);
              array_values($result);
              break;
            }
          }
          if (!$found) {
            $result[] = intval($user_id);
          }
          $finalstring = implode("|", $result);
          $query = "UPDATE ".DISCUSS_POSTS_SPECIAL_TABLE." SET thanks = :result WHERE post_id = :id";
          $sth = $this->dbc->prepare($query);
          $bresult = $sth->execute(array(
            ':result' => $finalstring,
            ':id' => intval($post_id)
          ));
          return count($result);
        }
      } else {
        return false;
      }
    }
  }

  // filter swear words
  function filter_swear_words($contaminated) {
    $swears = array(
      "freaking" => "ZnVja2luZw==", // f******
      "screw"    => "ZnVjaw==",     // f***
      "shodd"    => "c2hpdHQ=",     // plural form of below
      "shod"     => "c2hpdA==",     // s***
      "bastard"  => "Yml0Y2g=",     // b****
      "****"     => "Y3VudA==",     // c***, too offensive to replace
      "butt"     => "YXNz",         // a**
      "darn"     => "ZGFtbg=="      // d***
    );
    $cleaned = ' ' . $contaminated . ' ';

    foreach ($swears as $minced => $swear) {
      $regex_prefix = "/([\s\.;\-\'\"\(])" . base64_decode($swear) . "([\s\.;\-\'\"\)])/";
      $cleaned = preg_replace($regex_prefix, '$1' . $minced . '$2', $cleaned);
    }

    return $cleaned;
  }

}

$discuss = new discuss($dbc);
?>
