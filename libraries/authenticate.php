<?php
	include_once "../header.php";
	include_once "sql.php";
	include_once "session.php";
	
	// get username and password from POST
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// TODO - save wanted page in session and then restore on login
	
	// save login state
	$loggedIn = login($username, $password);
	
	// if logged in, redirect to index
	if($loggedIn){
		$_SESSION['loggedIn'] = true;
		
		// check user Type and set
		$type = getUserType($username);
		$firstName = getUserFirstName($username);
		$_SESSION['firstName'] = $firstName;
		$_SESSION['userType'] = $type;
		
		header("Location: ../index.php");
	}
	
	// not logged in, redirect to login page
	else{
		
		// set session flag to indicate incorrect login, then redirect
		$_SESSION['invalidLogin'] = true;
		
		header("Location: ../login.php");
	}

?>
