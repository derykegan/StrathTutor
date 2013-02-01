<?php
	// imports
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	
	// get this page's content from the db
	$content = getPageContent("about");
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($content);
	
	// print page to screen
	echo($page->getPage());

	
?>
