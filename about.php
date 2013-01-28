<?php
	// import session and header
	include_once 'header.php';
	include_once 'libraries/sql.php';
	include_once 'footer.php';
	
	// print header
	echo(getHeader() . "\n");
	// retreive about page content from db
	echo(getPageContent("about"));
	
	// print footer
	echo(getFooter());

	
?>
