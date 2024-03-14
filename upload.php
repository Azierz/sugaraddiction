<?php
$page_title = 'Photo Upload';
$page_text = 'Photo Upload';
include ('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	require ('includes/constants.php');

	$errors = array(); // Initialize error array.

	$target_dir = "includes/images/"; // tempat simpan gambar
	$target_file = basename($_FILES["fileToUpload"]["name"]); // nama gambar
	$target_upload = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1; // file okay untuk upload ke db
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // lowercase nama file

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$errors[] = "Your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_upload)) { // save gambar dalam folder

			$id = $_POST["pID"];
			
			$query = "UPDATE product SET Image = '$target_file' WHERE ProductID = '$id'";
			$result = mysqli_query ($dbc, $query);

			$success = 1;
			
		} else {
			$errors[] = "There was an error uploading your file.";
		}
	}

	if ($errors) {
		echo '<h1>Error!</h1>
		<div id ="errors">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {
			echo " - $msg<br/>";
		}
		echo '</div>
		<div id = "errors">Please try again.</div>'; // Close div "errors"

	} elseif ($success == 1) {
		
		echo '<h1>Success!</h1>
		<div id ="success"><br/>';
		echo "New photo has been uploaded.<br/>";
		echo '</div><br>
		<div class="btn-group">
			<button align="right"><a href="edit_product.php?id='.$id.'">Back to Edit Product</a></button>
		</div>
		<br><br><br>'; // Close div "success"
		include ('includes/footer.html');
		exit();
	}
}
?>

<h1>Photo Upload</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
	<input type="text" name="pID" value="<?php echo $_GET["id"] ?>" hidden>
	<table style="font-size: 100%">
		<tr>
			<td><p style="size: 100%">Select image to upload</p></td>
			<td><p><input type="file" name="fileToUpload" id="fileToUpload"></p></td>
		</tr>
	</table>
	<p align="right"><input type="submit" value="Upload Image" name="submit"></p>
</form>

<?php
include ('includes/footer.html');
?>