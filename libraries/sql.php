<?php
	// Class to deal with MySQL interaction.
	
	// mysql settings
	$db_username = "rmb09188";
	$db_password = "ersterys";
	$db_hostname = "devweb2012.cis.strath.ac.uk";
	$db_name = "rmb09188";

	// connect to database server
	$db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name)
    		or die('Connection error: ' . mysqli_error());

	// connected.
	
	// user authentication
	function login($username, $password){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($username);
			
		// basic query - to be changed to use hashing
		$query = "SELECT * FROM user WHERE user.username = '$Susername' AND user.password = '$password'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error());
		
		$num_rows = mysqli_num_rows($result);
		
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
		global $db;
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error());
		return $result;
	}
	
	// return page content for given page name
	function getPageContent($pageName){
		global $db;
		$query = "SELECT Page_content FROM PageContent WHERE PageContent.Page_title = '$pageName'";
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error());
		$row = mysqli_fetch_assoc($result);
		$toReturn = $row['Page_content'];
		return $toReturn;
	}
	
	// method to read from site settings
	function getSetting($setting){
		global $db;
		$query = "SELECT value FROM Settings WHERE Settings.key = '$setting'";
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error());
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}

?>
