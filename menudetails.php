<?php
$page_title = 'Menu Details';
$page_text = 'Menu Details';
include ('includes/header.php');


if (empty($_SESSION['CustID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$CartID = $_POST['cart'];
	$CartQty = $_POST['qty'];
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
		
		
			$i = $_POST["cart"];
			$qty = $_SESSION["qty"][$i] + $CartQty;
			$_SESSION["amounts"][$i] = $amounts[$i] * $qty;
			$_SESSION["cart"][$i] = $i;
			$_SESSION["qty"][$i] = $qty;

			if (!empty($CartSms)) {
				$_SESSION["sms"][$i] = $CartSms;
			} else {
				$_SESSION["sms"][$i] = null;
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
							<td colspan="2">Quantity:<br><br><input type="number" name="qty" size=5 value="1" min=1 max=999></td>
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
