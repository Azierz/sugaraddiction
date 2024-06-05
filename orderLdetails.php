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
		<button><a href="orders_TotalOrder.php">Back to Order History</a></button>
	</div>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Product(s)</th>
			<th>Quantity</th>
			<th>Total Price</th>
			<th>Receipt</th>
		</tr>
		<?php
		

		$OrderDate = $_GET["Order_Date"];
		

		$q = "SELECT * FROM cust_order WHERE Order_Date = '$OrderDate'";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No order from customer</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {

			$OrderID = $data['OrderID'];
			$c = $data['CustID'];
			$p = $data['ProdID'];
			$SU = $data['StatusUpdate'];

			$qC = "SELECT * FROM customer WHERE CustID = '$c'";
			$rC = @mysqli_query ($dbc,$qC);
			$dataC = mysqli_fetch_array($rC);
			$qP = "SELECT * FROM product WHERE ProductID = '$p'";
			$rP = @mysqli_query ($dbc,$qP);
			$dataP = mysqli_fetch_array($rP);

			
			

			echo '<tr>';
			echo "<td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "
			<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			if(mysqli_num_rows($rP) == 1) {
				$sumProd = $dataP['Price']*$data['Quantity'];
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>
				';
				if(empty($receipt)) {
				if (!isset($data["Receipt"])) {
					echo '<td rowspan = 100000>Payment by Cash</td>';
					$receipt = 1;
				} else {
					echo '<td rowspan = 100000><img src="'.$data["Receipt"].'"/></td>';
				}$receipt = 1;};
			} else {
				echo '<td align="left" colspan="4"><i>Product No Longer Available</i></td>';
			}
			
			echo'
		</tr>'; 
		}} echo'<form action="orderLdetails.php" id=statupd method="POST">
			<input type="text" name="OrderDate" value="'.$OrderDate.'" hidden>
			<input type="text" name="OrderID" value="'.$OrderID.'" hidden>
			<label>' .StatusUpdate($SU).'</label>';
		
		// echo '<td colspan=9><input type="submit" name="submit" value="Save Change" /></td>';
		
			function StatusUpdate($SU) {
				$StatusUpdate = array ('Received_Pending' => 'Received, Pending Verification', 'Received_Verified' =>  'Received, Verified', 'Rejected' =>  'Rejected', 'In_Progress' =>  'In Progress', 'Pickup/Delivery' =>  'Ready for pickup/delivery', 'Complete' =>  'Order Complete',);

				echo '<td colspan=4><select name="StatusUpdate" id=statusDropdown form=statupd>';
				foreach ($StatusUpdate as $key => $value) {	echo "<option value=\"$key\"";
					if ($SU == $key) {echo " selected";}	echo ">$value</option>\n";}
				echo '</select></td>';
				// ======================================================================================
				// echo '<td colspan=4><select name="StatusUpdate" id=statusDropdown form=statupd>';
				// foreach ($StatusUpdate as $key => $value) {
				// 	echo "<option value=\"$key\">$value</option>\n";
				// }
				// echo '</select></td>';
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
