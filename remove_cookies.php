<?php

	// class to remove all cookies
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	
	// set EU privacy cookie to be removed
	setcookie("EUconsent", false, time() - 9999);
	
	// unset session
	$_SESSION['loggedIn'] = false;
	$_SESSION['userType'] = "";
	$_SESSION = array();
	
	$printme = "<h1>Cookies removed!</h1>
	<h2>Nom nom nom</h2>
	<p>All cookies have been removed, you may now close this browser
	tab or window.</p>";
		
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFNoCookiesPage($printme);
	
	// print page to screen
	echo($page->getPage());

?>
