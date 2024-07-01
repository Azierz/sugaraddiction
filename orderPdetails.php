<?php
$page_title = 'Order List';
$page_text = 'Order List';
include ('includes/header.php');
require ('includes/constants.php');
$ProdName = $_POST["ProdName"];

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
	$ProdID = $_POST["ProdID"];
	$grandsum = 0;

	// 1) dayfilter - nf, monthfilter - nf, yearfilter - nf
	if ((!isset($_POST['dayfilter'])) && (!isset($_POST['monthfilter'])) && (!isset($_POST['yearfilter'])) || ($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] == 0)) {
		$D = 0;
		$M = 0;
		$Y = 0;
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order 
		WHERE ProdID = '$ProdID'
		ORDER BY Order_Date DESC
		";
	// 2) dayfilter - nf, monthfilter - nf, yearfilter - f
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] != 0)) {
		$D = 0;
		$M = 0;
		$Y = $_POST['yearfilter'];
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order 
		WHERE ProdID = '$ProdID' AND YEAR(Order_Date) = $Y
		ORDER BY Order_Date DESC
		";
	// 3) dayfilter - nf, monthfilter - f, yearfilter - nf
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] == 0)) {
		$D = 0;
		$M = $_POST['monthfilter'];
		$Y = 0;
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order 
		WHERE ProdID = '$ProdID' AND month(Order_Date) = $M
		ORDER BY Order_Date DESC
		";
	// 4) dayfilter - f, monthfilter - nf, yearfilter - nf
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] == 0)) {
		$D = $_POST['dayfilter'];
		$M = 0;
		$Y = 0;
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order
		WHERE ProdID = '$ProdID' AND DAY(Order_Date) = $D
		ORDER BY Order_Date DESC
		";
	// 5) dayfilter - nf, monthfilter - f, yearfilter - f
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] != 0)) {
		$D = 0;
		$M = $_POST['monthfilter'];
		$Y = $_POST['yearfilter'];
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order
		WHERE ProdID = '$ProdID' AND MONTH(Order_Date) = $M AND YEAR(Order_Date) = $Y
		ORDER BY Order_Date DESC
		";
	// 6) dayfilter - f, monthfilter - nf, yearfilter - f
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] != 0)) {
		$D = $_POST['dayfilter'];
		$M = 0;
		$Y = $_POST['yearfilter'];
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order
		WHERE ProdID = '$ProdID' AND DAY(Order_Date) = $D AND YEAR(Order_Date) = $Y
		ORDER BY Order_Date DESC
		";
	// 7) dayfilter - f, monthfilter - f, yearfilter - nf
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] == 0)) {
		$D = $_POST['dayfilter'];
		$M = $_POST['monthfilter'];
		$Y = 0;
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order
		WHERE ProdID = '$ProdID' AND DAY(Order_Date) = $D AND MONTH(Order_Date) = $M
		ORDER BY Order_Date DESC
		";
	// 8) dayfilter - f, monthfilter - f, yearfilter - f
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] != 0)) {
		$D = $_POST['dayfilter'];
		$M = $_POST['monthfilter'];
		$Y = $_POST['yearfilter'];
		$q = "SELECT *, MONTHNAME(Order_Date) AS 'Month', YEAR(Order_Date) AS 'Year' 
		FROM cust_order
		WHERE ProdID = '$ProdID' AND DAY(Order_Date) = $D AND MONTH(Order_Date) = $M AND YEAR(Order_Date) = $Y
		ORDER BY Order_Date DESC
		";
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
			// 	<form action="orderLdetails.php" method="POST">
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

</div>
<?php
include ('includes/footer.html');
?>
