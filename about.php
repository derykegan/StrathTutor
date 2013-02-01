<?php
	// imports
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	
	$content = getPageContent("about");
	$pageFactory = new pageFactory();
	
	$page = $pageFactory->makeHFCookiesPage($content);
	echo($page->getPage());

	
?>
