<?php
$page_title = 'Shopping Cart';
$page_text = 'Shopping Cart';
include ('includes/header2.php');
require ('includes/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['newaddress'] != "") {
		if ($_POST['newaddress'] != "COD") {
		$CID = $_SESSION['CustID'];
		$ad = $_POST['newaddress'];
		
		$qA = "INSERT INTO address VALUES (0, '$CID', '$ad')";
		$rA = mysqli_query ($dbc, $qA); // Run the query.
		$_SESSION['newaddress'] = mysqli_insert_id($dbc);
		} else {
			$_SESSION['newaddress'] = "COD";
		}
	} else {
		$_SESSION['newaddress'] = $_POST['CustAdd'];
		
	}

	// if selected date is less than 4 days ahed from today or empty, send an error message
	if ($_POST['datepd'] < date('Y-m-d', strtotime('+4 days'))) {
		echo '
				<script>
				window.alert("\nPlease select a date that is at least 4 days from today.");
				setTimeout(function(){location.href="cart.php"},0);
				</script>';
	} else {
		$_SESSION['datepd'] = $_POST['datepd'];
		header("Location:payment.php");
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
			// if sms is empty
			if(empty($_SESSION['sms'][$val])) {
				$Sms = "No Message";
			} else {
				$Sms = $_SESSION['sms'][$val];
			}

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
					// echo '
					// <form action="menudetails.php" method="GET">
					// 	<input type="text" name="ProductID" value="'.$data["ProductID"].'" hidden>
					// 	<input type="submit" name="submit" value="More Details" />
					// </form>';
					echo '
					<div class="btn-group">
						<button><a href="edit_productCart.php?id='.$data['ProductID'].'">EDIT</a></button><br><br>
						<button><a href="delete_productCart.php?id='.$data['ProductID'].'">DELETE</a></button>
					</div>';
					
					
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
	
	<form action="cart.php" method="POST">
	<table>
		<tr>
			<th style="text-align: left; border: 0px">DELIVERY ADDRESS</th>
		</tr>

		<tr>
			<td style="text-align: left"><label><?php address($_SESSION['CustID'], $dbc); ?></td>
		</tr>
		<tr>
			<td id='hidediv'><b>Add New Address:-</b> <br><textarea name=newaddress cols="100" rows="5"></textarea></td>
		</tr>
	</table>
	
	<table>
		<tr>
			<th style="text-align: left; border: 0px">TOTAL PAYMENT</th>
			
			<th style="text-align: left; border: 0px" colspan="2">SELECT PICKUP/DELIVERY DATE</th>
			<th style="text-align: left; border: 0px" colspan="2">PAYMENT METHOD</th>
		</tr>
		<tr>
			<td style="text-align: left"><b>RM<?php echo $TotalPayment; ?></b></td>
			<td style="text-align: left" colspan="2"><input type="date" id="datepd" name="datepd" required>
			<label for="datepd"><br><br><b>NOTE: The selected date should be in the future, 4 days ahead from today</b></label>
			</td>
			<td style="text-align: left" colspan="2"><label><b><u>ONLINE PAYMENT ONLY</u>
			<br>Delivery Charge: RM5.00<br><br>
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

<script>

	function showDiv(divId, element) {
    document.getElementById(divId).style.display = element.value == "addaddress" ? 'block' : 'none';
	}

</script>
		
<?php

	function address($custid, $dbc) {
		$qAA = "SELECT Address_ID, Address FROM address WHERE Cust_ID='$custid'";
		$rAA = @mysqli_query($dbc, $qAA);

		if ($rAA) {
			echo '<select name="CustAdd" onchange="showDiv(\'hidediv\', this)">';
			echo "<option value=\"COD\">Self Pickup [pickup at our store]</option>\n";
			echo "<option value=\"addaddress\">[+] Add New Address</option>\n";
				foreach ($rAA as $value) {
					echo "<option value=\"$value[Address_ID]\">$value[Address]</option>\n";
				}
			
			
			echo '</select>';
		} else {
			// Handle error
			echo 'Error fetching addresses.';
		}
	}

	function pmethod() {
		$Pmethod = array ('Online' => 'Delivery - Online Payment', 'COD' =>  'Self Pickup - Payment during Pickup',);

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
