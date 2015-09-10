<?php include "inc/header.php";
	
	$current_user = $_SESSION["loggedin"];

	$sql2 = "SELECT id, email, username 
			 FROM members 
			 WHERE username = '".$current_user."' 
			 OR email = '".$current_user."' ";

	$result2 = mysqli_query($conn, $sql2);
	$user_id = mysqli_fetch_array($result2);
	

	$sql1 = "SELECT file_id, filename, user_id, size, uploaded 
		 	 FROM files 	
		 	 WHERE user_id = '".$user_id['id']."'";

	$result = mysqli_query($conn, $sql1);

	if (isset($current_user)) {

		include "inc/body.php";

		echo '  <div class="file-table">
		            <table>
		                <thead>
		                    <tr>
		                        <th></th>

		                        <th>Name</th>

		                        <th>Size</th>

		                        <th>Modified</th>

		                        <th></th>
		                    </tr>
		                </thead>

		                <tbody>';

			        if (mysqli_num_rows($result) > 0) {
						
			        	while ($file = mysqli_fetch_array($result)) {
			                echo '
			                <tr>
			                    <td><img height="18" src="img/download.png"></td>

			                    <td>'.$file['filename'].'</td>

			                    <td>'.$file['size'].'</td>

			                    <td>'.$file['uploaded'].'</td>

			                    <td><img height="18" src="img/delete.png" onclick=""></td>
			                </tr>';
			            } 
			        } 

		echo '	    </tbody>

		                <tfoot>
		                    <tr>
		                        <td></td>
		      
		                        <td>'.mysqli_num_rows($result).' Results</td>
							
								<td></td>

		                        <td></td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </section>
		</body>
		</html>';
	}
	else {
		header("refresh:2; url=index.php");
	}

?>