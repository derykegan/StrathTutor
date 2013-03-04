<?php

	/*
		Lesson Report Creation - takes lesson id from URL
		
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
	// ie - admin or the lesson tutor only
	if(getLoggedInType() != "admin"){
		if($username != $lesson[0]["Tutor"]){
				// redirect as needed
				header("Location: user_view_lessons.php");
		}
	}
	
	$sitePage = <<<EOT
	
	<br />
	<h1>Add Report</h1>
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
	
	
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Student:</span>' 
			. $lesson['Student'] .'</div> ';

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
	
	$sitePage = $sitePage . "<div class='newReport'><span class = 'label'>Report:</span>
		<form method='post' action='libraries/report_add.php'>
		<textarea name='reportText' class='edit_inline'></textarea>
		<input type='hidden' name='lesson_id' value='" . $lessonid . "'>
		<input type='Submit' value='Save Report' class='submitButton'>
		</form></div>";
	
	// close lesson container div
	$sitePage = $sitePage . '</div>';
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
