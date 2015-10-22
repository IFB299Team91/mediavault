<?php include "inc/header.php";
	
	$current_user = $_SESSION["loggedin"];

	include "inc/sql.php";

	$target_dir = "uploads/" .$current_user. "/";
	$target_file = $target_dir . basename($_FILES["datafile"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	function format_size($target_file) {

			$bytes = $target_file;

	        if ($bytes >= 1073741824)
	        {
	            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	        }
	        elseif ($bytes >= 1048576)
	        {
	            $bytes = number_format($bytes / 1048576, 2) . ' MB';
	        }
	        elseif ($bytes >= 1024)
	        {
	            $bytes = number_format($bytes / 1024, 2) . ' KB';
	        }
	        elseif ($bytes > 1)
	        {
	            $bytes = $bytes . ' B';
	        }
	        elseif ($bytes == 1)
	        {
	            $bytes = $bytes . ' B';
	        }
	        else
	        {
	            $bytes = '0 B';
	        }

	        return $bytes;
		}

		function thumb_image($imageFileType) {

			$string = $imageFileType;

			 if ($string == "jpg" | $string == "png" | $string == "gif" ) {
			 	
			 	$string = "image";

			 } else if ($string == "mov" | $string == "avi" | $string == "ogv" ) {

			 	$string = "video";

			 } else if ($string == "mp3" | $string == "ogg") {

			 	$string = "audio";

			 } else if ($string == "pdf" | $string == "doc" | $string == "docx" ) {

			 	$string = "text";

			 } 

			 return $string;
		}

	// Check if file already exists
	if (file_exists($target_file)) {
	    //echo "Sorry, file already exists. ";
	    header("refresh:.5; url=home.php");
	    $uploadOk = 0;
	}

	if (file_exists($target_dir)) {

	} else {
		mkdir("uploads/" .$current_user. "/");
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    //echo "Sorry, your file was not uploaded.";
	    header("refresh:.5; url=home.php");
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["datafile"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["datafile"]["name"]). " has been uploaded.";

	        $sql3 = "INSERT INTO files 
	        		 (user_id, filename, size, uploaded, dir, thumb)
	        		 VALUES
	        		 ('".$user_id['id']."',
	        		 ' ". basename( $_FILES['datafile']['name']). " ',
	        		 ' ".format_size(filesize($target_file))." ',
	        		 ' ".date('M j, g:i A', filemtime($target_file))." ',
	        		 ' ".$target_file." ',
	        		 ' ".thumb_image($imageFileType)." ')";

			$result3 = mysqli_query($conn, $sql3);

			header("refresh:.5; url=home.php");

	    } else {
	        //echo "Sorry, there was an error uploading your file.";
	        header("refresh:.5; url=home.php");
	    }
	}
?>

