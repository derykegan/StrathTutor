<?php
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/user_check.php';
	include_once 'libraries/session.php';
	
	// if user is already logged in, redirect.
	if(getLoggedInType() != ""){
		header("index.php");
		exit;
	}
	
$loginForm = <<<EOT
	
	<h1>Log in</h1>
        <form method="POST" action="libraries/authenticate.php">
 			       	
			<h2> Please log in below with your username (or email address) and password.</h2>
			<table class='login'>
                <tr>
                    <td><p class="login_label">Username:</p></td>
                    <td><input type="text" name="username" size="30"></td>
                </tr>
                <tr>
                    <td><p class="login_label">Password:</p></td>
                    <td><input type="password" name="password" size="30"></td>
                </tr>
                <tr>
                    <td><input type="Submit" value="Log in" class="loginButton"></td>
                </tr>
            </table>

        </form>
EOT;
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($loginForm);
	
	// print page to screen
	echo($page->getPage());

?>