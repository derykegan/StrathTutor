<?php
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'templates/messages_nav.php';
	
	$error_noUser = false;
	
	/*
		Create Lesson view for users
		
		*/
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// determine logged in user's type
	$currentUserType = getLoggedInType();
	
	$createForm = "<h1>Lesson Booking</h1>
	<h2>Please fill out the following information.</h2>";
	
	// now define form based on user's type
	
	// case: student
	if($currentUserType == 'student' && hasParentAccess()){
	
$createForm = $createForm . '
	<form method="POST" action="libraries/lesson_new.php">
 			       	
			<table class="create_lesson">
                <tr>
                    <td><p class="label">Tutor:</p></td>
                    <td><input type="text" name="tutor" size="30" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><select name="subject">' . generateDropDown('subject') . '</td>
                </tr>
				<tr>
                    <td><p class="label">Start Date / Time:</p></td>
                    <td><input type="text" name="startTime" size="50" required="required" class="datepicker"></td>
                </tr>
				<tr>
                    <td><p class="label">Duration:</p></td>
                    <td><select name="duration">' . generateDropDown('duration') . '</select></td>
                </tr>
				<tr>
					<td><p class="label">Comments (optional):</p></td>
					<td><input type="textarea" name="comments"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Request Lesson" class="sendButton"></td>
                </tr>
            </table>

        </form>';

	}
	
		// case: parent
	else if($currentUserType == 'parent' || $currentUserType == 'admin'){
	
$createForm = $createForm . '<form method="POST" action="libraries/lesson_new.php">
 			       	
			<table class="create_lesson">
				<tr>
                    <td><p class="label">Student:</p></td>
                    <td><input type="text" name="student" size="30" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Tutor:</p></td>
                    <td><input type="text" name="tutor" size="30" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><select name="subject">' . generateDropDown('subject') . '</td>
                </tr>
				<tr>
                    <td><p class="label">Start Date / Time:</p></td>
                    <td><input type="text" name="startTime" size="30" required="required" class="datepicker"></td>
                </tr>
				<tr>
                    <td><p class="label">Duration:</p></td>
                    <td><select name="duration">' . generateDropDown('duration') . '</select></td>
                </tr>
				<tr>
					<td><p class="label">Comments (optional):</p></td>
					<td><input type="textarea" name="comments"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Request Lesson" class="sendButton"></td>
                </tr>
            </table>

        </form>';

	}
	
		// case: tutor
	else if($currentUserType == 'tutor'){
	
$createForm = $createForm . '<form method="POST" action="libraries/lesson_new.php">
 			       	
			<table class="create_lesson">
                <tr>
                    <td><p class="label">Student:</p></td>
                    <td><input type="text" name="student" size="30" required="required"></td>
                </tr>
                <tr>
                    <td><p class="label">Subject:</p></td>
                    <td><select name="subject">' . generateDropDown('subject') . '</td>
                </tr>
				<tr>
                    <td><p class="label">Start Date / Time:</p></td>
                    <td><input type="text" name="startTime" size="30" required="required" class="datepicker"></td>
                </tr>
				<tr>
                    <td><p class="label">Duration:</p></td>
                    <td><select name="duration">' . generateDropDown('duration') . '</select></td>
                </tr>
				<tr>
					<td><p class="label">Comments (optional):</p></td>
					<td><input type="textarea" name="comments"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Create Lesson" class="sendButton"></td>
                </tr>
            </table>

        </form>';

	}
	else{
		// else is non valid user type
		$createForm = $createForm . "<div class='error'>Not a valid user type</div>";
	}
	
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($createForm);
	
	// print page to screen
	echo($page->getPage());
	
	
	// generates drop down options depending on type
	function generateDropDown($type){
		
		$typeArray = array('duration', 'subject');
		
		// if given option isn't predefined, return nothing
		if(!in_array($type, $typeArray)){
			return "";
		}
		
		// possible lesson durations
		if($type == 'duration'){
			
			$query = "SELECT * FROM LessonDurations";	
			$result = doQuery($query);
			$toReturn = "";
			
			if(count($result) > 0){
				while($row = $result->fetch_assoc()){
					$toReturn = $toReturn . "<option value=" . $row['duration'] . ">" . $row['friendlyDuration'] . "</option>";
				}
			}
			
			return $toReturn;
			
		}
		
		// possible subjects
		else if($type == 'subject'){
			
			$query = "SELECT * FROM Subject";	
			$result = doQuery($query);
			$toReturn = "";
			
			if(count($result) > 0){
				while($row = $result->fetch_assoc()){
					$toReturn = $toReturn . "<option value=" . $row['SubjectId'] . ">" . $row['SubjectDescription'] . "</option>";
				}
			}
			
			return $toReturn;
			
		}
		
	}

?>