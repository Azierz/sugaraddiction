<?php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Customer List';
$page_text = 'Customer List';
include ('includes/header2.php');
require ('includes/constants.php'); // Connect to the db.

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
	
	$custid = $_POST['cid'];
	$n = trim($_POST['name']);
	$p = trim($_POST['pass1']);
	$pn = trim($_POST['phone_no']);
	$dob = trim($_POST['dob']);
	// $ad = trim($_POST['address']);
	$e = trim($_POST['email']);

	if (empty($errors)) { // If everything's OK. ($fn && $ln && $e)

		

		//  Test for unique email address
		$q1 = "SELECT CustID, email FROM customer WHERE email='$e'";
		$r1 = @mysqli_query($dbc, $q1);

	if (mysqli_num_rows($r1) > 0) { // Check for unique email address
		$data = mysqli_fetch_array($r1);
		// $dbcustid = $data['CustID']
		if ($custid != $data['CustID']) {
			$errors[] = "Email Address already exists.";
		} else { // Register the user in the database...

			$q = "UPDATE customer SET CustName='$n', Password=SHA1('$p'), PhoneNum='$pn', dateofbirth='$dob', Email='$e' WHERE CustID='$custid' LIMIT 1";
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
		<p>The customer details are now updated.</p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">The customer details could not be updated due to a system error. Please try again later.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html');
		exit();

		}} // End of register user into db
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

// if get id is set
if (isset($_GET['CustID'])) {
	$cid = $_GET['CustID'];
// if post id is set
} elseif (isset($_POST['cid'])) {
	$cid = $_POST['cid'];
}
$q = "SELECT * FROM customer WHERE CustID = '$cid'";
$r = @mysqli_query ($dbc,$q);

if (!mysqli_num_rows($r) == 1) {
	echo '<tr><td colspan="4">No registered customers</td></tr>';
} else {
while ($data = mysqli_fetch_array($r)) {
?>
<h1>Customer's Details</h1>
<form action="edit_customers.php" method="post">
	<table border="0" id="reg">
		<tr><input type="text" name="cid" size="15" maxlength="20" value="<?php if (isset($_POST['cid'])) {echo $_POST['cid'];} else {echo $data["CustID"];} ?>" hidden />
			<td>Full Name:</td>
			<td><input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $data["CustName"];} ?>" required /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) {echo $_POST['pass1'];} ?>" required /></td>
		</tr>
		<tr>
			<td>Phone Number:</td>
			<td><input type="text" name="phone_no" size="20" maxlength="40" value= "<?php if (isset($_POST['phone_no'])) {echo $_POST['phone_no'];} else {echo $data["PhoneNum"];} ?>" required /></td>
		</tr>
		<tr>
			<td>Date of Birth:</td>
			<td><input type="date" id="dob" name="dob" value="<?php if (isset($_POST['dob'])) {echo $_POST['dob'];} else {echo $data["dateofbirth"];} ?>" required /></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) {echo $_POST['email'];} else {echo $data["Email"];} ?>" required /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
</form>

<?php }} include ('includes/footer.html'); ?>
