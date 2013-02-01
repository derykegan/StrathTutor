<?php

	// class to remove all cookies
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	
	// set EU privacy cookie to be removed
	setcookie("EUconsent", false, time() - 9999);
	
	// unset session
	$_SESSION = array();
	
	$printme = "<!DOCTYPE html>\n<head>\n
		<link rel='stylesheet' type='text/css' href='../default.css'>\n
		<meta charset='UTF-8'>\n
		<meta name='viewport' content='width=device-width, initial-scale=1'></head>\n";
	$printme = $printme . ("<body>All cookies have been removed, you may now close this browser
	tab or window.</body>");
		
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFNoCookiesPage($printme);
	
	// print page to screen
	echo($page->getPage());

?>
