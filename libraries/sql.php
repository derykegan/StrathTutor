<?php
	// Class to deal with MySQL interaction.
	
	include(config.php);

	// connect to database server
	$connect = mysql_connect($db_hostname, $db_username, $db_password)
    		or die('Connection error: ' . mysql_error());

	// and then supplied database
	mysql_select_db($db) or die('Could not select database' . mysql_error());

	// connected.
	
	// user authentication
	function login($username, $password){
		
		// use escape string to avoid injection attacks
		$Susername = mysql_real_escape_string($username);
			
		// basic query - to be changed to use hashing
		$query = "SELECT * FROM user WHERE user.username = '$Susername' AND user.password = '$password'";
     
        // Execute query
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		
		$num_rows = mysql_num_rows($result);
		
		// if we have only one row returned, login was successful
		if($num_rows == 1){
			return true;
			}
			
		// else was unsuccessful
		else{
			return false;
			}
	}
	
	// accessor method to perform SQL query.
	function doQuery($query){
		$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error());
		return $result;
	}

?>
