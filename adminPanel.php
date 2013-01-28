<?php
	// import session and header
	include_once 'header.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// print header
	echo(getHeader() . "\n");
	
	// heredoc for page content
$adminPage = <<<EOT
	
	<br />
	<div class = 'panelTitle'>Administration</div>
	<div class = 'panelText'>Please select an option below to begin configuration.</div>
	<br />
	<div class = 'panelOption'><a href='admin_user.php'>User Management</a></div>
	<div class = 'panelOption'><a href='admin_subject.php'>Subject Management</a></div>
	<div class = 'panelOption'><a href='admin_site.php'>Site Configuration</a></div>
    
EOT;
	
	// print admin page
	echo($adminPage);
	
?>
