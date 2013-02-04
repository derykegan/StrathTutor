<?php
	include_once 'session.php';
	
	// class to perform user type validation for current user
	
	
	// returns true if valid, false if not
	function validateUserType($typeToValidate){
		$continue = false;
	
		// check if logged in, and what user type
		if(isset($_SESSION['loggedIn']) ) {
			if($_SESSION['loggedIn']){
				// check user is desired level
				if($_SESSION['userType'] == $typeToValidate){
					$continue = true;
				}
			}
		}
		
		return $continue;
		
	}
	
	// function to return the type of the currently logged in user
	function getLoggedInType(){
		$user = '';
		
		// check if logged in, and what user type
		if(isset($_SESSION['loggedIn']) ) {
			
			if($_SESSION['loggedIn']){
				
				$user = $_SESSION['userType'];
			}
		}
		// if error, return blank response
		return $user;
	}
		

?>
