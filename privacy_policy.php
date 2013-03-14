<?php
	// imports
	include_once 'libraries/sql.php';
	include_once 'classes/pageFactory.php';
	
	// retreive privacy policy content from db
	$content = getPageContent("privacy_policy");
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($content);
	
	// print page to screen
	echo($page->getPage());

	
?>
