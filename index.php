<?php
	// PLACEHOLDER
	
	// check session
	include 'libraries/session.php';
	
	$redir = "";
	
	// Check if the user is logged in, then check type
	if (isset($_GET['loggedIn'])) {
		$userType = $_SESSION['userType'];
		
		//  admin
		if($userType == 'admin'){
			$redir = "adminPanel.php";
		}
		
		// tutor
		if($userType == 'tutor'){
			$redir = "tutorPanel.php";
		}
		
		// parent
		if($userType == 'parent'){
			$redir = "parentPanel.php";
		}
		
		// student
		if($userType == 'student'){
			$redir = "studentPanel.php";
		}
		
	} 
	 
	// else user is not logged in, redirect to welcome page
	else{
		$redir = "welcome.php";
		}
		
	// redirect accordingly
	header ("Location: $redir");

?>