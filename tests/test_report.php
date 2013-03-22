<?php
require_once('simpletest/autorun.php');
require_once('../libraries/reports.php');

class Test_Report extends UnitTestCase {
    function testGetSingleReport() {
		$report = getSingleReportId(24);
		
		// test 1 - getting an individual report
		$this->assertTrue($report[0]['Report'] == "<p>The sky is blue.</p>");
		
		$report = getStudentLessonsWithReports('student1');
		
		// test 2 - getting a student's reports
		$this->assertTrue(count($report) == '2');
		
		$report = getTutorLessonsNeedingReports('tutor1');
		
		// test 3 - getting a tutor's pending reports
		$this->assertTrue(count($report) == '2');
		echo(count($report));
    }
}
?>