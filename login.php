<?php
	
	include_once 'classes/pageFactory.php';
	
	$printError = false;
	// check session login details
	if(isset($_SESSION['invalidLogin'])){
		if($_SESSION['invalidLogin']){
			$printError = true;
		}
		unset($_SESSION['invalidLogin']);
	}
	
$loginForm = <<<EOT
	
        <form method="POST" action="libraries/authenticate.php">
 			       	
			<div class="page_Login"> Please log in below with your username (or email address) and password.</div>
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
	
	// print error message if previous login was invalid
	if($printError){
		$loginForm = "<div class='errorNotice'><p>Login failed - please try again.</p></div>" . $loginForm;
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($loginForm);
	
	// print page to screen
	echo($page->getPage());

?>