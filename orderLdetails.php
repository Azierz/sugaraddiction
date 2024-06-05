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
	$CID = $_POST['CustID'];
	$PID = $_POST['ProdID'];

	$eID = $_POST['edit'];
	$eName = $_POST['name'];
	$ePrice = $_POST['price'];
	$eDesc = $_POST['desc'];


	$qU = "UPDATE cust_order SET Status='$StatusUpdate' WHERE Order_Date = '$OrderDate' AND CustID = '$CID' AND ProdID = '$PID' LIMIT 1";
	$rU = @mysqli_query ($dbc, $qU);


	

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
			<th colspan=4>Update Status</th>
		</tr>
		<?php
		

		$OrderDate = $_GET["Order_Date"];
		

		$q = "SELECT * FROM cust_order WHERE Order_Date = '$OrderDate'";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No order from customer</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {

			$c = $data['CustID'];
			$p = $data['ProdID'];

			$qC = "SELECT * FROM customer WHERE CustID = '$c'";
			$rC = @mysqli_query ($dbc,$qC);
			$dataC = mysqli_fetch_array($rC);
			$qP = "SELECT * FROM product WHERE ProductID = '$p'";
			$rP = @mysqli_query ($dbc,$qP);
			$dataP = mysqli_fetch_array($rP);

			$numRows = mysqli_num_rows($rP);

			echo $numRows;

			echo '<tr>';
			echo "<td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "
			<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			if($numRows == 1) {
				$sumProd = $dataP['Price']*$data['Quantity'];
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>
				';
				
				if (empty($receipt)) {
					if (!isset($data["Receipt"])) {
						echo '<td rowspan='.$numRows.'>Payment by Cash</td>';
					} else {
						echo '<td rowspan='.$numRows.'><img src="'.$data["Receipt"].'"/></td>';
						$receipt = $data["Receipt"];
					};

				}
				
			} else {
				echo '<td align="left" colspan="4"><i>Product No Longer Available</i></td>';
			}}
			
				echo'<form action="orderLdetails.php" id=statupd method="POST">
				<input type="text" name="OrderDate" value="'.$OrderDate.'" hidden>
				<input type="text" name="CustID" value="'.$c.'" hidden>
				<input type="text" name="ProdID" value="'.$p.'" hidden>
				<label>' .StatusUpdate().'</label>
			</tr>'; 
		} 
		echo '<td colspan=9><input type="submit" name="submit" value="Save Change" /></form></td>';
		
			function StatusUpdate() {
				$StatusUpdate = array ('Received_Pending' => 'Received, Pending Verification', 'Received_Verified' =>  'Received, Verified', 'Rejected' =>  'Order Rejected', 'In_Progress' =>  'In Progress', 'Pickup/Delivery' =>  'Ready for pickup/delivery', 'Complete' =>  'Order Complete',);

				echo '<td colspan=4><select name="StatusUpdate" id=statusDropdown>';
				foreach ($StatusUpdate as $key => $value) {
					echo "<option value=\"$key\">$value</option>\n";
				}
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
