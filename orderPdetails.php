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
<button><a href="orders_ProductSold.php">Back to Product Sold List</a></button>
	</div>
	<table border="1">
		<tr>
			<th>Date Ordered</th>
			<th>Customer's Name</th>
			<th>Quantity</th>
			<th>Total Income</th>
			<!-- <th>View Order</th> -->
			
		</tr>
		<?php
		require ('includes/constants.php');

		$ProdID = $_GET["ProdID"];
		$grandsum = 0;
		
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order 
		WHERE ProdID = '$ProdID' AND MONTH(Order_Date)
		ORDER BY Order_Date DESC";
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

			echo "<tr><td>" . date("H:i:sA", strtotime($data['Order_Date'])) . "
			<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			echo '
				<td align="left">'.$dataC['CustName'].'</td>';
			if(mysqli_num_rows($rP) == 1) {
				echo '
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>';
			}
			$grandsum += $sumProd;
			// echo '<td>
			// 	<form action="orderLdetails.php" method="GET">
			// 		<input type="text" name="Order_Date" value="'.$data["Order_Date"].'" hidden>
			// 		<input type="text" name="CustName" value="'.$dataC["CustName"].'" hidden>
			// 		<input type="submit" name="submit" value="View Order" />
			// 	</form></td>';
			echo '</tr>';
		}}
		echo '<td colspan=3 style="text-align:right"><b>GRAND TOTAL INCOME:- <b></td>
		<td><b>RM'.$grandsum.'</td>';
		?>
	</table>

	<h1>Product List for <?php echo $ProdName ?></h1>

</div>
<?php
include ('includes/footer.html');
?>
