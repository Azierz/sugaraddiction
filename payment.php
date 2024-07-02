<?php
$page_title = 'Payment Form';
$page_text = 'Payment Form';
include ('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	require ('includes/constants.php');
	
	$errors = array(); // Initialize error array.
	
	$target_dir = "includes/receipts/"; // tempat simpan gambar
	$file_name = uniqid() . '-' . basename($_FILES["fileToUpload"]["name"]); // Unique file name
	$target_file = $target_dir . $file_name;
	$uploadOk = 1; // file okay untuk upload ke db
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // lowercase nama file
	
	// Allow certain file formats
	if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
		$errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$errors[] = "Your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { // save gambar dalam folder
	
	
			foreach($_SESSION['cart'] as $cart => $val) {
				$ProdID = $val;
				$Qty = $_SESSION['qty'][$val];
			
				$q = "SELECT * FROM product WHERE ProductID='$ProdID'";
				$r = mysqli_query ($dbc,$q);
			
				if (mysqli_num_rows($r) == 1) {
							
					while ($data = mysqli_fetch_array($r)) {
						
						$Order_CustID = $_SESSION['CustID'];
						$Order_ProdID = $ProdID;
						$Order_Quantity = $_SESSION['qty'][$val];
						$newaddress = $_SESSION['newaddress'];
						$status = 'Order Received, Pending Verification';
						$datepd = $_SESSION['datepd'];
						// if sms is empty
						if(empty($_SESSION['sms'][$val])) {
							$Sms = "No Message";
						} else {
							$Sms = $_SESSION['sms'][$val];
						}
			
						$qI = "INSERT INTO cust_order VALUES (0, '$Order_CustID', '$Order_ProdID', '$newaddress', '$Order_Quantity', '$Sms', '$datepd', '$target_file', '$status', null, NOW() )";
						$rI = mysqli_query($dbc, $qI);
					
					}
				}
			}
			
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
	
	}
	
	
	if ($rI) {
		unset($_SESSION['cart']);
		unset($_SESSION['qty']);
		unset($_SESSION['newaddress']);
		echo '<script>
		window.alert("\ORDER SUCCESS!\nThank you for purchasing with us!");
		setTimeout(function(){location.href="index.php"},0);
		</script>';
	} else {
		echo '<script>
		window.alert("\nERROR!\nPlease try again later.");
		setTimeout(function(){location.href="cart.php"},0);
		</script>';
	}
	}
	?>

<h1>Payment Form</h1>

<div class="payment">
	<br>
	<div class="row">
	<div class="col-50">
		<div class="container">
			<h1>Payment Upload (Proof of Payment)</h1>
			<form action="payment.php" method="POST" enctype="multipart/form-data">
			<table style="font-size: 100%">
				<tr>
					<td colspan="4"><p>Please transfer the total amount (refer to Cart) to account below:</p></td>
				</tr>
				<tr>
					<td colspan="1">&nbsp;</td>
				</tr>
				<tr>
					<td rowspan="7" style="text-align: center;"><img src="includes/images/bank_account.jpg" width="270"></td>
				</tr>
				<tr>
					<td><b>Account Holder Name: </b></td></tr><tr>
					<td>Muhammad Azizi bin Azni</td>
					<!-- <td><input type="text" name="accname" size="30" maxlength="50" placeholder="Name on Account" /></td> -->
				</tr>
				<tr>
					<td><b>Bank Account Name: </b></td></tr><tr>
					<td>Maybank</td>
					<!-- <td><input type="text" name="acctnum" size="30" maxlength="15" placeholder="Bank Account Number" /></td> -->
				</tr>
				<tr>
					<td><b>Bank Account Number: </b></td></tr><tr>
					<td>012345678910</td>
					<!-- <td><input type="text" name="acctnum" size="30" maxlength="15" placeholder="Bank Account Number" /></td> -->
				</tr>
				<!-- <tr>
					<td>Amount Paid: $ <input type="number" step=".01" min="0.01" name="amountpaid" size="10"/></td>
					<td>&nbsp;&nbsp;(Including any applicable fees)</td>
				</tr> -->

				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				</tr>
				<tr>
					<td colspan="2"><p>Upload your Receipt or Proof of Payment: &nbsp;</p></td>
				</tr>
				<tr>
					<td colspan="2"><p><input type="file" name="fileToUpload" id="fileToUpload" required></p></td>
				</tr>
				<tr>
					<td colspan="2"><p><b>DISCLAIMER: <br>Your order will be proceed ONLY AFTER we have validated your Proof of Payment. 
						if we identify that your receipt is fake, your order will automatically be canceled / void.<br><br> Thank you.</b></p></td>
				</tr>
			</table>

				<input type="submit" value="Confirm Order" class="btn">
			
			</form>
		</div>
	</div>
	<div class="col-50">
		<div class="container">
		<h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i></span></h4>
		
		<?php
		require ('includes/constants.php');
		$TotalPayment = 0;
		if(!empty($_SESSION["cart"])){
		foreach($_SESSION['cart'] as $cart => $val) {
			$ProdID = $val;
			$Qty = $_SESSION['qty'][$val];

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
		if ($TotalPayment < 100 && $_SESSION['newaddress'] != 'COD') {
			$TotalPayment += 5; //Adding shipping fee to total payment
		echo '<p>Delivery Charge <span class="price">RM5.00</span></p>';
			
		} else if ($TotalPayment > 100 && $_SESSION['newaddress'] != 'COD') {
			echo '<p>Delivery Charge <span class="price">Free Delivery</span></p>';
		} else {
			echo '<p>Delivery Charge <span class="price">N/A for self pickup</span></p>';
		}
		echo'
		<hr><p>Total <span class="price" style="color:black"><b>RM'.$TotalPayment.'</b></span></p>';
		?>
		</div>
	</div>
	</div>
</div>

<?php
include ('includes/footer.html');
?>