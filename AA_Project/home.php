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

								var strAudio = "'.$file['filename'].'"; 
								var resAudio = strAudio.match(/(.ogg|.mp3)/g);

								if (strAudio.match(resAudio) ) {
								  // There was a match.				
									document.getElementById("player").src="'.$file['dir'].'";
									document.getElementById("player").load();
									document.getElementById("player").play();
								} else {
								  // No match.
								} 

								var strImage = "'.$file['filename'].'"; 
								var resImage = strImage.match(/(.gif|.jpg|.png)/g);

								if (strImage.match(resImage) ) {
								  // There was a match.
									document.getElementById("imagebox").style.display="block";	
									document.getElementById("imageholder").src="'.$file['dir'].'";	
	
								} else {
								  // No match.
								} 

							}

					        function FileImage() {
					            var strimg = "'.$file['filename'].'"; 
					            var resimg = strimg.match(/(.gif|.jpg|.png)/g);
					            var resvid = strimg.match(/(.mov|.ogv|.avi)/g);
					            var resaud = strimg.match(/(.ogg|.mp3|.m4a)/g);

					            if (strimg.match(resimg) ) {
					                document.getElementById("'.$file['file_id'].'").src="img/photo.png";
					            } else if (strimg.match(resaud) ) {
					                document.getElementById("'.$file['file_id'].'").src="img/audio.png";
					            } else if (strimg.match(resvid) ) {
					                document.getElementById("'.$file['file_id'].'").src="img/video.png";
					            } else {

					            }
					        }
							</script>

			                <tr>
			                	<td><img height="14" id="'.$file['file_id'].'" onload="FileImage()" src="img/photo.png"></a></td>

			                    <td><a onclick="a'.$file['file_id'].'()" href="#">'.$file['filename'].'</a></td>

			                    <td>'.$file['size'].'</td>

			                    <td>'.$file['uploaded'].'</td>

			                    <td>
			                    <a href="'.$file['dir'].'" download><img height="18" src="img/download.png"></a>
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