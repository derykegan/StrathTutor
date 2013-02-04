<?php
	// Class to deal with MySQL interaction.
	
	// mysql settings
	$db_username = "rmb09188";
	$db_password = "ersterys";
	$db_hostname = "devweb2012.cis.strath.ac.uk";
	$db_name = "rmb09188";

	// connect to database server
	$db = mysqli_connect($db_hostname, $db_username, $db_password, $db_name)
    		or die('Connection error: ' . mysqli_error($db));

	// connected.
	
	// user authentication
	function login($username, $password){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($db, $username);
		// hash password using SHA-512
		$Spassword = hash("sha512", $password); 
			
		// query db using escaped username and hashed password
		$query = "SELECT * FROM User WHERE User.username = '$Susername' AND User.password = '$Spassword'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		
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
	
	// get first name of user
	function getUserFirstName($username){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($db, $username);
		
		$query = "SELECT firstname FROM User WHERE User.username = '$Susername'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}
	
	// get last name of user
	function getUserLastName($username){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($db, $username);
		
		$query = "SELECT lastname FROM User WHERE User.username = '$Susername'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}
	
	// get user type for given username
	function getUserType($username){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($db, $username);
		
		$query = "SELECT userType FROM User WHERE User.username = '$Susername'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}
	
	// create a new user if they do not exist already
	function createUser($username, $password, $userType, $email, $firstname, $lastname){
		global $db;
		
		// use escape string to avoid injection attacks
		$Susername = mysqli_real_escape_string($db, $username);
		// hash password using SHA-512
		$Spassword = hash("sha512", $password); 
		
		$query = "INSERT INTO User (username, password, userType, email, firstname, lastname) 
			VALUES ($Susername, $Spassword, $userType, $email, $firstname, $lastname)";
		
		// proceed if user doesn't already exist
		if(!userExists($username)){
			$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
			return true;
		}
		
		// user exists, so do nothing
		else{
			return false;
		}
		
	}
	
	// checks if username exists in db
	function userExists($username){
		global $db;
		
		// query db using username
		$query = "SELECT * FROM User WHERE User.username = '$Susername'";
     
        // Execute query
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		
		$num_rows = mysqli_num_rows($result);
		// if we have only one row returned, user exists
		if($num_rows == 1){
			return true;
			}
			
		// else does not exist
		else{
			return false;
			}
		
	}
	
	// accessor method to perform SQL query.
	function doQuery($query){
		global $db;
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		return $result;
	}
	
	// return page content for given page name
	function getPageContent($pageName){
		global $db;
		$query = "SELECT Page_content FROM PageContent WHERE PageContent.Page_title = '$pageName'";
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		$row = mysqli_fetch_assoc($result);
		$toReturn = $row['Page_content'];
		return $toReturn;
	}
	
	// method to read from site settings
	function getSetting($setting){
		global $db;
		$query = "SELECT value FROM Settings WHERE Settings.key = '$setting'";
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}
	
	// method to return true if this student is its own parent, else false
	function isOwnParent($user){
		global $db;
		$query = "SELECT UserStudent.isOwnParent FROM User, UserStudent 
			WHERE (User.user_id = UserStudent.user_id AND User.username = '$user')";
		$result = mysqli_query($db, $query) or die ("Error in query: $query. ".mysqli_error($db));
		$row = mysqli_fetch_row($result);
		$toReturn = $row[0];
		return $toReturn;
	}

?>
