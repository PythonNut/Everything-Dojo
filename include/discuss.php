<?php
/*
* Discuss Version 1.0
* Methods
*/
class discuss {

  function __construct($dbc){
    $this->dbc = $dbc;
  }
	
	function get_fora(){
		$query = "SELECT * FROM " . DISCUSS_FORUM_TABLE;
		$sth = $this->dbc->prepare($query);
		$sth->execute();
		
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		return $result;
	}

	function get_topics($id){
		// make sure the type is not special
		$query = "SELECT `type` FROM " . DISCUSS_FORUM_TABLE . " WHERE `id` = :id";
		$sth = $this->dbc->prepare($query);
		$sth->execute(array(
			':id' => $id
		));
		
		
	}

}
$discuss = new discuss($dbc);
?>
