<?php

	include_once 'libraries/session.php';
	
	//unset session
	$_SESSION = array();
	
	// destroy current session to force logout
	session_destroy();
	
	// redirect to index
	header("Location: index.php");


?>
