    <?php
		include_once "header.php";
		include_once "sql.php";
		
		// get username and password from POST
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// TODO - save wanted page in session and then restore on login
		
		// save login state
		$loggedIn = login($username, $password);
		
		// if logged in, redirect to index
 		if($loggedIn){
			header("Location: ../index.php");
		}
		
		// not logged in, redirect to login page
		else{
			// TODO - set session flag on failed login
			header("Location: ../login.php");
		}

    ?>