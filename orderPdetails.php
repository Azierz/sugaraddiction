<?php
$page_title = 'Order List';
$page_text = 'Order List';
include ('includes/header.php');
$ProdName = $_GET["ProdName"];

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Product List for <?php echo $ProdName ?></h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
		<button><a href="orders_ProductSold.php">Back to Order History</a></button>
	</div>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Customer's Name</th>
			<th>Quantity</th>
			<th>Total Income</th>
			<th>View Order</th>
			
		</tr>
		<?php
		require ('includes/constants.php');

		$ProdID = $_GET["ProdID"];
		

		$q = "SELECT * FROM cust_order WHERE ProdID = '$ProdID'";
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
			
			$sumProd = $dataP['Price']*$data['Quantity'];

			echo "<tr><td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			echo '
				<td align="left">'.$dataC['CustName'].'</td>';
			if(mysqli_num_rows($rP) == 1) {
				echo '
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>';
			} else {
				echo '<td align="left" colspan="2"><i>Product No Longer Available</i></td>';
			}
			
			echo '<td>
				<form action="orderLdetails.php" method="GET">
					<input type="text" name="Order_Date" value="'.$data["Order_Date"].'" hidden>
					<input type="text" name="CustName" value="'.$dataC["CustName"].'" hidden>
					<input type="submit" name="submit" value="View Order" />
				</form></td>
			</tr>';
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
