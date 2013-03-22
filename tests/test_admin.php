<?php
require_once('simpletest/autorun.php');
require_once('../libraries/admin_sql.php');

class Test_Admin extends UnitTestCase {
    function testGetSettings() {
		$settings = getSiteSettings();
		echo("Testing site settings...<br/>");
		$this->assertTrue(count($settings[0]) == 3);
    }
	
	function testGetAdminLog(){
		$log = getAdminLog();
		echo("Testing admin event log...<br/>");
		$this->assertTrue(count($log[0]) == 5);
	}
	
	function testGetPages(){
		$pages = getSitePages();
		echo("Testing site pages...<br/>");
		$this->assertTrue(count($pages[0]) == 3);
	}
	
	function testGetSubjects(){
		$subjects = getSubjects();
		echo("Testing subjects...<br/>");
		$this->assertTrue(count($subjects[0]) == 4);
	}
}
?>