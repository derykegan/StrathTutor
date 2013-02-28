<?php
	// Class to deal with MySQL interaction for reports
	
	include_once 'sql.php';
	
	// returns the report for id
	function getSingleReportId($lessonId){
		$lessonId = escapeQuery($lessonId);
		$query = "SELECT L.subject_id, L.tutor_id AS Tutor, L.student_id AS Student, LR.reportText AS Report
			FROM Lessons AS L 
			INNER JOIN Subject ON L.subject_id = Subject.SubjectId
			INNER JOIN User AS U1 ON L.tutor_id = U1.user_id
			INNER JOIN User AS U2 ON L.student_id = U2.user_id
			INNER JOIN LessonStatus AS LS ON L.status = LS.statusName
			INNER JOIN LessonReports AS LR ON L.lesson_id = LR.lesson_id
			WHERE L.lesson_id = '$id'";
		
		$result = doQuery($query);
		
		// save query results in an array
		$result_array = array();
		while($row = mysqli_fetch_assoc($result))
		{
    		$result_array[] = $row;
		}
		
		return $result_array;
	}

?>
