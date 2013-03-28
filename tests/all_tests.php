<?php
require_once('simpletest/autorun.php');

/**
	A suite of unit tests for StrathTutor using SimpleTest.
	Runs all individual unit tests.
	
	*/

class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
		// login tests
		$this->addFile('test_login.php');
		
		// lesson testing
        $this->addFile('test_lessons.php');
		
		// report testing
        $this->addFile('test_report.php');
		
		// admin testing
        $this->addFile('test_admin.php');
    }
}
?>
