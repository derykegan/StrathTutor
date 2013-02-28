<?php

	/*
		Report display - takes id from post
		
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
		header("Location: user_reports.php");
	}
	else{
		// read report id from post
		$reportid = $_GET['id'];
	}
	
	// get username and query the requested message
	$username = getLoggedInUsername();
	$report = getSingleReportId($reportid);
	
	var_dump($report);
	
	$sitePage = "<br />
	<h1>View Lesson Report</h1>
	<h2></h2>
	<br />";
	
	// check report isn't null
	if(empty($report) || $report == null){
		$sitePage = "<br />
		<h1>View Lesson Report</h1>
		<h2></h2>
		<br />No report found.";
	}
	
	else{
	
		// now check that this user should be able to read this message at all.
		// ie - admin, or either the tutor, student or parent
		if(getLoggedInType() != "admin"){
			if($username != $report[0]["Tutor"]
				&& $username != $report[0]["Student"]
				&& $username != getParentUsername($report[0]["Student"])){
					// redirect as needed
					header("Location: user_reports.php");
			}
		}
	}
	
	
	// create table and get content
	$tablef = new tableFactory();
	$table = $tablef->makeTable(null, $report);
	$sitePage = $sitePage . $table->getTable();
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
