<?php
$page_title = 'Product Sold List';
$page_text = 'Product Sold List';
include ('includes/header.php');
require ('includes/constants.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}

	$grandsum = 0;
	// 1) dayfilter - nf, monthfilter - nf, yearfilter - nf
	if ((!isset($_POST['dayfilter'])) && (!isset($_POST['monthfilter'])) && (!isset($_POST['yearfilter'])) || ($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] == 0)) {
		$D = 0;
		$M = 0;
		$Y = 0;
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order 
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 2) dayfilter - nf, monthfilter - nf, yearfilter - f
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] != 0)) {
		$D = 0;
		$M = 0;
		$Y = $_POST['yearfilter'];
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order 
		LEFT JOIN product ON cust_order.ProdID = product.ProductID 
		WHERE YEAR(cust_order.Order_Date) = $Y
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 3) dayfilter - nf, monthfilter - f, yearfilter - nf
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] == 0)) {
		$D = 0;
		$M = $_POST['monthfilter'];
		$Y = 0;
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order 
		LEFT JOIN product ON cust_order.ProdID = product.ProductID 
		WHERE month(cust_order.Order_Date) = $M
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 4) dayfilter - f, monthfilter - nf, yearfilter - nf
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] == 0)) {
		$D = $_POST['dayfilter'];
		$M = 0;
		$Y = 0;
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		WHERE DAY(cust_order.Order_Date) = $D
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 5) dayfilter - nf, monthfilter - f, yearfilter - f
	} else if (($_POST['dayfilter'] == 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] != 0)) {
		$D = 0;
		$M = $_POST['monthfilter'];
		$Y = $_POST['yearfilter'];
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		WHERE MONTH(cust_order.Order_Date) = $M AND YEAR(cust_order.Order_Date) = $Y
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 6) dayfilter - f, monthfilter - nf, yearfilter - f
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] == 0) && ($_POST['yearfilter'] != 0)) {
		$D = $_POST['dayfilter'];
		$M = 0;
		$Y = $_POST['yearfilter'];
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		WHERE DAY(cust_order.Order_Date) = $D AND YEAR(cust_order.Order_Date) = $Y
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 7) dayfilter - f, monthfilter - f, yearfilter - nf
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] == 0)) {
		$D = $_POST['dayfilter'];
		$M = $_POST['monthfilter'];
		$Y = 0;
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		WHERE DAY(cust_order.Order_Date) = $D AND MONTH(cust_order.Order_Date) = $M
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	// 8) dayfilter - f, monthfilter - f, yearfilter - f
	} else if (($_POST['dayfilter'] != 0) && ($_POST['monthfilter'] != 0) && ($_POST['yearfilter'] != 0)) {
		$D = $_POST['dayfilter'];
		$M = $_POST['monthfilter'];
		$Y = $_POST['yearfilter'];
		$q = "SELECT cust_order.*, SUM(cust_order.Quantity) AS QuantityNew, SUM(cust_order.Quantity)*product.Price AS TotalIncome
		FROM cust_order
		LEFT JOIN product ON cust_order.ProdID = product.ProductID
		WHERE DAY(cust_order.Order_Date) = $D AND MONTH(cust_order.Order_Date) = $M AND YEAR(cust_order.Order_Date) = $Y
		GROUP BY cust_order.ProdID
		ORDER BY TotalIncome DESC
		";
	}
?>

<h1>Product Sold List</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin: 0.5em">
	<form action="orders_ProductSold.php" id=filter method="POST">
	<label><?php DayFilter($dbc, $D);?></label>
	<label><?php MonthFilter($dbc, $M);?></label>
	<label><?php YearFilter($dbc, $Y);?></label>
	<input type="button" onclick="location.href='orders_ProductSold.php'" value="Clear Filter"/>
	<input type="submit" name="submit" value="Apply Filter"/>
	</form>
	</div>
	<table border="1">
		<tr>
			<th>Product Name</th>
			<th>Total Quantity Sold</th>
			<th>Total Income</th>
			<th>View Details</th>
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

			echo '<tr>';
			if(mysqli_num_rows($rP) == 1) {
				
				echo '
				<td align="left">'.$dataP['Name'].'</td>
				<td align="left">'.$data['QuantityNew'].'</td>
				<td align="left">RM'.$data['TotalIncome'].'</td>';
				echo '<td>
				<form action="orderPdetails.php" method="POST">
					<input type="text" name="ProdID" value="'.$data["ProdID"].'" hidden>
					<input type="text" name="ProdName" value="'.$dataP["Name"].'" hidden>
					<input type="text" name="dayfilter" value="'.$D.'" hidden>
					<input type="text" name="monthfilter" value="'.$M.'" hidden>
					<input type="text" name="yearfilter" value="'.$Y.'" hidden>
					<input type="submit" name="submit" value="More Details" />
				</form></td>
			</tr>';
			}
			$grandsum += $data['TotalIncome'];
		}}
		echo '<td colspan=3 style="text-align:right"><b>GRAND TOTAL INCOME:- <b></td>
		<td><b>RM'.$grandsum.'</td>';
		?>
	</table>

</div>

<?php
	// Function to update status/tracker
	function MonthFilter($dbc, $M) {
		$q = "SELECT MONTH(Order_Date) AS MonthNo, MONTHNAME(Order_Date) AS Month 
		FROM cust_order 
		GROUP BY MONTH(Order_Date) ASC
		";
		$r = @mysqli_query ($dbc,$q);

		if ($r) {
			echo '<select name="monthfilter" form=filter>';
			echo "<option value=\"0\">No Month Filter</option>\n";
				foreach ($r as $value) {
					echo "<option value=\"$value[MonthNo]\"";
					if ($M ==  $value['MonthNo']) {echo " selected";}	echo ">$value[Month]</option>\n";
				}
			echo '</select>';
		} else {
			// Handle error
			echo 'Error fetching filter(s).';
		}
	}

	function YearFilter($dbc, $Y) {
		$q = "SELECT YEAR(Order_Date) AS Year
		FROM cust_order 
		GROUP BY YEAR(Order_Date) DESC
		";
		$r = @mysqli_query ($dbc,$q);

		if ($r) {
			echo '<select name="yearfilter" form=filter>';
			echo "<option value=\"0\">No Year Filter</option>\n";
				foreach ($r as $value) {
					echo "<option value=\"$value[Year]\"";
					if ($Y ==  $value['Year']) {echo " selected";}	echo ">$value[Year]</option>\n";
				}
			echo '</select>';
		} else {
			// Handle error
			echo 'Error fetching filter(s).';
		}
	}

	function DayFilter($dbc, $D) {
		$q = "SELECT DAY(Order_Date) AS Day
		FROM cust_order 
		GROUP BY DAY(Order_Date) ASC
		";
		$r = @mysqli_query ($dbc,$q);

		if ($r) {
			echo '<select name="dayfilter" form=filter>';
			echo "<option value=\"0\">No Day Filter</option>\n";
				foreach ($r as $value) {
					echo "<option value=\"$value[Day]\"";
					if ($D ==  $value['Day']) {echo " selected";}	echo ">$value[Day]</option>\n";
				}
			echo '</select>';
		} else {
			// Handle error
			echo 'Error fetching filter(s).';
		}
	}

include ('includes/footer.html');
?>
