<?php
$page_title = 'Payment Form';
$page_text = 'Payment Form';
include ('includes/header.php');
?>

<h1>Payment Form</h1>

<div class="payment">
	<br>
	<div class="row">
	<div class="col-50">
		<div class="container">
		<form action="checkout.php" method="POST">
			<div class="col-50">
				<h3>Payment</h3>
				<label for="fname">Accepted Cards</label>
				<div class="icon-container">
				<i class="fa fa-cc-visa" style="color:navy;"></i>
				<i class="fa fa-cc-amex" style="color:blue;"></i>
				<i class="fa fa-cc-mastercard" style="color:red;"></i>
				<i class="fa fa-cc-discover" style="color:orange;"></i>
				</div>
				<label for="cname">Name on Card</label>
				<input type="text" id="cname" name="cardname" required>
				<label for="ccnum">Credit/Debit card number</label>
				<input type="text" id="ccnum" name="cardnumber" placeholder="xxxx-xxxx-xxxx-xxxx" required>
				<div class="row">
				<div class="col-25">
					<label for="expmonth">Exp Month</label>
					<select id="expmonth" name=expmonth value=''>
						<option value='01'>January</option>
						<option value='02'>February</option>
						<option value='03'>March</option>
						<option value='04'>April</option>
						<option value='05'>May</option>
						<option value='06'>June</option>
						<option value='07'>July</option>
						<option value='08'>August</option>
						<option value='09'>September</option>
						<option value='10'>October</option>
						<option value='11'>November</option>
						<option value='12'>December</option>
					</select>
				</div>
				<div class="col-25">
					<label for="expyear">Exp Year</label>
					<input type="text" id="expyear" name="expyear" required>
				</div>
				<div class="col-25">
					<label for="cvv">CVV</label>
					<input type="text" id="cvv" name="cvv" required>
				</div>
				</div>
			</div>
			<input type="submit" value="Continue to checkout" class="btn">
		</form>
		</div>
	</div>
	<div class="col-50">
		<div class="container">
		<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i></span></h4>
		
		<?php
		require ('includes/constants.php');
		$TotalPayment = 0;
		if(!empty($_SESSION["cart1"][1])){
		foreach($_SESSION['cart1'] as $cart => $val) {
			$ProdID = $val;
			$Qty = $_SESSION['qty1'][$val];

			$q = "SELECT * FROM product WHERE ProductID='$ProdID'";
			$r = @mysqli_query ($dbc,$q);

			if (mysqli_num_rows($r) == 1) {
						
				while ($data = mysqli_fetch_array($r)) {
					
					$Price = $data['Price'];
					$TotalPrice = number_format((double)$Qty*$Price, 2 ,'.', ',');
					
					$TotalPayment = number_format((double)$TotalPayment+$TotalPrice, 2 ,'.', ',');
					
					echo '
					<p><a>'.$data['Name'].' x'.$Qty.'</a> <span class="price">RM'.$TotalPrice.'</span></p>
					';
				}}
		}}
		
		if(!empty($_SESSION["cart2"][1])){
		foreach($_SESSION['cart2'] as $cart => $val) {
			$ProdID = $val;
			$Qty = $_SESSION['qty2'][$val];

			$q = "SELECT * FROM product WHERE ProductID='$ProdID'";
			$r = @mysqli_query ($dbc,$q);

			if (mysqli_num_rows($r) == 1) {
						
				while ($data = mysqli_fetch_array($r)) {
					
					$Price = $data['Price'];
					$TotalPrice = number_format((double)$Qty*$Price, 2 ,'.', ',');
					
					$TotalPayment = number_format((double)$TotalPayment+$TotalPrice, 2 ,'.', ',');
					
					echo '
					<p><a>'.$data['Name'].' x'.$Qty.'</a> <span class="price">RM'.$TotalPrice.'</span></p>
					';
				}}
		}}
		echo '<hr><p>Total <span class="price" style="color:black"><b>RM'.$TotalPayment.'</b></span></p>';
		?>
		</div>
	</div>
	</div>
</div>

<?php
include ('includes/footer.html');
?>
