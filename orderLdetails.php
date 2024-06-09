<?php
$page_title = 'Order List';
$page_text = 'Order List';
include ('includes/header.php');
require ('includes/constants.php');
$CustName = $_GET["CustName"];

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$StatusUpdate = $_POST['StatusUpdate'];
	$OrderDate = $_POST['OrderDate'];
	$OrderID = $_POST['OrderID'];

	$qU = "UPDATE cust_order SET StatusUpdate = '$StatusUpdate' WHERE Order_Date = '$OrderDate' ";
	$rU = @mysqli_query ($dbc, $qU);

	if (mysqli_affected_rows($dbc) > 0) {
		echo '<script>
		window.alert("\nSUCCESS!\nStatus has been updated.");
		setTimeout(function(){location.href="orders_TotalOrder.php"},0);
		</script>';
	} else {
		echo '<script>
		window.alert("\ERROR!\nStatus cannot not be updated.\nPlease try again later.");
		setTimeout(function(){location.href="orders_TotalOrder.php"},0);
		</script>';
	}
}
?>

<h1>Order List for <?php echo $CustName ?></h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
	<?php echo '<button><a href="'. $_SERVER["HTTP_REFERER"] .'">Back to Order History</a></button>';?>
	</div>

	<?php 
	$OrderDate = $_GET["Order_Date"];
		
	//LATER ASK ACAD ABPUT THIS - HOW TO USE THE DATA FROM DB IN 2 SEPERATE PLACE
	$q = "SELECT * FROM cust_order WHERE Order_Date = '$OrderDate'";
	$r = @mysqli_query ($dbc,$q);
	if (!mysqli_num_rows($r) == 1) {
		echo '<script>
		window.alert("\nRedirecting...\nNo order from customer.");
		setTimeout(function(){location.href="orders_TotalOrder.php"},0);
		</script>';
	}
	$dataPre = mysqli_fetch_array($r);
	$AddID = $dataPre['AddID'];
	$c = $dataPre['CustID'];
	$SU = $dataPre['StatusUpdate'];

	// Retrieve Address from db
	$qAdd = "SELECT Address FROM address WHERE Address_ID = '$AddID'";
	$rAdd = @mysqli_query ($dbc,$qAdd);
	$dataAdd = mysqli_fetch_array($rAdd);
	if(empty($dataAdd['Address']) || $dataAdd['Address'] == 'COD') {
		$DeliAdd = 'Self Pickup by Customer';
	} else {
		$DeliAdd = $dataAdd['Address'];
	}
	// Retrieve customer's details from db
	$qC = "SELECT * FROM customer WHERE CustID = '$c'";
	$rC = @mysqli_query ($dbc,$qC);
	$dataC = mysqli_fetch_array($rC);
	// Set the delivery method
	if(empty($dataPre['Receipt'])) {
		$DeliMeth = 'Self Pickup by Customer';
	} else {
		$DeliMeth = 'Delivery to Address Above';
	}
	?>

	<table>
		<tr><th colspan="3">CUSTOMER'S DETAILS</th></tr>
		<tr><th style="text-align:right">Name:- </th><td colspan="2" style="text-align:left"><?php echo $dataC['CustName'];?></td></tr>
		<tr><th style="text-align:right">Phone Number:- </th><td colspan="2" style="text-align:left"><?php echo $dataC['PhoneNum'];?></td></tr>
		<tr><th style="text-align:right">Delivery Address:- </th><td colspan="2" style="text-align:left"><?php echo $DeliAdd?></td></tr>
		<tr><th style="text-align:right">Delivery Method:- </th><td colspan="2" style="text-align:left"><b><?php echo $DeliMeth ?></b></td></tr>
		<form action="orderLdetails.php" id=statupd method="POST">
			
			<label><?php StatusUpdate($SU)?></label>
	</table>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Product(s)</th>
			<th>Quantity</th>
			<th>Total Price</th>
			<th>Receipt</th>
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
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>
				';
				if(empty($receipt)) {
				if (!isset($data["Receipt"])) {
					echo '<td rowspan = 100000>Payment during Self Pickup</td>';
					$receipt = 1;
				} else {
					echo '<td rowspan = 100000><img src="'.$data["Receipt"].'"/></td>';
				}$receipt = 1;};
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
				$StatusUpdate = array ('Order Received, Pending Verification' => 'Order Received, Pending Verification', 'Order Received, Verified' =>  'Order Received, Verified', 'Order Rejected' =>  'Order Rejected', 'Order In Progress' =>  'Order In Progress', 'Order Ready for Pickup/Delivery' =>  'Order Ready for pickup/delivery', 'Order Collected/Retrieved' =>  'Order Collected/Retrieved',);

				echo '<th style="text-align:right">Current Order Status:-</th>
				<td colspan=2 style="text-align:left"><select name="StatusUpdate" id=statusDropdown form=statupd>';
				foreach ($StatusUpdate as $key => $value) {	echo "<option value=\"$key\"";
					if ($SU == $key) {echo " selected";}	echo ">$value</option>\n";}
				echo '</select></td>';
			}
?>
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

		
	</table>
</div>

<?php
include ('includes/footer.html');
?>
