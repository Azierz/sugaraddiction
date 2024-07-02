<?php
$page_title = 'Order History Details';
$page_text = 'Order History Details';
include ('includes/header.php');
require ('includes/constants.php');
$CustName = $_GET["CustName"];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$StatusUpdate = $_POST['StatusUpdate'];
	$OrderDate = $_POST['OrderDate'];
	$OrderID = $_POST['OrderID'];



	$qU = "UPDATE cust_order SET StatusUpdate = '$StatusUpdate' WHERE Order_Date = '$OrderDate' ";
	$rU = @mysqli_query ($dbc, $qU);

	if (mysqli_affected_rows($dbc) > 0) {
		echo '<script>
		window.alert("\nSUCCESS!\nStatus has been updated.\nThank you for your purchase with us.");
		setTimeout(function(){location.href="cust_orders.php"},0);
		</script>';
	} else {
		echo '<script>
		window.alert("\ERROR!\nStatus cannot not be updated.\nPlease try again later.");
		setTimeout(function(){location.href="cust_orders.php"},0);
		</script>';
	}
	
}
?>

<h1>Order History Details</h1>

<div class="menu">
<?php 
	$OrderDate = $_GET["Order_Date"];
		
	//LATER ASK ACAD ABPUT THIS - HOW TO USE THE DATA FROM DB IN 2 SEPERATE PLACE
	$q = "SELECT * FROM cust_order WHERE Order_Date = '$OrderDate'";
	$r = @mysqli_query ($dbc,$q);
	if (!mysqli_num_rows($r) == 1) {
		echo '<script>
		window.alert("\nRedirecting...\nNo order from customer.");
		setTimeout(function(){location.href="cust_orders.php"},0);
		</script>';
	}
	$dataPre = mysqli_fetch_array($r);

	$AddID = $dataPre['AddID'];
	$c = $dataPre['CustID'];
	$SU = $dataPre['StatusUpdate'];
	$OrderID = $dataPre['OrderID'];
	$datepd = $dataPre['datepd'];

	// Retrieve Address from db
	$qAdd = "SELECT Address FROM address WHERE Address_ID = '$AddID'";
	$rAdd = @mysqli_query ($dbc,$qAdd);
	$dataAdd = mysqli_fetch_array($rAdd);
	if(empty($dataAdd['Address']) || $dataPre['AddID'] == 0) {
		$DeliAdd = 'Self Pickup by Customer';
	} else {
		$DeliAdd = $dataAdd['Address'];
	}
	// Retrieve customer's details from db
	$qC = "SELECT * FROM customer WHERE CustID = '$c'";
	$rC = @mysqli_query ($dbc,$qC);
	$dataC = mysqli_fetch_array($rC);
	// Set the delivery method
	if($dataPre['AddID'] == 0) {
		$DeliMeth = 'Self Pickup by Customer';
	} else {
		$DeliMeth = 'Delivery to Address Above';
	}
?>

	<table>
		<tr><th colspan="3">ORDER DETAILS</th>
		<th>ORDER RECEIPT</th></tr>
		<tr><th style="text-align:right">Name:- </th><td colspan="2" style="text-align:left"><?php echo $dataC['CustName'];?></td>
		<?php if(empty($receipt)) {
			echo '<td rowspan = 6><img src="'.$dataPre["Receipt"].'"/></td>';
			$receipt = 1;
		}
			?>
			</tr>
		<tr><th style="text-align:right">Phone Number:- </th><td colspan="2" style="text-align:left"><?php echo $dataC['PhoneNum'];?></td></tr>

		<?php if($dataPre['AddID'] != 0) { ?>
			<tr><th style="text-align:right">Delivery Address:- </th><td colspan="2" style="text-align:left"><?php echo $DeliAdd?></td></tr>
			<tr><th style="text-align:right">Delivery Method:- </th><td colspan="2" style="text-align:left"><b><?php echo $DeliMeth ?></b></td></tr>
		<?php } else { ?>
			<tr><th style="text-align:right">Delivery Method:- </th><td colspan="2" style="text-align:left"><b><?php echo $DeliMeth ?></b></td></tr>
		<?php } ?>
		
		<tr><th style="text-align:right">Selected Pickup / Delivery Date:- </th><td colspan="2" style="text-align:left"><b><?php echo date("j M Y", strtotime($datepd)) ?></b></td></tr>
		<form action="cust_orderdetails.php" id=statupd method="POST">
			<?php 
			if ($SU == 'Order Ready for Pickup/Delivery') {
				echo '<label>' .StatusUpdate($SU).'</label>';
				} else if (empty($SU)){
					echo '<th style="text-align:right">Current Order Status:-</th>
					<td colspan=2 style="text-align:left"> Order Received, Pending Verification</td>';
				} else {
					echo '<th style="text-align:right">Current Order Status:-</th>
					<td colspan=2 style="text-align:left">'.$SU.'</td>';
				}?>
	</table>

	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Product(s)</th>
			<th>Personalized Message</th>
			<th>Quantity</th>
			<th>Total Price</th>
		</tr>
		<?php
		$q = "SELECT * FROM cust_order WHERE Order_Date = '$OrderDate'";
		$r = @mysqli_query ($dbc,$q);
		while ($data = mysqli_fetch_array($r)) {
			
			$OrderID = $data['OrderID'];
			$p = $data['ProdID'];

			$qP = "SELECT * FROM product WHERE ProductID = '$p'";
			$rP = @mysqli_query ($dbc,$qP);
			$dataP = mysqli_fetch_array($rP);

			echo '<tr>';
			echo "<td>" . date("H:i:sA", strtotime($data['Order_Date'])) . ", 
			" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			if(mysqli_num_rows($rP) == 1) {
				$sumProd = $dataP['Price']*$data['Quantity'];
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['pmessage'].'</td>
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>
				';
			} 
			// else {
			// 	echo '<td align="left" colspan="4"><i>Product No Longer Available</i></td>';
			// }
			
			echo'</tr>
			<input type="text" name="OrderDate" value="'.$OrderDate.'" hidden>
			<input type="text" name="OrderID" value="'.$OrderID.'" hidden>'; 
		}
			// Function to update status/tracker
			function StatusUpdate($SU) {
				$StatusUpdate = array ('Confirm Your Order Here' => 'Confirm Your Order Here', 'Order Collected/Retrieved' =>  'Order Collected/Retrieved');

				echo '<td colspan=4><b>Current Order Status:- <b><select name="StatusUpdate" id=statusDropdown form=statupd>';
				foreach ($StatusUpdate as $key => $value) {	echo "<option value=\"$key\"";
					if ($SU == $key) {echo " selected";}	echo ">$value</option>\n";}
				echo '</select></td>';
			}
?>
	</table>
</div>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add this script after your dropdown menu -->
<script>
  $(document).ready(function() {
    // Assuming your dropdown menu has an ID of "statusDropdown"
    $('#statusDropdown').on('change', function() {
      const selectedStatus = $(this).val(); // Get the selected value
      // Programmatically submit the form
      $('#statupd').submit(); // Replace with your actual form ID
    });
  });
</script>

<?php
include ('includes/footer.html');
?>
