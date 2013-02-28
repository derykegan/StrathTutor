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
    <div class = "lessonBlock">
EOT;

	$currentUserType = getLoggedInType();
	/*
	// create table and get lesson content
	$tablef = new tableFactory();
	$table = $tablef->makeTable(null, $lesson);
	$sitePage = $sitePage . $table->getTable();
	*/
	
	$lesson = $lesson[0];
	
	// now render lesson display, depending on user type
	// case: admin or parent
	if($currentUserType == 'admin' || hasParentAccess()){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Student:</span>' 
			. $lesson['Student'] .'</div> ';
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Tutor:</span>' 
			. $lesson['Tutor'] .'</div> ';
	}
	// case: student
	else if($currentUserType == 'student'){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Tutor:</span>' 
			. $lesson['Tutor'] .'</div> ';
	}
	// case: tutor
	else if($currentUserType == 'tutor'){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Student:</span>' 
			. $lesson['Student'] .'</div> ';
	}
	
	// display lesson type (friendly)
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_type"><span class = "label">Subject:</span>' 
			. $lesson['SubjectDescription'] .'</div>';
	
	// display time and duration
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_time"><div class = "time"><span class = "label">Start Time:</span>' 
			. $lesson['startTime'] .'</div> <div class = "duration"> <span class = "label">Duration:</span>'
			. $lesson['friendlyDuration'] . '</div></div>';
			
	// display lesson status
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_status"><span class = "label">Status:</span>' 
			. $lesson['statusDescription'] .'</div>';
			
	// display lesson comments (if any)
	if(!empty($lesson['lesson_comments'])){
		$sitePage = $sitePage . 
				'<div class = "lessonBlock_comments"><span class = "label">Comments:</span>' 
				. $lesson['lesson_comments'] .'</div>';
	}
	
	// close lesson container div
	$sitePage = $sitePage . '</div>';
	
	
	// report
	
	
	// if current user is not a student, show report (if any)
	if(hasParentAccess() || $currentUserType == 'admin' || $currentUserType == 'tutor'){
		$report = getSingleReportId($lessonid);
		if(!empty($report)){
			$sitePage = $sitePage . '<div class ="reportBlock"><a class ="editReportButton" href="">Edit Report</a>';
			$sitePage = $sitePage . '<div class ="report">' . $report['reportText'] . '</div>';
		}
		else{
			if($currentUserType == 'tutor' || $currentUserType == 'admin'){
				$sitePage = $sitePage . '<div class ="reportBlock"><a class="addReportButton" href="user_report_new.php">Add Report</a>';
			}
		}
		$sitePage = $sitePage . '</div>';
	}
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
