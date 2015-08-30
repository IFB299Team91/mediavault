<?php include "inc/header.php";

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$sql_login = "SELECT *
				  FROM members
				  WHERE username = '". $username ."'
				  AND password = '". md5($password) ."'";



	$result_login = mysqli_query($conn, $sql_login);
	$rows = mysqli_num_rows($result_login);

	if ($rows == 1) {
	    $_SESSION['loggedin'] = $username;
	    header("refresh:2; url=home.php");
	    echo "Login Successful.";
	    
	} else {
	    header("refresh:2; url=index.php");
	    echo "Login Un-Successful.";
	}

?>