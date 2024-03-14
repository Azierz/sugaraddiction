<?php
$page_title = 'Menu Details';
$page_text = 'Menu Details';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$CartID = $_POST['cart'];
	$CartQty = $_POST['qty'];
	$CartSize = $_POST['cake_size'];
	$CartSms = $_POST['sms'];

	require ('includes/constants.php');

	$q = "SELECT * FROM product WHERE ProductID='$CartID'";
	$r = @mysqli_query ($dbc,$q);

	if (!mysqli_num_rows($r) == 1) {
		echo '<script>
		window.alert("\nERROR!\nPlease try again later.");
		setTimeout(function(){location.href="menu.php"},0);
		</script>';
	} else {
		if ($CartSize == "7 Inch (1KG)") {
			// For Cake Size 7 inch (1KG)
			$i = $_POST["cart"];
			$qty = $_SESSION["qty1"][$i] + $CartQty;
			$_SESSION["amounts1"][$i] = $amounts[$i] * $qty;
			$_SESSION["cart1"][$i] = $i;
			$_SESSION["qty1"][$i] = $qty;
			$_SESSION["cakesize1"][$i] = $CartSize;

			if (!empty($CartSms)) {
				$_SESSION["sms1"][$i] = $CartSms;
			} else {
				$_SESSION["sms1"][$i] = null;
			}
			

		} else {
			// For Cake Size 9 inch (2KG)
			$j = $_POST["cart"];
			$qty = $_SESSION["qty2"][$j] + $CartQty;
			$_SESSION["amounts2"][$j] = $amounts[$j] * $qty;
			$_SESSION["cart2"][$j] = $j;
			$_SESSION["qty2"][$j] = $qty;
			$_SESSION["cakesize2"][$j] = $CartSize;

			if (!empty($CartSms)) {
				$_SESSION["sms2"][$j] = $CartSms;
			} else {
				$_SESSION["sms2"][$j] = null;
			}
			
		}
		

		echo '<script>
		window.alert("\nSUCCESS!\nProduct added to cart.");
		setTimeout(function(){location.href="menu.php"},0);
		</script>';
	}
}
?>

<h1>Sugar Addiction Menu Details</h1>

<div class="menudetails">
	<div class="row">

	  	<div class="column">
		<table>
			<?php
			require ('includes/constants.php');

			$ProductID = $_GET["ProductID"];
			
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
					<form action="menudetails.php" method="POST">
					

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
							<td>
									Cake Size:<br><br>
									<input type="radio" id="7inch" name="cake_size" value="7 Inch (1KG)" required>
									<label for="7inch">7 Inch (1KG)</label><br>
									<input type="radio" id="9inch" name="cake_size" value="9 Inch (2KG)">
									<label for="9inch">9 Inch (2KG)</label><br>
							</td>
							<td>Quantity:<br><br><input type="number" name="qty" size=5 value="1" min=1 max=999></td>
						</tr>
						<tr>
							<td colspan="2">Personalized Message (Optional):<br><br><textarea name="sms" rows="4" cols="30"></textarea></td>
						</tr>
						<tr>
							<input type="text" name="cart" value="'.$data["ProductID"].'" hidden>
							<td colspan="2"><input type="submit" name="submit" value="Add To Cart" /></td>
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
