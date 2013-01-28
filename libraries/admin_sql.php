<?php
	// Class to deal with MySQL interaction for admin pages.
	
	include_once 'sql.php';
	
	// returns site settings as an associative array
	function getSiteSettings(){
		$query = 'SELECT * FROM Settings';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	

?>