<?php

	/*
		Lesson display - takes id from post
		
		*/
		
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/lessons.php';
	include_once 'libraries/reports.php';
	include_once 'classes/pageFactory.php';
	include_once 'classes/tableFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// if there is no post variable, redirect
	if(!isset($_GET['id'])){
		header("Location: user_view_lessons.php");
	}
	else{
		// read lesson id from post
		$lessonid = $_GET['id'];
	}
	
	// get username and query the requested lesson
	$username = getLoggedInUsername();
	$lesson = getSingleLessonId($lessonid);
	
	// now check that this user should be able to view this lesson at all.
	// ie - admin, or either the tutor, student or parent
	if(getLoggedInType() != "admin"){
		if($username != $lesson[0]["Tutor"]
			&& $username != $lesson[0]["Student"]
			&& $username != getParentUsername($lesson[0]["Student"])){
				// redirect as needed
				header("Location: user_view_lessons.php");
		}
	}
	
	$sitePage = <<<EOT
	
	<br />
	<h1>View Lesson</h1>
	<h2></h2>
	<br />
    <div class = "lessonBlock">
EOT;

	$currentUserType = getLoggedInType();
	/*
	// create table and get lesson content
	$tablef = new tableFactory();
	$table = $tablef->makeTable(null, $lesson);
	$sitePage = $sitePage . $table->getTable();
	*/
	
	$lesson = $lesson[0];
	
	// now render lesson display, depending on user type
	// case: admin or parent
	if($currentUserType == 'admin' || hasParentAccess()){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Student:</span>' 
			. $lesson['Student'] .'</div> ';
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Tutor:</span>' 
			. $lesson['Tutor'] .'</div> ';
	}
	// case: student
	else if($currentUserType == 'student'){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Tutor:</span>' 
			. $lesson['Tutor'] .'</div> ';
	}
	// case: tutor
	else if($currentUserType == 'tutor'){
		$sitePage = $sitePage . 
			'<div class = "lessonBlock_user"><span class = "label">Student:</span>' 
			. $lesson['Student'] .'</div> ';
	}
	
	// display lesson type (friendly)
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_type"><span class = "label">Subject:</span>' 
			. $lesson['SubjectDescription'] .'</div>';
	
	// display time and duration
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_time"><div class = "time"><span class = "label">Start Time:</span>' 
			. $lesson['startTime'] .'</div> <div class = "duration"> <span class = "label">Duration:</span>'
			. $lesson['friendlyDuration'] . '</div></div>';
			
	// display lesson status  ------------------------------
	$sitePage = $sitePage . 
			'<div class = "lessonBlock_status"><span class = "label">Status:</span>' 
			. $lesson['statusDescription'];
			
	// case: Tutor
	if($currentUserType == 'tutor'){
		// if lesson is WAITING, allow APPROVE option
		if($lesson['statusName'] == 'WAITING'){
			$sitePage = $sitePage . 
				'<form method="POST" action="libraries/lesson_status_change.php">' 
				. '<input type="hidden" name="lesson_id" value="' . $lessonid . '">'
				. '<input type="hidden" name="lesson_new_status" value="APPROVED">'
				. '<input type="Submit" value="Approve Lesson" class="lessonButton">'
				. '</form>';
		}
		// else nothing to show
	}
	
	// case: Parent
	else if($currentUserType == 'parent'){
		// if lesson is DONE_NO_PAY, allow pay option
		if($lesson['statusName'] == 'DONE_NO_PAY'){
			$sitePage = $sitePage . 
				'<a class="lessonButton" href="TODO">Make Payment</a>';
		}
		// else nothing to show
	}
	
	// case: Admin
	if($currentUserType == 'admin'){
		// if admin, add a drop down list to allow changing the status
		$sitePage = $sitePage . 
			'<form method="POST" action="libraries/lesson_status_change.php">' 
			. '<input type="hidden" name="lesson_id" value="' . $lessonid . '">'
			. generateStatusDropDown($lesson['statusName'])
			. '<input type="Submit" value="Save" class="lessonButton">'
			. '</form>';
		
	}
		
	// close lesson status div	---------------------------
	$sitePage = $sitePage . '</div>';
			
	// display lesson comments (if any)
	if(!empty($lesson['lesson_comments'])){
		$sitePage = $sitePage . 
				'<div class = "lessonBlock_comments"><span class = "label">Comments:</span>' 
				. $lesson['lesson_comments'] .'</div>';
	}
	
	// close lesson container div
	$sitePage = $sitePage . '</div>';
	
	
	// report -------------------
	
	
	// if current user is not a student, show report (if any)
	if(hasParentAccess() || $currentUserType == 'admin' || $currentUserType == 'tutor'){
		$report = getSingleReportId($lessonid);
		// display report if it exists
		if(!empty($report)){
			$report = $report[0];
			// editable for admins or tutors
			if($currentUserType == 'admin' || $currentUserType == 'tutor'){
					$sitePage = $sitePage . "<div class='newReport'><span class = 'label'>Report:</span>
						<form method='post' action='libraries/report_edit.php'>
						<textarea name='reportText' class='edit_inline'>". $report['Report'] . "</textarea>
						<input type='hidden' name='lesson_id' value='" . $lessonid . "'>
						<input type='Submit' value='Save Report' class='submitButton'>
						</form></div>";
					}
			// non editable for anyone else
			else{
				$sitePage = $sitePage . "<div class='newReport'><span class = 'label'>Report:</span>". $report['Report'] . "</div>";
			}
		}
		// display add report option if appropriate
		else{
			if($currentUserType == 'tutor' || $currentUserType == 'admin'){
				// only completed lessons can have reports added
				if($lesson['statusName'] != 'WAITING' && $lesson['statusName'] != 'APPROVED'){
					$sitePage = $sitePage . '<div class ="reportBlock"><form method="get" action="user_report_new.php">' 
					. '<input type="hidden" name="id" value="' .$lessonid . '">
					<input type="Submit" value="Add Report" class="lessonButton"></form>';
				}
			}
		}

	}
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
	
	// generates a drop down menu with possible statuses
	function generateStatusDropDown($currentStatus){
		
		$query = "SELECT * FROM LessonStatus";
		$result = doQuery($query);
		
		$drop = "<select name='lesson_new_status'>";
		
		while($row = $result->fetch_assoc()){
			if($row['statusName'] == $currentStatus){
				$drop = $drop . '<option value="' . $row['statusName'] . '" selected>' . $row['statusDescription'] . '</option>';
			}
			else{
				$drop = $drop . '<option value="' . $row['statusName'] . '">' . $row['statusDescription'] . '</option>';
			}
		}
		
		$drop = $drop . "</select>";
		
		return $drop;
		
		
	}
	
?>
