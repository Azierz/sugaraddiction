<?php
$page_title = 'Product Deletion';
$page_text = 'Product Deletion';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if($_POST['con_del'] == "yes") {

		$DelID = $_POST['delete'];

		require ('includes/constants.php');

		$q = "DELETE FROM product WHERE ProductID='$DelID' LIMIT 1";
		$r = @mysqli_query ($dbc,$q);

		if (mysqli_affected_rows($dbc) == 1) {
			echo '<script>
			window.alert("\nSUCCESS!\nProduct has been deleted.");
			setTimeout(function(){location.href="maintenance.php"},0);
			</script>';
		} else {
			echo '<script>
			window.alert("\ERROR!\nProduct cannot not be deleted.\nPlease try again later.");
			setTimeout(function(){location.href="maintenance.php"},0);
			</script>';
		}

	} else {
		echo '<script>
		window.alert("\CONFIRMED!\nProduct will not be deleted.");
		setTimeout(function(){location.href="maintenance.php"},0);
		</script>';
	}
	
	
}
?>

<h1>Product Deletion</h1>

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
				<tr>
					<td>';
					if (!isset($data["Image"])) {
						echo '<img src="includes/images/image_na.png"/>';
					} else {
						echo '<img src="includes/images/'.$data["Image"].'"/>';
					};
					echo '</td>
					<tr>
						<td>'.$data["Description"].'</td>
					</tr>
					</table>
					</div>
					
					<div class="column">
					<table>
						<tr>
							<th colspan="2">'.$data["Name"].'</th>
						</tr>
						<tr>
							<td colspan="2">Price: RM '.$data["Price"].'</td>
						</tr>
						<tr>
							<td>Quantity Left:<br><br>'.$data["Quantity"].'</td>
							<td>
							<form action="delete_product.php" method="POST">
								<p> Confirm delete this product? </p>
								<input type="radio" name="con_del" value="yes"> Yes
								<input type="radio" name="con_del" value="no"> No
								<input type="text" name="delete" value="'.$data["ProductID"].'" hidden>
								<input type="submit" name="submit" value="Confirm" />
							</form>
							</td>
						</tr>
					</table>
					</div>';
			}}
			?>
	</div>
</div>
<?php
include ('includes/footer.html');
?>
