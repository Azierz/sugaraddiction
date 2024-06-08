<?php
$page_title = 'Product Sold List';
$page_text = 'Product Sold List';
include ('includes/header.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Product Sold List</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">

	</div>
	<table border="1">
		<tr>
			<th>Product Name</th>
			<th>Total Quantity Sold</th>
			<th>Total Income</th>
			<th>View Details</th>
		</tr>
		<?php
		require ('includes/constants.php');
		$grandsum = 0;

		$q = "SELECT CustID, ProdID, SUM(Quantity) AS Quantity, Order_Date
		FROM cust_order 
		GROUP BY ProdID
		";
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
			}
			$grandsum += $sumProd;
			
		}}
		echo '<td colspan=3 style="text-align:right"><b>GRAND TOTAL INCOME:- <b></td>
		<td><b>RM'.$grandsum.'</td>';
		?>
	</table>
</div>

<?php
include ('includes/footer.html');
?>
