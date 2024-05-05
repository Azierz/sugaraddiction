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
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
		<button><a href="?page=orders_OrderHistory.php">Order History</a></button>
		<button><a href="?page=orders_ProductHistory.php">Product Sold</a></button>
		<a style="background-color: #555;" href="?page=OrderHistory" class="<?php echo ($_GET['page'] == 'OrderHistory' || !isset($_GET['page'])) ? 'active' : ''; ?>">Order History</a>
    <a style="background-color: #555;" href="?page=ProductSold" class="<?php echo ($_GET['page'] == 'ProductSold') ? 'active' : ''; ?>">Product Sold</a>
    
	</div>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Customer's Name</th>
			<th>Total Item(s)</th>
			<th>View Details</th>
		</tr>
		<?php
		require ('includes/constants.php');

		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, Quantity, Order_Date
        FROM cust_order
        GROUP BY CustID, Order_Date";
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

			echo "<tr><td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			// j M Y - short form for month | j F Y - full name for month
			// H:i:s A, j M Y - time, date | j M Y, H:i:s A - date, time
			echo '
				<td align="left">'.$dataC['CustName'].'</td>';
			// if(mysqli_num_rows($rP) == 1) {
				echo '<td align="left">'.$data['ProdID'].'</td>';
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
	
	
	<h1>Product Sold</h1>

	<table border="1">
		<tr>
			<th>Product Name</th>
			<th>Total Quantity Sold</th>
			<th>Total Income</th>
			<th>View Details</th>
		</tr>
		<?php

		$q = "SELECT CustID, ProdID, SUM(Quantity) AS Quantity, Order_Date
		FROM cust_order 
		GROUP BY ProdID";
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

			echo '<tr>';
			if(mysqli_num_rows($rP) == 1) {
				$sumProd = $dataP['Price']*$data['Quantity'];
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>';
				echo '<td>
				<form action="orderPdetails.php" method="GET">
					<input type="text" name="ProdID" value="'.$data["ProdID"].'" hidden>
					<input type="text" name="ProdName" value="'.$dataP["Name"].'" hidden>
					<input type="submit" name="submit" value="More Details" />
				</form></td>
			</tr>';
			} else {
				echo '<td align="left" colspan="4"><i>Product No Longer Available</i></td>';
			}
			
			
		}}
		?>
	</table>
</div>

<?php
include ('includes/footer.html');
?>
