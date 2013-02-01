<?php
	// imports
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// heredoc for page content
$adminPage = <<<EOT
	
	<br />
	<div class = 'panelTitle'>Administration</div>
	<div class = 'panelText'>Please select an option below to begin configuration.</div>
	<br />
	<div class = 'panelContainer'>
	<a class = 'panelOption'href='admin_user.php' title='Add, edit or remove users.'>Users</a>
	<a class = 'panelOption'href='admin_subject.php' title='Add, edit or remove subjects.'>Subjects</a>
	<a class = 'panelOption'href='admin_pages.php' title='Edit page content, eg About or Welcome.'>Pages</a>
	<a class = 'panelOption'href='admin_site.php' title='Change options to personalise the site.'>Site Configuration</a>
	</div>
    
EOT;
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($adminPage);
	
	// print page to screen
	echo($page->getPage());
	
?>
