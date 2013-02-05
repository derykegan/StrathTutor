<?php
	// PLACEHOLDER
	
	// check session
	include 'libraries/session.php';
	
	$redir = "welcome.php";
	
	// Check if the user is logged in, then check user type
	if (isset($_SESSION['loggedIn'])) {
		
		if($_SESSION['loggedIn']){
		  $userType = $_SESSION['userType'];
		  
		  // admin
		  if($userType == 'admin'){
			  $redir = "userPanel.php";
		  }
		  
		  // tutor
		  if($userType == 'tutor'){
			  $redir = "userPanel.php";
		  }
		  
		  // parent
		  if($userType == 'parent'){
			  $redir = "userPanel.php";
		  }
		  
		  // student
		  if($userType == 'student'){
			  $redir = "userPanel.php";
		  }
		}
		
	} 
	 
	// else user is not logged in, redirect to welcome page
	else{
		$redir = "welcome.php";
		}
		
	// redirect accordingly
	header ("Location: $redir");

?>
