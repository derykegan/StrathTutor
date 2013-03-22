<?php
require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');
SimpleTest::prefer(new TextReporter());

class Test_Login extends WebTestCase {
	
	function setUp(){
		$this->get('https://devweb2012.cis.strath.ac.uk/~rmb09188/login.php');
	}
	
	function tearDown(){
		$this->restart();
	}
	
	// tests logging in as a student
    function testStudentLogin() {
		echo("Testing student login... <br/>");
		$this->assertField('username', '');
        $this->setField('username', 'student1');
		$this->setField('password', 'test');
        $this->click("Log in");
		$this->assertText('Student WithParent1');
		$this->assertLink("View Lessons");
    }
	
	// tests logging in as a tutor
    function testTutorLogin() {
		echo("Testing tutor login... <br/>");
		$this->assertField('username', '');
        $this->setField('username', 'tutor1');
		$this->setField('password', 'test');
        $this->click("Log in");
		$this->assertText('Tutor Test1');
		$this->assertLink("Lesson Booking");
    }
	
	// tests logging in as a parent
    function testParentLogin() {
		echo("Testing parent login... <br/>");
		$this->assertField('username', '');
        $this->setField('username', 'parent1');
		$this->setField('password', 'test');
        $this->click("Log in");
		$this->assertText('Parent Test1');
		$this->assertLink("Reports");
    }
	
	// tests logging in as an admin
    function testAdminLogin() {
		echo("Testing admin login... <br/>");
		$this->assertField('username', '');
        $this->setField('username', 'test');
		$this->setField('password', 'test');
        $this->click("Log in");
		$this->assertText('test user');
		$this->assertLink("Users");
    }
}
?>