<?php
	include_once "sql.php";
	include_once "session.php";
	include_once "user_check.php";
	
	/*
		Backend processing for report adding
		
		Required POST entries: lesson_id, reportText
		
		*/
		
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: ../index.php");
	}
	
	$redirURL = "../user_lesson_display.php";
	
	// make sure that form has been filled out
	if(isset($_POST['reportText']) && isset($_POST['lesson_id'])){
		$reportText = $_POST['reportText'];
		$lesson_id = $_POST['lesson_id'];
	}
	else{
		header:("Location: " . $redirURL);
	}
	
	// security - escape queries
	$reportText = escapeQuery($reportText);
	$lesson_id = escapeQuery($lesson_id);
	
	$query = "INSERT INTO LessonReports(lesson_id, reportText)
	VALUES ('$lesson_id', '$reportText')";
	
	doQuery($query);
	
	// redirect to lesson page
	header("Location: " . $redirURL . "?id=" . $lesson_id);

?>
