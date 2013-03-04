<?php
	include_once "sql.php";
	include_once "session.php";
	include_once "event_add.php";
	
	// get username and password from POST
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// TODO - save wanted page in session and then restore on login
	
	// save login state
	$loggedIn = login($username, $password);
	
	// if logged in, redirect to index
	if($loggedIn){
		// regenerate session id for security
		session_regenerate_id();
		
		// set session flags accordingly
		$_SESSION['loggedIn'] = true;
		
		// check user Type and set
		$type = getUserType($username);
		$firstName = getUserFirstName($username);
		$lastName = getUserLastName($username);
		$id = getIdfromUsername($username);
		
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['username'] = $username;
		$_SESSION['userType'] = $type;
		$_SESSION['userID'] = $id;
		
		// set parent access flags
		if($type == 'parent'){
			$_SESSION['parentAccess'] = true;
		}
		if($type == 'student'){
			if(isOwnParent($username)){
				$_SESSION['parentAccess'] = true;
			}
		}
		
		// if admin, log event
		if($type == 'admin'){
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			$eventDetails = "Admin user " . $username . " logged in. User details: " . $useragent;
			addEvent('ADMIN_LOGIN', $eventDetails);
			
		}
		
		header("Location: ../index.php");
	}
	
	// not logged in, redirect to login page
	else{
		
		// set session flag to indicate incorrect login, then redirect
		$_SESSION['invalidLogin'] = true;
		
		// save to event log
		$ip = $_SERVER['REMOTE_ADDR'];
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		
		$eventDetails = "Invalid login attempt from " . $ip;
		if(!empty($username)){
			$eventDetails = $eventDetails . ". Username: " . $username;
		}
		$eventDetails = $eventDetails . ". User details: " . $useragent;
		addEvent('FAILED_LOGIN', $eventDetails);
		
		header("Location: ../login.php");
	}

?>
