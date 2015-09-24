<?php include "inc/header.php";

	$current_user = $_SESSION["loggedin"];

	include "inc/sql.php";



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

							<script>
							function a'.$file['file_id'].'() {
							document.getElementById("videoplayer").src="'.$file['dir'].'";
							document.getElementById("videoplayer").load();
							document.getElementById("videoplayer").play();
							}
							</script>

			                <tr>
			                	<td><img height="14" id="'.$file['file_id'].'" src="img/play.png"></a></td>

			                    <td><a onclick="a'.$file['file_id'].'()" href="#">'.$file['filename'].'</a></td>

			                    <td>'.$file['size'].'</td>

			                    <td>'.$file['uploaded'].'</td>

			                    <td>
			                    <a href="'.$file['dir'].'"><img height="18" src="img/download.png"></a>
			                    <a href="delete.php?id='.$file['file_id'].'"><img height="18" src="img/delete.png"></a>
			                    </td>
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