<?php
	$sql2 = "SELECT id, email, username 
			 FROM members 
			 WHERE username = '".$current_user."' 
			 OR email = '".$current_user."' ";

	$result2 = mysqli_query($conn, $sql2);
	$user_id = mysqli_fetch_array($result2);

	$sql1 = "SELECT file_id, filename, user_id, size, uploaded, dir 
		 	 FROM files 	
		 	 WHERE user_id = '".$user_id['id']."'";

	$result = mysqli_query($conn, $sql1);
	

	$result_file = mysqli_query($conn, $sql1);
	$fileid = mysqli_fetch_array($result_file);
	


	$sql4 = "DELETE FROM files
			 WHERE file_id = '".$fileid['file_id']."'";

	?>