<?php
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Lessons</h1>
	<h2>Select a lesson to edit.</h2>
	<br />
    
EOT;
	
	// now generate table
	$lessons = getLessonList();
	$sitePage = $sitePage . '<div class="tableContainer"><table class="twoCol">'
		. '<tr class = "tableHeader">'
		. '<td>Lesson ID</td>'
		. '<td>Tutor</td>'
		. '<td>Student</td>'
		. '<td>Start Date/time</td>'
		. '<td>End Date/time</td></tr>';
	
	$size = count($lessons);
	if($size <= 0){
		$sitePage = $sitePage . '<tr class = "odd"><td colspan="0">No lessons have been added.</td></tr>';
	}
	else{
		for($i = 0; $i < $size; $i++){
			
			if($i % 2){
				$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $lessons[$i]["lesson_id"] . 
				'<td class = "even">'. $users[$i]["tutor_id"] . '<td class = "odd">' . $users[$i]["student_id"] . " " .
				$users[$i]["startDate"] . '<td class = "even">'. $users[$i]["endDate"] . '</tr>');
			}
			else{
				$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $users[$i]["lesson_id"] . 
				'<td class = "even">'. $users[$i]["tutor_id"] . '<td class = "odd">' . $users[$i]["student_id"] . " " .
				$users[$i]["startDate"] . '<td class = "even">'. $users[$i]["endDate"] . '</tr>');
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
