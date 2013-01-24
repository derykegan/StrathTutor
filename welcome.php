<?php
	// import session and header
	include_once 'header.php';
	include_once 'libraries/sql.php';
	
	// print header
	echo(getHeader() . "\n");
	// retreive splash page content from db
	echo(getPageContent("splash"));
	
?>
