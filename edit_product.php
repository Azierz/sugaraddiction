<?php
$page_title = 'Product Edit';
$page_text = 'Product Edit';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$eID = $_POST['edit'];
	$eName = $_POST['name'];
	$ePrice = $_POST['price'];
	$eQty = $_POST['quantity'];
	$eDesc = $_POST['desc'];

	require ('includes/constants.php');

	$q = "UPDATE product SET Name='$eName', Price='$ePrice', Quantity='$eQty', Description='$eDesc' WHERE ProductID=$eID LIMIT 1";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_affected_rows($dbc) == 1) {
		echo '<script>
		window.alert("\nSUCCESS!\nProduct has been updated.");
		setTimeout(function(){location.href="maintenance.php"},0);
		</script>';
	} else {
		echo '<script>
		window.alert("\ERROR!\nProduct cannot not be updated.\nPlease try again later.");
		setTimeout(function(){location.href="maintenance.php"},0);
		</script>';
	}
}

?>

<h1>Product Edit</h1>

<div class="menudetails">
	<div class="row">
	  	<div class="column">
		<table>
			<?php
			require ('includes/constants.php');

			$ProductID = $_GET["id"];
			
			$q = "SELECT * FROM product WHERE ProductID='$ProductID'";
			$r = @mysqli_query ($dbc,$q);
			
			if (!mysqli_num_rows($r) == 1) {
				echo '<tr><td colspan="3">PRODUCT OUT OF STOCK</td></tr>';
			} else {
			while ($data = mysqli_fetch_array($r)) {
				echo '
				<form action="edit_product.php" method="POST">
				<tr>
					<td>';
					if (!isset($data["Image"])) {
						echo '<img src="includes/images/image_na.png"/>';
					} else {
						echo '<img src="includes/images/'.$data["Image"].'"/>';
					};
					echo '</td>
					<tr>
						<td><div class="btn-group">
							<button><a href="upload.php?id='.$data['ProductID'].'">Change Photo</a></button>
						</div></td>
					</tr>
					
					</table>
					</div>
					
					<div class="column">
					<table>
						<tr>
							<th colspan="2">Fruit Name:<input type="text" name="name" value="'.$data["Name"].'" required></th>
						</tr>
						<tr>
							<th>Price(RM): <input type="text" name="price" value="'.$data["Price"].'" size="5" required></th>
							<th>Quantity:<input type="text" name="quantity" value="'.$data["Quantity"].'" size="5" required></th>
						</tr>
						<tr>
							<th colspan="2">FRUIT DESCRIPTION: <br><input type="text" name="desc" value="'.$data["Description"].'" required></th>
						</tr>
						<tr>
						<td colspan="2">
							<input type="text" name="edit" value="'.$data["ProductID"].'" hidden>
							<input type="submit" name="submit" value="Confirm Changes" />
						</td>
						</tr>
						</form>
					</table>
					</div>';
			}}
			?>
	</div>
</div>
<?php
include ('includes/footer.html');
?>
