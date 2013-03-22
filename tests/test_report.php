<?php
require_once('simpletest/autorun.php');
require_once('../libraries/reports.php');

class Test_Report extends UnitTestCase {
    function testGetSingleReport() {
		$report = getSingleReportId(24);
		echo("Testing single report<br/>");
		// test 1 - getting an individual report
		$this->assertTrue($report[0]['Report'] == "<p>The sky is blue.</p>");
		
    }
	
	function testGetStudentReports(){
		$report = getStudentLessonsWithReports('student1');
		echo("Testing student reports (student1)<br/>");
		// test 2 - getting a student's reports
		$this->assertTrue(count($report) == '2');
	}
	
	function testGetTutorReports(){
		$report = getTutorLessonsNeedingReports('tutor1');
		echo("Testing tutor reports (tutor1)<br/>");
		// test 3 - getting a tutor's pending reports
		$this->assertTrue(count($report) == '0');
	}
}
?>