<?php
$page_title = 'Checkout';
$page_text = 'Checkout';
include ('includes/header2.php');

require ('includes/constants.php');
foreach($_SESSION['cart'] as $cart => $val) {
	$ProdID = $val;
	$Qty = $_SESSION['qty'][$val];

	$q = "SELECT * FROM product WHERE ProductID='$ProdID'";
	$r = @mysqli_query ($dbc,$q);

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
			
			
			$qI = "INSERT INTO cust_order VALUES (0, '$Order_CustID', '$Order_ProdID', '$newaddress', '$Order_Quantity', '$Sms', '$datepd', null, $status, null, NOW() )";
			$rI = mysqli_query($dbc, $qI);
		
		}
	}
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
?>

<?php
include ('includes/footer.html');
?>
