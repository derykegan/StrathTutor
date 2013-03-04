<?php

	/*
		Report display - takes id from post
		
		*/
		
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/lessons.php';
	include_once 'libraries/reports.php';
	include_once 'libraries/sql.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// if there is no post variable, redirect
	if(!isset($_GET['id'])){
		header("Location: user_reports.php");
	}
	else{
		// read report id from post
		$reportid = $_GET['id'];
	}
	
	// get username and query the requested message
	$username = getLoggedInUsername();
	$currentUserType = getLoggedInType();
	$report = getSingleReportId($reportid);
	
	$sitePage = "<br />
	<h1>View Lesson Report</h1>
	<h2></h2>
	<br />";
	
	// check report isn't null
	if(empty($report) || $report == null){
		$sitePage = "<br />
		<h1>View Lesson Report</h1>
		<h2></h2>
		<br />No report found for this lesson.
		<br /><br />If you believe this is in error, please contact the administrator, quoting 
		lesson id: " . $reportid . ".";
		
		// show add report button - if applicable
		if($currentUserType == 'admin' || $currentUserType == 'tutor'){
			$sitePage = $sitePage . '<div class ="reportBlock"><a class="addReportButton" href="user_report_new.php">
			Add Report</a>';
		}
		
		// redirect to the main report page.
		else{
			$sitePage = $sitePage . '<meta http-equiv="refresh" content="10;URL=user_reports.php">';
		}
	}
	
	else{
	
		// now check that this user should be able to view this report at all.
		// ie - admin, or either the tutor, student or parent
		if(getLoggedInType() != "admin"){
			if($username != getUsernameFromId($report[0]["Tutor"])
				&& $username != getParentUsername(getUsernameFromId($report[0]["Student"]))){
					// redirect as needed
					header("Location: user_reports.php");
			}
		}
		
		// create table and get content
		$tablef = new tableFactory();
		$table = $tablef->makeTable(null, $report);
		$sitePage = $sitePage . $table->getTable();
		
	}
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
