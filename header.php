<?php
	// import session and sql
	include_once 'libraries/session.php';
	include_once 'libraries/sql.php';

	// method to return header when called.
	function getHeader(){
		$header = "Log in | About";
		// function will return header
		return $header;
	}

?>
