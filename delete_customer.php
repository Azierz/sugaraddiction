<?php
$page_title = 'Customer Details Deletion';
$page_text = 'Customer Details Deletion';
include ('includes/header2.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if($_POST['con_del'] == "yes") {

		$DelID = $_POST['delete'];

		require ('includes/constants.php');

		$q = "DELETE FROM customer WHERE CustID='$DelID' LIMIT 1";
		$r = @mysqli_query ($dbc,$q);

		if (mysqli_affected_rows($dbc) == 1) {
			echo '<script>
			window.alert("\nSUCCESS!\nCustomer Details has been deleted.");
			setTimeout(function(){location.href="customers.php"},0);
			</script>';
		} else {
			echo '<script>
			window.alert("\ERROR!\nCustomer Details cannot not be deleted.\nPlease try again later.");
			setTimeout(function(){location.href="customers.php"},0);
			</script>';
		}

	} else {
		echo '<script>
		window.alert("\CONFIRMED!\nCustomer Details will not be deleted.");
		setTimeout(function(){location.href="customers.php"},0);
		</script>';
	}
	
	
}
?>

<h1>Customer Details Deletion</h1>

<div class="menudetails">
	<div class="row">
	  	<div class="column">
		<table>
			<?php
			require ('includes/constants.php');

			$CustID = $_GET["CustID"];
			
			$q = "SELECT * FROM customer WHERE CustID='$CustID'";
			$r = @mysqli_query ($dbc,$q);
			// select all from address where custID=custID
			$q2 = "SELECT * FROM address WHERE Cust_ID='$CustID'";
			$r2 = @mysqli_query ($dbc,$q2);
			$data2 = mysqli_fetch_array($r2);
			
			if (!mysqli_num_rows($r) == 1) {
				echo '<tr><td colspan="3">NO REGISTERED CUSTOMER</td></tr>';
			} else {
			while ($data = mysqli_fetch_array($r)) {
				echo '
				<tr>
					<td><b>Customer ID</b></td>
					<td>'.$data["CustID"].'</td>
					</tr>
					<tr>
					<td><b>Customer Name</b></td>
					<td>'.$data["CustName"].'</td>
					</tr>
					<tr>
					<td><b>Customer Phone</b></td>
					<td>'.$data["PhoneNum"].'</td>
					</tr>
					<tr>
					<td><b>Customer Email</b></td>
					<td>'.$data["Email"].'</td>
					</tr>
					<tr>
					<td><b>Customer Date</b></td>
					<td>'.$data["dateofbirth"].'</td>
					</tr>
					
						<tr>
							<td colspan="2">
							<form action="delete_customer.php" method="POST">
								<p> Confirm delete this product? </p>
								<input type="radio" name="con_del" value="yes"> Yes
								<input type="radio" name="con_del" value="no"> No
								<input type="text" name="delete" value="'.$data["CustID"].'" hidden>
								<input type="submit" name="submit" value="Confirm" />
							</form>
							</td>
						</tr>
					</table>
					</div>';
			}}
			?>
	</div>
</div>
<?php
include ('includes/footer.html');
?>
