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
			// Select all themes
			$query = "SELECT * FROM " . THEMEDB_TABLE;
			$result = mysql_query($query);

			$data = mysql_fetch_array($result, MYSQL_ASSOC);

			$num = mysql_num_rows($result);
			// Assign themes to array
			$name = array();
			$i=0;
			while ($i < $num) {
				$name[] = mysql_result($result,$i,"name");
				$i++;
			}

			return $data;
		}
		else{
		}
	}

}
$themedb = new themedb();
?>
