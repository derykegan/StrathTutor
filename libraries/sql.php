<?php
	// Class to deal with MySQL interaction.
	
	// mysql settings
	$db_username = "rmb09188";
	$db_password = "ersterys";
	$db_hostname = "localhost";
	$db_name = "rmb09188";

	// connect to database server
	$connect = mysql_connect($db_hostname, $db_username, $db_password)
    		or die('Connection error: ' . mysql_error());

	// and then supplied database
	mysql_select_db($db) or die('Could not select database' . mysql_error());

	// connected.


?>
