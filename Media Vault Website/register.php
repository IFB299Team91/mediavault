<?php include "inc/header.php";

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);

	$sql = "INSERT INTO members 
			(username, password, email)
			VALUES 
			('". $username ."', '". md5($password) ."', '". $email ."')";

	$result = mysqli_query($conn, $sql); 

	if ($result) {
		header("refresh:2; url=index.php");
		echo "Registration Successful.";
    } else {	
		header("refresh:2; url=index.php");
		echo "Registration Un-Successful.";
    }
	
?>