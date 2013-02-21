<?php
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Lessons</h1>
	<h2>Select a lesson to edit.</h2>
	<br />
    
EOT;
	
	// now generate table
	$lessons = getLessonList();
	$headings = array("");
	$tableFactory = new tableFactory();
	$table = $tableFactory->makeTable($headings, $lessons);
	$sitePage = $sitePage . $table->getTable();
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>