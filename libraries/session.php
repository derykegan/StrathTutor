<?php
	// Class to deal with browser sessions.
	
	// start session (if not already)
	session_start();
	
	// set timeout period (seconds)
	$timeout = 1200;
	
	// check if is already set
	if(isset($_SESSION['timeout']) ) {
		
		$session_time = time() - $_SESSION['timeout'];
		
		// if $timeout period has elapsed
		if($session_time > $timeout){
			// unset and destroy session
			$_SESSION = array();
			session_destroy(); 
			
			// redirect to index
			header("Location: index.php"); 
			}
	}
	
	$_SESSION['timeout'] = time();

?>
