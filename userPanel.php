<?php

	/*
		User panel class. Generates options depending on privelege level of the current user.
		This allows some code reuse in cases where options are similar - eg user options.
	*/
	
	// imports
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is a valid user, direct to index if not
	if(!validateUserType("parent")
		&& !validateUserType("student")
		&& !validateUserType("tutor")){
		header("Location: index.php");
	}
	
	$userIntro = getPageContent("userPanel");	
	
	// parent specific menu options
	$parentSpecific = "<a class = 'panelOption'href='user_booking.php' title='Make a new lesson booking.'>Lesson Booking</a>
	<a class = 'panelOption'href='user_payments.php' title='View payments and invoicing information'>Payments</a>
	<a class = 'panelOption'href='user_reports.php' title='View past lesson reports'>Reports</a>";
	
	// tutor specific menu options
	$parentSpecific = "<a class = 'panelOption'href='user_booking.php' title='Make a new lesson booking.'>Lesson Booking</a>
	<a class = 'panelOption'href='user_reports.php' title='Create or view past lesson reports'>Reports</a>";
	
	// student specific menu options - currently blank
	$studentSpecific = "";
	
	// generic content header
	$userPage = "<br />
	$userIntro
	<br />
	<div class = 'panelContainer'>
	<a class = 'panelOption' href='user_lessons.php' title='View scheduled and past lessons'>View Lessons</a>";
	
	// if a student, add in student specific content
	if(getLoggedInType() == 'student'){
		$userPage = $userPage . $studentSpecific;
	}
	
	// if a parent, add in parent specific content
	if(hasParentAccess()){
	
		$userPage = $userPage . $parentSpecific;
		
	}
	
	// if a student, add in student specific content
	if(getLoggedInType() == 'tutor'){
		$userPage = $userPage . $tutorSpecific;
	}
	
	// generic content end
	$userPage = $userPage . "
	<a class = 'panelOption' href='user_messaging.php' title='Send or receive messages.'>Messaging</a>
	<a class = 'panelOption' href='user_options.php' title='Personalise your options.'>Options</a>
	</div>
	<span class='clear'></span>";
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($userPage);
	
	// print page to screen
	echo($page->getPage());
	
?>
