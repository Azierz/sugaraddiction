<?php
$page_title = 'Shopping Cart';
$page_text = 'Shopping Cart';
include ('includes/header2.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if($_POST['Pmethod'] == 'Online') {
		$_SESSION['method'] = 1;
		header("Location:payment.php");
	} else {
		$_SESSION['method'] = 0;
		header("Location:checkout.php");
	}
}
?>

<h1>Sugar Addiction Cart</h1>

		<div class="menu">
			<table border="1">
				<tr>
					<th>Product(s)</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Personalized Message</th>
					<th>Total</th>
					<th>Action(s)</th>
				</tr>
				<?php
				require ('includes/constants.php');

				if (empty($_SESSION["cart"])) {
					echo '
						<script>
						window.alert("\nShopping Cart Empty!");
						setTimeout(function(){location.href="menu.php"},0);
						</script>';
				}
					
				$TotalPayment = 0;
				if(!empty($_SESSION["cart"])){
				foreach($_SESSION['cart'] as $cart => $val) {
					
					$ProdID = $val;
					$Qty = $_SESSION['qty'][$val];
					$Sms = $_SESSION["sms"][$val];

					$q = "SELECT * FROM product WHERE ProductID='$ProdID'";
					$r = @mysqli_query ($dbc,$q);

					if (mysqli_num_rows($r) == 1) {
						
					while ($data = mysqli_fetch_array($r)) {
						
						$Price = $data['Price'];
						$TotalPrice = number_format((double)$Qty*$Price, 2 ,'.', ',');
						$TotalPayment = number_format((double)$TotalPayment+$TotalPrice, 2 ,'.', ',');

						echo "
						<tr>
							<td style=\"border-bottom: 0px\">";
							if (!isset($data['Image'])) {
								echo "<img src=\"includes/images/image_na.png\"";
							} else {
								echo "<img src=\"includes/images/".$data['Image']."\"";
							};
							echo "</td>
							<td rowspan='2'>RM ".$Price."</td>
							<td rowspan='2'>".$Qty."</td>
							<td rowspan='2'>".$Sms."</td>
							<td rowspan='2'>RM ".$TotalPrice."</td>
							<td rowspan='2'>";
							$dt = $data["ProductID"];
							// TO BE CONFIRMED LATER HOW TO EDIT CART AFTER ADD TO CART
							echo '
							<form action="menudetails.php" method="GET">
								<input type="text" name="ProductID" value="'.$data["ProductID"].'" hidden>
								<input type="submit" name="submit" value="More Details" />
							</form>';
							echo "</td>
						</tr>
						<tr>
							<td style=\"border-top: 0px\">".$data['Name']."</td>
						</tr>
						";
					}} 
				}}

				
				?>
			 </table>
			
			<table>
				<tr>
					<th style="text-align: left; border: 0px">DELIVERY ADDRESS</th>
				</tr>
				<tr>
					<td style="text-align: left"><?php echo $_SESSION['Address']; ?></td>
				</tr>
			</table>
			<form action="cart.php" method="POST">
			<table>
				<tr>
					<th style="text-align: left; border: 0px">TOTAL PAYMENT</th>
					<th style="text-align: left; border: 0px">PAYMENT METHOD</th>
				</tr>
				<tr>
					<td style="text-align: left">RM<?php echo $TotalPayment; ?></td>
					<td style="text-align: left"><label><?php pmethod(); ?>
					<br><b>DELIVERY CHARGE: RM5.00<br><br>
						NOTE: Order above RM100 will get free delivery</b></label></td>
				</tr>
			</table>

			<table>
				<tr>
					<td style="text-align: right; border: 0px;"><button type="submit" value="submit" class="btn"><a>Proceed to Order</a></button></td>
				</tr>
			</table>
			</form>
		</div>

		<?php
		function pmethod() {
			$Pmethod = array ('Online' => 'Delivery - Online Payment', 'COD' =>  'Self Pickup - Cash On Delivery',);

			echo '<select name="Pmethod">';
			foreach ($Pmethod as $key => $value) {
				echo "<option value=\"$key\">$value</option>\n";
			}
			echo '</select>';
		}
		?>

<?php
include ('includes/footer.html');
?>
