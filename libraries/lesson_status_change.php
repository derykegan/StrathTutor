<?php
	include_once "sql.php";
	include_once "session.php";
	include_once "user_check.php";
	
	/*
		Backend processing for updating a lesson status
		
		Required POST entries: lesson_id, lesson_new_status
		
		*/
		
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: ../index.php");
	}
	
	$redirURL = "../user_lesson_display.php";
	
	// make sure that form has been filled out
	if(isset($_POST['lesson_new_status']) && isset($_POST['lesson_id'])){
		$lesson_new_status = $_POST['lesson_new_status'];
		$lesson_id = $_POST['lesson_id'];
	}
	else{
		header:("Location: " . $redirURL);
	}
	
	// security - escape queries
	$lesson_new_status = escapeQuery($lesson_new_status);
	$lesson_id = escapeQuery($lesson_id);
	
	$query = "UPDATE Lessons
	SET status='$lesson_new_status'
	WHERE lesson_id='$lesson_id'";
	
	doQuery($query);
	
	// redirect to lesson page
	header("Location: " . $redirURL . "?id=" . $lesson_id);

?>
