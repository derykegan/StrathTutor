<?php
	// import session and header
	include_once 'header.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// print header
	echo(getHeader() . "\n");
	
	
	
	
?>
