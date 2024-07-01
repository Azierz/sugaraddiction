<?php
$page_title = 'Order History';
$page_text = 'Order History';
include ('includes/header.php');
require ('includes/constants.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}

	// 1) d-nf, s-nf, sd-nf
	if ((!isset($_POST['delivery'])) && (!isset($_POST['status'])) && (!isset($_POST['sDate'])) || 
	($_POST['delivery'] == 2) && ($_POST['status'] == 2) && ($_POST['sDate'] == 2)) {
		$D = 2;
		$S = 2;
		$sd = 2;
		
		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
        FROM cust_order
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC
		";
	// 2) d-nf, s-nf, sd-f
	} else if (($_POST['delivery'] == 2) && ($_POST['status'] == 2) && ($_POST['sDate'] != 2)) {
		$D = 2;
		$S = 2;
		$sd = $_POST['sDate'];
		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
        FROM cust_order
		WHERE datepd = '$sd'
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC
		";
	// 3) d-nf, s-f, sd-nf
	} else if (($_POST['delivery'] == 2) && ($_POST['status'] != 2) && ($_POST['sDate'] == 2)) {
		$D = 2;
		$S = $_POST['status'];
		$sd = 2;
		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
        FROM cust_order
		WHERE StatusUpdate = '$S'
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC
		";
	// 4) d-f, s-nf, sd-nf
	} else if (($_POST['delivery'] != 2) && ($_POST['status'] == 2) && ($_POST['sDate'] == 2)) {
		$D = $_POST['delivery'];
		$S = 2;
		$sd = 2;
		if ($D == 0) {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE AddID = 0
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC"; 
		} else {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE NOT AddID = 0
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC";
		};
	// 5) d-nf, s-f, sd-f
	} else if (($_POST['delivery'] == 2) && ($_POST['status'] != 2) && ($_POST['sDate'] != 2)) {
		$D = 2;
		$S = $_POST['status'];
		$sd = $_POST['sDate'];
		$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
        FROM cust_order
		WHERE StatusUpdate = '$S' AND datepd = '$sd'
        GROUP BY CustID, Order_Date
		ORDER BY Order_Date DESC
		";
	// 6) d-f, s-nf, sd-f
	} else if (($_POST['delivery'] != 2) && ($_POST['status'] == 2) && ($_POST['sDate'] != 2)) {
		$D = $_POST['delivery'];
		$S = 2;
		$sd = $_POST['sDate'];
		if ($D == 0) {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE AddID = 0 AND datepd = '$sd'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC"; 
		} else {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE NOT AddID = 0 AND datepd = '$sd'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC";
		};
	// 7) d-f, s-f, sd-nf
	} else if (($_POST['delivery'] != 2) && ($_POST['status'] != 2) && ($_POST['sDate'] == 2)) {
		$D = $_POST['delivery'];
		$S = $_POST['status'];
		$sd = 2;
		if ($D == 0) {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE AddID = 0 AND StatusUpdate = '$S'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC"; 
		} else {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE NOT AddID = 0 AND StatusUpdate = '$S'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC";
		};
	// 8) d-f, s-f, sd-f
	} else if (($_POST['delivery'] != 2) && ($_POST['status'] != 2) && ($_POST['sDate'] != 2)) {
		$D = $_POST['delivery'];
		$S = $_POST['status'];
		$sd = $_POST['sDate'];
		if ($D == 0) {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE AddID = 0 AND StatusUpdate = '$S' AND datepd = '$sd'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC"; 
		} else {
			$q = "SELECT CustID, COUNT(ProdID) AS ProdID, AddID, Quantity, datepd, StatusUpdate, Order_Date
			FROM cust_order
			WHERE NOT AddID = 0 AND StatusUpdate = '$S' AND datepd = '$sd'
			GROUP BY CustID, Order_Date
			ORDER BY Order_Date DESC";
		};
	}
?>


<h1>Total Order</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin: 0.5em">
	<form action="orders_TotalOrder.php" id=filter method="POST">
	<label><?php sDate($dbc, $sd);?></label>
	<label><?php delivery($D);?></label>
	<label><?php status($S);?></label>
	<input type="button" onclick="location.href='orders_TotalOrder.php'" value="Clear Filter"/>
	<input type="submit" name="submit" value="Apply Filter"/>
	</form>
	</div>
	<table border="1" style="width: max-content; margin:0.5em 4em">
		<tr>
			<th>Date Ordered</th>
			<th>Customer's Name</th>
			<th>Delivery Method</th>
			<th>Due Date</th>
			<th>Current Status</th>
			<th>View Order Details</th>
		</tr>
		<?php
		$r = @mysqli_query ($dbc,$q);
		// to check what error occurs in query
		// if (!$r) {
		// 	die("Query failed: " . mysqli_error($dbc));
		// }

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="5">No order from customer</td></tr>';
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

			if(empty($data['AddID']) || $data['AddID'] == 0) {
				$DeliMeth = 'Self Pickup by Customer';
			} else {
				$DeliMeth = 'Delivery to Customer\'s Address';
			}

			echo "<tr><td>" . date("j M Y", strtotime($data['Order_Date'])) . "<br>
			" . date("h:i:sA", strtotime($data['Order_Date'])) . "</td>";
			// 12-hours format - h, 24-hours format - H
			// j M Y - short form for month | j F Y - full name for month
			// H:i:s A, j M Y - time, date | j M Y, H:i:s A - date, time
			echo '
				<td align="left">'.$dataC['CustName'].'</td>
				<td align="left">'.$DeliMeth.'</td>
				<td align="left">'.date('j M Y', strtotime($data['datepd'])).'</td>';
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
	// Function to update status/tracker
	function delivery($D) {

		$delivery = array ('2' => 'No Delivery Method Filter', '0' =>  'Self Pickup', '1' => 'Delivery');

			echo '<select name="delivery" form=filter>';
				foreach ($delivery as $key => $value) {
					echo "<option value=\"$key\""; 
					if ($D ==  $key) {echo " selected";} 
					echo ">$value</option>\n";
				}
			echo '</select>';
	}

	function status($S) {

		$status = array ('2' => 'No Current Status Filter', 'Order Received, Pending Verification' => 'Order Received, Pending Verification', 'Order Received, Verified' =>  'Order Received, Verified', 'Order Rejected' =>  'Order Rejected', 'Order In Progress' =>  'Order In Progress', 'Order Ready for Pickup/Delivery' =>  'Order Ready for pickup/delivery', 'Order Collected/Retrieved' =>  'Order Collected/Retrieved');

			echo '<select name="status" form=filter>';
				foreach ($status as $key => $value) {
					echo "<option value=\"$key\""; 
					if ($S ==  $key) {echo " selected";} 
					echo ">$value</option>\n";
				}
			echo '</select>';
	}

	function sDate($dbc, $sd) {
		$q = "SELECT datepd
		FROM cust_order 
		GROUP BY datepd DESC
		";
		$r = @mysqli_query ($dbc,$q);

		if ($r) {
			echo '<select name="sDate" form=filter>';
			echo "<option value=\"2\">No Date Filter</option>\n";
				foreach ($r as $value) {
					echo "<option value=\"$value[datepd]\"";
					if ($sd ==  $value['datepd']) {echo " selected";} echo '>';	
					echo date('j M Y', strtotime($value['datepd']));
					echo "</option>\n";
				}
			echo '</select>';
		} else {
			// Handle error
			echo 'Error fetching filter(s).';
		}
	}


include ('includes/footer.html');

?>