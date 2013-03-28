<?php
	/*  Library to deal with MySQL interaction for admin pages.
		Leverages the SQL core library (sql.php)
	
		*/
	
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
	
	// returns event log as an associative array
	function getAdminLog(){
		$query = 'SELECT * FROM EventLog
				ORDER BY event_datetime DESC';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the pages editable by admins
	function getSitePages(){
		$query = 'SELECT * FROM PageContent';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the subjects editable by admins
	function getSubjects(){
		$query = 'SELECT * FROM Subject';
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}
	
	// returns the user list
	function getUserList(){
		$query = 'SELECT * FROM User';
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
