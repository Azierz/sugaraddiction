<?php
$page_title = 'Customer List';
$page_text = 'Customer List';
include ('includes/header2.php');
require ('includes/constants.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}

// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$errors = array(); // Initialize an error array.
		
		$custid = $_POST['CustID'];
		$addid = trim($_POST['AddID']);
		$ad = $_POST['address'];
	
		if (empty($errors)) { // If everything's OK. ($fn && $ln && $e)

			$q = "UPDATE address SET Address='$ad' WHERE Cust_ID='$custid' AND Address_ID='$addid'";
			$r = @mysqli_query ($dbc, $q);

			// // Take Cust ID to insert in Address & Save Address in different table
			// if ($r) {
			// 	$CID = mysqli_insert_id($dbc);
			// 	$qA = "INSERT INTO address VALUES (0, '$CID', '$ad')";
			// 	$rA = mysqli_query ($dbc, $qA); // Run the query.
	
			// }
	
			if ($r) { // If it ran OK.
	
				// Print a message:
				echo '<h1>Thank you!</h1>
			<p>The customer address are now updated.</p>';
	
			} else { // If it did not run OK.
	
				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">The customer address could not be updated due to a system error. Please try again later.</p>';
	
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
			} // End of if ($r) IF.
	
			mysqli_close($dbc); // Close the database connection.
	
			// Include the footer and quit the script:
			include ('includes/footer.html');
			exit();
	
			 // End of register user into db
		}  // End of if (empty($errors)) IF.
			if ($errors) { // Report the errors.
			echo '<h1>Error!</h1>
			<div id = "errors">The following error(s) occurred:<br />';
			foreach ($errors as $msg) { // Print each error.
				echo " - $msg<br />\n";
			}
			echo '</div>
			<div id = "errors">Please try again.</div> <p><br /></p>';
	
		}
	
	} // End of the main Submit conditional.
?>



<h1><?php echo $_GET['CustName']?>'s Address List</h1>

<div class="menu">
	
	<table border="1">
	
		<tr>
			<th>No</th>
			<th colspan="3">Address</th>
			<th>Action(s)</th>
		</tr>
		<?php

		$CustID = $_GET['CustID'];

		$q = "SELECT * FROM address WHERE Cust_ID = '$CustID' ORDER BY Address_ID ASC";
		$r = @mysqli_query ($dbc,$q);
		$no = 1;
		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No registered address</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {
			echo '<form action="customers_address.php" method="POST">
			<tr>
				<td align="left">'.$no.'</td>
				<td align="left" colspan="3" style="text-align: left;">
				<input type="text" name="address" value="'.$data["Address"].'"></td>';
			echo '<td align="left">
				<input type="text" name="CustID" value="'.$data["Cust_ID"].'" hidden>
				<input type="text" name="AddID" value="'.$data["Address_ID"].'" hidden>
				<input type="submit" name="submit" value="Update" />
				</form>
				<form action="delete_customer.php" method="GET">
				<input type="text" name="CustID" value="'.$data["Cust_ID"].'" hidden>
				<input type="submit" name="submit" value="Delete" />
				</form>
				</td>';
			echo'</tr>';
			$no++;
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
