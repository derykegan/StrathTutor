<?php
	// imports
	include_once 'libraries/sql.php';
	include_once 'classes/pageFactory.php';
	
	// retreive splash page content from db
	$content = getPageContent("splash");
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($content);
	
	// print page to screen
	echo($page->getPage());

	
?>
