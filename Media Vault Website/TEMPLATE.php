<?php include "inc/header.php";
	
	$current_user = $_SESSION["loggedin"];

	if (isset($current_user)) {
		
		include "inc/body.php";

		echo '
		    	<h3>Account Settings</h3>
		    </section>
		</body>
		</html>';
	}
	else {
		header("refresh:2; url=index.php");
	}

?>