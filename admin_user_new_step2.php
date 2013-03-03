<?php

	/*
		Create user form for admin - page 2.
		Processes input for: user type, username, password, first/last name, email address.
		
		Saves variables in session for later processing.
		
		*/
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'libraries/admin_user_new.php';
	
	$step1URL = "admin_user_new_step1.php";
	$step3URL = "admin_user_new_step3.php";
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// validate input, redirect if not
	if(!(isset($_POST['new_user_type']) && isset($_POST['new_user_username'])
		&& isset($_POST['new_user_password']) && isset($_POST['new_user_firstname'])
		&& isset($_POST['new_user_lastname']) && isset($_POST['new_user_email']) )){
			header("Location: " . $step1URL);
		}
	
	// get user details from POST and place in session
	$_SESSION['new_user_type'] 		= $_POST['new_user_type'];
	$_SESSION['new_user_username'] 	= $_POST['new_user_username'];
	$_SESSION['new_user_password'] 	= $_POST['new_user_password'];
	$_SESSION['new_user_firstname'] = $_POST['new_user_firstname'];
	$_SESSION['new_user_lastname'] 	= $_POST['new_user_lastname'];
	$_SESSION['new_user_email'] 	= $_POST['new_user_email'];
	
	
	// case: new student
	if($_SESSION['new_user_type'] == 'student'){
		$createForm = ' <form method="POST" action="' . $step3URL .'">
 			       	
			<table class="create_user">
                <tr>
                    <td><p class="label">New student - part 2.</p></td>
                </tr>
                <tr>
                    <td><p class="label">Is this student self sufficient?:</p></td>
                    <td><input type="checkbox" name="ownParent"></td>
                </tr>
                <tr>
                    <td><input type="Submit" value="Continue" class="continueButton"></td>
                </tr>
            </table>

        </form>';
	}
	
	// case: new parent
	else if($_SESSION['new_user_type'] == 'parent'){
		
	}
	
	// case: new tutor
	else if($_SESSION['new_user_type'] == 'tutor'){
		// no extra data needed at this stage
		header("Location: " . $step3URL);
	}
	
	// case: new admin
	else if($_SESSION['new_user_type'] == 'admin'){
		// no extra data needed at this stage
		header("Location: " . $step3URL);
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($createForm);
	
	// print page to screen
	echo($page->getPage());
	
	

?>