<?php
	/*
	
		View this user's lesson reports.
		
		*/
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/reports.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	include_once 'libraries/sql.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// check if ordinary student, if so, redirect
	if(getLoggedInType() == 'student' && !hasParentAccess()){
		header("Location: index.php");
	}
	
	
	// get username and query messages
	$username = getLoggedInUsername();
	$userType = getLoggedInType();
	
		// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Reports</h1>
	<h2>Select a lesson to see more information.</h2>
	<br />
    
EOT;
	
	// get appropriate lesson list depending on user type
	
	// case: tutor
	if($userType == 'tutor'){
		$lessons = getTutorLessonsNeedingReports($username);
			// override heading to accomodate tutor content
$sitePage = <<<EOT
	
	<br />
	<h1>Reports</h1>
	<h2>Showing lessons needing reports added.</h2>
	<br />
    
EOT;
	}
	
	// case: parent
	else if($userType == 'parent'){
		// get lessons for each child
		$students = getChildrenUsernames($username);

		$lessons = array();
		foreach($students[0] as $s){
			$lessons = getStudentLessonsWithReports($s);
		}
		
	}

	// case: student
	else if($userType == 'student' && hasParentAccess()){
		$lessons = getStudentLessonsWithReports($username);
	}
	
	$size = count($lessons);
	
	// if no lessons
	if($size == 0){
		if($userType == 'tutor'){
			$sitePage = $sitePage . 'No lessons are currently needing reports added. 
				If you wish to edit an existing lesson report, you can do so via
				the <a href="user_lessons.php">lessons</a> page.';
		}
		else{
			$sitePage = $sitePage . 'No reports currently available to view.';
		}
	}
	// else have lessons
	else{
		
		$tableFactory = new tableFactory();
		$table = $tableFactory->makeTableView(array(""), $lessons, 'lesson_id', 'user_lesson_display.php');
		$sitePage = $sitePage . $table->getTable();
		
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
