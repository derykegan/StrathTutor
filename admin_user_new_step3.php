<?php

	/*
		Actually creates the user with the information provided so far.
		
		Performs some additional checks to ensure that the user isn't being duplicated.
		
		On completion, displays a success page and redirects after 20 seconds.
		
		*/
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'libraries/admin_user_new.php';
	
	$step1URL = "admin_user_new_step1.php";
	$step2URL = "admin_user_new_step2.php";
	$completeURL = "admin_user.php";
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// get user details from POST and place in session
	$newUserType	 	= $_SESSION['new_user_type'];
	$newUserUsername 	= $_SESSION['new_user_username'];
	$newUserPassword 	= $_SESSION['new_user_password'];
	$newUserFirstName 	= $_SESSION['new_user_firstname'];
	$newUserLastName	= $_SESSION['new_user_lastname'];
	$newUserEmail		= $_SESSION['new_user_email'];
	
	$newUserAddress1	= $_SESSION['new_user_address1'];
	$newUserAddress2	= $_SESSION['new_user_address2'];
	$newUserAddress3	= $_SESSION['new_user_address3'];
	$newUserPostcode	= $_SESSION['new_user_postcode'];
	$newUserPhoneHome 	= $_SESSION['new_user_phone_home'];
	$newUserPhoneMobile	= $_SESSION['new_user_phone_mobile'];
	
	// make sure we're not duplicating an existing user
	if(userExists($newUserUsername)){
		$message = "<div>User already exists.</div>";
		header("Location: " . $step1URL);
		
	}
	else{
	
		// case: new student
		if($newUserType == 'student'){
			// read status of own parent
			if(isset($_POST['ownParent'])){
				if($_POST['ownParent'] == true){
					$isOwnParent = true;
				}
			}
			else{
				$isOwnParent = false;
			}
			
			createNewStudent($newUserUsername, $newUserPassword, $newUserFirstName, $newUserLastName, $newUserEmail, $newUserAddress1, $newUserAddress2,
			$newUserAddress3, $newUserPostcode, $newUserPhoneHome, $newUserPhoneMobile, $isOwnParent);
		}
		
		// case: new parent
		else if($newUserType == 'parent'){
			
			// set blank
			$childname = "";
			
			// read status of own parent
			if(isset($_POST['new_user_parent_childname'])){
				if(!empty($_POST['new_user_parent_childname'])){
					$childname = $_POST['new_user_parent_childname'];
					
					// validate childname
					if(!userExists($childname)){
						$childname = "";
					}
				}
			}
			
			createNewParent($newUserUsername, $newUserPassword, $newUserFirstName, $newUserLastName, $newUserEmail, $newUserAddress1, $newUserAddress2,
			$newUserAddress3, $newUserPostcode, $newUserPhoneHome, $newUserPhoneMobile, $childname);
	
			
		}
		
		// case: new tutor
		else if($newUserType == 'tutor'){
			createNewTutor($newUserUsername, $newUserPassword, $newUserFirstName, $newUserLastName, $newUserEmail, $newUserAddress1, $newUserAddress2,
			$newUserAddress3, $newUserPostcode, $newUserPhoneHome, $newUserPhoneMobile);
		}
		
		// case: new admin
		else if($newUserType == 'admin'){
			createNewAdmin($newUserUsername, $newUserPassword, $newUserFirstName, $newUserLastName, $newUserEmail, $newUserAddress1, $newUserAddress2,
			$newUserAddress3, $newUserPostcode, $newUserPhoneHome, $newUserPhoneMobile);
		}
		
		$message = "<div class = 'message'>New user created successfully! User details: <br />"
			. "Type: " . $newUserType . " <br / >"
			. "Username: " . $newUserUsername . " <br / >"
			. "First name: " . $newUserFirstName . " <br / >"
			. "Last name: " . $newUserLastName . " <br / >"
			. "Email: " . $newUserEmail . " <br / >"
			. "<br />This page will redirect in 20 seconds.<br />"
		. "<meta http-equiv='refresh' content='20; url='" . $completeURL . "'> </div>";
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($message);
	
	// print page to screen
	echo($page->getPage());
	
	

?>