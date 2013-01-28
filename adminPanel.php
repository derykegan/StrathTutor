<?php
	// import session and header
	include_once 'header.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	include_once 'footer.php';
	
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
	<div><a class = 'panelOption'href='admin_user.php' title='Add, edit or remove users.'>Users</a></div>
	<div><a class = 'panelOption'href='admin_subject.php' title='Add, edit or remove subjects.'>Subjects</a></div>
	<div><a class = 'panelOption'href='admin_pages.php' title='Edit page content, eg About or Welcome.'>Pages</a></div>
	<div><a class = 'panelOption'href='admin_site.php' title='Change options to personalise the site.'>Site Configuration</a></div>
    
EOT;
	
	// print admin page
	echo($adminPage);
	
	// print footer
	echo(getFooter());
	
?>
