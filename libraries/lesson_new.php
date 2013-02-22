<?php

	/*
		Class for processing input from create lesson form.
		Please note that input is not escaped here, but is handled in
		lessons.php.
		
		*/
	include_once "sql.php";
	include_once "session.php";
	include_once 'user_check.php';
	include_once 'lessons.php';
	
	$studentSet = false;
	$tutorSet = false;
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: ../index.php");
	}
	
	// make sure we have either a student or tutor, or both
	if(isset($_POST['student']) || isset($_POST['tutor'])){
		if(isset($_POST['student'])){
			$student = $_POST['student'];
			$studentSet = true;
		}
		if(isset($_POST['tutor'])){
			$tutor = $_POST['tutor'];
			$tutorSet = true;
		}
		
		// fill in the gaps with the current user
		if(!$studentSet){
			$student = getLoggedInUsername();
		}
		if(!$tutorSet){
			$tutor = getLoggedInUsername();
		}
	}
	else{
		// set session flag to indicate invalid user, then redirect
		$_SESSION['error_message_noUser'] = true;
		
		// redirect with error
		header("Location: ../user_lesson_new.php");
	}
	
	// get lesson details from POST
	$subject = $_POST['subject'];
	$level = $_POST['level'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	
	if(isset($_POST['comments'])){
		$comments = $_POST['comments'];
	}
	else{
		$comments = "";
	}

	
	// check that all users exist, else redir with error
	if(userExists($tutor) && userExists($student)){
		
		$userType = getLoggedInType();
		
		if($userType == 'admin' || $userType == 'tutor'){
			$status = "APPROVED";
		}
		
		if($userType == 'student' || $userType == 'parent'){
			$status = "WAITING";
		}

		// create lesson
		createLesson($student, $tutor, $subject, $level, $startTime, $endTime, $comments, $status);
		
		// redirect to lessons page
		header("Location: ../user_view_lessons.php");
		
	}
	else{
		// set session flag to indicate invalid users, then redirect
		$_SESSION['error_message_noUser'] = true;
		
		header("Location: ../user_lesson_new.php");
	}
	
?>
