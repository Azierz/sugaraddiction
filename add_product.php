<?php
$page_title = 'Add New Product';
$page_text = 'Add New Product';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$aName = $_POST['name'];
	$aPrice = $_POST['price'];
	$aDesc = $_POST['desc'];

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

			$query = "INSERT INTO product VALUES (0, '$aName', '$target_file', '$aPrice', 0, '$aDesc')";
			$result = mysqli_query ($dbc, $query);

			$success = 1;
			
		} else {
			$errors[] = "There was an error uploading your product image.";
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
		
		echo '<script>
		window.alert("\nSUCCESS!\nA new product has been uploaded.");
		setTimeout(function(){location.href="maintenance.php"},0);
		</script>';
	}
}?>

<h1>Add New Product</h1>
<form action="add_product.php" method="post" enctype="multipart/form-data">
	<table border="0" id="reg">
		<tr>
			<td>Sweet Name:</td>
			<td><input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required /></td>
		</tr>
		<tr>
			<td>Sweet Price(RM):</td>
			<td><input type="text" name="price" size="10" maxlength="20" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" required /></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td><input type="text" name="desc" size="40" maxlength="100" value="<?php if (isset($_POST['desc'])) echo $_POST['desc']; ?>" required /></td>
		</tr>
		<tr>
			<td>Sweet Image:</td>
			<td><input type="file" name="fileToUpload" id="fileToUpload"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Add Sweet" /></td>
		</tr>
	</table>
</form>
<?php
include ('includes/footer.html');
?>
