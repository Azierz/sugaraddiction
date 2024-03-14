<?php
$page_title = 'Order List';
$page_text = 'Order List';
include ('includes/header.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Order List</h1>

<div class="menu">
	<table border="1">
		<tr>
			<th>Customer's Name</th>
			<th>Product(s)</th>
			<th>Quantity</th>
			<th>Date Ordered</th>
		</tr>
		<?php
		require ('includes/constants.php');

		$q = "SELECT * FROM cust_order";
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

			echo '
			<tr>
				<td align="left">'.$dataC['CustName'].'</td>';
			if(mysqli_num_rows($rP) == 1) {
				echo '<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['Quantity'].'</td>';
			} else {
				echo '<td align="left" colspan="2"><i>Product No Longer Available</i></td>';
			}
			echo '	
				<td align="left">'.$data['Order_Date'].'</td>
			</tr>';
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
