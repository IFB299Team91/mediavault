<?php include "inc/header.php";
	
	$current_user = $_SESSION["loggedin"];

	include "inc/sql.php";

	$result4 = mysqli_query($conn, $sql4);

	header("refresh:0; url=home.php");
?>