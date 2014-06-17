<?php
/*
* Theme DB Version 1.0 
* Methods
*/
class themedb{
	
	// Modifying/inserting methods

	function approve_theme(){
	}
	
	function submit_theme(){
	}

	// Getting methods

	function get_themes($id = 'all'){
		if($id == 'all'){
			// Select all approved themes but unvalidated
			$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 0";
			$result = mysql_query($query);
			$num = mysql_num_rows($result);

			$id 					= array();
			$name 				= array();
			$description 	= array();
			$stage 				= array();
			$author 			= array();
			$version 			= array();
			$submit_id 		= array();
			$owner_id 		= array();
			$i = 0;
			// Assign themes to array
			while ($i < $num) {
				$id[] 					= mysql_result($result,$i,"id");
				$name[] 				= mysql_result($result,$i,"name");
				$description[] 	= mysql_result($result,$i,"description");
				$stage[] 				= mysql_result($result,$i,"stage");
				$author[] 			= mysql_result($result,$i,"author");
				$version[] 			= mysql_result($result,$i,"version");
				$submit_id[] 		= mysql_result($result,$i,"submited_by_id");
				$owner_id[] 		= mysql_result($result,$i,"owner_id");
				$i++;
			}			
			$unvalidated = array(
					'count'				=> $i,
					'id' 					=> $id,
					'name' 				=> $name,
					'description' => $description,
					'stage' 			=> $stage,
					'author' 			=> $author,
					'version' 		=> $version,
					'submit_id' 	=> $submit_id,
					'owner_id' 		=> $owner_id 				
			);
			
			// Select all approved themes and validated
			$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 1";
			$result = mysql_query($query);
			$num = mysql_num_rows($result);

			$id 					= array();
			$name 				= array();
			$description 	= array();
			$stage 				= array();
			$author 			= array();
			$version 			= array();
			$submit_id 		= array();
			$owner_id 		= array();
			$i = 0;
			// Assign themes to array
<<<<<<< HEAD
			$name = array();
			$i=0;
=======
>>>>>>> database stuff
			while ($i < $num) {
				$id[] 					= mysql_result($result,$i,"id");
				$name[] 				= mysql_result($result,$i,"name");
				$description[] 	= mysql_result($result,$i,"description");
				$stage[] 				= mysql_result($result,$i,"stage");
				$author[] 			= mysql_result($result,$i,"author");
				$version[] 			= mysql_result($result,$i,"version");
				$submit_id[] 		= mysql_result($result,$i,"submited_by_id");
				$owner_id[] 		= mysql_result($result,$i,"owner_id");
				$i++;
<<<<<<< HEAD
			}

=======
			}			
			$validated = array(
					'count'				=> $i,
					'id' 					=> $id,
					'name' 				=> $name,
					'description' => $description,
					'stage' 			=> $stage,
					'author' 			=> $author,
					'version' 		=> $version,
					'submit_id' 	=> $submit_id,
					'owner_id' 		=> $owner_id 				
			);			
			
			$data = array(
				'unvalidated' => $unvalidated,
				'validated'		=> $validated
			);			
			
>>>>>>> database stuff
			return $data;
		}
		else{
		}
	}

}
$themedb = new themedb();
?>
