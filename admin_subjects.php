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
	<h1>Subject Editing</h1>
	<h2>Select a subject in order to edit its content.</h2>
	<br />
    
EOT;
	
	// now generate table
	$subjects = getSubjects();
	$sitePage = $sitePage . ('<div class="tableContainer"><table class="twoCol">');
	
	//print header row
	$sitePage = $sitePage . ('<tr class = "tableHeader">' .
			'<td class = "bold">' . 'Subject'. '</td>' . 
			'<td class = "bold">' . 'Level' . '</td>' .
			'<td class = "bold">' . 'Description' . '</td>' . '</tr>');
	
	$size = count($subjects);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $subjects[$i]["SubjectName"] . 
			'<td class = "even">'. $subjects[$i]["SubjectLevel"] . '<td class = "odd">' . $subjects[$i]["SubjectDescription"] 
			. '</tr>');
		}
		else{
			$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $subjects[$i]["SubjectName"] . 
			'<td class = "even">'. $subjects[$i]["SubjectLevel"] . '<td class = "odd">' . $subjects[$i]["SubjectDescription"] 
			. '</tr>');
		}
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
