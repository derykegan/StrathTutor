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
		exit;
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
		setError("Oops! Looks like that user name was wrong. Please try again.");
		
		// redirect with error
		header("Location: ../user_booking.php");
		exit;
	}
	
	// check that POST details are set
	if(!(isset($_POST['subject']) && isset($_POST['startTime']) && isset($_POST['duration']))){
		// set session flag to indicate invalid info
		setError("Oops! Some of the required information wasn't provided. Please try again.");
		
		// redirect with error
		header("Location: ../user_booking.php");
		exit;
	}
	
	// get lesson details from POST
	$subjectId = $_POST['subject'];
	$startTime = $_POST['startTime'];
	$duration = $_POST['duration'];
	
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
		
		else if($userType == 'student' || $userType == 'parent'){
			$status = "WAITING";
		}

		// create lesson
		createLesson($student, $tutor, $subjectId, $startTime, $duration, $comments, $status);
		
		// redirect to lessons page
		header("Location: ../user_lessons.php");
		exit;
		
	}
	else{
		// set session flag to indicate invalid users, then redirect
		setError("Oops! Looks like that user name was wrong. Please try again.");
		
		header("Location: ../user_booking.php");
		exit;
	}
	
?>
