<?php
	include_once "sql.php";
	include_once "session.php";
	include_once "user_check.php";
	include_once "hashing.php";
	
	/*
		Backend processing for password changes
		
		Required POST entries: user_id, user_new_password, user_new_password_confirm
		
		*/
		
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: ../index.php");
		exit;
	}
	
	$redirURL = "../user_options.php";
	
	// make sure that form has been filled out
	if(isset($_POST['user_id']) && isset($_POST['new_password']) && isset($_POST['new_password_confirm'])){
		$user_id = $_POST['user_id'];
		$user_new_password = $_POST['new_password'];
		$user_new_password_confirm = $_POST['new_password_confirm'];
	}
	else{
		serError("Required information not provided, please try again.");
		header("Location: " . $redirURL);
		exit;
	}
	
	// check that new password is not blank
	if(empty($user_new_password)){
		setError("New password provided cannot be blank. Please try again.");
		header("Location: " . $redirURL);
		exit;
	}
	
	// security - escape queries
	$user_id = escapeQuery($user_id);
	$user_new_password = escapeQuery($user_new_password);
	$user_new_password_confirm = escapeQuery($user_new_password_confirm);
	
	// check that new password matches
	if($user_new_password != $user_new_password_confirm){
		setError("New password provided does not match, please try again.");
		header("Location: " . $redirURL);
		exit;
	}
	
	$user_new_password = hashPassword($user_new_password);
	
	$query = "UPDATE User
	SET password='$user_new_password'
	WHERE user_id='$user_id'";
	
	doQuery($query);
	
	// set notification message
	setSuccess("Password successfully changed.");
	
	// redirect to user options page
	header("Location: " . $redirURL);

?>
