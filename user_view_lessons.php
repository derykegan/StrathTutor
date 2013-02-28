<?php
	/*
	
		View this user's lessons.
		
		*/
	// import session and header
	include_once 'libraries/user_check.php';
	include_once 'libraries/lessons.php';
	include_once 'classes/pageFactory.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// get username and query messages
	$username = getLoggedInUsername();
	$userType = getLoggedInType();
	
		// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Lessons</h1>
	<h2>Select a lesson to see more information.</h2>
	<br />
    
EOT;
	
	// build table
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	// get appropriate lesson list depending on user type
	if($userType == 'student'){
		$lessons = getStudentLessons($username);
	}
	else if($userType == 'tutor'){
		$lessons = getTutorLessons($username);
	}
	else if($userType == 'parent'){
		$lessons = getParentLessons($username);
	}
	
	$size = count($lessons);
	
	// if no lessons
	if($size == 0){
		$sitePage = $sitePage . '<tr class = "odd"><td class = "bold">No lessons currently booked!</td></tr>';
	}
	// else have lessons
	else{
		
		// case: student
		if($userType == 'student'){
		
			//print header row
			$sitePage = $sitePage . ('<tr class = "tableHeader">' . '<td class = "bold">' 
					. '</td>' .
					'<td class = "bold">' . 'Tutor'. '</td>' . 
					'<td class = "bold">' . 'Start Time' . '</td>' .
					'<td class = "bold">' . 'End Time' . '</td>' .
					'<td class = "bold">' . 'Subject' . '</td>' . 
					'<td class = "bold">' . 'Level' . '</td>' .'</tr>');
			
			for($i = 0; $i < $size; $i++){
				$lessonid = $lessons[$i]["lesson_id"];
	
				if($i % 2){
					$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				else{
					$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">' .
					'<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				
			}
		}
		
		// case: tutor
		if($userType == 'tutor'){
		
			//print header row
			$sitePage = $sitePage . ('<tr class = "tableHeader">' . '<td class = "bold">' 
					. '</td>' .
					'<td class = "bold">' . 'Student'. '</td>' . 
					'<td class = "bold">' . 'Start Time' . '</td>' .
					'<td class = "bold">' . 'End Time' . '</td>' .
					'<td class = "bold">' . 'Subject' . '</td>' . 
					'<td class = "bold">' . 'Level' . '</td>' .'</tr>');
			
			for($i = 0; $i < $size; $i++){
				$lessonid = $lessons[$i]["lesson_id"];
	
				if($i % 2){
					$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				else{
					$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">'
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				
			}
			
		}
		
		// case: parent
		if($userType == 'parent'){
		
			//print header row
			$sitePage = $sitePage . ('<tr class = "tableHeader">' . '<td class = "bold">' 
					. '</td>' .
					'<td class = "bold">' . 'Student'. '</td>' . 
					'<td class = "bold">' . 'Tutor'. '</td>' . 
					'<td class = "bold">' . 'Start Time' . '</td>' .
					'<td class = "bold">' . 'End Time' . '</td>' .
					'<td class = "bold">' . 'Subject' . '</td>' . 
					'<td class = "bold">' . 'Level' . '</td>' .'</tr>');
			
			for($i = 0; $i < $size; $i++){
				$lessonid = $lessons[$i]["lesson_id"];
	
				if($i % 2){
					$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				else{
					$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">'
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["endTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				
			}
			
		}
		
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
