<?php include "inc/header.php";
	
	$current_user = $_SESSION["loggedin"];

	include "inc/sql.php";

	$sql_rename = "UPDATE files
			  	   SET filename = '".$_POST['filename']."'
			   	   WHERE file_id = '".$_POST['file_id']."'";

	mysqli_query($conn, $sql_rename);

	header("refresh:.5; url=home.php");

?>