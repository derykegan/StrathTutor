<?php

	/*
		Create user form for admin - page 2.
		Processes input for: 	student - if is self sufficient
								parent  - student username
		
		Saves variables in session for later processing.
		
		*/
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'libraries/hashing.php';
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
		
	// check that username does not exist already
	if(userExists($_POST['new_user_username'])){
		// set flag and redirect to step1
		$_SESSION['error_UserExists'] = true;
		header("Location: " . $step1URL);
		return;
	}
	
	// get user details from POST and place in session
	$_SESSION['new_user_type'] 		= $_POST['new_user_type'];
	$_SESSION['new_user_username'] 	= $_POST['new_user_username'];
	$_SESSION['new_user_password'] 	= hashPassword($_POST['new_user_password']);
	$_SESSION['new_user_firstname'] = $_POST['new_user_firstname'];
	$_SESSION['new_user_lastname'] 	= $_POST['new_user_lastname'];
	$_SESSION['new_user_email'] 	= $_POST['new_user_email'];
	
	// check for optional fields and set if necessary
	if(isset($_POST['new_user_address1'])){
		$_SESSION['new_user_address1'] = $_POST['new_user_address1'];
	}
	else{
		$_SESSION['new_user_address1'] = "";
	}
	if(isset($_POST['new_user_address2'])){
		$_SESSION['new_user_address2'] = $_POST['new_user_address2'];
	}
	else{
		$_SESSION['new_user_address2'] = "";
	}
	if(isset($_POST['new_user_address3'])){
		$_SESSION['new_user_address3'] = $_POST['new_user_address3'];
	}
	else{
		$_SESSION['new_user_address3'] = "";
	}
	if(isset($_POST['new_user_postcode'])){
		$_SESSION['new_user_postcode'] = $_POST['new_user_postcode'];
	}
	else{
		$_SESSION['new_user_postcode'] = "";
	}
	if(isset($_POST['new_user_phone_home'])){
		$_SESSION['new_user_phone_home'] = $_POST['new_user_phone_home'];
	}
	else{
		$_SESSION['new_user_phone_home'] = "";
	}
	if(isset($_POST['new_user_phone_mobile'])){
		$_SESSION['new_user_phone_mobile'] = $_POST['new_user_phone_mobile'];
	}
	else{
		$_SESSION['new_user_phone_mobile'] = "";
	}
	
	
	// case: new student
	if($_SESSION['new_user_type'] == 'student'){
		$createForm = ' <form method="POST" action="' . $step3URL .'">
 			       	
			<table class="create_user">
                <tr>
                    <td><p class="label" colspan="2">New student - part 2.</p></td>
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
		$createForm = ' <form method="POST" action="' . $step3URL .'">
 			       	
			<table class="create_user">
                <tr>
                    <td><p class="label" colspan="2">New parent - part 2.</p></td>
                </tr>
                <tr>
                    <td><p class="label">If this parent has a child, enter the child username here. Note: more can be added later.</p></td>
                    <td><input type="text" name="new_user_parent_childname"></td>
                </tr>
                <tr>
                    <td><input type="Submit" value="Continue" class="continueButton"></td>
                </tr>
            </table>

        </form>';

		
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