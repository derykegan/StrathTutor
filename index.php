<?php
	/*
		Index page - redirects as needed.
		If logged in, directs to user panel.
		Else, directs to login page.
	
		*/
	
	// check session
	include 'libraries/session.php';
	
	$redir = "welcome.php";
	
	// Check if the user is logged in, then check user type
	if (isset($_SESSION['loggedIn'])) {
		
		if($_SESSION['loggedIn']){
			  $redir = "userPanel.php";
		  }
		
	} 
	 
	// else user is not logged in, redirect to welcome page
	else{
		$redir = "welcome.php";
		}
		
	// redirect accordingly
	header ("Location: $redir");

?>
