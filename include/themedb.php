<?php
/*
* Theme DB Version 1.0
* Methods
*/
class themedb {

	function __construct($dbc){
		$this->dbc = $dbc;
	}

  // Modifying/inserting methods

  function approve_theme(){
  }

	/*
	* edit_settings($data)
	* Desc: Edits a theme setting
	* $data: The data from the form
	*/
	function edit_settings($data){
		if($data['request'] == 1){
			$query = "UPDATE `" . THEMEDB_TABLE . "` SET `validate_request` = 1 WHERE `id` = :id";
			$sth = $this->dbc->prepare($query);
			
			$sth->execute(array(
				':id' => $data['id']
			));
		}
		if($data['user_id'] != NULL){
			$query = "UPDATE `" . THEMEDB_TABLE . "` SET `owner_id` = :owner WHERE `id` = :id";
			$sth = $this->dbc->prepare($query);
			
			$sth->execute(array(
				':owner' => $data['user_id'],
				':id' => $data['id']
			));
		}
		
		return $data['id'];
	}

	/*
	* edit_theme($data)
	* Desc: Edits a theme in the database
	* $data: The data from the form
	*/
	function edit_theme($data){
		$query = "UPDATE `" . THEMEDB_TABLE . "` SET `name` = :name, `description` = :description, `code` = :code, `stage` = :stage, `author` = :author, `screenshot` = :screenshot, `version` = :version WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		
		$sth->execute(array(
			':name'							=> $data['name'],
			':description'			=> $data['description'],
			':code'							=> $data['code'],
			':stage'						=> $data['stage'],
			':author'						=> $data['author'],
			':screenshot'				=> $data['screenshot'],
			':version'					=> $data['version'],
			':id'								=> $data['id']
		));

		return $data['id'];
	}

	/*
	* submit_theme($data)
	* Desc: Submits a theme to the database
	* $data: The data from the form
	*/
  function submit_theme($data){
		$query = "INSERT INTO `" . THEMEDB_TABLE . "` (`id`, `approved`, `validated`, `validate_request`, `name`, `description`, `code`, `stage`, `author`, `screenshot`, `version`, `submitted_by`, `submitted_by_id`, `owner`, `owner_id`) VALUES (NULL, 0, 0, 0, :name, :description, :code, :stage, :author, :screenshot, :version, :submitted_by, :submitted_by_id, NULL, NULL)";
		$sth = $this->dbc->prepare($query);
		
		$sth->execute(array(
			':name'							=> $data['name'],
			':description'			=> $data['description'],
			':code'							=> $data['code'],
			':stage'						=> $data['stage'],
			':author'						=> $data['author'],
			':screenshot'				=> $data['screenshot'],
			':version'					=> $data['version'],
			':submitted_by'			=> $data['submitted_by'],
			':submitted_by_id'	=> $data['submitted_by_id']
		));
		
		$id = $this->dbc->lastInsertId();
		return $id;
  }

  // Getting methods

