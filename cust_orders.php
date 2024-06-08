<?php
$page_title = 'Order History';
$page_text = 'Order History';
include ('includes/header2.php');
?>

<h1>Order History</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
    
	</div>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Current Order Status</th>
			<th>View Order Details</th>
		</tr>
		<?php
		require ('includes/constants.php');
		$SCID = $_SESSION['CustID'];
		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, Quantity, Order_Date
        FROM cust_order
		WHERE CustID = $SCID
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC
		;";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">You have no order history</td></tr>';
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
			$qOD = "SELECT * FROM cust_order WHERE Order_date = '$OD'";
			$rOD = @mysqli_query ($dbc,$qOD);
			$dataOD = mysqli_fetch_array($rOD);

			echo "<tr><td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";

			if (isset($dataOD['StatusUpdate'])) {
				echo '
				<td align="left">'.$dataOD['StatusUpdate'].'</td>'; 
			} else {
				echo '<td align="left">New Order</td>';
			}
			echo '<td>
				<form action="cust_orderdetails.php" method="GET">
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
