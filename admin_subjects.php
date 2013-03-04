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
	
	$sitePage = $sitePage . '<div class = "addSubject"><span class="sectionTitle">Add Subject</span>
	<form class="subject" name="addSubject" method="POST" action="libraries/subject_add.php">
		<table class="create_subject">
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><input type="text" name="subject_subject" size="30" required="required" required=required></td>
                </tr>
                <tr>
                    <td><p class="label">Level:</p></td>
                    <td><select name="subject_level">' . generateDropDown('level') . '</td>
                </tr>
				<tr>
					<td><p class="label">Description:</p></td>
					<td><input type="text" name="subject_description" required=required></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Add Subject" class="sendButton"></td>
                </tr>
            </table>
			</form></div>';
			
	$sitePage = $sitePage . '<div class = "addSubject"><span class="sectionTitle">Add Tuition Level</span>
	<form class="subject" name="addLevel" method="POST" action="libraries/subject_add_level.php">
		<table class="create_subject">
                <tr>
                    <td><p class="label">Level:</p></td>
                    <td><input type="text" name="level_level" required=required></td>
                </tr>
				<tr>
					<td><p class="label">Description:</p></td>
					<td><input type="text" name="level_description" required=required></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Add Level" class="sendButton"></td>
                </tr>
            </table>
			</form> <br />';
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
	// generates drop down options depending on type
	function generateDropDown($type){
		
		$typeArray = array('level');
		
		// if given option isn't predefined, return nothing
		if(!in_array($type, $typeArray)){
			return "";
		}
		
		// possible lesson durations
		if($type == 'level'){
			
			$query = "SELECT * FROM SubjectLevel";	
			$result = doQuery($query);
			$toReturn = "";
			
			if(count($result) > 0){
				while($row = $result->fetch_assoc()){
					$toReturn = $toReturn . "<option value=" . $row['Level'] . ">" . $row['Description'] . "</option>";
				}
			}
			
			return $toReturn;
			
		}
		
	}
	
?>
