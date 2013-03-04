<?php
	// Class to deal with MySQL interaction for creating a new user.
	
	include_once 'sql.php';
	
	// returns user types as an associative array
	function getSystemUserTypes(){
		$query = 'SELECT * FROM UserType';
		$result = doQuery($query);
		
		return $result;
	}
	
	// generates drop down options depending on type
	function generateDropDown($type){
		
		$typeArray = array('userType');
		
		// if given option isn't predefined, return nothing
		if(!in_array($type, $typeArray)){
			return "";
		}
		
		// possible user types
		if($type == 'userType'){
			
			$result = getSystemUserTypes();
			$toReturn = "";
			
			if(count($result) > 0){
				while($row = $result->fetch_assoc()){
					$toReturn = $toReturn . "<option value=" . $row['userType'] . ">" . $row['typeDescription'] . "</option>";
				}
			}
			
			return $toReturn;
			
		}
		
		
		
	}
	
	// creates a new admin user
	function createNewAdmin($username, $password, $firstname, $lastname, $email, $address1, $address2, $address3, $postcode, $homePhone, $mobilePhone){
		
		$query = "INSERT INTO User(username, password, firstname, lastname, userType, email, address1, address2, address3, postcode, phone_home, phone_mobile)
		VALUES('$username', '$password', '$firstname', '$lastname', 'admin', '$email', '$address1', '$address2', '$address3', '$postcode', '$homePhone', '$mobilePhone')";
		
		doQuery($query);
		
	}
	
	// creates a new tutor user
	function createNewTutor($username, $password, $firstname, $lastname, $email, $address1, $address2, $address3, $postcode, $homePhone, $mobilePhone){
		
		$query = "INSERT INTO User(username, password, firstname, lastname, userType, email, address1, address2, address3, postcode, phone_home, phone_mobile)
		VALUES('$username', '$password', '$firstname', '$lastname', 'tutor', '$email', '$address1', '$address2', '$address3', '$postcode', '$homePhone', '$mobilePhone')";
		
		doQuery($query);
		
	}
	
	// creates a new student user - own parent
	function createNewStudent($username, $password, $firstname, $lastname, $email, $address1, $address2, $address3, $postcode, $homePhone, $mobilePhone, $isOwnParent){
		
		// populate User table
		$query = "INSERT INTO User(username, password, firstname, lastname, userType, email, address1, address2, address3, postcode, phone_home, phone_mobile)
		VALUES('$username', '$password', '$firstname', '$lastname', 'student', '$email', '$address1', '$address2', '$address3', '$postcode', '$homePhone', '$mobilePhone')";
		
		doQuery($query);
		
		// get user ID
		$id = getIdFromUsername($username);
		
		if($isOwnParent){
			// populate UserStudent
			$query = "INSERT INTO UserStudent(user_id, isOwnParent, parentID)
			VALUES('$id', '1', '0')";
		}
		else{
			// populate UserStudent
			$query = "INSERT INTO UserStudent(user_id, isOwnParent, parentID)
			VALUES('$id', '0', '-1')";
		}
		
		doQuery($query);
		
	}
	
	// creates a new tutor user
	function createNewParent($username, $password, $firstname, $lastname, $email, $address1, $address2, $address3, $postcode, $homePhone, $mobilePhone, $studentName){
		
		// populate User
		$query = "INSERT INTO User(username, password, firstname, lastname, userType, email, address1, address2, address3, postcode, phone_home, phone_mobile)
		VALUES('$username', '$password', '$firstname', '$lastname', 'parent', '$email', '$address1', '$address2', '$address3', '$postcode', '$homePhone', '$mobilePhone')";
		
		doQuery($query);
		
		if(!empty($studentName)){
			// if there is a student name provided, update UserStudent
			$id = getIdFromUsername($username);
			$studentId = getIdFromUsername($studentName);
			$query = "UPDATE UserStudent
			SET user_id='$studentId', isOwnParent='0', parentId='id')";
			doQuery($query);
		}
		
	}
	
	
	

?>
