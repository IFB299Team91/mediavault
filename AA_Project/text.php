<?php 	include "inc/header.php";

		$current_user = $_SESSION["loggedin"];

		include "inc/sql.php";

		if (isset($current_user)) {

			include "inc/body.php"; ?>

				<div class="file-table">
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
				<tbody>
<?php 	
			if (mysqli_num_rows($result) > 0) {
				while ($file = mysqli_fetch_array($result_text)) {
					include "inc/functions.js";
?>		
					<tr>
						<td><img src="img/<?php echo trim($file['thumb']) ?>.png" height="12"></td>
						<td><a onclick="a<?php echo $file['file_id'] ?>()" href="#"><?php echo $file['filename'] ?></a></td>
						<td><?php echo $file['size'] ?></td>
						<td><?php echo $file['uploaded'] ?></td>
						<td class="contact-delete">
							<form action="delete.php?id="<?php echo $file['file_id'] ?>"" method="post">
								<a onclick="c<?php echo $file['file_id'] ?>()" href="#">
									<input type="button" name="share" value="Share" onclick="ShowShare()">
								</a>
								<a href="<?php echo $file['dir'] ?>" download>
									<input type="button" name="download" value="Download">
								</a>
								<a onclick="d<?php echo $file['file_id'] ?>()" href="#">
									<input type="button" name="edit" value="Edit" onclick="ShowEdit()">
								</a>
								<input type="hidden" name="name" value="<?php echo $file['file_id'] ?>">
								<input type="submit" name="delete" value="Delete">
							</form>
						</td>
					</tr>
 <?php
				} 
			} 
?>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td><?php echo mysqli_num_rows($result_text) ?> Results</td>
						<td></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>
</body>
</html> 
<?php
}
	else {
	header("refresh:2; url=index.php");
}
?>