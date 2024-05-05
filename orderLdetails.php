<?php
$page_title = 'Order List';
$page_text = 'Order List';
include ('includes/header.php');
$CustName = $_GET["CustName"];

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
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
			<th>View Product</th>
		</tr>
		<?php
		require ('includes/constants.php');

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

			

			echo '<tr>';
			echo "<td>" . date("H:i:s A", strtotime($data['Order_Date'])) . "
			<br>" . date("j M Y", strtotime($data['Order_Date'])) . "</td>";
			if(mysqli_num_rows($rP) == 1) {
				$sumProd = $dataP['Price']*$data['Quantity'];
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['Quantity'].'</td>
				<td align="left">RM'.$sumProd.'</td>
				<td>';
				if (!isset($data["Receipt"])) {
					echo 'Payment by Cash';
				} else {
					echo '<img src="'.$data["Receipt"].'"/>';
				};
			} else {
				echo '</td><td align="left" colspan="4"><i>Product No Longer Available</i></td>';
			}
			
			
			echo '<td>
				<form action="orderPdetails.php" method="GET">
					<input type="text" name="ProdID" value="'.$data["ProdID"].'" hidden>
					<input type="text" name="ProdName" value="'.$dataP["Name"].'" hidden>
					<input type="submit" name="submit" value="View Product" />
				</form></td>
			</tr>';
			
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
