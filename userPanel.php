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
	
	$site_name = getSetting("site_name");
	$parentSpecific = "<a class = 'panelOption'href='user_booking.php' title='Make a new lesson booking.'>Lesson Booking</a>
	<a class = 'panelOption'href='user_payments.php' title='View payments and invoicing information'>Payments</a>
	<a class = 'panelOption'href='user_reports.php' title='View past lesson reports'>Reports</a>";
	
	// generic content header
	$userPage = "<br />
	<h1>Welcome</h1>
	<h2>Welcome to $site_name. To begin, please select an option below.</h2>
	<br />
	<div class = 'panelContainer'>";
	
	// if a parent, add in parent specific content
	if(hasParentAccess()){
	
		$userPage = $userPage . $parentSpecific;
		
	}

	// generic content end
	$userPage = $userPage . "
	<a class = 'panelOption'href='user_options.php' title='Personalise your options.'>Options</a>
	</div>
	<span class='clear'></span>";
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($userPage);
	
	// print page to screen
	echo($page->getPage());
	
?>