	/*
	* check_owner($id, $user_id)
	* Desc: checks if a user is an owner for a style id
	*/
	function check_owner($id, $user_id){
		$query = "SELECT `submitted_by_id`, `owner_id` FROM " . THEMEDB_TABLE . " WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		
		$sth->execute(array(
			':id'	=> $id
		));
		
		$data = $sth->fetch(PDO::FETCH_ASSOC);
		if($data['owner_id'] == NULL){
			if($data['submitted_by_id'] == $user_id){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			if($data['owner_id'] == $user_id){
				return true;
			}
			else{
				return false;
			}
		}
	}

	/*
	* get_themes($id)
	* Desc: Gets either a list of all the themes sorted by validated/unvalidated or one theme
	* $id: Either nothing to get all themes or an id number
	*/
  function get_themes($id = 'all', $user_id = 0, $moderator = 0){
		if($id == 'all') {
      // Select all approved themes but unvalidated
      $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 0";

      // Assign themes to array
      $id          = array();
      $name        = array();
      $description = array();
      $stage       = array();
      $author      = array();
      $version     = array();
      $submit_id   = array();
      $owner_id    = array();
			
			foreach($this->dbc->query($query) as $row) {
        $id[]          = $row["id"];
        $name[]        = $row["name"];
        $description[] = $row["description"];
        $stage[]       = $row["stage"];
        $author[]      = $row["author"];
        $version[]     = $row["version"];
        $submit_id[]   = $row["submited_by_id"];
        $owner_id[]    = $row["owner_id"];
			}

      $unvalidated = array(
          'id'          => $id,
          'name'        => $name,
          'description' => $description,
          'stage'       => $stage,
          'author'      => $author,
          'version'     => $version,
          'submit_id'   => $submit_id,
          'owner_id'    => $owner_id
      );
			

      // Select all approved themes and validated
      $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 1";

      // Assign themes to array
      $id          = array();
      $name        = array();
      $description = array();
      $stage       = array();
      $author      = array();
      $version     = array();
      $submit_id   = array();
      $owner_id    = array();
			
			foreach($this->dbc->query($query) as $row) {
        $id[]          = $row["id"];
        $name[]        = $row["name"];
        $description[] = $row["description"];
        $stage[]       = $row["stage"];
        $author[]      = $row["author"];
        $version[]     = $row["version"];
        $submit_id[]   = $row["submited_by_id"];
        $owner_id[]    = $row["owner_id"];
			}
			
      $validated = array(
          'id'          => $id,
          'name'        => $name,
          'description' => $description,
          'stage'       => $stage,
          'author'      => $author,
          'version'     => $version,
          'submit_id'   => $submit_id,
          'owner_id'    => $owner_id
      );

      $data = array(
        'unvalidated' => $unvalidated,
        'validated'   => $validated
      );
			
      return $data;
    }
    else {
			$query = "SELECT `owner_id` FROM `" . THEMEDB_TABLE . "` WHERE `id` = :id";
			$sth = $this->dbc->prepare($query);
			$sth->execute(array(':id' => $id));
			$owner = $sth->fetchColumn();
			
			if($moderator == 0){
				if($owner == NULL){			
					$query = "SELECT * FROM `" . THEMEDB_TABLE . "` WHERE `id` = :id AND (`approved` = 1 OR `submitted_by_id` = :user_id)";
					$sth = $this->dbc->prepare($query);
					$sth->execute(array(':id' => $id, ':user_id' => $user_id));
					$result = $sth->fetch(PDO::FETCH_ASSOC);
				}
				else{			
					$query = "SELECT * FROM `" . THEMEDB_TABLE . "` WHERE `id` = :id AND (`approved` = 1 OR `owner_id` = :user_id)";
					$sth = $this->dbc->prepare($query);
					$sth->execute(array(':id' => $id, ':user_id' => $user_id));
					$result = $sth->fetch(PDO::FETCH_ASSOC);
				}
			}
			else{
				$query = "SELECT * FROM `" . THEMEDB_TABLE . "` WHERE `id` = :id";
				$sth = $this->dbc->prepare($query);
				$sth->execute(array(':id' => $id));
				$result = $sth->fetch(PDO::FETCH_ASSOC);			
			}
			
			return $result;
		}
  }
	
	/*
	* get_mcp_styles()
	* Desc: get themes for the mcp to display
	*/
	function get_mcp_styles(){
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 0";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['unapproved'] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `validate_request` = 1 AND `validated` = 0";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['validate_request'] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	/*
	* get_own_themes($user_id)
	* Desc: get own themes for the request view
	*/
	function get_own_themes($user_id){
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 0 AND ((`owner_id` IS NULL AND `submitted_by_id` = :user_id) OR (`owner_id` = :user_id))";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['unapproved'] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validate_request` = 0 AND `validated` = 0 AND ((`owner_id` IS NULL AND `submitted_by_id` = :user_id) OR (`owner_id` = :user_id))";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['approved'] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validate_request` = 1 AND `validated` = 0 AND ((`owner_id` IS NULL AND `submitted_by_id` = :user_id) OR (`owner_id` = :user_id))";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['validate_request'] = $sth->fetchAll(PDO::FETCH_ASSOC); 
		
		$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `validated` = 1 AND ((`owner_id` IS NULL AND `submitted_by_id` = :user_id) OR (`owner_id` = :user_id))";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			'user_id' => $user_id
		));
		
		$result['validated'] = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
	
	/*
	* get_popup_users()
	* Desc: Gets users for the popup
	*/
	function get_popup_users(){
		$query = "SELECT `id`, `user_name` FROM " . USERS_TABLE;
		$sth = $this->dbc->prepare($query);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}
}
$themedb = new themedb($dbc);
?>
