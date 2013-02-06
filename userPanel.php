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
		&& !validateUserType("tutor")
		&& !validateUserType("admin")){
			header("Location: index.php");
	}
	
	$isNotAdmin = false;
	// check if is not admin
	if(getLoggedInType() != 'admin'){
		$isNotAdmin = true;
	}
	
	$userIntro = getPageContent("userPanel");	
	
	// admin specific menu options
	$adminSpecific = "<a class = 'panelOption'href='admin_user.php' title='Add, edit or remove users.'>Users</a>
	<a class = 'panelOption'href='admin_subjects.php' title='Add, edit or remove subjects.'>Subjects</a>
	<a class = 'panelOption'href='admin_pages.php' title='Edit page content, eg About or Welcome.'>Pages</a>
	<a class = 'panelOption'href='admin_site.php' title='Change options to personalise the site.'>Site Configuration</a>";
	
	// parent specific menu options
	$parentSpecific = "<a class = 'panelOption'href='user_booking.php' title='Make a new lesson booking.'>Lesson Booking</a>
	<a class = 'panelOption'href='user_payments.php' title='View payments and invoicing information'>Payments</a>
	<a class = 'panelOption'href='user_reports.php' title='View past lesson reports'>Reports</a>";
	
	// tutor specific menu options
	$tutorSpecific = "<a class = 'panelOption'href='user_booking.php' title='Make a new lesson booking.'>Lesson Booking</a>
	<a class = 'panelOption'href='user_reports.php' title='Create or view past lesson reports'>Reports</a>";
	
	// student specific menu options - currently blank
	$studentSpecific = "";
	
	// generic content header
	$userPage = "<br />
	$userIntro
	<br />
	<div class = 'panelContainer'>";
	
	// if not admin, add view lessons option
	if($isNotAdmin){
		$userPage = $userPage . "<a class = 'panelOption' href='user_lessons.php' title='View scheduled and past lessons'>View Lessons</a>";
	}
	
	// if an admin, add in admin options
	if(getLoggedInType() == 'admin'){
		$userPage = $userPage . $adminSpecific;
	}
	
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
