<?php

	/*
		Lesson display - takes id from post
		
		*/
		
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/lessons.php';
	include_once 'libraries/reports.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// if there is no post variable, redirect
	if(!isset($_GET['id'])){
		header("Location: user_view_lessons.php");
	}
	else{
		// read lesson id from post
		$lessonid = $_GET['id'];
	}
	
	// get username and query the requested message
	$username = getLoggedInUsername();
	$lesson = getSingleLessonId($lessonid);
	
	// now check that this user should be able to read this message at all.
	// ie - admin, or either the tutor, student or parent
	if(getLoggedInType() != "admin"){
		if($username != $lesson[0]["Tutor"]
			&& $username != $lesson[0]["Student"]
			&& $username != getParentUsername($lesson[0]["Student"])){
				// redirect as needed
				header("Location: user_view_lessons.php");
		}
	}
	
	$sitePage = <<<EOT
	
	<br />
	<h1>View Lesson</h1>
	<h2></h2>
	<br />
    
EOT;
	
	// create table and get lesson content
	$tablef = new tableFactory();
	$table = $tablef->makeTable(null, $lesson);
	$sitePage = $sitePage . $table->getTable();
	
	// report
	$currentUserType = getLoggedInType();
	
	// if current user is not a student, show report (if any)
	if(hasParentAccess() || $currentUserType == 'admin' || $currentUserType == 'tutor'){
		$report = getSingleReportId($lessonid);
		if(!empty($report)){
			$sitePage = $sitePage . '<div class ="reportBlock"><a class ="editReportButton" href="">Edit Report</a>';
			$sitePage = $sitePage . '<div class ="report">' . $report['reportText'] . '</div>';
		}
		else{
			$sitePage = $sitePage . '<div class ="reportBlock"><a class="addReportButton" href="user_report_new.php">Add Report</a>';
		}
		$sitePage = $sitePage . '</div>';
	}
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
