<?php include "inc/header.php";
	session_destroy();
	header("refresh:2; url=index.php");
	echo 'Successfully Logged Out';
?>