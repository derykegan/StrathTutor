<?php
	
	include_once "header.php";
	include_once "footer.php";
	
	$printError = false;
	// check session login details
	if(isset($_SESSION['invalidLogin'])){
		if($_SESSION['invalidLogin']){
			$printError = true;
		}
		unset($_SESSION['invalidLogin']);
	}
	
$loginform = <<<EOT
	
        <form method="POST" action="libraries/authenticate.php">
 			<div class="page_Login">           	
			<p>Please log in below with your username (or email address) and password.</p>			
			<table>
                <tr>
                    <td><p>Username:</p></td>
                    <td><input type="text" name="username" size="30"></td>
                </tr>
                <tr valign="top">
                    <td><p>Password:</p></td>
                    <td><input type="password" name="password" size="30"></td>
                </tr>
                <tr>
                    <td><input type="Submit" value="Log in" ></td>
                </tr>
            </table>
			</div>
        </form>
EOT;

	// now print header and login form to client
	echo(getHeader() . "\n");
	
	// print error message if previous login was invalid
	if($printError){
		echo "<div class='errorNotice'><p>Login failed - please try again.</p></div>";
	}
	echo $loginform;
	
	// print footer
	echo(getFooter());


?>