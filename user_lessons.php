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
	
	// set default view
	$possibleViews = array('futureOnly', 'all' );
	$view = $possibleViews[0];
	
	// read view type from URL
	if(isset($_GET['view'])){
		
		// if valid, change to given view
		if(in_array($_GET['view'], $possibleViews)){
			$view = $_GET['view'];
		}
	}
	
	// check start and end
	// read view type from URL
	if(isset($_GET['start'])){
		if(is_numeric($_GET['start'])){
			$start = $_GET['start'];
		}
	}
	if(isset($_GET['end'])){
		if(is_numeric($_GET['end'])){
			$end = $_GET['end'];
		}
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
	<a class = 'pageButton' href='user_lessons.php?view=futureOnly'>View Future Lessons</a>
	<a class = 'pageButton' href='user_lessons.php?view=all'>View All Lessons</a>
	<br />
    
EOT;
	
	// build table
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	// get appropriate lesson list depending on user type
	if($userType == 'student'){
		$lessons = getStudentLessons($username, $view);
	}
	else if($userType == 'tutor'){
		$lessons = getTutorLessons($username, $view);
	}
	else if($userType == 'parent'){
		$lessons = getParentLessons($username, $view);
	}
	
	$size = count($lessons);
	
	// if no lessons
	if($size == 0){
		$sitePage = $sitePage . '<tr class = "odd"><td class = "bold">No lessons found matching criteria.</td></tr>';
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
					'<td class = "bold">' . 'Duration' . '</td>' .
					'<td class = "bold">' . 'Subject' . '</td>' . 
					'<td class = "bold">' . 'Level' . '</td>' .'</tr>');
			
			for($i = 0; $i < $size; $i++){
				$lessonid = $lessons[$i]["lesson_id"];
	
				if($i % 2){
					$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				else{
					$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">' .
					'<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["tutor"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
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
					'<td class = "bold">' . 'Duration' . '</td>' .
					'<td class = "bold">' . 'Subject' . '</td>' . 
					'<td class = "bold">' . 'Level' . '</td>' .'</tr>');
			
			for($i = 0; $i < $size; $i++){
				$lessonid = $lessons[$i]["lesson_id"];
	
				if($i % 2){
					$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "bold">' 
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectName"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["SubjectLevel"] . '</td>' .
					'</tr>');
				}
				else{
					$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "bold">'
					. '<a href="user_lesson_display.php?id=' . $lessonid .'">VIEW</a> </td>' .
					'<td class = "even">' . $lessons[$i]["student"] . '</td>' . 
					'<td class = "even">' . $lessons[$i]["startTime"] . '</td>' .
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
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
					'<td class = "bold">' . 'Duration' . '</td>' .
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
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
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
					'<td class = "even">' . $lessons[$i]["duration"] . '</td>' .
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
