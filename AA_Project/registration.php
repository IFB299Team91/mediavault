<?php include "inc/header.php"; 

	if (isset($_SESSION['loggedin'])) {
		echo 'You are already a registered user, ' . $_SESSION['loggedin'] . '.';
		header("refresh:2; url=index.php");
	} else {
?>
		<!DOCTYPE html>
		<html>
		<head>
		    <meta content="initial-scale=1.0" name="viewport">
		    <link href="css/style.css" rel="stylesheet" type="text/css">
		    <meta charset="”UTF-8”">

		    <title>Register</title>
		</head>

		<body>
		    <section>
		        <div class="userform">
		            <h2>Register an account</h2>

		            <form action="register.php" method="post">
		                <p><input id="username" name="username" placeholder=" Username"
		                type="text" value=""></p>

		                <p><input id="email" name="email" placeholder=" Email" type=
		                "text" value=""></p>

		                <p><input id="password" name="password" placeholder=" Password"
		                type="password" value=""></p>

		                <p><button class="submit">Submit</button></p>
		            </form><a class="register" href="index.php">Return</a>
		        </div>
		    </section>
		</body>
		</html>
<?php 
	}
?>