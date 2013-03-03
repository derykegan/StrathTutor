<?php

	/*
		Create user form for admin - page 1.
		Selection of user type, username, password, first/last name, email address.
		
		*/
	
	include_once 'classes/pageFactory.php';
	include_once 'libraries/sql.php';
	include_once 'libraries/session.php';
	include_once 'libraries/user_check.php';
	include_once 'libraries/admin_user_new.php';
	
	// check that user is logged in, else redirect
	if(getLoggedInType() == ""){
		header("Location: index.php");
	}
	
	// check is admin, direct to index if not
	if(!validateUserType("admin")){
		header("Location: index.php");
	}
	
$createForm = ' <form method="POST" action="admin_user_new_step2.php">
 			       	
			<table class="create_user">
                <tr>
                    <td><p class="label">Please select which user type you would like to create.</p></td>
                </tr>
                <tr>
                     <td><p class="label">User Type:</p></td>
                    <td><select name="new_user_type">' . generateDropDown('userType') . '</td>
                </tr>
				<tr>
					<td><p class="label">Username:</p></td>
					<td><input type="text" name="new_user_username" required="required"></td>
				</tr>
				<tr>
					<td><p class="label">Password:</p></td>
					<td><input type="text" name="new_user_password" required="required"></td>
				</tr>
				<tr>
					<td><p class="label">First Name:</p></td>
					<td><input type="text" name="new_user_firstname" required="required"></td>
				</tr>
				<tr>
					<td><p class="label">Surname:</p></td>
					<td><input type="text" name="new_user_lastname" required="required"></td>
				</tr>
				<tr>
					<td><p class="label">Email address:</p></td>
					<td><input type="text" name="new_user_email" required="required"></td>
				</tr>
                <tr>
                    <td><input type="Submit" value="Continue" class="continueButton"></td>
                </tr>
            </table>

        </form>';
	
	// print error message if appropriate
	if($error_UserExists){
		$createForm = "<div class='errorNotice'><div class='errorText'>
		Oops! That user name already exists! Please choose a different name.
		</div></div>" . $createForm;
	}
	
	// create page factory and generate new page
	$pageFactory = new pageFactory();
	$page = $pageFactory->makeHFCookiesPage($createForm);
	
	// print page to screen
	echo($page->getPage());
	
	
	

?>