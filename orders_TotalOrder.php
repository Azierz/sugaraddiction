<?php
$page_title = 'Order History';
$page_text = 'Order History';
include ('includes/header.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Total Order</h1>

<div class="menu">
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Customer's Name</th>
			<th>Delivery Method</th>
			<th>Current Status</th>
			<th>View Order Details</th>
		</tr>
		<?php
		require ('includes/constants.php');

		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, Quantity, Receipt, StatusUpdate, Order_Date
        FROM cust_order
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC;";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No order from customer</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {

			$c = $data['CustID'];
			$p = $data['ProdID'];
			$OD = $data['Order_Date'];

			$qC = "SELECT * FROM customer WHERE CustID = '$c'";
			$rC = @mysqli_query ($dbc,$qC);
			$dataC = mysqli_fetch_array($rC);
			$qP = "SELECT * FROM product WHERE ProductID = '$p'";
			$rP = @mysqli_query ($dbc,$qP);
			$dataP = mysqli_fetch_array($rP);

			if(empty($data['Receipt'])) {
				$DeliMeth = 'Self Pickup by Customer';
			} else {
				$DeliMeth = 'Delivery to Customer\'s Address';
			}

			echo "<tr><td>" . date("H:i:sA", strtotime($data['Order_Date'])) . "<br>
			" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			// j M Y - short form for month | j F Y - full name for month
			// H:i:s A, j M Y - time, date | j M Y, H:i:s A - date, time
			echo '
				<td align="left">'.$dataC['CustName'].'</td>
				<td align="left">'.$DeliMeth.'</td>';
			// if(mysqli_num_rows($rP) == 1) {
			if (isset($data['StatusUpdate'])) {
				echo '
				<td align="left">'.$data['StatusUpdate'].'</td>'; 
			} else {
				echo '<td align="left">Order Received, Pending Verification</td>';
			}
				// <td align="left">'.$data['Quantity'].'</td>';
			// } else {
			// 	echo '<td align="left" colspan="2"><i>Product No Longer Available</i></td>';
			// }
			// echo '	
			// 	<td align="left">'.$data['Order_Date'].'</td>
			// </tr>';


			echo '<td>
				<form action="orderLdetails.php" method="GET">
					<input type="text" name="Order_Date" value="'.$data["Order_Date"].'" hidden>
					<input type="text" name="CustName" value="'.$dataC["CustName"].'" hidden>
					<input type="submit" name="submit" value="More Details" />
				</form></td>
			</tr>';
		}}
		?>
	</table>
</div>

<?php
include ('includes/footer.html');
?>
