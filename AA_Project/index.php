<?php include "inc/header.php";

	if (!isset($_SESSION['loggedin'])) {
	    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta content="initial-scale=1.0" name="viewport">
            <meta charset="utf-8”">
            <link href="css/style.css" rel="stylesheet" type="text/css">

            <title>Media Vault</title>
        </head>

        <body>
            <section>
                <div class="userform">
                    <h2>Media Vault</h2>

                    <form action="login.php" method="post">
                        <p><input id="username" name="username" placeholder=
                        "Username or Email" type="text" value=""></p>

                        <p><input id="password" name="password" placeholder="Password"
                        type="password" value=""></p>

                        <p><button class="submit">Submit</button></p>
                    </form><a class="register" href="registration.php">Register?</a>
                </div>
            </section>
        </body>
        </html>';

	} else {
		header("refresh:0; url=home.php");
	}
	
?>