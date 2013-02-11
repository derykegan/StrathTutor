<?php

	/*
		Class for processing input from create message form.
		Please note that input is not escaped here, but is handled in
		messages.php.
		
		*/
	include_once "sql.php";
	include_once "session.php";
	include_once 'user_check.php';
	include_once 'messages.php';
	
	// get message details from POST
	$toUser = $_POST['toUser'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: ../index.php");
	}

	// get current username
	$fromUser = getLoggedInUsername();
	
	// check that target user exists, else redir with error
	if(userExists($toUser)){

		// create message
		sendMessage($fromUser, $toUser, $subject, $message);
		
		// redirect to messaging page
		header("Location: ../user_messaging.php");
		
	}
	else{
		// set session flag to indicate invalid user, then redirect
		$_SESSION['error_message_noUser'] = true;
		
		header("Location: ../user_message_new.php");
	}
	
?>
