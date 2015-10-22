<?php
	
	$sql1 = "SELECT id, email, username 
			 FROM members 
			 WHERE username = '".$current_user."' 
			 OR email = '".$current_user."' ";

	$result1 = mysqli_query($conn, $sql1);
	$user_id = mysqli_fetch_array($result1);

    //
	$sql2 = "SELECT file_id, filename, user_id, size, uploaded, dir, thumb
		 	 FROM files 	
		 	 WHERE user_id = '".$user_id['id']."'";

	$result = mysqli_query($conn, $sql2);
	$result_file = mysqli_query($conn, $sql2);
	$fileid = mysqli_fetch_array($result_file);

	//
	$sql_audio = "SELECT file_id, filename, user_id, size, uploaded, dir, thumb
			 	 FROM files 	
			 	 WHERE user_id = '".$user_id['id']."'
			 	 AND thumb = ' audio '";

	$result_audio = mysqli_query($conn, $sql_audio);

	//
	$sql_text = "SELECT file_id, filename, user_id, size, uploaded, dir, thumb
			 	 FROM files 	
			 	 WHERE user_id = '".$user_id['id']."'
			 	 AND thumb = ' text '";

	$result_text = mysqli_query($conn, $sql_text);

	//
	$sql_video = "SELECT file_id, filename, user_id, size, uploaded, dir, thumb
			 	 FROM files 	
			 	 WHERE user_id = '".$user_id['id']."'
			 	 AND thumb = ' video '";

	$result_video = mysqli_query($conn, $sql_video);

	//
	$sql_image = "SELECT file_id, filename, user_id, size, uploaded, dir, thumb
			 	 FROM files 	
			 	 WHERE user_id = '".$user_id['id']."'
			 	 AND thumb = ' image '";

	$result_image = mysqli_query($conn, $sql_image);

?>