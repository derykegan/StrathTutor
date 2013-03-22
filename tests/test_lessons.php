<?php
require_once('simpletest/autorun.php');
require_once('../libraries/lessons.php');

class Test_Lessons extends UnitTestCase {
    function testGetStudentLessons() {
		// all of student1's lessons
		$lessons = getStudentLessons("student1", "all");
		echo("Testing student lessons (student1, all) ...<br/>");
		
		// check the time of the oldest lesson is valid
		$this->assertTrue($lessons[count($lessons) - 1]['startTime'] == "2013-02-17 14:00:00");
    }
	
	 function testGetTutorLessons() {
		// all of tutor1's lessons
		$lessons = getTutorLessons("tutor1", "all");
		echo("Testing tutor lessons (tutor1, all) ...<br/>");
		
		// check the time of the oldest lesson is valid
		$this->assertTrue($lessons[count($lessons) - 1]['startTime'] == "2013-01-01 17:00:00");
    }
	
	 function testGetParentLessons() {
		// all of student1's lessons
		$lessons = getParentLessons("parent1", "all");
		echo("Testing parent lessons (parent1, all) ...<br/>");
		
		// check the time of the oldest lesson is valid
		$this->assertTrue($lessons[count($lessons) - 1]['startTime'] == "2013-02-17 14:00:00");
    }
	
}
?>