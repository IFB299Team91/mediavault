<?php

	error_reporting(E_ALL);
	session_start();

	$servername = "localhost";
	$db_username = "root"; 
	$db_password = "";	   
	$dbname = "MEDIAVAULT";

	// Try and connect to the database
	$conn = mysqli_connect($servername,$db_username,$db_password,$dbname);
	
	// If connection was not successful, handle the error
	if(!$conn) {
    	// Handle error - notify administrator, log to a file, show an error screen, etc.
		die("Connection failed: " . mysqli_connect_error());
	}

?>