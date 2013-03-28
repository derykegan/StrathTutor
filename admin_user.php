<?php
	/*
		Admin user view - shows all user on system, gives
		option to add new users.
		
		*/
		
	// import session and header
	include_once 'libraries/admin_sql.php';
	include_once 'libraries/user_check.php';
	include_once 'classes/pageFactory.php';
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
	// heredoc for page content
$sitePage = <<<EOT
	
	<br />
	<h1>Users</h1>
	<h2>Select a user to edit.</h2>
	<br />
    
EOT;
	
	// now generate table
	$users = getUserList();
	$sitePage = $sitePage . '<a class = "pageButton" href="admin_user_new_step1.php">Add New User</a><br />
	<div class="tableContainer"><table class="twoCol">'
		. '<tr class = "tableHeader">'
		. '<td>Username</td>'
		. '<td>User Type</td>'
		. '<td>Full Name</td>'
		. '<td>User ID</td>';
	
	$size = count($users);
	for($i = 0; $i < $size; $i++){
		
		if($i % 2){
			$sitePage = $sitePage . ('<tr class = "odd">' . '<td class = "odd">' . $users[$i]["username"] . 
			'<td class = "even">'. $users[$i]["userType"] . '<td class = "odd">' . $users[$i]["firstname"] . " " .
			$users[$i]["lastname"] . '<td class = "even">'. $users[$i]["user_id"] . '</tr>');
		}
		else{
			$sitePage = $sitePage . ('<tr class = "even">' . '<td class = "odd">' . $users[$i]["username"] . 
			'<td class = "even">'. $users[$i]["userType"] . '<td class = "odd">' . $users[$i]["firstname"] . " " .
			$users[$i]["lastname"] . '<td class = "even">'. $users[$i]["user_id"] . '</tr>');
		}
	}
	$sitePage = $sitePage . ('</table></div>');
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($sitePage);
	
	// print page to screen
	echo($page->getPage());
	
?>
